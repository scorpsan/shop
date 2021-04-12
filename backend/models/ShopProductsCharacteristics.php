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

    protected $_rules;
    protected $_labels;

    public static function tableName() {
        return '{{%shop_products_characteristics}}';
    }

    public function rules() {
        return $this->_rules;
    }

    public function attributeLabels() {
        return $this->_labels;
    }

    public function init() {
        parent::init();
        $this->_rules = [
            [['product_id', 'lng'], 'required'],
            [['product_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lng' => 'url']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
        $this->_labels = [
            'id' => Yii::t('backend', 'ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'lng' => Yii::t('backend', 'Lng'),
        ];
        $paramsList = ShopCharacteristics::find()->with('translate')->all();
        foreach ($paramsList as $param) {
            $this->_rules[] = [[$param->alias], 'safe'];
            $this->_labels = $this->_labels + [$param->alias => $param->title];
        }
    }

    public function getProduct() {
        return $this->hasOne(ShopProducts::className(), ['id' => 'product_id']);
    }

}