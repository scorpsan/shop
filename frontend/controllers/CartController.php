<?php
namespace frontend\controllers;

use frontend\models\UserWishlistItems;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use frontend\models\ShopProducts;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Exception;

/**
 * @property-read null|ShopProducts[] $sessionList
 */
class CartController extends AppController
{
    public $_session;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
                'only' => ['to-wish'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['to-wish'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->_session = Yii::$app->session;
        $this->_session->open();

        Yii::$app->layout = 'page';
        $this->headerClass = 'header-v2 header-absolute';
    }

    public function beforeAction($action): bool
    {
        if ($action->id == 'order-notify') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function actionIndex()
    {
        $this->setMeta(Yii::$app->name . ' | ' . Yii::t('frontend', 'Your Shopping Cart'), '', '');

        if (!Yii::$app->request->isAjax) {
            return $this->render('index', [
                'productList' => $this->getSessionList(),
                'cartList' => ArrayHelper::getValue($this->_session, 'cart'),
                'cartQty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
            ]);
        }
        return $this->renderAjax('index', [
            'productList' => $this->getSessionList(),
            'cartList' => ArrayHelper::getValue($this->_session, 'cart'),
            'cartQty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ]);
    }

    public function actionMiniCart()
    {
        return $this->renderPartial('mini-cart', [
            'productList' => $this->getSessionList(),
            'cartList' => ArrayHelper::getValue($this->_session, 'cart'),
            'cartQty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ]);
    }

    /**
     * @return ShopProducts[]
     * @throws Exception
     */
    protected function getSessionList(): array
    {
        if (!$cart = ArrayHelper::getValue($this->_session, 'cart')) {
            $cartIds = [];
        } else {
            $cartIds = array_column($cart, 'id');
        }
        return ShopProducts::ProductsInCart($cartIds);
    }

    public function actionAdd()
    {
        $data = Yii::$app->request->post();
        if (!$product = ShopProducts::find()->where(['id' => $data['id']])->one()) {
            return [
                'error' => true,
                'message' => Yii::t('frontend', 'Error adding to cart! Product not found.'),
            ];
        }
        $qty = ArrayHelper::getValue($data, 'qty', 1);

        $this->ItemToCart($data['id'], $qty);

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'name' => $product->title,
            'image' => $product->smallImageMain,
            'message' => Yii::t('frontend', 'Successfully added to cart!'),
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionDelete()
    {
        $data = Yii::$app->request->post();

        $this->ItemToCart($data['id'], 0);

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionMinus()
    {
        $data = Yii::$app->request->post();

        $this->ItemToCart($data['id'], -1);

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionPlus()
    {
        $data = Yii::$app->request->post();

        $this->ItemToCart($data['id'], 1);

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionUpdate()
    {
        $data = Yii::$app->request->post('update');

        foreach ($data as $item) {
            $this->ItemToCart($item['id'], $item['qty'], true);
        }

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionClear()
    {
        $this->_session->remove('cart');
        $this->_session->remove('cart.qty');

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionToWish()
    {
        $data = Yii::$app->request->post();
        if (!$product = ShopProducts::find()->where(['id' => $data['id']])->one()) {
            return [
                'error' => true,
                'message' => Yii::t('frontend', 'Add to Wishlist failed! Product not found.'),
            ];
        }

        if (!$wish = UserWishlistItems::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => $data['id']])->one()) {
            $newwish = new UserWishlistItems([
                'user_id' => Yii::$app->user->id,
                'product_id' => $data['id'],
            ]);
            $newwish->save();
            $message = Yii::t('frontend', 'Successfully added to Wishlist!');
        } else {
            $message = Yii::t('frontend', 'This Product is already on the Wishlist!');
        }

        $this->ItemToCart($data['id'], 0);

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'name' => $product->title,
            'image' => $product->smallImageMain,
            'message' => $message,
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public static function ItemToCart($id, $qty, $update = false): bool
    {
        $session = Yii::$app->session;

        $cart = $session['cart'];
        $changeQty = 0;

        if (isset($cart[$id])) {
            if ($qty != 0) {
                if ($update) {
                    $changeQty = $qty - $cart[$id]['qty'];
                    $cart[$id]['qty'] = $qty;
                } else {
                    $changeQty = $qty;
                    $cart[$id]['qty'] += $qty;
                }
            } else {
                $changeQty = -1 * $cart[$id]['qty'];
                $cart[$id]['qty'] = 0;
            }
            
            if ($cart[$id]['qty'] == 0)
                unset($cart[$id]);
        } elseif($qty > 0) {
            $cart[$id] = [
                'id' => $id,
                'qty' => $qty,
            ];
            $changeQty = $qty;
        }

        $session['cart'] = $cart;
        $session['cart.qty'] = $session['cart.qty'] + $changeQty;

        return true;
    }

}