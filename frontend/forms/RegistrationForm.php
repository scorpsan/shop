<?php
namespace frontend\forms;

use Da\User\Form\RegistrationForm as BaseRegistrationForm;
use Da\User\Helper\SecurityHelper;
use Da\User\Model\User;
use Yii;
use yii\helpers\Html;
use Exception;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * @var string User Name
     */
    public $name;
    /**
     * @var string User Phone
     */
    public $phone;

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function rules()
    {
        /** @var User $user */
        $user = $this->getClassMap()->get(User::class);

        return [
            'nameRequired' => [['name'], 'required'],
            'nameLength' => [['name'], 'string', 'max' => 255],
            'nameTrim' => [['name'], 'filter', 'filter' => 'trim'],
            // phone rules
            'phoneTrim' => ['phone', 'filter', 'filter' => 'trim'],
            'phoneRequired' => ['phone', 'required'],
            'phonePattern' => ['phone', 'match', 'pattern' => '/^\+[0-9]{7,20}$/', 'message' => Yii::t('frontend', 'Wrong format, enter phone number in international format.')],
            'phoneUnique' => [
                'phone',
                'unique',
                'targetClass' => $user,
                'message' => Yii::t('frontend', 'This Phone has already been taken.'),
            ],
            // username rules
            [['username'], 'safe'],/*
            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'usernamePattern' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique' => [
                'username',
                'unique',
                'targetClass' => $user,
                'message' => Yii::t('usuario', 'This username has already been taken'),
            ],*/
            // email rules
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailUnique' => [
                'email',
                'unique',
                'targetClass' => $user,
                'message' => Yii::t('usuario', 'This email address has already been taken'),
            ],
            // password rules
            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->generatePasswords],
            'passwordLength' => ['password', 'string', 'min' => 6, 'max' => 72],
            'gdprType' => ['gdpr_consent', 'boolean'],
            'gdprDefault' => ['gdpr_consent', 'default', 'value' => 0, 'skipOnEmpty' => false],
            'gdprRequired' => ['gdpr_consent',
                'compare',
                'compareValue' => true,
                'message' => Yii::t('usuario', 'Your consent is required to register'),
                'when' => function () {
                    return $this->module->enableGdprCompliance;
                }]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Full Name'),
            'phone' => Yii::t('frontend', 'Phone'),
            'email' => Yii::t('usuario', 'Email'),
            'username' => Yii::t('usuario', 'Username'),
            'password' => Yii::t('usuario', 'Password'),
            'gdpr_consent' => Yii::t('usuario', 'Data processing consent')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->phone = Yii::$app->params['userPhoneCode'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'gdpr_consent' => Yii::t(
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
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->phone = '+' . preg_replace('/\D+/', '', $this->phone);
            if (empty($this->username)) {
                $this->username = $this->email;
            }
            if (empty($this->password)) {
                $security = $this->make(SecurityHelper::class);
                $this->password = $security->generatePassword(10);
            }
            return true;
        }
        return false;
    }
}