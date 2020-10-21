<?php
/**
 * @var $this       yii\web\View
 * @var $model      backend\models\Language
 */
$this->title = Yii::t('backend', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>