<?php
namespace backend\components\grid;

use backend\controllers\AppController;
use Yii;
use yii\helpers\Html;

class TranslateDataColumn extends \yii\grid\DataColumn {

    protected function renderDataCellContent($model, $key, $index) {
        $value = $this->getDataCellValue($model, $key, $index);
        $html = AppController::debug($value);
        /*
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
        */
        return $value === null ? $this->grid->emptyCell : $html;
    }

}