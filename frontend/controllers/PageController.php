<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Pages;
use yii\web\NotFoundHttpException;

class PageController extends AppController {

    public $conTitle;

    public function init() {
        $this->conTitle = Yii::t('frontend', 'Pages');
        parent::init();
    }

    public function actionIndex() {
        $model = Pages::findIndexPage();
        if (empty($model)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $this->setMeta(Yii::$app->name . ' | ' . $model->seotitle, $model->keywords, $model->description);
        //Yii::$app->session['alias'] = $model->alias;
        Yii::$app->layout = 'main';
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionView($alias) {
        $model = Pages::findAliasPage($alias);
        if (empty($model)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        if ($model->main) {
            return $this->redirect('main');
        }
        $this->setMeta(Yii::$app->name . ' | ' . $model->seotitle, $model->keywords, $model->description);
        //Yii::$app->session['alias'] = $model->alias;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionSearch() {
        if (!Yii::$app->params['searchOnSite']) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $query = Yii::$app->request->get('s');
        $query = trim($query);
        $query = htmlspecialchars($query);
        $this->setMeta(Yii::$app->name . ' | ' . Yii::t('app', 'Search results'), Yii::$app->params['keywords'], Yii::$app->params['description']);
        if (!$query) {
            return $this->render('search', [
                's' => $query,
                'results' => null,
            ]);
        } else {
            $results = Pages::find()->where(['published' => true])/*->andWhere('or', ['like', 'translate.title', $query], ['like', 'translate.description', $query], ['like', 'content', $query])*/->all();
            return $this->render('search', [
                's' => $query,
                'results' => $results,
            ]);
        }
    }

}