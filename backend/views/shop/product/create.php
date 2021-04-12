<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\ShopProducts
 * @var $modelLng       backend\models\ShopProductsLng
 * @var $languages      backend\models\Language
 * @var $parentList     array
 * @var $sortingList    array
 * @var $modelParams    backend\models\ShopProductsCharacteristics
 * @var $paramsList     backend\models\ShopCharacteristics
 * @var $brandList      array
 */
$this->title = Yii::t('backend', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'parentList' => $parentList,
    'sortingList' => $sortingList,
    'modelParams' => $modelParams,
    'paramsList' => $paramsList,
    'brandList' => $brandList,
]) ?>