<?php
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
use frontend\assets\AppAsset;
use yii\helpers\Url;

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

    <main>
        <?= $content ?>
    </main>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>