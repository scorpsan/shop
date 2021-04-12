<?php
/**
 * @var View            $this
 * @var ActiveForm      $form
 * @var ProfileAddress  $address
 */

use yii\web\View;
use common\models\ProfileAddress;
use common\models\Country;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('frontend', 'Address');
?>
<section class="section-account p-0 m-0">
    <div class="my-container">
        <div class="js-filter-popup filter-mobile fliter-product">
            <?= $this->render('../profile/_menu') ?>
        </div>
        <span class="button-filter fas fa-ellipsis-v js-filter d-lg-none"></span>
        <span class="change-button-filter fas fa-times js-close-filter d-none"></span>
        <div class="js-bg-filter bg-filter-overlay"></div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 fliter-product slidebar-col-3">
                <?= $this->render('../profile/_menu') ?>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 category-right">
                <?php
                $breadcrumbs[] = ['label' => Yii::t('frontend', 'My Account'), 'url' => ['/user/profile/index']];
                $breadcrumbs[] = $this->title;
                ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($breadcrumbs) ? $breadcrumbs : [],
                    'tag' => 'div',
                    'options' => ['class' => 'product-toolbar'],
                    'itemTemplate' => '{link} / ',
                    'activeItemTemplate' => '<span>{link}</span>',
                ]); ?>

                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="font-weight-bold"><?= Html::encode($this->title) ?></h3>
                    </div>
                </div>

                <?= $this->render('../shared/_alert') ?>

                <div class="row mb-4">
                    <div class="col-12">
                        <?php $form = ActiveForm::begin([
                            'id' => 'ProfileAddress',
                            'enableClientValidation' => true,
                            'validateOnBlur' => true,
                        ]); ?>

                        <?= $form->field($address, 'title') ?>

                        <div class="row">
                            <div class="col-xl-6">
                                <?= $form->field($address, 'postal') ?>
                            </div>
                            <div class="col-xl-6">
                                <?= $form->field($address, 'country')->dropDownList(Country::getCountryList()) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <?= $form->field($address, 'region') ?>
                            </div>
                            <div class="col-xl-6">
                                <?= $form->field($address, 'district') ?>
                            </div>
                        </div>

                        <?= $form->field($address, 'city') ?>

                        <?= $form->field($address, 'address') ?>

                        <div class="d-flex lr mb-4">
                            <?= Html::a(Yii::t('frontend', 'Cancel'), ['/user/profile/index'], ['class' => 'btn-cancel']) ?>
                            <?= Html::submitButton(Yii::t('frontend', 'Save'), ['class' => 'btn-submit']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>