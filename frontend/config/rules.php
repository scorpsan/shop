<?php
return [
    '' => 'page/index',

    'cabinet' => 'user/profile/index',
    'cabinet/<_a:(login|logout)>' => 'user/security/<_a>',
    'cabinet/<_a:(register|resend)>' => 'user/registration/<_a>',
    'cabinet/forgot' => 'user/recovery/request',
    'cabinet/recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/recovery/reset',
    'cabinet/confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/registration/confirm',
    'cabinet/address/<_a:[\w\-]+>' => 'user/address/<_a>',
    'cabinet/wishlist' => 'user/wishlist/index',
    'cabinet/wishlist/<_a:[\w\-]+>' => 'user/wishlist/<_a>',
    'cabinet/profile/<_a:[\w\-]+>' => 'user/settings/<_a>',
    'cabinet/<_a:[\w_-]+>' => 'user/profile/<_a>',

    '/shop/cart' => '/cart/index',
    '/shop/cart/<_a:[\w_-]+>' => '/cart/<_a>',
    '/shop/all' => 'shop/index',
    '/shop/all/page<page:\d+>' => 'shop/index',
    '/shop/category/<categoryalias:[\w_-]+>' => 'shop/category',
    '/shop/category/<categoryalias:[\w_-]+>/page<page:\d+>' => 'shop/category',
    '/shop/vendor/<brandalias:[\w_-]+>' => 'shop/brand',
    '/shop/vendor/<brandalias:[\w_-]+>/page<page:\d+>' => 'shop/brand',
    '/shop/product/<alias:[\w_-]+>' => 'shop/product',

    '/search' => 'page/search',
    '/<alias:[\w_-]+>' => 'page/view',
    '/<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
    '/<_c:[\w\-]+>' => '<_c>/index',
    '/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
    '/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
];
