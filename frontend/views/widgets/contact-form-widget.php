<?php
/**
 * @var $options array
 * @var $params array
 * @var $model \frontend\models\ContactForm
 */

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha3;

if (Yii::$app->session->hasFlash('FormSubmitted')) {
    Pjax::begin(['id' => 'pjaxContactForm', 'enablePushState' => false]);
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
        <?= Html::a(Yii::t('frontend', 'Contact Us'), '#', ['data-toggle' => 'modal', 'data-target' => '#modalContactForm', 'class' => 'text-white text-extra-bold link-underline']) ?>
        <?php Yii::$app->view->on(View::EVENT_END_BODY, function () use ($model, $params, $options) { ?>
            <!-- Modal CallForm window-->
            <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fas fa-times-circle"></span></button>
                            <h4 class="modal-title" id="contactModalLabel"><?= Yii::t('frontend', 'Contact Us') ?></h4>
                        </div>
                        <?php echoContactForm($model, $options['type']); ?>
                    </div>
                </div>
            </div>
        <?php });
    } elseif ($options['type'] === 'div') { ?>
        <section id="contact-form" class="section section-contact-us <?= $params['style'] ?>">
            <div class="my-container">
                <?php if ($params['show_title']) { ?>
                    <?php if (isset($params['title_size'])) { ?>
                        <<?= $params['title_size'] ?> class="text-center"><?= $params['title'] ?></<?= $params['title_size'] ?>>
                    <?php } else { ?>
                        <h3 class="h3 heading-3 font-weight-bold text-center text-capitalize"><?= $params['title'] ?></h3>
                    <?php } ?>
                <?php } ?>
                <?php echoContactForm($model, $options['type']); ?>
            </div>
        </section>
    <?php } else {
        echoContactForm($model, $options['type']);
    }
}

function echoContactForm($model, $type) {
    Pjax::begin(['id'=> 'pjaxContactForm', 'enablePushState' => false]);
    $form = ActiveForm::begin([
        'id' => 'contact-form',
        'options' => ['data-pjax' => true, 'class' => 'rd-mailform text-left' . ($type !== 'modal')?' offset-top-30':''],
        'fieldConfig' => [
            'options' => ['class' => 'mb-0'],
            'template' => '{input}{error}',
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'form-validation mb-0 mt-0']
        ]
    ]); ?>

    <?= $form->field($model, 'reCaptcha', [ 'options' => ['class' => 'hidden'] ])->widget(ReCaptcha3::class, ['siteKey' => Yii::$app->reCaptcha->siteKeyV3, 'action' => 'ContactForm'])->label(false) ?>

    <?php if ($type === 'modal') { ?>

        <div class="modal-body">
            <?= $form->field($model, 'name', [ 'inputOptions' => ['tabindex' => '1'] ]) ?>

            <?= $form->field($model, 'email', [ 'inputOptions' => ['tabindex' => '2'] ]) ?>

            <?= $form->field($model, 'phone', [ 'inputOptions' => ['tabindex' => '3'] ]) ?>

            <?= $form->field($model, 'subject', [ 'inputOptions' => [ 'tabindex' => '4'] ]) ?>

            <?= $form->field($model, 'body', [ 'options' => ['class' => 'w-100'], 'inputOptions' => [ 'tabindex' => '5'] ])->textarea() ?>
        </div>
        <div class="modal-footer">
            <?= Html::button(Yii::t('frontend', 'Close'), ['class' => 'btn btn-default', 'tabindex' => '7', 'data-dismiss' => 'modal']) ?>
            <?= Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'tabindex' => '6', 'name' => 'contact-button']) ?>
        </div>

    <?php } else { ?>

            <div class="row">
                <div class="col-12 margin-bot-30">
                    <?= $form->field($model, 'name', [ 'inputOptions' => ['placeholder' => $model->getAttributeLabel('name'), 'tabindex' => '1'] ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 margin-bot-30">
                    <?= $form->field($model, 'email', [ 'inputOptions' => ['placeholder' => $model->getAttributeLabel('email'), 'tabindex' => '2'] ]) ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 margin-bot-30">
                    <?= $form->field($model, 'phone', [ 'inputOptions' => ['placeholder' => $model->getAttributeLabel('phone'), 'tabindex' => '3'] ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 margin-bot-30">
                    <?= $form->field($model, 'subject', [ 'inputOptions' => ['placeholder' => $model->getAttributeLabel('subject'), 'tabindex' => '4'] ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 margin-bot-30">
                    <?= $form->field($model, 'body', [ 'options' => ['class' => 'w-100'], 'inputOptions' => ['placeholder' => $model->getAttributeLabel('body'), 'rows' => 10, 'tabindex' => '5'] ])->textarea() ?>
                </div>
            </div>

            <?= Html::submitButton(Yii::t('frontend', 'Submit'), ['tabindex' => '6', 'name' => 'contact-button']) ?>

    <?php }
    ActiveForm::end();
    Pjax::end();
}