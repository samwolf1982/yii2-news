<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel snapget\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $treeViewConfig \yii\db\ActiveQuery */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <?= \yii\bootstrap\Collapse::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Search ...'),
                        'content' => $this->render('_search', ['model' => $searchModel,]),
                    ]
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= \snapget\news\widgets\tree\TreeViewWrapWidget::widget([
                'treeViewConfig' => $treeViewConfig,
                'snapgetTreeViewWrapOptions' => [
                    'frontendCategories' => $treeViewConfig['options']['id'],
                    'baseUrl' => \yii\helpers\Url::to(['index']),
                ],
            ]) ?>
        </div>
        <div class="col-md-8">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
            ]) ?>
        </div>
    </div>

</div>