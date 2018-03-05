<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model snapget\news\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <div class="news-item row">
        <div class="col-md-12">
            <h1><?= Html::encode($model->title) ?></h1>

            <h5><?= Yii::$app->formatter->asDatetime($model->created_at) ?></h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="img-item-view center-block">
                        <img src="<?= $model->getImageUrl() ?>" alt="<?= $model->title ?>"
                             class="pull-left img-responsive thumb margin10 img-thumbnail">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="description">
                        <article><?= $model->description ?></article>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
