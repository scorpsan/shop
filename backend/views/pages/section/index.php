<?php
/**
 * @var $sections      backend\models\PagesSection
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

foreach ($sections as $model) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="col-md-9">
                    <h3><?= $model->title ?></h3>
                    <?php if ($model->widget) { ?>
                        <?= Yii::$app->params['widgetsList'][$model->widget_type]['title'] ?>
                    <?php } else { ?>
                        <?= $model->content ?>
                    <?php } ?>
                </div>
                <div class="col-md-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'published',
                                'value' => function($data) {
                                    if ($data->published) {
                                        return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['unpublish']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    }
                                    return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($data->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['publish']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'show_title',
                                'value' => Html::tag('span', Yii::$app->formatter->asBoolean($model->show_title), ['class' => 'label label-' . (($model->show_title) ? 'success' : 'danger')]),
                                'format' => (!$model->widget || Yii::$app->params['widgetsList'][$model->widget_type]['params']['show_title'])?'html':'hidden',
                            ],
                            [
                                'attribute' => 'style',
                                'value' => Yii::$app->params['sectionStyle'][$model->style],
                                'format' => (!$model->widget || Yii::$app->params['widgetsList'][$model->widget_type]['params']['style'])?'html':'hidden',
                            ],
                            [
                                'attribute' => 'background',
                                'value' => ($model->background)?$model->background:null,
                                'format' => (!$model->widget || Yii::$app->params['widgetsList'][$model->widget_type]['params']['background'])?['image',['width'=>'150']]:'hidden',
                            ],
                            [
                                'attribute' => 'parallax',
                                'value' => Html::tag('span', Yii::$app->formatter->asBoolean($model->parallax), ['class' => 'label label-' . (($model->parallax) ? 'success' : 'danger')]),
                                'format' => (!$model->widget || Yii::$app->params['widgetsList'][$model->widget_type]['params']['parallax'])?'html':'hidden',
                            ],
                            [
                                'attribute' => 'sort',
                                'value' => function($data) {
                                    $content = '';
                                    if (!$data->getIsFirst())
                                        $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['up']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                    $content .= ' / ';
                                    if (!$data->getIsLast())
                                        $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['down']), 'id' => $data->id, 'item_id' => $data->item_id]]);
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
                            'class' => 'btn btn-primary sectionButton',
                            'data' => [
                                'title' => ($model->widget) ? Yii::t('backend', 'Update Widget') : Yii::t('backend', 'Update Section'),
                                'action' => ($model->widget) ? Url::to(['/pages/widget/update', 'id' => $model->id]) : Url::to(['/pages/section/update', 'id' => $model->id]),
                            ],
                        ]) ?>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('deletePages')) { ?>
                        <?= Html::button(Yii::t('backend', 'Delete'), [
                            'class' => 'btn btn-danger sectionButton',
                            'data' => [
                                'title' => ($model->widget) ? Yii::t('backend', 'Delete Widget') : Yii::t('backend', 'Delete Section'),
                                'action' => Url::to(['delete', 'id' => $model->id]),
                            ],
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>