<?php

use yii\db\Migration;

/**
 * Class m220123_114651_add_shop_new_function
 */
class m220123_114651_add_shop_new_function extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shop_products}}', 'weight', $this->integer(11)->defaultValue(0)->after('rating'));
        $this->addColumn('{{%settings}}', 'custom_style', $this->text()->after('link_to_instagram'));
        $this->addColumn('{{%settings_lng}}', 'logo_b', $this->string(255));
        $this->addColumn('{{%settings_lng}}', 'logo_w', $this->string(255));
        $this->addColumn('{{%settings_lng}}', 'logo_footer', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shop_products}}', 'weight');
        $this->dropColumn('{{%settings}}', 'custom_style');
        $this->dropColumn('{{%settings_lng}}', 'logo_b');
        $this->dropColumn('{{%settings_lng}}', 'logo_w');
        $this->dropColumn('{{%settings_lng}}', 'logo_footer');

        return true;
    }

}
