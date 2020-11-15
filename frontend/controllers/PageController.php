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
        if (($model = Pages::findIndexPage()) !== null) {
            Yii::$app->layout = 'main';
            $this->headerClass = Yii::$app->params['pageStyle'][$model->page_style]['headclass'];
            $this->setMeta(Yii::$app->name . ' | ' . $model->seotitle, $model->keywords, $model->description);
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionView($alias) {
        if (($model = Pages::findAliasPage($alias)) !== null) {
            if ($model->main) {
                return $this->redirect('main');
            }
            Yii::$app->layout = Yii::$app->params['pageStyle'][$model->page_style]['layouts'];
            $this->headerClass = Yii::$app->params['pageStyle'][$model->page_style]['headclass'];
            if (Yii::$app->params['pageStyle'][$model->landing]['breadbg'] && $model->translate->breadbg) {
                $this->backBreadcrumbs = $model->translate->breadbg;
            }
            $this->setMeta(Yii::$app->name . ' | ' . $model->seotitle, $model->keywords, $model->description);
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionSearch() {
        if (Yii::$app->params['searchOnSite']) {
            $query = Yii::$app->request->get('s');
            $query = trim($query);
            $query = htmlspecialchars($query);
            Yii::$app->layout = Yii::$app->params['pageStyle'][6]['layouts'];
            $this->headerClass = Yii::$app->params['pageStyle'][6]['headclass'];
            $this->setMeta(Yii::$app->name . ' | ' . Yii::t('app', 'Search results'), Yii::$app->params['keywords'], Yii::$app->params['description']);
            if (!$query) {
                return $this->render('search', [
                    's' => $query,
                    'results' => null,
                ]);
            } else {
                $results = Pages::find()->where(['published' => true])/*->andWhere('or', ['like', 'translate.title', $query], ['like', 'translate.description', $query], ['like', 'content', $query])*/ ->all();
                return $this->render('search', [
                    's' => $query,
                    'results' => $results,
                ]);
            }
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

}