<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menus}}`.
 */
class m190612_162203_create_menus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%menus}}', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer(11),
            'lft' => $this->integer(11)->notNull(),
            'rgt' => $this->integer(11)->notNull(),
            'depth' => $this->integer(11)->notNull(),
            'url' => $this->string(255),
            'params' => $this->string(255),
            'access' => $this->string(25),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'target_blank' => $this->boolean()->notNull()->defaultValue(0),
            'anchor' => $this->string(25),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menus}}');
    }
}
