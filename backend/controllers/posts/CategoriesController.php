<?php
namespace backend\controllers\posts;

use backend\controllers\AppController;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use Yii;
use yii\base\Model;
use backend\models\Categories;
use backend\models\CategoriesLng;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class CategoriesController extends AppController
{
    public $clearRoot = true;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewPages'],
                    ],
                    [
                        'actions' => ['create', 'update', 'publish', 'unpublish', 'up', 'down', 'lists'],
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
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $root = Categories::find()->where(['alias' => 'posts'])->limit(1)->one();
        if (empty($root)) {
            $root = new Categories([
                'alias' => 'posts',
                'parent_id' => 0,
                'published' => 0,
                'noindex' => 0,
                'page_style' => 0,
            ]);
            $root->makeRoot();
            if (!$this->clearRoot) {
                $languages = Language::getLanguages();
                foreach ($languages as $lang) {
                    $rootLng = new CategoriesLng([
                        'item_id' => $root->id,
                        'lng' => $lang->url,
                        'title' => 'Posts',
                    ]);
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

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new Categories([
            'published' => true,
            'noindex' => false,
            'page_style' => false,
        ]);
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
        $root = Categories::find()->where(['alias' => 'posts'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('posts', $this->clearRoot), 'id', 'title');

        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
            'clearRoot' => $this->clearRoot,
        ]);
    }

    public function actionUpdate($id)
    {
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

        if ($model->depth == 0 && $model->alias == 'posts') {
            $parentList = array();
            $model->parent_id = 0;
        } elseif ($model->depth == 0) {
            throw new NotFoundHttpException(Yii::t('error', 'error400 message'));
        } else {
            $root = Categories::find()->where(['alias' => 'posts'])->limit(1)->one();
            $parentList = ArrayHelper::map($root->listTreeCategories('posts', $this->clearRoot), 'id', 'title');
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

    public function actionPublish($id)
    {
        if (Yii::$app->request->isAjax) {
            Categories::updateAll(['published' => 1], ['id' => $id]);
            $this->clearCache();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnpublish($id)
    {
        if (Yii::$app->request->isAjax) {
            $category = Categories::find()->where(['id' => $id])->limit(1)->one();
            $categoryChildren = array_merge([$id], $category->children()->select('id')->column());
            Categories::updateAll(['published' => 0], ['in', 'id', $categoryChildren]);
            $this->clearCache();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUp($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Categories::find()->where(['id' => $id])->limit(1)->one();
            $prev = $model->prev()->one();
            if (!empty($prev))
                $model->insertBefore($prev);
            $this->clearCache();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDown($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = Categories::find()->where(['id' => $id])->limit(1)->one();
            $next = $model->next()->one();
            if (!empty($next))
                $model->insertAfter($next);
            $this->clearCache();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if (!$model = Categories::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            CategoriesLng::deleteAll(['item_id' => $id]);
            $this->clearCache();
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

    private function clearCache()
    {
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            Yii::$app->cache->delete('basicTreeCategories' . 'posts' . $language->url);
            Yii::$app->cache->delete('listTreeCategories' . 'posts' . $language->url);
            Yii::$app->cache->delete('menuTreeCategories' . 'posts' . $language->url);
        }
    }

    public function actionLists()
    {
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