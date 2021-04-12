<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\data\ActiveDataProvider;
use backend\models\Language;
use Yii;
use yii\web\NotFoundHttpException;

class LanguageController extends AppController
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
                        'roles' => ['viewSettings'],
                    ],
                    [
                        'actions' => ['create', 'update', 'publish', 'unpublish'],
                        'allow' => true,
                        'roles' => ['editSettings'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteSettings'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Language::find(),
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Language();
        $model->published = true;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->default) {
                $model->published = true;
                Language::updateAll(['default' => 0]);
            }
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = Language::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->default) {
                $model->published = true;
                Language::updateAll(['default' => 0]);
            }
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPublish($id)
    {
        if (Yii::$app->request->isAjax) {
            Language::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnpublish($id)
    {
        if (Yii::$app->request->isAjax) {
            Language::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if (!$model = Language::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

}