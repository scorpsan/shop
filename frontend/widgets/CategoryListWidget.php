<?php
namespace frontend\widgets;

use frontend\models\Categories;
use yii\base\Widget;
use frontend\models\ShopProducts;

/**
 * Class ProductsWidget
 * @package frontend\widgets
 */
class CategoryListWidget extends Widget
{
    /**
     * 'options' => [
     *      'count' => {
     *          1 => '1 column',
     *          2 => '2 columns',
     *          3 => '3 columns',
     *          4 => '4 columns'
     *      },
     * ],
     */
    public $options;
    /**
     * 'params' => [
     *      'title => 'Categories List',
     *      'show_title' => true,
     *      'style' => true,
     *      'text_align' => false,
     *      'background' => false,
     *      'parallax' => false,
     * ],
     */
    public $params;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->params = array_merge([
            'title' => 'Categories List',
            'show_title' => true,
            'style' => 'bg-white',
            'text_align' => false,
            'background' => false,
            'parallax' => 0,
        ], $this->params);
    }

    /**
     * {@inheritdoc}
     */
    public function getViewPath()
    {
        return '@frontend/views/widgets';
    }

    /**
     * {@inheritdoc}
     * @return string|null
     */
    public function run()
    {
        $root = Categories::find()->where(['alias' => 'shop'])->with('translate')->limit(1)->one();
        $items = $root->children()->with('translate')->all();
        if (!empty($items)) {
            return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'category-list-widget', [
                'items' => $items,
                'params' => $this->params,
                'options' => $this->options,
            ]);
        }
        return null;
    }

}