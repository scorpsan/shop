<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%swiper}}`.
 */
class m190622_063516_create_swiper_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%swiper}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'player' => $this->boolean()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%swiper}}');
    }
}
