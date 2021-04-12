<?php

use yii\db\Migration;

class m201010_181140_create_shop_products_lng_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_products_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'short_content' => $this->text(),
            'content' => $this->text(),
            'seotitle' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'seo_text' => $this->text(),
        ], $tableOptions);

        $this->createIndex('shop_products_lng_shop_products_id_fk', '{{%shop_products_lng}}', 'item_id');

        $this->createIndex('shop_products_lng_language_url_fk', '{{%shop_products_lng}}', 'lng');

        $this->addForeignKey(
            'shop_products_lng_shop_products_id_fk',
            '{{%shop_products_lng}}',
            'item_id',
            '{{%shop_products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'shop_products_lng_language_url_fk',
            '{{%shop_products_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_products_lng_shop_products_id_fk', '{{%shop_products_lng}}');

        $this->dropForeignKey('shop_products_lng_language_url_fk', '{{%shop_products_lng}}');

        $this->dropIndex('shop_products_lng_shop_products_id_fk', '{{%shop_products_lng}}');

        $this->dropIndex('shop_products_lng_language_url_fk', '{{%shop_products_lng}}');

        $this->dropTable('{{%shop_products_lng}}');
    }
}
