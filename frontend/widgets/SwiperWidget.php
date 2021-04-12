<?php
namespace frontend\widgets;

use yii\base\Widget;
use common\models\Swiper;

/**
 * Class SwiperWidget
 * @package frontend\widgets
 */
class SwiperWidget extends Widget
{
    public $options;
    public $params;

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
        $items = Swiper::find()->where(['id' => $this->options['id'], 'published' => true])->with('slides')->limit(1)->one();
        if (!empty($items)) {
            return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'swiper-widget', [
                'items' => $items,
                'params' => $this->params,
                'options' => $this->options,
            ]);
        }
        return null;
    }

}