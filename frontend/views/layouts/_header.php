<?php
/**
 * @var $params array
 */
use frontend\widgets\Menu;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$params = Yii::$app->params;
?>
<!-- Page header-->
<!-- BOX MOBILE MENU  -->
<div class="box-mobile-menu">
    <span class="box-title"><?= Html::img(['/images/logo-dark.png'], ['alt' => Yii::$app->name]) ?></span>
    <a href="javascript:void(0)" class="close-menu" id="pull-closemenu">
        <i class="fas fa-times"></i>
    </a>
    <ul class="nav justify-content-center social-icon">
        <?php if (!empty($params['siteSettings']->link_to_facebook)) { ?>
            <li class="nav-item"><a title="Facebook" href="<?= $params['siteSettings']->link_to_facebook ?>" class="nav-link"><i class="fab fa-facebook"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->link_to_vk)) { ?>
            <li class="nav-item"><a title="VK" href="<?= $params['siteSettings']->link_to_vk ?>" class="nav-link"><i class="fab fa-vk"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->link_to_instagram)) { ?>
            <li class="nav-item"><a title="Instagram" href="<?= $params['siteSettings']->link_to_instagram ?>" class="nav-link"><i class="fab fa-instagram"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->link_to_pinterest)) { ?>
            <li class="nav-item"><a title="Pinterest" href="<?= $params['siteSettings']->link_to_pinterest ?>" class="nav-link"><i class="fab fa-pinterest"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->link_to_youtube)) { ?>
            <li class="nav-item"><a title="Youtube" href="<?= $params['siteSettings']->link_to_youtube ?>" class="nav-link"><i class="fab fa-youtube"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->link_to_twitter)) { ?>
            <li class="nav-item"><a title="Twitter" href="<?= $params['siteSettings']->link_to_twitter ?>" class="nav-link"><i class="fab fa-twitter"></i></a></li>
        <?php } ?>
        <?php //Icon Links to messengers ?>
        <?php if (!empty($params['siteSettings']->whatsapp_phone)) { ?>
            <li class="nav-item"><a title="WhatsApp" href="whatsapp://send?phone=<?= preg_replace('/[^+0-9]/', '', $params['siteSettings']->whatsapp_phone) ?>" class="nav-link"><i class="fab fa-whatsapp"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->viber_phone)) { ?>
            <li class="nav-item"><a title="Viber" href="viber://chat?number=<?= preg_replace('/[^+0-9]/', '', $params['siteSettings']->viber_phone) ?>" class="nav-link"><i class="fab fa-viber"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->telegram_nick)) { ?>
            <li class="nav-item"><a title="Telegram" href="tg://resolve?domain=<?= $params['siteSettings']->telegram_nick ?>" class="nav-link"><i class="fab fa-telegram-plane"></i></a></li>
        <?php } ?>
        <?php if (!empty($params['siteSettings']->skype_nick)) { ?>
            <li class="nav-item"><a title="Skype" href="skype:<?= $params['siteSettings']->skype_nick ?>?call" class="nav-link"><i class="fab fa-skype"></i></a></li>
        <?php } ?>
    </ul>
    <div class="menu-clone">
        <ul class="main-menu">
            <li class="menu-item">
                <?= Html::a('Главная', ['/page/index'], ['title' => Yii::$app->name, 'class' => 'slide-dropdown']) ?>
            </li>
            <li class="menu-item">
                <?= Html::a('Каталог', ['/shop/index'], ['title' => 'Каталог', 'class' => 'slide-dropdown']) ?>
            </li>
            <li class="menu-item">
                <?= Html::a('Акции', ['/news/category', 'alias' => 'actions'], ['title' => 'Акции', 'class' => 'slide-dropdown']) ?>
            </li>
            <li class="menu-item">
                <?= Html::a('Полезные статьи', ['/blog/index'], ['title' => 'Полезные статьи', 'class' => 'slide-dropdown']) ?>
            </li>
            <li class="menu-item">
                <?= Html::a('Контакты', ['/page/view', 'alias' => 'contacts'], ['title' => 'Контакты', 'class' => 'slide-dropdown']) ?>
            </li>
        </ul>
    </div>
