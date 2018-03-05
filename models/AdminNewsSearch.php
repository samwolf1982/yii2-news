<?php

namespace snapget\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * NewsSearch represents the model behind the search form of `snapget\news\models\News`.
 */
class AdminNewsSearch extends NewsSearch
{
    protected function filterQuery($query)
    {
        $query->orWhere([News::tableName() . '.active' => News::STATUS_NOT_ACTIVE]);
    }
}
