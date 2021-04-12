<?php
/**
 * @var yii\web\View
 * @var \Da\User\Module $module
 * @var string          $title
 */

use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-center mb-4">
    <?= $this->render('../shared/_alert') ?>

    <?= Html::a(Yii::t('frontend', 'Back to My account'), ['/user/profile/index'], ['class' => 'btn-back']) ?>
</div>