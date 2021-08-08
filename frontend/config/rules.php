<?php
return [
    'sitemap.xml' => 'sitemap/index',

    '' => 'page/index',

    'cabinet/<_a:(login|logout)>' => 'user/security/<_a>',
    'cabinet/<_a:(register|resend)>' => 'user/registration/<_a>',
    'cabinet/forgot' => 'user/recovery/request',
    'cabinet/recover/<id:\d+>/<code:[A-Za-z0-9_\-]+>' => 'user/recovery/reset',
    'cabinet/confirm/<id:\d+>/<code:[A-Za-z0-9_\-]+>' => 'user/registration/confirm',
    'cabinet/orders/<number:[\w_\-]+>/<_a:[\w_\-]+>' => 'user/orders/<_a>',
    'cabinet/orders/<number:[\w_\-]+>' => 'user/orders/view',
    'cabinet/orders' => 'user/orders/index',
    'cabinet/wishlist/<_a:[\w_\-]+>' => 'user/wishlist/<_a>',
    'cabinet/wishlist' => 'user/wishlist/index',
    'cabinet/profile/<_a:[\w_\-]+>' => 'user/settings/<_a>',
    'cabinet/address/<_a:[\w_\-]+>' => 'user/address/<_a>',
    'cabinet/<_a:[\w_\-]+>' => 'user/profile/<_a>',
    'cabinet' => 'user/profile/index',

    'shop/cart/<_a:[\w_\-]+>' => 'cart/<_a>',
    'shop/cart' => 'cart/index',

    'shop/page<page:\d+>' => 'shop/index',
    'shop' => 'shop/index',
    'shop/category/<categoryalias:[\w_\-]+>/page<page:\d+>' => 'shop/category',
    'shop/category/<categoryalias:[\w_\-]+>' => 'shop/category',
    'shop/vendor/<alias:[\w_\-]+>/page<page:\d+>' => 'shop/brand',
    'shop/vendor/<alias:[\w_\-]+>' => 'shop/brand',
    'shop/product/<alias:[\w_\-]+>' => 'shop/product',

    'checkout/<_a:[\w_\-]+>' => 'checkout/<_a>',
    'checkout' => 'checkout/index',

    'blog/category/<categoryalias:[\w_\-]+>/page<page:\d+>' => 'posts/category',
    'blog/category/<categoryalias:[\w_\-]+>' => 'posts/category',
    'blog/post/<alias:[\w_\-]+>' => 'posts/view',
    'blog/page<page:\d+>' => 'posts/index',
    'blog' => 'posts/index',

    '<_c:(site)>/<_a:[\w_\-]+>' => '<_c>/<_a>',

    'search' => 'page/search',
    '<alias:[\w_\-]+>' => 'page/view',

    '/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
    '/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    '/<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
    '/<_c:[\w\-]+>' => '<_c>/index',
];
