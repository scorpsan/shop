<?php
/**
 * @var $this       \yii\web\View
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

if (Yii::$app->layout == 'pagesite') { ?>
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'tag' => 'div',
        'options' => ['class' => 'bread-crumb'],
        'itemTemplate' => '{link} <i>/</i>',
        'activeItemTemplate' => '<strong class="active">{link}</strong>',
    ]); ?>
<?php } else { ?>
    <section class="section-slide img-fluid" style="background-image : url(<?= $this->context->backBreadcrumbs ?>)">
        <div class="title text-center">
            <h3 class="heading-3 font-weight-bold"><?= Html::encode($this->title) ?></h3>
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'tag' => 'p',
                'options' => ['class' => 'para-fs30 mb-0'],
                'itemTemplate' => '{link} / ',
                'activeItemTemplate' => '{link}',
            ]); ?>
        </div>
    </section>
<?php } ?>