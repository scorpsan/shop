<?php
/**
 * @var $user       \Da\User\Model\User
 */
?>

<?php $this->beginContent('@backend/views/user/admin/update.php', ['user' => $user]) ?>

<table class="table">
    <tr>
        <td><strong><?= Yii::t('usuario', 'Registration time') ?>:</strong></td>
        <td><?= Yii::t('usuario', '{0, date, MMMM dd, YYYY HH:mm}', [$user->created_at]) ?></td>
    </tr>
    <?php if ($user->registration_ip !== null): ?>
        <tr>
            <td><strong><?= Yii::t('usuario', 'Registration IP') ?>:</strong></td>
            <td><?= $user->registration_ip ?></td>
        </tr>
    <?php endif ?>
    <tr>
        <td><strong><?= Yii::t('usuario', 'Confirmation status') ?>:</strong></td>
        <?php if ($user->isConfirmed): ?>
            <td class="text-success"><?= Yii::t(
                    'usuario',
                    'Confirmed at {0, date, MMMM dd, YYYY HH:mm}',
                    [$user->confirmed_at]
                ) ?></td>
        <?php else: ?>
            <td class="text-danger"><?= Yii::t('usuario', 'Unconfirmed') ?></td>
        <?php endif ?>
    </tr>
    <tr>
        <td><strong><?= Yii::t('usuario', 'Block status') ?>:</strong></td>
        <?php if ($user->isBlocked): ?>
            <td class="text-danger"><?= Yii::t(
                    'usuario',
                    'Blocked at {0, date, MMMM dd, YYYY HH:mm}',
                    [$user->blocked_at]
                ) ?>
            </td>
        <?php else: ?>
            <td class="text-success"><?= Yii::t('usuario', 'Not blocked') ?></td>
        <?php endif ?>
    </tr>
</table>

<?php $this->endContent() ?>
