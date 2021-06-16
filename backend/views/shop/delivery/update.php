<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopDelivery
 * @var $modelLng       backend\models\ShopDeliveryLng
 * @var $languages      backend\models\Language
 */
$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Delivery Method') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
]) ?>