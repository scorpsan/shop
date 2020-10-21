<?php
namespace backend\controllers;

use yii\helpers\HtmlPurifier;

class AppController extends \yii\web\Controller {

    public static function debug($arr) {
        echo '<pre style="text-align: left;">' . print_r($arr, true) . '</pre>';
    }

    public static function purifier($text) {
        $pr = new HtmlPurifier;
        return $pr->process($text);
    }

}