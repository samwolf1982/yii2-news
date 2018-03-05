<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model snapget\news\models\News */
/* @var $initialPreview bool */
/* @var $treeQuery \yii\db\ActiveQuery */

$this->title = Yii::t('app', 'Create News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'initialPreview' => $initialPreview,
        'treeQuery' => $treeQuery,
    ]) ?>

</div>
