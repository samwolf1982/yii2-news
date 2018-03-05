<?php

namespace snapget\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * NewsSearch represents the model behind the search form of `snapget\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'active'], 'integer'],
            [['title', 'short_description', 'description', 'image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|int|null $categoryId Id of category.
     *
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function search($params, $categoryId = null)
    {
        $query = News::find()->orderBy(['created_at' => SORT_DESC])->joinWith(['newsCategories']);

        // add conditions that should always apply here
        NewsCategory::updateAll(['selected' => NewsCategory::STATUS_SELECTED_NOT_ACTIVE]);

        if ($categoryId) {
            $newsCategory = NewsCategory::findOne($categoryId);
            $newsCategory->updateAttributes(['selected' => NewsCategory::STATUS_SELECTED_ACTIVE]);
            if (!$newsCategory) {
                throw new NotFoundHttpException(Yii::t('app', 'Category Not Found'));
            }
            $children = $newsCategory->children();
            $childrenIds = ArrayHelper::getColumn($children->asArray()->all(), 'id');

            $query->joinWith(['newsCategoryNews'])
                ->andWhere([NewsCategoryNews::tableName() . '.[[news_category_id]]' => $childrenIds]);
        }

        $query->andWhere([News::tableName() . '.active' => News::STATUS_ACTIVE])
            ->groupBy(News::tableName() . '.id');

        $this->filterQuery($query);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            News::tableName() . '.active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }

    /**
     * Addes additional filters to `$query`, uses in children classes.
     *
     * @param ActiveQuery $query
     */
    protected function filterQuery($query)
    {
    }
}
