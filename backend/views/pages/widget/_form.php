<?php
/**
 * @var $model          backend\models\PagesSection
 * @var $sortingList    array
 */
use backend\models\PagesSection;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\elfinder\InputFile;
mihaildev\elfinder\Assets::noConflict($this);

if ($model->scenario === PagesSection::SCENARIO_WIDGET1) {
    $form = ActiveForm::begin([
        'id' => 'presection-form',
        'action' => \yii\helpers\Url::to(),
        'options' => [
            'data' => [
                'item_id' => $model->item_id,
                'title' => Yii::t('backend', 'Create Widget'),
            ],
        ],
    ]);
} elseif ($model->scenario === PagesSection::SCENARIO_WIDGET2) {
    $form = ActiveForm::begin([
        'id' => 'section-form',
        'action' => \yii\helpers\Url::to(),
        'options' => [
            'data' => [
                'item_id' => $model->item_id,
            ],
        ],
    ]);
} ?>
<?= Html::activeHiddenInput($model, 'item_id') ?>
<?= Html::activeHiddenInput($model, 'widget') ?>
<?php if ($model->scenario === PagesSection::SCENARIO_WIDGET1) { ?>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'widget_type')->dropDownList(\yii\helpers\ArrayHelper::map(Yii::$app->params['widgetsList'], 'id', 'title'), ['prompt' => Yii::t('backend', 'Choose Widget...')]) ?>
        </div>
    </div>
    <?php if (Yii::$app->request->isAjax) { ?>
        <div class="modal-footer" style="padding-left:0;padding-right:0;">
            <?= Html::button(Yii::t('backend', 'Cancel'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) ?>

            <?= Html::submitButton(Yii::t('backend', 'Next'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-xs-12">
                <?= Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>

                <?= Html::submitButton(Yii::t('backend', 'Next'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php } ?>
<?php } elseif ($model->scenario === PagesSection::SCENARIO_WIDGET2) { ?>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'widget_type')->dropDownList(\yii\helpers\ArrayHelper::map(Yii::$app->params['widgetsList'], 'id', 'title'), ['prompt' => Yii::t('backend', 'Choose Widget...'), 'disabled' => true]) ?>
        </div>
        <div class="col-xs-12">
            <?php
            if (isset($model->widget_type)) {
                $widgetParams = Yii::$app->params['widgetsList'][$model->widget_type]['params'];
            } else {
                $widgetParams = array();
            }
            $fieldOption = array();
            if (isset($widgetParams['show_title']) && !$widgetParams['show_title']) {
                $fieldOption = ['options' => ['class' => 'hidden']];
                if (!isset($model->title)) {
                    $model->title = Yii::$app->params['widgetsList'][$model->widget_type]['title'];
                }
            } ?>
            <?= $form->field($model, 'title', $fieldOption)->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'published')->checkbox() ?>
        </div>
        <div class="col-sm-6">
            <?php
            $keys = array_keys($sortingList);
            $found_index = array_search($model->sort, $keys);
            if (!($found_index === false || $found_index === 0)) {
                $model->sorting = $keys[$found_index - 1];
            } else {
                $model->sorting = 'last';
            } ?>
            <?= $form->field($model, 'sorting')->dropDownList($sortingList, [
                'options' => [
                    $model->sort => ['Disabled' => true],
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?php
            if (isset($widgetParams['show_title']) && !$widgetParams['show_title']) {
                echo $form->field($model, 'show_title', ['options' => ['class' => 'hidden']])->checkbox();
            } else {
                echo $form->field($model, 'show_title')->checkbox();
            } ?>
        </div>
        <div class="col-sm-6">
            <?php
            if (isset($widgetParams['style']) && !$widgetParams['style']) {
                echo $form->field($model, 'style', ['options' => ['class' => 'hidden']])->dropDownList(Yii::$app->params['sectionStyle']);
            } else {
                echo $form->field($model, 'style')->dropDownList(Yii::$app->params['sectionStyle']);
            } ?>
        </div>
        <div class="col-sm-6">
            <?php
            if (isset($widgetParams['parallax']) && !$widgetParams['parallax']) {
                echo $form->field($model, 'parallax', ['options' => ['class' => 'hidden']])->checkbox();
            } else {
                echo $form->field($model, 'parallax')->checkbox();
            } ?>

            <?php
            $fieldOption = array();
            if (isset($widgetParams['background']) && !$widgetParams['background']) {
                $fieldOption = ['options' => ['class' => 'hidden']];
            } ?>
            <?= $form->field($model, 'background', $fieldOption)->widget(InputFile::className(), [
                'controller'    => 'elfinder',
                'filter'        => 'image',
                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control'],
                'buttonOptions' => ['class' => 'btn btn-default'],
                'multiple'      => false
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?php
            $fieldOption = array();
            if (isset($widgetParams['text_align']) && !$widgetParams['text_align']) {
                $fieldOption = ['options' => ['class' => 'hidden']];
            } ?>
            <?= $form->field($model, 'text_align', $fieldOption)->dropDownList(Yii::$app->params['textAlignList'], [
                'prompt' => Yii::t('backend', 'Template default...'),
            ]) ?>
        </div>
        <?php if (!empty(Yii::$app->params['widgetsList'][$model->widget_type]['options'])) { ?>
            <div class="col-xs-12">
                <label class="control-label has-star" for="pagessection-widget_params"><?= Yii::t('backend', 'Widget Params') ?></label>
                <?php
                foreach (Yii::$app->params['widgetsList'][$model->widget_type]['options'] as $key => $option) {
                    if (isset($option['dropList']))
                        echo $form->field($model, 'widget_params['.$key.']')->dropDownList($option['dropList'], ['prompt' => $option['title']])->label($option['title']);
                    elseif (isset($option['text']))
                        echo $form->field($model, 'widget_params['.$key.']')->textInput()->label($option['title']);
                } ?>
            </div>
        <?php } ?>
    </div>
    <?php if (Yii::$app->request->isAjax) { ?>
        <div class="modal-footer" style="padding-left:0;padding-right:0;">
            <?= Html::button(Yii::t('backend', 'Cancel'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) ?>

            <?php if (!$model->id) { ?>
            <?= Html::button(Yii::t('backend', 'Back'), [
                'class' => 'btn btn-primary sectionButton',
                'data' => [
                    'title' => Yii::t('backend', 'Create Widget'),
                    'action' => \yii\helpers\Url::to(['/pages/widget/create', 'item_id' => $model->item_id]),
                ],
            ]) ?>
            <?php } ?>

            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-xs-12">
                <?= Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>

                <?= Html::a(Yii::t('backend', 'Back'), ['index'], ['class' => 'btn btn-primary']) ?>

                <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php
ActiveForm::end();