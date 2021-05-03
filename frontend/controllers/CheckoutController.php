<?php
namespace frontend\controllers;

use common\models\Country;
use frontend\forms\CheckoutForm;
use frontend\models\ProfileAddress;
use frontend\models\ShopDelivery;
use frontend\models\ShopOrders;
use frontend\models\ShopOrdersItems;
use frontend\models\ShopOrdersStatuses;
use frontend\models\ShopPayment;
use frontend\models\ShopProducts;
use Yii;
use Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @property-read float $weight
 * @property-read float $subtotal
 * @property-read float $total
 * @property-read array|ShopProducts[] $sessionList
 */
class CheckoutController extends AppController
{
    public $_session;
    private $cartList;
    private $productList;
    private $canCheckout = true;
    private $weight;
    private $subtotal;
    private $total;
    private $formInfo;
    private $shipMethod = null;
    private $payMethod = null;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->_session = Yii::$app->session;
        $this->_session->open();

        Yii::$app->layout = 'checkouts';
        $this->setMeta(Yii::$app->name . ' | ' . Yii::t('frontend', 'Checkout'), '', '');

        $this->cartList = ArrayHelper::getValue($this->_session, 'cart');
        if (!empty($this->cartList)) {
            $this->formInfo = new CheckoutForm([
                'country' => Yii::$app->params['userCountry'],
                'shipping_method' => 0,
                'payment_method' => 0,
            ]);
            if (!Yii::$app->user->isGuest) {
                $user = Yii::$app->user->identity;
                $this->formInfo->email = $user->email;
                $this->formInfo->phone = $user->phone;
                $this->formInfo->name = $user->profile->name;
                $this->formInfo->user_address = $user->addresses[0]->id;
            }
            if (isset($this->_session['checkInfo'])) {
                $this->formInfo->setAttributes($this->_session['checkInfo']);
                if ($this->formInfo->shipping_method) {
                    $this->shipMethod = ShopDelivery::find()->where(['id' => $this->formInfo->shipping_method])->with('translate')->one();
                }
                if ($this->formInfo->payment_method) {
                    $this->payMethod = ShopPayment::find()->where(['id' => $this->formInfo->payment_method])->with('translate')->one();
                }
            }
            $this->productList = $this->getSessionList();
            $this->weight = $this->getWeight();
            $this->subtotal = $this->getSubtotal();
            $this->total = $this->getTotal();
        }
    }

    public function actionIndex()
    {
        $this->redirect(['information']);
    }

    public function actionInformation()
    {
        if (empty($this->cartList) || !$this->canCheckout) {
            return $this->redirect(['/cart/index']);
        }

        Yii::$app->user->setReturnUrl(['checkout/information']);

        if ($this->formInfo->load(Yii::$app->request->post()) && $this->formInfo->validate()) {
            if (!$this->formInfo->user_address && $this->formInfo->remember_me && !Yii::$app->user->isGuest) {
                $address = new ProfileAddress([
                    'user_id' => Yii::$app->user->id,
                    'title' => Yii::t('frontend', 'Address') . ' ' . (count(Yii::$app->user->identity->addresses) + 1),
                    'country' => ($this->formInfo->country) ? $this->formInfo->country : null,
                    'region' => ($this->formInfo->region) ? $this->formInfo->region : null,
                    'district' => ($this->formInfo->district) ? $this->formInfo->district : null,
                    'city' => ($this->formInfo->city) ? $this->formInfo->city : null,
                    'address' => ($this->formInfo->address) ? $this->formInfo->address : null,
                    'address2' => ($this->formInfo->address2) ? $this->formInfo->address2 : null,
                    'postal' => ($this->formInfo->postal) ? $this->formInfo->postal : null,
                ]);
                if ($address->save()) {
                    $this->formInfo->user_address = $address->id;
                    $this->formInfo->remember_me = null;
                }
            }
            $this->_session['checkInfo'] = $this->formInfo->toArray();
            return $this->redirect(['shipping']);
        }

        return $this->render('information', [
            'productList' => $this->productList,
            'cartList' => $this->cartList,
            'formInfo' => $this->formInfo,
            'shipMethod' => $this->shipMethod,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);
    }

    public function actionShipping()
    {
        if (empty($this->cartList) || !$this->canCheckout) {
            return $this->redirect(['/cart/index']);
        }

        if (!$this->formInfo->name || !$this->formInfo->email || !$this->formInfo->address) {
            return $this->redirect(['information']);
        }

        $this->formInfo->setScenario('shipping');

        if ($this->formInfo->load(Yii::$app->request->post()) && $this->formInfo->validate()) {
            $this->_session['checkInfo'] = $this->formInfo->toArray();
            return $this->redirect(['payment']);
        }

        $shippingList = ShopDelivery::find()->where(['published' => true])
            ->andOnCondition(['or', ['or', ['max_weight' => null], ['max_weight' => 0]], ['and', ['>', 'max_weight', 0], ['>=', 'max_weight', $this->weight]]])
            ->andOnCondition(['or', ['or', ['min_summa' => null], ['min_summa' => 0]], ['and', ['>', 'min_summa', 0], ['<', 'min_summa', $this->subtotal]]])
            ->andOnCondition(['or', ['or', ['max_summa' => null], ['max_summa' => 0]], ['and', ['>', 'max_summa', 0], ['>=', 'max_summa', $this->subtotal]]])
            ->orderBy(['sort' => SORT_ASC])->all();

        return $this->render('shipping', [
            'productList' => $this->productList,
            'cartList' => $this->cartList,
            'formInfo' => $this->formInfo,
            'shipMethod' => $this->shipMethod,
            'shippingList' => $shippingList,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);
    }

    public function actionPayment()
    {
        if (empty($this->cartList) || !$this->canCheckout) {
            return $this->redirect(['/cart/index']);
        }

        if (!$this->formInfo->name || !$this->formInfo->email || !$this->formInfo->address) {
            return $this->redirect(['information']);
        }

        if (!$this->formInfo->shipping_method) {
            return $this->redirect(['shipping']);
        }

        $this->formInfo->setScenario('payment');

        if ($this->formInfo->load(Yii::$app->request->post()) && $this->formInfo->validate()) {
            $this->_session['checkInfo'] = $this->formInfo->toArray();
            if (!$this->formInfo->payment_method) {
                return $this->refresh();
            }
            return $this->redirect(['order']);
        }

        return $this->render('payment', [
            'productList' => $this->productList,
            'cartList' => $this->cartList,
            'formInfo' => $this->formInfo,
            'shipMethod' => $this->shipMethod,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);
    }

    public function actionOrder()
    {
        if (empty($this->cartList) || !$this->canCheckout) {
            return $this->redirect(['/cart/index']);
        }

        $this->formInfo->setScenario('order');

        if (!$this->formInfo->validate()) {
            return $this->redirect(['information']);
        }

        $order = new ShopOrders([
            'order_number' => 'BK' . time(),
            'user_id' => (!Yii::$app->user->isGuest) ? Yii::$app->user->id : null,
            'delivery_method_id' => $this->shipMethod->id,
            'delivery_method_name' => $this->shipMethod->title,
            'delivery_cost' => $this->shipMethod->cost,
            'payment_method_id' => $this->payMethod->id,
            'payment_method_name' => $this->payMethod->title,
            'amount' => $this->total,
            'currency' => Yii::$app->formatter->currencyCode,
            'note' => $this->formInfo->note,
            'cancel_reason' => null,
            'customer_email' => $this->formInfo->email,
            'customer_phone' => $this->formInfo->phone,
            'customer_name' => $this->formInfo->name,
            'delivery_postal' => $this->formInfo->postal,
            'delivery_address' => implode(", ", array_diff([
                    Country::getCountryName($this->formInfo->country),
                    $this->formInfo->region,
                    $this->formInfo->district,
                    $this->formInfo->city,
                    $this->formInfo->address,
                    $this->formInfo->address2,
                ], array('', NULL, false))),
        ]);
        if ($order->save()) {
            foreach ($this->cartList as $key => $prod) {
                $price = (($this->productList[$key]->sale) ? $this->productList[$key]->sale : $this->productList[$key]->price);

                $orderItem = new ShopOrdersItems([
                    'order_id' => $order->id,
                    'product_id' => $key,
                    'product_name' => $this->productList[$key]->title,
                    'product_code' => $this->productList[$key]->code,
                    'price' => $price,
                    'quantity' => $prod['qty'],
                ]);

                $orderItem->save();
            }

            $paymentStatus = new ShopOrdersStatuses([
                'order_id' => $order->id,
                'type' => ShopOrdersStatuses::STATUS_TYPE_PAYMENT,
                'status' => ShopOrdersStatuses::ORDER_NEW,
            ]);
            $paymentStatus->save();

            $deliveryStatus = new ShopOrdersStatuses([
                'order_id' => $order->id,
                'type' => ShopOrdersStatuses::STATUS_TYPE_DELIVERY,
                'status' => ShopOrdersStatuses::ORDER_NEW,
            ]);
            $deliveryStatus->save();

            $this->_session->remove('cart');
            $this->_session->remove('cart.qty');

            if ($this->payMethod->className) {
                $payClass = $this->payMethod->className;
                $payClass::pay($order->order_number, $order->amount, $order->currency, [
                    'return_url' => Url::to(['/orders/success', 'number' => $order->order_number], true),
                    'cancel_url' => Url::to(['/orders/cancel', 'number' => $order->order_number], true),
                    'notification_url' => Url::to(['/orders/notify', 'number' => $order->order_number], true),
                ]);
            }

            if (!Yii::$app->user->isGuest) {
                return $this->redirect(['/orders/index']);
            }
            return $this->redirect(['/orders/view', 'number' => $order->order_number, 'token' => $order->token]);

        } else {
            Yii::debug($order->getErrors());
        }

        return $this->redirect(['payment']);
    }

    /**
     * @return ShopProducts[]
     * @throws Exception
     */
    protected function getSessionList(): array
    {
        if (!$this->cartList) {
            $cartIds = [];
        } else {
            $cartIds = array_column($this->cartList, 'id');
        }
        return ShopProducts::ProductsInCart($cartIds);
    }

    protected function getWeight(): float
    {
        $weight = 0;
        foreach ($this->cartList as $key => $prod) {
            $oneWeight = (($this->productList[$key]->characteristics->weight) ? $this->productList[$key]->characteristics->weight : 0);
            $totalWeight = $prod['qty'] * $oneWeight;
            $weight += $totalWeight;
        }
        return $weight;
    }

    protected function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->cartList as $key => $prod) {
            if ($this->productList[$key]->in_stock) {
                $price = (($this->productList[$key]->sale) ? $this->productList[$key]->sale : $this->productList[$key]->price);
                $totalPrice = $prod['qty'] * $price;
                $subtotal += $totalPrice;
            } else {
                $this->canCheckout = false;
            }
        }
        return $subtotal;
    }

    protected function getTotal(): float
    {
        if (isset($this->shipMethod)) {
            return $this->subtotal + $this->shipMethod->cost;
        }
        return $this->subtotal;
    }

}