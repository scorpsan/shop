<?php
namespace frontend\controllers;

use common\models\Country;
use frontend\forms\CheckoutForm;
use frontend\models\ShopDelivery;
use frontend\models\ShopOrders;
use frontend\models\ShopOrdersItems;
use frontend\models\ShopOrdersStatuses;
use frontend\models\ShopPayment;
use frontend\models\ShopProducts;
use Yii;
use Exception;
use yii\helpers\ArrayHelper;

/**
 * @property-read float $subtotal
 * @property-read float $total
 * @property-read array|ShopProducts[] $sessionList
 */
class CheckoutController extends AppController
{
    public $_session;
    private $cartList;
    private $productList;
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
    }

    public function actionIndex()
    {
        $this->redirect(['information']);
    }

    public function actionInformation()
    {
        if (!isset($this->cartList)) {
            return $this->redirect(['/cart/index']);
        }

        Yii::$app->user->setReturnUrl(['checkout/information']);

        if ($this->formInfo->load(Yii::$app->request->post()) && $this->formInfo->validate()) {
            $this->_session['checkInfo'] = $this->formInfo->toArray();
            return $this->redirect(['shipping']);
        }

        return $this->render('information', [
            'productList' => $this->productList,
            'cartList' => $this->cartList,
            'formInfo' => $this->formInfo,
            'shipMethod' => $this->shipMethod,
            'subtotal' => $this->getSubtotal(),
            'total' => $this->getTotal(),
        ]);
    }

    public function actionShipping()
    {
        if (!isset($this->cartList)) {
            return $this->redirect(['/cart/index']);
        }

        if (!$this->formInfo->name || !$this->formInfo->email || !$this->formInfo->address) {
            return $this->redirect(['information']);
        }

        if (!$this->formInfo->shipping_method) {
            $this->formInfo->shipping_method = ShopDelivery::find()->select('id')->where(['default' => true, 'published' => true])->scalar();
        }

        $this->formInfo->setScenario('shipping');

        if ($this->formInfo->load(Yii::$app->request->post()) && $this->formInfo->validate()) {
            $this->_session['checkInfo'] = $this->formInfo->toArray();
            return $this->redirect(['payment']);
        }

        $shippingList = ShopDelivery::find()->where(['published' => true])->orderBy(['sort' => SORT_ASC])->all();

        return $this->render('shipping', [
            'productList' => $this->productList,
            'cartList' => $this->cartList,
            'formInfo' => $this->formInfo,
            'shipMethod' => $this->shipMethod,
            'shippingList' => $shippingList,
            'subtotal' => $this->getSubtotal(),
            'total' => $this->getTotal(),
        ]);
    }

    public function actionPayment()
    {
        if (!isset($this->cartList)) {
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
            'subtotal' => $this->getSubtotal(),
            'total' => $this->getTotal(),
        ]);
    }

    public function actionOrder()
    {
        if (!isset($this->cartList)) {
            return $this->redirect(['/cart/index']);
        }

        $this->formInfo->setScenario('order');

        if (!$this->formInfo->validate()) {
            return $this->redirect(['index']);
        }

        $order = new ShopOrders([
            'order_number' => 'BK' . time(),
            'user_id' => (!Yii::$app->user->isGuest) ? Yii::$app->user->id : 0,
            'delivery_method_id' => $this->shipMethod->id,
            'delivery_method_name' => $this->shipMethod->title,
            'delivery_cost' => $this->shipMethod->cost,
            'payment_method_id' => $this->payMethod->id,
            'payment_method_name' => $this->payMethod->title,
            'amount' => $this->getTotal(),
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
                'status' => 0,
            ]);
            $paymentStatus->save();

            $deliveryStatus = new ShopOrdersStatuses([
                'order_id' => $order->id,
                'type' => ShopOrdersStatuses::STATUS_TYPE_DELIVERY,
                'status' => 0,
            ]);
            $deliveryStatus->save();

            $this->_session->remove('cart');
            $this->_session->remove('cart.qty');

            if ($this->payMethod->className) {
                $payClass = $this->payMethod->className;
                $payClass::pay();
            } else {
                if (!Yii::$app->user->isGuest) {
                    return $this->redirect(['index']);
                }
                return $this->redirect(['index']);
            }
        } else {
            Yii::debug($order->getErrors());
        }

        return $this->redirect(['index']);
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

    protected function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->cartList as $key => $prod) {
            $price = (($this->productList[$key]->sale) ? $this->productList[$key]->sale : $this->productList[$key]->price);
            $totalPrice = $prod['qty'] * $price;
            $subtotal += $totalPrice;
        }
        return $subtotal;
    }

    protected function getTotal(): float
    {
        $total = $this->getSubtotal();
        if (isset($this->shipMethod)) {
            $total += $this->shipMethod->cost;
        }
        return $total;
    }

}