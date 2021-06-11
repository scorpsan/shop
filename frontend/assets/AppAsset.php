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
        '/css/style.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.5/mobile-detect.min.js',
        '/js/slick.min.js',
        '/js/jquery.countdown.js',
        '/js/jquery.barrating.min.js',
        '/js/store.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'frontend\assets\StyleAsset',
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
