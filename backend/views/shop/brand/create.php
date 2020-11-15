<?php
/**
 * @var $this       yii\web\View
 * @var $model      backend\models\ShopBrands
 * @var $modelLng   backend\models\ShopBrandsLng
 * @var $languages      backend\models\Language
 */
$this->title = Yii::t('backend', 'Create Brand');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Product Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
]) ?>
