<?php
use yii\helpers\Html;

if (!empty(Yii::$app->urlManager->languages) && count(Yii::$app->urlManager->languages) > 1) { ?>
    <?= Html::cssFile('@frontend/css/lang.min.css', ['async' => 'async']); ?>
    <ul>
    <?php
    foreach (Yii::$app->urlManager->languages as $lang) {
        if ($lang === Yii::$app->language ||
            substr($lang, -2) === '-*' && substr(Yii::$app->language, 0, 2) === substr($lang, 0, 2)) {
            continue;
        }
        echo '<li>' . Html::a('<span class="lang-sm" lang="' . $lang . '"></span>', ['/', 'language' => $lang], ['class' => 'align-items-center']) . '</li>';
    } ?>
    </ul>
<?php } ?>