<?php

use yii\db\Migration;

/**
 * Class m220326_065151_add_shop_delivery_method_fields
 */
class m220326_065151_add_shop_delivery_method_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_delivery_method}}', 'min_weight', $this->integer(11)->after('cost'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_delivery_method}}', 'min_weight');

        return true;
    }

}
