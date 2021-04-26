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
    <link rel="dns-prefetch" href="//www.googletagmanager.com/">
    <link rel="dns-prefetch" href="//www.google-analytics.com/">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height, minimum-scale=1.0, user-scalable=0">
    <title><?= Html::encode($this->title) ?></title>
    <!-- Google Tag Manager --
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MZJGZZN');</script>
    !-- End Google Tag Manager -->
    <link rel="shortcut icon" type="image/png" href="/images/favicon.png" sizes="16x16">
    <meta name="theme-color" content="#7fc9c4">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head();
    /*
    $gt = <<< GT
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZJGZZN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    GT;

    Yii::$app->view->on(\yii\web\View::EVENT_BEGIN_BODY, function () use ($gt) {
    echo $gt;
    });*/
    ?>
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