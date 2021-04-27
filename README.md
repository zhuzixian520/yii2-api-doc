<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 Annotations Generate API Document Extension</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/zhuzixian520/yii2-api-doc/v)](//packagist.org/packages/zhuzixian520/yii2-api-doc)
[![Total Downloads](https://poser.pugx.org/zhuzixian520/yii2-api-doc/downloads)](//packagist.org/packages/zhuzixian520/yii2-api-doc)
[![Latest Unstable Version](https://poser.pugx.org/zhuzixian520/yii2-api-doc/v/unstable)](//packagist.org/packages/zhuzixian520/yii2-api-doc)
[![License](https://poser.pugx.org/zhuzixian520/yii2-api-doc/license)](//packagist.org/packages/zhuzixian520/yii2-api-doc)
[![Suggesters](https://poser.pugx.org/zhuzixian520/yii2-api-doc/suggesters)](//packagist.org/packages/zhuzixian520/yii2-api-doc)
[![Dependents](https://poser.pugx.org/zhuzixian520/yii2-api-doc/dependents)](//packagist.org/packages/zhuzixian520/yii2-api-doc)

yii2-api-doc
============
Generate online api document by code annotation for yii2 easily

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist zhuzixian520/yii2-api-doc "*"
```

or add

```
"zhuzixian520/yii2-api-doc": "*"
```

to the require section of your `composer.json` file and run

```
composer install
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
return [
    'modules' => [
        'api_doc' => [
            'class' => 'zhuzixian520\api_doc\Module',
            'hostApiDev' => 'http://api-dev.demo.com',//开发环境接口主机地址
            'hostApiProd' => 'http://api.demo.com',//生产环境接口主机地址
            'hostApiTest' => 'http://api-test.demo.com',//测试环境接口主机地址
            'author' => 'Trevor',
            'email' => 'service@wangxiankeji.com',
            'logo_src' => '/img/logo_64_64.png',//web目录下
            'icp_num' => '粤ICP备15025495号',
            'copyright_website' => 'http://www.sijiche.com',
            'company_start_year' => '2015',
        ],
        'v1' => [
            'class' => 'api\modules\v1\V1Module',
        ],
    ],
];
```

Controller code comments in the API

```php
class PassportController extends yii\rest\Controller
{
    /**
     * 微信PC网页登录
     * @method POST
     * @token 0
     * @param string code 同意授权后的code 是
     * @res string token 访问令牌
     * @return array
     */
    public function actionLoginByWechatPc(): array {}
}
```
Output

![img.png](img.png)

![img_1.png](img_1.png)

Access the API document address

_just like gii or debug，and you can also change the V parameter to switch API versions_

`
http://yourhost/api_doc?v=1
`

Contact Us

Email：zhuzixian520@126.com