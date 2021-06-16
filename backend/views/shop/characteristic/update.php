<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopCharacteristics
 * @var $modelLng       backend\models\ShopCharacteristicsLng
 * @var $languages      backend\models\Language
 * @var $typeList       array
 * @var $sortingList    array
 */
$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Characteristic') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Product Characteristics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'typeList' => $typeList,
    'sortingList' => $sortingList,
]) ?>