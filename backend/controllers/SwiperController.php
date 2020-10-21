<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\base\Model;
use backend\models\Swiper;
use backend\models\SwiperSlides;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SwiperController extends AppController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Swiper::find()->with('slides'),
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = Swiper::find()->where(['id' => $id])->limit(1)->one();
        if ($model !== null) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    public function actionCreate() {
        $model = new Swiper();
        $model->published = true;
        $model->player = false;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = Swiper::find()->where(['id' => $id])->limit(1)->one();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            Swiper::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUnpublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            Swiper::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionDelete($id) {
        if (($model = Swiper::findOne($id)) !== null) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

}