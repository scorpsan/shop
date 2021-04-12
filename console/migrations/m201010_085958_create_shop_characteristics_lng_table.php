<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_characteristics`.
 */
class m201010_085958_create_shop_characteristics_lng_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_characteristics_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'units' => $this->string(10),
            'default' => $this->string(),
        ], $tableOptions);

        $this->createIndex('shop_characteristics_lng_shop_characteristics_id_fk', '{{%shop_characteristics_lng}}', 'item_id');

        $this->createIndex('shop_characteristics_lng_language_url_fk', '{{%shop_characteristics_lng}}', 'lng');

        $this->addForeignKey(
            'shop_characteristics_lng_shop_characteristics_id_fk',
            '{{%shop_characteristics_lng}}',
            'item_id',
            '{{%shop_characteristics}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'shop_characteristics_lng_language_url_fk',
            '{{%shop_characteristics_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('shop_characteristics_lng_shop_characteristics_id_fk', '{{%shop_characteristics_lng}}');

        $this->dropForeignKey('shop_characteristics_lng_language_url_fk', '{{%shop_characteristics_lng}}');

        $this->dropIndex('shop_characteristics_lng_shop_characteristics_id_fk', '{{%shop_characteristics_lng}}');

        $this->dropIndex('shop_characteristics_lng_language_url_fk', '{{%shop_characteristics_lng}}');

        $this->dropTable('{{%shop_characteristics_lng}}');
    }
}
