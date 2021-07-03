<?php
namespace frontend\controllers\user;

use frontend\controllers\AppController;
use frontend\controllers\CheckoutController;
use frontend\models\ShopOrders;
use frontend\models\ShopOrdersStatuses;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use frontend\models\ProfileAddress;
use frontend\forms\DeleteForm;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OrdersController extends AppController
{
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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'pay', 'cancel', 'received', 'pay-return', 'pay-cancel', 'pay-notify', 'notification'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'notification' || $action->id == 'pay-notify') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
	{
        Yii::$app->user->setReturnUrl(['/user/orders/index']);

        $orders = ShopOrders::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['updated_at' => SORT_DESC])->all();

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }

    public function actionView($number, $token = null)
	{
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        //$order = $this->orderByNumber($number);

	    if ($token)
            $order = ShopOrders::find()->where(['order_number' => $number, 'token' => $token])->with('items')->with('deliveryStatus')->with('paymentStatus')->limit(1)->one();
        else
            $order = ShopOrders::find()->where(['order_number' => $number, 'user_id' => Yii::$app->user->id])->with('items')->with('deliveryStatus')->with('paymentStatus')->limit(1)->one();

        if (!$order)
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));

        if ($token)
            Yii::$app->user->setReturnUrl(['/user/orders/view', 'number' => $number, 'token' => $token]);
        else
            Yii::$app->user->setReturnUrl(['/user/orders/view', 'number' => $number]);

        return $this->render('view', [
			'order' => $order,
        ]);
    }

    public function actionPay($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        // Вызываем оплату
        self::payOrder($order, $order->paymentMethod->className);

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        return $this->redirect(['view', 'number' => $order->order_number, 'token' => $order->token]);
    }

    public static function payOrder($order, $payClass)
    {
        if ($payClass) {
            if ($order->payment_token) {
                $response = $payClass::payNow($order->payment_token);
                if (isset($response['redirect_url'])) {
                    header('Location: ' . $response['redirect_url']);
                    die();
                }
            }

            $response = $payClass::pay($order->order_number, $order->amount, $order->currency, [
                'return_url' => Url::to(['/user/orders/pay-return', 'number' => $order->order_number], true),
                'cancel_url' => Url::to(['/user/orders/pay-cancel', 'number' => $order->order_number], true),
                'notification_url' => Url::to(['/user/orders/notification', 'number' => $order->order_number], true),
            ]);

            if (isset($response['redirect_url'])) {
                if (isset($response['payment_token'])) {
                    $order->payment_token = $response['payment_token'];
                    $order->save();
                }

                header('Location: ' . $response['redirect_url']);
                die();
            } elseif (isset($response['message'])) {
                Yii::$app->getSession()->setFlash('error', 'Failed: Pay Gateway Error - ' . $response['message']);
                Yii::debug('Failed: Pay Gateway Error - ' . $response['message']);
            }
        }
    }

    public function actionCancel($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_PAYMENT, ShopOrdersStatuses::ORDER_CANCEL);

        ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_DELIVERY, ShopOrdersStatuses::ORDER_CANCEL);

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
        ];
    }

    public function actionReceived($number, $token = null)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_DELIVERY, ShopOrdersStatuses::DELIVERY_DELIVER);

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
        ];
    }

    public function actionPayReturn($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        if ($order->canPay) {
            $payClass = $order->paymentMethod->className;
            $status = $payClass::success(Yii::$app->request->get());
            if (isset($status['status'])) {
                if ($status['status'])
                    ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_PAYMENT, $status['status']);
                Yii::$app->getSession()->setFlash($status['type'], $status['message']);
            }
        }

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        return $this->redirect(['view', 'number' => $order->order_number, 'token' => $order->token]);
    }

    public function actionPayCancel($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        Yii::$app->getSession()->setFlash('error', Yii::t('frontend', 'Payment canceled'));

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        return $this->redirect(['view', 'number' => $order->order_number, 'token' => $order->token]);
    }

    public function actionPayNotify($number)
    {
        if (!Yii::$app->request->isPost) {
            return false;
        }

        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        $response = json_decode(Yii::$app->request->getRawBody());

        Yii::info(print_r($response, true));

        if ($order->canPay) {
            $payClass = $order->paymentMethod->className;
            if ($status = $payClass::notify($response)) {
                ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_PAYMENT, $status);
            } else {
                return false;
            }
        }

        //header("HTTP/1.1 200 OK");
        return true;
    }

    public function actionNotification($number)
    {
        if (!Yii::$app->request->isPost) {
            return false;
        }

        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        $order = $this->orderByNumber($number);

        $response = json_decode(Yii::$app->request->getRawBody());

        Yii::info(print_r($response, true));

        if ($order->canPay) {
            $payClass = $order->paymentMethod->className;
            if ($status = $payClass::notify($response)) {
                ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_PAYMENT, $status);
            } else {
                return false;
            }
        }

        //header("HTTP/1.1 200 OK");
        return true;
    }

    /**
     * @throws NotFoundHttpException
     */
    private function orderByNumber($number)
    {
        if (!$order = ShopOrders::find()->where(['order_number' => $number])->with('deliveryStatus')->with('paymentStatus')->limit(1)->one())
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));

        return $order;
    }

}