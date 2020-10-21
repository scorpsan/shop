<?php
namespace backend\controllers;

use backend\models\Categories;
use Yii;
use yii\filters\AccessControl;
use yii\base\Model;
use backend\models\Pages;
use backend\models\PagesLng;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PagesController extends AppController {

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
            'query' => Pages::find()->with('translate')->with('translates')->orderBy(['main' => SORT_DESC]),
            'sort' => false,
            'pagination' => false,
        ]);
        $languages = Language::getLanguages();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => $languages,
        ]);
    }

    public function actionView($id) {
        $model = Pages::find()->where(['id' => $id])
            ->with('category')
            ->with('translate')
            ->with('translates')
            ->limit(1)->one();
        $languages = Language::getLanguages();
        if ($model !== null) {
            return $this->render('view', [
                'model' => $model,
                'languages' => $languages,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    public function actionCreate() {
        $model = new Pages();
        $model->published = true;
        $model->main = false;
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new PagesLng();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->main)
                Pages::updateAll(['main' => 0]);
            $model->save();
            foreach ($modelLng as $key => $modelL) {
                $modelL->item_id = $model->id;
                if ($modelL->validate())
                    $modelL->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('pages'), 'id', 'title');
        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
        ]);
    }

    public function actionUpdate($id) {
        $model = Pages::find()->where(['id' => $id])
            ->with('translate')
            ->limit(1)->one();
        $modelLng = PagesLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            if (empty($modelLng[$lang->url])) {
                $modelLng[$lang->url] = new PagesLng();
            }
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->main)
                Pages::updateAll(['main' => 0]);
            $model->save();
            foreach ($modelLng as $key => $modelL) {
                $modelL->item_id = $model->id;
                if ($modelL->validate())
                    $modelL->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('pages'), 'id', 'title');
        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
        ]);
    }

    public function actionPublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            Pages::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUnpublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            Pages::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionDelete($id) {
        if (($model = Pages::findOne($id)) !== null) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

}