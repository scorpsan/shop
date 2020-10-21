<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

Yii::$app->layout = 'error';
$this->title = Yii::t('error', 'error') . ' ' . $exception->statusCode . ' - ' . Yii::t('error', 'error' . $exception->statusCode . ' title');
?>
<section class="page-404">
    <div class="container-fluid my-container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('frontend', 'Home'), 'url' => Url::home()],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'tag' => 'div',
            'options' => ['class' => 'bread-crumb'],
            'itemTemplate' => '{link}',
            'activeItemTemplate' => '<strong class="active">{link}</strong>',
        ]); ?>
        <div class="error-page text-center">
            <h1><?= Html::encode($this->title) ?></h1>
            <h3 class="error-title"><?= nl2br(Html::encode($message)) ?></h3>
            <p><?= Yii::t('error', 'error text') ?></p>
            <p><?= Yii::t('error', 'error footer text') ?></p>
            <a href="<?= Url::home() ?>" class="btn-back"><?= Yii::t('error', 'Visit Home Page') ?></a>
        </div>
    </div>
</section>