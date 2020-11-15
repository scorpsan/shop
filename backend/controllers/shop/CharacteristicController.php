<?php
namespace backend\controllers\shop;

use backend\models\Language;
use backend\models\ShopCharacteristics;
use backend\models\ShopCharacteristicsLng;
use backend\models\ShopProductsCharacteristics;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CharacteristicController extends Controller {

    private $typeMap = [
        //'pk' => 'Primary Key',//"int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY"
        //'bigpk' => 'Big Primary Key',//"bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY"
        //'upk' => 'Un Primary Key',//"int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY"
        'char' => 'Char(1)',//"char(1)"
        'string' => 'String(255)',//"varchar(255)"
        //'text' => 'Text',//"text"
        'smallint' => 'SmInteger(6)',//"smallint(6)"
        'integer' => 'Integer(11)',//"int(11)"
        //'bigint' => 'BigInteger(20)',//"bigint(20)"
        'boolean' => 'Boolean',//"tinyint(1)"
        'float' => 'Float',//"float"
        //'decimal' => 'Decimal',//"decimal"
        //'datetime' => 'Datetime',//"datetime"
        //'timestamp' => 'Timestamp',//"timestamp"
        //'time' => 'Time',//"time"
        //'date' => 'Date',//"date"
        //'money' => 'Money (Decimal 19,4)',//"decimal(19,4)"
        //'binary' => 'Binary',//"blob"
    ];

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
        $query = ShopCharacteristics::find()
            ->with('translate')
            ->with('translates')
            ->orderBy(['sort' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionCreate() {
        $model = new ShopCharacteristics();
        $model->required = false;
        $model->published = true;
        $model->sorting = 'last';
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new ShopCharacteristicsLng();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            try {
                $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
                if ($model->sorting <> 'last') {
                    if ($model->sorting <> 'first')
                        $model->sort = (int)$model->sorting + 1;
                    else
                        $model->sort = 1;
                }
                $model->save();
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                Yii::$app->db->createCommand()
                    ->addColumn(ShopProductsCharacteristics::tableName(), $model->alias, $model->type)
                    ->execute();
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
            'typeList' => $this->typeMap,
            'sortingList' => $model->getSortingLists(),
        ]);
    }

    public function actionUpdate($id) {
        if (($model = ShopCharacteristics::find()->where(['id' => $id])
                ->with('translate')
                ->limit(1)->one()) !== null) {
            $modelLng = ShopCharacteristicsLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
            $languages = Language::getLanguages();
            foreach ($languages as $lang) {
                if (empty($modelLng[$lang->url])) {
                    $modelLng[$lang->url] = new ShopCharacteristicsLng();
                }
            }
            $sortingList = $model->getSortingLists();
            $keys = array_keys($sortingList);
            $found_index = array_search($model->sort, $keys);
            if (!($found_index === false || $found_index === 0))
                $model->sorting = $keys[$found_index - 1];
            else
                $model->sorting = 'last';
            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
                try {
                    if ($model->getOldAttribute('alias') !== $model->alias)
                        Yii::$app->db->createCommand()
                            ->renameColumn(ShopProductsCharacteristics::tableName(), $model->getOldAttribute('alias'), $model->alias)
                            ->execute();
                    if ($model->getOldAttribute('type') !== $model->type)
                        Yii::$app->db->createCommand()
                            ->alterColumn(ShopProductsCharacteristics::tableName(), $model->alias, $model->type)
                            ->execute();
                    $model->save();
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
                'typeList' => $this->typeMap,
                'sortingList' => $sortingList,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
    }

    public function actionPublish($id) {
        ShopCharacteristics::updateAll(['published' => 1], ['id' => $id]);
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionUnpublish($id) {
        ShopCharacteristics::updateAll(['published' => 0], ['id' => $id]);
        if (Yii::$app->request->isAjax) return $this->actionIndex();
        return $this->redirect(Url::previous('actions-redirect'));
    }

    public function actionDelete($id) {
        if (($model = ShopCharacteristics::findOne($id)) !== null) {
            try {
                ShopCharacteristicsLng::deleteAll(['item_id' => $id]);
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