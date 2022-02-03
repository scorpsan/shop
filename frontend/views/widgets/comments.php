<?php
/**
 * @var $modelC
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Pjax;

$this->registerJs('
jQuery(document).on("click", ".comment a.icon-reply", function(event) {
    //event.preventDefault();
    var $this = jQuery(this);
    var comment = $this.data("comment");
    var commentname = $this.data("comment-name");
    $("#comments-parent").val(comment);
    $("#comments-comment").val($.trim(commentname + ", " + $("#comments-comment").val()));
});');
?>
<?php if (!empty($items)) { ?>
<div id="comments">
    <div class="text-extra-bold text-gray-light"><?= count($items) . ' ' . Yii::t('app', 'comments') ?></div>
    <div class="offset-top-25">
        <?php foreach ($items as $item) { ?>
            <div class="comment bg-alabaster text-sm-left <?= ($item->parent)?'comment-reply':'' ?>">
                <div class="unit unit-sm-horizontal unit-md-horizontal unit-lg-horizontal unit-xl-horizontal unit-middle unit-spacing-sm">
                    <?php //<div class="unit-left"><img class="max-width-none img-circle img-responsive" src="images/comments-86x86.png" width="86" alt="<?= $item->name >"/></div> ?>
                    <div class="unit-body">
                        <div class="range range-sm-justify range-sm-bottom text-sm-left">
                            <div class="cell-sm-10">
                                <ul class="list-inline list-inline-dashed list-inline-dashed-from-md text-italic">
                                    <li><span class="text-gray-lighter">by <a class="text-bold text-gray-light" href="#"><?= $item->name ?></a></span></li>
                                    <li><span class="icon-date"></span><span class="text-gray-lighter"><?= Yii::$app->formatter->asDate($item->created_at, 'medium') ?>    </span></li>
                                </ul>
                            </div>
                            <div class="cell-sm-2 offset-top-0 text-right"><a class="icon-reply text-primary fas fa-reply" data-comment="<?= $item->id ?>" data-comment-name="<?= $item->name ?>" href="#reply"></a></div>
                        </div>
                        <p><?= $item->comment ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<hr class="divider"/>
<?php } ?>
<div id="reply">
    <h6 class="text-gray-light"><?= Yii::t('app', 'Leave a Reply') ?></h6>
    <!-- RD Mailform-->
    <?php Pjax::begin(['id'=> 'pjax-comments','enablePushState' => false]); ?>
    <?php if (Yii::$app->session->hasFlash('FormSubmitted')) { ?>

        <p class="text-gray-lighter"><?= Yii::t('app', 'Thank you for your comment. After moderation, it will be published.') ?></p>

    <?php } else { ?>
        <p class="text-gray-lighter"><?= Yii::t('app', 'Your email address will not be published.') ?></p>
        <!-- RD Mailform-->
        <?php $form = ActiveForm::begin([
            'id' => 'comment-form',
            'options' => ['data-pjax' => true, 'class' => 'rd-mailform text-left offset-top-25'],
            'fieldConfig' => [
                'options' => ['class' => 'form-group'],
                'template' => '{input}<span class="form-validation">{error}</span>',
                'inputOptions' => ['class' => 'form-control form-control-last-child']
            ]
        ]); ?>

        <?= $form->field($modelC, 'module')->hiddenInput()->label(false) ?>
        <?= $form->field($modelC, 'item_id')->hiddenInput()->label(false) ?>
        <?= $form->field($modelC, 'parent')->hiddenInput()->label(false) ?>
        <?= $form->field($modelC, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha3::className(), ['siteKey' => Yii::$app->components['reCaptcha']['siteKeyV3'], 'action' => 'CommentForm']) ?>
        <div class="range">
            <div class="cell-md-6">
                <?= $form->field($modelC, 'name')->textInput(['placeholder' => $modelC->getAttributeLabel('name')]) ?>

                <?= $form->field($modelC, 'email')->textInput(['placeholder' => $modelC->getAttributeLabel('email')]) ?>
            </div>
        </div>
        <?= $form->field($modelC, 'comment', ['options' => ['class' => 'form-group textarea-group'],])->textarea(['rows' => 6, 'placeholder' => $modelC->getAttributeLabel('comment')]) ?>

        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary offset-top-10', 'name' => 'comment-button']) ?>

        <?php ActiveForm::end(); ?>
    <?php } ?>
    <?php Pjax::end(); ?>
</div>