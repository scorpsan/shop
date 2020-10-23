<?php
use frontend\widgets\Menu;
use yii\helpers\Html;
//use frontend\widgets\CallFormWidget;
?>
<!-- Page header-->
<!-- BOX MOBILE MENU  -->
<div class="box-mobile-menu">
    <span class="box-title"><img src="img/logo_eurotas.png" alt="_img logo"></span>
    <a href="javascript:void(0)" class="close-menu" id="pull-closemenu">
        <i class="fas fa-times"></i>
    </a>
    <ul class="nav justify-content-center social-icon" >
        <li class="nav-item"><a href="javascript:void(0)" class="nav-link"><i class="fa fa-facebook-f"></i></a></li>
        <li class="nav-item"><a href="javascript:void(0)" class="nav-link"><i class="fa fa-twitter"></i></a></li>
        <li class="nav-item"><a href="javascript:void(0)" class="nav-link"><i class="fa fa-pinterest-p"></i></a></li>
        <li class="nav-item"><a href="javascript:void(0)" class="nav-link"><i class="fa fa-youtube"></i></a></li>
        <li class="nav-item"><a href="javascript:void(0)" class="nav-link"><i class="fa fa-instagram"></i></a></li>
    </ul>
    <div class="menu-clone">
        <ul class="main-menu">
            <li class="menu-item menu-item-has-children">
                <a href="javascript:void(0)" class="slide-dropdown">Home <span class="fas fa-chevron-right down"></span></a>
                <div class="submenu">
                    <ul class="menu-shop-style">
                        <li class="style-item"><a class="menu-link nav-link" href="homepage-v1.html">Home 1</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="homepage-v2.html">Home 2</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="homepage-v3.html">Home 3</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="homepage-v4.html">Home 4</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="homepage-v5.html">Home 5</a></li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="javascript:void(0)" class="slide-dropdown">Collection <span class="fas fa-chevron-right down"></span></a>
                <div class="submenu">
                    <ul class="menu-shop-style">
                        <li class="style-item"><a class="menu-link nav-link" href="grid-slidebar-left.html">Grid Slidebar Left</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="list-slidebar-left.html">List Slidebar Left</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="shop-page.html">Shop Page</a></li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="javascript:void(0)"  class="slide-dropdown">Product <span class="fas fa-chevron-right down"></span></a>
                <div class="submenu">
                    <ul class="menu-shop-style">
                        <li class="style-item"><a class="menu-link nav-link" href="product-detail-v1.html">Product Detail V1</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="product-detail-v2.html">Product Detail V2</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="product-detail-v3.html">Product Detail V3</a></li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="javascript:void(0)" class="slide-dropdown">Blog <span class="fas fa-chevron-right down"></span></a>
                <div class="submenu">
                    <ul class="menu-shop-style">
                        <li class="style-item"><a class="menu-link nav-link" href="blog-post.html">Blog Post</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="our-blog-v1.html">Our Blog V1</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="our-blog-v2.html">Our Blog V2</a></li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="javascript:void(0)" class="slide-dropdown">Page <span class="fas fa-chevron-right down"></span></a>
                <div class="submenu">
                    <ul class="menu-shop-style">
                        <li class="style-item"><a class="menu-link nav-link" href="about-us.html">About us</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="contact-us.html">Contact us</a></li>
                        <li class="style-item"><a class="menu-link nav-link" href="#">Wishlist</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="image-effect ">
            <a href="javascript:void()0">
                <img src="img/banner-menu.jpg" alt="_img banner menu" class="img-fluid w-100">
            </a>
        </div>
    </div>
</div>
<div class="menu-overlay"></div>

<!-- box search mobile -->
<div class="form-search__destop">
    <form action="/search" method="POST" role="search" class="mobile-nav-search-form">
        <div class="search">
            <span class="fas fa-search"></span>
        </div>
        <div class="mobile-nav-search-close">
            <span class="fas fa-times"></span>
        </div>
        <input type="search" name="search" class="input-block-level search-query" placeholder="Search" autocomplete="off" data-old-term="search">
        <div class="autocomplete-results">
            <ul class="ui-autocomplete ui-front"></ul>
        </div>
        <input type="hidden" name="type" value="product">
    </form>
</div>

