<?php
namespace backend\controllers\shop;

use backend\models\Language;
use backend\models\ShopBrands;
use backend\models\ShopBrandsLng;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BrandController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewPages'],
                    ],
                    [
                        'actions' => ['create', 'update', 'publish', 'unpublish'],
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
        if (in_array($action->id, ['index'], true)) {
            Url::remember('', 'actions-redirect');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $query = ShopBrands::find()
            ->with('translate')
            ->with('translates')
            ->orderBy('alias');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionCreate() {
        $model = new ShopBrands();
        $model->published = true;
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new ShopBrandsLng();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            try {
                $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
                if ($model->save()) {
                    foreach ($modelLng as $key => $modelL) {
                        $modelL->item_id = $model->id;
                        if ($modelL->validate())
                            $modelL->save(false);
                    }
                    return $this->redirect(['index']);
                }
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
        ]);
    }

    public function actionUpdate($id) {
        if (($model = ShopBrands::find()->where(['id' => $id])
                ->with('translate')
                ->limit(1)->one()) !== null) {
            $modelLng = ShopBrandsLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
            $languages = Language::getLanguages();
            foreach ($languages as $lang) {
                if (empty($modelLng[$lang->url])) {
                    $modelLng[$lang->url] = new ShopBrandsLng();
                }
            }
            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
                try {
                    $model->save();
                    foreach ($modelLng as $key => $modelL) {
                        $modelL->item_id = $model->id;
                        if ($modelL->validate())
                            $modelL->save(false);
                    }
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
            return $this->render('create', [
                'model' => $model,
                'modelLng' => $modelLng,
                'languages' => $languages,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionPublish($id) {
        ShopBrands::updateAll(['published' => 1], ['id' => $id]);
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        ShopBrands::updateAll(['published' => 0], ['id' => $id]);
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionDelete($id) {
        if (($model = ShopBrands::findOne($id)) !== null) {
            try {
                ShopBrandsLng::deleteAll(['item_id' => $id]);
                //ShopProducts::updateAll(['brand_id' => 0], ['brand_id' => $id]);
                $model->delete();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['index']);
    }

}