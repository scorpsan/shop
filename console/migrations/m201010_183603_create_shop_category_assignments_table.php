<?php

use yii\db\Migration;

class m201010_183603_create_shop_category_assignments_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%shop_category_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);
        
        $this->createIndex('shop_category_assignments_shop_products_id_fk', '{{%shop_category_assignments}}', 'product_id');
        $this->createIndex('shop_category_assignments_categories_id_fk', '{{%shop_category_assignments}}', 'category_id');

        $this->addForeignKey(
            'shop_category_assignments_shop_products_id_fk',
            '{{%shop_category_assignments}}',
            'product_id',
            '{{%shop_products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'shop_category_assignments_categories_id_fk',
            '{{%shop_category_assignments}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_category_assignments_shop_products_id_fk', '{{%shop_category_assignments}}');

        $this->dropForeignKey('shop_category_assignments_categories_id_fk', '{{%shop_category_assignments}}');

        $this->dropIndex('shop_category_assignments_shop_products_id_fk', '{{%shop_category_assignments}}');

        $this->dropIndex('shop_category_assignments_categories_id_fk', '{{%shop_category_assignments}}');

        $this->dropTable('{{%shop_category_assignments}}');
    }
}
