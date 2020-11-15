<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\Swiper
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = Yii::t('backend', 'Slider') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php if (Yii::$app->user->can('deletePages')) { ?>
                    <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'title',
                        'description',
                        [
                            'attribute' => 'player',
                            'value' => Html::tag('span', Yii::$app->formatter->asBoolean($model->player), ['class' => 'label label-' . (($model->player) ? 'success' : 'danger')]),
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'published',
                            'value' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['unpublish', 'id' => $data->id],
                                        [
                                            'class' => 'btn btn-xs btn-success',
                                            'data-method' => 'post',
                                        ]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['publish', 'id' => $data->id],
                                    [
                                        'class' => 'btn btn-xs btn-danger',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-picture-o"></i> <?= Yii::t('backend', 'Slides') ?></h2>
<div class="row">
    <div class="col-xs-12" id="slides" data-item_id="<?= $model->id ?>"></div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::button(Yii::t('backend', 'Create Slide'), [
                    'class' => 'btn btn-primary slideButton',
                    'data' => [
                        'title' => Yii::t('backend', 'Create Slide'),
                        'action' => Url::to(['/swiper-slides/create', 'item_id' => $model->id]),
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modal-edit-slide">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= Yii::t('backend', 'Close') ?>">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<?php
$url1 = Url::to(['/swiper-slides/index']);
$script = <<< JS
$("#slides").each(function(i,elem) {
    var data = $(this).data();
    $(this).load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
});
$(document).on('click', '.actionButton', function(e) {
    e.preventDefault();
    var data = $(this).data();
    $.ajax({
        type: "POST",
        url: data.url,
        data: {id: data.id},
        cache: false
    })
    .done(function(result) {
        if (result) {
            $('#slides').load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        } else {
            alert( "Request failed");
        }
    });
});
$(document).on('click', '.slideButton', function() {
    var data = $(this).data(),
        modal = $('#modal-edit-slide');
    modal.find('.modal-title').text(data.title);
    modal.find('.modal-body').load(data.action);
    modal.modal('show');
});
$(document).on('submit', '#slide-form', function() {
    var form = $(this),
        data = $(this).data(),
        modal = $('#modal-edit-slide');
    $.post(
        form.attr("action"),
        form.serialize()
    )
    .done(function(result) {
        if (result.success) {
            modal.modal('hide');
            modal.find('.modal-title').text('');
            modal.find('.modal-body').text('');
            $('#slides').load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        }
    });
    return false;
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>