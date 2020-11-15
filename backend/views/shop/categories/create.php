<?php
/**
 * @var $model          backend\models\Categories
 * @var $modelLng       backend\models\CategoriesLng
 * @var $languages      backend\models\Language
 * @var $parentList     array
 */
$this->title = Yii::t('backend', 'Create Shop Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Shop Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'parentList' => $parentList,
]) ?>