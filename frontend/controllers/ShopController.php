<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\ShopBrands;
use frontend\models\ShopProducts;
use frontend\models\ShopProductsLng;
use frontend\models\Tags;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ShopController extends AppController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = ShopProducts::find()->where(['published' => true])
            ->with('translate')
            ->with('images')
            ->with('category')
            ->orderBy(['in_stock' => SORT_DESC, 'new' => SORT_DESC, 'sort' => SORT_ASC]);

        if ($search = Yii::$app->request->get('search')) {
            $search = trim($search);
            $search = htmlspecialchars($search);
            $query->andFilterWhere([
                'or',
                ['like', ShopProductsLng::tableName().'.title', $search],
                ['like', 'code', $search],
            ]);
        }
        if ($tag = Yii::$app->request->get('tag')) {
            $tagName = htmlspecialchars(trim($tag));
            $tagArray = Tags::find()->where(['name' => $tagName])->with('shopTags')->one();
            $query->andFilterWhere(['in', 'id', ArrayHelper::getColumn($tagArray->shopTags, 'item_id')]);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 16, 'forcePageParam' => false, 'pageSizeParam' => false, 'pageSizeLimit' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $root = Categories::find()->where(['alias' => 'shop'])->with('translate')->limit(1)->one();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$root->page_style]['layouts'];
        $this->headerClass = Yii::$app->params['categoryStyle'][$root->page_style]['headclass'];

        if (Yii::$app->params['categoryStyle'][$root->page_style]['breadbg'] && !empty($root->translate->breadbg)) {
            $this->backBreadcrumbs = $root->translate->breadbg;
        }
        $this->setMeta(Yii::$app->name . ' | ' . $root->seotitle, $root->keywords, $root->description);

        return $this->render('index', [
            'products' => $products,
            'category' => $root,
            'pages' => $pages,
            'search' => $search,
        ]);
    }

    /**
     * @param $categoryalias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($categoryalias)
    {
        $category = Categories::find()->where(['published' => true, 'alias' => $categoryalias])->with('translate')->limit(1)->one();
        if (empty($category)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $categoryParent = $category->parents()->andWhere(['published' => true])->with('translate')->all();
        $categoryChildren = array_merge([$category->id], $category->children()->select('id')->andWhere(['published' => true])->column());

        $query = ShopProducts::find()->where(['published' => true])
            ->andWhere(['in', 'category_id', $categoryChildren])
            ->with('translate')
            ->with('images')
            ->with('category')
            ->orderBy(['in_stock' => SORT_DESC, 'new' => SORT_DESC, 'sort' => SORT_ASC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 16, 'forcePageParam' => false, 'pageSizeParam' => false, 'pageSizeLimit' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$category->page_style]['layouts'];
        $this->headerClass = Yii::$app->params['categoryStyle'][$category->page_style]['headclass'];

        if (Yii::$app->params['categoryStyle'][$category->page_style]['breadbg'] && !empty($category->translate->breadbg)) {
            $this->backBreadcrumbs = $category->translate->breadbg;
        }
        $this->setMeta(Yii::$app->name . ' | ' . $category->seotitle, $category->keywords, $category->description);

        return $this->render('category', [
            'products' => $products,
            'category' => $category,
            'categoryParent' => $categoryParent,
            'pages' => $pages,
        ]);
    }

    /**
     * @param $categoryalias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBrand($brandalias)
    {
        $brand = ShopBrands::find()->where(['published' => true, 'alias' => $brandalias])->with('translate')->limit(1)->one();
        if (empty($brand)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        $query = ShopProducts::find()->where(['published' => true])
            ->andWhere(['brand_id' => $brand->id])
            ->with('translate')
            ->with('images')
            ->with('category')
            ->orderBy(['in_stock' => SORT_DESC, 'new' => SORT_DESC, 'sort' => SORT_ASC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 16, 'forcePageParam' => false, 'pageSizeParam' => false, 'pageSizeLimit' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $root = Categories::find()->where(['alias' => 'shop'])->with('translate')->limit(1)->one();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$root->page_style]['layouts'];
        $this->headerClass = Yii::$app->params['categoryStyle'][$root->page_style]['headclass'];

        if (Yii::$app->params['categoryStyle'][$root->page_style]['breadbg'] && !empty($brand->breadbg)) {
            $this->backBreadcrumbs = $brand->breadbg;
        }
        $this->setMeta(Yii::$app->name . ' | ' . $brand->seotitle, $brand->keywords, $brand->description);

        return $this->render('brand', [
            'products' => $products,
            'category' => $root,
            'brand' => $brand,
            'pages' => $pages,
        ]);
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProduct($alias)
    {
        $product = ShopProducts::find()->where(['published' => true, 'alias' => $alias])->with('translate')->with('images')->with('characteristics')->limit(1)->one();
        if (empty($product)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $product->updateCounters(['hit' => 1]);

        $categoryParent = $product->category->parents()->andWhere(['published' => true])->with('translate')->all();

        Yii::$app->layout = Yii::$app->params['categoryStyle'][$product->category->page_style]['layouts'];
        $this->headerClass = Yii::$app->params['categoryStyle'][$product->category->page_style]['headclass'];

        if (Yii::$app->params['categoryStyle'][$product->category->page_style]['breadbg'] && !empty($product->category->translate->breadbg)) {
            $this->backBreadcrumbs = $product->category->translate->breadbg;
        }
        $this->setMeta(Yii::$app->name . ' | ' . $product->seotitle, $product->keywords, $product->description);

        return $this->render('product', [
            'categoryParent' => $categoryParent,
            'product' => $product,
        ]);
    }

}