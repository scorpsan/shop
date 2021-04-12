<?php
namespace frontend\controllers\user;

use Da\User\Controller\SecurityController as BaseSecurityController;
use Yii;

class SecurityController extends BaseSecurityController
{
    public $backBreadcrumbs;
    public $headerClass;

    public function init()
    {
        parent::init();
        $this->view->title = Yii::$app->name . ' - ' . Yii::t('frontend', 'My Profile');
        Yii::$app->layout = Yii::$app->params['pageStyle'][2]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][2]['headclass'];
        $this->backBreadcrumbs = false;
    }

}