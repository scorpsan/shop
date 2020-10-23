<?php
$this->title = Yii::t('backend', 'Update Menu Item') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'parentList' => $parentList,
    'listUrls' => $listUrls,
    'available_roles' => $available_roles,
    'languages' => $languages,
]) ?>