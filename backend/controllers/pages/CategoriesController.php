<?php
namespace backend\controllers\pages;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\base\Model;
use backend\models\Categories;
use backend\models\CategoriesLng;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class CategoriesController extends \backend\controllers\AppController {

    public $clearRoot = true;

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
                        'actions' => ['create', 'update', 'lists', 'publish', 'unpublish', 'up', 'down'],
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
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        if (empty($root)) {
            $root = new Categories();
            $root->alias = 'pages';
            $root->parent_id = 0;
            $root->published = 0;
            $root->noindex = 0;
            $root->page_style = 0;
            $root->makeRoot();
            if (!$this->clearRoot) {
                $languages = Language::getLanguages();
                foreach ($languages as $lang) {
                    $rootLng = new CategoriesLng();
                    $rootLng->item_id = $root->id;
                    $rootLng->lng = $lang->url;
                    $rootLng->title = 'Pages';
                    $rootLng->save();
                }
            }
        }
        $query = Categories::find()
            ->where(['tree' => $root->tree])
            ->with('translate')
            ->with('translates')
            ->orderBy('lft');
        if ($this->clearRoot) {
            $query->andWhere(['<>', 'id', $root->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'clearRoot' => $this->clearRoot,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionView($id) {
        $model = Categories::find()->where(['id' => $id])
            ->with('translate')
            ->with('translates')
            ->limit(1)->one();
        $languages = Language::getLanguages();
        if ($model !== null)
            return $this->render('view', [
                'model' => $model,
                'languages' => $languages,
                'clearRoot' => $this->clearRoot,
            ]);
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionCreate() {
        $model = new Categories();
        $model->published = true;
        $model->noindex = false;
        $model->page_style = false;
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new CategoriesLng();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->parent_id) {
                if ($model->sorting == 'last') {
                    $parent = Categories::find()->where(['id' => $model->parent_id])->limit(1)->one();
                    $model->appendTo($parent);
                } elseif ($model->sorting == 'first') {
                    $parent = Categories::find()->where(['id' => $model->parent_id])->limit(1)->one();
                    $model->prependTo($parent);
                } else {
                    $after = Categories::find()->where(['id' => $model->sorting])->limit(1)->one();
                    $model->insertAfter($after);
                }
            }
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                $this->clearCache();
                return $this->redirect(['index']);
            }
        }
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('pages', $this->clearRoot), 'id', 'title');
        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
            'clearRoot' => $this->clearRoot,
        ]);
    }

    public function actionUpdate($id) {
        $model = Categories::find()->where(['id' => $id])
            ->with('translate')
            ->limit(1)->one();
        $modelLng = CategoriesLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            if (empty($modelLng[$lang->url])) {
                $modelLng[$lang->url] = new CategoriesLng();
            }
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            if ($model->parent_id) {
                if ($model->sorting == 'first') {
                    $parent = Categories::find()->where(['id' => $model->parent_id])->limit(1)->one();
                    $model->prependTo($parent);
                } elseif ($model->sorting == 'last') {
                    $parent = Categories::find()->where(['id' => $model->parent_id])->limit(1)->one();
                    $model->appendTo($parent);
                } else {
                    $after = Categories::find()->where(['id' => $model->sorting])->limit(1)->one();
                    $model->insertAfter($after);
                }
            }
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                if (!$model->published) {
                    $categoryChildren = $model->children()->select('id')->column();
                    Categories::updateAll(['published' => 0], ['in', 'id', $categoryChildren]);
                }
                $this->clearCache();
                return $this->redirect(['index']);
            }
        }
        if ($model->depth == 0 && $model->alias == 'shop') {
            $parentList = [];
            $model->parent_id = 0;
        } elseif ($model->depth == 0) {
            throw new NotFoundHttpException(Yii::t('error', 'error400 message'));
        } else {
            $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
            $parentList = ArrayHelper::map($root->listTreeCategories('pages', $this->clearRoot), 'id', 'title');
            $parent = $model->parents(1)->one();
            $model->parent_id = $parent->id;
        }
        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
            'clearRoot' => $this->clearRoot,
        ]);
    }

    public function actionDelete($id) {
        if (($model = Categories::findOne($id)) !== null) {
            try {
                CategoriesLng::deleteAll(['item_id' => $id]);
                //Pages::updateAll(['category_id' => 0], ['category_id' => $id]);
                $model->delete();
                $this->clearCache();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['index']);
    }

    public function actionPublish($id) {
        Categories::updateAll(['published' => 1], ['id' => $id]);
        $this->clearCache();
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        $category = Categories::find()->where(['id' => $id])->limit(1)->one();
        $categoryChildren = array_merge([$id], $category->children()->select('id')->column());
        Categories::updateAll(['published' => 0], ['in', 'id', $categoryChildren]);
        $this->clearCache();
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUp($id) {
        $model = Categories::find()->where(['id' => $id])->limit(1)->one();
        $prev = $model->prev()->one();
        if (!empty($prev))
            $model->insertBefore($prev);
        $this->clearCache();
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionDown($id) {
        $model = Categories::find()->where(['id' => $id])->limit(1)->one();
        $next = $model->next()->one();
        if (!empty($next))
            $model->insertAfter($next);
        $this->clearCache();
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    private function clearCache() {
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
            Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
            Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
        }
    }

    public function actionLists() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $item_id = $_POST['item_id'];
            $parent = Categories::find()->where(['id' => $id])->limit(1)->one();
            $sortingList = ArrayHelper::map(Categories::find()->where(['>', 'lft', $parent->lft])->andWhere(['<', 'rgt', $parent->rgt])->andWhere(['depth' => $parent->depth + 1])->andWhere(['tree' => $parent->tree])->orderBy('lft')->all(), 'id', 'title');
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
                    $item = Categories::find()->where(['id' => $item_id])->limit(1)->one();
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

}