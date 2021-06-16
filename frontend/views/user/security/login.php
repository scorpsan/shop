<?php
/**
 * @var yii\web\View            $this
 * @var \Da\User\Form\LoginForm $model
 * @var \Da\User\Module         $module
 */

use Da\User\Widget\ConnectWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('usuario', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row myaccount">
    <div class="col-12">
        <div class="account-element login">
            <div class="form-account-heading text-center">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="page-content">
                <?php $form = ActiveForm::begin([
                    'id' => $model->formName(),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>
                    <?= $this->render('../shared/_alert') ?>

                    <div class="login-form">
                        <?= $form->field($model, 'login')->label(Yii::t('frontend', 'Email')) ?>

                        <?= $form->field($model, 'password')->passwordInput()
                            ->label( Yii::t('usuario', 'Password')
                                . ($module->allowPasswordRecovery ?
                                    ' (' . Html::a(
                                        Yii::t('usuario', 'Forgot password?'),
                                        ['/user/recovery/request'],
                                        ['tabindex' => '5']
                                    ) . ')' : '')
                            ) ?>

                        <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'checkbox']])->checkbox(['tabindex' => '4']) ?>

                        <div class="d-flex lr">
                            <?= Html::submitButton(Yii::t('usuario', 'Sign in'), ['class' => 'btn-submit', 'tabindex' => '3']) ?>

                            <?php if ($module->enableEmailConfirmation): ?>
                                <?= Html::a(Yii::t('usuario', 'Didn\'t receive confirmation message?'), ['/user/registration/resend'], ['class' => 'RecoverPassword btn-lostpwd']) ?>
                            <?php endif ?>
                        </div>

                        <?php if ($module->enableRegistration): ?>
                        <div class="box-register">
                            <span class="or-register mr-2"></span>
                            <?= Html::a(Yii::t('usuario', 'Don\'t have an account? Sign up!'), ['/user/registration/register'], ['class' => 'creat-account']) ?>
                        </div>
                        <?php endif ?>

                        <?= ConnectWidget::widget(['baseAuthUrl' => ['/user/security/auth']]) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>