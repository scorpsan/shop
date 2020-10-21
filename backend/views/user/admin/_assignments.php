<?php
use Da\User\Widget\AssignmentsWidget;
/**
 * @var $this       yii\web\View
 * @var $user       Da\User\Model\User
 * @var $params     string[]
 */
?>

<?php $this->beginContent('@backend/views/user/admin/update.php', ['user' => $user]) ?>

<?= yii\bootstrap\Alert::widget([
    'options' => [ 'class' => 'alert-info alert-dismissible' ],
    'body' => Yii::t('usuario', 'You can assign multiple roles or permissions to user by using the form below'),
]) ?>

<?= AssignmentsWidget::widget(['userId' => $user->id, 'params' => $params]) ?>

<?php $this->endContent() ?>
