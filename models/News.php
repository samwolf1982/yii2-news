<?php

namespace snapget\news\models;

use mongosoft\file\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $short_description
 * @property string $description
 * @property string $image
 * @property int $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property NewsCategoryNews[] $newsCategoryNews
 * @property NewsCategory[] $newsCategories
 */
class News extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    /**
     * @var string
     */
    protected $baseImagePath;
    /**
     * @var string
     */
    protected $baseImageUrl;
    /**
     * @var string
     */
    protected $baseDescriptionImagePath;
    /**
     * @var string
     */
    protected $baseDescriptionImageUrl;

    /**
     * @var array
     */
    private $_category_ids = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->baseImagePath = isset(Yii::$app->controller->module->baseImagePath)
            ? Yii::$app->controller->module->baseImagePath
            : Yii::getAlias('@webroot/upload/news');

        $this->baseImageUrl = isset(Yii::$app->controller->module->baseImageUrl)
            ? Yii::$app->controller->module->baseImageUrl
            : Yii::getAlias('@web/upload/news');

        $this->baseDescriptionImagePath = isset(Yii::$app->controller->module->baseDescriptionImagePath)
            ? Yii::$app->controller->module->baseDescriptionImagePath
            : $this->baseImagePath . '/description';

        $this->baseDescriptionImageUrl = isset(Yii::$app->controller->module->baseDescriptionImageUrl)
            ? Yii::$app->controller->module->baseDescriptionImageUrl
            : $this->baseImageUrl . '/description';

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_description', 'description'], 'required'],
            [['image'], 'required', 'on' => self::SCENARIO_CREATE],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 1000],
            [['active', 'created_at', 'updated_at'], 'integer'],
            [['category_ids', 'image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'short_description' => Yii::t('app', 'Short Description'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'active' => Yii::t('app', 'Active'),
            'category_ids' => Yii::t('app', 'Categories'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE],
                'path' => $this->baseImagePath,
                'url' => $this->baseImageUrl,
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios[self::SCENARIO_UPDATE] = $scenarios[self::SCENARIO_DEFAULT];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        // check categories exist
        if ($this->_category_ids && is_array($this->_category_ids)) {
            $categoryExistence = NewsCategory::exists($this->_category_ids);
            if (!$categoryExistence) {
                $this->addError('category_ids', Yii::t('app', 'Some categories do not exist'));

                return false;
            }
        }

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategoryNews()
    {
        return $this->hasMany(NewsCategoryNews::class, ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategories()
    {
        return $this->hasMany(NewsCategory::class, ['id' => 'news_category_id'])
            ->via('newsCategoryNews');
    }

    /**
     * Gets image url.
     *
     * @return string Image url.
     */
    public function getImageUrl()
    {
        $imageUrl = Url::to($this->baseImageUrl . '/' . $this->image);

        return $imageUrl;
    }

    /**
     * Loads categories.
     */
    public function loadCategories()
    {
        $this->_category_ids = [];

        if (!empty($this->id)) {

            $rows = NewsCategoryNews::find()
                ->select(['news_category_id', 'news_id'])
                ->where(['news_id' => $this->id])
                ->asArray()
                ->all();

            foreach($rows as $row) {
                $this->_category_ids[] = $row['news_category_id'];
            }
        }
    }

    /**
     * Saves categories.
     *
     * @throws \yii\db\Exception
     */
    public function saveCategories()
    {
        NewsCategoryNews::deleteAll(['news_id' => $this->id]);

        if (is_array($this->_category_ids)) {

            $batch = [];
            foreach($this->_category_ids as $category_id) {
                $batch[] = [$category_id, $this->id];
            }

            Yii::$app->db->createCommand()->batchInsert(
                NewsCategoryNews::tableName(),
                ['news_category_id', 'news_id'], $batch)->execute();
        }
    }

    /**
     * @return string
     */
    public function getCategory_ids()
    {
        $categoryIds = is_array($this->_category_ids) ? implode(',', $this->_category_ids) : $this->_category_ids;

        return $categoryIds;
    }

    /**
     * @param array $category_ids
     */
    public function setCategory_ids($category_ids)
    {
        $this->_category_ids = is_string($category_ids) ? explode(',', $category_ids) : $category_ids;
    }

    /**
     * @return string
     */
    public function getBaseDescriptionImagePath()
    {
        return $this->baseDescriptionImagePath;
    }

    /**
     * @return string
     */
    public function getBaseDescriptionImageUrl()
    {
        return $this->baseDescriptionImageUrl;
    }
}
