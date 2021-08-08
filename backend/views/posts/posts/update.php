<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\Posts
 * @var $modelLng       backend\models\PostsLng
 * @var $languages      backend\models\Language
 * @var $categoryList   array
 */
$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Post') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
    'modelLng' => $modelLng,
    'languages' => $languages,
    'categoryList' => $categoryList,
]) ?>