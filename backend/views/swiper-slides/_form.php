<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
mihaildev\elfinder\Assets::noConflict($this);
?>
<?php $form = ActiveForm::begin([
    'id' => 'slide-form',
    'action' => \yii\helpers\Url::to(),
    'options' => [
        'data' => [
            'item_id' => $model->item_id,
        ],
    ],
]); ?>
    <?= Html::activeHiddenInput($model, 'item_id') ?>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'published')->checkbox() ?>

            <?= $form->field($model, 'start_at', ['enableClientValidation' => false])->widget(DateTimePicker::classname(), [
                'options' => [
                    'placeholder' => Yii::t('backend', 'Select date and time...'),
                    'value' => $model->start_at ? Yii::$app->formatter->asDatetime($model->start_at) : '',
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
            <?= $form->field($model, 'end_at', ['enableClientValidation' => false])->widget(DateTimePicker::classname(), [
                'options' => [
                    'placeholder' => Yii::t('backend', 'Select date and time...'),
                    'value' => $model->end_at ? Yii::$app->formatter->asDatetime($model->end_at) : '',
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
        <div class="col-sm-6">
            <?php
            $keys = array_keys($sortingList);
            $found_index = array_search($model->sort, $keys);
            if (!($found_index === false || $found_index === 0))
                $model->sorting = $keys[$found_index-1];
            else
                $model->sorting = 'last';
            ?>

            <?= $form->field($model, 'sorting')->dropDownList($sortingList, [
                'options' => [
                    $model->sort => ['Disabled' => true],
                ],
            ]) ?>

            <?= $form->field($model, 'text_align')->dropDownList(Yii::$app->params['textAlignList'], [
                'prompt' => Yii::t('backend', 'Template default...'),
            ]) ?>

            <?= $form->field($model, 'style')->dropDownList(Yii::$app->params['sectionStyle']) ?>

            <?= $form->field($model, 'lng')->dropDownList($languages, [
                'prompt' => Yii::t('backend', 'Choose language...'),
            ]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'image')->widget(InputFile::className(), [
                'controller'    => 'elfinder',
                'filter'        => 'image',
                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control'],
                'buttonOptions' => ['class' => 'btn btn-default'],
                'multiple'      => false
            ]) ?>

            <?= $form->field($model, 'content')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'standart',
                    'inline' => false,
                    'path' => '/files',
                    'allowedContent' => true,
                ]),
            ]) ?>
        </div>
    </div>
<?php if (Yii::$app->request->isAjax) { ?>
    <div class="modal-footer" style="padding-left:0;padding-right:0;">
        <?= Html::button(Yii::t('backend', 'Cancel'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-xs-12">
            <?= Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php } ?>
<?php ActiveForm::end(); ?>