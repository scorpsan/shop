<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_payment_delivery}}`.
 */
class m210329_170556_create_shop_payment_delivery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_payment_delivery}}', [
            'delivery_id' => $this->integer()->notNull(),
            'payment_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('shop_payment_delivery_pk', '{{%shop_payment_delivery}}', ['delivery_id', 'payment_id']);

        $this->createIndex('shop_payment_delivery_shop_delivery_method_fk', '{{%shop_payment_delivery}}', 'delivery_id');
        $this->createIndex('shop_payment_delivery_shop_payment_method_fk', '{{%shop_payment_delivery}}', 'payment_id');

        $this->addForeignKey('shop_payment_delivery_shop_delivery_method_fk', '{{%shop_payment_delivery}}', 'delivery_id', '{{%shop_delivery_method}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('shop_payment_delivery_shop_payment_method_fk', '{{%shop_payment_delivery}}', 'payment_id', '{{%shop_payment_method}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('shop_payment_delivery_shop_delivery_method_fk', '{{%shop_payment_delivery}}');

        $this->dropForeignKey('shop_payment_delivery_shop_payment_method_fk', '{{%shop_payment_delivery}}');

        $this->dropIndex('shop_payment_delivery_shop_delivery_method_fk', '{{%shop_payment_delivery}}');

        $this->dropIndex('shop_payment_delivery_shop_payment_method_fk', '{{%shop_payment_delivery}}');

        $this->dropTable('{{%shop_payment_delivery}}');
    }
}
