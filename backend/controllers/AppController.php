<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\helpers\HtmlPurifier;

/**
 * Class AppController
 * @package backend\controllers
 */
class AppController extends Controller
{
    /**
     * @param $arr
     */
    public static function debug($arr)
    {
        echo '<pre style="text-align: left;">' . print_r($arr, true) . '</pre>';
    }

    /**
     * @param $text
     * @return string
     */
    public static function purifier($text)
    {
        $pr = new HtmlPurifier;
        return $pr->process($text);
    }

}