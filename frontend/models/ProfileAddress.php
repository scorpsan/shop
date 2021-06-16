<?php
namespace frontend\models;

use common\models\ProfileAddress as BaseProfileAddress;
use Yii;

class ProfileAddress extends BaseProfileAddress
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'title' => Yii::t('frontend', 'Title'),
            'country' => Yii::t('frontend', 'Country'),
            'region' => Yii::t('frontend', 'Region'),
            'district' => Yii::t('frontend', 'District'),
            'city' => Yii::t('frontend', 'City'),
            'address' => Yii::t('frontend', 'Address'),
            'address2' => Yii::t('frontend', 'Apartment, suite, etc. (optional)'),
            'postal' => Yii::t('frontend', 'Postal'),
        ];
    }

}