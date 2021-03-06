<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\VerbFilter;
use Yii;
use backend\models\Language;
use backend\models\SiteSettings;
use backend\models\SiteSettingsLng;
use yii\base\Model;

class SiteSettingsController extends AppController
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
                'only' => ['index', 'update', 'change-setting'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewSettings'],
                    ],
                    [
                        'actions' => ['update', 'change-setting'],
                        'allow' => true,
                        'roles' => ['editSettings'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $model = SiteSettings::find()
            ->with('translate')
            ->with('translates')
            ->limit(1)->one();
        if (empty($model)) {
            $model = new SiteSettings();
            $model->save(false);
        }
        return $this->render('index', [
            'model' => $model,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionUpdate() {
        $model = SiteSettings::find()->where(['id' => 1])
            ->with('translate')
            ->limit(1)->one();
        $modelLng = SiteSettingsLng::find()->where(['item_id' => 1])->indexBy('lng')->all();
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            if (empty($modelLng[$lang->url])) {
                $modelLng[$lang->url] = new SiteSettingsLng();
            }
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->save();
            foreach ($modelLng as $key => $modelL) {
                $modelL->item_id = $model->id;
                if ($modelL->validate())
                    $modelL->save(false);
            }
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
        ]);
    }

    public function actionChangeSetting() {
        if (Yii::$app->request->isAjax) {
            $setting = Yii::$app->request->post('setting', null);
            if ($setting) {
                $val = (Yii::$app->request->post('val') === 'true');
                SiteSettings::updateAll([$setting => $val]);
                return true;
            }
            return false;
        }
        return false;
    }

}