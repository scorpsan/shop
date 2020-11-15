<?php
/**
 * @var $model          backend\models\Categories
 * @var $modelLng       backend\models\CategoriesLng
 * @var $languages      backend\models\Language
 * @var $parentList     array
 */
$this->title = Yii::t('backend', 'Update Pages Category') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'parentList' => $parentList,
]) ?>