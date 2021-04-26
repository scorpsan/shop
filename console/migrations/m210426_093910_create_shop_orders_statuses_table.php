<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_orders_statuses}}`.
 */
class m210426_093910_create_shop_orders_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_orders_statuses}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'type' => $this->integer(2)->notNull(),
            'status' => $this->integer(2)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_orders_statuses}}');
    }
}
