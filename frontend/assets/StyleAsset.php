<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class StyleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Barlow:400,700&display=swap',
        '//fonts.googleapis.com/css?family=Roboto&display=swap',
        '/css/transition.min.css',
        '/css/slick-theme.min.css',
        '/css/slick.min.css',
    ];
    public $js = [];
    public $depends = [
        'frontend\assets\FontAwesome5Asset',
    ];
}
