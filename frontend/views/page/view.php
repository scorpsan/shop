<?php
/**
 * @var $model \frontend\models\Pages
 */
$this->title = $model->title;
if (Yii::$app->layout != 'main') {
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<?php if (!empty($model->content)) { ?>
    <?php foreach ($model->content as $key => $section) { ?>
        <?php if ($section->widget) { ?>
            <?php
            $widgetName = "\\frontend\\widgets\\$section->widget_type";
            $widgetParams = [
                'params' => [
                    'title' => $section->title,
                    'show_title' => $section->show_title,
                    'style' => $section->style,
                    'background' => $section->background,
                    'parallax' => $section->parallax,
                    'text_align' => $section->text_align,
                ],
                'options' => unserialize($section->content),
            ];
            echo $widgetName::widget($widgetParams);
            ?>
        <?php } else { ?>
            <section id="<?= $model->alias ?>-<?= $section->id ?>" class="section section-<?= $model->alias ?>-<?= $section->id ?> <?= $section->style ?> <?= ($section->background)?'bg-image bg-overlay" style="background-image: url('.$section->background.');':''?>">
                <div class="my-container <?= $section->text_align ?>">
                    <?php if ($section->show_title) { ?>
                        <?php if ($key == 0) { ?>
                            <h3 class="h3 heading-3 font-weight-bold text-center text-capitalize"><?= $section->title ?></h3>
                        <?php } else { ?>
                            <h3 class="heading-3 font-weight-bold text-center text-capitalize"><?= $section->title ?></h3>
                        <?php } ?>
                    <?php } ?>
                    <?= $section->content ?>
                </div>
            </section>
        <?php } ?>
    <?php } ?>
<?php } ?>