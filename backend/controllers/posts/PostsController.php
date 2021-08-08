<?php
namespace backend\controllers\posts;

use backend\controllers\AppController;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use yii\data\ActiveDataProvider;
use backend\models\Categories;
use backend\models\Posts;
use backend\models\PostsLng;
use backend\models\Language;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class PostsController extends AppController
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
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Posts::find()->with('translate')->with('translates')->orderBy(['created_at' => SORT_DESC]),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'languages' => Language::getLanguages(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Posts();
        $model->published = true;
        $model->noindex = false;

        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $modelLng[$lang->url] = new PostsLng();
        }

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
            }
            return $this->redirect(['index']);
        }

        $root = Categories::find()->where(['alias' => 'posts'])->limit(1)->one();
        $categoryList = ArrayHelper::map($root->listTreeCategories('posts'), 'id', 'title');

        return $this->render('create', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'categoryList' => $categoryList,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = Posts::find()->where(['id' => $id])
            ->with('translate')
            ->limit(1)->one()) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        $modelLng = PostsLng::find()->where(['item_id' => $id])->indexBy('lng')->all();
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            if (empty($modelLng[$lang->url])) {
                $modelLng[$lang->url] = new PostsLng();
            }
        }

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($modelLng, Yii::$app->request->post())) {
            $model->titleDefault = $modelLng[Yii::$app->params['defaultLanguage']]->title;
            if ($model->save()) {
                foreach ($modelLng as $key => $modelL) {
                    $modelL->item_id = $model->id;
                    if ($modelL->validate())
                        $modelL->save(false);
                }
                return $this->redirect(['index']);
            }
        }

        $root = Categories::find()->where(['alias' => 'posts'])->limit(1)->one();
        $categoryList = ArrayHelper::map($root->listTreeCategories('posts'), 'id', 'title');

        return $this->render('update', [
            'model' => $model,
            'modelLng' => $modelLng,
            'languages' => $languages,
            'categoryList' => $categoryList,
        ]);
    }

    public function actionPublish($id)
    {
        if (Yii::$app->request->isAjax) {
            Posts::updateAll(['published' => 1], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionUnpublish($id)
    {
        if (Yii::$app->request->isAjax) {
            Posts::updateAll(['published' => 0], ['id' => $id]);
            return true;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if (!$model = Posts::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
        }

        if (Yii::$app->request->isAjax) {
            return $model->delete();
        }
        return $this->redirect(['index']);
    }

}