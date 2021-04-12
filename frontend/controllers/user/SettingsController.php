<?php
namespace frontend\controllers\user;

use Da\User\Controller\SettingsController as BaseSettingsController;
use Da\User\Event\UserEvent;
use Da\User\Model\User;
use Da\User\Service\TwoFactorQrCodeUriGeneratorService;
use Da\User\Validator\TwoFactorCodeValidator;
use frontend\forms\SettingsForm;
use Da\User\Validator\AjaxRequestModelValidator;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SettingsController extends BaseSettingsController
{
    public $backBreadcrumbs;
    public $headerClass;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'disconnect' => ['post'],
                    'delete' => ['post'],
                    'two-factor-disable' => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'profile',
                            'account',
                            'networks',
                            'privacy',
                            'gdpr-consent',
                            'gdpr-delete',
                            'disconnect',
                            'delete',
                            'two-factor',
                            'two-factor-enable',
                            'two-factor-disable'
                        ],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->view->title = Yii::$app->name . ' - ' . Yii::t('frontend', 'My Profile');
        Yii::$app->layout = Yii::$app->params['pageStyle'][2]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][2]['headclass'];
        $this->backBreadcrumbs = false;
    }

    public function actionAccount()
    {
        /** @var SettingsForm $form */
        $form = $this->make(SettingsForm::class);
        $event = $this->make(UserEvent::class, [$form->getUser()]);

        $this->make(AjaxRequestModelValidator::class, [$form])->validate();

        if ($form->load(Yii::$app->request->post())) {
            $this->trigger(UserEvent::EVENT_BEFORE_ACCOUNT_UPDATE, $event);

            if ($form->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('usuario', 'Your account details have been updated'));
                $this->trigger(UserEvent::EVENT_AFTER_ACCOUNT_UPDATE, $event);

                return $this->refresh();
            }
        }

        return $this->render('account', ['model' => $form]);
    }

    /**
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionPrivacy()
    {
        if (!$this->module->enableGdprCompliance && !$this->module->enableTwoFactorAuthentication && !$this->module->allowAccountDelete) {
            throw new NotFoundHttpException();
        }
        return $this->render('privacy', [
            'module' => $this->module
        ]);
    }

    public function actionTwoFactor($id)
    {
        /** @var User $user */
        $user = $this->userQuery->whereId($id)->one();

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        $uri = $this->make(TwoFactorQrCodeUriGeneratorService::class, [$user])->run();

        return $this->renderAjax('two-factor', ['id' => $id, 'uri' => $uri]);
    }

    public function actionTwoFactorEnable($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        /** @var User $user */
        $user = $this->userQuery->whereId($id)->one();

        if (null === $user) {
            return ['success' => false, 'message' => Yii::t('usuario', 'User not found.')];
        }
        $code = Yii::$app->request->get('code');

        $success = $this->make(TwoFactorCodeValidator::class, [$user, $code, $this->module->twoFactorAuthenticationCycles])->validate();

        $success = $success && $user->updateAttributes(['auth_tf_enabled' => '1']);

        return ['success' => $success,
            'message' => $success
                ? Yii::t('usuario', 'Two factor authentication successfully enabled.')
                : Yii::t('usuario', 'Verification failed. Please, enter new code.')
        ];
    }

    public function actionTwoFactorDisable($id)
    {
        /** @var User $user */
        $user = $this->userQuery->whereId($id)->one();

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        if ($user->updateAttributes(['auth_tf_enabled' => '0'])) {
            Yii::$app->getSession()->setFlash('success', Yii::t('usuario', 'Two factor authentication has been disabled.'));
        } else {
            Yii::$app->getSession()->setFlash('danger', Yii::t('usuario', 'Unable to disable Two factor authentication.'));
        }

        $this->redirect(['privacy']);
    }

    public function actionGdprConsent()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($user->gdpr_consent) {
            return $this->redirect(['profile']);
        }
        $model = new DynamicModel(['gdpr_consent']);
        $model->addRule('gdpr_consent', 'boolean');
        $model->addRule('gdpr_consent', 'default', ['value' => 0, 'skipOnEmpty' => false]);
        $model->addRule('gdpr_consent', 'compare', [
            'compareValue' => true,
            'message' => Yii::t('usuario', 'Your consent is required to work with this site'),
            'when' => function () {
                return $this->module->enableGdprCompliance;
            },
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->updateAttributes([
                'gdpr_consent' => 1,
                'gdpr_consent_date' => time(),
            ]);
            return $this->redirect(['profile']);
        }

        return $this->render('gdpr-consent', [
            'model' => $model,
            'gdpr_consent_hint' => Yii::t(
                'frontend',
                'I agree processing of my personal data and the use of cookies to facilitate the operation of this site. For more information read our {privacyPolicy}',
                [
                    'privacyPolicy' => Html::a(
                        Yii::t('frontend', 'privacy policy'),
                        $this->module->gdprPrivacyPolicyUrl,
                        ['target' => '_blank']
                    ),
                ]
            ),
        ]);
    }

}