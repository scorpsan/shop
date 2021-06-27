<?php
namespace frontend\controllers\user;

use Da\User\Controller\RecoveryController as BaseRecoveryController;
use Yii;

class RecoveryController extends BaseRecoveryController
{
    public $backBreadcrumbs;
    public $headerClass;

    public function init()
    {
        parent::init();
        $this->view->title = Yii::$app->name . ' | ' . Yii::t('usuario', 'Recover your password');
        Yii::$app->layout = Yii::$app->params['pageStyle'][2]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][2]['headclass'];
        $this->backBreadcrumbs = false;
    }

}
