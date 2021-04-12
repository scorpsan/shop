<?php
namespace frontend\widgets\phoneInput;

use yii\web\AssetBundle;
use yii\web\View;

class phoneInputAsset extends AssetBundle
{
	public $sourcePath = (__DIR__ . '/assets');
	public $css = [
		'css/phoneCountry.css',
	];
	public $js = [
		'js/phone-codes.js',
		'js/jquery.inputmask-multi.min.js',
	];
	public $depends = [
		'frontend\widgets\phoneInput\inputMaskAsset',
	];
	public $jsOptions = [
		'position' => View::POS_END,
	];
	public $publishOptions = [
		'forceCopy'=>true,
	];

}