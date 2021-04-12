<?php
namespace frontend\controllers;

use frontend\models\PagesLng;
use Yii;
use frontend\models\Pages;
use yii\web\NotFoundHttpException;

class PageController extends AppController
{
    /**
     * @return Pages|string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        if (!$model = Pages::findIndexPage()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        Yii::$app->layout = 'main';
        $this->headerClass = Yii::$app->params['pageStyle'][$model->page_style]['headclass'];

        $this->setMeta(Yii::$app->name . ' | ' . $model->seotitle, $model->keywords, $model->description);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $alias
     * @return Pages|string
     * @throws NotFoundHttpException
     */
    public function actionView($alias)
    {
        if (!$model = Pages::findAliasPage($alias)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if ($model->main) {
            return $this->redirect('index');
        }

        Yii::$app->layout = Yii::$app->params['pageStyle'][$model->page_style]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][$model->page_style]['headclass'];

        if (Yii::$app->params['pageStyle'][$model->page_style]['breadbg'] && !empty($model->translate->breadbg)) {
            $this->backBreadcrumbs = $model->translate->breadbg;
        }

        $this->setMeta(Yii::$app->name . ' | ' . $model->seotitle, $model->keywords, $model->description);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionSearch()
    {
        $query = Yii::$app->request->post('search');
        $query = trim($query);
        $query = htmlspecialchars($query);
        Yii::$app->layout = Yii::$app->params['pageStyle'][6]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][6]['headclass'];
        $this->setMeta(Yii::$app->name . ' | ' . Yii::t('frontend', 'Search results'), Yii::$app->params['keywords'], Yii::$app->params['description']);

        $results = null;
        if ($query) {
            $results = Pages::find()->where(['published' => true])->leftJoin(PagesLng::tableName())
                ->andFilterWhere(['or', ['like', PagesLng::tableName().'.title', $query], ['like', PagesLng::tableName().'.description', $query], ['like', PagesLng::tableName().'.content', $query]])
                ->all();
        }

        return $this->render('search', [
            'search' => $query,
            'results' => $results,
        ]);
    }

}