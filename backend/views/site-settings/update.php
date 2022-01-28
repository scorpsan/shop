<?php
/**
 * @var $model          \backend\models\SiteSettings
 * @var $modelLng       \backend\models\SiteSettingsLng
 * @var $languages      \backend\models\Language
 * @var $parentList     array
 * @var $clearRoot      bool
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\elfinder\InputFile;

$this->title = Yii::t('backend', 'Update') . ' ' . Yii::t('backend', 'Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<h2 class="page-header"><i class="fa fa-address-card"></i> <?= Yii::t('backend', 'Contact Information') ?></h2>
<?php if (!empty($languages)) {
    $count = count($languages);
    $licontent = '';
    $tabcontent = '';
    if ($count > 1) { ?>
        <p><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></p>
        <p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <?php
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
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng")->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title")->textInput(['maxlength' => true]);
                } else {
                    $tabcontent .= $form->field($modelLng[$key], "[$key]item_id", ['enableClientValidation' => false])->hiddenInput(['value' => $model->id])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]lng", ['enableClientValidation' => false])->hiddenInput(['value' => $key])->label(false);
                    $tabcontent .= $form->field($modelLng[$key], "[$key]title", ['enableClientValidation' => false])->textInput(['maxlength' => true]);
                }
                $tabcontent .= $form->field($modelLng[$key], "[$key]logo_b")->widget(InputFile::class, [
                    'controller' => 'elfinder',
                    'filter' => 'image',
                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'multiple' => false
                ]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]logo_w")->widget(InputFile::class, [
                    'controller' => 'elfinder',
                    'filter' => 'image',
                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'multiple' => false
                ]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]seotitle")->textInput(['maxlength' => true]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]description")->textInput(['maxlength' => true]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]keywords")->textInput(['maxlength' => true]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]about_footer")->textarea(['rows' => 6]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]logo_footer")->widget(InputFile::class, [
                    'controller' => 'elfinder',
                    'filter' => 'image',
                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'multiple' => false
                ]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]opening_hours")->textInput(['maxlength' => true]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]opening_hours_full")->textarea(['maxlength' => true, 'rows' => 4]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]contact_info")->textarea(['rows' => 6]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]address")->textarea(['maxlength' => true, 'rows' => 4]);
                $tabcontent .= $form->field($modelLng[$key], "[$key]address_map")->textarea(['maxlength' => true, 'rows' => 4]);
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
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'admin_email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'support_email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'contact_phone')->textarea(['maxlength' => true, 'rows' => 3]) ?>

                        <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'viber_phone')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'whatsapp_phone')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'telegram_nick')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'skype_nick')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-map"></i> <?= Yii::t('backend', 'Map') ?></h2>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'long_map')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'lat_map')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-share-square"></i> <?= Yii::t('backend', 'Social Links') ?></h2>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'link_to_facebook')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'link_to_youtube')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'link_to_vk')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'link_to_pinterest')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'link_to_twitter')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'link_to_instagram')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'instagram_token')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-file-code"></i> <?= Yii::t('backend', 'Custome CSS Style') ?></h2>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'custom_style')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
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