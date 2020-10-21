<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
//use backend\components\widgets\DetailView;

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
                        $licontent .= '<li class="active"><a data-toggle="tab" id="' . $lang->url . '_tab" role="tab" href="#lng_' . $lang->url . '" aria-expanded="true">' . $lang->title . ' <span class="fa fa-star"></span></a></li>';
                        $tabcontent .= '<div id="lng_' . $lang->url . '" class="tab-pane fade active in" role="tabpanel">';
                    } else {
                        $licontent .= '<li><a data-toggle="tab" id="' . $lang->url . '_tab" role="tab" href="#lng_' . $lang->url . '" aria-expanded="false">' . $lang->title . '</a></li>';
                        $tabcontent .= '<div id="lng_' . $lang->url . '" class="tab-pane fade" role="tabpanel">';
                    }
                }
                if (!empty($model->translates[$lang->url])) {
                    $tabcontent .= DetailView::widget([
                        'model' => $model->translates[$lang->url],
                        'attributes' => [
                            'title',
                            'seotitle',
                            'description',
                            'keywords',
                            'address',
                            'about_footer',
                            'opening_hours',
                            'opening_hours_full',
                            'contact_info:html',
                            'address_map',
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
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>