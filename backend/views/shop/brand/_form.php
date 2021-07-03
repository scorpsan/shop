<?php
/**
 * @var $this           yii\web\View
 * @var $form           yii\widgets\ActiveForm
 * @var $model          backend\models\ShopBrands
 * @var $modelLng       backend\models\ShopBrandsLng
 * @var $languages      backend\models\Language
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
mihaildev\elfinder\Assets::noConflict($this);
?>
<?php $form = ActiveForm::begin(); ?>
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
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng")->hiddenInput(['value' => $key])->label(false);
                } else {
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title", ['enableClientValidation' => false]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                }
                $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                $tabcontent .= $form->field($modelLng[$key], "[$key]country");
                $tabcontent .= $form->field($modelLng[$key], "[$key]content")->widget(CKEditor::class, [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'path' => '@files',
                        'allowedContent' => true,
                        'removePlugins' => 'forms,about',
                    ]),
                ]);
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
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'published')->checkbox() ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'logo')->widget(InputFile::class, [
                    'controller'    => 'elfinder',
                    'filter'        => 'image',
                    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options'       => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'multiple'      => false
                ]) ?>

                <?= $form->field($model, 'breadbg')->widget(InputFile::class, [
                    'controller'    => 'elfinder',
                    'filter'        => 'image',
                    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options'       => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'multiple'      => false
                ]) ?>
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