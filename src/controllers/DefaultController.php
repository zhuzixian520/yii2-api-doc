<?php

namespace zhuzixian520\api_doc\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    /**
     * @var \zhuzixian520\api_doc\Module
     */
    public $module;

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = 'main';

        return $this->render('index');
    }
}