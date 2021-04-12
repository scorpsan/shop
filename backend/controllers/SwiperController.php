<?php
namespace backend\controllers;

use backend\models\Swiper;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class SwiperController extends AppController
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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['viewPages'],
                    ],
                    [
                        'actions' => ['create', 'update', 'publish', 'unpublish'],
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
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Swiper::find()->with('slides'),
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        if (!$model = Swiper::find()->where(['id' => $id])->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Swiper([
            'published' => true,
            'player' => false,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = Swiper::find()->where(['id' => $id])->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPublish($id)
    {
        if (Yii::$app->request->isAjax) {
            Swiper::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnpublish($id) {
        if (Yii::$app->request->isAjax) {
            Swiper::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id) {
        if (!$model = Swiper::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

}