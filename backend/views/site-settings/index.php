<?php
/**
 * @var $this           yii\web\View
 * @var $model          \backend\models\SiteSettings
 * @var $languages      \backend\models\Language
 */
use yii\helpers\Html;
use backend\components\widgets\DetailView;

$this->title = Yii::t('backend', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('editSettings')) { ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if (!empty($languages)) {
    $count = count($languages);
    $licontent = '';
    $tabcontent = '';
    if ($count > 1) { ?>
        <h2 class="page-header"><i class="fa fa-globe"></i> <?= Yii::t('backend', 'Translates') ?></h2>
        <p class="text-muted"><?= Yii::t('backend', 'Translate Rules') ?></p>
    <?php } ?>
    <div class="row">
        <div class="col-xs-12">
            <?php
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
                if (!empty($model->translates[$key])) {
                    echo $model->translate->getAttributeLabel('seotitle');
                    $tabcontent .= DetailView::widget([
                        'model' => $model->translates[$key],
                        'template' => '<tr><th{captionOptions} width="300px">{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            'title',
                            'seotitle:ntext',
                            'keywords:ntext',
                            'description:ntext',
                            'address:html',
                            'about_footer:html',
                            'opening_hours',
                            'opening_hours_full',
                            'contact_info:html',
                            'address_map:html',
                        ],
                    ]);
                } else {
                    $tabcontent .= Yii::t('backend', 'Translate Not Found...');
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
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<tr><th{captionOptions} width="300px">{label}</th><td{contentOptions}>{value}</td></tr>',
                    'attributes' => [
                        'admin_email',
                        'support_email',
                        'sender_email',
                        'phone',
                        'contact_phone',
                        'viber_phone',
                        'whatsapp_phone',
                        'telegram_nick',
                        'skype_nick',
                        'currency_code',
                        'long_map',
                        'lat_map',
                        'link_to_facebook',
                        'link_to_youtube',
                        'link_to_vk',
                        'link_to_pinterest',
                        'link_to_twitter',
                        'link_to_instagram',
                        'instagram_token',
                        [
                            'attribute' => 'coming_soon',
                            'value' => function($data) {
                                return Html::tag('span', Yii::$app->formatter->asBoolean($data->coming_soon), ['class' => 'label label-' . (($data->coming_soon) ? 'danger' : 'success')]);
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'search_on_site',
                            'value' => function($data) {
                                return Html::tag('span', Yii::$app->formatter->asBoolean($data->search_on_site), ['class' => 'label label-' . (($data->search_on_site) ? 'success' : 'danger')]);
                            },
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'shop_on_site',
                            'value' => function($data) {
                                return Html::tag('span', Yii::$app->formatter->asBoolean($data->shop_on_site), ['class' => 'label label-' . (($data->shop_on_site) ? 'success' : 'danger')]);
                            },
                            'format' => 'html',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>