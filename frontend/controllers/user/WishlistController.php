<?php
namespace frontend\controllers\user;

use frontend\controllers\AppController;
use frontend\controllers\CartController;
use frontend\models\ShopProducts;
use frontend\models\UserWishlistItems;
use yii\filters\AccessControl;
use Da\User\Filter\AccessRuleFilter;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class WishlistController extends AppController
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
                        'actions' => ['index', 'add', 'delete', 'to-cart'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
	{
        Yii::$app->user->setReturnUrl(['index']);

        $wishlist = UserWishlistItems::find()->where(['user_id' => Yii::$app->user->id])->with('product')->all();

        $this->title = Yii::t('frontend', 'My Wish List');
        $this->setMeta($this->title, Yii::$app->params['keywords'], Yii::$app->params['description']);

        return $this->render('index', [
            'wishlist' => $wishlist,
        ]);
    }

    public function actionAdd()
	{
        $data = Yii::$app->request->post();
        if (!$product = ShopProducts::find()->where(['id' => $data['id']])->one()) {
            return [
                'error' => true,
                'message' => Yii::t('frontend', 'Add to Wishlist failed! Product not found.'),
            ];
        }

        if (!$wish = UserWishlistItems::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => $data['id']])->one()) {
            $newwish = new UserWishlistItems([
                'user_id' => Yii::$app->user->id,
                'product_id' => $data['id'],
            ]);
            $newwish->save();
            $message = Yii::t('frontend', 'Successfully added to Wishlist!');
        } else {
            $message = Yii::t('frontend', 'This Product is already on the Wishlist!');
        }

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'name' => $product->title,
            'image' => $product->smallImageMain,
            'message' => $message,
        ];
    }

	public function actionDelete()
	{
        $data = Yii::$app->request->post();

        if ($wish = UserWishlistItems::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => $data['id']])->one()) {
            $wish->delete();
        }

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
        ];
	}

	public function actionToCart()
    {
        $data = Yii::$app->request->post();

        if ($wish = UserWishlistItems::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => $data['id']])->one()) {
            if (!$product = $wish->product) {
                return [
                    'error' => true,
                    'message' => Yii::t('frontend', 'Error adding to cart! Product not found.'),
                ];
            }
        }

        if (CartController::ItemToCart($data['id'], 1)) {
            $wish->delete();
        }

        if (!Yii::$app->request->isAjax) {
            return $this->goBack();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'name' => $product->title,
            'image' => $product->smallImageMain,
            'message' => Yii::t('frontend', 'Successfully added to cart!'),
            'qty' => ArrayHelper::getValue(Yii::$app->session, 'cart.qty', 0),
        ];
    }

}