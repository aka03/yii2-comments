<?php

namespace aka03\comments\modules\testPage\controllers;

use aka03\comments\modules\testPage\models\LoginForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `testPage` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
