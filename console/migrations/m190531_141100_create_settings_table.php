<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m190531_141100_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(21)->notNull()->defaultValue('+123456789'),
            'currency_code' => $this->string(3)->notNull()->defaultValue('USD'),
            'admin_email' => $this->string(255)->notNull()->defaultValue('admin@email.com'),
            'support_email' => $this->string(255)->notNull()->defaultValue('admin@email.com'),
            'sender_email' => $this->string(255)->notNull()->defaultValue('admin@email.com'),
            'contact_phone' => $this->string(255),
            'viber_phone' => $this->string(21),
            'whatsapp_phone' => $this->string(21),
            'telegram_nick' => $this->string(255),
            'skype_nick' => $this->string(255),
            'long_map' => $this->float(),
            'lat_map' => $this->float(),
            'instagram_token' => $this->string(255),
            'link_to_facebook' => $this->string(255),
            'link_to_youtube' => $this->string(255),
            'link_to_vk' => $this->string(255),
            'link_to_pinterest' => $this->string(255),
            'link_to_twitter' => $this->string(255),
            'link_to_instagram' => $this->string(255),
            'coming_soon' => $this->boolean()->notNull()->defaultValue(0),
            'search_on_site' => $this->boolean()->notNull()->defaultValue(0),
            'shop_on_site' => $this->boolean()->notNull()->defaultValue(0),
        ]);

        $this->insert('{{%settings}}', [
            'phone' => '+123456789',
            'currency_code' => 'USD',
            'admin_email' => 'admin@email.com',
            'support_email' => 'admin@email.com',
            'sender_email' => 'admin@email.com',
            'coming_soon' => 0,
            'search_on_site' => 0,
            'shop_on_site' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
