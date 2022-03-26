<?php
/**
 * @var $this           yii\web\View
 * @var $form           yii\widgets\ActiveForm
 * @var $model          backend\models\ShopDelivery
 * @var $modelLng       backend\models\ShopDeliveryLng
 * @var $languages      backend\models\Language
 */

use backend\models\ShopPayment;
use yii\helpers\Html;
use kartik\form\ActiveForm;
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
                $tabcontent .= $form->field($modelLng[$key], "[$key]desc")->textarea();
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
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'min_weight')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'max_weight')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'min_summa')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'max_summa')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'payment_list')->listBox(ShopPayment::listAll(), [
                    'multiple' => true,
                    'size' => 5,
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <?= $form->field($model, 'id')->textInput(['readonly' => 'readonly']) ?>

                <?= $form->field($model, 'published')->checkbox() ?>

                <?= $form->field($model, 'pickup')->checkbox() ?>

                <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
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