<?php

namespace snapget\news\widgets\tree;

use kartik\tree\TreeView;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class TreeViewWrap Wrap of `kartik\tree\TreeView` adds some styles
 * and javascript functionality (change url on node click, add class to selected node).
 */
class TreeViewWrapWidget extends Widget
{
    /**
     * @var array Config data for `kartik\tree\TreeView`
     */
    public $treeViewConfig;
    /**
     * @var array config data for js object `snapgetTreeViewWrap`
     */
    public $snapgetTreeViewWrapOptions = [];

    /**
     * @var array default values for js object `snapgetTreeViewWrap`,
     */
    protected $defaultSnapgetTreeViewWrapOptions = [
        'rootItemClass' => '.root-item',
        'treeContainerClass' => '.kv-tree-container',
        'beforeselectEvent' => 'treeview.beforeselect',
        'focussedClassName' => 'kv-focussed',
        'selectedClass' => '.kv-selected',
        'treeListClass' => '.kv-tree-list',
        'nodeDetailClass' => '.kv-node-detail',
    ];


    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->snapgetTreeViewWrapOptions['frontendCategories'] || !$this->snapgetTreeViewWrapOptions['baseUrl']) {
            throw new InvalidConfigException('Params "frontendCategories", "baseUrl" are required in "snapgetTreeViewWrapOptions"');
        }

        TreeViewWrapAsset::register($this->view);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo TreeView::widget($this->treeViewConfig);

        $options = ArrayHelper::merge($this->defaultSnapgetTreeViewWrapOptions, $this->snapgetTreeViewWrapOptions);
        $encodedOptions = Json::encode($options);
        $this->view->registerJs("new snapgetTreeViewWrap($encodedOptions)");
    }
}