<?php
namespace frontend\widgets;

use frontend\models\Categories;
use frontend\models\ShopBrands;
use frontend\models\Tags;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class FilterWidget
 * @package frontend\widgets
 */
class FilterWidget extends Widget
{
    public $menu = false;
    public $brands = false;
    public $tags = false;
    public $categoryalias = null;

    /**
     * {@inheritdoc}
     */
    public function getViewPath()
    {
        return '@frontend/views/widgets';
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function run()
    {
        $secondMenu = array();
        if ($this->menu) {
            $root = Categories::find()->where(['alias' => $this->menu])->with('translate')->limit(1)->one();
            $secondMenu = $root->menuTreeCategories($this->menu);
        }

        $brands = array();
        if ($this->brands) {
            $brands = Yii::$app->cache->get('brandsTreeCategories' . Yii::$app->language);
            if (empty($brands)) {
                $brandsAll = ShopBrands::find()->where(['published' => true])->with('translate')->all();
                foreach ($brandsAll as $brand) {
                    if ($brand->countProd) {
                        $brands[] = ['label' => $brand->title, 'count' => $brand->countProd, 'url' => ['/shop/brand', 'alias' => $brand->alias]];
                    }
                }
                ArrayHelper::multisort($brands, 'label', SORT_ASC);
                $brands = ArrayHelper::merge([
                    ['label' => Yii::t('frontend', 'All Brands'), 'url' => ['/shop/index']]
                ], $brands);
                // set cache
                Yii::$app->cache->set('brandsTreeCategories' . Yii::$app->language, $brands, 3600);
            }
        }

        $tags = array();
        if ($this->tags) {
            $tags = Tags::find()->orderBy(['frequency' => SORT_DESC])->all();
        }

        return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'filter-widget', [
            'categoryalias' => $this->categoryalias,
            'menu' => $this->menu,
            'secondMenu' => $secondMenu,
            'brands' => $brands,
            'tags' => $tags,
        ]);
    }

}