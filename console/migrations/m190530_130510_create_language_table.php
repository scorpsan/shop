<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m190530_130510_create_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(5)->unique()->notNull(),
            'local' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'default' => $this->boolean()->notNull()->defaultValue(0),
            'published' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->insert('{{%language}}', [
            'url' => 'ru',
            'local' => 'ru-RU',
            'title' => 'Russian',
            'default' => 1,
            'published' => 1,
        ]);

        $this->insert('{{%language}}', [
            'url' => 'en',
            'local' => 'en-EN',
            'title' => 'English',
            'default' => 0,
            'published' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
