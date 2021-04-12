<?php
namespace frontend\widgets\phoneInput;

use yii\web\AssetBundle;

class inputMaskAsset extends AssetBundle
{
	public $sourcePath = '@bower/inputmask';
	public $css = [
		'css/inputmask.css',
	];
	public $js = [
		'dist/min/jquery.inputmask.bundle.min.js',
	];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
