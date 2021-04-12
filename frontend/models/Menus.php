<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\validators\UrlValidator;
use creocoder\nestedsets\NestedSetsBehavior;
use Exception;
use yii\db\Expression;

/**
 * @property-read null $label
 * @property-read null $title
 * @property-read mixed $translate
 *
 * @property int $id [int(11)]
 * @property int $tree [int(11)]
 * @property int $lft [int(11)]
 * @property int $rgt [int(11)]
 * @property int $depth [int(11)]
 * @property string $url [varchar(255)]
 * @property string $params [varchar(255)]
 * @property string $access [varchar(25)]
 * @property bool $published [tinyint(1)]
 * @property bool $target_blank [tinyint(1)]
 * @property string $anchor [varchar(25)]
 */
class Menus extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menus}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return MenusQuery
     */
    public static function find()
    {
        return new MenusQuery(get_called_class());
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
     * @return string|null
     * @throws Exception
     */
    public function getLabel()
    {
        return $this->title;
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslate()
    {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(MenusLng::class, ['item_id' => 'id'])->alias('translate')
            ->onCondition(['lng' => Yii::$app->language])
            ->orOnCondition(['lng' => $langDef])
            ->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])
            ->indexBy('lng');
    }

    public function getFullUrl($url = null, $params = null, $anchor = null)
    {
        if (!isset($url)) {
            $url = $this->url;
            $params = $this->params;
            $anchor = $this->anchor;
        }
        $validator = new UrlValidator();
        if (!empty($url) && !$validator->validate($url, $error) && $url != '#') {
            if (preg_match('#^[+][0-9]{11,12}$#', $url)) {
                $url = 'callto:' . $url;
            } else {
                if (isset($params) && !empty($params)) {
                    $url = [$url] + unserialize($params);
                } else {
                    $url = [$url];
                }
                if (isset($anchor) && !empty($anchor)) {
                    $url += ['#' => $anchor];
                }
            }
        } else {
            if (isset($anchor) && !empty($anchor)) {
                $url .= '#' . $anchor;
            }
        }
        if (!empty($url)) {
            return Url::to($url);
        } else {
            return false;
        }
    }

    public static function getMenuItems($controller)
    {
        $makeNode = function ($node) {
            if (!empty($node['url'])) {
                $node['url'] = $this->getFullUrl($node['url'], $node['params'], $node['anchor']);
            }
            $newData = [
                'label' => $node['translate']['title'],
                'title' => $node['translate']['title'],
                'url' => $node['url'],
            ];
            if (isset($node['access']) && !empty($node['access'])) {
                $newData += [$this->visible => Yii::$app->user->can($node['access'])];
            }
            return array_merge($node, $newData);
        };
        // get cache
        //$trees = Yii::$app->cache->get('menuTree' . $controller . Yii::$app->language);
        if (empty($trees)) {
            $root = self::find()->where(['url' => $controller, 'depth' => 0])->limit(1)->one();
            if (!empty($root)) {
                // Trees mapped
                $trees = array();
                $collection = self::find()->andWhere(['tree' => $root->tree])->andWhere(['>', 'depth', 0])->andWhere(['published' => true])->with('translate')->orderBy('lft')->asArray()->all();
                if (count($collection) > 0) {
                    foreach ($collection as &$col) {
                        $col = $makeNode($col);
                    }
                    // Node Stack. Used to help building the hierarchy
                    $stack = array();
                    foreach ($collection as $node) {
                        $item = $node;
                        $item['items'] = array();
                        // Number of stack items
                        $l = count($stack);
                        // Check if we're dealing with different levels
                        while ($l > 0 && $stack[$l - 1]['depth'] >= $item['depth']) {
                            array_pop($stack);
                            $l--;
                        }
                        // Stack is empty (we are inspecting the root)
                        if ($l == 0) {
                            // Assigning the root node
                            $i = count($trees);
                            $trees[$i] = $item;
                            $stack[] = &$trees[$i];
                        } else {
                            // Add node to parent
                            $i = count($stack[$l - 1]['items']);
                            $stack[$l - 1]['folder'] = true;
                            $stack[$l - 1]['items'][$i] = $item;
                            $stack[] = &$stack[$l - 1]['items'][$i];
                        }
                    }
                }
                // set cache
                Yii::$app->cache->set('menuTree' . $controller . Yii::$app->language, $trees, 3600);
            }
            return null;
        }
        return $trees;
    }

}