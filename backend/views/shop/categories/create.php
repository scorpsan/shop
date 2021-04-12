<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\Categories
 * @var $modelLng       backend\models\CategoriesLng
 * @var $languages      backend\models\Language
 * @var $parentList     array
 * @var $clearRoot      bool
 */
$this->title = Yii::t('backend', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Shop Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'parentList' => $parentList,
    'clearRoot' => $clearRoot,
]) ?>