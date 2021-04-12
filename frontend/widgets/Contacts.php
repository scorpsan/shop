<?php
namespace frontend\widgets;

use yii\base\Widget;

class Contacts extends Widget
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
    public function run() {
        return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'contacts', [
            'params' => $this->params,
            'options' => $this->options,
        ]);
    }

}