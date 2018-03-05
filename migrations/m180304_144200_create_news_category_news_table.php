<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news_category_news`.
 * Has foreign keys to the tables:
 *
 * - `news_category`
 * - `news`
 */
class m180304_144200_create_news_category_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('news_category_news', [
            'id' => $this->primaryKey(),
            'news_category_id' => $this->integer()->notNull(),
            'news_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `news_category_id`
        $this->createIndex(
            'idx-news_category_news-news_category_id',
            'news_category_news',
            'news_category_id'
        );

        // add foreign key for table `news_category`
        $this->addForeignKey(
            'fk-news_category_news-news_category_id',
            'news_category_news',
            'news_category_id',
            'news_category',
            'id',
            'CASCADE'
        );

        // creates index for column `news_id`
        $this->createIndex(
            'idx-news_category_news-news_id',
            'news_category_news',
            'news_id'
        );

        // add foreign key for table `news`
        $this->addForeignKey(
            'fk-news_category_news-news_id',
            'news_category_news',
            'news_id',
            'news',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // drops foreign key for table `news_category`
        $this->dropForeignKey(
            'fk-news_category_news-news_category_id',
            'news_category_news'
        );

        // drops index for column `news_category_id`
        $this->dropIndex(
            'idx-news_category_news-news_category_id',
            'news_category_news'
        );

        // drops foreign key for table `news`
        $this->dropForeignKey(
            'fk-news_category_news-news_id',
            'news_category_news'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            'idx-news_category_news-news_id',
            'news_category_news'
        );

        $this->dropTable('news_category_news');
    }
}
