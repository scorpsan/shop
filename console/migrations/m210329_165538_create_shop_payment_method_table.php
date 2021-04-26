<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_payment_method}}`.
 */
class m210329_165538_create_shop_payment_method_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_payment_method}}', [
            'id' => $this->primaryKey(),
            'className' => $this->string()->notNull(),
            'sort' => $this->integer(9)->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_payment_method}}');
    }
}
