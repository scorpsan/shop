<?php
/**
 * @var yii\web\View                        $this
 * @var yii\widgets\ActiveForm              $form
 * @var \Da\User\Model\User                 $model
 * @var \Da\User\Model\SocialNetworkAccount $account
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('usuario', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row myaccount">
    <div class="col-12">
        <div class="account-element">
            <div class="form-account-heading text-center">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="page-content">
                <div class="alert alert-info">
                    <p><?= Yii::t('usuario','In order to finish your registration, we need you to enter following fields') ?>:</p>
                </div>
                <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
                    <?= $this->render('../shared/_alert') ?>

                    <div class="login-form">
                        <?= $form->field($model, 'email')->input('email') ?>

                        <?= $form->field($model, 'username') ?>

                        <div class="d-flex lr">
                            <?= Html::submitButton(Yii::t('usuario', 'Continue'), ['class' => 'btn-submit']) ?>
                        </div>

                        <div class="box-register">
                            <span class="or-register mr-2"></span>
                            <?= Html::a(Yii::t('usuario','If you already registered, sign in and connect this account on settings page'), ['/user/settings/networks']) ?>.
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>