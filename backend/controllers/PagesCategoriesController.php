<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\base\Model;
use backend\models\Categories;
use backend\models\CategoriesLng;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class PagesCategoriesController extends AppController {

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
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $languages = Language::getLanguages();
        if (empty($root)) {
            $root = new Categories();
            $root->alias = 'pages';
            $root->parent_id = 0;
            $root->published = 0;
            $root->makeRoot();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Categories::find()
                ->where(['tree' => $root->tree])
                ->andWhere(['<>', 'id', $root->id])
                ->with('translate')
                ->with('translates')
                ->orderBy('lft'),
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => $languages,
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
            ]);
        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    public function actionCreate() {
        $model = new Categories();
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
                foreach ($languages as $language) {
                    Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
                    Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
                    Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
                }
                return $this->redirect(['index']);
            }
        }
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('pages'), 'id', 'title');
        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'parentList' => $parentList,
            'languages' => $languages,
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
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
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
                foreach ($languages as $language) {
                    Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
                    Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
                    Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
                }
                return $this->redirect(['index']);
            }
        }
        $root = Categories::find()->where(['alias' => 'pages'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('pages'), 'id', 'title');
        $parent = $model->parents(1)->one();
        $model->parent_id = $parent->id;
        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'parentList' => $parentList,
            'languages' => $languages,
        ]);
    }

    public function actionDelete($id) {
        if (($model = Categories::findOne($id)) !== null) {
//            CategoriesLng::deleteAll(['item_id' => $id]);
//            Pages::updateAll(['category_id' => 0], ['category_id' => $id]);
            $model->delete();
            $languages = Language::getLanguages();
            foreach ($languages as $language) {
                Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
                Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
                Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
            }
        }
        return $this->redirect(['index']);
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

    public function actionPublish($id) {
        Categories::updateAll(['published' => 1], ['id' => $id]);
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
            Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
            Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
        }
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        $category = Categories::find()->where(['id' => $id])->limit(1)->one();
        $categoryChildren = array_merge([$id], $category->children()->select('id')->column());
        Categories::updateAll(['published' => 0], ['in', 'id', $categoryChildren]);
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
            Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
            Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
        }
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUp() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = Categories::find()->where(['id' => $id])->limit(1)->one();
            $prev = $model->prev()->one();
            if (!empty($prev))
                $model->insertBefore($prev);
            $languages = Language::getLanguages();
            foreach ($languages as $language) {
                Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
                Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
                Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
            }
            return true;
        }
        return false;
    }

    public function actionDown() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = Categories::find()->where(['id' => $id])->limit(1)->one();
            $next = $model->next()->one();
            if (!empty($next))
                $model->insertAfter($next);
            $languages = Language::getLanguages();
            foreach ($languages as $language) {
                Yii::$app->cache->delete('basicTreeCategories' . 'pages' . $language->url);
                Yii::$app->cache->delete('listTreeCategories' . 'pages' . $language->url);
                Yii::$app->cache->delete('menuTreeCategories' . 'pages' . $language->url);
            }
            return true;
        }
        return false;
    }

}