<?php
/**
 * @var $productList \frontend\models\ShopProducts
 * @var $cartList array
 * @var $formInfo \frontend\forms\CheckoutForm
 * @var $shipMethod \frontend\models\ShopDelivery
 * @var $shippingList \frontend\models\ShopDelivery
 * @var $subtotal float
 * @var $total float
 */

use common\models\Country;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('frontend', 'Shipping');
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
                        <li class="breadcrumb__item breadcrumb__item--completed">
                            <?= Html::a(Yii::t('frontend', 'Information'), ['/checkout/information'], ['class' => 'breadcrumb__link']) ?>
                            <svg class="icon-svg icon-svg--color-adaptive-light icon-svg--size-10 breadcrumb__chevron-icon" aria-hidden="true" focusable="false"> <use xlink:href="#chevron-right" /> </svg>
                        </li>
                        <li class="breadcrumb__item breadcrumb__item--current" aria-current="step">
                            <?= Html::tag('span', Yii::t('frontend', 'Shipping'), ['class' => 'breadcrumb__link']) ?>
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
                    <?php $form = ActiveForm::begin([
                        'id' => $formInfo->formName(),
                        'options' => ['class' => 'edit_checkout'],
                        'fieldConfig' => [
                            'template' => "<div class=\"content-box\">{input}\n{label}</div>\n{hint}\n{error}",
                            'errorOptions' => ['class' => 'field__message field__message--error'],
                            'options' => ['class' => 'section__content'],
                        ],
                        'enableClientValidation' => true,
                        'validateOnBlur' => true,
                    ]); ?>

                        <div class="step__sections">

                            <div class="section">
                                <div class="content-box">
                                    <div role="table" class="content-box__row content-box__row--tight-spacing-vertical">
                                        <div role="row" class="review-block">
                                            <div class="review-block__inner">
                                                <div role="rowheader" class="review-block__label"><?= Yii::t('frontend', 'Contact') ?></div>
                                                <div role="cell" class="review-block__content">
                                                    <bdo dir="ltr">
                                                        <?= $formInfo->name ?><br>
                                                        <?= $formInfo->email ?><br>
                                                        <?= $formInfo->phone ?>
                                                    </bdo>
                                                </div>
                                            </div>
                                            <div role="cell" class="review-block__link">
                                                <?= Html::a('<span aria-hidden="true">' . Yii::t('frontend', 'Change') . '</span>', ['/checkout/information'], ['class' => 'link--small']) ?>
                                            </div>
                                        </div>
                                        <div role="row" class="review-block">
                                            <div class="review-block__inner">
                                                <div role="rowheader" class="review-block__label"><?= Yii::t('frontend', 'Ship to') ?></div>
                                                <div role="cell" class="review-block__content">
                                                    <address class="address address--tight">
                                                        <?php
                                                        $address = [
                                                            $formInfo->address,
                                                            $formInfo->address2,
                                                            $formInfo->city,
                                                            $formInfo->district,
                                                            $formInfo->region,
                                                            Country::getCountryName($formInfo->country),
                                                            $formInfo->postal,
                                                        ];
                                                        echo implode(", ", array_diff($address, array('', NULL, false)));
                                                        ?>
                                                    </address>
                                                </div>
                                            </div>
                                            <div role="cell" class="review-block__link">
                                                <?= Html::a('<span aria-hidden="true">' . Yii::t('frontend', 'Change') . '</span>', ['/checkout/information'], ['class' => 'link--small']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section section--shipping-method">
                                <div class="section__header">
                                    <h2 class="section__title" id="main-header" tabindex="-1"><?= Yii::t('frontend', 'Shipping method') ?></h2>
                                </div>
                                <?php if (count($shippingList)) {
                                    echo $form->field($formInfo, 'shipping_method')->radioList(ArrayHelper::map($shippingList, 'id', 'title'), [
                                        'item' => function($index, $label, $name, $checked, $value) use ($shippingList) {
                                            $check = $checked ? ' checked="checked"' : '';
                                            return "<div class=\"content-box__row\">
                                                        <div class=\"radio-wrapper\">
                                                            <div class=\"radio__input\">
                                                                <input class=\"input-radio\" type=\"radio\" value=\"$value\" name=\"$name\" id=\"shipping_method_$value\" $check />
                                                            </div>
                                                            <label class=\"radio__label\" for=\"shipping_method_$value\">
                                                                <span class=\"radio__label__primary\">$label</span>
                                                                <span class=\"radio__label__accessory\">
                                                                    <span class=\"content-box__emphasis\">" . (($shippingList[$index]->cost) ? Yii::$app->formatter->asCurrency($shippingList[$index]->cost) : Yii::t('frontend','free')) . "</span>
                                                                </span>
                                                            </label>
                                                        </div> <!-- /radio-wrapper-->
                                                    </div>";
                                        },
                                    ])->label(false);
                                } else { ?>
                                <div class="section__content">
                                    <div class="content-box">
                                        <div class="radio-wrapper content-box__row content-box__row--secondary">
                                            <div class="blank-slate">
                                                <p><?= Yii::t('frontend', 'This store is not currently delivery methods.') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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