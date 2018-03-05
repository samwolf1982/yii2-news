<?php

namespace snapget\news\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * NewsCategorySearch represents the model behind the search form of `snapget\news\models\NewsCategory`.
 */
class NewsCategorySearch extends NewsCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'root', 'lft', 'rgt', 'lvl'], 'integer'],
            [['name', 'icon', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /* @var $query ActiveQuery */
        $query = NewsCategory::find();
        $query->addOrderBy(['root', 'lft']);

        // add conditions that should always apply here

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
            'root' => $this->root,
            'lft' => $this->lft,
            'rgt' => $this->rgt,
            'lvl' => $this->lvl,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'icon_type', $this->icon_type])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'selected', $this->selected])
            ->andFilterWhere(['like', 'disabled', $this->disabled])
            ->andFilterWhere(['like', 'readonly', $this->readonly])
            ->andFilterWhere(['like', 'visible', $this->visible])
            ->andFilterWhere(['like', 'collapsed', $this->collapsed])
            ->andFilterWhere(['like', 'movable_u', $this->movable_u])
            ->andFilterWhere(['like', 'movable_d', $this->movable_d])
            ->andFilterWhere(['like', 'movable_l', $this->movable_l])
            ->andFilterWhere(['like', 'movable_r', $this->movable_r])
            ->andFilterWhere(['like', 'removable', $this->removable])
            ->andFilterWhere(['like', 'removable_all', $this->removable_all]);

        return $dataProvider;
    }
}
