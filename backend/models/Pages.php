<?php
namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $alias
 * @property int $published
 * @property int $main
 * @property int $created_at
 * @property int $updated_at
 */
class Pages extends \yii\db\ActiveRecord {

    public $titleDefault;

    public static function tableName() {
        return '{{%pages}}';
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
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['published', 'main'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['main'], 'default', 'value' => false],
            [['created_at', 'updated_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category_id' => Yii::t('backend', 'Category'),
            'alias' => Yii::t('backend', 'Alias'),
            'published' => Yii::t('backend', 'Published'),
            'main' => Yii::t('backend', 'Main'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            if ($this->created_at) {
                $this->created_at = Yii::$app->formatter->asTimestamp($this->created_at);
            } else {
                $this->created_at = time();
            }
        } else {
            if ($this->created_at) {
                $this->created_at = Yii::$app->formatter->asTimestamp($this->created_at);
            } else {
                $this->created_at = $this->getOldAttribute('created_at');
            }
        }
        $this->updated_at = time();
        return parent::beforeSave($insert);
    }

    public function beforeDelete() {
        PagesLng::deleteAll(['item_id' => $this->id]);
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

    public static function getCategoriesList() {
        $categories = Pages::find()
            ->with('category')
            ->distinct(true)
            ->all();
        $categorieslist = ArrayHelper::map($categories, 'category_id', 'category.title');
        $categorieslist[0] = Yii::t('backend', 'Without category');
        return $categorieslist;
    }

    public function getCategory() {
        return $this->hasOne(Categories::className(), ['id' => 'category_id'])->with('translate');
    }

    public function getTranslates() {
        return $this->hasMany(PagesLng::className(), ['item_id' => 'id'])->indexBy('lng');
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(PagesLng::className(), ['item_id' => 'id'])->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

}