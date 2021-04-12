<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopBrands
 * @var $modelLng       backend\models\ShopBrandsLng
 * @var $languages      backend\models\Language
 */
$this->title = Yii::t('backend', 'Update Brand') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Product Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
]) ?>