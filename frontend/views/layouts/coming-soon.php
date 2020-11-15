<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('',true)]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('_head') ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!-- Page-->
        <div class="page">
            <?= $content ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>