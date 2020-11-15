<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $languages      \backend\models\Language
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\BooleanDataColumn;
use backend\components\grid\TranslatesDataColumn;
use backend\components\grid\CombinedDataColumn;

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
                <?php Pjax::begin(); ?>
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
                            'attribute' => 'page_style',
                            'content' => function($data) {
                                return Yii::$app->params['pageStyle'][$data->page_style]['title'];
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'html',
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
                                        [
                                            'class' => 'btn btn-xs btn-success btn-block',
                                            'data-method' => 'post',
                                        ]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['publish', 'id' => $data->id],
                                    [
                                        'class' => 'btn btn-xs btn-danger btn-block',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'raw',
                        ],
                        [
                            'class' => CombinedDataColumn::className(),
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