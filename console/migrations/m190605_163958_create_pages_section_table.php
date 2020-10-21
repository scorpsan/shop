<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pages_section}}`.
 */
class m190605_163958_create_pages_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pages_section}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'subtitle' => $this->string(255),
            'precontent' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'id_section' => $this->string(255),
            'show_title' => $this->boolean()->notNull()->defaultValue(1),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'style' => $this->string(100)->notNull()->defaultValue('bg-default'),
            'text_align' => $this->string(25),
            'background' => $this->string(255),
            'parallax' => $this->boolean()->notNull()->defaultValue(0),
            'sort' => $this->integer(11)->notNull(),
            'widget' => $this->boolean()->notNull()->defaultValue(0),
            'widget_type' => $this->string(255),
            'content' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
        ]);

        $this->createIndex('pages_section_pages_lng_id_fk', '{{%pages_section}}', 'item_id');

        $this->addForeignKey(
            'pages_section_pages_lng_id_fk',
            '{{%pages_section}}',
            'item_id',
            '{{%pages_lng}}',
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
        $this->dropForeignKey('pages_section_pages_lng_id_fk', '{{%pages_section}}');

        $this->dropIndex('pages_section_pages_lng_id_fk', '{{%pages_section}}');

        $this->dropTable('{{%pages_section}}');
    }
}
