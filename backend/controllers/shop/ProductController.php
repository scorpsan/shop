<?php
namespace backend\controllers\shop;

use backend\controllers\AppController;
use backend\models\Categories;
use backend\models\ShopBrands;
use backend\models\ShopCharacteristics;
use backend\models\ShopPhotos;
use backend\models\ShopProducts;
use backend\models\ShopProductsCharacteristics;
use backend\models\ShopProductsLng;
use backend\models\ShopProductsSearch;
use backend\models\Language;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ProductController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
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
                        'actions' => ['create', 'update', 'publish', 'unpublish', 'in-stock', 'un-in-stock', 'up', 'down', 'upload-file', 'delete-file', 'sort-file', 'list'],
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
                'class' => VerbFilter::class,
                'actions' => [
                    'upload-file' => ['POST'],
                    'delete-file' => ['POST'],
                    'sort-file' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ShopProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionCreate()
    {
        $model = new ShopProducts([
            'published' => true,
            'in_stock' => false,
            'new' => true,
            'top' => false,
            'hit' => 0,
            'rating' => 0,
            'sorting' => 'last',
        ]);
        $languages = Language::getLanguages();
        $paramsList = ShopCharacteristics::find()->with('translate')->indexBy('alias')->orderBy(['sort' => SORT_ASC])->all();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new ShopProductsLng();
            $modelParams[$lang->url] = new ShopProductsCharacteristics();
        }

        if ($model->load(Yii::$app->request->post())
            && Model::loadMultiple($modelLng, Yii::$app->request->post())
            && Model::loadMultiple($modelParams, Yii::$app->request->post())
        ) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->sorting <> 'last') {
                if ($model->sorting <> 'first')
                    $model->sort = $model->sorting + 1;
                else
                    $model->sort = 1;
            }
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                foreach ($modelParams as $key => $modelP) {
                    $modelP->product_id = $model->id;
                    if ($modelP->validate())
                        $modelP->save(false);
                }
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $root = Categories::find()->where(['alias' => 'shop'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('shop'), 'id', 'title');

        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
            'sortingList' => $model->getSortingLists(),
            'modelParams' => $modelParams,
            'paramsList' => $paramsList,
            'brandList' => ArrayHelper::map(ShopBrands::find()->where(['published' => true])->all(), 'id', 'title'),
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = ShopProducts::find()->where(['id' => $id])->with('translate')->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        $languages = Language::getLanguages();
        $paramsList = ShopCharacteristics::find()->with('translate')->indexBy('alias')->orderBy(['sort' => SORT_ASC])->all();
        $modelLng = ShopProductsLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
        $modelParams = ShopProductsCharacteristics::find()->where(['product_id' => $id])->indexBy('lng')->all();
        foreach ($languages as $lang) {
            if (empty($modelLng[$lang->url])) {
                $modelLng[$lang->url] = new ShopProductsLng();
            }
            if (empty($modelParams[$lang->url])) {
                $modelParams[$lang->url] = new ShopProductsCharacteristics();
            }
        }

        if ($model->load(Yii::$app->request->post())
            && Model::loadMultiple($modelLng, Yii::$app->request->post())
            && Model::loadMultiple($modelParams, Yii::$app->request->post())
        ) {
            if ($model->save()) {
                if ($model->sorting == 'first')
                    $model->moveFirst();
                elseif ($model->sorting == 'last')
                    $model->moveLast();
                else
                    $model->moveToPosition($model->sorting + 1);
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                foreach ($modelParams as $key => $modelP) {
                    $modelP->product_id = $model->id;
                    if ($modelP->validate())
                        $modelP->save(false);
                }
                return $this->redirect(['index']);
            }
        }

        $sortingList = $model->getSortingLists();
        $keys = array_keys($sortingList);
        $found_index = array_search($model->sort, $keys);
        if (!($found_index === false || $found_index === 0))
            $model->sorting = $keys[$found_index - 1];
        else
            $model->sorting = 'last';

        $root = Categories::find()->where(['alias' => 'shop'])->limit(1)->one();
        $parentList = ArrayHelper::map($root->listTreeCategories('shop'), 'id', 'title');

        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'parentList' => $parentList,
            'sortingList' => $model->getSortingLists(),
            'modelParams' => $modelParams,
            'paramsList' => $paramsList,
            'brandList' => ArrayHelper::map(ShopBrands::find()->where(['published' => true])->all(), 'id', 'title'),
        ]);
    }

    public function actionPublish($id)
    {
        if (Yii::$app->request->isAjax) {
            ShopProducts::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnpublish($id)
    {
        if (Yii::$app->request->isAjax) {
            ShopProducts::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionInStock($id)
    {
        if (Yii::$app->request->isAjax) {
            ShopProducts::updateAll(['in_stock' => 1], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnInStock($id)
    {
        if (Yii::$app->request->isAjax) {
            ShopProducts::updateAll(['in_stock' => 0], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUp($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = ShopProducts::find()->where(['id' => $id])->limit(1)->one();
            $model->movePrev();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDown($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = ShopProducts::find()->where(['id' => $id])->limit(1)->one();
            $model->moveNext();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if (!$model = ShopProducts::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

    public function actionUploadFile()
    {
        if (!Yii::$app->request->isAjax) {
            return false;
        }

        $model = new ShopPhotos();

        if ($model->load(Yii::$app->request->post())) {
            $dirRoot = Yii::getAlias('@filesroot/products/' . $model->product_id . '/');
            $dir = Yii::getAlias('@files/products/' . $model->product_id . '/');
            $file = UploadedFile::getInstance($model, 'attachment');

            if ($model->validate(['attachment']) && !empty($file)) {
                $model->url = ShopPhotos::uploadFile($file, Yii::$app->params['productsImagesSize'], $dirRoot);
                $model->attachment = $dir . $model->url;

                if ($model->save()) {
                    return true;
                } else {
                    ShopPhotos::deleteFile($model->url, $dirRoot);
                    $result = ['error' => Yii::t('backend', 'Can not Save file')];
                }
            } else {
                $result = ['error' => Yii::t('backend', 'Can not Upload file')];
                //'error' => $model->getFirstError('attachment')
            }
        } else {
            $result = ['error' => Yii::t('backend', 'Can not Load file')];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionDeleteFile()
    {
        if (!Yii::$app->request->isAjax) {
            return false;
        }

        $post = Yii::$app->request->post();
        $model = ShopPhotos::findOne($post['key']);

        if ($model->delete()) {
            return true;
        } else {
            $result = ['error' => Yii::t('backend', 'Can not Delete file')];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionSortFile()
    {
        if (!Yii::$app->request->isAjax) {
            return false;
        }

        $id = Yii::$app->request->post('id');
        $post = Yii::$app->request->post('sort');

        if ($post['oldIndex'] > $post['newIndex']) {
            $param = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
            $counter = 1;
        } else {
            $param = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
            $counter = -1;
        }
        ShopPhotos::updateAllCounters(['sort' => $counter], ['and', ['product_id' => $id], $param]);
        ShopPhotos::updateAll(['sort' => $post['newIndex']], ['id' => $post['stack'][$post['newIndex']]['key']]);

        return true;
    }

}