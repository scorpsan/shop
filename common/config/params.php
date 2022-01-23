<?php
return [
    'adminEmail' => '',
    'supportEmail' => '',
    'senderEmail' => '',
    'senderName' => '',
    //SEO params
    'title' => '',
    'seotitle' => '',
    'keywords' => '',
    'description' => '',
    // User
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'userCountry' => 'BELARUS',
    'userCountryCode' => 'BY',
    'userTimeZone' => 'Europe/Minsk',
    'userPhoneCode' => 375,
    // Coming Soon
    'comingSoon' => false,
    'comingSoonDate' => '31-12-2022 00:00',
    // Search
    'searchOnSite' => false,
    // Shop
    'shopOnSite' => false,
    // Language
    'defaultLanguage' => 'ru',
    // Site Menu
    'listType' => [
        'mainmenu' => 'Main Menu',
        'footermenu' => 'Footer Menu',
        'privacymenu' => 'Privacy Menu',
        'accountmenu' => 'Account Menu',
    ],
    // Page and Category style
    'pageStyle' => [
        '0' => [
            'key' => 0,
            'title' => 'Landing with slider (dark bg)',
            'breadbg' => false,
            'layouts' => 'page',
            'headclass' => 'header-v2 header-absolute',
        ],
        '1' => [
            'key' => 1,
            'title' => 'Landing with slider (light bg)',
            'breadbg' => false,
            'layouts' => 'page',
            'headclass' => 'header-v2 header-absolute',
        ],
        '6' => [
            'key' => 6,
            'title' => 'Landing without slider but with breadcrumb section',
            'breadbg' => true,
            'layouts' => 'page',
            'headclass' => 'header-v2 header-absolute',
        ],
        '2' => [
            'key' => 2,
            'title' => 'Landing without slider and breadcrumb section',
            'breadbg' => false,
            'layouts' => 'pagesite',
            'headclass' => 'header-v2 header-v1',
        ],
    ],
    'categoryStyle' => [
        '6' => [
            'key' => 6,
            'title' => 'With breadcrumb section',
            'breadbg' => true,
            'layouts' => 'page',
            'headclass' => 'header-v2 header-absolute',
        ],
        '2' => [
            'key' => 2,
            'title' => 'Without breadcrumb section',
            'breadbg' => false,
            'layouts' => 'pagesite',
            'headclass' => 'header-v2 header-v1',
        ],
    ],
    // Section style
    'sectionStyle' => [
        'bg-white' => 'White',
        'bg-smoke' => 'Smoke',
    ],
    // Text Align List
    'textAlignList' => [
        'text-left' => 'Text Left',
        'text-center' => 'Text Center',
        'text-right' => 'Text Right'
    ],
    // Images
    'avatarImagesSize' => [99, 99],
    // Widgets List
    'widgetsList' => [
        'SwiperWidget' => [
            'class' => \common\models\Swiper::class,
            'id' => 'SwiperWidget',
            'title' => 'Swiper Slider',
            'params' => [
                'show_title' => false,
                'style' => false,
                'text_align' => true,
                'background' => false,
                'parallax' => false,
            ],
            'options' => [],
        ],
        'CallFormWidget' => [
            'id' => 'CallFormWidget',
            'title' => 'Call Request Form',
            'params' => [
                'show_title' => true,
                'style' => true,
                'text_align' => false,
                'background' => true,
                'parallax' => true,
            ],
            'options' => [
                'type' => [
                    'title' => Yii::t('backend', 'Choose Type...'),
                    'dropList' => [
                        'default' => 'Default',
                        'div' => 'Div',
                        'modal' => 'Modal',
                    ],
                ],
            ],
        ],
        'ContactFormWidget' => [
            'id' => 'ContactFormWidget',
            'title' => 'Contact Form',
            'params' => [
                'show_title' => true,
                'style' => true,
                'text_align' => false,
                'background' => true,
                'parallax' => true,
            ],
            'options' => [
                'type' => [
                    'title' => Yii::t('backend', 'Choose Type...'),
                    'dropList' => [
                        'default' => 'Default',
                        'div' => 'Div',
                        'modal' => 'Modal',
                    ],
                ],
            ],
        ],
        'Contacts' => [
            'id' => 'Contacts',
            'title' => 'Contact information',
            'params' => [
                'show_title' => true,
                'style' => true,
                'text_align' => false,
                'background' => true,
                'parallax' => true,
            ],
            'options' => [
                'type' => [
                    'title' => Yii::t('backend', 'Choose Type...'),
                    'dropList' => [
                        'c' => 'Contacts Only',
                        'f' => 'Form Only',
                        'm' => 'Map Only',
                        'cf' => 'Contacts + Form',
                        'cm' => 'Contacts + Map',
                        'fm' => 'Form + Map',
                        'cfm' => 'Contacts + Form + Map',
                    ],
                ],
                'pretext' => [
                    'title' => Yii::t('backend', 'Insert PreText'),
                    'text' => '',
                ],
            ],
        ],
        'ProductsWidget' => [
            'id' => 'ProductsWidget',
            'title' => 'Products Widget',
            'params' => [
                'show_title' => true,
                'style' => false,
                'text_align' => false,
                'background' => false,
                'parallax' => false,
            ],
            'options' => [
                'type' => [
                    'title' => Yii::t('backend', 'Choose Type...'),
                    'dropList' => [
                        'new' => 'New Arrivals',
                        'rnd' => 'Random Products',
                        'hit' => 'Hits Sales',
                        'act' => 'Actions Products',
                        'rat' => 'High Ratings Products'
                    ],
                ],
                'count' => [
                    'title' => Yii::t('backend', 'Count Product'),
                    'dropList' => [0 => 'All in one page', 4 => '4 - one row', 8 => '8 - 2 rows', 12 => '12 - 3 rows'],
                ],
            ],
        ],

        //'LatestNews' => ['title' => 'Latest Posts'],
        //['id' => 'Gallery', 'title' => 'Portfolio on Main'],
        //['id' => 'ItemTestimonials', 'title' => 'Testimonials'],
        //['id' => 'OurTeam', 'title' => 'Our Team'],
        //['id' => 'Partners', 'title' => 'Partners'],
        //['id' => 'Map', 'title' => 'Map Small'],
        //['id' => 'MapFull', 'title' => 'Map Full Width'],
    ],
    'bsVersion' => '3.x',
    // Настройки из базы
    'siteSettings' => [],
];
