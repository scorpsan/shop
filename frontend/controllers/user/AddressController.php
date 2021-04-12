<?php
namespace frontend\controllers\user;

use frontend\controllers\AppController;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use common\models\ProfileAddress;
use frontend\forms\DeleteForm;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

class AddressController extends AppController
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
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
	{
        $address = new ProfileAddress([
            'user_id' => Yii::$app->user->id,
            'country' => Yii::$app->params['userCountry'],
        ]);

        if ($address->load(Yii::$app->request->post()) && $address->validate()) {
        	if (!$address->save()) {
				Yii::$app->getSession()->setFlash('error', Yii::t('frontend', 'Error Create Address'));
			} else {
                Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Your Address has been added'));
            }
            return $this->redirect(['/user/profile/index']);
        }

        return $this->render('edit', [
            'address' => $address,
        ]);
    }

    public function actionUpdate($id)
	{
		if (!$id) {
			throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
		}

		if (!$address = ProfileAddress::find()->where(['id' => $id])->one()) {
			throw new NotFoundHttpException(Yii::t('error', 'error404 message'));
		}

        if ($address->load(Yii::$app->request->post()) && $address->validate()) {
			if (!$address->save()) {
				Yii::$app->getSession()->setFlash('error', Yii::t('frontend', 'Error Update Address'));
			} else {
                Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Your Address has been updated'));
            }
            return $this->redirect(['/user/profile/index']);
        }

        return $this->render('edit', [
			'address' => $address,
        ]);
    }

	public function actionDelete($id)
	{
		if (!Yii::$app->request->isAjax) {
			throw new MethodNotAllowedHttpException(Yii::t('error', 'error405 message'));
		}

		if (!$id) {
			throw new BadRequestHttpException(Yii::t('error', 'error400 message'));
		}

		$address = ProfileAddress::find()->where(['id' => $id])->one();

		$form = new DeleteForm([
			'text' => Yii::t('frontend', 'Are you sure you want to delete your address?'),
			'confirm' => true,
			'item_id' => $id,
		]);

		if ($form->load(Yii::$app->request->post()) && $form->validate()) {

			if ($address->delete()) {
			    Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Your Address has been deleted'));
			} else {
				Yii::$app->getSession()->setFlash('error', Yii::t('frontend', 'Error Delete Address'));
			}

			return $this->redirect(['/user/profile/index']);
		}

		return $this->renderAjax('delete', [
			'model' => $form,
		]);
	}

}