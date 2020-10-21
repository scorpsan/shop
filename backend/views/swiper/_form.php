<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'description')->textarea(['rows' => 5, 'maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'published')->checkbox() ?>

                <?= $form->field($model, 'player')->checkbox() ?>
            </div>
        </div>
    </div>
</div>
<?php if ($model->id) { ?>
<h2 class="page-header"><i class="fa fa-picture-o"></i> <?= Yii::t('backend', 'Slides') ?></h2>
<div class="row">
    <div class="col-xs-12" id="slides" data-item_id="<?= $model->id ?>"></div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::button(Yii::t('backend', 'Create Slide'), [
                    'class' => 'btn btn-primary slideButton',
                    'data' => [
                        'title' => Yii::t('backend', 'Create Slide'),
                        'action' => Url::to(['/swiper-slides/create', 'item_id' => $model->id]),
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>
                <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="modal fade bs-example-modal-lg" id="modal-edit-slide">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= Yii::t('backend', 'Close') ?>">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<?php
$url1 = Url::to(['/swiper-slides/index']);
$script = <<< JS
$("#slides").each(function(i,elem) {
    var data = $(this).data();
    $(this).load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
});
$(document).on('click', '.actionButton', function(e) {
    e.preventDefault();
    var data = $(this).data();
    $.ajax({
        type: "POST",
        url: data.url,
        data: {id: data.id},
        cache: false
    })
    .done(function(result) {
        if (result) {
            $('#slides').load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        } else {
            alert( "Request failed");
        }
    });
});
$(document).on('click', '.slideButton', function() {
    var data = $(this).data(),
        modal = $('#modal-edit-slide');
    modal.find('.modal-title').text(data.title);
    modal.find('.modal-body').load(data.action);
    modal.modal('show');
});
$(document).on('submit', '#slide-form', function() {
    var form = $(this),
        data = $(this).data(),
        modal = $('#modal-edit-slide');
    $.post(
        form.attr("action"),
        form.serialize()
    )
    .done(function(result) {
        if (result.success) {
            modal.modal('hide');
            modal.find('.modal-title').text('');
            modal.find('.modal-body').text('');
            $('#slides').load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        }
    });
    return false;
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>