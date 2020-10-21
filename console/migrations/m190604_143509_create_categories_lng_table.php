<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories_lng}}`.
 */
class m190604_143509_create_categories_lng_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'seotitle' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'content' => $this->text(),
            'img' => $this->string(255),
        ]);

        $this->createIndex('categories_lng_categories_id_fk', '{{%categories_lng}}', 'item_id');

        $this->createIndex('categories_lng_language_url_fk', '{{%categories_lng}}', 'lng');

        $this->addForeignKey(
            'categories_lng_categories_id_fk',
            '{{%categories_lng}}',
            'item_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'categories_lng_language_url_fk',
            '{{%categories_lng}}',
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
        $this->dropForeignKey('categories_lng_categories_id_fk', '{{%categories_lng}}');

        $this->dropForeignKey('categories_lng_language_url_fk', '{{%categories_lng}}');

        $this->dropIndex('categories_lng_categories_id_fk', '{{%categories_lng}}');

        $this->dropIndex('categories_lng_language_url_fk', '{{%categories_lng}}');

        $this->dropTable('{{%categories_lng}}');
    }
}
