<?php

namespace snapget\news\filters;

use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

/**
 * Class FrontendFilter
 * @package snapget\news\filters
 */
class FrontendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = ['admin-news-category', 'admin-news'];


    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->controller->id, $this->controllers)) {
            throw new NotFoundHttpException('Not found');
        }
        return true;
    }
}