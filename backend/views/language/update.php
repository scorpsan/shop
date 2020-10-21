<?php
/**
 * @var $this       yii\web\View
 * @var $model      backend\models\Language
 */
$this->title = Yii::t('backend', 'Update Language') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>