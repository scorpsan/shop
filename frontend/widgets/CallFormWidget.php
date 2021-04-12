<?php
namespace frontend\widgets;

use yii\base\Widget;
use Yii;
use frontend\models\CallForm;

/**
 * Class CallFormWidget
 * @package frontend\widgets
 */
class CallFormWidget extends Widget
{
    /**
     * @var array
     * [ type (div, modal) ]
     */
    public $options;
    public $params;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (empty($this->options['style']) || $this->options['style'] === null) {
            $this->options['style'] = 'default';
        }
        if (empty($this->options['type']) || $this->options['type'] === null) {
            $this->options['type'] = 'default';
        }
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
     * @return string
     */
    public function run()
    {
        $model = new CallForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['supportEmail'])) {
            Yii::$app->session->setFlash('FormSubmitted');
        }
        return $this->render($this->getViewPath() . DIRECTORY_SEPARATOR . 'call-form-widget', [
            'model' => $model,
            'params' => $this->params,
            'options' => $this->options,
        ]);
    }

}