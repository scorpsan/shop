<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_characteristics`.
 */
class m201010_085957_create_shop_characteristics_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_characteristics}}', [
            'id' => $this->primaryKey(),
            'alias' => $this->string(255)->unique()->notNull(),
            'type' => $this->string(16)->notNull(),
            'required' => $this->boolean()->notNull()->defaultValue(0),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'sort' => $this->integer(3)->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%shop_characteristics}}');
    }
}
