<?php
namespace frontend\bootstrap;

use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface {

	public function bootstrap($app) {
        if ($app->params['comingSoon']) {
            $app->catchAll = ['/site/coming-soon'];
        }
    }

}