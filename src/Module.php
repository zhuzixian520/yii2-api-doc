<?php

namespace zhuzixian520\api_doc;

use yii\base\Application;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'zhuzixian520\api_doc\controllers';

    public $hostApiDev = '';
    public $hostApiProd = '';
    public $hostApiTest = '';
    public $logo_src = 'https://www.yiichina.com/images/logo.svg';
    public $author = 'Trevor';
    public $email = 'service@wangxiankeji.com';
    public $icp_num = '';
    public $icp_website = 'http://beian.miit.gov.cn';
    public $copyright_website = '';
    public $company_start_year = '';
    public $is_show_fae = true;
    public $fae_name = '网仙科技';
    public $fae_website = 'http://www.wangxiankeji.com';

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
            ], false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }
}