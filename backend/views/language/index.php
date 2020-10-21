<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use shop\helpers\BooleanDataColumn;
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 */
$this->title = Yii::t('backend', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editSettings')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Create Language'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive">
                <?php Pjax::begin(['id' => 'admin-grid-view', 'timeout' => false]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered table-striped dataTable'],
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

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
                            'format' => 'html',
                        ],
                        'url',
                        'local',
                        [
                            'class' => BooleanDataColumn::className(),
                            'attribute' => 'default',
                            'headerOptions' => ['width' => '130'],
                            'format' => 'boolean',
                        ],
                        [
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published)
                                    return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/language/unpublish']), 'id' => $data->id]]);
                                else
                                    return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/language/publish']), 'id' => $data->id]]);
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'headerOptions' => ['width' => '60'],
                            'visibleButtons' => [
                                'update' => Yii::$app->user->can('editSettings'),
                                'delete' => Yii::$app->user->can('deleteSettings'),
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