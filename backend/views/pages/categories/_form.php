<?php
/**
 * @var $model          backend\models\Categories
 * @var $modelLng       backend\models\CategoriesLng
 * @var $languages      backend\models\Language
 * @var $parentList     array
 * @var $clearRoot      bool
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
mihaildev\elfinder\Assets::noConflict($this);

if ($model->id) $item_id = $model->id; else $item_id = 0;
$rootOptions = [];
if ($model->depth == 0 && $model->alias == 'pages') {
    $rootOptions = ['readonly' => 'readonly'];
}
$this->registerJs('
$("document").ready(function(){
    $("select#categories-parent_id").trigger("change");
    //$("select#pages-page_style").trigger("change");
});
');
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
                    $tabcontent .= $form->field($modelLng[$key], "[$key]breadbg")->widget(InputFile::class, [
                        'controller' => 'elfinder',
                        'filter' => 'image',
                        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options' => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple' => false
                    ]);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]content")->widget(CKEditor::class, [
                        'editorOptions' => ['allowedContent' => true,],
                    ]);
                    $tabcontent .= '<hr><h2 class="page-header"><i class="fa fa-internet-explorer"></i> ' . Yii::t('backend', 'SEO') . '</h2>';
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seotitle");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]keywords");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]description");
                    $tabcontent .= $form->field($modelLng[$key], "[$key]seo_text")->textarea();
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

                    <?= $form->field($model, 'noindex')->checkbox() ?>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <?= $form->field($model, 'parent_id')->dropDownList($parentList, array_merge($rootOptions, [
                        'options' => [
                            $model->id => ['Disabled' => true],
                        ],
                        'onchange' => '
                        $.post("'.Url::to(['/pages/categories/lists']).'", {id: $(this).val(), item_id: '.$item_id.'}, function (resp) {
                            $("select#categories-sorting").html( resp );
                        });',
                    ])) ?>

                    <?= $form->field($model, 'sorting')->dropDownList([], $rootOptions) ?>

                    <?= $form->field($model, 'page_style')->dropDownList(ArrayHelper::map(Yii::$app->params['categoryStyle'], 'key', 'title'), [
                        'onchange' => '
                                //$("div[class*=-breadbg]").addClass("hidden");
                                //if ($(this).val() > 5) {
                                    //$("div[class*=-breadbg]").removeClass("hidden");
                                //}'
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