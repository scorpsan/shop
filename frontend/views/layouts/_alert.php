<?php
use frontend\widgets\Alert;

$Flashes = Yii::$app->session->getAllFlashes();

if (count($Flashes)) { ?>
    <!-- Alerts-->
    <div class="container">
        <?php
        foreach ($Flashes as $key => $message) {
            if ($key != 'contactFormSubmitted') {
                echo Alert::widget(['options' => ['class' => '']]);
            }
        }
        ?>
    </div>
<?php } ?>