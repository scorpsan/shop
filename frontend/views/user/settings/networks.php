<?php
/**
 * @var View           $this
 * @var yii\widgets\ActiveForm $form
 * @var \Da\User\Model\User    $user
 */

use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\bootstrap4\Html;
use Da\User\Widget\ConnectWidget;

$this->title = Yii::t('usuario', 'Networks');
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

                <div class="container my-4">
                    <div class="row">
                        <div class="col-12 info">
                            <div class="alert-dismissible alert-info alert" role="alert">
                                <?= Yii::t('usuario', 'You can connect multiple accounts to be able to log in using them') ?>.
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <?php $auth = ConnectWidget::begin([
                            'baseAuthUrl' => ['/user/security/auth'],
                            'accounts' => $user->socialNetworkAccounts,
                            'autoRender' => false,
                            'popupMode' => false,
                        ]) ?>
                        <table class="table">
                            <?php foreach ($auth->getClients() as $client) { ?>
                                <tr>
                                    <td style="width: 32px; vertical-align: middle">
                                        <?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]) ?>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <strong><?= $client->getTitle() ?></strong>
                                    </td>
                                    <td style="width: 120px">
                                        <?= $auth->isConnected($client) ?
                                            Html::a(Yii::t('usuario', 'Disconnect'), $auth->createClientUrl($client), [
                                                'class' => 'btn btn-danger btn-block',
                                                'data-method' => 'post',
                                            ]) :
                                            Html::a(Yii::t('usuario', 'Connect'), $auth->createClientUrl($client), [
                                                'class' => 'btn btn-success btn-block',
                                            ]) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <?php ConnectWidget::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>