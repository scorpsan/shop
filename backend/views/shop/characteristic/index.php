<?php
/**
 * @var $this           yii\web\View
 * @var $dataProvider   yii\data\ActiveDataProvider
 * @var $languages      \backend\models\Language
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\components\grid\TranslatesDataColumn;

$this->title = Yii::t('backend', 'Product Characteristics');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?= Html::a(Yii::t('backend', 'Create Characteristic'), ['create'], ['class' => 'btn btn-success']) ?>
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
                        'alias',
                        [
                            'class' => TranslatesDataColumn::className(),
                            'attribute' => 'translates',
                            'label' => Yii::t('backend', 'Translate'),
                            'format' => 'html',
                            'visible' => (count($languages) > 1),
                        ],
                        [
                            'class' => \backend\components\grid\BooleanDataColumn::className(),
                            'attribute' => 'required',
                            'headerOptions' => ['width' => '90'],
                            'format' => 'boolean',
                        ],
                        'default',
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
                        [
                            'attribute' => 'updown',
                            'label' => false,
                            'value' => function($data) {
                                $content = '';
                                if (!$data->getIsFirst())
                                    $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', ['up', 'id' => $data->id]);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                $content .= ' / ';
                                if (!$data->getIsLast())
                                    $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', ['down', 'id' => $data->id]);
                                else
                                    $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                return $content;
                            },
                            'headerOptions' => ['width' => '60'],
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