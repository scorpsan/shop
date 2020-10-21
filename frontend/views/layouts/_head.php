<?php
use yii\helpers\Html;
?>
<link rel="dns-prefetch" href="//www.googletagmanager.com/">
<link rel="dns-prefetch" href="//www.google-analytics.com/">
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= Html::encode($this->title) ?></title>
<!-- Google Tag Manager --
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MZJGZZN');</script>
!-- End Google Tag Manager -->
<link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
<meta name="theme-color" content="#7fc9c4">
<?= Html::csrfMetaTags() ?>
<?php
$this->head();
/*
$gt = <<< GT
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZJGZZN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
GT;

Yii::$app->view->on(\yii\web\View::EVENT_BEGIN_BODY, function () use ($gt) {
    echo $gt;
});*/
/*
 *
 	<link rel="stylesheet" href="fonts/linearicons/linearicons.css">
 	<link rel="stylesheet" href="fonts/themify-icons/themify-icons.css">

 	<link rel="stylesheet" href="vendors/transition-wow/transition.css">
 	<link rel="stylesheet" href="vendors/slick/slick-theme.css">
 	<link rel="stylesheet" href="vendors/slick/slick.css">

 	<link rel="stylesheet" href="css/bootstrap.min.css">
 	<link rel="stylesheet" href="css/style.css">

*/
/*
<link rel="shortcut icon" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/favicon.png?v=17697506255299455493" type="image/png" />

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
<meta property="og:title" content="Lamode - Clothing &amp; Fashion Responsive Shopify Theme">
<meta property="og:image" content="http://cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/logo.png?3308">
<meta property="og:image:secure_url" content="https://cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/logo.png?3308">
<meta property="og:url" content="https://lamode-store-demo.myshopify.com/">
<meta property="og:site_name" content="Lamode - Clothing &amp; Fashion Responsive Shopify Theme">

<meta name="twitter:card" content="summary">

<link rel="icon" href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/favicon.png?v=17697506255299455493" type="image/png" sizes="16x16">
<!-- CSS ================================================== -->

<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/timber.scss.css?v=8758432440463319374" rel="stylesheet" type="text/css" media="all" />



<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/bootstrap.min.css?v=15178164969440951488" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/linearicons.css?v=14425432822374449497" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/themify-icons.css?v=1782837867860931872" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/linea-ecommerce10.css?v=4693725325639099996" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/font-awesome.min.css?v=2186963269736709578" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/slick.css?v=9834047404617688405" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/slick-theme.css?v=10106483877146501201" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/jquery.fancybox.min.css?v=1927803431663513770" rel="stylesheet" type="text/css" media="all" />


<link href="//cdn.shopify.com/s/files/1/0260/6681/3005/t/3/assets/engo-customize.scss.css?v=7186027304043762935" rel="stylesheet" type="text/css" media="all" />
*/
