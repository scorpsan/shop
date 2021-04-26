<?php
namespace frontend\controllers\user;

use frontend\controllers\AppController;
use frontend\models\ShopOrders;
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
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
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

}