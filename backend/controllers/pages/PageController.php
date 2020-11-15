<?php
namespace backend\controllers\pages;

use backend\models\Categories;
use backend\models\Pages;
use backend\models\PagesLng;
use backend\models\Language;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class PageController extends \backend\controllers\AppController {

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
            'query' => Pages::find()->with('translate')->with('translates')->orderBy(['main' => SORT_DESC]),
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionView($id) {
        if (($model = Pages::find()->where(['id' => $id])
            ->with('category')
            ->with('translate')
            ->with('translates')
            ->limit(1)->one()) !== null) {
            $languages = Language::getLanguages();
            return $this->render('view', [
                'model' => $model,
                'languages' => $languages,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionCreate() {
        $model = new Pages();
        $model->published = true;
        $model->main = false;
        $model->page_style = 0;
        $model->noindex = false;
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new PagesLng();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->main)
                Pages::updateAll(['main' => 0]);
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($model->page_style > 5)
                        $modelL->breadbg = null;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $categoryList = ArrayHelper::map($root->listTreeCategories('pages'), 'id', 'title');
        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'categoryList' => $categoryList,
        ]);
    }

    public function actionUpdate($id) {
        if (($model = Pages::find()->where(['id' => $id])
            ->with('translate')
            ->limit(1)->one()) !== null) {
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
                if ($model->save()) {
                    foreach ($modelLng as $key => $modelL) {
                        $modelL->item_id = $model->id;
                        if ($model->page_style > 5)
                            $modelL->breadbg = null;
                        if ($modelL->validate())
                            $modelL->save(false);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
            $categoryList = ArrayHelper::map($root->listTreeCategories('pages'), 'id', 'title');
            return $this->render('update', [
                'model' => $model,
                'modelLng' => $modelLng,
                'languages' => $languages,
                'categoryList' => $categoryList,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionPublish($id) {
        Pages::updateAll(['published' => 1], ['id' => $id]);
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        Pages::updateAll(['published' => 0], ['id' => $id]);
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionDelete($id) {
        if (($model = Pages::findOne($id)) !== null) {
            try {
                PagesLng::deleteAll(['item_id' => $id]);
                $model->delete();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['index']);
    }

}