<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_brands`.
 */
class m201009_083939_create_shop_brands_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_brands}}', [
            'id' => $this->primaryKey(),
            'alias' => $this->string(255)->unique()->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'logo' => $this->string(255),
            'breadbg' => $this->string(255),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%shop_brands}}');
    }
}
