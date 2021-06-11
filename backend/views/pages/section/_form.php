<?php
/**
 * @var $model          backend\models\PagesSection
 * @var $sortingList    array
 */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;

mihaildev\elfinder\Assets::noConflict($this);
?>
<?php $form = ActiveForm::begin([
    'id' => 'section-form',
    'action' => Url::to(),
    'options' => [
        'data' => [
            'item_id' => $model->item_id,
        ],
    ],
]); ?>
    <?= Html::activeHiddenInput($model, 'item_id') ?>
    <?= Html::activeHiddenInput($model, 'widget') ?>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'published')->checkbox() ?>
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
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'show_title')->checkbox() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'style')->dropDownList(Yii::$app->params['sectionStyle']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'parallax', ['options' => ['class' => 'hidden']])->checkbox() ?>

            <?= $form->field($model, 'background')->widget(InputFile::class, [
                'controller'    => 'elfinder',
                'filter'        => 'image',
                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control'],
                'buttonOptions' => ['class' => 'btn btn-default'],
                'multiple'      => false
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'text_align')->dropDownList(Yii::$app->params['textAlignList'], [
                'prompt' => Yii::t('backend', 'Template default...'),
            ]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'content')->widget(CKEditor::class,[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'full',
                    'path' => '/files',
                    'allowedContent' => true,
                    'removePlugins' => 'forms,about',
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