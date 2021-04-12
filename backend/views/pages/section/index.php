<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\widgets\DetailView;
?>
<?php foreach ($sections as $model) { ?>
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
                                'value' => function($model) {
                                    if ($model->published)
                                        return Html::a('<span class="label label-success">' . Yii::$app->formatter->asBoolean($model->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['unpublish']), 'id' => $model->id, 'item_id' => $model->item_id]]);
                                    else
                                        return Html::a('<span class="label label-danger">' . Yii::$app->formatter->asBoolean($model->published) . '</span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['publish']), 'id' => $model->id, 'item_id' => $model->item_id]]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'show_title',
                                'value' => ($model->show_title)
                                        ? '<span class="label label-success">' . Yii::$app->formatter->asBoolean($model->show_title) . '</span>'
                                        : '<span class="label label-danger">' . Yii::$app->formatter->asBoolean($model->show_title) . '</span>',
                                'format' => 'html',
                                'captionOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['show_title']) ? 'hidden' : '',
                                ],
                                'contentOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['show_title']) ? 'hidden' : '',
                                ],
                            ],
                            [
                                'attribute' => 'style',
                                'value' => (!empty($model->style)) ? Yii::$app->params['sectionStyle'][$model->style] : null,
                                'format' => 'html',
                                'captionOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['style']) ? 'hidden' : '',
                                ],
                                'contentOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['style']) ? 'hidden' : '',
                                ],
                            ],
                            [
                                'attribute' => 'text_align',
                                'value' => (!empty($model->text_align)) ? Yii::$app->params['textAlignList'][$model->text_align] : null,
                                'format' => 'html',
                                'captionOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['text_align']) ? 'hidden' : '',
                                ],
                                'contentOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['text_align']) ? 'hidden' : '',
                                ],
                            ],
                            [
                                'attribute' => 'background',
                                'value' => (!empty($model->background)) ? $model->background : null,
                                'format' => ['image',['width'=>'150']],
                                'captionOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['background']) ? 'hidden' : '',
                                ],
                                'contentOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['background']) ? 'hidden' : '',
                                ],
                            ],
                            [
                                'attribute' => 'parallax',
                                'value' => ($model->parallax)
                                    ? '<span class="label label-success">' . Yii::$app->formatter->asBoolean($model->parallax) . '</span>'
                                    : '<span class="label label-danger">' . Yii::$app->formatter->asBoolean($model->parallax) . '</span>',
                                'format' => 'html',
                                'captionOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['parallax']) ? 'hidden' : '',
                                ],
                                'contentOptions' => [
                                    'class' => ($model->widget && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['parallax']) ? 'hidden' : '',
                                ],
                            ],
                            [
                                'attribute' => 'sort',
                                'value' => function($data) {
                                    $content = '';
                                    if (!$data->getIsFirst())
                                        $content .= Html::a('<span class="fa fa-arrow-circle-up"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/pages/section/up']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-up"></span>';
                                    $content .= ' / ';
                                    if (!$data->getIsLast())
                                        $content .= Html::a('<span class="fa fa-arrow-circle-down"></span>', '#', ['class' => 'actionButton', 'data' => ['url' => Url::to(['/pages/section/down']), 'id' => $data->id, 'item_id' => $data->item_id]]);
                                    else
                                        $content .= '<span class="fa fa-arrow-circle-down"></span>';
                                    return $content;
                                },
                                'format' => 'raw',
                            ],
                        ],
                    ]) ?>
                    <?php if (Yii::$app->user->can('editPages')) { ?>
                        <?php if ($model->widget) { ?>
                            <?= Html::button(Yii::t('backend', 'Update'), [
                                'class' => 'btn btn-primary sectionButton',
                                'data' => [
                                    'title' => Yii::t('backend', 'Update Widget'),
                                    'action' => Url::to(['/pages/widget/update', 'id' => $model->id]),
                                ],
                            ]) ?>
                        <?php } else { ?>
                            <?= Html::button(Yii::t('backend', 'Update'), [
                                'class' => 'btn btn-primary sectionButton',
                                'data' => [
                                    'title' => Yii::t('backend', 'Update Section'),
                                    'action' => Url::to(['/pages/section/update', 'id' => $model->id]),
                                ],
                            ]) ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if (Yii::$app->user->can('deletePages')) { ?>
                        <?php if ($model->widget) { ?>
                            <?= Html::button(Yii::t('backend', 'Delete'), [
                                'class' => 'btn btn-danger sectionButton',
                                'data' => [
                                    'title' => Yii::t('backend', 'Delete Widget'),
                                    'action' => Url::to(['/pages/section/delete', 'id' => $model->id]),
                                ],
                            ]) ?>
                        <?php } else { ?>
                            <?= Html::button(Yii::t('backend', 'Delete'), [
                                'class' => 'btn btn-danger sectionButton',
                                'data' => [
                                    'title' => Yii::t('backend', 'Delete Section'),
                                    'action' => Url::to(['/pages/section/delete', 'id' => $model->id]),
                                ],
                            ]) ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>