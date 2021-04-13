<?php
use yii\helpers\Url;
use yii\web\View;
?>

<?php if (Yii::$app->user->isGuest && !Yii::$app->session['answer']) { ?>
    <!-- POPUP 18+ BOX -->
    <div id="modal-overlay" class="black" style="display:block;">
        <div class="modal-popup">
            <div class="modal-content" style="display:block;">
                <div class="row">
                    <div class="col-md-4 d-mobile-none">
                        <img src="/files/18only.jpg" alt="_img modal poppup" class="w-100">
                    </div>
                    <div class="col-md-8 col-mobile-12">
                        <div class="content py-4">
                            <?= Yii::t('frontend', '18plus') ?>
                            <?php if (Yii::$app->session['answer'] === false) { ?>
                                <?= Yii::t('frontend', 'answerNo') ?>
                            <?php } else { ?>
                                <p class="d-flex lr">
                                    <button type="button" name="submit" data-answer="yes" class="btn-shop-now btn-yes"><?= Yii::t('frontend', 'I am over 18') ?></button>
                                    <button type="button" name="cancel" data-answer="no" class="btn-shop-now btn-no"><?= Yii::t('frontend', 'I\'m under 18') ?></button>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$url = Url::to(['/site/rules-check']);
$script = <<<JS
$(document).on('click', '.btn-yes, .btn-no', function (event){
    event.preventDefault();
    var data = {};
    data.answer = $(this).data('answer');
    $.ajax({
        url: '{$url}',
        data: data,
        type: 'POST'
    });
});
JS;
//Регистрируем скрипты
$this->registerJs($script, View::POS_READY);
?>
<?php } ?>