<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Url;
use yii\helpers\Html;

Yii::$app->layout = 'pagesite';
$this->title = Yii::t('error', 'error') . ' ' . $exception->statusCode . ' - ' . Yii::t('error', 'error' . $exception->statusCode . ' title');
?>
<div class="error-page text-center">
    <h1><?= Html::encode($this->title) ?></h1>
    <h3 class="error-title"><?= nl2br(Html::encode($message)) ?></h3>
    <p><?= Yii::t('error', 'error text') ?></p>
    <p><?= Yii::t('error', 'error footer text') ?></p>
    <a href="<?= Url::home() ?>" class="btn-back"><?= Yii::t('error', 'Visit Home Page') ?></a>
</div>