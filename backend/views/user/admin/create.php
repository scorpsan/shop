<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;
/**
 * @var $this       yii\web\View
 * @var $user       \Da\User\Model\User
 */
$this->title = Yii::t('usuario', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('usuario', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@backend/views/user/shared/admin_layout.php') ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        [
                            'label' => Yii::t('usuario', 'Account details'),
                            'url' => ['/user/admin/create'],
                        ],
                        [
                            'label' => Yii::t('usuario', 'Profile details'),
                            'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ],
                        ],
                        [
                            'label' => Yii::t('usuario', 'Information'),
                            'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info">
                    <?= Yii::t('usuario', 'Credentials will be sent to the user by email') ?>.
                    <?= Yii::t('usuario', 'A password will be generated automatically if not provided') ?>.
                </div>
                <?php $form = ActiveForm::begin(
                    [
                        'layout' => 'horizontal',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'wrapper' => 'col-sm-9',
                            ],
                        ],
                    ]
                ); ?>

                <?= $this->render('/admin/_user', ['form' => $form, 'user' => $user]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(
                            Yii::t('usuario', 'Save'),
                            ['class' => 'btn btn-block btn-success']
                        ) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent() ?>