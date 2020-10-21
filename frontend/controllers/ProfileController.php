<?php
namespace frontend\controllers;

use Da\User\Controller\ProfileController as BaseProfileController;
use Yii;
use yii\web\NotFoundHttpException;

class ProfileController extends BaseProfileController {

    public function actionIndex() {
        $profile = $this->profileQuery->whereUserId(Yii::$app->user->getId())->one();
        if ($profile === null) {
            throw new NotFoundHttpException();
        }
        return $this->render('show',
            [
                'profile' => $profile,
            ]
        );
    }

    public function actionShow($id = null) {
        return $this->redirect(['index']);
    }
}
