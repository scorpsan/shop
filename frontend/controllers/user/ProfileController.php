<?php
namespace frontend\controllers\user;

use Da\User\Controller\ProfileController as BaseProfileController;
use frontend\models\ProfileAddress;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use Yii;
use yii\web\NotFoundHttpException;

class ProfileController extends BaseProfileController
{
    public $backBreadcrumbs;
    public $headerClass;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'show'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->view->title = Yii::$app->name . ' | ' . Yii::t('frontend', 'My Account');
        Yii::$app->layout = Yii::$app->params['pageStyle'][2]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][2]['headclass'];
        $this->backBreadcrumbs = false;
    }

    public function actionIndex()
    {
        $profile = $this->profileQuery->whereUserId(Yii::$app->user->id)->one();

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $userAddresses = ProfileAddress::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $this->render('index', [
            'profile' => $profile,
            'userAddresses' => $userAddresses,
        ]);
    }

    public function actionShow($id)
    {
        return $this->redirect(['index']);
    }

}