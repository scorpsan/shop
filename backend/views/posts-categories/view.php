<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('backend', 'Posts Categories') . ' <small>' . $model->title . '</small>';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Posts Categories'), 'url' => ['index']];
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
                            'value' => $model->parents(1)->one()->title,
                        ],
                        'alias',
                        [
                            'attribute' => 'published',
                            'value' => ($model->published)
                                ? '<span class="label label-success">' . Yii::$app->formatter->asBoolean($model->published) . '</span>'
                                : '<span class="label label-danger">' . Yii::$app->formatter->asBoolean($model->published) . '</span>',
                            'format' => 'html',
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
                        $tabcontent .= '<div id="lng_' . $key . '" class="tab-panel fade active in" role="tabpanel">';
                    } else {
                        $licontent .= '<li><a data-toggle="tab" id="' . $key . '_tab" role="tab" href="#lng_' . $key . '" aria-expanded="false">' . $lang->title . '</a></li>';
                        $tabcontent .= '<div id="lng_' . $key . '" class="tab-panel fade" role="tabpanel">';
                    }
                    if (!empty($model->translates[$key])) {
                        $tabcontent .= DetailView::widget([
                            'model' => $model->translates[$key],
                            'attributes' => [
                                'title',
                                'content:html',
                                [
                                    'attribute' => 'img',
                                    'value' => function($data) {
                                        return $data->img;
                                    },
                                    'format' => ['image',['width'=>'100%']],
                                ],
                                'seo_title',
                                'keywords',
                                'description',
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