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
        $root = Categories::find()->where(['alias' => 'shop'])->with('translate')->limit(1)->one();
        $secondMenu = $root->menuTreeCategories('shop');

        $brands = Yii::$app->cache->get('brandsTreeCategories' . Yii::$app->language);
        if (empty($brands)) {
            $brandsAll = ShopBrands::find()->where(['published' => true])->with('translate')->all();
            foreach ($brandsAll as $brand) {
                if ($brand->countProd) {
                    $brands[] = ['label' => $brand->title, 'count' => $brand->countProd, 'url' => ['/shop/brand', 'brandalias' => $brand->alias]];
                }
            }
            ArrayHelper::multisort($brands, 'label', SORT_ASC);
            $brands = ArrayHelper::merge([
                ['label' => Yii::t('frontend', 'All Brands'), 'url' => ['/shop/index']]
            ], $brands);
            // set cache
            Yii::$app->cache->set('brandsTreeCategories' . Yii::$app->language, $brands, 3600);
        }

        $tags = Tags::find()->orderBy(['frequency' => SORT_DESC])->all();

        return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'filter-widget', [
            'categoryalias' => $this->categoryalias,
            'secondMenu' => $secondMenu,
            'brands' => $brands,
            'tags' => $tags,
        ]);
    }

}