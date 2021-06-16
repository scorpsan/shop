<?php

use yii\db\Migration;

/**
 * Class m210615_163201_add_shop_orders_fields
 */
class m210615_163201_add_shop_orders_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_orders}}', 'admin_note', $this->text()->after('note'));

        $this->addColumn('{{%shop_orders}}', 'amount_change', $this->float()->after('amount'));

        $this->addColumn('{{%shop_orders}}', 'discount', $this->float()->after('amount_change'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
