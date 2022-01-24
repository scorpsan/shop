<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class SiteController extends AppController
{
    public $_session;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_session = Yii::$app->session;
        $this->_session->open();
        $this->setMeta(Yii::$app->name, Yii::$app->params['keywords'], Yii::$app->params['description']);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionComingSoon()
    {
        $this->setMeta(Yii::t('frontend', 'This Site is Coming Soon'), Yii::$app->params['keywords'], Yii::$app->params['description']);
        Yii::$app->layout = 'coming-soon';
        return $this->render('coming-soon', ['time' => Yii::$app->params['comingSoonDate']]);
    }

    public function actionRulesCheck()
    {
        $data = Yii::$app->request->post();

        if (empty($this->_session['answer']) && isset($data['answer'])) {
            if ($data['answer'] == 'yes') {
                $this->_session['answer'] = true;
            } else {
                $this->_session['answer'] = false;
            }
        }

        return $this->goBack();
    }

}