<?php
namespace frontend\widgets;

use yii\widgets\Menu as BaseMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Exception;

/**
 * Class Menu
 * @package frontend\widgets
 */
class Menu extends BaseMenu
{
    public $linkTemplate = '<a href="{url}" title="{title}" class="{class}" {target_blank}>{label}</a>';
    public $labelTemplate = '{label}';
    public $menuItemCssClass = '';
    public $subMenuItemCssClass = '';
    public $shevronSubmenu = '';

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    protected function renderItem($item) {
        if (isset($item['url']) && !empty($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            if (isset($item['target_blank']) && !empty($item['target_blank'])) {
                $item['target_blank'] = 'target="_blank"';
            } else {
                $item['target_blank'] = '';
            }
            if (!isset($item['title']) || empty($item['title'])) {
                $item['title'] = $item['label'];
            }
            $class = $this->menuItemCssClass;
            if (!empty($item['items'])) {
                $item['label'] = $item['label'] . $this->shevronSubmenu;
                $class .= $this->subMenuItemCssClass;
            }
            if (isset($item['count'])) {
                $item['count'] = '('.$item['count'].')';
            } else {
                $item['count'] = '';
            }

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{title}' => $item['title'],
                '{target_blank}' => $item['target_blank'],
                '{class}' => $class,
                '{count}' => $item['count'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

}