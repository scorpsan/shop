<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('backend', 'Jobs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'channel',
                        'job',
                        [
                            'attribute' => 'pushed_at',
                            'format' => 'datetime',
                        ],
                        'ttr',
                        'delay',
                        'priority',
						[
							'attribute' => 'reserved_at',
							'format' => 'datetime',
						],
                        'attempt',
						[
							'attribute' => 'done_at',
							'format' => 'datetime',
						],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}'
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>