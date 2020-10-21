<?php
use yii\helpers\Html;
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
?>
<header class="main-header">
    <?= Html::a('<span class="logo-mini">' . Yii::$app->params['shortname'] . '</span><span class="logo-lg">' . Yii::$app->params['name'] . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= Yii::$app->user->identity->profile->getAvatarUrl() ?>" class="user-image" alt="<?= Yii::$app->user->identity->profile->name ?>"/>
                            <span class="hidden-xs"><?= Yii::$app->user->identity->profile->name ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= Yii::$app->user->identity->profile->getAvatarUrl() ?>" class="img-circle" alt="<?= Yii::$app->user->identity->profile->name ?>"/>
                                <p>
                                    <?= Yii::$app->user->identity->profile->name ?>
                                    <small>Member since <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->created_at, 'medium') ?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= Html::a(Yii::t('backend', 'Profile'),
                                        ['/user/profile/show'],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                                <div class="pull-right">
                                    <?= Html::a(Yii::t('backend', 'Log Out'),
                                        ['/user/security/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (Yii::$app->user->can('manager')) { ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>
