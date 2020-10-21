<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
mihaildev\elfinder\Assets::noConflict($this);

if ($model->id) $item_id = $model->id; else $item_id = 0;
$this->registerJs('
$("document").ready(function(){
    $("select#categories-parent_id").trigger("change");
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

                        <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'parent_id')->dropDownList($parentList, [
                            'options' => [
                                $model->id => ['Disabled' => true],
                            ],
                            'onchange' => '
                                $.post("'.Url::to(['/pages-categories/lists']).'", {id: $(this).val(), item_id: '.$item_id.'}, function (resp) {
                                    $("select#categories-sorting").html( resp );
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
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]content")->widget(CKEditor::className(), [
                        'editorOptions' => ['allowedContent' => true,],
                    ]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]img")->widget(InputFile::className(), [
                        'controller'    => 'elfinder',
                        'filter'        => 'image',
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false
                    ]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seo_title");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]keywords");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]description");

                    $tabcontent .= '</div>';
                } else {
                    $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';

                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title", ['enableClientValidation' => false]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]content")->widget(CKEditor::className(), [
                        'editorOptions' => ['allowedContent' => true,],
                    ]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]img")->widget(InputFile::className(), [
                        'controller'    => 'elfinder',
                        'filter'        => 'image',
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false
                    ]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seo_title");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]keywords");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]description");

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