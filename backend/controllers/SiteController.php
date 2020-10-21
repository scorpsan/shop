<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

class SiteController extends AppController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'error', 'reset-cache'],
                        'allow' => true,
                        'roles' => ['adminPanel'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionResetCache() {
        Yii::$app->cache->flush();
        Yii::$app->getSession()->setFlash('success', 'Cache Cleared...');
        return $this->redirect('index');
    }

}