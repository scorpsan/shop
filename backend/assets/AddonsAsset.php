<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AddonsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        '/admin/js/bootbox.all.min.js',
    ];
    public $depends = [
        'backend\assets\AdminLtePluginAsset',
    ];
}
