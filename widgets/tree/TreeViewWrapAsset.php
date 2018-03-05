<?php

namespace snapget\news\widgets\tree;

use yii\web\AssetBundle;

/**
 * Class TreeViewWrapAsset
 */
class TreeViewWrapAsset extends AssetBundle
{
    /**
     * @internal
     */
    public $css = [
        'css/tree-view-wrap.css',
    ];

    /**
     * @internal
     */
    public $js = [
        'js/tree-view-wrap.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
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