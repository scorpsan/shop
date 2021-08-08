<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Posts;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class PostsController extends AppController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Posts::find()->where(['published' => true])
            ->with('translate')
            ->with('category')
            ->orderBy(['created_at' => SORT_DESC]);

        $pages = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false, 'pageSizeLimit' => false]);
        $posts = $query->offset($pages->offset)->limit($pages->limit)->all();

        $root = Categories::find()->where(['alias' => 'posts'])->with('translate')->limit(1)->one();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$root->page_style]['layouts'];
        $this->title = $root->title;
        $this->headerClass = Yii::$app->params['categoryStyle'][$root->page_style]['headclass'];
        if (Yii::$app->params['categoryStyle'][$root->page_style]['breadbg'] && !empty($root->translate->breadbg)) {
            $this->backBreadcrumbs = $root->translate->breadbg;
        }

        $this->setMeta($root->seotitle, $root->keywords, $root->description);

        return $this->render('index', [
            'posts' => $posts,
            'category' => $root,
            'pages' => $pages,
        ]);
    }

    /**
     * @param $categoryalias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($categoryalias): string
    {
        $category = Categories::find()->where(['published' => true, 'alias' => $categoryalias])->with('translate')->limit(1)->one();
        if (empty($category)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $categoryParent = $category->parents()->andWhere(['published' => true])->with('translate')->all();
        $categoryChildren = array_merge([$category->id], $category->children()->select('id')->andWhere(['published' => true])->column());

        $query = Posts::find()->where(['published' => true])
            ->andWhere(['in', 'category_id', $categoryChildren])
            ->with('translate')
            ->with('category')
            ->orderBy(['created_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false, 'pageSizeLimit' => false]);
        $posts = $query->offset($pages->offset)->limit($pages->limit)->all();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$category->page_style]['layouts'];
        $this->title = $category->title;
        $this->headerClass = Yii::$app->params['categoryStyle'][$category->page_style]['headclass'];
        if (Yii::$app->params['categoryStyle'][$category->page_style]['breadbg'] && !empty($category->translate->breadbg)) {
            $this->backBreadcrumbs = $category->translate->breadbg;
        }

        $this->setMeta($category->seotitle, $category->keywords, $category->description);

        return $this->render('category', [
            'posts' => $posts,
            'category' => $category,
            'categoryParent' => $categoryParent,
            'pages' => $pages,
        ]);
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($alias): string
    {
        $post = Posts::find()->where(['published' => true, 'alias' => $alias])->with('translate')->limit(1)->one();
        if (empty($post)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $post->updateCounters(['hit' => 1]);

        $categoryParent = $post->category->parents()->andWhere(['published' => true])->with('translate')->all();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$post->category->page_style]['layouts'];
        $this->title = $post->category->title;
        if (!empty($post->breadbg)) {
            $this->backBreadcrumbs = $post->breadbg;
        }

        $this->setMeta($post->seotitle, $post->keywords, $post->description);

        return $this->render('view', [
            'post' => $post,
            'categoryParent' => $categoryParent,
        ]);
    }

}