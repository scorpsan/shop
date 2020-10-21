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
        $this->createTable('{{%swiper}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'player' => $this->boolean()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%swiper}}');
    }
}
