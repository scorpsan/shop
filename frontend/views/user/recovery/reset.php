<?php
/**
 * @var yii\web\View               $this
 * @var yii\widgets\ActiveForm     $form
 * @var \Da\User\Form\RecoveryForm $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('usuario', 'Reset your password');
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
                ]); ?>
                    <?= $this->render('../shared/_alert') ?>

                    <div class="login-form">
                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <div class="d-flex lr">
                            <?= Html::submitButton(Yii::t('usuario', 'Finish'), ['class' => 'btn-submit']) ?>
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
