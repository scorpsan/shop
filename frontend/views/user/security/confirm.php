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
        <div class="account-element">
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
                        <?= $form->field($model,'twoFactorAuthenticationCode',
                            ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                        ) ?>

                        <div class="d-flex lr">
                            <?= Html::submitButton(Yii::t('usuario', 'Confirm'), ['class' => 'btn-submit']) ?>

                            <?= Html::a(Yii::t('usuario', 'Cancel'), ['/user/security/login'], ['class' => 'btn-back', 'tabindex' => '3']) ?>
                        </div>

                        <div class="box-register">
                            <span class="or-register mr-2"></span>
                            <?= Html::a(Yii::t('frontend', 'Back to My account'), ['/user/profile/index']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>