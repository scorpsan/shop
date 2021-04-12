<?php

use yii\db\Migration;

class m201010_181139_create_shop_products_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'code' => $this->string()->unique()->notNull(),
            'alias' => $this->string(255)->unique()->notNull(),
            'sort' => $this->integer(9)->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'top' => $this->integer(1)->defaultValue(0)->notNull(),
            'new' => $this->integer(1)->defaultValue(0)->notNull(),
            'hit' => $this->integer()->defaultValue(0),
            'rating' => $this->decimal(3, 2),
            'price' => $this->float(),
            'sale' => $this->float(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('shop_products_categories_id_fk', '{{%shop_products}}', 'category_id');

        $this->addForeignKey(
            'shop_products_categories_id_fk',
            '{{%shop_products}}',
            'category_id',
            '{{%categories}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->createIndex('shop_products_shop_brands_id_fk', '{{%shop_products}}', 'brand_id');

        $this->addForeignKey(
            'shop_products_shop_brands_id_fk',
            '{{%shop_products}}',
            'brand_id',
            '{{%shop_brands}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_products_categories_id_fk', '{{%shop_products}}');

        $this->dropIndex('shop_products_categories_id_fk', '{{%shop_products}}');

        $this->dropForeignKey('shop_products_shop_brands_id_fk', '{{%shop_products}}');

        $this->dropIndex('shop_products_shop_brands_id_fk', '{{%shop_products}}');

        $this->dropTable('{{%shop_products}}');
    }
}
