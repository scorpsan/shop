<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use Yii;
use yii\base\DynamicModel;
use backend\models\Language;
use backend\models\SwiperSlides;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class SwiperSlidesController extends AppController
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

    public function actionIndex($item_id = null)
    {
        if ($item_id && Yii::$app->request->isAjax) {
            $slides = SwiperSlides::find()->where(['item_id' => $item_id])->orderBy(['sort' => SORT_ASC])->all();

            return $this->renderAjax('index', [
                'slides' => $slides,
            ]);
        }
        return false;
    }

    public function actionCreate($item_id = null)
    {
        if ($item_id && Yii::$app->request->isAjax) {
            $model = new SwiperSlides();
            $model->item_id = $item_id;
            $model->published = true;
            if ($model->load(Yii::$app->request->post())) {
                // JSON response
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->sorting <> 'last') {
                    if ($model->sorting <> 'first')
                        $model->sort = $model->sorting + 1;
                    else
                        $model->sort = 1;
                }
                if ($model->save()) {
                    return ['success' => true];
                }
                return ['success' => false];
            }

            return $this->renderAjax('_form', [
                'model' => $model,
                'sortingList' => $this->sortingLists(),
                'languages' => ArrayHelper::map(Language::getLanguages(), 'url', 'title'),
            ]);
        }
        return false;
    }

    public function actionUpdate($id = null)
    {
        if ($id && Yii::$app->request->isAjax) {
            $model = SwiperSlides::find()->where(['id' => $id])->limit(1)->one();
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
                return ['success' => false];
            }

            return $this->renderAjax('_form', [
                'model' => $model,
                'sortingList' => $this->sortingLists(),
                'languages' => ArrayHelper::map(Language::getLanguages(), 'url', 'title'),
            ]);
        }
        return false;
    }

    public function actionPublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            SwiperSlides::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUnpublish() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            SwiperSlides::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return false;
    }

    public function actionUp() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = SwiperSlides::find()->where(['id' => $id])->limit(1)->one();
            $model->movePrev();
            return true;
        }
        return false;
    }

    public function actionDown() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', null);
            $model = SwiperSlides::find()->where(['id' => $id])->limit(1)->one();
            $model->moveNext();
            return true;
        }
        return false;
    }

    public function actionDelete($id = null) {
        if ($id && Yii::$app->request->isAjax) {
            if (($model = SwiperSlides::findOne($id)) !== null) {
                $delmodel = new DynamicModel(['delete', 'item_id']);
                $delmodel->addRule(['delete'], 'boolean')->addRule(['item_id'], 'integer');
                $delmodel->item_id = $model->item_id;
                if ($delmodel->load(Yii::$app->request->post())) {
                    // JSON response
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if (($model = SwiperSlides::findOne($id)) !== null && $delmodel->delete) {
                        $model->delete();
                        return ['success' => true];
                    }
                    return ['success' => false];
                }
                return $this->renderAjax('_delete', [
                    'model' => $delmodel,
                ]);
            }
        }
        return false;
    }

    protected function sortingLists($item_id = null)
    {
        $sortingList = ArrayHelper::map(SwiperSlides::find()->orderBy(['sort' => SORT_ASC])->all(), 'sort', 'title');
        if ($item_id)
            $item = SwiperSlides::find()->where(['id' => $item_id])->limit(1)->one();
        else
            $item = SwiperSlides::find()->orderBy(['sort' => SORT_DESC])->limit(1)->one();
        if (!count($sortingList)) {
            if (empty($item)) {
                $sortingList = ['last' => Yii::t('backend', '- First Element -')];
            } else {
                $sortingList = ['first' => Yii::t('backend', '- First Element -'), 'last' => Yii::t('backend', '- Last Element -')];
            }
        } else {
            $sortingList = ['first' => Yii::t('backend', '- First Element -')] + $sortingList + ['last' => Yii::t('backend', '- Last Element -')];
        }
        return $sortingList;
    }

}