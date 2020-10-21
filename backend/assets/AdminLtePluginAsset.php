<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AdminLtePluginAsset extends AssetBundle {

    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $js = [
        'plugins/iCheck/icheck.min.js',
        'bower_components/select2/dist/js/select2.full.min.js',
    ];
    public $css = [
        'plugins/iCheck/all.css',
        'bower_components/select2/dist/css/select2.min.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}