<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('backend', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Create Slider'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive">
                <?php Pjax::begin(['id' => 'backend-grid-view', 'timeout' => false]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered table-striped dataTable'],
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'id',
                            'headerOptions' => ['width' => '60'],
                        ],
                        'title',
                        'description',
                        [
                            'attribute' => 'player',
                            'content' => function($data) {
                                if ($data->player)
                                    return '<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->player) . '</span>';
                                else
                                    return '<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->player) . '</span>';
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],
                        [
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published)
                                    return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/swiper/unpublish']), 'id' => $data->id]]);
                                else
                                    return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/swiper/publish']), 'id' => $data->id]]);
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '90'],
                            'visibleButtons' => [
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
            $.pjax.reload({container: '#backend-grid-view'});
        } else {
            alert( "Request failed");
        }
    });
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>