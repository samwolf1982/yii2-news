<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $treeViewConfig array */

$this->title = Yii::t('app', 'News Categories');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \snapget\news\widgets\Alert::widget() ?>

<div class="news-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \kartik\tree\TreeView::widget($treeViewConfig); ?>
</div>
