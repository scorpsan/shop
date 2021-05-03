<?php

use yii\db\Migration;

/**
 * Class m210428_141445_add_shop_products_fields
 */
class m210428_141445_add_shop_products_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_products}}', 'in_stock', $this->boolean()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
