<?php
namespace backend\controllers;

use backend\models\Queue;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use Yii;
use DomainException;

class JobsController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
	{
        $dataProvider = new ActiveDataProvider([
            'query' => Queue::find()->orderBy(['attempt' => SORT_DESC]),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
	{
        if (($model = Queue::findOne($id)) !== null) {
            try {
                $model->delete();
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['index']);
    }

}