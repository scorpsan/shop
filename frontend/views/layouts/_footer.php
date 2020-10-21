<?php
use frontend\widgets\Menu;
use yii\helpers\Html;

$items = \frontend\models\Menus::getMenuItems('footermenu');
?>
<!-- Page Footer-->
<footer>
    <section class="section-footer footer-home2">
        <div class="my-container">
            <div class="row no-gutters">
                <div class="col-xl-3 col-lg-3 col-md-6 padding-bot-30">
                    <h3><?= Yii::t('frontend', 'Contacts') ?></h3>
                    <ul class="navbar-nav">
                        <li><i class="lnr lnr-home"></i>1234 Heaven Stress, Beverly Hill</li>
                        <li><i class="lnr lnr-phone"></i>Telephone: +01 234 567 89</li>
                        <li><i class="lnr lnr-envelope"></i>Email: <a href="#">example@domain.com</a></li>
                        <li><i class="lnr lnr-clock"></i>8:00 - 19:00, Monday - Saturday</li>
                        <li>
                            <ul class="list-child">
                                <li>
                                    <img src="/images/f-01.png" alt="_img-footer">
                                </li>
                                <li>
                                    <img src="/images/f-02.png" alt="_img-footer">
                                </li>
                                <li>
                                    <img src="/images/f-03.png" alt="_img-footer">
                                </li>
                                <li>
                                    <img src="/images/f-04.png" alt="_img-footer">
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 padding-bot-30">
                    <h3>my account</h3>
                    <ul>
                        <li><a href="#">my account</a></li>
                        <li><a href="#">login</a></li>
                        <li><a href="#">my cart</a></li>
                        <li><a href="#">wishlist</a></li>
                        <li><a href="#">checkout</a></li>
                    </ul>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 padding-bot-30">
                    <h3>information</h3>
                    <ul>
                        <li><a href="about-us.html">about us</a></li>
                        <li><a href="#">careers</a></li>
                        <li><a href="#">delivery information</a></li>
                        <li><a href="#">privacy policy </a></li>
                        <li><a href="#">terms & condition</a></li>
                    </ul>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 image-effect-home2 padding-bot-30">
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
<?php if(Yii::$app->layout == 'error_old') { ?>
<section class="pre-footer-corporate">
    <div class="container">
        <div class="row justify-content-sm-center justify-content-lg-start row-30 row-md-60">
            <div class="col-sm-10 col-md-6 col-lg-10 <?= (!empty($items))?'col-xl-3':'col-xl-6' ?>">
                <h6><?= Yii::t('frontend', 'About') ?></h6>
                <p><?= Yii::$app->params['siteSettings']->translates[Yii::$app->language]->about_footer ?></p>
            </div>
            <?php if (!empty($items)) { ?>
            <div class="col-sm-10 col-md-6 col-lg-3 col-xl-3">
                <?= Menu::widget([
                    'items' => $items,
                    'options' => ['class' => 'list-linked'],
                    'activateParents' => true,
                ]); ?>
            </div>
            <?php } ?>
            <div class="col-sm-10 col-md-6 col-lg-5 col-xl-3">
                <h6><?= Yii::t('frontend', 'Recent Comments') ?></h6>
                <ul class="list-sm">
                    <li>
                        <article class="post-inline">
                            <div class="post-inline__header"><a class="post-inline__author meta-author" href="standard-post.html">Brian on</a>
                                <p class="post-inline__link"><a href="standard-post.html">Kylie Jenner’s Sexy Wrap Dress is Still Available for under $70</a></p>
                            </div>
                        </article>
                    </li>
                    <li>
                        <article class="post-inline">
                            <div class="post-inline__header"><a class="post-inline__author meta-author" href="standard-post.html">Brian on</a>
                                <p class="post-inline__link"><a href="standard-post.html">Person of the Week: Mark Armstrong Peddigrew</a></p>
                            </div>
                        </article>
                    </li>
                </ul>
            </div>
            <div class="col-sm-10 col-md-6 col-lg-4 col-xl-3">
                <h6><?= Yii::t('frontend', 'Contacts') ?></h6>
                <ul class="list-xs">
                    <li>
                        <dl class="list-terms-minimal">
                            <dt><?= Yii::t('frontend', 'Address') ?></dt>
                            <dd><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translates[Yii::$app->language]->address) ?></dd>
                        </dl>
                    </li>
                    <li>
                        <dl class="list-terms-minimal">
                            <dt><?= Yii::t('frontend', 'Phones') ?></dt>
                            <dd>
                                <ul class="list-semicolon">
                                    <?= '<li>' . Html::a(Yii::$app->params['siteSettings']->phone, 'callto:'.preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->phone)) . '</li>' ?>
                                    <?php if (!empty(Yii::$app->params['siteSettings']->contact_phone)) {
                                        $contactPhone = explode("\n", Yii::$app->params['siteSettings']->contact_phone);
                                        foreach ($contactPhone as $phone) {
                                            echo '<li>' . Html::a($phone, 'callto:'.preg_replace('/[^+0-9]/', '', $phone)) . '</li>';
                                        }
                                    } ?>
                                </ul>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl class="list-terms-minimal">
                            <dt><?= Yii::t('frontend', 'Email') ?></dt>
                            <dd><?= Html::a(Yii::$app->params['supportEmail'], 'mailto:'.Yii::$app->params['supportEmail']) ?></dd>
                        </dl>
                    </li>
                    <?php if (!empty(Yii::$app->params['siteSettings']->translates[Yii::$app->language]->opening_hours_full)) { ?>
                    <li>
                        <dl class="list-terms-minimal">
                            <dt><?= Yii::t('frontend', 'We are open') ?></dt>
                            <dd><?= str_replace("\n", "<br>", Yii::$app->params['siteSettings']->translates[Yii::$app->language]->opening_hours_full) ?></dd>
                        </dl>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php } ?>