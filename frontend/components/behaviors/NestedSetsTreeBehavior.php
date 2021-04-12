<?php
namespace frontend\components\behaviors;

use Yii;
use yii\validators\UrlValidator;

class NestedSetsTreeBehavior extends \yii\base\Behavior {

    /**
     * @var string
     */
    public $leftAttribute = 'lft';
    /**
     * @var string
     */
    public $rightAttribute = 'rgt';
    /**
     * @var string
     */
    public $depthAttribute = 'depth';
    /**
     * @var string
     */
    public $labelAttribute = 'title';
    /**
     * @var string
     */
    public $childrenOutAttribute = 'children';
    /**
     * @var string
     */
    public $labelOutAttribute = 'title';
    /**
     * @var string
     */
    public $hasChildrenOutAttribute = 'folder';
    /**
     * @var string
     */
    public $hrefOutAttribute = 'url';
    /**
     * @var string
     */
    public $optionsOutAttribute = 'options';
    /**
     * @var string
     */
    public $accessOutAttribute = 'visible';
    /**
     * @var null|callable
     */
    public $makeLinkCallable = false;

    /**
     * @param $controller
     * @return array|mixed
     */
    public function treeCategories($controller)
    {
        $makeNode = function ($node, $controller) {
            $newData = [
                $this->labelOutAttribute => $node['translate'][$this->labelAttribute],
                $this->hrefOutAttribute => ['/'.$controller.'/category', 'categoryalias' => $node['alias']],
            ];
            if (is_callable($makeLink = $this->makeLinkCallable)) {
                $newData += [
                    $this->hrefOutAttribute => $makeLink($node),
                ];
            }
            return array_merge($node, $newData);
        };
        // get cache
        //Yii::$app->cache->delete('basicTreeCategories' . $controller . Yii::$app->language);
        $trees = Yii::$app->cache->get('basicTreeCategories' . $controller . Yii::$app->language);
        if (empty($trees)) {
            // Trees mapped
            $trees = array();
            $collection = $this->owner->find()->andWhere(['tree' => $this->owner->tree])->with('translate')->asArray()->all();
            if (count($collection) > 0) {
                foreach ($collection as &$col) $col = $makeNode($col, $controller);
                // Node Stack. Used to help building the hierarchy
                $stack = array();
                foreach ($collection as $node) {
                    $item = $node;
                    $item[$this->childrenOutAttribute] = array();
                    // Number of stack items
                    $l = count($stack);
                    // Check if we're dealing with different levels
                    while ($l > 0 && $stack[$l - 1][$this->depthAttribute] >= $item[$this->depthAttribute]) {
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
                        $i = count($stack[$l - 1][$this->childrenOutAttribute]);
                        $stack[$l - 1][$this->hasChildrenOutAttribute] = true;
                        $stack[$l - 1][$this->childrenOutAttribute][$i] = $item;
                        $stack[] = &$stack[$l - 1][$this->childrenOutAttribute][$i];
                    }
                }
            }
            // set cache
            Yii::$app->cache->set('basicTreeCategories' . $controller . Yii::$app->language, $trees, 3600);
        }
        return $trees;
    }

    public function menuTreeCategories($controller) {
        $makeNode = function ($node, $controller) {
            $newData = [
                'label' => $node['translate'][$this->labelAttribute],
                $this->labelOutAttribute => $node['translate'][$this->labelAttribute],
                $this->hrefOutAttribute => ['/'.$controller.'/category', 'categoryalias' => $node['alias']],
            ];
            return array_merge($node, $newData);
        };
        // get cache
        Yii::$app->cache->delete('menuTreeCategories' . $controller . Yii::$app->language);
        $trees = Yii::$app->cache->get('menuTreeCategories' . $controller . Yii::$app->language);
        if (empty($trees)) {
            // Trees mapped
            $trees = array();
            $collection = $this->owner->find()->andWhere(['tree' => $this->owner->tree])->andWhere(['>', 'depth', 0])->andWhere(['published' => true])->with('translate')->orderBy('lft')->asArray()->all();
            if (count($collection) > 0) {
                foreach ($collection as &$col) {
                    $col = $makeNode($col, $controller);
                }
                // Node Stack. Used to help building the hierarchy
                $stack = array();
                foreach ($collection as $node) {
                    $item = $node;
                    $item['items'] = array();
                    // Number of stack items
                    $l = count($stack);
                    // Check if we're dealing with different levels
                    while ($l > 0 && $stack[$l - 1][$this->depthAttribute] >= $item[$this->depthAttribute]) {
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
                        $stack[$l - 1][$this->hasChildrenOutAttribute] = true;
                        $stack[$l - 1]['items'][$i] = $item;
                        $stack[] = &$stack[$l - 1]['items'][$i];
                    }
                }
            }
            // set cache
            Yii::$app->cache->set('menuTreeCategories' . $controller . Yii::$app->language, $trees, 3600);
        }
        return $trees;
    }

    public function menuTree($controller) {
        $makeNode = function ($node) {
            if ($node['url']) {
                $validator = new UrlValidator();
                if (!$validator->validate($node['url'], $error) && $node['url'] != '#') {
                    if (preg_match('#^[+][0-9]{11,12}$#', $node['url'])) {
                        $node['url'] = 'callto:' . $node['url'];
                    } else {
                        if (isset($node['params']) && !empty($node['params'])) {
                            $node['url'] = [$node['url']] + unserialize($node['params']);
                        } else {
                            $node['url'] = [$node['url']];
                        }
                        if (isset($node['anchor']) && !empty($node['anchor'])) {
                            $node['url'] += ['#' => $node['anchor']];
                        }
                    }
                } else {
                    if (isset($node['anchor']) && !empty($node['anchor'])) {
                        $node['url'] .= '#' . $node['anchor'];
                    }
                }
            }
            $newData = [
                'label' => $node['translate'][$this->labelAttribute],
                $this->labelOutAttribute => $node['translate'][$this->labelAttribute],
                $this->hrefOutAttribute => $node['url'],
            ];
            if (isset($node['access']) && !empty($node['access'])) {
                $newData += [$this->accessOutAttribute => Yii::$app->user->can($node['access'])];
            }
            return array_merge($node, $newData);
        };
        // get cache
        //$trees = Yii::$app->cache->get('menuTree' . $controller . Yii::$app->language);
        if (empty($trees)) {
            // Trees mapped
            $trees = array();
            $collection = $this->owner->find()->andWhere(['tree' => $this->owner->tree])->andWhere(['>', 'depth', 0])->andWhere(['published' => true])->with('translate')->orderBy('lft')->asArray()->all();
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
                    while ($l > 0 && $stack[$l - 1][$this->depthAttribute] >= $item[$this->depthAttribute]) {
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
                        $stack[$l - 1][$this->hasChildrenOutAttribute] = true;
                        $stack[$l - 1]['items'][$i] = $item;
                        $stack[] = &$stack[$l - 1]['items'][$i];
                    }
                }
            }
            // set cache
            Yii::$app->cache->set('menuTree' . $controller . Yii::$app->language, $trees, 3600);
        }
        return $trees;
    }

}