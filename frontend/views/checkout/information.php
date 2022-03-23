<?php
/**
 * @var $productList \frontend\models\ShopProducts
 * @var $cartList array
 * @var $formInfo \frontend\forms\CheckoutForm
 * @var $shipMethod \frontend\models\ShopDelivery
 * @var $subtotal float
 * @var $total float
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Country;
use frontend\widgets\phoneInput\phoneInputWidget;
use yii\bootstrap4\Html;

$this->title = Yii::t('frontend', 'Information');

$user = Yii::$app->user;
?>

<?= $this->render('_aside_head', ['total' => $total]) ?>

<div class="content">
    <div class="wrap">
        <div class="main">
            <header class="main__header" role="banner">
                <?= Html::a('<span class="logo__text heading-1">' . Yii::$app->name . '</span>', ['/page/index'], ['title' => Yii::$app->name, 'class' => 'logo logo--left']) ?>

                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb " role="list">
                        <li class="breadcrumb__item breadcrumb__item--completed">
                            <?= Html::a(Yii::t('frontend', 'Cart'), ['/cart/index'], ['class' => 'breadcrumb__link']) ?>
                            <svg class="icon-svg icon-svg--color-adaptive-light icon-svg--size-10 breadcrumb__chevron-icon" aria-hidden="true" focusable="false"> <use xlink:href="#chevron-right" /> </svg>
                        </li>
                        <li class="breadcrumb__item breadcrumb__item--current" aria-current="step">
                            <?= Html::tag('span', Yii::t('frontend', 'Information'), ['class' => 'breadcrumb__link']) ?>
                            <svg class="icon-svg icon-svg--color-adaptive-light icon-svg--size-10 breadcrumb__chevron-icon" aria-hidden="true" focusable="false"> <use xlink:href="#chevron-right" /> </svg>
                        </li>
                        <li class="breadcrumb__item breadcrumb__item--completed">
                            <?= Html::a(Yii::t('frontend', 'Shipping'), ['/checkout/shipping'], ['class' => 'breadcrumb__link']) ?>
                            <svg class="icon-svg icon-svg--color-adaptive-light icon-svg--size-10 breadcrumb__chevron-icon" aria-hidden="true" focusable="false"> <use xlink:href="#chevron-right" /> </svg>
                        </li>
                        <li class="breadcrumb__item breadcrumb__item--blank">
                            <?= Html::a(Yii::t('frontend', 'Payment'), ['/checkout/payment'], ['class' => 'breadcrumb__link']) ?>
                        </li>
                    </ol>
                </nav>
            </header>
            <main class="main__content" role="main">
                <div class="step">
                    <?php if (!$user->isGuest) { ?>
                        <div class="section__content mb-4">
                            <div class="logged-in-customer-information">
                                <div class="logged-in-customer-information__avatar-wrapper">
                                    <div class="logged-in-customer-information__avatar gravatar" style="background-image: url(<?= $user->identity->profile->avatarUrl ?>);" role="img" aria-label="Avatar"></div>
                                </div>
                                <p class="logged-in-customer-information__paragraph">
                                    <span class="page-main__emphasis"><?= (empty($user->identity->profile->name)) ? Html::encode($user->identity->username) : Html::encode($user->identity->profile->name) ?></span>
                                    <span data-rtl-ensure="">(<?= $user->identity->email ?>)</span>
                                    <br>
                                    <?= Html::a(Yii::t('frontend', 'Sign Out'), ['/user/security/logout'], ['data-method' => 'post', 'title' => Yii::t('frontend', 'Sign Out')]) ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php $form = ActiveForm::begin([
                        'id' => $formInfo->formName(),
                        'options' => ['class' => 'edit_checkout'],
                        'fieldConfig' => [
                            'template' => "<div class=\"field__input-wrapper\">{label}\n{input}</div>\n{hint}\n{error}",
                            'labelOptions' => ['class' => 'field__label field__label--visible'],
                            'errorOptions' => ['class' => 'field__message field__message--error'],
                            'options' => ['class' => 'field'],
                            'inputOptions' => ['class' => 'field__input'],
                        ],
                        'enableClientValidation' => true,
                        'validateOnBlur' => true,
                    ]); ?>

                        <div class="step__sections">
                            <div class="section section--contact-information">
                                <div class="section__header">
                                    <div class="layout-flex layout-flex--tight-vertical layout-flex--loose-horizontal layout-flex--wrap">
                                        <h2 class="section__title layout-flex__item layout-flex__item--stretch" id="main-header" tabindex="-1"><?= Yii::t('frontend', 'Contact information') ?></h2>
                                        <?php if ($user->isGuest) { ?>
                                        <p class="layout-flex__item">
                                            <span aria-hidden="true"><?= Yii::t('frontend', 'Already have an account?') ?></span>
                                            <?= Html::a(Yii::t('frontend', 'Sign In'), ['/user/security/login'], ['title' => Yii::t('frontend', 'My Account')]) ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="section__content">
                                    <div class="fieldset">
                                        <?= $form->field($formInfo, 'email')->input('email', ['placeholder' => $formInfo->getAttributeLabel('email')]) ?>

                                        <?= $form->field($formInfo, 'phone')->widget(phoneInputWidget::class, [
                                            'preferred' => ['BY'],
                                            'options' => [
                                                'class' => 'field__input'
                                            ],
                                            'bsVersion' => 4,
                                            'selectOn' => false,
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="section section--shipping-address">
                                <div class="section__header">
                                    <h2 class="section__title" id="section-delivery-title">
                                        <?= Yii::t('frontend', 'Shipping address') ?>
                                    </h2>
                                </div>
                                <div class="section__content">
                                    <div class="fieldset">
                                        <?php if (!$user->isGuest) { ?>
                                            <?= $form->field($formInfo, 'user_address', [
                                                'template' => "{label}\n<div class=\"field__input-wrapper field__input-wrapper--select\">{input}<div class=\"field__caret\">
                                                        <svg class=\"icon-svg icon-svg--color-adaptive-lighter icon-svg--size-10 field__caret-svg\" role=\"presentation\" aria-hidden=\"true\" focusable=\"false\"> <use xlink:href=\"#caret-down\" /> </svg>
                                                    </div></div>\n{hint}\n{error}",
                                                'options' => ['class' => 'field'],
                                                'inputOptions' => ['class' => 'field__input field__input--select', 'id' => 'custom_address'],
                                            ])->dropDownList(ArrayHelper::map($user->identity->addresses, 'id', 'fullStringAddress'), [
                                                'prompt' => Yii::t('frontend', 'Use a new address'),
                                                'data' => ['url' => Url::to(['/user/address/load'])],
                                            ]) ?>
                                        <?php } ?>

                                        <?= $form->field($formInfo, 'name')->textInput(['placeholder' => $formInfo->getAttributeLabel('name') . ' *'])->hint(Yii::t('frontend', 'If you choose Postal delivery method, please enter your Full Name')) ?>

                                        <div class="address-fields">
                                            <?= $form->field($formInfo, 'address')->textInput(['placeholder' => $formInfo->getAttributeLabel('address') . ' *']) ?>

                                            <?php /*$form->field($formInfo, 'address2')->textInput(['placeholder' => $formInfo->getAttributeLabel('address2')]) ?>

                                            <?= /$form->field($formInfo, 'city')->textInput(['placeholder' => $formInfo->getAttributeLabel('city') . ' *']) ?>

                                            <?= /$form->field($formInfo, 'district')->textInput(['placeholder' => $formInfo->getAttributeLabel('district')]) ?>

                                            <?= /$form->field($formInfo, 'region')->textInput(['placeholder' => $formInfo->getAttributeLabel('region')]) ?>

                                            <?= $form->field($formInfo, 'country', [
                                                'template' => "{label}\n<div class=\"field__input-wrapper field__input-wrapper--select\">{input}<div class=\"field__caret\">
                                                        <svg class=\"icon-svg icon-svg--color-adaptive-lighter icon-svg--size-10 field__caret-svg\" role=\"presentation\" aria-hidden=\"true\" focusable=\"false\"> <use xlink:href=\"#caret-down\" /> </svg>
                                                    </div></div>\n{hint}\n{error}",
                                                'options' => ['class' => 'field--two-thirds field'],
                                                'inputOptions' => ['class' => 'field__input field__input--select'],
                                            ])->dropDownList(Country::getCountryList()) ?>

                                            <?= $form->field($formInfo, 'postal', ['options' => [
                                                'class' => 'field--third field'
                                            ]])->textInput(['placeholder' => $formInfo->getAttributeLabel('postal')]) */ ?>
                                        </div>
                                        <?php if (!$user->isGuest) { ?>
                                            <div class="field" id="remember_me">
                                                <div class="checkbox-wrapper">
                                                    <div class="checkbox__input">
                                                        <input class="input-checkbox" data-backup="remember_me" type="checkbox" value="1" name="<?= $formInfo->formName() ?>[remember_me]" id="checkout_remember_me" />
                                                    </div>
                                                    <label class="checkbox__label" for="checkout_remember_me"><?= Yii::t('frontend', 'Save this address for next time') ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="section section--comment">
                                <div class="section__header">
                                    <h2 class="section__title" id="main-header" tabindex="-1"><?= Yii::t('frontend', 'Comment') ?></h2>
                                </div>
                                <div class="section__content">
                                    <div class="fieldset">
                                        <div class="comment-fields">
                                            <?= $form->field($formInfo, 'note', [
                                                'template' => "{label}\n<div class=\"field__input-wrapper\">{input}</div>\n{hint}\n{error}",
                                                'labelOptions' => ['class' => 'field__label field__label--visible'],
                                                'errorOptions' => ['class' => 'field__message field__message--error'],
                                                'options' => ['class' => 'field'],
                                                'inputOptions' => ['class' => 'field__input'],
                                            ])->textarea() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step__footer">
                            <?= Html::submitButton('<span class="btn__content">' . Yii::t('frontend', 'Continue') . '</span>', ['class' => 'step__footer__continue-btn btn']) ?>
                            <?= Html::a('<span class="step__footer__previous-link-content">' . Yii::t('frontend', 'Return to cart') . '</span>', ['/cart/index'], ['class' => 'step__footer__previous-link']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </main>
            <footer class="main__footer" role="contentinfo">
                <p class="copyright-text">Copyright <i class="fa fa-copyright"></i> <?= date('Y') ?> by <a href="#"><?= Yii::$app->name ?></a>. All Rights Reserved. Powered by <a href="https://web-made.biz" target="_blank">Web-Made.biz</a></p>
            </footer>
        </div>

        <?= $this->render('_aside', [
            'productList' => $productList,
            'cartList' => $cartList,
            'shipMethod' => $shipMethod,
            'subtotal' => $subtotal,
            'total' => $total,
        ]) ?>
    </div>
</div>