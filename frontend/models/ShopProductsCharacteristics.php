<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class ShopProductsCharacteristics extends ActiveRecord
{
    protected $_labels;
    protected $_hints;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_products_characteristics}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->_labels;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
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