<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('backend', 'Menu') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<?php if (Yii::$app->user->can('editPages')) { ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php if (Yii::$app->user->can('deletePages')) { ?>
                        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'tree',
                        'lft',
                        'rgt',
                        'depth',
                        'url:url',
                        'params',
                        'access',
                        [
                            'attribute' => 'target_blank',
                            'value' => Html::tag('span', Yii::$app->formatter->asBoolean($model->target_blank), ['class' => 'label label-' . (($model->target_blank) ? 'success' : 'danger')]),
                            'format' => 'html',
                        ],
                        'anchor',
                        [
                            'attribute' => 'published',
                            'value' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['/menus/unpublish', 'id' => $data->id],
                                        [
                                            'class' => 'btn btn-xs btn-success',
                                            'data-method' => 'post',
                                        ]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['/menus/publish', 'id' => $data->id],
                                    [
                                        'class' => 'btn btn-xs btn-danger',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
<p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <?php
            $licontent = '';
            $tabcontent = '';
            foreach ($languages as $key => $lang) {
                if ($lang->default) {
                    $licontent .= '<li class="active"><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade active in" role="tabpanel">';
                } else {
                    $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                    $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';
                }
                if (!empty($model->translates[$key])) {
                    $tabcontent .= DetailView::widget([
                        'model' => $model->translates[$key],
                        'attributes' => [
                            'title',
                        ],
                    ]);
                } else {
                    $tabcontent .= Yii::t('backend', 'Translate Not Found...');
                }
                $tabcontent .= '</div>';
            }
            ?>
            <ul class="nav nav-tabs" id="lngTabs">
                <?= $licontent ?>
            </ul>
            <div class="tab-content" id="lngTabContent">
                <?= $tabcontent ?>
            </div>
        </div>
    </div>
</div>