<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_lng}}`.
 */
class m210630_091345_create_posts_lng_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%posts_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'seotitle' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->string(255),
            'content' => $this->text(),
        ], $tableOptions);

        $this->createIndex('posts_lng_posts_id_fk', '{{%posts_lng}}', 'item_id');

        $this->createIndex('posts_lng_language_url_fk', '{{%posts_lng}}', 'lng');

        $this->addForeignKey(
            'posts_lng_posts_id_fk',
            '{{%posts_lng}}',
            'item_id',
            '{{%posts}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'posts_lng_language_url_fk',
            '{{%posts_lng}}',
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
        $this->dropForeignKey('posts_lng_posts_id_fk', '{{%posts_lng}}');

        $this->dropForeignKey('posts_lng_language_url_fk', '{{%posts_lng}}');

        $this->dropIndex('posts_lng_posts_id_fk', '{{%posts_lng}}');

        $this->dropIndex('posts_lng_language_url_fk', '{{%posts_lng}}');

        $this->dropTable('{{%posts_lng}}');
    }
}
