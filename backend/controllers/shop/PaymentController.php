<?php
namespace backend\controllers\shop;

use backend\controllers\AppController;
use backend\models\ShopPayment;
use backend\models\ShopPaymentLng;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\data\ActiveDataProvider;
use backend\models\Language;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

/**
 * Class DeliveryController
 * @package backend\controllers\shop
 */
class PaymentController extends AppController
{
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
                        'actions' => ['create', 'update', 'publish', 'unpublish', 'up', 'down'],
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

    public function actionIndex()
    {
        $query = ShopPayment::find()
            ->with('translate')
            ->with('translates')
            ->orderBy('sort');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionCreate()
    {
        $model = new ShopPayment([
            'default' => false,
            'published' => true,
        ]);
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new ShopPaymentLng();
        }

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = ShopPayment::find()->where(['id' => $id])->with('translate')->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        $modelLng = ShopPaymentLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            if (empty($modelLng[$lang->url])) {
                $modelLng[$lang->url] = new ShopPaymentLng();
            }
        }

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
        ]);
    }

    public function actionPublish($id)
    {
        if (Yii::$app->request->isAjax) {
            ShopPayment::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnpublish($id)
    {
        if (Yii::$app->request->isAjax) {
            ShopPayment::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if (!$model = ShopPayment::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

    public function actionUp($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = ShopPayment::find()->where(['id' => $id])->limit(1)->one();
            $model->movePrev();
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDown($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = ShopPayment::find()->where(['id' => $id])->limit(1)->one();
            $model->moveNext();
            return true;
        }
        return $this->redirect(['index']);
    }

}