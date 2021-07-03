<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m210630_091335_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11)->notNull()->defaultValue(0),
            'alias' => $this->string(255)->unique()->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'noindex' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('posts_categories_id_fk', '{{%posts}}', 'category_id');

        $this->addForeignKey(
            'posts_categories_id_fk',
            '{{%posts}}',
            'category_id',
            '{{%categories}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('posts_categories_id_fk', '{{%posts}}');

        $this->dropIndex('posts_categories_id_fk', '{{%posts}}');

        $this->dropTable('{{%posts}}');
    }
}
