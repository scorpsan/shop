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
use yii\helpers\Url;
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
                    'publish' => ['POST'],
                    'unpublish' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if (in_array($action->id, ['index', 'view', 'update'], true)) {
            Url::remember('', 'actions-redirect');
        }
        return parent::beforeAction($action);
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
        if (($model = Swiper::find()->where(['id' => $id])->limit(1)->one()) !== null) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
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
        if (($model = Swiper::find()->where(['id' => $id])->limit(1)->one()) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionPublish($id) {
        Swiper::updateAll(['published' => 1], ['id' => $id]);
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        Swiper::updateAll(['published' => 0], ['id' => $id]);
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionDelete($id) {
        if (($model = Swiper::findOne($id)) !== null) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

}