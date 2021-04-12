<?php
namespace frontend\controllers;

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
    public function init()
    {
        parent::init();
        $this->_session = Yii::$app->session;
        $this->_session->open();
    }

    public function beforeAction($action)
    {
        Yii::$app->layout = 'page';
        $this->headerClass = 'header-v2 header-absolute';
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
     * @return ShopProducts[]|null
     */
    protected function getSessionList()
    {
        if (empty($this->_session['cart'])) {
            return null;
        }

        $sessionList = ShopProducts::find()->where(['published' => true])
            ->andWhere(['in', 'id', array_column($this->_session['cart'], 'id')])
            ->with('translate')
            ->with('images')
            ->with('category')
            ->indexBy('id')->all();

        return $sessionList;
    }

    public function actionAdd()
    {
        $data = Yii::$app->request->post();
        if (!$product = ShopProducts::find()->where(['id' => $data['id']])->one()) {
            return [
                'error' => true,
                'message' => 'Ошибка добавления в корзину! Товар не найден.',
            ];
        }
        $qty = ArrayHelper::getValue($data, 'qty', 1);

        $cart = $this->_session['cart'];

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['qty'] += $qty;
        } else {
            $cart[$data['id']] = [
                'id' => $data['id'],
                'qty' => $qty,
            ];
        }
        $this->_session['cart'] = $cart;
        //$this->_session['cart.qty'] = isset($this->_session['cart.qty']) ? $this->_session['cart.qty'] + $qty : $qty;
        $this->_session['cart.qty'] = $this->_session['cart.qty'] + $qty;

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'name' => $product->title,
            'image' => $product->smallImageMain,
            'message' => 'Успешно добавлен в корзину!',
            'qty' => ArrayHelper::getValue($this->_session, 'cart.qty', 0),
        ];
    }

    public function actionDelete()
    {
        $data = Yii::$app->request->post();

        $cart = $this->_session['cart'];

        $qty = ArrayHelper::getValue($cart[$data['id']], 'qty', 0);
        if (isset($cart[$data['id']])) {
            unset($cart[$data['id']]);
        }
        $this->_session['cart'] = $cart;
        $this->_session['cart.qty'] = $this->_session['cart.qty'] - $qty;

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

        $cart = $this->_session['cart'];

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['qty'] -= 1;
            if ($cart[$data['id']]['qty'] == 0)
                unset($cart[$data['id']]);

            $this->_session['cart'] = $cart;
            $this->_session['cart.qty'] = $this->_session['cart.qty'] - 1;
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

    public function actionPlus()
    {
        $data = Yii::$app->request->post();

        $cart = $this->_session['cart'];

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['qty'] += 1;

            $this->_session['cart'] = $cart;
            $this->_session['cart.qty'] = $this->_session['cart.qty'] + 1;
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

    public function actionUpdate()
    {
        $data = Yii::$app->request->post('update');

        $cart = $this->_session['cart'];
        $qty = 0;

        foreach ($data as $item) {
            if (isset($cart[$item['id']])) {
                if ($item['qty'] > 0) {
                    $cart[$item['id']]['qty'] = $item['qty'];
                    $qty += $item['qty'];
                } else {
                    unset($cart[$item['id']]);
                }
            }
        }
        $this->_session['cart'] = $cart;
        $this->_session['cart.qty'] = $qty;

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

}