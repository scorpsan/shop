<?php
namespace backend\components\grid;

use backend\models\Language;
use yii\helpers\Html;

class TranslatesDataColumn extends \yii\grid\DataColumn {

    public $clearRoot = true;

    protected function renderDataCellContent($model, $key, $index) {
        if (isset($model->depth) && $model->depth == 0 && $this->clearRoot) {
            return $this->grid->emptyCell;
        } else {
            $value = $this->getDataCellValue($model, $key, $index);
            $html = '';
            $languages = Language::getLanguages();
            foreach ($languages as $key => $lang) {
                if (isset($value[$key]))
                    if ($lang->default)
                        $html .= Html::tag('span', $key, ['class' => 'label label-primary']);
                    else
                        $html .= Html::tag('span', $key, ['class' => 'label label-success']);
                else
                    $html .= Html::tag('span', $key, ['class' => 'label label-danger']);
            }
        }
        return $value === null ? $this->grid->emptyCell : $html;
    }

}