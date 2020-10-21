<?php
$this->title = Yii::t('backend', 'Create Posts Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Posts Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'parentList' => $parentList,
    'languages' => $languages,
]) ?>