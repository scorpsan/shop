<?php

use yii\db\Migration;

/**
 * Class m210616_091949_add_shop_delivery_method_fields
 */
class m210616_091949_add_shop_delivery_method_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_delivery_method}}', 'pickup', $this->boolean()->notNull()->defaultValue(0)->after('max_summa'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_delivery_method}}', 'pickup');

        return true;
    }

}
