<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $languages      \backend\models\Language
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\TranslatesDataColumn;

$this->title = Yii::t('backend', 'Site Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?= Html::a(Yii::t('backend', 'Create Menu Item'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive">
                <?php Pjax::begin(['id' => 'admin-grid-view']); ?>
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
                                if ($data->depth != 0) {
                                    if ($data->fullUrl) {
                                        $urlinfo = '&nbsp;<span class="small">(url: ' . $data->fullUrl . ')</span>';
                                    } else {
                                        $urlinfo = '';
                                    }
                                    return Html::a(($data->depth - 1 > 0) ? str_pad('', ($data->depth - 1), '-') . ' &nbsp;' . Html::encode($data->title) : Html::encode($data->title), ['view', 'id' => $data->id]) . $urlinfo;
                                } else {
                                    return '<b>' . Html::encode($data->title) . '</b>';
                                }
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'updown',
                            'label' => false,
                            'value' => function($data) {
                                $content = '';
                                if ($data->depth != 0) {
                                    $prev = $data->prev()->one();
                                    $next = $data->next()->one();
                                    if (!empty($prev))
                                        $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/menus/up']), 'id' => $data->id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                    $content .= ' / ';
                                    if (!empty($next))
                                        $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/menus/down']), 'id' => $data->id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                }
                                return $content;
                            },
                            'headerOptions' => ['width' => '60'],
                            'format' => 'raw',
                        ],
                        [
                            'class' => TranslatesDataColumn::className(),
                            'attribute' => 'translates',
                            'label' => Yii::t('backend', 'Translate'),
                            'format' => 'html',
                            'visible' => (count($languages) > 1),
                        ],
                        [
                            'attribute' => 'url',
                            'content' => function($data) {
                                if ($data->depth != 0) {
                                    return $data->url;
                                }
                                return '';
                            }
                        ],
                        [
                            'attribute' => 'params',
                            'content' => function($data) {
                                $params = '';
                                if ($data->depth != 0) {
                                    if (!empty($data->params)) {
                                        foreach (unserialize($data->params) as $key => $param) {
                                            $params .= '[' . $key . '] => ' . $param . '<br>';
                                        }
                                    }
                                }
                                if ($data->target_blank) {
                                    $params .= '[target_blank] => true<br>';
                                }
                                if ($data->anchor) {
                                    $params .= '[#] => ' . $data->anchor . '<br>';
                                }
                                return $params;
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'access',
                            'content' => function($data) {
                                if ($data->depth != 0) {
                                    return $data->access;
                                }
                                return '';
                            }
                        ],
                        [
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['unpublish', 'id' => $data->id],
                                        ['class' => 'btn btn-xs btn-success btn-block',]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['publish', 'id' => $data->id],
                                    ['class' => 'btn btn-xs btn-danger btn-block',]
                                );
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'raw',
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'headerOptions' => ['width' => '90'],
                            'visibleButtons' => [
                                'view' => Yii::$app->user->can('viewPages'),
                                'update' => Yii::$app->user->can('editPages'),
                                'delete' => Yii::$app->user->can('deletePages'),
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
$(document).on('click', '.actionButton', function(e) {
    e.preventDefault();
    var data = $(this).data();
    $.ajax({
        type: "POST",
        url: data.url,
        data: {id: data.id},
        cache: false
    }).done(function(result) {
        if (result) {
            $.pjax.reload({container: '#admin-grid-view'});
        } else {
            alert( "Request failed");
        }
    });
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>