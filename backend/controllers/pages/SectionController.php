<?php
namespace backend\controllers\pages;

use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use backend\models\PagesSection;
use yii\web\Response;

class SectionController extends \backend\controllers\AppController {

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

    public function actionIndex($item_id = null) {
        if ($item_id && Yii::$app->request->isAjax) {
            $sections = PagesSection::find()->where(['item_id' => $item_id])->orderBy(['sort' => SORT_ASC])->all();
            return $this->renderAjax('index', [
                'sections' => $sections,
            ]);
        }
        return false;
    }

    public function actionCreate($item_id = null) {
        if ($item_id && Yii::$app->request->isAjax) {
            $model = new PagesSection(['scenario' => PagesSection::SCENARIO_DEFAULT]);
            $model->item_id = $item_id;
            $model->widget = false;
            $model->show_title = true;
            $model->published = true;
            $model->style = 'bg-white';
            $model->parallax = false;
            $model->sorting = 'last';
            if ($model->load(Yii::$app->request->post())) {
                if ($model->sorting <> 'last') {
                    if ($model->sorting <> 'first')
                        $model->sort = (int)$model->sorting + 1;
                    else
                        $model->sort = 1;
                }
                // JSON response
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->save()) {
                    return ['success' => true];
                }
                Yii::info($model->errors);
                return ['success' => false];
            }
            return $this->renderAjax('_form', [
                'model' => $model,
                'sortingList' => $model->getSortingLists(),
            ]);
        }
        return false;
    }

    public function actionUpdate($id = null) {
        if ($id && Yii::$app->request->isAjax) {
            $model = PagesSection::find()->where(['id' => $id])->limit(1)->one();
            $model->scenario = PagesSection::SCENARIO_DEFAULT;
            if ($model->load(Yii::$app->request->post())) {
                // JSON response
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->save()) {
                    if ($model->sorting == 'first')
                        $model->moveFirst();
                    elseif ($model->sorting == 'last')
                        $model->moveLast();
                    else
                        $model->moveToPosition($model->sorting + 1);
                    return ['success' => true];
                }
                Yii::info($model->errors);
                return ['success' => false];
            }
            return $this->renderAjax('_form', [
                'model' => $model,
                'sortingList' => $model->getSortingLists(),
            ]);
        }
        return false;
    }

    public function actionPublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            PagesSection::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUnpublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            PagesSection::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUp() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = PagesSection::find()->where(['id' => $id])->limit(1)->one();
            $model->movePrev();
            return true;
        }
        return false;
    }

    public function actionDown() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = PagesSection::find()->where(['id' => $id])->limit(1)->one();
            $model->moveNext();
            return true;
        }
        return false;
    }

    public function actionDelete($id = null) {
        if ($id && Yii::$app->request->isAjax) {
            if (($model = PagesSection::findOne($id)) !== null) {
                $delmodel = new DynamicModel(['delete', 'item_id']);
                $delmodel->addRule(['delete'], 'boolean')->addRule(['item_id'], 'integer');
                $delmodel->item_id = $model->item_id;
                if ($delmodel->load(Yii::$app->request->post())) {
                    // JSON response
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if (($model = PagesSection::findOne($id)) !== null && $delmodel->delete) {
                        $model->delete();
                        return true;
                    }
                    Yii::info($model->errors);
                    return false;
                }
                return $this->renderAjax('_delete', [
                    'model' => $delmodel,
                ]);
            }
        }
        return false;
    }

}