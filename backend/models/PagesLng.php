<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%pages_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property string $seo_text
 * @property string $breadbg
 *
 * @property-read mixed $content
 */
class PagesLng extends ActiveRecord
{
    public $sections;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages_lng}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'lng', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description', 'breadbg'], 'string', 'max' => 255],
            [['seo_text'], 'string'],
            [['lng'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['lng' => 'url']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'lng' => Yii::t('backend', 'Lng'),
            'title' => Yii::t('backend', 'Title'),
            'seotitle' => Yii::t('backend', 'SEO Title'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'seo_text' => Yii::t('backend', 'SEO Text'),
            'breadbg' => Yii::t('backend', 'Breadcrumbs Section Background'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        PagesSection::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getContent()
    {
        return $this->hasMany(PagesSection::class, ['item_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

}