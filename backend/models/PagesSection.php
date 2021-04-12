<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii2tech\ar\position\PositionBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use Exception;

/**
 * This is the model class for table "{{%pages_section}}".
 *
 * @property int $id
 * @property int $item_id
 * @property string $title
 * @property string $subtitle
 * @property string $precontent
 * @property string $id_section
 * @property int $show_title
 * @property int $published
 * @property int $style
 * @property string $text_align
 * @property string $background
 * @property int $parallax
 * @property int $sort
 * @property int $widget
 * @property string $widget_type
 * @property string $content
 *
 * @property-read string|null $lng
 */
class PagesSection extends ActiveRecord
{
    const SCENARIO_DEFAULT = 'section';
    const SCENARIO_WIDGET1 = 'widget1';
    const SCENARIO_WIDGET2 = 'widget2';

    public $sorting;
    public $widget_params;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages_section}}';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_DEFAULT] = ['item_id', 'widget', 'title', 'show_title', 'text_align', 'published', 'style', 'background', 'parallax', 'sorting', 'sort', 'content'];
        $scenarios[static::SCENARIO_WIDGET1] = ['item_id', 'widget', 'widget_type'];
        $scenarios[static::SCENARIO_WIDGET2] = ['item_id', 'widget', 'widget_type', 'title', 'show_title', 'text_align', 'published', 'style', 'background', 'parallax', 'sorting', 'sort', 'widget_params'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'sort',
                'groupAttributes' => ['item_id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'title', 'widget_type'], 'required'],
            [['title', 'background', 'widget_type'], 'string', 'max' => 255],
            [['item_id', 'sort'], 'integer'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PagesLng::class, 'targetAttribute' => ['item_id' => 'id']],
            [['show_title', 'published', 'parallax', 'widget'], 'boolean'],
            [['show_title'], 'default', 'value' => true, 'on' => self::SCENARIO_DEFAULT],
            [['show_title'], 'default', 'value' => false, 'on' => self::SCENARIO_WIDGET2],
            [['published'], 'default', 'value' => true],
            [['parallax'], 'default', 'value' => false],
            [['widget'], 'default', 'value' => false, 'on' => self::SCENARIO_DEFAULT],
            [['widget'], 'default', 'value' => true, 'on' => self::SCENARIO_WIDGET1],
            [['widget'], 'default', 'value' => true, 'on' => self::SCENARIO_WIDGET2],
            [['style'], 'string', 'max' => 100],
            [['text_align'], 'string', 'max' => 25],
            [['style'], 'default', 'value' => 'bg-white'],
            [['content'], 'string'],
            [['sorting', 'widget_params'], 'safe'],
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
            'title' => Yii::t('backend', 'Title'),
            'subtitle' => Yii::t('backend', 'Sub Title'),
            'precontent' => Yii::t('backend', 'Pre Content'),
            'id_section' => Yii::t('backend', 'CSS ID Section'),
            'show_title' => Yii::t('backend', 'Show Title'),
            'published' => Yii::t('backend', 'Published'),
            'style' => Yii::t('backend', 'Style'),
            'text_align' => Yii::t('backend', 'Text Align'),
            'background' => Yii::t('backend', 'Background'),
            'parallax' => Yii::t('backend', 'Parallax'),
            'content' => Yii::t('backend', 'Content'),
            'sort' => Yii::t('backend', 'Sort'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'widget_type' => Yii::t('backend', 'Widget'),
            'widget_params' => Yii::t('backend', 'Widget Params'),
        ];
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getLng()
    {
        return ArrayHelper::getValue($this->pageslng, 'lng');
    }

    /**
     * @param int|null $item_id
     * @return array
     */
    public function getSortingLists($item_id = null)
    {
        $sortingList = ArrayHelper::map(self::find()->where(['item_id' => $this->item_id])->orderBy(['sort' => SORT_ASC])->all(), 'sort', 'title');
        if (count($sortingList)) {
            $sortingList = array_merge(['first' => Yii::t('backend', '- First Element -')], $sortingList, ['last' => Yii::t('backend', '- Last Element -')]);
        } else {
            $sortingList = ['last' => Yii::t('backend', '- First Element -')];
        }
        return $sortingList;
    }

}