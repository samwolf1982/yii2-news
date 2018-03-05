<?php

namespace snapget\news\controllers;

use snapget\news\models\News;
use snapget\news\models\NewsCategory;
use snapget\news\models\AdminNewsSearch;
use vova07\imperavi\actions\GetImagesAction;
use vova07\imperavi\actions\UploadFileAction;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AdminNewsController implements the CRUD actions for News model.
 */
class AdminNewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $news = new News();

        return [
            'images-get' => [
                'class' => GetImagesAction::class,
                'url' => $news->getBaseDescriptionImageUrl(),
                'path' => $news->getBaseDescriptionImagePath(),
            ],
            'image-upload' => [
                'class' => UploadFileAction::class,
                'url' => $news->getBaseDescriptionImageUrl(),
                'path' => $news->getBaseDescriptionImagePath(),
            ],
            'file-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => $news->getBaseDescriptionImageUrl(),
                'path' => $news->getBaseDescriptionImagePath(),
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $searchModel = new AdminNewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new News();
        $model->scenario = News::SCENARIO_CREATE;
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->saveCategories();

            return $this->redirect(['update', 'id' => $model->id]);
        }

        $treeQuery = NewsCategory::getTreeQuery();

        return $this->render('create', [
            'model' => $model,
            'initialPreview' => false,
            'treeQuery' => $treeQuery,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = News::SCENARIO_UPDATE;
        $model->loadCategories();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->saveCategories();

            return $this->redirect(['update', 'id' => $model->id]);
        }

        $initialPreview = $model->image ? $model->getImageUrl() : false;
        $treeQuery = NewsCategory::getTreeQuery();

        return $this->render('update', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'treeQuery' => $treeQuery,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id)
    {
        $deleted = $this->findModel($id)->deleteImage();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $message = $deleted
            ? Yii::t('app', 'File deleted successfully')
            : Yii::t('app', 'File not deleted');

        return [
            'message' => $message,
        ];
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
