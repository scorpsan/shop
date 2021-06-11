<?php
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
use frontend\assets\AppAsset;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('',true)]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= $this->render('_head') ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <?= $this->render('_header') ?>
    <!-- Page-->
    <main>
        <section class="section-slide img-fluid" style="background-image:url(<?= $this->context->backBreadcrumbs ?>);background-position:top center;">
            <div class="breadcrumb-title text-center">
                <div class="section-title">
                    <h2><?= Html::encode($this->title) ?></h2>
                </div>
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'tag' => 'p',
                    'options' => ['class' => 'bread-crumb'],
                    'itemTemplate' => '{link}<i> / </i>',
                    'activeItemTemplate' => '{link}',
                ]); ?>
            </div>
        </section>

        <?= $content ?>
    </main>
    <?= $this->render('_footer') ?>

    <?= $this->render('_18plus') ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
