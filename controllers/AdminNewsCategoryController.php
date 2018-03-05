<?php

namespace snapget\news\controllers;

use snapget\news\models\NewsCategory;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * AdminNewsCategoryController implements the CRUD actions for NewsCategory model.
 */
class AdminNewsCategoryController extends Controller
{
    /**
     * Lists all NewsCategory models.
     * @return mixed
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        if (!isset($this->module->treeManagerConfig)) {
            throw new InvalidConfigException('Module has contain property "treeManagerConfig"');
        }

        $treeQuery = NewsCategory::getTreeQuery();
        $queryConfig = ['query' => $treeQuery];

        $treeViewConfig = ArrayHelper::merge($queryConfig, $this->module->treeManagerConfig);

        return $this->render('index', [
            'treeViewConfig' => $treeViewConfig,
        ]);
    }
}
