<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $searchModel    \backend\models\ShopOrdersSearch
 */

use backend\models\ShopDelivery;
use backend\models\ShopOrdersStatuses;
use backend\models\ShopPayment;
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('backend', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
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
                    'filterModel' => $searchModel,
                    'pager' => [
                        'firstPageLabel' => Yii::t('backend', 'First'),
                        'lastPageLabel' => Yii::t('backend', 'Last'),
                    ],
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['width' => '60'],
                        ],
                        [
                            'attribute' => 'order_number',
                            'label' => Yii::t('backend', 'Order N'),
                            'value' => function($data) {
                                return Html::a(Html::encode($data->order_number), ['update', 'id' => $data->id]);
                            },
                            'headerOptions' => ['width' => '150'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'customer_name',
                            'content' => function ($data) {
                                if (!empty($data->user)) {
                                    return Html::a($data->customer_name, ['view-info', 'id' => $data->user->id]) . '<br>(' . $data->user->username . ')';
                                } else {
                                    return $data->customer_name;
                                }
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => Yii::t('backend', 'Amount'),
                            'value' => function($data) { return Yii::$app->formatter->asCurrency($data->amount, $data->currency); },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'payment_method_id',
                            'content' => function($data) {
                                return $data->payment_method_name;
                            },
                            'format' => 'raw',
                            'filter' => ShopPayment::listAll(),
                        ],
                        [
                            'attribute' => 'delivery_method_id',
                            'content' => function($data) {
                                return $data->delivery_method_name;
                            },
                            'format' => 'raw',
                            'filter' => ShopDelivery::listAll(),
                        ],
                        [
                            'attribute' => 'payment_status',
                            'content' => function($data) {
                                return ShopOrdersStatuses::HtmlStatus($data->paymentStatus->status);
                            },
                            'format' => 'raw',
                            'filter' => ShopOrdersStatuses::listAll(ShopOrdersStatuses::STATUS_TYPE_PAYMENT),
                        ],
                        [
                            'attribute' => 'delivery_status',
                            'content' => function($data) {
                                return ShopOrdersStatuses::HtmlStatus($data->deliveryStatus->status);
                            },
                            'format' => 'raw',
                            'filter' => ShopOrdersStatuses::listAll(ShopOrdersStatuses::STATUS_TYPE_DELIVERY),
                        ],
                        [
                            'attribute' => 'created_at',
                            'content' => function ($data) {
                                return Yii::$app->formatter->asDatetime($data->created_at);
                            },
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
                ]) ?>
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