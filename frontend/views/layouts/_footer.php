<?php
/**
 * @var $this   View
 */

use frontend\models\Menus;
use frontend\widgets\Menu;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

$style = 'white'; /* '' or 'white' */
$params = Yii::$app->params;
?>
<!-- Page Footer-->
<footer class="footer-v1">
    <div class="footer-top border-bot">
        <div class="container-fluid my-container">
            <div class="row">
                <div class="footer-column-1 col-xl-3 col-lg-4 col-sm-6 col-12 order-sm-4 order-md-1 mb-4">
                    <h3><?= Yii::t('frontend', 'Contacts') ?></h3>
                    <div class="footer-address">
                        <?php if (!empty($params['siteSettings']->translates[Yii::$app->language]->address)) { ?>
                            <span class="fas fa-home"></span>
                            <p class="mb-0"><?= str_replace("\n", "<br>", $params['siteSettings']->translates[Yii::$app->language]->address) ?></p>
                        <?php } ?>
                    </div>
                    <div class="footer-tel">
                        <span class="fas fa-phone"></span>
                        <p class="mb-0">
                            <?= Yii::t('frontend', 'Phones') ?>: <?= Html::a($params['siteSettings']->phone, 'callto:'.preg_replace('/[^+0-9]/', '', $params['siteSettings']->phone)) ?><br>
                            <?php if (!empty($params['siteSettings']->contact_phone)) {
                                $contactPhone = explode("\n", $params['siteSettings']->contact_phone);
                                foreach ($contactPhone as $phone) {
                                    echo Html::a($phone, 'callto:'.preg_replace('/[^+0-9]/', '', $phone)) . '<br>';
                                }
                            } ?>
                        </p>
                    </div>
                    <div class="footer-email">
                        <span class="fas fa-envelope"></span>
                        <p class="mb-0">Email: <?= Html::a($params['supportEmail'], 'mailto:'.$params['supportEmail']) ?></p>
                    </div>
                    <div class="footer-clock">
                        <?php if (!empty($params['siteSettings']->translates[Yii::$app->language]->opening_hours)) { ?>
                            <span class="fas fa-clock"></span>
                            <p class="mb-0"><?= str_replace("\n", "<br>", $params['siteSettings']->translates[Yii::$app->language]->opening_hours) ?></p>
                        <?php } ?>
                    </div>
                    <div class="payment-method">
                        <img src="/files/bez-fona-s-tenju.png" alt="Payment Method" style="width:100%">
                        <img alt="" src="/files/MTBank-color.png" style="height:49px;" />
                    </div>
                </div>
                <div class="footer-column-2 col-xl-3 col-lg-2 col-sm-6 col-12 order-sm-1 order-md-2 mb-4">
                    <?= $params['siteSettings']->translates[Yii::$app->language]->about_footer ?>
                </div>
                <div class="footer-column-3 col-xl-3 col-lg-3 col-sm-6 col-12 order-sm-2 order-md-3 mb-4">
                    <h3><?= Yii::t('frontend', 'Information') ?></h3>
                    <ul class="list-unstyled mb-0">
                        <li><?= Html::a(Yii::t('frontend', 'Доставка и оплата'), ['/page/view', 'alias' => 'delivery'], ['title' => Yii::t('frontend', 'Доставка и оплата')]) ?></li>
                        <li><?= Html::a(Yii::t('frontend', 'Возврат'), ['/page/view', 'alias' => 'return'], ['title' => Yii::t('frontend', 'Возврат')]) ?></li>
                        <li><?= Html::a(Yii::t('frontend', 'Конфиденциальность'), ['/page/view', 'alias' => 'privacy'], ['title' => Yii::t('frontend', 'Конфиденциальность')]) ?></li>
                        <li><?= Html::a(Yii::t('frontend', 'Договор'), ['/page/view', 'alias' => 'oferta'], ['title' => Yii::t('frontend', 'Договор')]) ?></li>
                    </ul>
                    <?php if (($items = Menus::getMenuItems('footermenu')) !== null) { ?>
                        <h3><?= Yii::t('frontend', 'Information') ?></h3>
                        <?= Menu::widget([
                            'items' => $items,
                            'activateParents' => true,
                            'options' => ['class' => 'list-unstyled mb-0'],
                        ]); ?>
                    <?php } ?>
                    <?php if (($items = Menus::getMenuItems('accountmenu')) !== null) { ?>
                        <h3><?= Yii::t('frontend', 'My Account') ?></h3>
                        <?= Menu::widget([
                            'items' => $items,
                            'activateParents' => true,
                            'options' => ['class' => 'list-unstyled mb-0'],
                        ]); ?>
                    <?php } ?>
                </div>
                <div class="footer-column-4 banner-item2 col-xl-3 col-lg-3 col-sm-6 col-12 order-sm-4 order-md-4 d-none d-sm-block">
                    <img src="/files/badkitty-b.png" class="img-fluid w-100" alt="BadKitty Shop">
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-capitalize text-center">
        <div class="container-fluid my-container">
            <div class="row">
                <div class="col-md-6 col-12 text-md-left">
                    <p class="desc mb-0">Copyright <i class="fa fa-copyright"></i> <?= date('Y') ?> by <a href="#"><?= Yii::$app->name ?></a>. All Rights Reserved. Powered by <a href="https://web-made.biz" target="_blank">Web-Made.biz</a></p>
                </div>
                <div class="socials col-md-6 col-12 text-md-right">
                    <span>Follow us:</span>
                    <?php if (!empty($params['siteSettings']->link_to_facebook)) { ?>
                        <a title="Facebook" href="<?= $params['siteSettings']->link_to_facebook ?>" class="socials-item"><i class="fab fa-facebook"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->link_to_vk)) { ?>
                        <a title="VK" href="<?= $params['siteSettings']->link_to_vk ?>" class="socials-item"><i class="fab fa-vk"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->link_to_instagram)) { ?>
                        <a title="Instagram" href="<?= $params['siteSettings']->link_to_instagram ?>" class="socials-item"><i class="fab fa-instagram"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->link_to_pinterest)) { ?>
                        <a title="Pinterest" href="<?= $params['siteSettings']->link_to_pinterest ?>" class="socials-item"><i class="fab fa-pinterest"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->link_to_youtube)) { ?>
                        <a title="Youtube" href="<?= $params['siteSettings']->link_to_youtube ?>" class="socials-item"><i class="fab fa-youtube"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->link_to_twitter)) { ?>
                        <a title="Twitter" href="<?= $params['siteSettings']->link_to_twitter ?>" class="socials-item"><i class="fab fa-twitter"></i></a>
                    <?php } ?>
                    <?php //Icon Links to messengers ?>
                    <?php if (!empty($params['siteSettings']->whatsapp_phone)) { ?>
                        <a title="WhatsApp" href="whatsapp://send?phone=<?= preg_replace('/[^+0-9]/', '', $params['siteSettings']->whatsapp_phone) ?>" class="socials-item"><i class="fab fa-whatsapp"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->viber_phone)) { ?>
                        <a title="Viber" href="viber://chat?number=<?= preg_replace('/[^+0-9]/', '', $params['siteSettings']->viber_phone) ?>" class="socials-item"><i class="fab fa-viber"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->telegram_nick)) { ?>
                        <a title="Telegram" href="tg://resolve?domain=<?= $params['siteSettings']->telegram_nick ?>" class="socials-item"><i class="fab fa-telegram-plane"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['siteSettings']->skype_nick)) { ?>
                        <a title="Skype" href="skype:<?= $params['siteSettings']->skype_nick ?>?call" class="socials-item"><i class="fab fa-skype"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="back-to-top">
    <span><a href="javascript:void(0)"><i class="fas fa-chevron-up"></i></a></span>
</div>

<div class="error-popup engo-popup">
    <div class="overlay"></div>
    <div class="popup-inner content">
        <div class="error-message"></div>
    </div>
</div>
<div class="product-popup engo-popup d-mobile-none">
    <div class="overlay"></div>
    <div class="content">
        <a href="javascript:void(0)" class="close-window"><i class="fas fa-times"></i></a>
        <div class="mini-product-item row">
            <div class="col-md-3 col-sm-3 product-image f-left">
                <img alt="img" src="<?= Yii::getAlias('@images/nophoto.svg') ?>" style="max-width:120px; height:auto"/>
            </div>
            <div class="col-md-9 col-sm-9 f-left">
                <div class="product-info f-left">
                    <p class="product-name"></p>
                    <p class="success-message"></p>
                </div>
                <div class="actions mt-0">
                    <button class="continue-shopping shop-button"><?= Yii::t('frontend', 'Continue') ?></button>
                    <button class="shop-button" onclick="window.location='<?= Url::to(['/cart/index']) ?>'"><?= Yii::t('frontend', 'View Cart') ?></button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php if (!Yii::$app->user->isGuest) { ?>
<div class="wishlist-popup engo-popup d-mobile-none">
    <div class="overlay"></div>
    <div class="content">
        <a href="javascript:void(0)" class="close-window"><i class="fas fa-times"></i></a>
        <div class="mini-product-item row">
            <div class="col-md-3 col-sm-3 product-image f-left">
                <img alt="img" src="<?= Yii::getAlias('@images/nophoto.svg') ?>" style="max-width:120px; height:auto"/>
            </div>
            <div class="col-md-9 col-sm-9 f-left">
                <div class="product-info f-left">
                    <p class="product-name"></p>
                    <p class="success-message"></p>
                </div>
                <div class="actions mt-0">
                    <button class="continue-shopping shop-button"><?= Yii::t('frontend', 'Continue') ?></button>
                    <button class="shop-button" onclick="window.location='<?= Url::to(['/user/wishlist/index']) ?>'"><?= Yii::t('frontend', 'My Wish List') ?></button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php } ?>