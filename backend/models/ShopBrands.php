<?php
namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%shop_brands}}".
 *
 * @property int $id
 * @property string $alias
 * @property int $published
 * @property string|null $logo
 * @property string|null $breadbg
 */
class ShopBrands extends \yii\db\ActiveRecord {

    public $titleDefault;

    public static function tableName() {
        return '{{%shop_brands}}';
    }

    public function behaviors() {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'titleDefault',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
        ];
    }

    public function rules() {
        return [
            [['alias'], 'required'],
            [['published'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['alias', 'logo', 'breadbg'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'alias' => Yii::t('backend', 'Alias'),
            'published' => Yii::t('backend', 'Published'),
            'logo' => Yii::t('backend', 'Logo'),
            'breadbg' => Yii::t('backend', 'Breadcrumbs Section Background'),
        ];
    }

    public function beforeDelete() {
        ShopBrandsLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public function getTitle() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getSeotitle() {
        return (isset($this->translate->seo_title)) ? $this->translate->seo_title : $this->getTitle();
    }

    public function getKeywords() {
        return (isset($this->translate->keywords)) ? $this->translate->keywords : null;
    }

    public function getDescription() {
        return (isset($this->translate->description)) ? $this->translate->description : null;
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(ShopBrandsLng::className(), ['item_id' => 'id'])->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

    public function getTranslates() {
        return $this->hasMany(ShopBrandsLng::className(), ['item_id' => 'id'])->indexBy('lng');
    }

}