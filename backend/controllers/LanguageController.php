<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LanguageController extends AppController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewSettings'],
                    ],
                    [
                        'actions' => ['create', 'update', 'publish', 'unpublish'],
                        'allow' => true,
                        'roles' => ['editSettings'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteSettings'],
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
            'query' => Language::find(),
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Language();
        $model->published = true;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->default) {
                $model->published = true;
                Language::updateAll(['default' => 0]);
            }
            if ($model->save())
                return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        if (($model = Language::findOne($id)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->default) {
                    $model->published = true;
                    Language::updateAll(['default' => 0]);
                }
                if ($model->save())
                    return $this->redirect(['index']);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionPublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            Language::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUnpublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            Language::updateAll(['published' => 0], ['id' => $id, 'default' => false]);
            return true;
        }
        return false;
    }

    public function actionDelete($id) {
        if (($model = Language::findOne($id)) !== null) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

}