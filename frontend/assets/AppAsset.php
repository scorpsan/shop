<?php
namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Barlow:400,700&display=swap',
        '//fonts.googleapis.com/css?family=Roboto&display=swap',
        '/css/style.css',
        '/css/themes.css',
    ];
    public $js = [
        '/js/jquery.barrating.min.js',
        '/js/jquery.countdown.min.js',
        '/js/slick.js',
        '/js/store.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'frontend\assets\FontAwesome5Asset',
    ];
    public $cssOptions = [
        'async' => 'async',
    ];
    public $jsOptions = [
        //'async' => 'async',
    ];

    public function init() {
        parent::init();
        // resetting Assets to not load own files
        //Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = false;
        //Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapPluginAsset'] = false;
    }
}
