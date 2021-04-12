<?php
namespace common\models;

use Da\User\Model\User as BaseUser;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property string $phone [varchar(21)]
 * @property-read ActiveQuery $addresses
 */
class User extends BaseUser
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'phone' => Yii::t('frontend', 'Phone'),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'register' => ['username', 'phone', 'email', 'password'],
                'connect' => ['username', 'email'],
                'create' => ['username', 'phone', 'email', 'password'],
                'update' => ['username', 'phone', 'email', 'password'],
                'settings' => ['username', 'phone', 'email', 'password'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                // phone rules
                'phoneRequired' => ['phone', 'required', 'on' => ['register', 'create', 'update']],
                'phoneLength' => ['phone', 'string', 'min' => 7, 'max' => 21],
                'phoneTrim' => ['phone', 'trim'],
                'phonePattern' => ['phone', 'match', 'pattern' => '/^[+][0-9]{7,20}$/', 'message' => Yii::t('frontend', 'Wrong format, enter phone number in international format.')],
                'phoneUnique' => [
                    'phone',
                    'unique',
                    'message' => Yii::t('frontend', 'This Phone has already been taken.'),
                ],
            ]
        );
    }

    /**
     * @param int $size
     *
     * @return string url avatar image
     */
    public function getAvatarUrl($size = 200): string
    {
        return '/images/default-avatar.png';
    }

    /**
     * Gets query for [[ProfileAddress]].
     *
     * @return ActiveQuery
     */
    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(ProfileAddress::class, ['user_id' => 'id']);
    }

}