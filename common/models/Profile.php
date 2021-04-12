<?php
namespace common\models;

use Da\User\Model\Profile as BaseProfile;
use Yii;

/**
 * @property int $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $timezone
 */
class Profile extends BaseProfile
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('frontend', 'Full Name'),
            'public_email' => Yii::t('usuario', 'Email (public)'),
            'gravatar_email' => Yii::t('usuario', 'Gravatar email'),
            'location' => Yii::t('usuario', 'Location'),
            'website' => Yii::t('usuario', 'Website'),
            'bio' => Yii::t('usuario', 'Bio'),
            'timezone' => Yii::t('usuario', 'Time zone'),
        ];
    }

}