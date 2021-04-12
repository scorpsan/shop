<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use Exception;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $alias
 * @property int $published
 * @property int $main
 * @property int $noindex
 * @property int $page_style
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read string|null $title
 * @property-read mixed $category
 * @property-read mixed $translate
 * @property-read mixed $translates
 * @property-read string|null $breadbg
 */
class Pages extends ActiveRecord
{
    public $titleDefault;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages}}';
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
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['published', 'main', 'noindex'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['main', 'noindex'], 'default', 'value' => false],
            [['page_style'], 'integer'],
            [['page_style'], 'default', 'value' => 6],
            [['created_at', 'updated_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category_id' => Yii::t('backend', 'Category'),
            'alias' => Yii::t('backend', 'Alias'),
            'published' => Yii::t('backend', 'Published'),
            'main' => Yii::t('backend', 'Main'),
            'noindex' => Yii::t('backend', 'NoIndex'),
            'page_style' => Yii::t('backend', 'Page Style'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
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
    public function beforeSave($insert)
    {
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

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        PagesLng::deleteAll(['item_id' => $this->id]);
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

    public static function getCategoriesList()
    {
        $categories = Pages::find()
            ->with('category')
            ->distinct(true)
            ->all();
        $categorieslist = ArrayHelper::map($categories, 'category_id', 'category.title');
        $categorieslist[0] = Yii::t('backend', 'Without category');
        return $categorieslist;
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id'])->with('translate');
    }

    public function getBreadbg()
    {
        return ArrayHelper::getValue($this->translate, 'breadbg');
    }

    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(PagesLng::class, ['item_id' => 'id'])
            ->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    public function getTranslates()
    {
        return $this->hasMany(PagesLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}