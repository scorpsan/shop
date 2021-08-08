<?php
/**
 * @var $post \frontend\models\Posts
 * @var $categoryParent \frontend\models\Categories
 */

use frontend\widgets\FilterWidget;
use yii\bootstrap4\Html;
use yii\widgets\Breadcrumbs;

if (count($categoryParent)) {
    foreach ($categoryParent as $parent) {
        if ($parent->depth == 0)
            $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/posts/index']];
        if ($parent->depth == 1 || count($categoryParent) == 1)
            $this->params['breadcrumbs'][] = $parent->title;
    }
} else {
    $this->params['breadcrumbs'][] = $post->category->title;
}

$filter = FilterWidget::widget(['menu' => 'posts', 'categoryalias' => $post->category->alias]);
?>
<section class="product-blog-v2">
    <div class="my-container column-right blog-post">
        <?php if (!empty($filter)) { ?>
        <div class="js-filter-popup filter-mobile fliter-product">
            <?= $filter ?>
        </div>
        <span class="button-filter js-filter d-lg-none"><?= Yii::t('frontend', 'Categories') ?> / <?= Yii::t('frontend', 'Filter') ?></span>
        <span class="change-button-filter fas fa-times js-close-filter d-none"></span>
        <div class="js-bg-filter bg-filter-overlay"></div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 fliter-product slidebar-col-3">
                <?= $filter ?>
            </div>
            <div class="col-xl-9 col-lg-9">
        <?php } else { ?>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
        <?php } ?>
                <div class="bread-crumb bread-crumb__blog-post">
                    <?php
                    if (count($categoryParent)) {
                        foreach ($categoryParent as $parent) {
                            if ($parent->depth == 0)
                                $breadcrumbs[] = ['label' => $parent->title, 'url' => ['/posts/index']];
                            else
                                $breadcrumbs[] = ['label' => $parent->title, 'url' => ['/posts/category', 'categoryalias' => $parent->alias]];
                        }
                    }
                    if ($post->category->depth == 0)
                        $breadcrumbs[] = ['label' => $post->category->title, 'url' => ['/posts/index']];
                    else
                        $breadcrumbs[] = ['label' => $post->category->title, 'url' => ['/posts/category', 'categoryalias' => $post->category->alias]];
                    $breadcrumbs[] = $post->title;
                    ?>
                    <?= Breadcrumbs::widget([
                        'homeLink' => false,
                        'links' => isset($breadcrumbs) ? $breadcrumbs : [],
                        'tag' => 'div',
                        'options' => ['class' => 'tag'],
                        'itemTemplate' => '{link} / ',
                        'activeItemTemplate' => '<span>{link}</span>',
                    ]); ?>
                </div>
                <?= $this->render('../layouts/_alert') ?>
                <div class="post">
                    <div class="main-post">
                        <h3 class="heading-3 font-weight-bold"><?= $post->title ?></h3>
                        <div class="content">
                            <?php /** <div class="comment"> <i class="fas fa-comments"></i> 00 Comments </div> */ ?>
                            <div class="date">
                                <i class="fas fa-clock"></i>
                                <span><?= Yii::t('frontend', 'Date') ?>: <?= Yii::$app->formatter->asDate($post->created_at) ?></span>
                            </div>
                        </div>
                        <div class="extra-post">
                            <?= $post->content ?>
                        </div>
                    </div>
                    <?php
                    $tagLinks = array();
                    foreach ($post->tags as $tag) {
                        $tagLinks[] = Html::a($tag->name, ['/posts/index', 'tag' => $tag->name]);
                    } ?>
                    <div class="tag d-flex justify-content-between">
                        <?php if (count($tagLinks)) { ?>
                        <div class="d-flex">
                            <label class="mb-0 font-weight-bold"><?= Yii::t('frontend', 'Tags') ?>: </label>
                            <span class="list">
                                <?= implode(', ', $tagLinks) ?>
                            </span>
                        </div>
                        <?php } ?>
                        <div>
                            <label class="mb-0 font-weight-bold"><?= Yii::t('frontend', 'Share') ?>:</label>
                            <span>
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                <div class="addthis_inline_share_toolbox"></div>
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60e2e868e86ef616"></script>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        /**
        <div class="comments">
            <h3 class="heading-3 font-weight-bold">Comment <span>(03)</span></h3>
            <div>
                <div class="post">
                    <div class="author d-flex align-items-center pt-0">
                        <div class="img">
                            <img src="img/our-blog-v1-circle1.jpg" alt="_img author Ourblog v1" class="img-fluid" >
                        </div>
                        <a href="javascript:void(0)">Beauty Hah</a>
                    </div>
                    <div class="comment para-fs18">
                        Maecenas faucibus mollis interdum. Donec id elit non mi porta gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla.
                    </div>
                    <div class="times d-flex align-items-center">
                        <div class="date d-flex align-items-center">
                            <i class="ti-time"></i>
                            <span>Date: 2 month ago</span>
                        </div>
                        <div class="reply">
                            <span>Reply</span>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="author d-flex align-items-center pt-0">
                        <div class="img" >
                            <img src="img/our-blog-v1-circle2.jpg" alt="_img author Ourblog v1" class="img-fluid" >
                        </div>
                        <a href="javascript">Luxy Fan</a>
                    </div>
                    <div class="comment para-fs18">
                        Maecenas faucibus mollis interdum. Donec id elit non mi porta gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla.
                    </div>
                    <div class="times d-flex align-items-center">
                        <div class="date d-flex align-items-center">
                            <i class="ti-time"></i>
                            <span>Date: 2 month ago</span>
                        </div>
                        <div class="reply">
                            <span>Reply</span>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="author d-flex align-items-center pt-0">
                        <div class="img" >
                            <img src="img/our-blog-v1-circle3.jpg" alt="_img author Ourblog v1" class="img-fluid" >
                        </div>
                        <a href="javascript">John Jack </a>
                    </div>
                    <div class="comment para-fs18">
                        Maecenas faucibus mollis interdum. Donec id elit non mi porta gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla.
                    </div>
                    <div class="times d-flex align-items-center">
                        <div class="date d-flex align-items-center">
                            <i class="ti-time"></i>
                            <span>Date: 3 month ago</span>
                        </div>
                        <div class="reply">
                            <span>Reply</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="feedback">
            <h3 class="heading-3 font-weight-bold">Leave A Comment</h3>
            <form action="/action_page.php">
                <div class="row ">
                    <div class="col-lg-4 col-md-6 margin-bot-30">
                        <input type="text" class="form-control" placeholder="Name*" name="name">
                    </div>
                    <div class="col-lg-4 col-md-6 margin-bot-30">
                        <input type="email" class="form-control" placeholder="Email*" name="email">
                    </div>
                    <div class="col-lg-4 col-md-6 margin-bot-30">
                        <input type="text" class="form-control" placeholder="Website">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <textarea name="comment" id="text" cols="30" rows="10" class="w-100" placeholder="Your Comment*"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" name="submit" class="post-comment">Post Comment</button>
                </div>
            </form>
        </div>
         */
        ?>
    </div>
</section>