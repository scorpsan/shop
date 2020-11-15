<?php
/**
 * @var $model          backend\models\Pages
 * @var $modelLng       backend\models\PagesLng
 * @var $languages      backend\models\Language
 * @var $categoryList     array
 */
$this->title = Yii::t('backend', 'Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'categoryList' => $categoryList,
]) ?>