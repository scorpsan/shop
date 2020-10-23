<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

if ($model->id) $item_id = $model->id; else $item_id = 0;
$this->registerJs('
$("document").ready(function(){
    $("select#menus-parent_id").trigger("change");
    $("select#menus-url").trigger("change");
    $("select#menus-url").select2({
        tags: true
    });
});
');
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'parent_id')->dropDownList($parentList, [
                            'options' => [
                                $model->id => ['Disabled' => true],
                            ],
                            'onchange' => '$.post("'.Url::to(['/menus/lists']).'", {id: $(this).val(), item_id: '.$item_id.'}, function (resp) {
                                $("select#menus-sorting").html( resp );
                            });',
                        ]) ?>

                        <?= $form->field($model, 'sorting')->dropDownList([]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'published')->checkbox() ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'url')->dropDownList($listUrls, [
                            'prompt' => Yii::t('backend', 'Choose...'),
                            'onchange' => '$.post("'.Url::to(['/menus/params']).'", {url: $(this).val(), item_id: '.$item_id.'}, function (resp) {
                                $("#urlParams").html( resp );
                            });',
                        ]) ?>
                        <div id="urlParams">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'target_blank')->checkbox() ?>

                        <?= $form->field($model, 'anchor')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'access')->dropDownList($available_roles, [
                    'prompt' => Yii::t('backend', 'Choose...')
                ]) ?>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
<p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <?php
            $licontent = '';
            $tabcontent = '';
            foreach ($languages as $key => $lang) {
                if ($lang->default) {
                    $licontent .= '<li class="active"><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade active in" role="tabpanel">';

                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title");

                    $tabcontent .= '</div>';
                } else {
                    $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';

                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title", ['enableClientValidation' => false]);

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