<?php

use yii\db\Migration;

/**
 * Class m210422_092121_add_shop_orders_fields
 */
class m210422_092121_add_shop_orders_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_orders}}', 'customer_email', $this->char(255)->after('statuses_json'));

        $this->addColumn('{{%shop_orders}}', 'payment_token', $this->char(255)->after('order_number'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
