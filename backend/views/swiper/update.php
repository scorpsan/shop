<?php
$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Slider') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
