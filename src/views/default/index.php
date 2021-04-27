<?php

/* @var $this yii\web\View */
/* @var $ver string */
/* @var $apiModuleList array */

use yii\helpers\Url;

$host_api = $this->params['host_api'] ?? '';
$author = $this->params['author'] ?? '';
$email = $this->params['email'] ?? '';

$this->title = 'API文档 ' . $ver . '.0.0'. ' - '. Yii::$app->name;

?>
<div class="index">
    <div class="alert alert-warning" role="alert"><strong>API统一地址：</strong><?= $host_api . '/' . $ver . '/';?> + 接口服务</div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>接口服务</th>
            <th>接口名称</th>
            <th>请求方法</th>
            <th>更多说明</th>
        </tr>
        </thead>
        <tbody>
        <?php $j=0; foreach ($apiModuleList as $k => $v){?>
            <tr>
                <td><?= $j+1;?></td>
                <td><a href="<?= Url::toRoute(['default/view', 'route' => $ver. '/' .$v['route'], 'ver' => $ver, ]);?>" target='_blank'><?= $v['route'];?></a></td>
                <td><?= $v['name'];?></td>
                <td><label class='label <?= $v['method'] == 'POST' ? 'label-primary' : 'label-success';?>'><?= strtoupper($v['method']);?></label></td>
                <td><?= $v['desc'];?></td>
            </tr>
            <?php $j++;}?>
        </tbody>
    </table>
    <div class="alert alert-success" role="alert">
        <strong>温馨提示：</strong> 此接口服务列表根据后台代码自动生成，如有疑问，请咨询PHP架构师 <?= $author;?>，邮箱：<a href="mailto:<?= $email;?>"><?= $email;?></a>
    </div>
</div>
