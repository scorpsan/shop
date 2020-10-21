<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menus_lng}}`.
 */
class m190612_162215_create_menus_lng_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menus_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
        ]);

        $this->createIndex('menus_lng_menus_id_fk', '{{%menus_lng}}', 'item_id');

        $this->createIndex('menus_lng_language_url_fk', '{{%menus_lng}}', 'lng');

        $this->addForeignKey(
            'menus_lng_menus_id_fk',
            '{{%menus_lng}}',
            'item_id',
            '{{%menus}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'menus_lng_language_url_fk',
            '{{%menus_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('menus_lng_menus_id_fk', '{{%menus_lng}}');

        $this->dropForeignKey('menus_lng_language_url_fk', '{{%menus_lng}}');

        $this->dropIndex('menus_lng_menus_id_fk', '{{%menus_lng}}');

        $this->dropIndex('menus_lng_language_url_fk', '{{%menus_lng}}');

        $this->dropTable('{{%menus_lng}}');
    }
}
