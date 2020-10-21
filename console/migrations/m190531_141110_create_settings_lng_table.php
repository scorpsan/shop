<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings_lng}}`.
 */
class m190531_141110_create_settings_lng_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'seotitle' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'address' => $this->string(255),
            'about_footer' => $this->text(),
            'opening_hours' => $this->string(255),
            'opening_hours_full' => $this->string(255),
            'contact_info' => $this->text(),
            'address_map' => $this->string(255),
        ]);

        $this->createIndex('settings_lng_settings_id_fk', '{{%settings_lng}}', 'item_id');

        $this->createIndex('settings_lng_language_url_fk', '{{%settings_lng}}', 'lng');

        $this->addForeignKey(
            'settings_lng_settings_id_fk',
            '{{%settings_lng}}',
            'item_id',
            '{{%settings}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'settings_lng_language_url_fk',
            '{{%settings_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );

        $this->insert('{{%settings_lng}}', [
            'item_id' => 1,
            'lng' => 'ru',
            'title' => 'Site Name',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('settings_lng_settings_id_fk', '{{%settings_lng}}');

        $this->dropForeignKey('settings_lng_language_url_fk', '{{%settings_lng}}');

        $this->dropIndex('settings_lng_settings_id_fk', '{{%settings_lng}}');

        $this->dropIndex('settings_lng_language_url_fk', '{{%settings_lng}}');

        $this->dropTable('{{%settings_lng}}');
    }
}
