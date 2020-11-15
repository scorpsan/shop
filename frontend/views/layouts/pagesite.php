<?php
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
use yii\helpers\Url;
use frontend\assets\AppAsset;

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
    <section class="page-static">
        <div class="container-fluid my-container">
            <?= $this->render('_breadcrumbs') ?>

            <?= $this->render('_alert') ?>

            <?= $content ?>
        </div>
    </section>
    <?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
