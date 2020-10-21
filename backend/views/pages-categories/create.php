<?php
$this->title = Yii::t('backend', 'Create Pages Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'parentList' => $parentList,
    'languages' => $languages,
]) ?>