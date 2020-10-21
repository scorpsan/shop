<?php
namespace frontend\controllers;

use Yii;

class SiteController extends AppController {

    public $conTitle;

    public function init() {
        $this->conTitle = Yii::t('frontend', 'Site');
        parent::init();
        $this->setMeta(Yii::$app->name, Yii::$app->params['keywords'], Yii::$app->params['description']);
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionComingSoon() {
        $this->setMeta(Yii::$app->name . ' - ' . Yii::t('frontend', 'This Site is Coming Soon'), Yii::$app->params['keywords'], Yii::$app->params['description']);
        Yii::$app->layout = 'coming-soon';
        return $this->render('coming-soon');
    }

}