</div>
<div class="menu-overlay"></div>
<!-- box search mobile -->
<div class="form-search__destop">
    <?php $form = ActiveForm::begin([
        'id' => 'search-form',
        'action' => ['/page/search'],
        'options' => ['class' => 'mobile-nav-search-form'],
    ]); ?>
        <div class="search">
            <span class="fas fa-search"></span>
        </div>
        <div class="mobile-nav-search-close">
            <span class="fas fa-times"></span>
        </div>
        <?= Html::input('search', 'search', '', ['placeholder' => Yii::t('frontend', 'Search'), 'autocomplete' => 'off', 'class' => 'input-block-level search-query']) ?>
        <div class="autocomplete-results">
            <ul class="ui-autocomplete ui-front"></ul>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<!-- add to cart  -->
<div class="js-cart-popup header-cart-content">
    <?php Pjax::begin(['id' => 'mini-cart-pjax']); ?>
        <h3 class="minicart-title text-center"><?= Yii::t('frontend', 'Your Cart') ?></h3>
        <span class="closebtn minicart-close fas fa-times"></span>
        <span class="minicart-number qty-in-cart"><?= Yii::$app->session->get('cart.qty', 0) ?></span>
        <div class="minicart-scroll" data-url="<?= Url::to(['/cart/mini-cart']) ?>">
        </div>
    <?php Pjax::end(); ?>
