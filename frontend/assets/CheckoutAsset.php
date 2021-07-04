<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Checkout frontend application asset bundle.
 */
class CheckoutAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/checkout.min.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.5/mobile-detect.min.js',
        '/js/checkout.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
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
