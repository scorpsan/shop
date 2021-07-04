<?php
use yii\helpers\Html;
use yii\helpers\Url;

if (Yii::$app->user->can('manager')) { ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div id="control-sidebar-options-tab" class="tab-pane active">
                <div>
                    <h3 class="control-sidebar-heading">Reset Cache</h3>

                    <div class="form-group">
                        <?= Html::a(Yii::t('backend', 'Reset Cache'), ['site/reset-cache'], ['class' => 'btn btn-warning', 'data-metod' => 'POST']) ?>
                    </div>
                </div>
            </div>
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading"><?= Yii::t('backend', 'Site Options') ?></h3>

                    <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-setting="coming_soon" class="pull-right" <?= (Yii::$app->params['comingSoon'])?'checked':'' ?>> Coming Soon</label><p>This Site is Coming Soon</p></div>
                    <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-setting="search_on_site" class="pull-right" <?= (Yii::$app->params['searchOnSite'])?'checked':'' ?>> Search On Site</label><p>Enable Search on this Site</p></div>
                    <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-setting="shop_on_site" class="pull-right" <?= (Yii::$app->params['shopOnSite'])?'checked':'' ?>> Shop On Site</label><p>Enable Shop on this Site</p></div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class='control-sidebar-bg'></div>
<?php } ?>
<?php
$url1 = Url::to(['site-settings/change-setting']);
$script = <<< JS
    $('aside.control-sidebar input').on('ifChanged', function() {
        $.ajax({
            type: "POST",
            url: "${url1}",
            data: {setting: $(this).data('setting'), val: $(this).prop('checked')},
            cache: false
        })
        .done(function(result) {
            if (!result) {
                alert( "Request failed");
            }
        });
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>