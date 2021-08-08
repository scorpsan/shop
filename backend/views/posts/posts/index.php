<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $languages      \backend\models\Language
 */
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\TranslatesDataColumn;
use backend\components\grid\CombinedDataColumn;

$this->title = Yii::t('backend', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive">
                <?php Pjax::begin(['id' => 'pjax-grid']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['width' => '60'],
                        ],
                        [
                            'attribute' => 'image',
                            'value' => function($data) {
                                return $data->image;
                            },
                            'headerOptions' => ['width' => '94'],
                            'format' => ['image', ['width' => '74']],
                        ],
                        [
                            'attribute' => 'title',
                            'label' => Yii::t('backend', 'Title'),
                            'value' => function($data) {
                                return Html::a(Html::encode($data->title), ['update', 'id' => $data->id]) . '<br>(alias: ' . $data->alias . ')';
                            },
                            'headerOptions' => ['width' => '200'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'category_id',
                            'label' => Yii::t('backend', 'Category'),
                            'value' => function($data) {
                                return (isset($data->category_id)) ? $data->category->title : '';
                            },
                            'headerOptions' => ['width' => '200'],
                            'format' => 'raw',
                        ],
                        [
                            'class' => TranslatesDataColumn::class,
                            'attribute' => 'translates',
                            'label' => Yii::t('backend', 'Translate'),
                            'format' => 'html',
                            'visible' => (count($languages) > 1),
                        ],
                        [
                            'attribute' => 'noindex',
                            'content' => function($data) {
                                return Html::tag('span', Yii::$app->formatter->asBoolean($data->noindex), ['class' => 'label label-' . (($data->noindex) ? 'danger' : 'success')]);
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['unpublish', 'id' => $data->id],
                                        ['class' => 'btn btn-xs btn-success btn-block ajaxAction']
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['publish', 'id' => $data->id],
                                    ['class' => 'btn btn-xs btn-danger btn-block ajaxAction']
                                );
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],
                        [
                            'attribute' => 'hit',
                            'headerOptions' => ['width' => '60'],
                        ],
                        [
                            'class' => CombinedDataColumn::class,
                            'labelTemplate' => '{0}  /  {1}',
                            'valueTemplate' => '{0}<br />{1}',
                            'labels' => [
                                Yii::t('backend', 'Created At'),
                                '[ '. Yii::t('backend', 'Updated At') .' ]',
                            ],
                            'attributes' => [
                                'created_at:html',
                                'updated_at:html',
                            ],
                            'values' => [
                                function ($data) {
                                    return Yii::$app->formatter->asDatetime($data->created_at);
                                },
                                function ($data) {
                                    return '[ '. Yii::$app->formatter->asDatetime($data->updated_at) .' ]';
                                },
                            ],
                            'sortLinksOptions' => [
                                ['class' => 'text-nowrap'],
                                ['class' => 'text-nowrap'],
                            ],
                            'headerOptions' => ['width' => '256'],
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '60'],
                            'template' => '{update} {delete}',
                            'visibleButtons' => [
                                'update' => Yii::$app->user->can('editPages'),
                                'delete' => Yii::$app->user->can('deletePages'),
                            ],
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'class' => 'ajaxDelete',
                                        'title' => Yii::t('backend', 'Delete')
                                    ]);
                                }
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
$.pjax.reload({container: '#pjax-grid'});
$(document).on('ready pjax:success', function () {
    $('.ajaxDelete').on('click', function (e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('href');
        bootbox.confirm('Are you sure you want to delete this item?', function (result) {
            if (result) {
                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    error: function (xhr, status, error) {
                        bootbox.alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function (data) {
                    $.pjax.reload({container: '#pjax-grid', timeout: false, async:false});
                });
            }
        });
    });
    $('.ajaxAction').on('click', function (e) {
        e.preventDefault();
        var actionUrl = $(this).attr('href');
        $.ajax({
            url: actionUrl,
            type: 'post',
            error: function (xhr, status, error) {
                bootbox.alert('There was an error with your request.' + xhr.responseText);
            }
        }).done(function (data) {
            $.pjax.reload({container: '#pjax-grid', timeout: false, async:false});
        });
    });
});
JS;
$this->registerJs($script, View::POS_READY);
?>