<!-- add to cart  -->
<div class="js-cart-popup product-checkout">
    <div class="mini-content ">
        <h3 class="mini-cart-title text-center">Your Cart</h3>
        <span class="minicart-numbers-items">1</span>
        <span class="closebtn">&times;</span>
        <div class="prod">
            <div class="product-cart ">
                <ol class="minicart-item" style="list-style: none">
                    <li class="product-cart-item">
                        <a href="javascript:void(0)" class="product-media"><img class="img-fluid" width="100" height="100" src="img/12.jpg" alt="_img-add to cart"></a>
                    </li>
                    <li class="product-detail">
                        <h3 class="product-name">
                            <a href="javascript:void(0)">Wilfred Madine Blouse</a>
                        </h3>
                        <div class="product-detail-info">
                            <span class="product-quantity">Women's Tank : </span>
                            <span class="product-cost">$115</span>
                        </div>
                    </li>
                    <li class="product-remove">
                        <span class="remove-product">&times;</span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="sub-total">
            <span class="total-title float-left">Total :</span>
            <span class="total-price float-right">$115</span>
        </div>
        <div class="action-checkout">
            <a href="<?= Yii::$app->urlManager->createUrl(['/shop/cart']) ?>" class="button-viewcart">
                <span><?= Yii::t('frontend', 'View Cart') ?></span>
            </a>
            <a href="<?= Yii::$app->urlManager->createUrl(['/shop/checkout']) ?>" class="button-checkout">
                <span><?= Yii::t('frontend', 'Checkout') ?></span>
            </a>
        </div>
    </div>
</div>

<div class="js-bg bg-canvas-overlay"></div>
<!-- search popup -->
<div class="search-destop">
    <div class="js-box-search search-eurotas">
        <div class="drawer-search-top">
            <h3 class="drawer-search-heading">Type the keyword or SKU</h3>
        </div>
        <form action="/search" class="form-search" method="POST">
            <input type="search" name="search" placeholder="Search anything" class="input-search">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="close-search">
            <a href="javascript:void(0)" class="js-close-search fas fa-times"></a>
        </div>
    </div>
    <div class="bg-search">
    </div>
</div>
<!-- POPUP LOGIN -->
<div class="popup-login__eurotas">
    <div class="popup-login__destop">
        <div class="popup-login__content">
            <div class="box_content_accountdestop">
                <div class="logo-eurotas">
                    <a href="javascript:void(0)">
                        <img src="img/logo_eurotas.png" alt="_img logo Eurotas">
                    </a>
                </div>
                <h3 class="popup-heading">Great to have you back!</h3>
                <div class="form-login">
                    <form action="/action_page.php" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pwd" placeholder="Password" required>
                        </div>
                        <div class="form-check">
                            <a href="javascript:void(0)" class="recover-password">Forgot your password?</a>
                        </div>
                        <button type="submit" class="btn-login w-100" value="log in">LOG IN</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="close__popup-login">
            <a href="javascript:void(0)" class="js-close__popup-login fas fa-times"></a>
        </div>
    </div>
    <div class="popup-register__destop ">
        <div class="popup-register__content ">
            <div class="logo-eurotas">
                <a href="javascript:void(0)">
                    <img src="img/logo_eurotas.png" alt="_img logo Eurotas">
                </a>
            </div>
            <h3 class="popup-heading">Create account</h3>
            <div class="form-login form-register">
                <div class="form-group">
                    <input type="text" class="form-control" name="firstName" placeholder="First name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="lastName" placeholder="Last name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email address" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pwd" placeholder="Password" required>
                </div>
                <button type="submit" class="btn-login w-50" value="register">CREATE</button>
            </div>
        </div>
        <div class="close__popup-login">
            <a href="javascript:void(0)" class="js-close__popup-login fas fa-times"></a>
        </div>
    </div>
    <div class="bg__popup-login"></div>
</div>
<!-- POPUP REGISTER -->
<!-- MENU POPUP -->

