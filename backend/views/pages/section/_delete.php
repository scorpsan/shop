<?php
/* @var $model      backend\models\PagesSection */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'section-form',
    'action' => \yii\helpers\Url::to(),
    'options' => [
        'data' => [
            'item_id' => $model->item_id,
        ],
    ],
]); ?>
    <?= Html::activeHiddenInput($model, 'delete', ['value' => true]) ?>
    <div class="row">
        <div class="col-xs-12">
            <h3><?= Yii::t('backend', 'Are you sure you want to delete this item?') ?></h3>
        </div>
    </div>
<?php if (Yii::$app->request->isAjax) { ?>
    <div class="modal-footer" style="padding-left:0;padding-right:0;">
        <?= Html::button(Yii::t('backend', 'Cancel'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton(Yii::t('backend', 'Delete'), ['class' => 'btn btn-danger']) ?>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-xs-12">
            <?= Html::a(Yii::t('backend', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton(Yii::t('backend', 'Delete'), ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
<?php } ?>
<?php ActiveForm::end(); ?>