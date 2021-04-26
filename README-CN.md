yii2-api-doc
============
通过对yii2的代码注释方便地生成在线api文档

安装
------------

安装此扩展的首选方式是通过 [composer](http://getcomposer.org/download/).

或者运行

```
composer require --prefer-dist zhuzixian520/yii2-api-doc "*"
```

或者添加

```
"zhuzixian520/yii2-api-doc": "*"
```

到你的`composer.json`文件中的 require 的部分，然后运行
```
composer install
```

用法
-----

一旦扩展安装，只需在您的代码中这样使用它:

```php
<?= \zhuzixian520\api_doc\AutoloadExample::widget(); ?>
```