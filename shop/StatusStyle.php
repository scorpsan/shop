<?php
namespace shop;

use common\models\ShopOrdersStatuses;
use yii\bootstrap4\Html;
use Yii;

class StatusStyle
{
	/**
	 * @param $status
	 * @return string
	 */
    public static function HtmlStatus($status): string
    {
		switch ($status) {
            case ShopOrdersStatuses::PAYMENTS_WAIT:
                return Html::tag('span', Yii::t('frontend', 'Wait'), ['class' => 'badge badge-primary font-size-12']);
            case ShopOrdersStatuses::PAYMENTS_PAID:
                return Html::tag('span', Yii::t('frontend', 'Paid'), ['class' => 'badge badge-success font-size-12']);
            case ShopOrdersStatuses::PAYMENTS_REFUND:
                return Html::tag('span', Yii::t('frontend', 'Refund'), ['class' => 'badge badge-warning font-size-12']);
            case ShopOrdersStatuses::PAYMENTS_CANCEL:
            case ShopOrdersStatuses::ORDER_CANCEL:
                return Html::tag('span', Yii::t('frontend', 'Cancel'), ['class' => 'badge badge-danger font-size-12']);

            case ShopOrdersStatuses::DELIVERY_APPROVE:
                return Html::tag('span', Yii::t('frontend', 'Approve'), ['class' => 'badge badge-primary font-size-12']);
            case ShopOrdersStatuses::DELIVERY_SEND:
                return Html::tag('span', Yii::t('frontend', 'Send'), ['class' => 'badge badge-info font-size-12']);
            case ShopOrdersStatuses::DELIVERY_DELIVER:
                return Html::tag('span', Yii::t('frontend', 'Deliver'), ['class' => 'badge badge-success font-size-12']);

            case ShopOrdersStatuses::ORDER_NEW:
			default:
				return Html::tag('span', Yii::t('frontend', 'New'), ['class' => 'badge badge-primary font-size-12']);
		}
	}

}