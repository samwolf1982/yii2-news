<?php

namespace snapget\news;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * news module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'snapget\news\controllers';
    /**
     * @var string id of treemanager module.
     */
    public $treemanagerModuleId = 'treemanager';
    /**
     * @var array config to `\kartik\tree\TreeView`.
     */
    public $treeManagerConfig = [];
    /**
     * @var array config to `\kartik\tree\TreeView` on frontend.
     */
    public $treeFrontendManagerConfig = [];
    /**
     * @var string
     */
    public $baseImagePath = '@webroot/upload/news';
    /**
     * @var string
     */
    public $baseImageUrl = '@web/upload/news';
    /**
     * @var string
     */
    public $baseDescriptionImagePath = '@webroot/upload/news/description';
    /**
     * @var string
     */
    public $baseDescriptionImageUrl = '@web/upload/news/description';

    /**
     * @var array default values to config `\kartik\tree\TreeView`.
     */
    protected $defaultTreeManagerConfig = [
        'headingOptions' => ['label' => 'Categories'],
        'fontAwesome' => false,
        'isAdmin' => false,
        'displayValue' => 1,
        'softDelete' => false,
        'cacheSettings' => [
            'enableCache' => false
        ],
    ];

    /**
     * @var array default values to config `\kartik\tree\TreeView`.
     */
    protected $defaultFrontendTreeManagerConfig = [
        'options' => ['id' => 'frontendCategories'],
        'headingOptions' => ['label' => 'Categories'],
        'fontAwesome' => false,
        'isAdmin' => false,
        'displayValue' => 1,
        'softDelete' => false,
        'cacheSettings' => [
            'enableCache' => false
        ],
        'mainTemplate' => '{wrapper}',
        'wrapperTemplate' => "{header}\n{tree}",
        'rootOptions' => [
            'label'=> 'All',  // custom root label
            'class' => 'root-item'
        ],
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->hasModule($this->treemanagerModuleId)) {
            throw new InvalidConfigException(
                Yii::t('app', 'Treemanager module is require to configure (http://demos.krajee.com/tree-manager#setup-module)')
            );
        }

        $this->treeManagerConfig = ArrayHelper::merge($this->defaultTreeManagerConfig, $this->treeManagerConfig);
        $this->treeFrontendManagerConfig = ArrayHelper::merge(
            $this->defaultFrontendTreeManagerConfig,
            $this->treeFrontendManagerConfig
        );

        $this->baseImagePath = Yii::getAlias($this->baseImagePath);
        $this->baseImageUrl = Yii::getAlias($this->baseImageUrl);
        $this->baseDescriptionImagePath = Yii::getAlias($this->baseDescriptionImagePath);
        $this->baseDescriptionImageUrl = Yii::getAlias($this->baseDescriptionImageUrl);

        $view = Yii::$app->view;
        NewsAsset::register($view);
    }
}
