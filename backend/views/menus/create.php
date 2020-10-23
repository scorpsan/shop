<?php
$this->title = Yii::t('backend', 'Create Menu Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'parentList' => $parentList,
    'listUrls' => $listUrls,
    'available_roles' => $available_roles,
    'languages' => $languages,
]) ?>
