<?php
use Da\User\Widget\ConnectWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * @var yii\web\View            $this
 * @var \Da\User\Form\LoginForm $model
 * @var \Da\User\Module         $module
 */
$this->title = Yii::t('usuario', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>",
    'template' => "{input}{error}"
];
$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
    'template' => "{input}{error}"
];
?>
<div class="login-box">
    <div class="login-logo">
        <?= Html::a(Yii::$app->params['name'], Yii::$app->homeUrl) ?>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
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

        <?= $form->field($model, 'login', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe', [
                        'options' => ['class' => 'checkbox icheck'],
                    ])->checkbox(['template' => "{input} {label}"]) ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton(
                    Yii::t('usuario', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block btn-flat']
                ) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <?php if (isset(Yii::$app->components['authClientCollection']) && !empty(Yii::$app->components['authClientCollection']['clients'])) { ?>
        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <?= ConnectWidget::widget(['baseAuthUrl' => ['/user/security/auth']]) ?>
        </div>
        <?php } ?>

        <?php if ($module->enableEmailConfirmation): ?>
        <div class="row">
            <div class="col-xs-12">
            <?= Html::a(
                Yii::t('usuario', 'Didn\'t receive confirmation message?'),
                ['/user/registration/resend']
            ) ?>
            </div>
        </div>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
        <div class="row">
            <div class="col-xs-12">
            <?= Html::a(Yii::t('usuario', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
            </div>
        </div>
        <?php endif ?>

    </div>
</div>