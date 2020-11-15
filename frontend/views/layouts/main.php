<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;

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
        <?= $this->render('_alert') ?>

        <?= $content ?>
    </main>
    <?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