</div>
<div class="js-bg bg-canvas-overlay"></div>
<!-- MENU POPUP -->
<header class="js-header <?= $this->context->headerClass ?> header-destop">
    <div class="my-container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-8 col-lg-8">
                <div class="row align-items-center">
                    <div class="col-4__header-home2 logo">
                        <?= Html::a(Html::img(['/images/logo.png'], ['alt' => Yii::$app->name]), ['/page/index'], ['title' => Yii::$app->name]) ?>
                    </div>
                    <div class="col-8__header-home2 navbar-home2">
                        <ul class="nav">
                            <li class="nav-item top-nav-items">
                                <?= Html::a('Главная', ['/page/index'], ['title' => Yii::$app->name, 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                            <li class="nav-item top-nav-items">
                                <?= Html::a('Каталог', ['/shop/index'], ['title' => 'Каталог', 'class' => 'nav-link top-nav-link']) ?>
                                <div class="submenu-header" >
                                    <div class="my-container">
                                        <div class="row">
                                            <div class="col-3">
                                                <ul>
                                                    <li><?= Html::a('Игрушки', ['/shop/category', 'categoryalias' => 'igruski'], ['title' => 'Игрушки']) ?></li>
                                                    <li><?= Html::a('Интимная косметика', ['/shop/category', 'categoryalias' => 'intim-cosmetics'], ['title' => 'Интимная косметика']) ?></li>
                                                    <li><?= Html::a('BDSM', ['/shop/category', 'categoryalias' => 'bdsm'], ['title' => 'BDSM']) ?></li>
                                                    <li><?= Html::a('Эротическая одежда', ['/shop/category', 'categoryalias' => 'erotic-clothes'], ['title' => 'Эротическая одежда']) ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Игрушки</h4>
                                                <ul>
                                                    <li><?= Html::a('Анальные украшения', ['/shop/category', 'categoryalias' => 'anal-decoration'], ['title' => 'Анальные украшения']) ?></li>
                                                    <li><?= Html::a('Анальные игрушки', ['/shop/category', 'categoryalias' => 'anal-toys'], ['title' => 'Анальные игрушки']) ?></li>
                                                    <li><?= Html::a('Вагинальные шарики и тренажеры', ['/shop/category', 'categoryalias' => 'vaginalnye-sariki'], ['title' => 'Вагинальные шарики и тренажеры']) ?></li>
                                                    <li><?= Html::a('Вибраторы', ['/shop/category', 'categoryalias' => 'vibratory'], ['title' => 'Вибраторы']) ?></li>
                                                    <li><?= Html::a('Игрушки из стекла', ['/shop/category', 'categoryalias' => 'galss-toys'], ['title' => 'Игрушки из стекла']) ?></li>
                                                    <li><?= Html::a('Фаллоимитаторы', ['/shop/category', 'categoryalias' => 'falloimitatory'], ['title' => 'Фаллоимитаторы']) ?></li>
                                                    <li><?= Html::a('Эрекционные кольца', ['/shop/category', 'categoryalias' => 'erectionie-kolca'], ['title' => 'Эрекционные кольца']) ?></li>
                                                    <li><?= Html::a('Насадки на пенис', ['/shop/category', 'categoryalias' => 'nasadki-na-penis'], ['title' => 'Насадки на пенис']) ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Интимная косметика</h4>
                                                <ul>
                                                    <li><?= Html::a('Смазки и лубриканты', ['/shop/category', 'categoryalias' => 'smazki-i-lubrikanty'], ['title' => 'Смазки и лубриканты']) ?></li>
                                                    <li><?= Html::a('Уход за игрушками', ['/shop/category', 'categoryalias' => 'uhod-za-igruskami'], ['title' => 'Уход за игрушками']) ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>BDSM</h4>
                                                <ul>
                                                    <li><?= Html::a('Кляпы и маски', ['/shop/category', 'categoryalias' => 'gag-mask'], ['title' => 'Кляпы и маски']) ?></li>
                                                    <li><?= Html::a('Наручники и фиксаторы', ['/shop/category', 'categoryalias' => 'narucniki-fiksatory'], ['title' => 'Наручники и фиксаторы']) ?></li>
                                                    <li><?= Html::a('Плети, кнуты, стеки', ['/shop/category', 'categoryalias' => 'pleti-knuty-steki'], ['title' => 'Плети, кнуты, стеки']) ?></li>
                                                    <li><?= Html::a('Ошейники, поводки', ['/shop/category', 'categoryalias' => 'osejniki-povodki'], ['title' => 'Ошейники, поводки']) ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item top-nav-items">
                                <?= Html::a(Yii::t('frontend', 'Акции'), ['/news/category', 'alias' => 'actions'], ['title' => Yii::t('frontend', 'Акции'), 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                            <li class="nav-item top-nav-items">
                                <?= Html::a(Yii::t('frontend', 'Полезные статьи'), ['/blog/index'], ['title' => Yii::t('frontend', 'Полезные статьи'), 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                            <li class="nav-item top-nav-items">
                                <?= Html::a(Yii::t('frontend', 'Контакты'), ['/page/view', 'alias' => 'contacts'], ['title' => Yii::t('frontend', 'Контакты'), 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-10 col-10 header-right">
                <?php $form = ActiveForm::begin([
                    'id' => 'search-form2',
                    'action' => ['/page/search'],
                ]); ?>
                    <div class="input-group">
                        <?= Html::input('search', 'search', '', ['placeholder' => Yii::t('frontend', 'Search'), 'class' => 'form-control']) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <?= Html::a('<i class="fas fa-user"></i>', ['/user/profile/index'], ['title' => Yii::t('frontend', 'My Account'), 'class' => 'btn-login-icon']) ?>
                <div class="js-cart-pull-right cart">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="number">
                        <span class="qty-in-cart"><?= Yii::$app->session->get('cart.qty', 0) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="menu-mobile">
    <header class="header-mobile nav-down">
        <div class="header-menu">
            <div class="menu">
                <i class="fas fa-bars js-click-megamenu"></i>
            </div>
            <div class="logo">
                <?= Html::a(Html::img(['/images/logo.png'], ['alt' => Yii::$app->name]), ['/page/index'], ['title' => Yii::$app->name]) ?>
            </div>
            <div class="right-box">
                <div class="search">
                    <?= Html::a('<i class="fas fa-search"></i>', '#', ['title' => Yii::t('frontend', 'Search'), 'class' => 'js-search']) ?>
                </div>
                <div class="login">
                    <?= Html::a('<i class="fas fa-user"></i>', ['/user/profile/index'], ['title' => Yii::t('frontend', 'My Account'), 'class' => 'btn-login-icon']) ?>
                </div>
                <div class="js-cart-pull-right cart">
                    <div class="shopping-cart">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="number">
                        <span class="qty-in-cart"><?= Yii::$app->session->get('cart.qty', 0) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<?php /*
<header class="page-header">
    <!-- RD Navbar-->
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-default" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-sm-device-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-stick-up-clone="false" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-lg-stick-up-offset="120px" data-xl-stick-up-offset="35px" data-xxl-stick-up-offset="35px">
            <!-- RD Navbar Top Panel-->
            <div class="rd-navbar-top-panel rd-navbar-search-wrap">
                <div class="rd-navbar-top-panel__main">
                    <div class="rd-navbar-top-panel__toggle rd-navbar-fixed__element-1 rd-navbar-static--hidden" data-rd-navbar-toggle=".rd-navbar-top-panel__main"><span></span></div>
                    <div class="rd-navbar-top-panel__content">
                        <div class="rd-navbar-top-panel__left">
                            <p><?= Yii::$app->name ?></p>
                        </div>
                        <div class="rd-navbar-top-panel__right">
                            <ul class="rd-navbar-items-list">
                                <?php if (Yii::$app->getModule('user')->enableRegistration) { ?>
                                <li>
                                    <ul class="list-inline-xxs">
                                    <?php if (Yii::$app->user->isGuest) { ?>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/user/security/login']) ?>" title="<?= Yii::t('frontend', 'Sign In') ?>"><?= Yii::t('frontend', 'Sign In') ?></a></li>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/user/registration/register']) ?>" title="<?= Yii::t('frontend', 'Create an Account') ?>"><?= Yii::t('frontend', 'Create an Account') ?></a></li>
                                    <?php } else { ?>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/user/profile/index']) ?>" title="<?= Yii::t('frontend', 'Profile') ?>"><?= Yii::t('frontend', 'Profile') . ' (' . Yii::$app->user->identity->username . ')' ?></a></li>
                                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/user/security/logout']) ?>" title="<?= Yii::t('frontend', 'Sign Out') ?>" data-method="post"><?= Yii::t('frontend', 'Sign Out') ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?= $this->render('_lang') ?>
                                <li>
                                    <ul class="list-inline-xxs">
                                        <?php if (!empty(Yii::$app->params['siteSettings']->link_to_facebook)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-facebook" title="Facebook" href="<?= Yii::$app->params['siteSettings']->link_to_facebook ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->link_to_vk)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-vk" title="VK" href="<?= Yii::$app->params['siteSettings']->link_to_vk ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->link_to_instagram)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-instagram" title="Instagram" href="<?= Yii::$app->params['siteSettings']->link_to_instagram ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->link_to_pinterest)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-pinterest" title="Pinterest" href="<?= Yii::$app->params['siteSettings']->link_to_pinterest ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->link_to_youtube)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-youtube" title="Youtube" href="<?= Yii::$app->params['siteSettings']->link_to_youtube ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->link_to_twitter)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-twitter" title="Twitter" href="<?= Yii::$app->params['siteSettings']->link_to_twitter ?>"></a></li>
                                        <?php } ?>
                                        <?php //Icon Links to messengers ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->whatsapp_phone)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-whatsapp" title="WhatsApp" href="whatsapp://send?phone=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->whatsapp_phone) ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->viber_phone)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-viber" title="Viber" href="viber://chat?number=<?= preg_replace('/[^+0-9]/', '', Yii::$app->params['siteSettings']->viber_phone) ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->telegram_nick)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-telegram-plane" title="Telegram" href="tg://resolve?domain=<?= Yii::$app->params['siteSettings']->telegram_nick ?>"></a></li>
                                        <?php } ?>
                                        <?php if (!empty(Yii::$app->params['siteSettings']->skype_nick)) { ?>
                                            <li><a class="icon icon-xxs icon-gray-4 fab fa-skype" title="Skype" href="skype:<?= Yii::$app->params['siteSettings']->skype_nick ?>?call"></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if (Yii::$app->params['searchOnSite'] || Yii::$app->params['shopOnSite']) { ?>
                <div class="rd-navbar-top-panel__aside">
                    <ul class="rd-navbar-items-list">
                        <?php if (Yii::$app->params['searchOnSite']) { ?>
                        <li>
                            <div class="rd-navbar-fixed__element-2">
                                <button class="rd-navbar-search__toggle rd-navbar-search__toggle_additional" data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
                            </div>
                        </li>
                        <?php } ?>
                        <?php if (Yii::$app->params['shopOnSite']) { ?>
                        <li>
                            <div class="rd-navbar-fixed__element-3"><a class="icon icon-md linear-icon-cart link-gray-4" href="#"></a></div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                <?php if (Yii::$app->params['searchOnSite']) { ?>
                <!-- RD Search-->
                <div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
                    <form class="rd-search" action="<?= Yii::$app->urlManager->createUrl(['/page/default/search']) ?>" method="GET">
                        <div class="form-wrap">
                            <input class="form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off" placeholder="<?= Yii::t('frontend', 'Enter keyword and hit Enter...') ?>">
                        </div>
                        <button class="rd-search__submit" type="submit" aria-label="<?= Yii::t('frontend', 'Search') ?>"></button>
                    </form>
                    <div class="rd-navbar-fixed--hidden">
                        <button class="rd-navbar-search__toggle" data-custom-toggle=".rd-navbar-search-wrap" data-custom-toggle-disable-on-blur="true"></button>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="rd-navbar-inner">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                    <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                    <!-- RD Navbar Brand-->
                    <div class="rd-navbar-brand"><?= Html::a(Html::img(['/images/logo-retina.png'], ['width' => 144, 'height' => 25, 'alt' => Yii::$app->name]), ['/'], ['title' => Yii::$app->name, 'class' => 'brand-name']) ?></div>
                </div>
                <!-- RD Navbar Nav-->
                <div class="rd-navbar-nav-wrap">
                    <div class="rd-navbar-nav-wrap__element"><?php // CallFormWidget::widget(['options' => ['type' => 'modal']]) ?></div>
                    <?php
                    $items = \frontend\models\Menus::getMenuItems('mainmenu');
                    $items = [
                    [ 'label' => Yii::t('frontend', 'Home'), 'url' => ['/page/default/main'] ],

                    [ 'label' => Yii::t('frontend', 'Courses'), 'url' => ['/page/default/page', 'alias' => 'courses'] ],
                    [ 'label' => Yii::t('frontend', 'About School'), 'url' => ['/page/default/page', 'alias' => 'about'] ],
                    [ 'label' => Yii::t('frontend', 'Contacts'), 'url' => ['/page/default/page', 'alias' => 'contacts'] ],
                    ];
                    if (!empty($items)) { ?>
                        <?= Menu::widget([
                            'items' => $items,
                            'options' => [
                                'class' => 'rd-navbar-nav',
                            ],
                            'activeCssClass' => 'active',
                            'activateParents' => true,
                            'submenuTemplate' => '<ul class="rd-navbar-dropdown">{items}</ul>'."\n",
                        ]); ?>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
</header>
*/