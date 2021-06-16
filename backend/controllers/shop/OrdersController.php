<?php
namespace backend\controllers\shop;

use backend\controllers\AppController;
use backend\models\ShopOrders;
use backend\models\ShopOrdersSearch;
use backend\models\ShopOrdersStatuses;
use backend\models\ShopPayment;
use backend\models\ShopDelivery;
use Da\User\Filter\AccessRuleFilter;
use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['viewPages'],
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['editPages'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deletePages'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'sort-file' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ShopOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id)
    {
        if (!$order = ShopOrders::find()->where(['id' => $id])->with('items', 'deliveryStatus', 'paymentStatus')->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        $modelCn = new DynamicModel(['pay_status_new', 'del_status_new', 'tracker_new']);
        $modelCn->addRule('pay_status_new', 'integer')
            ->addRule('del_status_new', 'integer')
            ->addRule('tracker_new', 'string')
            ->addRule('tracker_new', 'trim');
        if ($modelCn->load(Yii::$app->request->post())) {
            if ($modelCn->tracker_new) {
                $order->tracker = $modelCn->tracker_new;
                $order->save();
            }
            if ($modelCn->pay_status_new != $order->paymentStatus->status) {
                ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_PAYMENT, $modelCn->pay_status_new);
            }
            if ($modelCn->del_status_new != $order->deliveryStatus->status) {
                ShopOrdersStatuses::newStatus($order->id, ShopOrdersStatuses::STATUS_TYPE_DELIVERY, $modelCn->del_status_new);
            }

            $modelCn->pay_status_new = null;
            $modelCn->del_status_new = null;
            $modelCn->tracker_new = null;
            $order = ShopOrders::find()->where(['id' => $id])->with('items', 'deliveryStatus', 'paymentStatus')->limit(1)->one();
        }

        return $this->render('view', [
            'order' => $order,
            'modelCn' => $modelCn,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$order = ShopOrders::find()->where(['id' => $id])->with('items')->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if ($order->load(Yii::$app->request->post())) {

            if(isset($order->oldAttributes['payment_method_id']) && $order->payment_method_id != $order->oldAttributes['payment_method_id']) {
                $payMethod = ShopPayment::find()->where(['id' => $order->payment_method_id])->with('translate')->one();
                $order->payment_method_name = $payMethod->title;
            }

            if(isset($order->oldAttributes['delivery_method_id']) && $order->delivery_method_id != $order->oldAttributes['delivery_method_id']) {
                $shipMethod = ShopDelivery::find()->where(['id' => $order->delivery_method_id])->with('translate')->one();
                $order->delivery_method_name = $shipMethod->title;
                $order->delivery_cost = $shipMethod->cost;
            }

            if ($order->save()) {
                return $this->redirect(['view', 'id' => $order->id]);
            }
        }

        return $this->render('update', [
            'order' => $order,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$order = ShopOrders::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $order->delete();
        }
        return $this->redirect(['index']);
    }

}