<?php
/**
 * @var $options array
 * @var $params array
 * @var $model \frontend\models\CallForm
 */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha3;

if (Yii::$app->session->hasFlash('FormSubmitted')) {
    Pjax::begin(['id' => 'pjaxCallForm', 'enablePushState' => false]);
    if ($options['type'] === 'modal') { ?>
        <div class="modal-body">
            <p><?= Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.') ?></p>
        </div>
        <div class="modal-footer">
            <?= Html::button(Yii::t('frontend', 'Close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        </div>
    <?php } else { ?>
        <p><?= Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.') ?></p>
    <?php }
    Pjax::end();
} else {
    if ($options['type'] === 'modal') { ?>
        <?= Html::a(Yii::t('frontend', 'Request a call'), '#', ['data-toggle' => 'modal', 'data-target' => '#modalCallForm', 'class' => 'text-white text-extra-bold link-underline']) ?>
        <?php Yii::$app->view->on(View::EVENT_END_BODY, function () use ($model, $params, $options) { ?>
            <!-- Modal CallForm window-->
            <div class="modal fade" id="modalCallForm" tabindex="-1" role="dialog" aria-labelledby="callModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fas fa-times-circle"></span></button>
                            <h4 class="modal-title" id="callModalLabel"><?= Yii::t('frontend', 'Request a call') ?></h4>
                        </div>
                        <?php echoCallForm($model, $options['type']); ?>
                    </div>
                </div>
            </div>
        <?php });
    } elseif ($options['type'] === 'div') { ?>
        <section id="call-form" class="<?= $params['style'] ?> section-30 section-md-top-30 section-md-bottom-30">
            <div class="shell">
                <?php if ($params['show_title']) { ?>
                    <h3 class="text-center"><?= $params['title'] ?></h3>
                <?php } ?>
                <?php echoCallForm($model, $options['type']); ?>
            </div>
        </section>
    <?php } else {
        echoCallForm($model, $options['type']);
    }
}

function echoCallForm($model, $type) {
    Pjax::begin(['id'=> 'pjaxCallForm', 'enablePushState' => false]);
    $form = ActiveForm::begin([
        'id' => 'call-form',
        'options' => ['data-pjax' => true, 'class' => 'rd-mailform text-left' . ($type !== 'modal')?' offset-top-30':''],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'template' => '{label}{input}{error}',
            'labelOptions' => ['class' => 'form-label form-label-outside rd-input-label'],
            'inputOptions' => ['class' => 'form-control form-control-last-child'],
            'errorOptions' => ['class' => 'form-validation']
        ]
    ]); ?>

    <?= $form->field($model, 'reCaptcha', [ 'options' => ['class' => 'hidden'] ])->widget(ReCaptcha3::class, ['siteKey' => Yii::$app->reCaptcha->siteKeyV3, 'action' => 'CallForm']) ?>

    <?php if ($type === 'modal') { ?>

        <div class="modal-body">
            <?= $form->field($model, 'name', [ 'inputOptions' => ['tabindex' => '1'] ]) ?>

            <?= $form->field($model, 'phone', [ 'inputOptions' => ['tabindex' => '2'] ]) ?>

            <?= $form->field($model, 'email', [ 'inputOptions' => ['tabindex' => '3'] ]) ?>
        </div>
        <div class="modal-footer">
            <?= Html::button(Yii::t('frontend', 'Close'), ['class' => 'btn btn-default', 'tabindex' => '5', 'data-dismiss' => 'modal']) ?>
            <?= Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'tabindex' => '4', 'name' => 'call-button']) ?>
        </div>

    <?php } else { ?>

        <?php if ($type === 'div') { ?>

        <div class="range offset-top-0">
            <div class="cell-md-4">
                <?= $form->field($model, 'name', [ 'inputOptions' => ['tabindex' => '1'] ]) ?>
            </div>
            <div class="cell-md-4">
                <?= $form->field($model, 'phone', [ 'inputOptions' => ['tabindex' => '2'] ]) ?>
            </div>
            <div class="cell-md-4">
                <?= $form->field($model, 'email', [ 'inputOptions' => ['tabindex' => '3'] ]) ?>
            </div>
        </div>
        <div class="offset-top-40 text-right">
            <?= Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'tabindex' => '4', 'name' => 'call-button']) ?>
        </div>

        <?php } else { ?>

            <?= $form->field($model, 'name', [ 'inputOptions' => ['tabindex' => '1'] ]) ?>

            <?= $form->field($model, 'phone', [ 'inputOptions' => ['tabindex' => '2'] ]) ?>

            <?= $form->field($model, 'email', [ 'inputOptions' => ['tabindex' => '3'] ]) ?>

            <div class="offset-top-40 text-center">
                <?= Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'tabindex' => '4', 'name' => 'call-button']) ?>
            </div>

        <?php }
    }
    ActiveForm::end();
    Pjax::end();
}