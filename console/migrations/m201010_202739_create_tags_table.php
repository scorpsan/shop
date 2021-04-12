<?php

use yii\db\Migration;

class m201010_202739_create_tags_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'frequency' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%tags}}');
    }
}
