<?php
namespace backend\controllers;

use backend\models\Menus;
use backend\models\MenusLng;
use backend\models\Language;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class MenusController extends \backend\controllers\AppController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['viewPages'],
                    ],
                    [
                        'actions' => ['create', 'update', 'lists', 'params', 'publish', 'unpublish', 'up', 'down'],
                        'allow' => true,
                        'roles' => ['editPages'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deletePages'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'lists' => ['POST'],
                    'params' => ['POST'],
                    'publish' => ['POST'],
                    'unpublish' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if (in_array($action->id, ['index', 'view', 'update'], true)) {
            Url::remember('', 'actions-redirect');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $root = Menus::find()->select('url')->where(['depth' => 0])->column();
        $languages = Language::getLanguages();
        foreach (Yii::$app->params['listType'] as $key => $name) {
            if (!in_array($key, $root)) {
                $rootEl = new Menus();
                $rootEl->url = $key;
                $rootEl->parent_id = 0;
                $rootEl->published = 0;
                $rootEl->makeRoot();
                $rootEl->save();
                $rootLng = new MenusLng();
                $rootLng->item_id = $rootEl->id;
                $rootLng->lng = Yii::$app->params['defaultLanguage'];
                $rootLng->title = $name;
                $rootLng->save();
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Menus::find()
                ->with('translate')
                ->with('translates')
                ->orderBy(['tree' => SORT_ASC, 'lft' => SORT_ASC]),
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => $languages,
        ]);
    }

    public function actionView($id) {
        if (($model = Menus::find()->where(['id' => $id])
            ->with('translate')
            ->with('translates')
            ->limit(1)->one()) !== null) {
            $languages = Language::getLanguages();
            return $this->render('view', [
                'model' => $model,
                'languages' => $languages,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionCreate() {
        $model = new Menus();
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new MenusLng();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            if ($model->parent_id) {
                if ($model->sorting == 'last') {
                    $parent = Menus::find()->where(['id' => $model->parent_id])->limit(1)->one();
                    $model->appendTo($parent);
                } elseif ($model->sorting == 'first') {
                    $parent = Menus::find()->where(['id' => $model->parent_id])->limit(1)->one();
                    $model->prependTo($parent);
                } else {
                    $after = Menus::find()->where(['id' => $model->sorting])->limit(1)->one();
                    $model->insertAfter($after);
                }
            }
            if (!empty($model->params)) {
                $model->params = serialize($model->params);
            } else {
                $model->params = null;
            }
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                foreach (Yii::$app->params['listType'] as $key => $name) {
                    foreach ($languages as $language) {
                        Yii::$app->cache->delete('menuTree' . $key . $language->url);
                    }
                }
                return $this->redirect(['index']);
            }
        }
        $parentList = ArrayHelper::map($model->listAll(), 'id', 'title');
        $listUrls = ArrayHelper::map($model->listUrls(), 'url', 'name');
        $available_roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'parentList' => $parentList,
            'listUrls' => $listUrls,
            'available_roles' => $available_roles,
            'languages' => $languages,
        ]);
    }

    public function actionUpdate($id) {
        if (($model = Menus::find()->where(['id' => $id])
            ->with('translate')
            ->limit(1)->one()) !== null) {
            $modelLng = MenusLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
            $languages = Language::getLanguages();
            foreach ($languages as $lang) {
                if (empty($modelLng[$lang->url])) {
                    $modelLng[$lang->url] = new MenusLng();
                }
            }
            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
                if ($model->parent_id) {
                    if ($model->sorting == 'first') {
                        $parent = Menus::find()->where(['id' => $model->parent_id])->limit(1)->one();
                        $model->prependTo($parent);
                    } elseif ($model->sorting == 'last') {
                        $parent = Menus::find()->where(['id' => $model->parent_id])->limit(1)->one();
                        $model->appendTo($parent);
                    } else {
                        $after = Menus::find()->where(['id' => $model->sorting])->limit(1)->one();
                        $model->insertAfter($after);
                    }
                }
                if (!empty($model->params)) {
                    $model->params = serialize($model->params);
                } else {
                    $model->params = null;
                }
                if ($model->save()) {
                    foreach ($modelLng as $key => $modelL) {
                        $modelL->item_id = $model->id;
                        if ($modelL->validate())
                            $modelL->save(false);
                    }
                    if (!$model->published) {
                        $categoryChildren = $model->children()->select('id')->column();
                        Menus::updateAll(['published' => 0], ['in', 'id', $categoryChildren]);
                    }
                    foreach (Yii::$app->params['listType'] as $key => $name) {
                        foreach ($languages as $language) {
                            Yii::$app->cache->delete('menuTree' . $key . $language->url);
                        }
                    }
                    return $this->redirect(['index']);
                }
            }
            $parentList = ArrayHelper::map($model->listAll(), 'id', 'title');
            //$parent = $model->parents(1)->one();
            //$model->parent_id = $parent->id;
            $listUrls = ArrayHelper::map($model->listUrls(), 'url', 'name');
            if (!array_key_exists($model->url, $listUrls)) {
                $listUrls += [$model->url => $model->url];
            }
            $available_roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
            return $this->render('update', [
                'model' => $model,
                'modelLng' => $modelLng,
                'parentList' => $parentList,
                'listUrls' => $listUrls,
                'available_roles' => $available_roles,
                'languages' => $languages,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionDelete($id) {
        if (($model = Menus::findOne($id)) !== null) {
            $model->delete();
            $languages = Language::getLanguages();
            foreach (Yii::$app->params['listType'] as $key => $name) {
                foreach ($languages as $language) {
                    Yii::$app->cache->delete('menuTree' . $key . $language->url);
                }
            }
        }
        return $this->redirect(['index']);
    }

    public function actionLists() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $item_id = $_POST['item_id'];
            $parent = Menus::find()->where(['id' => $id])->limit(1)->one();
            $sortingList = ArrayHelper::map(Menus::find()->where(['>', 'lft', $parent->lft])->andWhere(['<', 'rgt', $parent->rgt])->andWhere(['depth' => $parent->depth + 1])->andWhere(['tree' => $parent->tree])->orderBy('lft')->all(), 'id', 'title');
            $selectHtml = '';
            if (!count($sortingList)) {
                $selectFirst = 'selected';
                $selectHtml .= "<option value='first' $selectFirst>" . Yii::t('backend', '- First Element -') . "</option>";
            } else {
                $selectFirst = '';
                $selectLast = '';
                $selectAfterid = 0;
                $selectIn = false;
                if ($item_id) {
                    $item = Menus::find()->where(['id' => $item_id])->limit(1)->one();
                    if ($item->parents(1)->one()->id == $id) {
                        $prev = $item->prev()->one();
                        $next = $item->next()->one();
                        if (empty($prev)) {
                            $selectFirst = 'selected';
                        } elseif (empty($next)) {
                            $selectLast = 'selected';
                        } else {
                            $selectAfterid = $prev->id;
                        }
                    }
                }
                $selectHtml .= "<option value='first' $selectFirst>" . Yii::t('backend', '- First Element -') . "</option>";
                foreach ($sortingList as $key => $item) {
                    if ($key == $selectAfterid) {
                        $selectAfter = 'selected';
                        $selectIn = true;
                    } else {
                        $selectAfter = '';
                    }
                    if ($key == $item_id) {
                        $disabled = 'disabled';
                    } else {
                        $disabled = '';
                    }
                    $selectHtml .= "<option value='$key' $selectAfter $disabled>$item</option>";
                }
                if (!$selectIn && $selectFirst == '') $selectLast = 'selected';
                $selectHtml .= "<option value='last' $selectLast>" . Yii::t('backend', '- Last Element -') . "</option>";
            }
            return $selectHtml;
        }
        return $this->redirect(['index']);
    }

    public function actionParams() {
        if (Yii::$app->request->isAjax) {
            $paramsHtml = Html::hiddenInput("Menus[params]", null);
            $url = $_POST['url'];
            if ($url) {
                $setParams = [];
                $item_id = $_POST['item_id'];
                $listUrls = Menus::listUrls();
                foreach ($listUrls as $url_item) {
                    if ($url == $url_item['url']) {
                        if (count($url_item['params'])) {
                            $paramsHtml = Html::label(Yii::t('backend', 'Params'), "menus-params", ['class' => 'control-label']);
                            if ($item_id) {
                                $item = Menus::find()->select('params')->where(['id' => $item_id, 'url' => $url])->column();
                                if (count($item)) {
                                    $setParams = unserialize($item[0]);
                                }
                            }
                        }
                        foreach ($url_item['params'] as $param) {
                            if ($item_id && isset($setParams[$param])) {
                                $paramsHtml .= '<div class="row"><div class="col-sm-4">' .
                                    Html::label('|__ ' . $param, "menus-params-$param", ['class' => 'control-label']) .
                                    '</div><div class="col-sm-8">' .
                                    Html::textInput("Menus[params][$param]", $setParams[$param], ['id' => "menus-params-$param", 'class' => 'form-control']) .
                                    '</div></div>';
                            } else {
                                $paramsHtml .= '<div class="row"><div class="col-sm-4">' .
                                    Html::label('|__ ' . $param, "menus-params-$param", ['class' => 'control-label']) .
                                    '</div><div class="col-sm-8">' .
                                    Html::textInput("Menus[params][$param]", '', ['id' => "menus-params-$param", 'class' => 'form-control']) .
                                    '</div></div>';
                            }
                        }
                        break;
                    }
                }
            }
            return $paramsHtml;
        }
        return $this->redirect(['index']);
    }

    public function actionPublish($id) {
        Menus::updateAll(['published' => 1], ['id' => $id]);
        $languages = Language::getLanguages();
        foreach (Yii::$app->params['listType'] as $key => $name) {
            foreach ($languages as $language) {
                Yii::$app->cache->delete('menuTree' . $key . $language->url);
            }
        }
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        $category = Menus::find()->where(['id' => $id])->limit(1)->one();
        $categoryChildren = array_merge([$id], $category->children()->select('id')->column());
        Menus::updateAll(['published' => 0], ['in', 'id', $categoryChildren]);
        $languages = Language::getLanguages();
        foreach (Yii::$app->params['listType'] as $key => $name) {
            foreach ($languages as $language) {
                Yii::$app->cache->delete('menuTree' . $key . $language->url);
            }
        }
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUp() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = Menus::find()->where(['id' => $id])->limit(1)->one();
            $prev = $model->prev()->one();
            if (!empty($prev))
                $model->insertBefore($prev);
            $languages = Language::getLanguages();
            foreach (Yii::$app->params['listType'] as $key => $name) {
                foreach ($languages as $language) {
                    Yii::$app->cache->delete('menuTree' . $key . $language->url);
                }
            }
            return true;
        }
        return false;
    }

    public function actionDown() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = Menus::find()->where(['id' => $id])->limit(1)->one();
            $next = $model->next()->one();
            if (!empty($next))
                $model->insertAfter($next);
            $languages = Language::getLanguages();
            foreach (Yii::$app->params['listType'] as $key => $name) {
                foreach ($languages as $language) {
                    Yii::$app->cache->delete('menuTree' . $key . $language->url);
                }
            }
            return true;
        }
        return false;
    }

}