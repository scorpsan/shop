<?php
namespace backend\models;

use common\models\Pages as BasePages;
use yii\behaviors\SluggableBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * @property-read ActiveQuery $category
 * @property-read ActiveQuery $translates
 */
class Pages extends BasePages
{
    public $titleDefault;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
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
    public function rules(): array
    {
        return [
            [['id', 'alias'], 'unique'],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['published', 'main', 'noindex'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['main', 'noindex'], 'default', 'value' => false],
            [['id', 'page_style'], 'integer'],
            [['page_style'], 'default', 'value' => 6],
            [['created_at', 'updated_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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
    public function beforeValidate(): bool
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
    public function beforeSave($insert): bool
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
    public function beforeDelete(): bool
    {
        PagesLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public static function getCategoriesList(): array
    {
        $categories = Pages::find()
            ->with('category')
            ->distinct(true)
            ->all();
        $categorieslist = ArrayHelper::map($categories, 'category_id', 'category.title');
        $categorieslist[0] = Yii::t('backend', 'Without category');
        return $categorieslist;
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id'])->with('translate');
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(PagesLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}