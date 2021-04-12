<?php

use yii\db\Migration;

class m201010_203739_create_shop_tags_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_tags}}', [
            'item_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('shop_tags_shop_products_id_fk', '{{%shop_tags}}', 'item_id');

        $this->addForeignKey(
            'shop_tags_shop_products_id_fk',
            '{{%shop_tags}}',
            'item_id',
            '{{%shop_products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('shop_tags_tags_id_fk', '{{%shop_tags}}', 'tag_id');

        $this->addForeignKey(
            'shop_tags_tags_id_fk',
            '{{%shop_tags}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_tags_shop_products_id_fk', '{{%shop_tags}}');

        $this->dropForeignKey('shop_tags_tags_id_fk', '{{%shop_tags}}');

        $this->dropIndex('shop_tags_shop_products_id_fk', '{{%shop_tags}}');

        $this->dropIndex('shop_tags_tags_id_fk', '{{%shop_tags}}');

        $this->dropTable('{{%shop_tags}}');
    }
}
