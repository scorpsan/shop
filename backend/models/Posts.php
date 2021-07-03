<?php
namespace backend\models;

use common\models\Posts as BasePosts;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use Yii;

/**
 * @property-read ActiveQuery $translates
 */
class Posts extends BasePosts
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
            [['id'], 'integer'],
            [['id', 'alias'], 'unique'],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'filter', 'filter'=>'trim'],
            [['alias'], 'filter', 'filter'=>'strtolower'],
            [['published', 'noindex'], 'boolean'],
            [['published'], 'default', 'value' => true],
            [['noindex'], 'default', 'value' => false],
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
            'noindex' => Yii::t('backend', 'NoIndex'),
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
        PostsLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslates(): ActiveQuery
    {
        return $this->hasMany(PostsLng::class, ['item_id' => 'id'])->indexBy('lng');
    }

}