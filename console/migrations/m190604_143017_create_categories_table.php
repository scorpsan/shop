<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m190604_143017_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'alias' => $this->string(255)->unique()->notNull(),
            'tree' => $this->integer(11),
            'lft' => $this->integer(11)->notNull(),
            'rgt' => $this->integer(11)->notNull(),
            'depth' => $this->integer(11)->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'noindex' => $this->boolean()->notNull()->defaultValue(0),
            'page_style' => $this->tinyInteger(1)->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
