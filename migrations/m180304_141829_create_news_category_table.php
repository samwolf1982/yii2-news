<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news_category`.
 * Has foreign keys to the tables:
 *
 * - `news_category`
 */
class m180304_141829_create_news_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('news_category', [
            'id' => $this->primaryKey(),
            'root' => $this->integer(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'lvl' => $this->smallInteger(5)->notNull(),
            'name' => $this->string(60)->notNull(),
            'icon' => $this->string(),
            'icon_type' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'selected' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'disabled' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'readonly' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'visible' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'collapsed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'movable_u' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'movable_d' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'movable_l' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'movable_r' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'removable' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'removable_all' => $this->tinyInteger(1)->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-news_category-root', 'news_category', 'root');
        $this->createIndex('idx-news_category-lft', 'news_category', 'lft');
        $this->createIndex('idx-news_category-rgt', 'news_category', 'rgt');
        $this->createIndex('idx-news_category-lvl', 'news_category', 'lvl');
        $this->createIndex('idx-news_category-active', 'news_category', 'active');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropIndex('idx-news_category-root', 'news_category');
        $this->dropIndex('idx-news_category-lft', 'news_category');
        $this->dropIndex('idx-news_category-rgt', 'news_category');
        $this->dropIndex('idx-news_category-lvl', 'news_category');
        $this->dropIndex('idx-news_category-active', 'news_category');

        $this->dropTable('news_category');
    }
}
