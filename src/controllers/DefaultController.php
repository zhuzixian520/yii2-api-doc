<?php

namespace zhuzixian520\api_doc\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use zhuzixian520\api_doc\AnnotationHelper;

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

        $version = (int)Yii::$app->request->get('v', 1);
        if ($version == 0){
            $version = 'v1';
        }else {
            $version = 'v' . $version;
        }

        $apiModuleList = $this->_getApiModuleList($version);

        $data = [
            'apiModuleList' => $apiModuleList,
            'ver' => $version,
        ];

        return $this->render('index');
    }

    private function _getApiModuleList($version)
    {
        //$yii2_modules = Yii::$app->modules;
        //unset($yii2_modules['gii']);
        //unset($yii2_modules['debug']);
        $module = Yii::$app->getModule($version);//获取版本模块
        if (!$module) {
            throw new NotFoundHttpException('您输入的地址页面不存在');
        }

        $controller_path = $module->getControllerPath();//获取控制器主路径

        //$folder_arr = FileHelper::findDirectories($controller_path);//获取控制器主文件夹下的子文件数组
        $folder = $controller_path;
        $apiModuleList = [];
        //foreach ($folder_arr as $k => $folder) {
        $controllers = FileHelper::findFiles($folder, ['recursive' => true]);
        foreach ($controllers as $k2 => $controller) {
            //获取控制器的类名，含命名空间
            $base_path = dirname(Yii::getAlias('@api_cms'));
            $c_name_temp = str_replace([$base_path, '.php', '/'], ['', '', '\\'], $controller);
            $c_name = mb_substr($c_name_temp, 1);

            $contents = file_get_contents($controller);
            $controllerId = Inflector::camel2id(substr(basename($controller), 0, -14));

            preg_match_all('/public function action(\w+?)\(/', $contents, $result);
            foreach ($result[1] as $k3 => $action) {
                $methods = AnnotationHelper::getNoteDetail($c_name, 'action' . $action);
                $actionId = Inflector::camel2id($action);

                /*$ctrl = str_replace($controller_path . DIRECTORY_SEPARATOR, '', $folder_arr[$k]);
                $route = $ctrl . '/' . $controllerId . '/' . $actionId;
                $apiModuleList[$ctrl][$route] = $methods;
                $apiModuleList[$ctrl][$route]['route'] = $route;
                asort($apiModuleList[$ctrl][$route]);*/

                $route = $controllerId . '/' . $actionId;
                $apiModuleList[$route] = $methods;
                $apiModuleList[$route]['route'] = $route;
                asort($apiModuleList[$route]);
            }
        }
        //}
        return $apiModuleList;
    }
}