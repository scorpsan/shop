<?php

use yii\db\Migration;

/**
 * Class m210428_130359_delete_shop_delivery_method_fields
 */
class m210428_130359_delete_shop_delivery_method_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shop_delivery_method}}', 'default');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
