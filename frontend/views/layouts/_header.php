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
    <span class="box-title"><?= Html::img(['@images/logo-dark.png'], ['alt' => Yii::$app->name]) ?></span>
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
                <?= Html::a('Акции', ['/page/view', 'alias' => 'actions'], ['title' => 'Акции', 'class' => 'slide-dropdown']) ?>
            </li>
            <li class="menu-item">
                <?= Html::a('Полезные статьи', ['/post/index'], ['title' => 'Полезные статьи', 'class' => 'slide-dropdown']) ?>
            </li>
            <li class="menu-item">
                <?= Html::a('Контакты', ['/page/view', 'alias' => 'contacts'], ['title' => 'Контакты', 'class' => 'slide-dropdown']) ?>
            </li>
        </ul>
    </div>
</div>
<div class="menu-overlay"></div>
<?php if (Yii::$app->params['searchOnSite']) { ?>
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
<?php } ?>
<?php if (Yii::$app->params['shopOnSite']) { ?>
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
<?php } ?>
<div class="js-bg bg-canvas-overlay"></div>
<!-- MENU POPUP -->
<header class="js-header <?= $this->context->headerClass ?> header-destop">
    <div class="my-container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-8 col-lg-8">
                <div class="row align-items-center">
                    <div class="col-4__header-home2 logo">
                        <?= Html::a(Html::img(['@images/logo.png'], ['alt' => Yii::$app->name]), ['/page/index'], ['title' => Yii::$app->name]) ?>
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
                                <?= Html::a(Yii::t('frontend', 'Акции'), ['/page/view', 'alias' => 'actions'], ['title' => Yii::t('frontend', 'Акции'), 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                            <li class="nav-item top-nav-items">
                                <?= Html::a(Yii::t('frontend', 'Полезные статьи'), ['/post/index'], ['title' => Yii::t('frontend', 'Полезные статьи'), 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                            <li class="nav-item top-nav-items">
                                <?= Html::a(Yii::t('frontend', 'Контакты'), ['/page/view', 'alias' => 'contacts'], ['title' => Yii::t('frontend', 'Контакты'), 'class' => 'nav-link top-nav-link']) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-10 col-10 header-right">
                <?php if (Yii::$app->params['searchOnSite']) { ?>
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
                <?php } ?>
                <?= Html::a('<i class="fas fa-user"></i>', ['/user/profile/index'], ['title' => Yii::t('frontend', 'My Account'), 'class' => 'btn-login-icon']) ?>
                <?php if (Yii::$app->params['shopOnSite']) { ?>
                <div class="js-cart-pull-right cart">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="number">
                        <span class="qty-in-cart"><?= Yii::$app->session->get('cart.qty', 0) ?></span>
                    </div>
                </div>
                <?php } ?>
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
                <?= Html::a(Html::img(['@images/logo.png'], ['alt' => Yii::$app->name]), ['/page/index'], ['title' => Yii::$app->name]) ?>
            </div>
            <div class="right-box">
                <?php if (Yii::$app->params['searchOnSite']) { ?>
                <div class="search">
                    <?= Html::a('<i class="fas fa-search"></i>', '#', ['title' => Yii::t('frontend', 'Search'), 'class' => 'js-search']) ?>
                </div>
                <?php } ?>
                <div class="login">
                    <?= Html::a('<i class="fas fa-user"></i>', ['/user/profile/index'], ['title' => Yii::t('frontend', 'My Account'), 'class' => 'btn-login-icon']) ?>
                </div>
                <?php if (Yii::$app->params['shopOnSite']) { ?>
                <div class="js-cart-pull-right cart">
                    <div class="shopping-cart">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="number">
                        <span class="qty-in-cart"><?= Yii::$app->session->get('cart.qty', 0) ?></span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </header>
</div>