<?php
namespace backend\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string|null $short_content
 * @property string|null $content
 * @property string|null $seotitle
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $seo_text
 */
class ShopProductsLng extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%shop_products_lng}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['short_content', 'content', 'seo_text'], 'string'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description'], 'string', 'max' => 255],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['lng' => 'url']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'short_content' => Yii::t('backend', 'Short Content'),
            'content' => Yii::t('backend', 'Content'),
            'seotitle' => Yii::t('backend', 'SEO Title'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'seo_text' => Yii::t('backend', 'SEO Text'),
        ];
    }

}