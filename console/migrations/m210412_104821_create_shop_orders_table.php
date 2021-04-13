<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_orders}}`.
 */
class m210412_104821_create_shop_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_orders}}', [
            'id' => $this->primaryKey(),

            'order_number' => $this->string(100)->notNull(),
            'user_id' => $this->integer(11),
            'delivery_method_id' => $this->integer(11),
            'delivery_method_name' => $this->string()->notNull(),
            'delivery_cost' => $this->float(),
            'payment_method_id' => $this->integer(11),
            'payment_method_name' => $this->string()->notNull(),
            'amount' => $this->float(),
            'note' => $this->text(),
            'payment_status' => $this->integer()->notNull(),
            'delivery_status' => $this->integer()->notNull(),
            'cancel_reason' => $this->text(),
            'statuses_json' => 'JSON NOT NULL',
            'customer_phone' => $this->string(),
            'customer_name' => $this->string(),
            'delivery_postal' => $this->char(10),
            'delivery_address' => $this->text(),

            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('shop_orders_user_id_fk', '{{%shop_orders}}', 'user_id');
        $this->addForeignKey(
            'shop_orders_user_id_fk',
            '{{%shop_orders}}',
            'user_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->createIndex('shop_orders_shop_delivery_method_fk', '{{%shop_orders}}', 'delivery_method_id');
        $this->addForeignKey(
            'shop_orders_shop_delivery_method_fk',
            '{{%shop_orders}}',
            'delivery_method_id',
            '{{%shop_delivery_method}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->createIndex('shop_orders_shop_payment_method_fk', '{{%shop_orders}}', 'payment_method_id');
        $this->addForeignKey(
            'shop_orders_shop_payment_method_fk',
            '{{%shop_orders}}',
            'payment_method_id',
            '{{%shop_payment_method}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_orders}}');
    }
}
