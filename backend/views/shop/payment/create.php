<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopPayment
 * @var $modelLng       backend\models\ShopPaymentLng
 * @var $languages      backend\models\Language
 */
$this->title = Yii::t('backend', 'Create') . ' ' . Yii::t('backend', 'Payment Method');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Payment Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
]) ?>
