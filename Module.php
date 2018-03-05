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
    public $baseImagePath;
    /**
     * @var string
     */
    public $baseImageUrl;
    /**
     * @var string
     */
    public $baseDescriptionImagePath;
    /**
     * @var string
     */
    public $baseDescriptionImageUrl;

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

        $this->initPathesAndUrls();

        $view = Yii::$app->view;
        NewsAsset::register($view);
    }

    /**
     * @throws InvalidConfigException
     */
    protected function initPathesAndUrls()
    {
        if (!$this->baseImageUrl) {
            throw new InvalidConfigException('Param "baseImageUrl" is required');
        }

        $this->baseImagePath = !$this->baseImagePath
            ? Yii::getAlias('@frontend') . '/web/upload/news'
            : $this->baseImagePath;

        $this->baseDescriptionImagePath = !$this->baseDescriptionImagePath
            ? $this->baseImagePath . '/description'
            : $this->baseDescriptionImagePath;

        $this->baseDescriptionImageUrl = $this->baseImageUrl . '/description';
    }
}
