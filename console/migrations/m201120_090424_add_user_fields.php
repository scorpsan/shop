<?php

use yii\db\Migration;

/**
 * Class m201120_090424_add_user_fields
 */
class m201120_090424_add_user_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'phone', $this->string(21)->notNull()->after('email'));

        $this->createIndex('idx_user_phone', '{{%user}}', 'phone', false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}