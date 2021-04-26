<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopPayment
 * @var $modelLng       backend\models\ShopPaymentLng
 * @var $languages      backend\models\Language
 */
$this->title = Yii::t('backend', 'Update Payment Method') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Payment Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
]) ?>