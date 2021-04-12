<?php
/**
 * @var View          $this
 * @var $module \Da\User\Module
 */

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;

$this->title = Yii::t('usuario', 'Privacy settings');

$user = Yii::$app->user->identity;
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
                        <?php if ($module->enableTwoFactorAuthentication) { ?>
                            <h3 class="font-weight-bold"><?= Yii::t('usuario', 'Two Factor Authentication (2FA)') ?></h3>
                            <p><?= Yii::t('usuario', 'Two factor authentication protects you in case of stolen credentials') ?>.</p>
                            <div class="d-flex lr mb-4">
                                <?= Html::a(Yii::t('usuario', 'Disable two factor authentication'),
                                    ['two-factor-disable', 'id' => $user->id],
                                    [
                                        'id' => 'disable_tf_btn',
                                        'class' => 'btn-danger ' . ($user->auth_tf_enabled ? '' : 'hide'),
                                        'data-method' => 'post',
                                        'data-confirm' => Yii::t('usuario', 'This will disable two factor authentication. Are you sure?'),
                                    ]
                                ) ?>
                                <?= Html::a(Yii::t('usuario', 'Enable two factor authentication'),
                                    '#modal-overlay',
                                    [
                                        'id' => 'enable_tf_btn',
                                        'class' => 'btn-submit ' . ($user->auth_tf_enabled ? 'hide' : ''),
                                        'data-toggle' => 'modal',
                                        'data-target' => '.modal-tfmodal'
                                    ]
                                ) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <?php if ($module->allowAccountDelete) { ?>
                            <h3 class="font-weight-bold"><?= Yii::t('usuario', 'Delete account') ?></h3>
                            <p><?= Yii::t('usuario', 'Once you delete your account, there is no going back') ?>.</p>
                            <p><?= Yii::t('usuario', 'It will be deleted forever') ?>.</p>
                            <p><?= Yii::t('usuario', 'Please be certain') ?>.</p>
                            <div class="d-flex lr mb-4">
                                <?= Html::a(Yii::t('usuario', 'Cancel'), ['/user/profile/index'], ['class' => 'btn-cancel']) ?>
                                <?= Html::a(Yii::t('usuario', 'Delete account'), ['delete'], [
                                    'class' => 'btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('usuario', 'Are you sure? There is no going back'),
                                ]) ?>
                            </div>
                        <?php } else { ?>
                            <h3 class="font-weight-bold"><?= Yii::t('usuario', 'Delete my account') ?></h3>
                            <p><?= Yii::t('usuario', 'This will remove your personal data from this site. You will no longer be able to sign in.') ?></p>
                            <div class="d-flex lr mb-4">
                                <?= Html::a(Yii::t('usuario', 'Cancel'), ['/user/profile/index'], ['class' => 'btn-cancel']) ?>
                                <?php if ($module->allowAccountDelete) { ?>
                                    <?= Html::a(Yii::t('usuario', 'Delete account'), ['delete'], [
                                        'id' => 'gdpr-del-button',
                                        'class' => 'btn-danger',
                                        'data-method' => 'post',
                                        'data-confirm' => Yii::t('usuario', 'Are you sure? There is no going back'),
                                    ]) ?>
                                <?php } else { ?>
                                    <?= Html::a(Yii::t('usuario', 'Delete'), ['/user/settings/gdpr-delete'], [
                                        'class' => 'btn-danger',
                                        'id' => 'gdpr-del-button',
                                    ]) ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($module->enableTwoFactorAuthentication) { ?>
    <div id="modal-overlay" class="modal-tfmodal" style="display:none;">
        <div class="modal-popup">
            <div class="modal-content">
                <button type="button" class="btn-close" id="button-close" data-dismiss="modal"><span class="fas fa-times" aria-hidden="true"></span></button>
                <h4 class="modal-title" id="myModalLabel"><?= Yii::t('usuario', 'Two Factor Authentication (2FA)') ?></h4>
                <div class="content py-4">
                    <div class="loading"></div>
                </div>
            </div>
        </div>
    </div>
<?php
    // This script should be in fact in a module as an external file
    // consider overriding this view and include your very own approach
    $uri = Url::to(['two-factor', 'id' => $user->id]);
    $verify = Url::to(['two-factor-enable', 'id' => $user->id]);
$js = <<<JS
$('.modal-tfmodal').on('show.bs.modal', function() {
    if(!$('img#qrCode').length) {
        $(this).find('.content').load('{$uri}');
    } else {
        $('input#tfcode').val('');
    }
});
$(document).on('click', '.btn-submit-code', function(e) {
   e.preventDefault();
   var btn = $(this);
   btn.prop('disabled', true);
   
   $.getJSON('{$verify}', {code: $('#tfcode').val()}, function(data){
      btn.prop('disabled', false);
      if(data.success) {
          $('#enable_tf_btn, #disable_tf_btn').toggleClass('hide');
          $('#tfmessage').removeClass('alert-danger').addClass('alert-success').find('p').text(data.message);
          setTimeout(function() { $('.modal-tfmodal').modal('hide'); }, 2000);
      } else {
          $('input#tfcode').val('');
          $('#tfmessage').removeClass('alert-info').addClass('alert-danger').find('p').text(data.message);
      }
   }).fail(function(){ btn.prop('disabled', false); });
});
JS;

    $this->registerJs($js);
} ?>