<?php

namespace snapget\news\models;

use kartik\tree\models\Tree;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "news_category".
 *
 * @property int $id
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $name
 * @property string $icon
 * @property int $icon_type
 * @property int $active
 * @property int $selected
 * @property int $disabled
 * @property int $readonly
 * @property int $visible
 * @property int $collapsed
 * @property int $movable_u
 * @property int $movable_d
 * @property int $movable_l
 * @property int $movable_r
 * @property int $removable
 * @property int $removable_all
 *
 * @property NewsCategoryNews[] $newsCategoryNews
 */
class NewsCategory extends Tree
{
    const STATUS_SELECTED_ACTIVE = 1;
    const STATUS_SELECTED_NOT_ACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'root' => Yii::t('app', 'Root'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'lvl' => Yii::t('app', 'Lvl'),
            'name' => Yii::t('app', 'Name'),
            'icon' => Yii::t('app', 'Icon'),
            'icon_type' => Yii::t('app', 'Icont Type'),
            'active' => Yii::t('app', 'Active'),
            'selected' => Yii::t('app', 'Selected'),
            'disabled' => Yii::t('app', 'Disabled'),
            'readonly' => Yii::t('app', 'Readonly'),
            'visible' => Yii::t('app', 'Visible'),
            'collapsed' => Yii::t('app', 'Collapsed'),
            'movable_u' => Yii::t('app', 'Movable U'),
            'movable_d' => Yii::t('app', 'Movable D'),
            'movable_l' => Yii::t('app', 'Movable L'),
            'movable_r' => Yii::t('app', 'Movable R'),
            'removable' => Yii::t('app', 'Removable'),
            'removable_all' => Yii::t('app', 'Removable All'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategoryNews()
    {
        return $this->hasMany(NewsCategoryNews::class, ['news_category_id' => 'id']);
    }

    /**
     * Gets query for tree view.
     *
     * @return ActiveQuery
     */
    public static function getTreeQuery()
    {
        $query = static::find()->addOrderBy('root, lft');

        return $query;
    }

    /**
     * Checks whether news categories exists with specified ids
     *
     * @param array $newsCategoryIds Specified news categories ids for check on existence.
     *
     * @return bool True if categories exist.
     */
    public static function exists(array $newsCategoryIds)
    {
        /* @var $query ActiveQuery */
        $query = static::find();

        $existedCategories = $query->select(['id'])->where(['id' => $newsCategoryIds])->asArray()->all();

        $exists = count($existedCategories) == count($newsCategoryIds);

        return $exists;
    }
}
