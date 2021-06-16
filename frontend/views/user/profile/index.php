<?php
/**
 * @var View          $this
 * @var \common\models\Profile      $profile
 * @var \frontend\models\ProfileAddress     $userAddresses
 */

use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
use yii\bootstrap4\Html;

$this->title = Yii::t('frontend', 'My Account');

$module = Yii::$app->getModule('user');
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
$user = $profile->user;
$name = empty($profile->name) ? Html::encode($user->username) : Html::encode($profile->name);
?>
<section class="section-account myaccount p-0 m-0">
    <div class="my-container">
        <div class="js-filter-popup filter-mobile fliter-product">
            <?= $this->render('_menu') ?>
        </div>
        <span class="button-filter fas fa-ellipsis-v js-filter d-lg-none"></span>
        <span class="change-button-filter fas fa-times js-close-filter d-none"></span>
        <div class="js-bg-filter bg-filter-overlay"></div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 fliter-product slidebar-col-3">
                <?= $this->render('_menu') ?>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 category-right">
                <?php $breadcrumbs[] = $this->title; ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($breadcrumbs) ? $breadcrumbs : [],
                    'tag' => 'div',
                    'options' => ['class' => 'product-toolbar'],
                    'itemTemplate' => '{link} / ',
                    'activeItemTemplate' => '<span>{link}</span>',
                ]); ?>

                <?= $this->render('../shared/_alert') ?>

                <div class="row mb-4">
                    <div class="col-sm-6 col-xs-12 mb-4">
                        <h3 class="font-weight-bold"><?= $name ?><?php if ($user->username != $user->email) { ?> <span class="font-size-16">(<?= Html::encode($user->username) ?>)</span><?php } ?></h3>
                        <p class="text-muted"><?= Yii::t('usuario', 'Joined on {0, date}', $user->created_at) ?></p>
                        <div class="mb-2">
                            <p class="mb-1"><?= Yii::t('frontend', 'Phone') ?> :</p>
                            <h5 class="font-size-16"><?= Html::encode($user->phone) ?></h5>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1">E-mail :</p>
                            <h5 class="font-size-16"><?= Html::encode($user->email) ?></h5>
                        </div>
                        <?php if (!empty($profile->public_email) && ($profile->public_email != $user->email)): ?>
                            <div class="mb-2">
                                <p class="mb-1"><?= Yii::t('frontend', 'Email') ?> :</p>
                                <h5 class="font-size-16"><?= Html::encode($profile->public_email) ?></h5>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6 col-xs-12 mb-4">
                        <?= Html::a(Yii::t('frontend', 'Edit Profile'), ['/user/settings/profile'], ['class' => 'btn-black']) ?>
                        <?= Html::a(Yii::t('frontend', 'Edit Account'), ['/user/settings/account'], ['class' => 'btn-black']) ?>
                        <?= Html::a(Yii::t('frontend', 'Change Password'), ['/user/settings/account'], ['class' => 'btn-black']) ?>
                        <?php if ($module->enableGdprCompliance || $module->allowAccountDelete || $module->enableTwoFactorAuthentication) { ?>
                            <?= Html::a(Yii::t('usuario', 'Privacy'), ['/user/settings/privacy'], ['class' => 'btn-black']) ?>
                        <?php } ?>
                        <?php if ($networksVisible) { ?>
                            <?= Html::a(Yii::t('usuario', 'Networks'), ['/user/settings/networks'], ['class' => 'btn-black']) ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="heading-3 font-weight-bold"><?= Yii::t('frontend', 'Addresses') ?></h4>
                    </div>
                </div>

                <div class="row mb-4">
                    <?php if (count($userAddresses)) { ?>
                        <?php foreach ($userAddresses as $key => $address) { ?>
                            <div class="col-lg-4 col-sm-6 mb-4">
                                <div class="card border rounded active h-100">
                                    <div class="card-body">
                                        <?= Html::a('<i class="fas fa-times-circle text-danger font-size-16"></i>', ['/user/address/delete', 'id' => $address->id], [
                                            'title' => Yii::t('frontend', 'Delete'),
                                            'class' => 'profileButton float-right ml-1',
                                        ]) ?>

                                        <?= Html::a('<i class="fas fa-pen font-size-16"></i>', ['/user/address/update', 'id' => $address->id], [
                                            'title' => Yii::t('frontend', 'Change'),
                                            'class' => 'float-right ml-1',
                                        ]) ?>

                                        <h5 class="font-size-16 mb-4"><?= $address->title ?></h5>
                                        <div class="table-responsive">
                                            <?= DetailView::widget([
                                                'model' => $address,
                                                'options' => [
                                                    'class' => 'table table-borderless mb-0',
                                                ],
                                                'template' => '<tr><th class="text-muted">{label}</th><td{contentOptions}>{value}</td></tr>',
                                                'attributes' => [
                                                    'city',
                                                    'address',
                                                    'postal',
                                                ],
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="card border rounded active h-100">
                            <div class="card-body">
                                <?= Html::a(Yii::t('frontend', 'Create'), ['/user/address/create'], ['class' => 'btn-black']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="modal-overlay" class="modal-profile" style="display:none;">
    <div class="modal-popup">
        <div class="modal-content">
            <button type="button" class="btn-close" id="button-close" data-dismiss="modal"><span class="fas fa-times" aria-hidden="true"></span></button>
            <div class="content py-4">
                <div class="loading"></div>
            </div>
        </div>
    </div>
</div>
<?php
// обновление данных в таблице статистики 1 раз в 5 минут
$script = <<<JS
$(document).on('click', '.profileButton', function(e) {
   e.preventDefault();
   var modal = $('#modal-overlay');
   modal.find('.content').html('<div class="loading"></div>');
   modal.modal('show');
   modal.find('.content').load($(this).attr('href'));
});
JS;
//Регистрируем скрипты
$this->registerJs($script, View::POS_READY);