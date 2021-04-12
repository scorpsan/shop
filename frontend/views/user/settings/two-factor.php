<?php
/**
 * @var string $id
 * @var string $uri
 */
?>
<div class="container my-4">
    <div class="row">
        <div class="col-12 info">
            <div class="alert-info alert" role="alert">
                <?= Yii::t('usuario', 'Scan the QrCode with Google Authenticator App, then insert its temporary code on the box and submit.') ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-offset-3 col-md-6 text-center">
        <img id="qrCode" src="<?= $uri ?>"/>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-3 col-md-6 text-center">
        <div class="input-group">
            <input type="text" class="form-control" id="tfcode" placeholder="<?= Yii::t('usuario', 'Two factor authentication code') ?>"/>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-submit-code">
                    <?= Yii::t('usuario', 'Enable') ?>
                </button>
            </span>
        </div>
    </div>
</div>