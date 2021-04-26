<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class ShopProductsCharacteristics extends ActiveRecord
{
    protected $_labels;
    protected $_hints;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%shop_products_characteristics}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return $this->_labels;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints(): array
    {
        return $this->_hints;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_labels = array();
        $paramsList = ShopCharacteristics::find()->where(['published' => true])->with('translate')->orderBy(['sort' => SORT_ASC])->all();
        $this->_labels = ArrayHelper::map($paramsList, 'alias', 'title');
        $this->_hints = ArrayHelper::map($paramsList, 'alias', 'units');
    }

}