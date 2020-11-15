<?php
/**
 * @var $this           yii\web\View
 * @var $model          backend\models\Categories
 * @var $languages      backend\models\Language
 * @var $clearRoot      bool
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('backend', 'Pages Category') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages Categories'), 'url' => ['index']];
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
                        [
                            'attribute' => 'parent_id',
                            'value' => function($data) use ($clearRoot) {
                                $listParents = [];
                                if (($parents = $data->parents((!$clearRoot)?null:(int)$clearRoot)->all()) !== null) {
                                    foreach ($parents as $item) {
                                        $listParents[] = $item->title;
                                    }
                                }
                                return implode(" / ", $listParents);
                            },
                            'format' => 'raw',
                        ],
                        'alias',
                        [
                            'attribute' => 'published',
                            'value' => function($data) {
                                if ($data->published) {
                                    return Html::a(
                                        Yii::$app->formatter->asBoolean($data->published),
                                        ['unpublish', 'id' => $data->id],
                                        [
                                            'class' => 'btn btn-xs btn-success mx-5',
                                            'data-method' => 'post',
                                        ]
                                    );
                                }
                                return Html::a(
                                    Yii::$app->formatter->asBoolean($data->published),
                                    ['publish', 'id' => $data->id],
                                    [
                                        'class' => 'btn btn-xs btn-danger mx-5',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'page_style',
                            'value' => Yii::$app->params['pageStyle'][$model->page_style]['title'],
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'noindex',
                            'value' => function($data) {
                                return Html::tag('span', Yii::$app->formatter->asBoolean($data->noindex), ['class' => 'label label-' . (($data->noindex) ? 'danger' : 'success')]);
                            },
                            'format' => 'html',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($languages)) {
            $count = count($languages);
            $licontent = '';
            $tabcontent = '';
            if ($count > 1) { ?>
                <h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
                <p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
            <?php }
            foreach ($languages as $key => $lang) {
                if ($count > 1) {
                    if ($lang->default) {
                        $licontent .= '<li class="active"><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                        $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade active in" role="tabpanel">';
                    } else {
                        $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                        $tabcontent .= '<div id="lng_' . $key . '" class="tab-pane fade" role="tabpanel">';
                    }
                }
                if (!empty($model->translates[$lang->url])) {
                    if ($model->page_style > 5) {
                        $tabcontent .= '<div class="row"><div class="col-md-9">';
                    } else {
                        $tabcontent .= '<div class="row"><div class="col-xs-12">';
                    }
                    $tabcontent .= DetailView::widget([
                        'model' => $model->translates[$lang->url],
                        'template' => '<tr><th{captionOptions} width="200px">{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            'title',
                            'content:html',
                            'seotitle:ntext',
                            'keywords:ntext',
                            'description:ntext',
                            'seo_text:html'
                        ],
                    ]);
                    if ($model->page_style > 5) {
                        $tabcontent .= '</div><div class="col-md-3">';
                        $tabcontent .= DetailView::widget([
                            'model' => $model->translates[$key],
                            'template' => '<tr><th{captionOptions}>{label}</th></tr><tr><td{contentOptions}>{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'breadbg',
                                    'value' => ($model->breadbg) ? $model->breadbg : null,
                                    'format' => ['image', ['width' => '250']],
                                ],
                            ],
                        ]);
                    }
                    $tabcontent .= '</div></div>';
                } else {
                    $tabcontent .= '<div class="row"><div class="col-xs-12"><div class="box"><div class="box-body">';
                    $tabcontent .= Yii::t('backend', 'Translate Not Found...');
                    $tabcontent .= '</div></div></div></div>';
                }
                if ($count > 1) {
                    $tabcontent .= '</div>';
                }
            } ?>
            <?php if ($count > 1) { ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="lngTabs">
                        <?= $licontent ?>
                    </ul>
                    <div class="tab-content" id="lngTabContent">
                        <?= $tabcontent ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="box">
                    <div class="box-body">
                        <?= $tabcontent ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>