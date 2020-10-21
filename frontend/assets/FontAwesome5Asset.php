<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class FontAwesome5Asset extends AssetBundle {
    public $sourcePath = '@bower/font-awesome';
    public $css = [
        'css/all.css',
    ];

    public function init() {
        parent::init();

        $this->publishOptions['beforeCopy'] = function ($from, $to) {
            return preg_match('%(/|\\\\)(webfonts|fonts|css)%', $from);
        };
    }
}