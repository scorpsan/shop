<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $clearRoot      bool
 * @var $languages      \backend\models\Language
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\TranslatesDataColumn;

$this->title = Yii::t('backend', 'Pages Categories');
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
                <?php Pjax::begin(['enablePushState' => false]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'title',
                            'label' => Yii::t('backend', 'Title'),
                            'value' => function($data) use ($clearRoot) {
                                return Html::a(($data->depth - (int)$clearRoot > 0) ? str_pad('', ($data->depth - (int)$clearRoot), '-') . ' &nbsp;' . Html::encode($data->title) : Html::encode($data->title), ['view', 'id' => $data->id]) . '&nbsp;<span class="small">(alias: ' . $data->alias . ')</span>';
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
                                    $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', ['up', 'id' => $data->id]);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                $content .= ' / ';
                                if (!empty($next))
                                    $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', ['down', 'id' => $data->id]);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                return $content;
                            },
                            'headerOptions' => ['width' => '60'],
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'page_style',
                            'content' => function($data) {
                                return (isset(Yii::$app->params['categoryStyle'][$data->page_style]))
                                    ? Yii::$app->params['categoryStyle'][$data->page_style]['title']
                                    : null;
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'raw',
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
                            'class' => TranslatesDataColumn::className(),
                            'clearRoot' => $clearRoot,
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
                            'headerOptions' => ['width' => '90'],
                            'visibleButtons' => [
                                'update' => Yii::$app->user->can('editPages'),
                                'delete' => Yii::$app->user->can('deletePages'),
                            ],
                        ],

                        [
                            'attribute' => 'id',
                            'headerOptions' => ['width' => '60'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>