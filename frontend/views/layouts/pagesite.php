<?php
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('',true)]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->render('_head') ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <?= $this->render('_header') ?>
    <!-- Page-->
    <main>
        <section class="page-static">
            <div class="container-fluid my-container">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'tag' => 'p',
                    'options' => ['class' => 'bread-crumb'],
                    'itemTemplate' => '{link}<i> / </i>',
                    'activeItemTemplate' => '{link}',
                ]); ?>
            </div>

            <?= $content ?>
        </section>
    </main>
    <?= $this->render('_footer') ?>

    <?= $this->render('_18plus') ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
