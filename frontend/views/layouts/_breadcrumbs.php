<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
?>
<section class="slide-about-us" style="background-image : url(/files/testimonial.jpg)">
    <div class="title text-center">
        <h3 class="heading-3 text-white font-weight-bold"><?= Html::encode($this->context->view->title) ?></h3>
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'tag' => 'p',
            'options' => ['class' => 'para-fs30 text-white mb-0'],
            'itemTemplate' => '{link}',
            'activeItemTemplate' => '{link}',
        ]); ?>
        <p class="para-fs30 text-white mb-0">
            <a href="javascript:void(0)" class=" text-white para-fs30">Menu</a> / About Us
        </p>
    </div>
</section>

<div class="wrap-bread-crumb breadcrumb_collection2">
    <div class="bg-breadcrumb" style="background-image : url(//cdn.shopify.com/s/files/1/0318/1759/7065/files/testimonial.jpg?v=1580806584 )">
        <div class="container container-v2">
            <div class="title-page">
                <h2><?= Html::encode($this->context->view->title) ?></h2>
            </div>
            <div class="bread-crumb">
                <a href="/" title="Back to the frontpage">Home<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                <strong>About us</strong>
            </div>
        </div>
    </div>
</div>
<section class="section-toolbar">
    <div class="product-toolbar">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => ['class' => 'my-container'],
            'itemTemplate' => '{link}',
            'activeItemTemplate' => '<span>{link}</span>',
        ]); ?>
    </div>
</section>
<section class="breadcrumbs-custom">
    <div class="container">
        <div class="breadcrumbs-custom__inner">
            <p class="breadcrumbs-custom__title"></p>
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumbs-custom__path'],
                'itemTemplate' => '<li>{link}</li>',
                'activeItemTemplate' => '<li class="active">{link}</li>',
            ]); ?>
        </div>
    </div>
</section>