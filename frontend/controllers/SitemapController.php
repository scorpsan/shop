<?php
namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Pages;
use frontend\models\Posts;
use frontend\models\ShopBrands;
use frontend\models\ShopProducts;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class SitemapController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->cache->delete('sitemap');

        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {

            $urls = array();

            // Pages
            $pages = Pages::find()->where(['published' => true, 'noindex' => false])->orderBy(['main' => SORT_DESC, 'created_at' => SORT_ASC])->all();
            foreach ($pages as $item) {
                if ($item->main) {
                    $urls[] = array(
                        'loc' => ['/page/index'],
                        'lastmod' => $item->updated_at,
                        'changefreq' => 'daily',
                        'priority' => 1.0
                    );
                } else {
                    $urls[] = array(
                        'loc' => ['/page/view', 'alias' => $item->alias],
                        'lastmod' => $item->updated_at,
                        'changefreq' => 'daily',
                        'priority' => 1.0
                    );
                }
            }

            // Pages Categories
            $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
            if (!empty($root)) {
                $categories = $root->children()->andWhere(['published' => true, 'noindex' => false])->all();
                foreach ($categories as $item) {
                    if ($item->depth) {
                        $urls[] = array(
                            'loc' => ['/page/category', 'categoryalias' => $item->alias],
                            'changefreq' => 'daily',
                            'priority' => 1.0
                        );
                    }
                }
            }

            // Shop Categories
            $root = Categories::find()->where(['alias' => 'shop'])->limit(1)->one();
            if (!empty($root)) {
                $urls[] = array(
                    'loc' => ['/shop/index'],
                    'changefreq' => 'daily',
                    'priority' => 1.0
                );
                $categories = $root->children()->andWhere(['published' => true, 'noindex' => false])->all();
                foreach ($categories as $item) {
                    if ($item->depth) {
                        $urls[] = array(
                            'loc' => ['/shop/category', 'categoryalias' => $item->alias],
                            'changefreq' => 'daily',
                            'priority' => 0.9
                        );
                    }
                }
            }

            // Shop Products
            $products = ShopProducts::find()->where(['published' => true])->orderBy(['created_at' => SORT_ASC])->all();
            foreach ($products as $item) {
                $urls[] = array(
                    'loc' => ['/shop/product', 'alias' => $item->alias],
                    'lastmod' => $item->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => 0.8
                );
            }

            // Shop Brands
            $brands = ShopBrands::find()->where(['published' => true])->orderBy(['alias' => SORT_ASC])->all();
            if (count($brands) > 1) {
                foreach ($brands as $item) {
                    $urls[] = array(
                        'loc' => ['/shop/brand', 'alias' => $item->alias],
                        'changefreq' => 'weekly',
                        'priority' => 0.8
                    );
                }
            }

            // Posts Categories
            $root = Categories::find()->where(['alias' => 'posts'])->limit(1)->one();
            if (!empty($root)) {
                $urls[] = array(
                    'loc' => ['/posts/index'],
                    'changefreq' => 'daily',
                    'priority' => 1.0
                );
                $categories = $root->children()->andWhere(['published' => true, 'noindex' => false])->all();
                foreach ($categories as $item) {
                    if ($item->depth) {
                        $urls[] = array(
                            'loc' => ['/posts/category', 'categoryalias' => $item->alias],
                            'changefreq' => 'daily',
                            'priority' => 0.5
                        );
                    }
                }
            }

            // Posts
            $posts = Posts::find()->where(['published' => true, 'noindex' => false])->orderBy(['created_at' => SORT_ASC])->all();
            foreach ($posts as $item) {
                $urls[] = array(
                    'loc' => ['/posts/view', 'alias' => $item->alias],
                    'lastmod' => $item->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => 0.5
                );
            }

            $xml_sitemap = $this->renderPartial('index', array(
                'urls' => $urls,
            ));

            Yii::$app->cache->set('sitemap', $xml_sitemap, 60*60*12);
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/xml');

        return $xml_sitemap;
    }

}