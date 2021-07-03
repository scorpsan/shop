<?php
namespace backend\components\grid;

use yii\grid\DataColumn;
use Yii;
use yii\helpers\Html;

class BooleanDataColumn extends DataColumn {

    protected function renderDataCellContent($model, $key, $index) {
        $value = $this->getDataCellValue($model, $key, $index);
        switch ($value) {
            case true:
                $class = 'success';
                break;
            case false:
                $class = 'danger';
                break;
            default:
                $class = 'default';
        }
        $html = Html::tag('span', Yii::$app->formatter->asBoolean($value), ['class' => 'label label-' . $class]);
        return $value === null ? $this->grid->emptyCell : $html;
    }

}