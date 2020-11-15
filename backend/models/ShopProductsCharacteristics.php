<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%shop_products_characteristics}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $lng
 */
class ShopProductsCharacteristics extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%shop_products_characteristics}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['product_id', 'lng'], 'required'],
            [['product_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lng' => 'url']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'lng' => Yii::t('backend', 'Lng'),
        ];
    }

}