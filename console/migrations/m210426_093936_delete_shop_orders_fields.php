<?php

use yii\db\Migration;

/**
 * Class m210426_093936_delete_shop_orders_fields
 */
class m210426_093936_delete_shop_orders_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shop_orders}}', 'payment_status');

        $this->dropColumn('{{%shop_orders}}', 'delivery_status');

        $this->dropColumn('{{%shop_orders}}', 'statuses_json');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
