<?php
namespace frontend\forms;

use Da\User\Form\SettingsForm as BaseSettingsForm;
use Da\User\Model\User;
use Yii;

class SettingsForm extends BaseSettingsForm
{
    /**
     * @var string User Phone
     */
    public $phone;

    public function init()
    {
        parent::init();
        $this->phone = $this->getUser()->phone;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->getClassMap()->get(User::class);

        return [
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
            'usernameRequired' => ['username', 'required'],
            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernamePattern' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],*/
            'emailRequired' => ['email', 'required'],
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailPattern' => ['email', 'email'],
            'emailUsernameUnique' => [
                ['email', 'username'],
                'unique',
                'when' => function ($model, $attribute) {
                    return $this->getUser()->$attribute !== $model->$attribute;
                },
                'targetClass' => $this->getClassMap()->get(User::class),
            ],
            'newPasswordLength' => ['new_password', 'string', 'max' => 72, 'min' => 6],
            'currentPasswordRequired' => ['current_password', 'required'],
            'currentPasswordValidate' => [
                'current_password',
                function ($attribute) {
                    if (!$this->securityHelper->validatePassword($this->$attribute, $this->getUser()->password_hash)) {
                        $this->addError($attribute, Yii::t('usuario', 'Current password is not valid'));
                    }
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'phone' => Yii::t('frontend', 'Phone'),
            'email' => Yii::t('usuario', 'Email'),
            'username' => Yii::t('usuario', 'Username'),
            'new_password' => Yii::t('usuario', 'New password'),
            'current_password' => Yii::t('usuario', 'Current password'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->phone = '+' . preg_replace('/\D+/', '', $this->phone);
            return true;
        }
        return false;
    }

}