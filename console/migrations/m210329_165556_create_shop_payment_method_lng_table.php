<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_payment_method_lng}}`.
 */
class m210329_165556_create_shop_payment_method_lng_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_payment_method_lng}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'lng' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'desc' => $this->text(),
        ], $tableOptions);

        $this->createIndex('shop_payment_method_lng_shop_payment_method_id_fk', '{{%shop_payment_method_lng}}', 'item_id');

        $this->createIndex('shop_payment_method_lng_language_url_fk', '{{%shop_payment_method_lng}}', 'lng');

        $this->addForeignKey(
            'shop_payment_method_lng_shop_payment_method_id_fk',
            '{{%shop_payment_method_lng}}',
            'item_id',
            '{{%shop_payment_method}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'shop_payment_method_lng_language_url_fk',
            '{{%shop_payment_method_lng}}',
            'lng',
            '{{%language}}',
            'url',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('shop_payment_method_lng_shop_payment_method_id_fk', '{{%shop_payment_method_lng}}');

        $this->dropForeignKey('shop_payment_method_lng_language_url_fk', '{{%shop_payment_method_lng}}');

        $this->dropIndex('shop_payment_method_lng_shop_payment_method_id_fk', '{{%shop_payment_method_lng}}');

        $this->dropIndex('shop_payment_method_lng_language_url_fk', '{{%shop_payment_method_lng}}');

        $this->dropTable('{{%shop_payment_method_lng}}');
    }
}
