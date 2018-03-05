<?php

use yii\helpers\Html;

/* @var $model \snapget\news\models\News */
?>

<div class="news-item row blogShort">
    <div class="col-md-12">
        <h3><?= Html::encode($model->title) ?></h3>

        <div class="categories">
            <span><?= Yii::t('app', 'Categories: ') ?></span>
            <?php foreach ($model->newsCategories as $category): ?>
                <span class="category-list-name">
                    <?= Html::encode($category->name); ?>,
                </span>
            <?php endforeach; ?>
        </div>

        <h5><?= Yii::$app->formatter->asDatetime($model->created_at) ?></h5>

        <div class="img-item-container">
            <img src="<?= $model->getImageUrl() ?>" alt="<?= $model->title ?>"
                 class="pull-left img-responsive thumb img-thumbnail">
        </div>

        <article><?= $model->short_description ?></article>

        <a href="<?= \yii\helpers\Url::to(['view', 'id' => $model->id]) ?>"
           class="btn btn-info pull-right marginBottom10">
            <?= Yii::t('app', 'Read more') ?>
        </a>
    </div>
</div>
