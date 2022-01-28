<?php
/**
 * @var $model          \backend\models\ShopProducts
 * @var $modelLng       \backend\models\ShopProductsLng
 * @var $languages      \backend\models\Language
 * @var $parentList     array
 * @var $sortingList    array
 * @var $brandList      array
 * @var $modelParams    \backend\models\ShopProductsCharacteristics
 * @var $paramsList     ShopCharacteristics
 */

use backend\models\ShopCharacteristics;
use dosamigos\selectize\SelectizeTextInput;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\file\FileInput;
use yii\web\JsExpression;

mihaildev\elfinder\Assets::noConflict($this);
$this->registerJs('
$("document").ready(function(){
    $("select.select2").select2({
        tags: true
    });
});
');
?>
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-9">
        <?php if (!empty($languages)) {
            $count = count($languages);
            $licontent = '';
            $tabcontent = '';
            if ($count > 1) { ?>
                <h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
                <p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
            <?php }
            foreach ($languages as $key => $lang) {
                if ($count > 1) {
                    if ($lang->default) {
                        $licontent .= '<li class="active"><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                        $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade active in" role="tabpanel">';
                    } else {
                        $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                        $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';
                    }
                }
                if ($lang->default) {
                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id")->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng")->hiddenInput(['value' => $key])->label(false);
                } else {
                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title", ['enableClientValidation' => false]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                }
                $tabcontent .= $form->field($modelLng[$key], "[$key]short_content")->textarea(['rows' => 8]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]content")->widget(CKEditor::class, [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'path' => '@files',
                        'allowedContent' => true,
                        'removePlugins' => 'forms,about',
                    ]),
                ]);
                $tabcontent .= '<h2 class="page-header"><i class="fa fa-paperclip"></i> ' . Yii::t('backend', 'Product Characteristics') . '</h2>';
                $tabcontent .= $form->field($modelParams[$key], "[$key]product_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                $tabcontent .= $form->field($modelParams[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                $tabcontent .= '<div class="row">';
                foreach ($paramsList as $params) {
                    $tabcontent .= '<div class="col-sm-3">';
                    switch ($params->type) {
                        case 'boolean':
                            $tabcontent .= $form->field($modelParams[$key], "[$key]$params->alias")->checkbox()->label($params->title);
                            break;
                        case 'char':
                        case 'string':
                            $dropList = ShopCharacteristics::DropList($params->alias);
                            $tabcontent .= $form->field($modelParams[$key], "[$key]$params->alias")->dropDownList($dropList, [
                                'class' => 'select2',
                                'prompt' => Yii::t('backend', 'Choose or enter new value...'),
                            ])->label($params->title);
                            break;
                        case 'smallint':
                        case 'integer':
                        case 'float':
                        default:
                            $tabcontent .= $form->field($modelParams[$key], "[$key]$params->alias")->textInput()->label($params->title);
                    }
                    $tabcontent .= '</div>';
                }
                $tabcontent .= '</div>';
                $tabcontent .= '<hr><h2 class="page-header"><i class="fa fa-internet-explorer"></i> ' . Yii::t('backend', 'SEO') . '</h2>';
                $tabcontent .= $form->field($modelLng[$key], "[$key]seotitle");
                $tabcontent .= $form->field($modelLng[$key], "[$key]keywords");
                $tabcontent .= $form->field($modelLng[$key], "[$key]description");
                $tabcontent .= $form->field($modelLng[$key], "[$key]seo_text")->widget(CKEditor::class, [
                    'editorOptions' => [
                        'allowedContent' => true,
                        'toolbar' => [
                            ['Source'],
                            ['Undo', 'Redo'],
                            ['Format'],
                            ['Bold', 'Italic', 'Underline'],
                        ],
                    ],
                ]);
                if ($count > 1) {
                    $tabcontent .= '</div>';
                }
            } ?>
            <?php if ($count > 1) { ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="lngTabs">
                        <?= $licontent ?>
                    </ul>
                    <div class="tab-content" id="lngTabContent">
                        <?= $tabcontent ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="box">
                    <div class="box-body">
                        <?= $tabcontent ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>

                <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'published')->checkbox() ?>

                <?= $form->field($model, 'in_stock')->checkbox() ?>

                <?= $form->field($model, 'top')->checkbox() ?>

                <?= $form->field($model, 'new')->checkbox() ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'sale')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'category_id')->dropDownList($parentList, [
                    'options' => [
                        $model->id => ['Disabled' => true],
                    ]
                ]) ?>

                <?= $form->field($model, 'brand_id')->dropDownList($brandList, [
                    'prompt' => Yii::t('backend', 'Choose Brand...'),
                ]) ?>

                <?= $form->field($model, 'sorting')->dropDownList($sortingList, [
                    'options' => [
                        $model->sort => ['Disabled' => true],
                    ],
                ]) ?>
                <hr>
                <?= $form->field($model, 'created_at', ['enableClientValidation' => false])->widget(DateTimePicker::class, [
                    'options' => [
                        'placeholder' => Yii::t('backend', 'Select date and time...'),
                        'value' => $model->created_at ? Yii::$app->formatter->asDatetime($model->created_at) : '',
                    ],
                    'convertFormat' => true,
                    'removeButton' => false,
                    //'disabled' => true,
                    'pluginOptions' => [
                        'format' => Yii::$app->formatter->datetimeFormat,
                        'startDate' => '01-01-2018 00:00',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'todayBtn'=>true,
                    ],
                ]) ?>
                <?= $form->field($model, 'updated_at', ['enableClientValidation' => false])->widget(DateTimePicker::class, [
                    'options' => [
                        'placeholder' => Yii::t('backend', 'Select date and time...'),
                        'value' => $model->updated_at ? Yii::$app->formatter->asDatetime($model->updated_at) : '',
                    ],
                    'convertFormat' => true,
                    'removeButton' => false,
                    'disabled' => true,
                    'pluginOptions' => [
                        'format' => Yii::$app->formatter->datetimeFormat,
                        'startDate' => '01-01-2018 00:00',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'todayBtn'=>true,
                    ],
                ]) ?>
                <hr>
                <h2 class="page-header"><i class="fa fa-tags"></i> <?= Yii::t('backend', 'Tags') ?></h2>
                <?= $form->field($model, 'tagNames')->widget(SelectizeTextInput::class, [
                    // calls an action that returns a JSON object with matched
                    // tags
                    'loadUrl' => ['tag/list'],
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'plugins' => ['remove_button'],
                        'valueField' => 'name',
                        'labelField' => 'name',
                        'searchField' => ['name'],
                        'create' => true,
                    ],
                ])->hint(Yii::t('backend', 'Use commands to separate tags')) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <h2 class="page-header"><i class="fa fa-image"></i> <?= Yii::t('backend', 'Images') ?></h2>
        <?php if ($model->id) { ?>
            <div class="box">
                <div class="box-body">
                    <?= FileInput::widget([
                        'name' => 'ShopPhotos[attachment]',
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'uploadUrl' => Url::to(['upload-file']),
                            'deleteUrl' => Url::to(['delete-file']),
                            'uploadExtraData' => [
                                'ShopPhotos[product_id]' => $model->id,
                            ],
                            'maxFileCount' => 20,
                            //'showCaption' => false,
                            'showRemove' => false,
                            //'showUpload' => false,
                            'showClose' => false,
                            //'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  Yii::t('backend', 'Select Photo'),
                            'initialPreview'=> $model->imagesLinks,
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => false,
                            'initialPreviewConfig' => $model->imagesLinksData,
                            'initialPreviewCount' => true,
                        ],
                        'pluginEvents' => [
                            'filesorted' => new JsExpression('function(event, params) {
                                $.post("'. Url::to(['sort-file']) . '",{id: ' . $model->id . ', sort: params});
                            }')
                        ],
                    ]) ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="box">
                <div class="box-body">
                    <?= Yii::t('backend', 'Save this before Upload Images') ?>
                </div>
            </div>
        <?php } ?>
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