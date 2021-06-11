<?php
namespace backend\controllers\shop;

use backend\controllers\AppController;
use backend\models\ShopOrders;
use backend\models\ShopOrdersSearch;
use Da\User\Filter\AccessRuleFilter;
use Yii;
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
                        'actions' => ['index'],
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

    public function actionUpdate($id)
    {
        if (!$model = ShopOrders::find()->where(['id' => $id])->with('items')->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        return $this->render('update', [
            'order' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = ShopOrders::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

}