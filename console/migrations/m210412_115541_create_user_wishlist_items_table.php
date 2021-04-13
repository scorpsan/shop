<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_items}}`.
 */
class m210412_115541_create_user_wishlist_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user_wishlist_items}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('user_wishlist_items_user_id_fk', '{{%user_wishlist_items}}', 'user_id');
        $this->addForeignKey(
            'user_wishlist_items_user_id_fk',
            '{{%user_wishlist_items}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('user_wishlist_items_products_id_fk', '{{%user_wishlist_items}}', 'product_id');
        $this->addForeignKey(
            'user_wishlist_items_products_id_fk',
            '{{%user_wishlist_items}}',
            'product_id',
            '{{%shop_products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_items}}');
    }
}
