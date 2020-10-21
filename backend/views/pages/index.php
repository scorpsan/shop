<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\components\grid\BooleanDataColumn;
use yii\widgets\Pjax;

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Create Page'), ['create'], ['class' => 'btn btn-success']) ?>
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
                        [
                            'attribute' => 'title',
                            'label' => Yii::t('backend', 'Title'),
                            'value' => function($data) {
                                $content = Html::a(Html::encode($data->title), ['view', 'id' => $data->id]);
                                if (isset($data->alias)) {
                                    $content .= '<br>(alias: ' . $data->alias . ')';
                                }
                                return $content;
                            },
                            'format' => 'html',
                        ],
                        [
                            'class' => BooleanDataColumn::className(),
                            'attribute' => 'main',
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],
                        [
                            'attribute' => 'translate',
                            'label' => Yii::t('backend', 'Translate'),
                            'content' => function($data) use($languages){
                                $content = '';
                                foreach ($languages as $key => $lang) {
                                    if (isset($data->translates[$key]))
                                        if ($lang->default)
                                            $content .= '<span class="label label-primary">' . $key . '</span>';
                                        else
                                            $content .= '<span class="label label-success">' . $key . '</span>';
                                    else
                                        $content .= '<span class="label label-danger">' . $key . '</span>';
                                }
                                return $content;
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published)
                                    return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/pages/unpublish']), 'id' => $data->id]]);
                                else
                                    return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/pages/publish']), 'id' => $data->id]]);
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],
                        [
                            'class' => 'backend\components\grid\CombinedDataColumn',
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