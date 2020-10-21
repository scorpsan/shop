<?php
namespace frontend\controllers;

use yii\helpers\HtmlPurifier;

class AppController extends \yii\web\Controller {

    public $backBreadcrumbs;

    public function init() {
        parent::init();
    }

    protected function setMeta($title = null, $keywords = null, $description = null) {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);
    }

    public static function debug($arr) {
        echo '<pre style="text-align: left;">' . print_r($arr, true) . '</pre>';
    }

    public static function purifier($text) {
        $pr = new HtmlPurifier;
        return $pr->process($text);
    }

}