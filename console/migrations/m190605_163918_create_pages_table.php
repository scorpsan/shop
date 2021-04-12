<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pages}}`.
 */
class m190605_163918_create_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11)->notNull()->defaultValue(0),
            'alias' => $this->string(255)->unique()->notNull(),
            'published' => $this->boolean()->notNull()->defaultValue(1),
            'main' => $this->boolean()->notNull()->defaultValue(0),
            'noindex' => $this->boolean()->notNull()->defaultValue(0),
            'page_style' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex('pages_categories_id_fk', '{{%pages}}', 'category_id');

        $this->addForeignKey(
            'pages_categories_id_fk',
            '{{%pages}}',
            'category_id',
            '{{%categories}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('pages_categories_id_fk', '{{%pages}}');

        $this->dropIndex('pages_categories_id_fk', '{{%pages}}');

        $this->dropTable('{{%pages}}');
    }
}
