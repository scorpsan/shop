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

$this->title = Yii::t('backend', 'Payment Methods');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?= Html::a(Yii::t('backend', 'Create Payment Method'), ['create'], ['class' => 'btn btn-success']) ?>
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
                            'attribute' => 'title',
                            'label' => Yii::t('backend', 'Title'),
                            'value' => function($data) {
                                return Html::a(Html::encode($data->title), ['update', 'id' => $data->id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'description',
                            'label' => Yii::t('backend', 'Description'),
                            'value' => function($data) {
                                return Html::encode($data->description);
                            },
                            'format' => 'raw',
                        ],
                        'className',
                        [
                            'attribute' => 'updown',
                            'label' => false,
                            'value' => function($data) {
                                $content = '';
                                if (!$data->getIsFirst())
                                    $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', ['up', 'id' => $data->id], ['class' => 'ajaxAction']);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                $content .= ' / ';
                                if (!$data->getIsLast())
                                    $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', ['down', 'id' => $data->id], ['class' => 'ajaxAction']);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                return $content;
                            },
                            'headerOptions' => ['width' => '60'],
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
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['unpublish', 'id' => $data->id],
                                        ['class' => 'btn btn-xs btn-success btn-block ajaxAction',]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['publish', 'id' => $data->id],
                                    ['class' => 'btn btn-xs btn-danger btn-block ajaxAction',]
                                );
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'raw',
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