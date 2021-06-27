<?php
namespace frontend\controllers\user;

use Da\User\Controller\RegistrationController as BaseRegistrationController;
use Da\User\Event\FormEvent;
use Da\User\Factory\MailFactory;
use Da\User\Form\RegistrationForm;
use Da\User\Model\User;
use Da\User\Service\UserRegisterService;
use Da\User\Validator\AjaxRequestModelValidator;
use common\models\Profile;
use Yii;
use yii\web\NotFoundHttpException;

class RegistrationController extends BaseRegistrationController
{
    public $backBreadcrumbs;
    public $headerClass;

    public function init()
    {
        parent::init();
        $this->view->title = Yii::$app->name . ' | ' . Yii::t('usuario', 'Sign up');
        Yii::$app->layout = Yii::$app->params['pageStyle'][2]['layouts'];
        $this->headerClass = Yii::$app->params['pageStyle'][2]['headclass'];
        $this->backBreadcrumbs = false;
    }

    /**
     * {@inheritdoc}
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/user/profile/index']);
        }

        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        /** @var RegistrationForm $form */
        $form = $this->make(RegistrationForm::class);
        /** @var FormEvent $event */
        $event = $this->make(FormEvent::class, [$form]);

        $this->make(AjaxRequestModelValidator::class, [$form])->validate();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->trigger(FormEvent::EVENT_BEFORE_REGISTER, $event);

            /** @var User $user */

            // Create a temporay $user so we can get the attributes, then get
            // the intersection between the $form fields  and the $user fields.
            $user = $this->make(User::class, [] );
            $fields = array_intersect_key($form->attributes, $user->attributes);

            // Becomes password_hash
            $fields['password'] = $form['password'];

            $user = $this->make(User::class, [], $fields );

            $user->setScenario('register');
            $mailService = MailFactory::makeWelcomeMailerService($user);

            if ($this->make(UserRegisterService::class, [$user, $mailService])->run()) {
                /** Добавление данных в профиль (ФИО Timezone Location) */
                $profile = Profile::find()->where(['user_id' => $user->id])->one();
                $profile->name = $form->name;
                $profile->public_email = $user->email;
                $profile->timezone = Yii::$app->getTimeZone();
                $profile->save();

                if ($this->module->enableEmailConfirmation) {
                    Yii::$app->session->setFlash('info',
                        Yii::t('usuario','Your account has been created and a message with further instructions has been sent to your email'));
                } else {
                    Yii::$app->session->setFlash('info', Yii::t('usuario', 'Your account has been created'));
                }
                $this->trigger(FormEvent::EVENT_AFTER_REGISTER, $event);
                return $this->render('/shared/message', [
                    'title' => Yii::t('usuario', 'Your account has been created'),
                    'module' => $this->module,
                ]);
            }
            Yii::$app->session->setFlash('danger', Yii::t('usuario', 'User could not be registered.'));
        }
        return $this->render('register', ['model' => $form, 'module' => $this->module]);
    }

}