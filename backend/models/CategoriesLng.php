<?php
namespace backend\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%categories_lng}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $lng
 * @property string $title
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property string $seo_text
 * @property string $content
 * @property string $breadbg
 */
class CategoriesLng extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories_lng}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['content'], 'string'],
            [['lng'], 'string', 'max' => 5],
            [['title', 'seotitle', 'keywords', 'description', 'breadbg'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['item_id' => 'id']],
            [['seo_text'], 'string'],
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
            'content' => Yii::t('backend', 'Content'),
            'keywords' => Yii::t('backend', 'Keywords'),
            'description' => Yii::t('backend', 'Description'),
            'seo_text' => Yii::t('backend', 'SEO Text'),
            'breadbg' => Yii::t('backend', 'Breadcrumbs Section Background and Category Image'),
        ];
    }

}