<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
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
