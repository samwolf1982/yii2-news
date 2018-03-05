<?php

namespace snapget\news\controllers;

use snapget\news\models\News;
use snapget\news\models\NewsCategory;
use snapget\news\models\NewsSearch;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * Lists all News models.
     * @param null $id
     * @return mixed
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function actionIndex($id = null)
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        if (!isset($this->module->treeFrontendManagerConfig)) {
            throw new InvalidConfigException('Module has contain property "treeFrontendManagerConfig"');
        }

        $treeQuery = NewsCategory::getTreeQuery();
        $additionalConfig = [
            'query' => $treeQuery,
            'value' => $id ? $id : '',
        ];

        $treeViewConfig = ArrayHelper::merge($additionalConfig, $this->module->treeFrontendManagerConfig);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'treeViewConfig' => $treeViewConfig,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
