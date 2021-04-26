<?php
/**
 * @var yii\web\View             $this
 * @var \Da\User\Form\ResendForm $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('usuario', 'Request new confirmation message');
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
                        <?= $form->field($model, 'email')->input('email', ['autofocus' => true]) ?>

                        <div class="d-flex lr">
                            <?= Html::submitButton(Yii::t('usuario', 'Continue'), ['class' => 'btn-submit']) ?>
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
