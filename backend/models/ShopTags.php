<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%posts_tags}}".
 *
 * @property int $item_id [int(11)]
 * @property int $tag_id [int(11)]
 *
 * @property-read ActiveQuery $tag
 * @property-read ActiveQuery $item
 */
class ShopTags extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_tags}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['item_id', 'tag_id'], 'required'],
            [['item_id', 'tag_id'], 'integer'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::class, 'targetAttribute' => ['item_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'item_id' => Yii::t('backend', 'Item ID'),
            'tag_id' => Yii::t('backend', 'Tag ID'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getItem(): ActiveQuery
    {
        return $this->hasOne(ShopProducts::class, ['id' => 'item_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tags::class, ['id' => 'tag_id']);
    }

}