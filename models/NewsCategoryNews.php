<?php

namespace snapget\news\models;

use Yii;

/**
 * This is the model class for table "news_category_news".
 *
 * @property int $id
 * @property int $news_category_id
 * @property int $news_id
 *
 * @property NewsCategory $newsCategory
 * @property News $news
 */
class NewsCategoryNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_category_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_category_id', 'news_id'], 'required'],
            [['news_category_id', 'news_id'], 'integer'],
            [['news_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsCategory::class, 'targetAttribute' => ['news_category_id' => 'id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'news_category_id' => Yii::t('app', 'News Category ID'),
            'news_id' => Yii::t('app', 'News ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategory()
    {
        return $this->hasOne(NewsCategory::class, ['id' => 'news_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }
}
