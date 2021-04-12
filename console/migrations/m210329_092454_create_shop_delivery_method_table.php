<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_delivery_method}}`.
 */
class m210329_092454_create_shop_delivery_method_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_delivery_method}}', [
            'id' => $this->primaryKey(),
            'cost' => $this->float()->defaultValue(0),
            'max_weight' => $this->integer(),
            'min_summa' => $this->integer(),
            'max_summa' => $this->integer(),
            'sort' => $this->integer(9)->notNull(),
            'default' => $this->boolean()->notNull()->defaultValue(0),
            'published' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_delivery_method}}');
    }
}
