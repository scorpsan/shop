<?php
/**
 * @var yii\web\View                   $this
 * @var \Da\User\Form\RegistrationForm $model
 * @var \Da\User\Model\User            $user
 * @var \Da\User\Module                $module
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\phoneInput\phoneInputWidget;

$this->title = Yii::t('usuario', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row myaccount">
    <div class="col-12">
        <div class="account-element">
            <div class="form-account-heading text-center">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="page-content">
                <?php $form = ActiveForm::begin([
                    'id' => $model->formName(),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]) ?>
                    <?= $this->render('../shared/_alert') ?>

                    <div class="login-form">
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'email')->input('email') ?>

                        <?= $form->field($model, 'phone')->widget(phoneInputWidget::class, [
                            'preferred' => ['BY'],
                            //'buttonClass' => 'uk-input uk-border-rounded',
                            'bsVersion' => 4,
                            'selectOn' => false,
                        ]) ?>

                        <?php if ($module->generatePasswords === false): ?>
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        <?php endif ?>

                        <?php if ($module->enableGdprCompliance): ?>
                            <?= $form->field($model, 'gdpr_consent', ['options' => ['class' => 'checkbox']])->checkbox() ?>
                        <?php endif ?>

                        <div class="d-flex lr">
                            <?= Html::submitButton(Yii::t('usuario', 'Sign up'), ['class' => 'btn-submit']) ?>
                        </div>

                        <div class="box-register">
                            <span class="or-register mr-2"></span>
                            <?= Html::a(Yii::t('usuario', 'Already registered? Sign in!'), ['/user/security/login']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>