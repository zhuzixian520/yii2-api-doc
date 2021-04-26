<?php

namespace zhuzixian520\api_doc\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
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
            'host_api' => $this->_getApiHost(),
            'author' => $this->module->author,
            'email' => $this->module->email,
        ];

        return $this->render('index', $data);
    }

    public function actionView()
    {
        $this->layout = 'main';

        $route = Yii::$app->request->get('route');
        $ver = Yii::$app->request->get('ver');
        $arr = explode('/',$route);
        //if (count($arr) != 4 || in_array('',$arr)){
        if (count($arr) != 3 || in_array('',$arr)){
            throw new NotFoundHttpException('您输入的地址页面不存在');
        }

        //$c_name = Inflector::id2camel(StringHelper::mb_ucfirst($arr[2])).'Controller';
        $c_name = Inflector::id2camel(StringHelper::mb_ucfirst($arr[1])).'Controller';
        //$class = 'api\modules\\'.$arr[0].'\\controllers\\'.$arr[1]. '\\' .$c_name;
        $class = 'api_cms\modules\\' . $arr[0]. '\\controllers\\' . $c_name;

        //$res = strpos($arr[3], '-');
        $res = strpos($arr[2], '-');
        if ($res){
            //$a = FormatHelper::trimAll(StringHelper::mb_ucwords(str_replace('-', ' ', $arr[3])));
            $a = trim(StringHelper::mb_ucwords(str_replace('-', ' ', $arr[2])));
        }else{
            //$a = StringHelper::mb_ucfirst($arr[3]);
            $a = StringHelper::mb_ucfirst($arr[2]);
        }
        $method = 'action'.$a;

        try {
            $notes = AnnotationHelper::getNoteDetail($class, $method);
        } catch (\ReflectionException $e){
            //return $e->getMessage();
            throw new NotFoundHttpException('您输入的地址页面不存在');
        }

        $data = [
            'notes' => $notes,
            'route' => $route,
            'ver' => $ver,
            //'tab_name' => $arr[1],
            'host_api' => $this->_getApiHost(),
            'author' => $this->module->author,
            'email' => $this->module->email,
        ];

        return $this->render('detail', $data);
    }

    private function _getApiHost()
    {
        $env = YII_ENV;
        switch ($env) {
            case YII_ENV_DEV:
                $host_api = $this->module->hostApiDev;
                break;
            case YII_ENV_PROD:
                $host_api = $this->module->hostApiProd;
                break;
            case YII_ENV_TEST:
                $host_api = $this->module->hostApiTest;
                break;
            default:
                $host_api = '';
        }

        return $host_api;
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