<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_orders_items}}`.
 */
class m210412_104832_create_shop_orders_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_orders_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(11)->notNull(),
            'product_id' => $this->integer(11),
            'product_name' => $this->string()->notNull(),
            'product_code' => $this->string()->notNull(),
            'price' => $this->float()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('shop_orders_items_shop_orders_fk', '{{%shop_orders_items}}', 'order_id');
        $this->addForeignKey(
            'shop_orders_items_shop_orders_fk',
            '{{%shop_orders_items}}',
            'order_id',
            '{{%shop_orders}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('shop_orders_items_shop_products_fk', '{{%shop_orders_items}}', 'product_id');
        $this->addForeignKey(
            'shop_orders_items_shop_products_fk',
            '{{%shop_orders_items}}',
            'product_id',
            '{{%shop_products}}',
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
        $this->dropTable('{{%shop_orders_items}}');
    }
}
