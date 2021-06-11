<?php
use yii\bootstrap4\Html;
?>
<link rel="dns-prefetch" href="//www.googletagmanager.com/">
<link rel="dns-prefetch" href="//www.google-analytics.com/">
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= Html::encode($this->title) ?></title>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-PN3H2TW');</script>
    <!-- End Google Tag Manager -->
<link rel="shortcut icon" type="image/png" href="/images/favicon.png" sizes="16x16">
<meta name="theme-color" content="#7fc9c4">
<?= Html::csrfMetaTags() ?>
<?php
$this->head();

$gt = <<< GT
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PN3H2TW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
GT;

Yii::$app->view->on(\yii\web\View::EVENT_BEGIN_BODY, function () use ($gt) {
    echo $gt;
});

/*
<link rel="apple-touch-icon-precomposed" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_57x57.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_60x60.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_72x72.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_76x76.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_114x114.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_120x120.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_144x144.png?v=12793611169492794772" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/icon-for-mobile_152x152.png?v=12793611169492794772" />

<meta property="og:type" content="website">
<meta property="og:title" content="BadKitty - Clothing &amp; Fashion Responsive Shopify Theme">
<meta property="og:image" content="http://cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/logo.png?3308">
<meta property="og:image:secure_url" content="https://cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/logo.png?3308">
<meta property="og:url" content="https://badkitty.by/">
<meta property="og:site_name" content="Lamode - Clothing &amp; Fashion Responsive Shopify Theme">

<meta name="twitter:card" content="summary">
*/
