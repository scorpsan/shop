<?php
namespace frontend\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Menu extends \yii\widgets\Menu {

    public $linkTemplate = '<a href="{url}" title="{title}" {target_blank}>{label}</a>';

    protected function renderItem($item) {
        if (isset($item['url']) && !empty($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            if (isset($node['target_blank']) && !empty($node['target_blank'])) {
                $item['target_blank'] = 'target="_blank"';
            } else {
                $item['target_blank'] = '';
            }
            if (!isset($node['title']) || empty($node['title'])) {
                $item['title'] = $item['label'];
            }

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{title}' => $item['title'],
                '{target_blank}' => $item['target_blank'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

}