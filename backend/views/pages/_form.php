<?php
/**
 * @var $model          backend\models\Pages
 * @var $modelLng       backend\models\PagesLng
 * @var $languages      backend\models\Language
 */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>

                        <?= $form->field($model, 'category_id')->dropDownList($parentList) ?>

                        <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'created_at', ['enableClientValidation' => false])->widget(DateTimePicker::classname(), [
                            'options' => [
                                'placeholder' => Yii::t('backend', 'Select date and time...'),
                                'value' => $model->created_at ? Yii::$app->formatter->asDatetime($model->created_at) : '',
                            ],
                            'convertFormat' => true,
                            'removeButton' => false,
                            //'disabled' => true,
                            'pluginOptions' => [
                                'format' => Yii::$app->formatter->datetimeFormat,
                                'startDate' => '01-01-2019 00:00',
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'todayBtn'=>true,
                            ],
                        ]) ?>
                        <?= $form->field($model, 'updated_at', ['enableClientValidation' => false])->widget(DateTimePicker::classname(), [
                            'options' => [
                                'placeholder' => Yii::t('backend', 'Select date and time...'),
                                'value' => $model->updated_at ? Yii::$app->formatter->asDatetime($model->updated_at) : '',
                            ],
                            'convertFormat' => true,
                            'removeButton' => false,
                            'disabled' => true,
                            'pluginOptions' => [
                                'format' => Yii::$app->formatter->datetimeFormat,
                                'startDate' => '01-01-2019 00:00',
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'todayBtn'=>true,
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'published')->checkbox() ?>

                <?= $form->field($model, 'main')->checkbox() ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
        <p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
        <div class="nav-tabs-custom">
            <?php
            $licontent = '';
            $tabcontent = '';
            foreach ($languages as $key => $lang) {
                if ($lang->default) {
                    $licontent .= '<li class="active"><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade active in" role="tabpanel">';

                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng")->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seotitle");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]description");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]keywords");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seo_text")->textarea();

                    $tabcontent .= '<div class="row"><div class="col-xs-12"><h3 class="box-title">' . Yii::t('backend', 'Sections') . '</h3></div></div>';
                    if ($modelLng[$key]->id) {
                        $tabcontent .= '<div class="row"><div class="col-xs-12" id="lng_sections_' . $modelLng[$key]->id . '" data-item_id="' . $modelLng[$key]->id . '">';
                        $tabcontent .= '</div></div>';
                        $tabcontent .= '<div class="row"><div class="col-xs-12">';
                        $tabcontent .= Html::button(Yii::t('backend', 'Create Section'), [
                            'class' => 'btn btn-primary sectionButton',
                            'data' => [
                                'title' => Yii::t('backend', 'Create Section'),
                                'action' => Url::to(['/pages-section/create', 'item_id' => $modelLng[$key]->id]),
                            ],
                        ]);
                        $tabcontent .= ' ' . Html::button(Yii::t('backend', 'Create Widget'), [
                            'class' => 'btn btn-primary sectionButton',
                            'data' => [
                                'title' => Yii::t('backend', 'Create Widget'),
                                'action' => Url::to(['/pages-widget/create', 'item_id' => $modelLng[$key]->id]),
                            ],
                        ]);
                        $tabcontent .= '</div></div>';
                    } else {
                        $tabcontent .= '<div class="row"><div class="col-xs-12"><div class="box"><div class="box-body">';
                        $tabcontent .= Yii::t('backend', 'Create Translate for this Language before Create Sections');
                        $tabcontent .= '</div></div></div></div>';
                    }
                    $tabcontent .= '</div>';
                } else {
                    $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';

                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title", ['enableClientValidation' => false]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seotitle");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]description");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]keywords");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seo_text")->textarea();

                    $tabcontent .= '<div class="row"><div class="col-xs-12"><h3 class="box-title">' . Yii::t('backend', 'Sections') . '</h3></div></div>';
                    if ($modelLng[$key]->id) {
                        $tabcontent .= '<div class="row"><div class="col-xs-12" id="lng_sections_' . $modelLng[$key]->id . '" data-item_id="' . $modelLng[$key]->id . '">';
                        $tabcontent .= '</div></div>';
                        $tabcontent .= '<div class="row"><div class="col-xs-12">';
                        $tabcontent .= Html::button(Yii::t('backend', 'Create Section'), [
                            'class' => 'btn btn-primary sectionButton',
                            'data' => [
                                'title' => Yii::t('backend', 'Create Section'),
                                'action' => Url::to(['/pages-section/create', 'item_id' => $modelLng[$key]->id]),
                            ],
                        ]);
                        $tabcontent .= ' ' . Html::button(Yii::t('backend', 'Create Widget'), [
                            'class' => 'btn btn-primary sectionButton',
                            'data' => [
                                'title' => Yii::t('backend', 'Create Widget'),
                                'action' => Url::to(['/pages-widget/create', 'item_id' => $modelLng[$key]->id]),
                            ],
                        ]);
                        $tabcontent .= '</div></div>';
                    } else {
                        $tabcontent .= '<div class="row"><div class="col-xs-12"><div class="box"><div class="box-body">';
                        $tabcontent .= Yii::t('backend', 'Create Translate for this Language before Create Sections');
                        $tabcontent .= '</div></div></div></div>';
                    }
                    $tabcontent .= '</div>';
                }
            }
            ?>
            <ul class="nav nav-tabs" id="lngTabs">
                <?= $licontent ?>
            </ul>
            <div class="tab-content" id="lngTabContent">
                <?= $tabcontent ?>
            </div>
        </div>
    </div>
</div>
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
<div class="modal fade bs-example-modal-lg" id="modal-edit-section">
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
$url1 = Url::to(['/pages-section/index']);
$script = <<< JS
$("[id^='lng_sections_']").each(function(i,elem) {
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
            $('#lng_sections_' + data.item_id).load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        } else {
            alert( "Request failed");
        }
    });
});
$(document).on('click', '.sectionButton', function() {
    var data = $(this).data(),
        modal = $('#modal-edit-section');
    modal.find('.modal-title').text(data.title);
    modal.find('.modal-body').load(data.action);
    modal.modal('show');
});
$(document).on('submit', '#presection-form', function(e) {
    e.preventDefault();
    var form = $(this),
        data = $(this).data(),
        modal = $('#modal-edit-section');
    $.post(
        form.attr("action"),
        form.serialize(),
    )
    .done(function(result) {
        modal.find('.modal-title').text(data.title);
        modal.find('.modal-body').html(result);
    });
    return true;
});
$(document).on('submit', '#section-form', function(e) {
    e.preventDefault();
    var form = $(this),
        data = $(this).data(),
        modal = $('#modal-edit-section');
    $.post(
        form.attr("action"),
        form.serialize()
    )
    .done(function(result) {
        if (result.success) {
            modal.find('.modal-title').text('');
            modal.find('.modal-body').html('');
            modal.modal('hide');
            $('#lng_sections_' + data.item_id).load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        }
    });
    return true;
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>