<?php
/**
 * @var $params array
 * @var $options array
 */

use frontend\widgets\ContactFormWidget;
use yii\helpers\Html;
/**
'c' => 'Contacts Only',
'f' => 'Form Only',
'm' => 'Map Only',
'cf' => 'Contacts + Form',
'cm' => 'Contacts + Map',
'fm' => 'Form + Map',
'cfm' => 'Contacts + Form + Map',
 */
?>
<?php if ($options['type'] != 'm') { ?>
<section id="contact" class="section section-contact-us <?= $params['style'] ?>">
    <div class="my-container">
        <?php if ($options['type'] == 'f' || $options['type'] == 'fm') { ?>
            <?php if ($params['show_title']) { ?>
                <h3 class="h3 heading-3 font-weight-bold text-center text-capitalize"><?= $params['title'] ?></h3>
            <?php } ?>
            <?php if (!empty($options['pretext'])) { ?>
                <p><?= $options['pretext'] ?></p>
            <?php } ?>
            <?= ContactFormWidget::widget() ?>
        <?php } else { ?>
            <div class="row">
                <?php if ($options['type'] == 'cf' || $options['type'] == 'cfm') { ?>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 detail">
                        <h3 class="heading-3  mb-0"><?= Yii::t('frontend', 'Contact Details') ?></h3>
                        <?php if (!empty($options['pretext'])) { ?>
                            <p class="col-10 para-fs18 font-2 pl-0" style="padding-right: 20px"><?= $options['pretext'] ?></p>
                        <?php } ?>
                        <ul>
                            <?php if (!empty(Yii::$app->params['siteSettings']->translate->address)) { ?>
                                <li>
                                    <span>
                                        <?= Yii::t('frontend', 'Address') ?>:

                                        <address>
                                            <a class="text-gray-light" href="#"><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translate->address) ?></a>
                                        </address>
                                    </span>
                                </li>
                            <?php } ?>
                            <?php if (!empty(Yii::$app->params['siteSettings']->translate->opening_hours_full)) { ?>
                                <li>
                                    <span><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translate->opening_hours_full) ?></span>
                                </li>
                            <?php } ?>
                            <li></li>
                            <?php if (!empty(Yii::$app->params['siteSettings']->phone)) { ?>
                                <li>
                                <span> <?= Yii::t('frontend', 'Phones') ?>: </span>
                                <?= Html::a(Yii::$app->params['siteSettings']->phone, 'tel:'.preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->phone), ['class' => 'text-gray-light text-extra-bold reveal-inline']) ?><br>
                                <?php if (!empty(Yii::$app->params['siteSettings']->contact_phone)) {
                                    $contactPhone = explode("\n", Yii::$app->params['siteSettings']->contact_phone);
                                    foreach ($contactPhone as $phone) {
                                        echo Html::a($phone, 'tel:'.preg_replace('/[^+0-9]/', '', $phone), ['class' => 'text-gray-light text-extra-bold reveal-inline']) . '<br>';
                                    }
                                } ?>
                                </li>
                            <?php } ?>
                            <li>
                                <span>E-mail: </span>
                                <a href="mailto:<?= Yii::$app->params['supportEmail'] ?>" target="_blank"><?= Yii::$app->params['supportEmail'] ?></a>
                            </li>
                            <?php if (!empty(Yii::$app->params['siteSettings']->whatsapp_phone) || !empty(Yii::$app->params['siteSettings']->viber_phone) || !empty(Yii::$app->params['siteSettings']->telegram_nick) || !empty(Yii::$app->params['siteSettings']->skype_nick)) { ?>
                                <li>
                                    <span><?= Yii::t('frontend', 'Message us') ?>: </span>
                                    <?php if (!empty(Yii::$app->params['siteSettings']->whatsapp_phone)) { ?>
                                        <a title="WhatsApp" href="whatsapp://send?phone=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->whatsapp_phone) ?>"><span class="fab fa-2x fa-whatsapp"></span></a>
                                    <?php } ?>
                                    <?php if (!empty(Yii::$app->params['siteSettings']->viber_phone)) { ?>
                                        <a title="Viber" href="viber://chat?number=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->viber_phone) ?>"><span class="fab fa-2x fa-viber"></span></a>
                                    <?php } ?>
                                    <?php if (!empty(Yii::$app->params['siteSettings']->telegram_nick)) { ?>
                                        <a title="Telegram" href="tg://resolve?domain=<?= Yii::$app->params['siteSettings']->telegram_nick ?>"><span class="fab fa-2x fa-telegram-plane"></span></a>
                                    <?php } ?>
                                    <?php if (!empty(Yii::$app->params['siteSettings']->skype_nick)) { ?>
                                        <a title="Skype" href="skype:<?= Yii::$app->params['siteSettings']->skype_nick ?>?call"><span class="fab fa-2x fa-skype"></span></a>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div id="contact-form" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 contact">
                        <?php if ($params['show_title']) { ?>
                            <h3 class="heading-3"><?= $params['title'] ?></h3>
                        <?php } ?>
                        <?= ContactFormWidget::widget() ?>
                    </div>
                <?php } elseif ($options['type'] == 'c' || $options['type'] == 'cm') { ?>
                    <div class="row">
                        <div class="col-12">
                            <?php if ($params['show_title']) { ?>
                                <h3 class="h3 heading-3 font-weight-bold text-center text-capitalize"><?= $params['title'] ?></h3>
                            <?php } ?>
                            <?php if (!empty($options['pretext'])) { ?>
                                <p><?= $options['pretext'] ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                    <?php if (!empty(Yii::$app->params['siteSettings']->translate->address)) { ?>
                        <div class="cell-sm-4">
                            <h4><?= Yii::t('frontend', 'Address') ?></h4>
                            <address>
                                <a class="text-gray-light" href="#"><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translate->address) ?></a>
                            </address>
                        </div>
                        <?php } ?>
                        <?php if (!empty(Yii::$app->params['siteSettings']->phone)) { ?>
                        <div class="cell-sm-4">
                            <h4> <?= Yii::t('frontend', 'Phones') ?></h4>
                            <div>
                                <?= Html::a(Yii::$app->params['siteSettings']->phone, 'tel:'.preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->phone), ['class' => 'text-gray-light text-extra-bold reveal-inline']) ?><br>
                                <?php if (!empty(Yii::$app->params['siteSettings']->contact_phone)) {
                                    $contactPhone = explode("\n", Yii::$app->params['siteSettings']->contact_phone);
                                    foreach ($contactPhone as $phone) {
                                        echo Html::a($phone, 'tel:'.preg_replace('/[^+0-9]/', '', $phone), ['class' => 'text-gray-light text-extra-bold reveal-inline']) . '<br>';
                                    }
                                } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if (!empty(Yii::$app->params['siteSettings']->whatsapp_phone) || !empty(Yii::$app->params['siteSettings']->viber_phone) || !empty(Yii::$app->params['siteSettings']->telegram_nick) || !empty(Yii::$app->params['siteSettings']->skype_nick)) { ?>
                        <div class="cell-sm-4">
                            <h4><?= Yii::t('frontend', 'Message us') ?></h4>
                            <div>
                                <?php if (!empty(Yii::$app->params['siteSettings']->whatsapp_phone)) { ?>
                                    <a title="WhatsApp" href="whatsapp://send?phone=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->whatsapp_phone) ?>"><span class="fab fa-2x fa-whatsapp"></span></a>
                                <?php } ?>
                                <?php if (!empty(Yii::$app->params['siteSettings']->viber_phone)) { ?>
                                    <a title="Viber" href="viber://chat?number=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->viber_phone) ?>"><span class="fab fa-2x fa-viber"></span></a>
                                <?php } ?>
                                <?php if (!empty(Yii::$app->params['siteSettings']->telegram_nick)) { ?>
                                    <a title="Telegram" href="tg://resolve?domain=<?= Yii::$app->params['siteSettings']->telegram_nick ?>"><span class="fab fa-2x fa-telegram-plane"></span></a>
                                <?php } ?>
                                <?php if (!empty(Yii::$app->params['siteSettings']->skype_nick)) { ?>
                                    <a title="Skype" href="skype:<?= Yii::$app->params['siteSettings']->skype_nick ?>?call"><span class="fab fa-2x fa-skype"></span></a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="cell-sm-4">
                            <h4>E-mail</h4>
                            <div><a class="text-primary text-italic" href="mailto:<?= Yii::$app->params['supportEmail'] ?>" target="_blank"><?= Yii::$app->params['supportEmail'] ?></a></div>
                        </div>
                        <?php if (!empty(Yii::$app->params['siteSettings']->translate->opening_hours_full)) { ?>
                        <div class="cell-sm-4 offset-top-20 offset-md-top-60">
                            <h4><?= Yii::t('frontend', 'Opening hours') ?></h4>
                            <p><?= str_replace("\n", "</p><p>", Yii::$app->params['siteSettings']->translate->opening_hours_full) ?></p>
                        </div>
                    <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
<?php } ?>
<?php if (Yii::$app->params['siteSettings']->long_map && Yii::$app->params['siteSettings']->lat_map && ($options['type'] == 'm' || $options['type'] == 'cm' || $options['type'] == 'fm' || $options['type'] == 'cfm')) { ?>
<section class="section-map <?= $params['style'] ?>">
    <?php if ($options['type'] == 'm' && (!empty($options['pretext']) || $params['show_title'])) { ?>
        <div class="my-container">
            <?php if ($params['show_title']) { ?>
                <h3 class="h3 heading-3 font-weight-bold text-center text-capitalize"><?= $params['title'] ?></h3>
            <?php } ?>
            <?php if (!empty($options['pretext'])) { ?>
                <p class="text-center"><?= $options['pretext'] ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="my-container">
        <div id="map" class="img-fluid w-100" style="height:400px;"></div>
    </div>
</section>
<?php
$long_map = Yii::$app->params['siteSettings']->long_map;
$lat_map = Yii::$app->params['siteSettings']->lat_map;
$name = Yii::$app->name;
$address = Yii::$app->params['siteSettings']->translate->address_map;
$script = <<< JS
ymaps.ready(init);
function init() {
    var myMap = new ymaps.Map("map", {
        center: [${long_map}, ${lat_map}],
        zoom: 15
    }, {
        searchControlProvider: 'yandex#search'
    });
    var glyphIcon1 = new ymaps.Placemark([${long_map}, ${lat_map}], {
        balloonContent: '${address}',
        iconCaption: "${name}"
    }, {
        preset: 'islands#glyphIcon',
        iconGlyph: 'circle-red-cross',
        iconGlyphColor: '#0095e5',
        iconColor: '#0095e5'
    });
    myMap.geoObjects.add(glyphIcon1);
}
JS;
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang='.Yii::$app->language.'&amp;apikey=da839d07-6cb6-4cbf-9cc2-89a213d5497e');
$this->registerJs($script, yii\web\View::POS_READY);
}