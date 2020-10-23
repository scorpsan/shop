<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\Pages
 * @var $languages      backend\models\Language
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = Yii::t('backend', 'Pages') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
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
                        [
                            'attribute' => 'category_id',
                            'value' => (isset($model->category))
                                ? $model->category->title
                                : '',
                        ],
                        'alias',
                        [
                            'attribute' => 'published',
                            'value' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['/pages/unpublish', 'id' => $data->id],
                                        [
                                            'class' => 'btn btn-xs btn-success',
                                            'data-method' => 'post',
                                        ]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['/pages/publish', 'id' => $data->id],
                                    [
                                        'class' => 'btn btn-xs btn-danger',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'main',
                            'value' => Html::tag('span', Yii::$app->formatter->asBoolean($model->main), ['class' => 'label label-' . ($model->main) ? 'success' : 'danger']),
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => Yii::$app->formatter->asDatetime($model->created_at),
                            'format' => 'ntext',
                        ],
                        [
                            'attribute' => 'updated_at',
                            'value' => Yii::$app->formatter->asDatetime($model->updated_at),
                            'format' => 'ntext',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
<p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <?php
            $licontent = '';
            $tabcontent = '';
            foreach ($languages as $key => $lang) {
                if ($lang->default) {
                    $licontent .= '<li class="active"><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade active in" role="tabpanel">';
                } else {
                    $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';
                }
                if (!empty($model->translates[$key])) {
                    $tabcontent .= DetailView::widget([
                        'model' => $model->translates[$key],
                        'attributes' => [
                            'title',
                            'seotitle:ntext',
                            'description:ntext',
                            'keywords:ntext',
                            'seo_text:html'
                        ],
                    ]);
                    $tabcontent .= '<div class="row"><div class="col-xs-12"><h3 class="box-title">' . Yii::t('backend', 'Sections') . '</h3></div></div>';
                    $tabcontent .= '<div class="row"><div class="col-xs-12" id="lng_sections_' . $model->translates[$key]->id . '" data-item_id="' . $model->translates[$key]->id . '">';
                    $tabcontent .= '</div></div>';
                    $tabcontent .= '<div class="row"><div class="col-xs-12">';
                    $tabcontent .= Html::button(Yii::t('backend', 'Create Section'), [
                        'class' => 'btn btn-primary sectionButton',
                        'data' => [
                            'title' => Yii::t('backend', 'Create Section'),
                            'action' => Url::to(['/pages-section/create', 'item_id' => $model->translates[$key]->id]),
                        ],
                    ]);
                    $tabcontent .= ' ' . Html::button(Yii::t('backend', 'Create Widget'), [
                        'class' => 'btn btn-primary sectionButton',
                        'data' => [
                            'title' => Yii::t('backend', 'Create Widget'),
                            'action' => Url::to(['/pages-widget/create', 'item_id' => $model->translates[$key]->id]),
                        ],
                    ]);
                    $tabcontent .= '</div></div>';
                } else {
                    $tabcontent .= Yii::t('backend', 'Translate Not Found...');
                }
                $tabcontent .= '</div>';
            }
            ?>
            <ul class="nav nav-tabs" id="lngTabs">
                <?= $licontent ?>
            </ul>
            <div class="tab-content" id="lngTabContent">
                <?= $tabcontent ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modal-edit-section">
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
$url1 = Url::to(['/pages-section/index']);
$script = <<< JS
$("[id^='lng_sections_']").each(function(i,elem) {
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
            $('#lng_sections_' + data.item_id).load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        } else {
            alert( "Request failed");
        }
    });
});
$(document).on('click', '.sectionButton', function() {
    var data = $(this).data(),
        modal = $('#modal-edit-section');
    modal.find('.modal-title').text(data.title);
    modal.find('.modal-body').load(data.action);
    modal.modal('show');
});
$(document).on('submit', '#presection-form', function(e) {
    e.preventDefault();
    var form = $(this),
        data = $(this).data(),
        modal = $('#modal-edit-section');
    $.post(
        form.attr("action"),
        form.serialize(),
    )
    .done(function(result) {
        modal.find('.modal-title').text(data.title);
        modal.find('.modal-body').html(result);
    });
    return true;
});
$(document).on('submit', '#section-form', function(e) {
    e.preventDefault();
    var form = $(this),
        data = $(this).data(),
        modal = $('#modal-edit-section');
    $.post(
        form.attr("action"),
        form.serialize()
    )
    .done(function(result) {
        if (result.success) {
            modal.find('.modal-title').text('');
            modal.find('.modal-body').html('');
            modal.modal('hide');
            $('#lng_sections_' + data.item_id).load('${url1}?item_id=' + data.item_id + '&uid=' + (new Date()).getTime());
        }
    });
    return true;
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>