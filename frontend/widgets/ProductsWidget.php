<?php
namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\ShopProducts;

/**
 * Class ProductsWidget
 * @package frontend\widgets
 */
class ProductsWidget extends Widget
{
    /**
     * 'options' => [
     *      'type' => {
     *          'new' => 'New Arrivals',
     *          'rnd' => 'Random Products',
     *          'hit' => 'Hits Sales',
     *          'act' => 'Actions Products',
     *          'rat' => 'High Ratings Products'
     *      },
     *      'count' => {
     *          0 => 'All in one page',
     *          4 => '4 - one row',
     *          8 => '8 - 2 rows',
     *          12 => '12 - 3 rows'
     *      },
     * ],
     */
    public $options;
    /**
     * 'params' => [
     *      'title => 'Products',
     *      'show_title' => true,
     *      'style' => false,
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
            'title' => 'Products',
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
        $query = ShopProducts::find()->with('category')->with('translate')->with('images');
        if ($this->options['count'] > 0) {
            $query->limit($this->options['count']);
        }
        switch ($this->options['type']) {
            case 'rnd':
                $items = $query->orderBy('rand()')->all();
                break;
            case 'hit':
                $items = $query->orderBy(['hit' => SORT_DESC])->all();
                break;
            case 'act':
                $items = $query->andWhere(['>', 'sale', 0])->orderBy('rand()')->all();
                break;
            case 'rat':
                $items = $query->orderBy(['rating' => SORT_DESC])->all();
                break;
            case 'new':
                $items = $query->orderBy(['created_at' => SORT_DESC])->all();
                break;
            default:
                $items = $query->all();
        }
        if (!empty($items)) {
            return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'products-widget', [
                'items' => $items,
                'params' => $this->params,
                'options' => $this->options,
            ]);
        }
        return null;
    }

}