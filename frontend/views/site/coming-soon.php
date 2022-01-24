<?php
/**
 * @var $time
 */
Yii::$app->layout = 'coming-soon';
$this->title = Yii::t('frontend', 'This Site is Coming Soon');
?>
<section class="section-slide-v1 section-slide-v3 bg-smoke">
    <div class="js-section-slider-v3 section-slide-v3">
        <div class="slider-child">
            <div class="img-slider">
                <img src="/images/bg-image-coming-soon.jpg" alt="_img-slider" class="img-fluid w-100">
            </div>
            <div class="title my-container">
                <div class="caption">
                    <p class="sub-title m-0" style="color:#fff;"><?= Yii::t('frontend', 'This Site is Coming Soon') ?></p>
                    <h1 class="heading-1" style="color:#fff;"><?= Yii::$app->name ?></h1>
                    <div class="countdown countdown-default" style="color:#fff;" data-type="until" data-time="<?php Yii::$app->formatter->locale = 'en-US'; echo Yii::$app->formatter->asDatetime($time, "dd MMM yyyy HH:mm"); ?>" data-format="dhms"></div>
                    <?php /**
                    <h5><?= Yii::t('frontend', 'If you have questions') ?></h5>
                    <p><?= Yii::t('frontend', 'You can fill out the form below and we will contact you shortly.') ?></p>
                    <?= \frontend\widgets\CallFormWidget::widget() ?> */ ?>
                </div>
            </div>
        </div>
    </div>
</section>