<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $languages      backend\models\Language
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('backend', 'Posts Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
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
                                return Html::a(($data->depth - 1 > 0) ? str_pad('', ($data->depth - 1), '-') . ' &nbsp;' . Html::encode($data->title) : Html::encode($data->title), ['view', 'id' => $data->id]) . '&nbsp;<span class="small">(alias: ' . $data->alias . ')</span>';
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'updown',
                            'label' => false,
                            'value' => function($data) {
                                $content = '';
                                $prev = $data->prev()->one();
                                $next = $data->next()->one();
                                if (!empty($prev))
                                    $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/backend/posts-categories/up']), 'id' => $data->id]]);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                $content .= ' / ';
                                if (!empty($next))
                                    $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/backend/posts-categories/down']), 'id' => $data->id]]);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                return $content;
                            },
                            'headerOptions' => ['width' => '60'],
                            'format' => 'raw',
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
                                    return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/backend/posts-categories/unpublish']), 'id' => $data->id]]);
                                else
                                    return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/backend/posts-categories/publish']), 'id' => $data->id]]);
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