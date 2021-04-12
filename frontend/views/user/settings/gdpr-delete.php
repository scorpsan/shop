<?php
/**
 * @var View           $this
 * @var $model \Da\User\Form\GdprDeleteForm
 */

use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('usuario', 'Delete personal data');
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
                        <p><?= Yii::t('usuario', 'You are about to delete all your personal data from this site.') ?></p>
                        <p class="text-danger">
                            <?= Yii::t('usuario', 'Once you have deleted your data, you will not longer be able to sign in with this account.') ?>
                        </p>
                        <hr>
                        <?php $form = ActiveForm::begin([]); ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <div class="d-flex lr mb-4">
                            <?= Html::a(Yii::t('usuario', 'Back to privacy settings'), ['/user/settings/privacy'], ['class' => 'btn-cancel']) ?>
                            <?= Html::a(Yii::t('usuario', 'Cancel'), ['/user/profile/index'], ['class' => 'btn-cancel']) ?>
                            <?= Html::submitButton(Yii::t('usuario', 'Delete'), ['class' => 'btn-submit btn-danger']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>