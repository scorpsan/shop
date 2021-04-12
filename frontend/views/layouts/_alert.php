<?php
use yii\bootstrap4\Alert;

$Flashes = Yii::$app->session->getAllFlashes();

if (count($Flashes)) { ?>
    <!-- Alerts-->
    <div class="container my-4">
        <div class="row">
            <?php foreach ($Flashes as $type => $message): ?>
                <?php if ($type != 'contactFormSubmitted') { ?>
                    <div class="col-12 <?= $type ?>">
                    <?= Alert::widget([
                        'options' => ['class' => 'alert-dismissible alert-' . $type],
                        'body' => $message,
                    ]) ?>
                    </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>