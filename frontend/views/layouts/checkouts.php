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
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-PN3H2TW');</script>
    <!-- End Google Tag Manager -->
    <link type="image/png" rel="shortcut icon" sizes="16x16" href="/icon/favicon_16x16.png">
    <link type="image/png" rel="icon" sizes="32x32" href="/icon/favicon_32x32.png">
    <link type="image/png" rel="icon" sizes="96x96" href="/icon/favicon_96x96.png">
    <link type="image/png" rel="icon" sizes="120x120" href="/icon/favicon_120x120.png">
    <link type="image/png" rel="icon" sizes="192x192"  href="/icon/android-icon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/icon/apple-touch-icon-57x57.png">
    <meta name="theme-color" content="#7fc9c4">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PN3H2TW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

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