<?php
/**
 * @var $post \frontend\models\Posts
 */

use yii\bootstrap4\Html;
use yii\helpers\StringHelper;
?>
<div class="post">
    <?= Html::a(Html::img($post->image, ['alt' => $post->title, 'class' => 'img-fluid w-100']) . '<span class="overlay"></span>', ['/posts/view', 'alias' => $post->alias], ['title' => $post->title]) ?>
    <div class="d-flex time p-0">
        <?php /** <div class="comment"> <i class="fas fa-comments"></i> 00 Comments </div> */ ?>
        <div class="date">
            <i class="fas fa-clock"></i>
            <span><?= Yii::t('frontend', 'Date') ?>: <?= Yii::$app->formatter->asDate($post->created_at) ?></span>
        </div>
    </div>
    <?= Html::a(Html::tag('h4', $post->title, ['class' => 'heading-4']), ['/posts/view', 'alias' => $post->alias], ['title' => $post->title]) ?>
    <p class="para-fs18 font-2 mb-0 col-xl-10 p-0">
        <?= StringHelper::truncate($post->content,150,'...') ?>
    </p>
</div>