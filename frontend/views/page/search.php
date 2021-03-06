<?php
/**
 * @var $search string|null
 */
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Search results');
$this->params['breadcrumbs'][] = $this->title;
$search_text = Html::encode($search);
?>
<section class="section-85">
    <div class="shell">
        <h2><?= Yii::t('frontend', 'Search results') ?></h2>
        <h4><?= Yii::t('frontend', 'Your search:') ?> "<span class="search"><?= $search_text ?></span>"</h4>
        <div class="rd-search-results offset-top-40">
            <div id="search-results">
            <?php if (!empty($results)) { ?>
                <ol class="search_list">
                <?php foreach ($results as $result) {
                    $result->content = strip_tags($result->content);
                    $pos_int = stripos($result->content, $search_text);
                    ?>
                    <li class="search-list-item">
                        <h5 class="search_title">
                            <?= Html::a($result->title, ['/page/view', 'alias' => $result->alias], ['class' => 'search_link', 'target' => '_top']) ?>
                        </h5>
                        <p><?php
                            if ($pos_int <= 20) {
                                echo str_replace($search_text, "<span class='search'>{$search_text}</span>", mb_substr($result->content, 0, 140)) . '...';
                            } else {
                                echo  '...' . str_replace($search_text, "<span class='search'>{$search_text}</span>", mb_substr($result->content, $pos_int, 140)) . '...';
                            }
                            ?></p>
                        <p class="match"><em><?= Yii::t('frontend', 'Terms matched: ') . substr_count($result->content, $search_text) ?></em></p>
                    </li>
                <?php } ?>
                </ol>
            <?php } else { ?>
                <ol class="search_list">
                    <li>
                        <div class="search_error"><?= Yii::t('frontend', 'No results found...') ?></div>
                    </li>
                </ol>
            <?php } ?>
            </div>
        </div>
    </div>
</section>