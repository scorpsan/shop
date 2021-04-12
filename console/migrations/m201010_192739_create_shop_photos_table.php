<?php

use yii\db\Migration;

class m201010_192739_create_shop_photos_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11)->notNull(),
            'url' => $this->string(255)->notNull(),
            'sort' => $this->integer(3),
        ], $tableOptions);

        $this->createIndex('shop_photos_shop_products_id_fk', '{{%shop_photos}}', 'product_id');

        $this->addForeignKey(
            'shop_photos_shop_products_id_fk',
            '{{%shop_photos}}',
            'product_id',
            '{{%shop_products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_photos_shop_products_id_fk', '{{%shop_photos}}');

        $this->dropIndex('shop_photos_shop_products_id_fk', '{{%shop_photos}}');

        $this->dropTable('{{%shop_photos}}');
    }
}
