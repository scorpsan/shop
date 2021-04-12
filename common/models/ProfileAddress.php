<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%profile_address}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $country
 * @property string|null $region
 * @property string|null $district
 * @property string|null $city
 * @property string|null $address
 * @property string|null $postal
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read ActiveQuery $user
 */
class ProfileAddress extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%profile_address}}';
    }

	/**
	 * {@inheritdoc}
	 */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'country', 'city', 'address'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'country', 'region', 'district', 'city', 'address'], 'string', 'max' => 255],
            [['postal'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'user_id' => Yii::t('frontend', 'User ID'),
            'title' => Yii::t('frontend', 'Title'),
            'country' => Yii::t('frontend', 'Country'),
            'region' => Yii::t('frontend', 'Region'),
            'district' => Yii::t('frontend', 'District'),
            'city' => Yii::t('frontend', 'City'),
            'address' => Yii::t('frontend', 'Address'),
            'postal' => Yii::t('frontend', 'Postal'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}