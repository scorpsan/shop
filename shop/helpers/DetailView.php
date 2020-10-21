<?php
namespace shop\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DetailView extends \yii\widgets\DetailView {
    /**
     * @inheritdoc
     */
    protected function renderAttribute($attribute, $index) {
        if ($attribute['format'] !== 'hidden') {
            if (is_string($this->template)) {
                $captionOptions = Html::renderTagAttributes(ArrayHelper::getValue($attribute, 'captionOptions', []));
                $contentOptions = Html::renderTagAttributes(ArrayHelper::getValue($attribute, 'contentOptions', []));
                if ($attribute['value'] instanceof \Closure) {
                    $value = call_user_func($attribute['value'], $model);
                } else {
                    $value = $this->formatter->format($attribute['value'], $attribute['format']);
                }
                return strtr($this->template, [
                    '{label}' => $attribute['label'],
                    '{value}' => $value,
                    '{captionOptions}' => $captionOptions,
                    '{contentOptions}' => $contentOptions,
                ]);
            }
            return call_user_func($this->template, $attribute, $index, $this);
        }
        return null;
    }

}