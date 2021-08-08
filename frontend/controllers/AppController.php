<?php
namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\helpers\HtmlPurifier;

class AppController extends Controller
{
    public $title;
    public $headerClass;
    public $backBreadcrumbs;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        Yii::$app->layout = Yii::$app->params['pageStyle'][2]['layouts'];
        $this->title = Yii::$app->name;
        $this->headerClass = Yii::$app->params['pageStyle'][2]['headclass'];
        $this->backBreadcrumbs = Yii::getAlias('@files/breadcrumbs-image-default.jpg');
    }

    /**
     * @param null $title
     * @param null $keywords
     * @param null $description
     */
    public function setMeta($title = null, $keywords = null, $description = null) {
        $this->view->title = implode(' - ', [$title, Yii::$app->name]);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);
    }

    /**
     * @param $arr
     */
    public static function debug($arr) {
        echo '<pre style="text-align: left;">' . print_r($arr, true) . '</pre>';
    }

    /**
     * @param $text
     * @return string
     */
    public static function purifier($text) {
        $pr = new HtmlPurifier;
        return $pr->process($text);
    }

}