<?php
/**
 * @var $this       \yii\web\View
 * @var $content    string
 */
use frontend\assets\CheckoutAsset;
use yii\bootstrap4\Html;
use yii\helpers\Url;

CheckoutAsset::register($this);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('',true)]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="js mac opera desktop page--no-banner page--logo-main page--show page--show card-fields cors svg opacity placeholder no-touchevents displaytable display-table generatedcontent cssanimations flexbox no-flexboxtweener anyflexbox shopemoji floating-labels">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height, minimum-scale=1.0, user-scalable=0">
    <?= $this->render('_head') ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <header class="banner" role="banner">
        <div class="wrap">
            <?= Html::a('<span class="logo__text heading-1">' . Yii::$app->name . '</span>', ['/page/index'], ['title' => Yii::$app->name, 'class' => 'logo logo--left']) ?>
        </div>
    </header>

    <?= $content ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>