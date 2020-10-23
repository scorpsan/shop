<?php
/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
use Da\User\Widget\ConnectWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View            $this
 * @var \Da\User\Form\LoginForm $model
 * @var \Da\User\Module         $module
 */
Yii::$app->layout = 'pagesite';
$this->title = Yii::t('usuario', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/shared/_alert', ['module' => Yii::$app->getModule('user')]) ?>
<div class="row">
    <div class="col-lg-3 col-1"></div>
    <div class="col-lg-6 col-10 myaccount">
        <div class="CustomerLoginForm account-element login">
            <div class="engoc-account-heading text-center">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <?php $form = ActiveForm::begin(
                [
                    'id' => $model->formName(),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]
            ) ?>
            <div class="page-content">
                <div class="login-form">
                    <div class="form-groups">
                    <?= $form->field($model, 'login',
                        ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                    ) ?>

                    <?= $form->field($model, 'password',
                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                        ->passwordInput()
                        ->label( Yii::t('usuario', 'Password')
                        . ($module->allowPasswordRecovery ?
                            ' (' . Html::a(
                                Yii::t('usuario', 'Forgot password?'),
                                ['/user/recovery/request'],
                                ['tabindex' => '5']
                            ) . ')' : '')
                    ) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>
                    </div>
                    <div class="d-flex lr">
                        <?= Html::submitButton(Yii::t('usuario', 'Sign in'), ['class' => 'btn-submit', 'tabindex' => '3']) ?>

                    </div>
                    <div class="d-flex lr">
                        <?php if ($module->enableEmailConfirmation): ?>
                            <p><?= Html::a(Yii::t('usuario', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?></p>
                        <?php endif ?>
                        <?php if ($module->enableRegistration): ?>
                            <p><?= Html::a(Yii::t('usuario', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?></p>
                        <?php endif ?>
                        <?= ConnectWidget::widget(['baseAuthUrl' => ['/user/security/auth']]) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col-lg-3 col-1"></div>
</div>