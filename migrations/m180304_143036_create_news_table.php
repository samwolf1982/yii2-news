<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180304_143036_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'short_description' => $this->string(1000)->notNull(),
            'description' => $this->text()->notNull(),
            'image' => $this->string()->notNull(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-news-title', 'news', 'title');
        $this->createIndex('idx-news-short_description', 'news', 'short_description');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropIndex('idx-news-short_description', 'news');
        $this->dropIndex('idx-news-title', 'news');

        $this->dropTable('news');
    }
}
