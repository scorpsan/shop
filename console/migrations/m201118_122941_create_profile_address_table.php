<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile_address}}`.
 */
class m201118_122941_create_profile_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        /**
         * $id
         * $user_id - ID пользователя
         * $title - Название
         * $country - Страна
         * $region - Область
         * $district - Район
         * $city - Город
         * $address - Адрес (улица, дом, корпу, квартира...)
         * $postal - Почтовый индекс
         * $created_at - датавремя создания адреса
         * $updated_at - датавремя изменения адреса
         */
        $this->createTable('{{%profile_address}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'country' => $this->char(255),
            'region' => $this->char(255),
            'district' => $this->char(255),
            'city' => $this->char(255),
            'address' => $this->char(255),
            'postal' => $this->char(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('profile_address_user_id_fk', '{{%profile_address}}', 'user_id');

        $this->addForeignKey(
            'profile_address_user_id_fk',
            '{{%profile_address}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profile_address}}');
    }
}
