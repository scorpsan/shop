<?php

use yii\db\Migration;

/**
 * Class m210426_123116_add_shop_orders_fields
 */
class m210426_123116_add_shop_orders_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_orders}}', 'currency', $this->char(3)->after('amount'));

        $this->addColumn('{{%shop_orders}}', 'token', $this->string(64)->after('order_number'));

        $this->addColumn('{{%shop_orders}}', 'tracker', $this->string(255)->after('delivery_address'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
