<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model snapget\news\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var $initialPreview bool */
/* @var $treeQuery \yii\db\ActiveQuery */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textarea(['rows' => 8]) ?>

    <?= $form->field($model, 'description')->widget(\vova07\imperavi\Widget::class, [
        'settings' => [
            'minHeight' => 200,
            'imageUpload' => Url::to(['image-upload']),
            // TODO fix delete image file problem
            'imageDelete' => Url::to(['file-delete']),
            'imageManagerJson' => Url::to(['images-get']),
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
        'plugins' => [
            'imagemanager' => \vova07\imperavi\bundles\ImageManagerAsset::class,
        ],
    ]); ?>

    <?= $form->field($model, 'image')->widget(\kartik\file\FileInput::class, [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview' => $initialPreview,
            'initialPreviewAsData' => true,
            'initialPreviewShowDelete' => false,
            'showRemove' => false,
            'showUpload' => false,
        ],
    ]) ?>

    <?php echo $form->field($model, 'category_ids')->widget(\kartik\tree\TreeViewInput::class, [
        'query' => $treeQuery,
        'headingOptions' => ['label' => Yii::t('app', 'Select ...')],
        'rootOptions' => ['label'=>'<i class="fa fa-tree text-success"></i>'],
        'fontAwesome' => false,
        'asDropdown' => true,
        'multiple' => true,
        'options' => ['disabled' => false],
    ]); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
