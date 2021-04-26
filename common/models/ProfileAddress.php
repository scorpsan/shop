<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $country
 * @property string|null $region
 * @property string|null $district
 * @property string|null $city
 * @property string|null $address
 * @property string|null $address2
 * @property string|null $postal
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read string $stringAddress
 * @property-read string $fullStringAddress
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
            [['title', 'country', 'region', 'district', 'city', 'address', 'address2'], 'string', 'max' => 255],
            [['postal'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @return string
     */
    public function getStringAddress(): string
    {
        $address = [
            $this->address,
            $this->address2,
            $this->city,
            Country::getCountryName($this->country),
        ];
        return implode(", ", array_diff($address, array('', NULL, false)));
    }

    /**
     * @return string
     */
    public function getFullStringAddress(): string
    {
        return $this->title . ' (' . $this->stringAddress . ')';
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