<header class="js-header header-destop header-top header--<?= (Yii::$app->layout == 'pagesite') ? 'v1' : 'v2' ?> ">
    <div class="my-container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-xl-8 col-lg-8">
                <div class="row align-items-center">
                    <div class="col-4__header-home2 logo">
                        <?= Html::a(Html::img(['/images/logo.png'], ['alt' => Yii::$app->name]), ['/page/index'], ['title' => Yii::$app->name]) ?>
                    </div>
                    <div class="col-8__header-home2 navbar-home2">
                        <ul class="nav">
                            <li class="nav-item top-nav-items">
                                <a href="javascript:void(0)" class="js-menu-header nav-link top-nav-link" >Home</a>
                                <div class="submenu-header" >
                                    <div class="my-container">
                                        <div class="row">
                                            <div class="col-3">
                                                <ul>
                                                    <li><a href="homepage-v1.html">Home 1</a></li>
                                                    <li><a href="homepage-v2.html">Home 2</a></li>
                                                    <li><a href="homepage-v3.html">Home 3</a></li>
                                                    <li><a href="homepage-v4.html">Home 4</a></li>
                                                    <li><a href="homepage-v5.html">Home 5</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Product</h4>
                                                <ul>
                                                    <li><a href="product-detail-v1.html">Product Detail 1</a></li>
                                                    <li><a href="product-detail-v2.html">Product Detail 2</a></li>
                                                    <li><a href="product-detail-v3.html">Product Detail 3</a></li>
                                                </ul>
                                                <h4 class="mt-3">
                                                    Our Blog
                                                </h4>
                                                <ul>
                                                    <li><a href="our-blog-v1.html">Our Blog 1</a></li>
                                                    <li><a href="our-blog-v2.html">Our Blog 2</a></li>
                                                    <li><a href="blog-post.html">Blog Post</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Collection</h4>
                                                <ul>
                                                    <li><a href="grid-slidebar-left.html">Grid Slidebar Left</a></li>
                                                    <li><a href="list-slidebar-left.html">List Slidebar Left</a></li>
                                                    <li><a href="shop-page.html">Shop Page</a></li>
                                                </ul>
                                                <h4 class="mt-3">
                                                    Page
                                                </h4>
                                                <ul>
                                                    <li><a href="about-us.html">About Us</a></li>
                                                    <li><a href="contact-us.html">Contact Us</a></li>
                                                    <li><a href="#">wishlist</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <div class="img image-effect">
                                                    <a href="javascript:void(0)"><img src="img/banner-submenu.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item top-nav-items">
                                <a href="javascript:void(0)" class="nav-link top-nav-link">Men</a>
                                <div class="submenu-header" >
                                    <div class="my-container">
                                        <div class="row">
                                            <div class="col-3">
                                                <ul>
                                                    <li><a href="javascript:void(0)">New Arrival</a></li>
                                                    <li><a href="javascript:void(0)">Best Sellers</a></li>
                                                    <li><a href="javascript:void(0)">Release Dates</a></li>
                                                    <li><a href="javascript:void(0)">Resolution Ready</a></li>
                                                    <li><a href="javascript:void(0)">Sale</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Shoes</h4>
                                                <ul>
                                                    <li><a href="javascript:void(0)">SNKRS Launch Calendar</a></li>
                                                    <li><a href="javascript:void(0)">Life style</a></li>
                                                    <li><a href="javascript:void(0)">Running</a></li>
                                                    <li><a href="javascript:void(0)">Training & Gym</a></li>
                                                    <li><a href="javascript:void(0)">Basketball</a></li>
                                                    <li><a href="javascript:void(0)">Jordan</a></li>
                                                    <li><a href="javascript:void(0)">Football</a></li>
                                                    <li><a href="javascript:void(0)">Soccer</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Clothing</h4>
                                                <ul>
                                                    <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                    <li><a href="javascript:void(0)">Shorts</a></li>
                                                    <li><a href="javascript:void(0)">Polos</a></li>
                                                    <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                    <li><a href="javascript:void(0)">Jacket & Vests</a></li>
                                                    <li><a href="javascript:void(0)">Pants & Tights </a></li>
                                                    <li><a href="javascript:void(0)">Surt & Swimwear</a></li>
                                                    <li><a href="javascript:void(0)">Nike Pro & Compression</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <div class="img image-effect">
                                                    <a href="javascript:void(0)"><img src="img/banner-submenu.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item top-nav-items">
                                <a href="javascript:void(0)" class="nav-link top-nav-link">Women</a>
                                <div class="submenu-header">
                                    <div class="my-container">
                                        <div class="row">
                                            <div class="col-3">
                                                <h4>Featured</h4>
                                                <ul>
                                                    <li><a href="javascript:void(0)">New Arrival</a></li>
                                                    <li><a href="javascript:void(0)">Best Sellers</a></li>
                                                    <li><a href="javascript:void(0)">Release Dates</a></li>
                                                    <li><a href="javascript:void(0)">Sale</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Shoes</h4>
                                                <ul>
                                                    <li><a href="javascript:void(0)">SNKRS Launch Calendar</a></li>
                                                    <li><a href="javascript:void(0)">Life style</a></li>
                                                    <li><a href="javascript:void(0)">Running</a></li>
                                                    <li><a href="javascript:void(0)">Training & Gym</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Clothing</h4>
                                                <ul>
                                                    <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                    <li><a href="javascript:void(0)">Shorts</a></li>
                                                    <li><a href="javascript:void(0)">Polos</a></li>
                                                    <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-3">
                                                <h4>Sports</h4>
                                                <ul>
                                                    <li><a href="javascript:void(0)">Running</a></li>
                                                    <li><a href="javascript:void(0)">Soccer</a></li>
                                                    <li><a href="javascript:void(0)">Basketball</a></li>
                                                    <li><a href="javascript:void(0)">Football</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="img-banne image-effectr">
                                            <a href="javascript:void(0)">
                                                <img src="img/megamenu-banner2.jpg" alt="_img banner megamenu" class="img-fluid w-100">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item top-nav-items">
                                <a href="javascript:void(0)" class="nav-link top-nav-link">Kids</a>
                                <div class="submenu-header" >
                                    <div class="my-container">
                                        <div class="row">
                                            <div class="col-3">
                                                <ul class="tabs">
                                                    <li class="tabs-link current" data-tab="tab-4">New Arrival</li>
                                                    <li class="tabs-link" data-tab="tab-5">Best Sellers</li>
                                                    <li class="tabs-link" data-tab="tab-6">Release Dates</li>
                                                    <li class="tabs-link" data-tab="tab-7">Resolution Ready</li>
                                                    <li class="tabs-link" data-tab="tab-8">Sale</li>
                                                </ul>
                                            </div>
                                            <div class="col-9 tab-content current p-0" id="tab-4">
                                                <div class="row w-100 m-0">
                                                    <div class="col-4">
                                                        <h4>Shoes</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">SNKRS Launch Calendar</a></li>
                                                            <li><a href="javascript:void(0)">Life style</a></li>
                                                            <li><a href="javascript:void(0)">Running</a></li>
                                                            <li><a href="javascript:void(0)">Training & Gym</a></li>
                                                            <li><a href="javascript:void(0)">Basketball</a></li>
                                                            <li><a href="javascript:void(0)">Jordan</a></li>
                                                            <li><a href="javascript:void(0)">Football</a></li>
                                                            <li><a href="javascript:void(0)">Soccer</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4>Clothing</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                            <li><a href="javascript:void(0)">Shorts</a></li>
                                                            <li><a href="javascript:void(0)">Polos</a></li>
                                                            <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                            <li><a href="javascript:void(0)">Jacket & Vests</a></li>
                                                            <li><a href="javascript:void(0)">Pants & Tights </a></li>
                                                            <li><a href="javascript:void(0)">Surt & Swimwear</a></li>
                                                            <li><a href="javascript:void(0)">Nike Pro & Compression</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img image-effect">
                                                            <a href="javascript:void(0)"><img src="img/banner-submenu.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9 tab-content p-0" id="tab-5">
                                                <div class="row w-100 m-0">
                                                    <div class="col-4">
                                                        <h4>Shoes</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">SNKRS Launch Calendar</a></li>
                                                            <li><a href="javascript:void(0)">Life style</a></li>
                                                            <li><a href="javascript:void(0)">Running</a></li>
                                                            <li><a href="javascript:void(0)">Training & Gym</a></li>
                                                            <li><a href="javascript:void(0)">Basketball</a></li>
                                                            <li><a href="javascript:void(0)">Jordan</a></li>
                                                            <li><a href="javascript:void(0)">Football</a></li>
                                                            <li><a href="javascript:void(0)">Soccer</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4>Clothing</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                            <li><a href="javascript:void(0)">Shorts</a></li>
                                                            <li><a href="javascript:void(0)">Polos</a></li>
                                                            <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                            <li><a href="javascript:void(0)">Jacket & Vests</a></li>
                                                            <li><a href="javascript:void(0)">Pants & Tights </a></li>
                                                            <li><a href="javascript:void(0)">Surt & Swimwear</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img ">
                                                            <a href="javascript:void(0)"><img src="img/banner-submenu.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9 tab-content p-0" id="tab-6">
                                                <div class="row w-100 m-0">
                                                    <div class="col-4">
                                                        <h4>Featured</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">New Arrival</a></li>
                                                            <li><a href="javascript:void(0)">Best Sellers</a></li>
                                                            <li><a href="javascript:void(0)">Release Dates</a></li>
                                                            <li><a href="javascript:void(0)">Sale</a></li>
                                                            <li><a href="javascript:void(0)">Deal Of The Day</a></li>
                                                            <li><a href="javascript:void(0)">Gender Neureal</a></li>
                                                            <li><a href="javascript:void(0)">Resolution Ready </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4>Clothing</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                            <li><a href="javascript:void(0)">Shorts</a></li>
                                                            <li><a href="javascript:void(0)">Polos</a></li>
                                                            <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                            <li><a href="javascript:void(0)">Jacket & Vests</a></li>
                                                            <li><a href="javascript:void(0)">Pants & Tights </a></li>
                                                            <li><a href="javascript:void(0)">Surt & Swimwear</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img ">
                                                            <a href="javascript:void(0)"><img src="img/banner-submenu.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9 tab-content p-0" id="tab-7">
                                                <div class="row w-100 m-0">
                                                    <div class="col-4">
                                                        <h4>Shoes</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">SNKRS Launch Calendar</a></li>
                                                            <li><a href="javascript:void(0)">Life style</a></li>
                                                            <li><a href="javascript:void(0)">Running</a></li>
                                                            <li><a href="javascript:void(0)">Training & Gym</a></li>
                                                            <li><a href="javascript:void(0)">Basketball</a></li>
                                                            <li><a href="javascript:void(0)">Jordan</a></li>
                                                            <li><a href="javascript:void(0)">Football</a></li>
                                                            <li><a href="javascript:void(0)">Soccer</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4>Clothing</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                            <li><a href="javascript:void(0)">Shorts</a></li>
                                                            <li><a href="javascript:void(0)">Polos</a></li>
                                                            <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                            <li><a href="javascript:void(0)">Jacket & Vests</a></li>
                                                            <li><a href="javascript:void(0)">Pants & Tights </a></li>
                                                            <li><a href="javascript:void(0)">Surt & Swimwear</a></li>
                                                            <li><a href="javascript:void(0)">Nike Pro & Compression</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img image-effect">
                                                            <a href="javascript:void(0)"><img src="img/page2_footer.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9 tab-content p-0" id="tab-8">
                                                <div class="row w-100 m-0">
                                                    <div class="col-4">
                                                        <h4>Shoes</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">SNKRS Launch Calendar</a></li>
                                                            <li><a href="javascript:void(0)">Life style</a></li>
                                                            <li><a href="javascript:void(0)">Running</a></li>
                                                            <li><a href="javascript:void(0)">Training & Gym</a></li>
                                                            <li><a href="javascript:void(0)">Basketball</a></li>
                                                            <li><a href="javascript:void(0)">Jordan</a></li>
                                                            <li><a href="javascript:void(0)">Football</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4>Clothing</h4>
                                                        <ul>
                                                            <li><a href="javascript:void(0)">Tops & T-Shirts</a></li>
                                                            <li><a href="javascript:void(0)">Shorts</a></li>
                                                            <li><a href="javascript:void(0)">Polos</a></li>
                                                            <li><a href="javascript:void(0)">Hoodies & Sweatshirts</a></li>
                                                            <li><a href="javascript:void(0)">Jacket & Vests</a></li>
                                                            <li><a href="javascript:void(0)">Pants & Tights </a></li>
                                                            <li><a href="javascript:void(0)">Surt & Swimwear</a></li>
                                                            <li><a href="javascript:void(0)">Nike Pro & Compression</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img image-effect">
                                                            <a href="javascript:void(0)"><img src="img/banner-submenu.jpg" alt="_img banner submenu" class="img-fluid w-100"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item top-nav-items"><a href="javascript:void(0)" class="nav-link top-nav-link">Sports</a></li>
                            <li class="nav-item top-nav-items"><a href="javascript:void(0)" class="nav-link top-nav-link">Holiday</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-10 col-10 header-right">
                <form action="/action_page.php" method="POST">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" placeholder="Search">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
                <a href="javascript:void(0)" class="btn-login-icon js-popup-login">
                    <i class="fas fa-user"></i>
                </a>
                <div class="js-cart-pull-right cart">
                    <div class="shopping-cart">
                        <i class="fas fa-shopping-cart" style="color:#fff"></i>
                    </div>
                    <div class="number">
                        <span>1</span>
                    </div>
                </div>
                <div class="js-click-megamenu header-menu">
                    <i class="fas fa-bars" style="color:#fff"></i>
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
            <div class="add-to-cart">
                <div class="search">
                    <a href="javascript:void(0)" class="js-search fas fa-search"></a>
                </div>
                <div class="js-cart-pull-right cart">
                    <div class="shopping-cart">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="number">
                        <span>1</span>
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