<?php
/**
 * @var yii\web\View    $this
 * @var ActiveForm      $form
 * @var DeleteForm      $model
 */

use frontend\forms\DeleteForm;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;
?>
<h2><?= Yii::t('frontend', 'Delete') ?></h2>

<?php $form = ActiveForm::begin([
    'id' => 'delete',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
]); ?>

<p><?= $model->text ?></p>
<?= Html::activeHiddenInput($model, 'item_id'); ?>
<?= Html::activeHiddenInput($model, 'confirm'); ?>

<p class="d-flex">
    <?= Html::button(Yii::t('frontend', 'Cancel'), ['class' => 'btn-shop-now', 'data-dismiss' => 'modal']) ?>
    <?= Html::submitButton(Yii::t('frontend', 'Delete'), ['class' => 'btn-shop-now']) ?>
</p>

<?php ActiveForm::end(); ?>