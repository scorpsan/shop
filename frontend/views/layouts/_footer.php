<?php
use frontend\widgets\Menu;
use yii\helpers\Html;
?>
<!-- Page Footer-->
<footer>
    <section class="section-footer footer-home2">
        <div class="my-container">
            <div class="row no-gutters">
                <div class="col-xl-3 col-lg-3 col-md-6 padding-bot-30 order-sm-4 order-md-1">
                    <h3><?= Yii::t('frontend', 'Contacts') ?></h3>
                    <ul class="navbar-nav">
                        <?php if (!empty(Yii::$app->params['siteSettings']->translates[Yii::$app->language]->address)) { ?>
                            <li><i class="fas fa-home"></i><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translates[Yii::$app->language]->address) ?></li>
                        <?php } ?>
                        <li><i class="fas fa-phone"></i>
                            <?= Yii::t('frontend', 'Phones') ?>: <?= Html::a(Yii::$app->params['siteSettings']->phone, 'callto:'.preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->phone)) ?><br>
                            <?php if (!empty(Yii::$app->params['siteSettings']->contact_phone)) {
                                $contactPhone = explode("\n", Yii::$app->params['siteSettings']->contact_phone);
                                foreach ($contactPhone as $phone) {
                                    echo Html::a($phone, 'callto:'.preg_replace('/[^+0-9]/', '', $phone)) . '<br>';
                                }
                            } ?>
                        </li>
                        <li><i class="fas fa-envelope"></i>Email: <?= Html::a(Yii::$app->params['supportEmail'], 'mailto:'.Yii::$app->params['supportEmail']) ?></li>
                        <?php if (!empty(Yii::$app->params['siteSettings']->translates[Yii::$app->language]->opening_hours_full)) { ?>
                            <li><i class="fas fa-clock"></i><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translates[Yii::$app->language]->opening_hours_full) ?></li>
                        <?php } ?>
                        <li>
                            <a href="<?= \yii\helpers\Url::to(['page/view', 'alias' => 'delivery']) ?>" class="images">
                                <img src="/files/payment-white.png" class="img-fluid" alt="payment">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 padding-bot-30 order-sm-1 order-md-2">
                    <?php if (($items = \frontend\models\Menus::getMenuItems('accountmenu')) !== null) { ?>
                    <h3><?= Yii::t('frontend', 'my account') ?></h3>
                    <?= Menu::widget([
                        'items' => $items,
                        'activateParents' => true,
                    ]); ?>
                    <?php } ?>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 padding-bot-30 order-sm-2 order-md-3">
                    <?php if (($items = \frontend\models\Menus::getMenuItems('footermenu')) !== null) { ?>
                    <h3><?= Yii::t('frontend', 'information') ?></h3>
                    <?= Menu::widget([
                        'items' => $items,
                        'activateParents' => true,
                    ]); ?>
                    <?php } ?>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 image-effect-home2 padding-bot-30 order-sm-3 order-md-4">
                    <?= Yii::$app->params['siteSettings']->translates[Yii::$app->language]->about_footer ?>
                </div>
            </div>
        </div>
    </section>
    <section class="section-copyright">
        <div class="my-container copyright2019">
            <div>Copyright <i class="fa fa-copyright"></i> <?= date('Y') ?> by <a href="#"><?= Yii::$app->name ?></a>. All Rights Reserved. Powered by <a href="https://web-made.biz" target="_blank">Web-Made.biz</a></div>
            <ul>
                <li>Follow us:</li>
                <?php if (!empty(Yii::$app->params['siteSettings']->link_to_facebook)) { ?>
                    <li><a title="Facebook" href="<?= Yii::$app->params['siteSettings']->link_to_facebook ?>"><i class="fab fa-facebook"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->link_to_vk)) { ?>
                    <li><a title="VK" href="<?= Yii::$app->params['siteSettings']->link_to_vk ?>"><i class="fab fa-vk"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->link_to_instagram)) { ?>
                    <li><a title="Instagram" href="<?= Yii::$app->params['siteSettings']->link_to_instagram ?>"><i class="fab fa-instagram"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->link_to_pinterest)) { ?>
                    <li><a title="Pinterest" href="<?= Yii::$app->params['siteSettings']->link_to_pinterest ?>"><i class="fab fa-pinterest"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->link_to_youtube)) { ?>
                    <li><a title="Youtube" href="<?= Yii::$app->params['siteSettings']->link_to_youtube ?>"><i class="fab fa-youtube"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->link_to_twitter)) { ?>
                    <li><a title="Twitter" href="<?= Yii::$app->params['siteSettings']->link_to_twitter ?>"><i class="fab fa-twitter"></i></a></li>
                <?php } ?>
                <?php //Icon Links to messengers ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->whatsapp_phone)) { ?>
                    <li><a title="WhatsApp" href="whatsapp://send?phone=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->whatsapp_phone) ?>"><i class="fab fa-whatsapp"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->viber_phone)) { ?>
                    <li><a title="Viber" href="viber://chat?number=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->viber_phone) ?>"><i class="fab fa-viber"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->telegram_nick)) { ?>
                    <li><a title="Telegram" href="tg://resolve?domain=<?= Yii::$app->params['siteSettings']->telegram_nick ?>"><i class="fab fa-telegram-plane"></i></a></li>
                <?php } ?>
                <?php if (!empty(Yii::$app->params['siteSettings']->skype_nick)) { ?>
                    <li><a title="Skype" href="skype:<?= Yii::$app->params['siteSettings']->skype_nick ?>?call"><i class="fab fa-skype"></i></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
</footer>

<div class="back-to-top">
    <span>
        <a href="javascript:void(0)">
            <i class="lnr lnr-chevron-up-circle"></i>
        </a>
    </span>
</div>