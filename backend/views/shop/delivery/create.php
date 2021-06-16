<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopDelivery
 * @var $modelLng       backend\models\ShopDeliveryLng
 * @var $languages      backend\models\Language
 */
$this->title = Yii::t('backend', 'Create') . ' ' . Yii::t('backend', 'Delivery Method');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
]) ?>
