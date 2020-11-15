<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_products_characteristics`.
 */
class m201010_185957_create_shop_products_characteristics_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%shop_products_characteristics}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'lng' => $this->string(5)->notNull(),
        ]);

        $this->createIndex('shop_products_characteristics_shop_products_id_fk', '{{%shop_products_characteristics}}', 'product_id');

        $this->createIndex('shop_products_characteristics_language_url_fk', '{{%shop_products_characteristics}}', 'lng');

        $this->addForeignKey(
            'shop_products_characteristics_shop_products_id_fk',
            '{{%shop_products_characteristics}}',
            'product_id',
            '{{%shop_products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'shop_products_characteristics_language_url_fk',
            '{{%shop_products_characteristics}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_products_characteristics_shop_products_id_fk', '{{%shop_products_characteristics}}');

        $this->dropForeignKey('shop_products_characteristics_language_url_fk', '{{%shop_products_characteristics}}');

        $this->dropIndex('shop_products_characteristics_shop_products_id_fk', '{{%shop_products_characteristics}}');

        $this->dropIndex('shop_products_characteristics_language_url_fk', '{{%shop_products_characteristics}}');

        $this->dropTable('{{%shop_products_characteristics}}');
    }
}
