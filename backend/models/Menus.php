<?php
namespace backend\models;

use backend\controllers\AppController;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\db\Expression;
use yii\validators\UrlValidator;
use creocoder\nestedsets\NestedSetsBehavior;
use Exception;

/**
 * This is the model class for table "{{%menus}}".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $url
 * @property string $params
 * @property string $access
 * @property int $published
 * @property int $target_blank
 * @property string $anchor
 */
class Menus extends \yii\db\ActiveRecord {

    public $parent_id;
    public $sorting;
    /**
     * List of Modules exclude from List of Route
     */
    private $modulesEx = ['admin', 'debug', 'gii', 'elfinder'];

    public static function tableName() {
        return '{{%menus}}';
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find() {
        return new MenusQuery(get_called_class());
    }

    public function rules() {
        return [
            [['url', 'params'], 'string', 'max' => 255],
            [['tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer'],
            [['access', 'anchor'], 'string', 'max' => 25],
            [['published', 'target_blank'], 'boolean'],
            ['published', 'default', 'value' => 1],
            ['target_blank', 'default', 'value' => 0],
            [['tree', 'lft', 'rgt', 'depth', 'sorting'], 'safe'],
            [['url', 'anchor'], 'trim'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'url' => Yii::t('backend', 'Url'),
            'params' => Yii::t('backend', 'Params'),
            'access' => Yii::t('backend', 'Access'),
            'parent_id' => Yii::t('backend', 'Parent'),
            'sorting' => Yii::t('backend', 'Sort After'),
            'published' => Yii::t('backend', 'Published'),
            'target_blank' => Yii::t('backend', 'Open in New Window'),
            'anchor' => Yii::t('backend', 'Anchor'),
        ];
    }

    public function beforeDelete() {
        MenusLng::deleteAll(['item_id' => $this->id]);
        return parent::beforeDelete();
    }

    public function getTitle() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getLabel() {
        return (isset($this->translate->title)) ? $this->translate->title : null;
    }

    public function getTranslate() {
        $langDef = Yii::$app->params['defaultLanguage'];
        return $this->hasOne(MenusLng::className(), ['item_id' => 'id'])->alias('translate')->onCondition(['lng' => Yii::$app->language])->orOnCondition(['lng' => $langDef])->orderBy([new Expression("FIELD(lng, '".Yii::$app->language."', '".$langDef."')")])->indexBy('lng');
    }

    public function getTranslates() {
        return $this->hasMany(MenusLng::className(), ['item_id' => 'id'])->indexBy('lng');
    }

    public function listAll() {
        $makeNode = function ($node) {
            $newData = [
                'title' => ($node['depth'] > 0) ? str_pad('', ($node['depth']), '-') . ' ' . $node['translate']['title'] : $node['translate']['title'],
            ];
            return array_merge($node, $newData);
        };
        $trees = $this->find()->with('translate')->orderBy(['tree' => SORT_ASC, 'lft' => SORT_ASC])->asArray()->all();
        if (count($trees) > 0) {
            foreach ($trees as &$col) $col = $makeNode($col);
        }
        return $trees;
    }

    public function getFullUrl($url = null, $params = null, $anchor = null) {
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

    public static function getMenuItems($rtree) {
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
                $newData += ['visible' => Yii::$app->user->can($node['access'])];
            }
            return array_merge($node, $newData);
        };
        // get cache
        $trees = Yii::$app->cache->get('menuTree' . $rtree . Yii::$app->language);
        if (empty($trees)) {
            // Trees mapped
            $trees = array();
            if (($root = self::find()->where(['url' => $rtree, 'depth' => 0])->limit(1)->one()) !== null) {
                $collection = $root->find()->andWhere(['tree' => $root->tree])->andWhere(['>', 'depth', 0])->andWhere(['published' => true])->with('translate')->orderBy('lft')->asArray()->all();
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
            }
            // set cache
            Yii::$app->cache->set('menuTree' . $rtree . Yii::$app->language, $trees, 3600);
        }
        return $trees;
    }

    /**
     * Lists all Route models.
     *
     * @return mixed
     */
    public function listUrls() {
        // get cache
        $result = Yii::$app->cache->get('listUrlsAppForMenu');
        if (empty($result)) {
            $result = [];
            $this->getRouteRecrusive(Yii::$app, $result);
            // set cache
            Yii::$app->cache->set('listUrlsAppForMenu', $result, 3600);
        }
        return $result;
    }
    /**
     * Get route(s) recrusive
     *
     * @param \yii\base\Module $module
     * @param array $result
     */
    private function getRouteRecrusive($module, &$result) {
        try {
            foreach ($module->getModules() as $id => $child) {
                if (!in_array($id, $this->modulesEx)) {
                    if (($child = $module->getModule($id)) !== null) {
                        $this->getRouteRecrusive($child, $result);
                    }
                }
            }
            foreach ($module->controllerMap as $id => $type) {
                if (!in_array($id, $this->modulesEx)) {
                    $this->getControllerActions($type, $id, $module, $result);
                }
            }
            $namespace = trim($module->controllerNamespace, '\\') . '\\';
            $this->getControllerFiles($module, $namespace, '', $result);
            $result[] = ($module->uniqueId === '' ? '' : '/' . $module->uniqueId) . '/*';
        } catch (Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }
    /**
     * Get list controller under module
     *
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     *
     * @return mixed
     */
    private function getControllerFiles($module, $namespace, $prefix, &$result) {
        $path = @Yii::getAlias('@' . str_replace('\\', '/', $namespace));
        if (!is_dir($path)) return;
        try {
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file)) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $id = Inflector::camel2id(substr(basename($file), 0, -14));
                    $className = $namespace . Inflector::id2camel($id) . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }
    /**
     * Get list action of controller
     *
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    private function getControllerActions($type, $id, $module, &$result) {
        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            //$result[] = '/' . $controller->uniqueId . '/*';
        } catch (Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }
    /**
     * Get route of action
     *
     * @param \yii\base\Controller $controller
     * @param array $result all controller action.
     */
    private function getActionRoutes($controller, &$result) {
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                //$result[] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $params = array();
                $name = $method->getName();
                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    if (count($method->getParameters())) {
                        foreach ($method->getParameters() as $key => $param) {
                            $params[] = $param->name;
                        }
                    }
                    $result[] = array(
                        'url' => $prefix . Inflector::camel2id(substr($name, 6)),
                        'name' => $controller->conTitle . ' ' . substr($name, 6),
                        'params' => $params
                    );
                }
            }
        } catch (Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }

}