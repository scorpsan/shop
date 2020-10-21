<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%swiper_slides}}`.
 */
class m190622_063535_create_swiper_slides_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%swiper_slides}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'content' => $this->text(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'sort' => $this->integer(3),
            'style' => $this->string(25)->notNull()->defaultValue('bg-default'),
            'text_align' => $this->string(25),
            'lng' => $this->string(5),
            'start_at' => $this->integer(11),
            'end_at' => $this->integer(11),
        ]);

        $this->createIndex('swiper_slides_swiper_id_fk', '{{%swiper_slides}}', 'item_id');

        $this->createIndex('swiper_slides_language_url_fk', '{{%swiper_slides}}', 'lng');

        $this->addForeignKey(
            'swiper_slides_swiper_id_fk',
            '{{%swiper_slides}}',
            'item_id',
            '{{%swiper}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'swiper_slides_language_url_fk',
            '{{%swiper_slides}}',
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
        $this->dropForeignKey('swiper_slides_swiper_id_fk', '{{%swiper_slides}}');

        $this->dropForeignKey('swiper_slides_language_url_fk', '{{%swiper_slides}}');

        $this->dropIndex('swiper_slides_swiper_id_fk', '{{%swiper_slides}}');

        $this->dropIndex('swiper_slides_language_url_fk', '{{%swiper_slides}}');

        $this->dropTable('{{%swiper_slides}}');
    }
}
