<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pages_lng}}`.
 */
class m190605_163930_create_pages_lng_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pages_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'seotitle' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'seo_text' => $this->text(),
        ]);

        $this->createIndex('pages_lng_pages_id_fk', '{{%pages_lng}}', 'item_id');

        $this->createIndex('pages_lng_language_url_fk', '{{%pages_lng}}', 'lng');

        $this->addForeignKey(
            'pages_lng_pages_id_fk',
            '{{%pages_lng}}',
            'item_id',
            '{{%pages}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'pages_lng_language_url_fk',
            '{{%pages_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('pages_lng_pages_id_fk', '{{%pages_lng}}');

        $this->dropForeignKey('pages_lng_language_url_fk', '{{%pages_lng}}');

        $this->dropIndex('pages_lng_pages_id_fk', '{{%pages_lng}}');

        $this->dropIndex('pages_lng_language_url_fk', '{{%pages_lng}}');

        $this->dropTable('{{%pages_lng}}');
    }
}
