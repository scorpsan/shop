<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\Categories
 * @var $modelLng       backend\models\CategoriesLng
 * @var $languages      backend\models\Language
 * @var $parentList     array
 * @var $clearRoot      bool
 */
$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Category') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'parentList' => $parentList,
    'clearRoot' => $clearRoot,
]) ?>