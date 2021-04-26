<?php

use yii\db\Migration;

/**
 * Class m210415_110415_add_profile_fields
 */
class m210415_110415_add_profile_address_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile_address}}', 'address2', $this->char(255)->after('address'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}