<?php
/**
 * @var $slides      backend\models\SwiperSlides
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

foreach ($slides as $model) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="col-md-6">
                    <?= Html::img($model->image, ['width' => '100%']) ?>
                </div>
                <div class="col-md-3">
                    <h3><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?></h3>
                    <?= $model->content ?>
                </div>
                <div class="col-md-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'published',
                                'value' => function($data) {
                                    if ($data->published) {
                                        return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/swiper-slides/unpublish']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    }
                                    return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/swiper-slides/publish']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'lng',
                                'label' => Yii::t('backend', 'Language'),
                                'content' => ($model->lng)
                                    ? Html::tag('span', $model->lng, ['class' => 'label label-success'])
                                    : Html::tag('span', Yii::t('backend', 'All'), ['class' => 'label label-primary']),
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'text_align',
                                'value' => Yii::$app->params['textAlignList'][$model->text_align],
                            ],
                            [
                                'attribute' => 'style',
                                'value' => Yii::$app->params['sectionStyle'][$model->style],
                            ],
                            [
                                'attribute' => 'sort',
                                'value' => function($data) {
                                    $content = '';
                                    if (!$data->getIsFirst())
                                        $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/swiper-slides/up']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                    $content .= ' / ';
                                    if (!$data->getIsLast())
                                        $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/swiper-slides/down']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                    return $content;
                                },
                                'format' => 'raw',
                            ],
                        ],
                    ]) ?>
                    <?php if (Yii::$app->user->can('editPages')) { ?>
                        <?= Html::button(Yii::t('backend', 'Update'), [
                            'class' => 'btn btn-primary slideButton',
                            'data' => [
                                'title' => Yii::t('backend', 'Update Slide'),
                                'action' => Url::to(['/swiper-slides/update', 'id' => $model->id]),
                            ],
                        ]) ?>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('deletePages')) { ?>
                        <?= Html::button(Yii::t('backend', 'Delete'), [
                            'class' => 'btn btn-danger slideButton',
                            'data' => [
                                'title' => Yii::t('backend', 'Delete Slide'),
                                'action' => Url::to(['/swiper-slides/delete', 'id' => $model->id]),
                            ],
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>