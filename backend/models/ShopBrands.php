<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\SluggableBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * This is the model class for table "{{%shop_brands}}".
 *
 * @property int $id
 * @property string $alias
 * @property int $published
 * @property string|null $logo
 * @property string|null $breadbg
 *
 * @property-read mixed $translate
 * @property-read null $title
 * @property-read mixed $translates
 */
class ShopBrands extends ActiveRecord
{
    public $titleDefault;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_brands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias'], 'unique'],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['published'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['alias', 'logo', 'breadbg'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'alias' => Yii::t('backend', 'Alias'),
            'published' => Yii::t('backend', 'Published'),
            'logo' => Yii::t('backend', 'Logo'),
            'breadbg' => Yii::t('backend', 'Breadcrumbs Section Background'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->alias = str_replace(' ', '_', $this->alias);
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        ShopBrandsLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getTitle()
    {
        return ArrayHelper::getValue($this->translate, 'title');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopBrandsLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates()
    {
        return $this->hasMany(ShopBrandsLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}