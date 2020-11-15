<?php
/**
 * @var $model          backend\models\Pages
 * @var $modelLng       backend\models\PagesLng
 * @var $languages      backend\models\Language
 * @var $categoryList     array
 */
$this->title = Yii::t('backend', 'Update Page') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'categoryList' => $categoryList,
]) ?>
