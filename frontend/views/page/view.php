<?php
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
            <section id="<?= $model->alias ?>-<?= $section->id ?>" class="section-60 <?= $section->style ?> <?= ($section->background)?'bg-image bg-overlay" style="background-image: url('.$section->background.');':''?>">
                <div class="shell <?= $section->text_align ?>">
                    <?php if ($section->show_title) { ?>
                        <?php if ($key == 0) { ?>
                            <h1 class="text-center h3"><?= $section->title ?></h1>
                        <?php } else { ?>
                            <h3 class="text-center"><?= $section->title ?></h3>
                        <?php } ?>
                    <?php } ?>
                    <div class="range <?= $section->text_align ?> <?= ($section->show_title)?'offset-top-30':'' ?>">
                        <?= $section->content ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>
<?php } ?>