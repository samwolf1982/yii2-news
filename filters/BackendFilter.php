<?php

namespace snapget\news\filters;

use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

/**
 * Class BackendFilter is used to allow access only to admin and security controller in frontend when using Yii2-news with
 * Yii2 advanced template.
 */
class BackendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = ['news'];


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