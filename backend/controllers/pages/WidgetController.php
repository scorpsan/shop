<?php
namespace backend\controllers\pages;

use Yii;
use yii\filters\AccessControl;
use backend\models\PagesSection;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class WidgetController extends \backend\controllers\AppController {

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

    public function actionCreate($item_id = null) {
        if ($item_id && Yii::$app->request->isAjax) {
            $model = new PagesSection(['scenario' => PagesSection::SCENARIO_WIDGET2]);
            $model->item_id = $item_id;
            $model->widget = true;
            $model->scenario = PagesSection::SCENARIO_WIDGET2;
            if ($model->load(Yii::$app->request->post())) {
                if (isset($model->widget_type)) {
                    if (isset(Yii::$app->params['widgetsList'][$model->widget_type]['class'])) {
                        $widgetClass = Yii::$app->params['widgetsList'][$model->widget_type]['class'];
                        Yii::$app->params['widgetsList'][$model->widget_type]['options'] = $widgetClass::getOptionsList();
                    }
                }
                if (isset($model->title)) {
                    if ($model->sorting <> 'last') {
                        if ($model->sorting <> 'first')
                            $model->sort = $model->sorting + 1;
                        else
                            $model->sort = 1;
                    }
                    $model->content = serialize($model->widget_params);
                    // JSON response
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if ($model->save()) {
                        return ['success' => true];
                    }
                    Yii::info($model->errors);
                    return ['success' => false];
                }
            } else {
                $model->scenario = PagesSection::SCENARIO_WIDGET1;
            }
            if ($model->scenario === PagesSection::SCENARIO_WIDGET2) {
                $model->show_title = false;
                $model->published = true;
                $model->style = 'bg-white';
                $model->parallax = false;
                $model->sorting = 'last';
            }
            return $this->renderAjax('_form', [
                'model' => $model,
                'sortingList' => $model->getSortingLists(),
            ]);
        }
        throw new NotFoundHttpException(Yii::t('error', 'error400 message'));
        //\DomainException(Yii::t('error', 'error400 message'));
    }

    public function actionUpdate($id = null) {
        if ($id && Yii::$app->request->isAjax) {
            $model = PagesSection::find()->where(['id' => $id, 'widget' => true])->limit(1)->one();
            $model->scenario = PagesSection::SCENARIO_WIDGET2;
            if (isset(Yii::$app->params['widgetsList'][$model->widget_type]['class'])) {
                $widgetClass = Yii::$app->params['widgetsList'][$model->widget_type]['class'];
                Yii::$app->params['widgetsList'][$model->widget_type]['options'] = ArrayHelper::index($widgetClass::getOptionsList(), 'key');
            }
            $model->widget_params = unserialize($model->content);
            if ($model->load(Yii::$app->request->post())) {
                if (isset(Yii::$app->params['widgetsList'][$model->widget_type]['params']['show_title']) && !Yii::$app->params['widgetsList'][$model->widget_type]['params']['show_title']) {
                    if (isset(Yii::$app->params['widgetsList'][$model->widget_type]['class'])) {
                        $model->title = Yii::$app->params['widgetsList'][$model->widget_type]['options']['id']['dropList'][$model->widget_params['id']];
                    } else {
                        $model->title = Yii::$app->params['widgetsList'][$model->widget_type]['title'];
                    }
                }
                $model->content = serialize($model->widget_params);
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

}