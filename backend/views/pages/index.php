<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $languages      backend\models\Language
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\BooleanDataColumn;
use backend\components\grid\TranslateDataColumn;

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
                            'class' => BooleanDataColumn::className(),
                            'attribute' => 'landing',
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],
                        [
                            'attribute' => 'noindex',
                            'label' => Yii::t('backend', 'NoIndex'),
                            'content' => function ($data) {
                                return Html::tag('span', Yii::$app->formatter->asBoolean($data->noindex), ['class' => 'label label-' . ($data->noindex) ? 'danger' : 'success']);
                            },
                            'headerOptions' => ['width' => '90'],
                            'format' => 'html',
                        ],
                        [
                            'class' => TranslateDataColumn::className(),
                            'attribute' => 'translate',
                            'label' => Yii::t('backend', 'Translate'),
                            /*
                            'content' => function($data) use($languages){
                                $content = '';
                                foreach ($languages as $key => $lang) {
                                    if (isset($data->translates[$key]))
                                        if ($lang->default)
                                            $content .= Html::tag('span', $key, ['class' => 'label label-primary']);
                                        else
                                            $content .= Html::tag('span', $key, ['class' => 'label label-label-success']);
                                    else
                                        $content .= Html::tag('span', $key, ['class' => 'label label-label-danger']);
                                }
                                return $content;
                            },*/
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'published',
                            'content' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['/pages/unpublish', 'id' => $data->id],
                                        [
                                            'class' => 'btn btn-xs btn-success btn-block',
                                            'data-method' => 'post',
                                        ]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['/pages/publish', 'id' => $data->id],
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