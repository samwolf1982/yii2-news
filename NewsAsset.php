<?php

namespace snapget\news;


use yii\web\AssetBundle;

/**
 * Class NewsAsset
 */
class NewsAsset extends AssetBundle
{
    /**
     * @internal
     */
    public $css = [
        'css/style.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\validators\ValidationAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';

        parent::init();
    }
}