<?php
/**
 * @var $form       yii\widgets\ActiveForm
 * @var $user       \Da\User\Model\User
 */
?>
<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
