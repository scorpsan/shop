<?php
namespace frontend\controllers\user;

use frontend\controllers\AppController;
use frontend\models\ShopOrders;
use frontend\models\ShopOrdersStatuses;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use frontend\models\ProfileAddress;
use frontend\forms\DeleteForm;
use Yii;
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
                        'actions' => ['index', 'cancel', 'received'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'success'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
	{
        $orders = ShopOrders::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }

    public function actionView($number, $token = null)
	{
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

	    if ($token)
            $order = ShopOrders::find()->where(['order_number' => $number, 'token' => $token])->with('items')->limit(1)->one();
        else
            $order = ShopOrders::find()->where(['order_number' => $number, 'user_id' => Yii::$app->user->id])->with('items')->limit(1)->one();

        if (!$order)
            throw new BadRequestHttpException(Yii::t('error', 'error404 message'));

        return $this->render('view', [
			'order' => $order,
        ]);
    }

    public function actionCancel($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        if (!$order = ShopOrders::find()->where(['order_number' => $number, 'user_id' => Yii::$app->user->id])->with('deliveryStatus')->with('paymentStatus')->limit(1)->one())
            throw new BadRequestHttpException(Yii::t('error', 'error404 message'));

        $paymentStatus = new ShopOrdersStatuses([
            'order_id' => $order->id,
            'type' => ShopOrdersStatuses::STATUS_TYPE_PAYMENT,
            'status' => ShopOrdersStatuses::ORDER_CANCEL,
        ]);
        $paymentStatus->save();

        $deliveryStatus = new ShopOrdersStatuses([
            'order_id' => $order->id,
            'type' => ShopOrdersStatuses::STATUS_TYPE_DELIVERY,
            'status' => ShopOrdersStatuses::ORDER_CANCEL,
        ]);
        $deliveryStatus->save();

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
        ];
    }

    public function actionReceived($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        if (!$order = ShopOrders::find()->where(['order_number' => $number, 'user_id' => Yii::$app->user->id])->with('deliveryStatus')->with('paymentStatus')->limit(1)->one())
            throw new BadRequestHttpException(Yii::t('error', 'error404 message'));

        $deliveryStatus = new ShopOrdersStatuses([
            'order_id' => $order->id,
            'type' => ShopOrdersStatuses::STATUS_TYPE_DELIVERY,
            'status' => ShopOrdersStatuses::DELIVERY_DELIVER,
        ]);
        $deliveryStatus->save();

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
        ];
    }

    public function actionSuccess($number)
    {
        if (!$number) {
            throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
        }

        if (!$order = ShopOrders::find()->where(['order_number' => $number])->with('paymentStatus')->limit(1)->one())
            throw new BadRequestHttpException(Yii::t('error', 'error404 message'));

        if ($payClass = $order->paymentMethod->className) {
            if ($order->order_id = $payClass::success()) {
                $order->save();


            }
        }
    }

}