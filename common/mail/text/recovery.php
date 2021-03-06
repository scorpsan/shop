<?php

/**
 * @var Da\User\Model\User
 * @var Da\User\Model\Token $token
 */

?>
<?= Yii::t('usuario', 'Hello') ?>,

<?= Yii::t('usuario', 'We have received a request to reset the password for your account on {0}', Yii::$app->name) ?>.
<?= Yii::t('usuario', 'Please click the link below to complete your password reset') ?>.

<?= $token->url ?>

<?= Yii::t('usuario', 'If you cannot click the link, please try pasting the text into your browser') ?>.

<?= Yii::t('usuario', 'If you did not make this request you can ignore this email') ?>.
