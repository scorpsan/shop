<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_brands_lng`.
 */
class m201009_083940_create_shop_brands_lng_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_brands_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),
            'seotitle' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'seo_text' => $this->text(),
            'country' => $this->string(255),
        ], $tableOptions);

        $this->createIndex('shop_brands_lng_shop_brands_id_fk', '{{%shop_brands_lng}}', 'item_id');

        $this->createIndex('shop_brands_lng_language_url_fk', '{{%shop_brands_lng}}', 'lng');

        $this->addForeignKey(
            'shop_brands_lng_shop_brands_id_fk',
            '{{%shop_brands_lng}}',
            'item_id',
            '{{%shop_brands}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'shop_brands_lng_language_url_fk',
            '{{%shop_brands_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_brands_lng_shop_brands_id_fk', '{{%shop_brands_lng}}');

        $this->dropForeignKey('shop_brands_lng_language_url_fk', '{{%shop_brands_lng}}');

        $this->dropIndex('shop_brands_lng_shop_brands_id_fk', '{{%shop_brands_lng}}');

        $this->dropIndex('shop_brands_lng_language_url_fk', '{{%shop_brands_lng}}');

        $this->dropTable('{{%shop_brands_lng}}');
    }
}
