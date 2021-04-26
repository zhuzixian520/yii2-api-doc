<?php

/* @var $this yii\web\View */
/* @var $notes array*/
/* @var $route string */
/* @var $ver string */

/* @var $host_api string */
/* @var $author string */
/* @var $email string */


use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

//$this->title = 'API文档 ' . $ver . '.0.0'. ' - '. Yii::$app->name;
$this->title = $notes['name'] . ' - ' . Yii::$app->name . ' API v1.0.0';
//$this->params['breadcrumbs'][] = '接口 - ' . $notes['name'];
$token = $notes['token'] ?? 0;
?>
<div>
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => '首页',
            'url' => ['/'],
            'template' => '<li><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;{link}</li>'
        ],
        'itemTemplate' => "<li>{link}</li>\n", //全局模板  运用到每个link
        'links' => [
            /*[
            'label' => '文章列表',
            'url' => ['site/index'],
            'template' => "<li>{link}</li>" //只会引用到该类模板
            ],
            [
            'label' => '文章详情',
            'url' => ['site/view', 'id'=>1]//如果需要传参这种格式
            ],*/
            '接口 - ' . $notes['name'],//没有链接的
        ],
        'options' => [//设置html属性
            'class' => 'breadcrumb',
        ],
    ]);?>
    <div class="alert alert-warning" role="alert">
        <strong>地址：</strong>
        <span style="margin-left: 5px;color:red;word-break: break-all;"><?= $host_api . '/' . $route;?></span>
    </div>
    <div class="page-header">
        <h4><span class="glyphicon glyphicon-open" aria-hidden="true"></span> 请求参数</h4>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>参数名</th>
            <th>类型</th>
            <th>是否必须</th>
            <th>说明</th>
        </tr>
        </thead>
        <tbody>
        <?php if($token != 0){?>
            <tr>
                <td>token</td>
                <td>string</td>
                <td><label class="label label-primary"><?= $token == 1 ? '是' : '否';?></label></td>
                <td>用户登录认证秘钥【请在Header头Authorization里面传递】</td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>参数名</th>
            <th>类型</th>
            <th>是否必须</th>
            <th>默认值</th>
            <th>说明</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($notes['param'] as $v){?>
            <tr>
                <td><?= $v[1];?></td>
                <td><?= $v[0];?></td>
                <td><label class="label <?= isset($v[3]) && $v[3]=='否'? 'label-default' : 'label-primary';?> label"><?= isset($v[3]) ? $v[3] : '';?></label></td>
                <td><?= isset($v[4]) ? $v[4] : '';?></td>

                <td><?= $v[2];?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <div class="page-header">
        <h4><span class="glyphicon glyphicon-save" aria-hidden="true"></span> 返回参数</h4>
    </div>
    <table class="table table-bordered" >
        <thead>
        <tr><th>返回字段</th><th>类型</th><th>说明</th></tr>
        </thead>
        <tbody>
        <tr>
            <td>name</td>
            <td>string</td>
            <td>HTTP Status Name</td>
        </tr>
        <tr>
            <td>message</td>
            <td>string</td>
            <td>返回的信息，当请求成功时为Success</td>
        </tr>
        <tr>
            <td>code</td>
            <td>int</td>
            <td>返回码，详情请参阅<a href="<?= Url::toRoute(['index/code']);?>">错误码说明</a></td>
        </tr>
        <tr>
            <td>status</td>
            <td>int</td>
            <td>HTTP Status Code</td>
        </tr>
        <tr>
            <td>type</td>
            <td>string</td>
            <td>出错时的异常信息类型</td>
        </tr>
        <tr>
            <td>data</td>
            <td>array</td>
            <td>数据</td>
        </tr>
        </tbody>
    </table>
    <div class="page-header">
        <h5>data字段详细返回参数</h5>
    </div>
    <table class="table table-bordered" >
        <thead>
        <tr><th>返回字段</th><th>类型</th><th>说明</th></tr>
        </thead>
        <tbody>
        <?php if (!empty($notes['res'])){foreach ($notes['res'] as $k2){?>
            <tr>
                <td><?= $k2[1]?></td>
                <td><?= $k2[0]?></td>
                <td><?= $k2[2]?></td>
            </tr>
        <?php }}?>
        </tbody>
    </table>
    <div class="page-header">
        <h4><span class="glyphicon glyphicon-send" aria-hidden="true"></span> 请求模拟</h4>
    </div>
    <table class="table table-bordered" >
        <thead>
        <tr>
            <th>字段</th>
            <th>名称</th>
            <th>类型</th
            ><th>值</th>
        </tr>
        </thead>
        <tbody>
        <?php if($token != 0){?>
            <tr>
                <td>token</td>
                <td>访问令牌</td>
                <td>string</td>
                <td>
                    <textarea class="form-control" rows="6" name="token"></textarea>
                </td>
            </tr>
        <?php }?>
        <?php foreach ($notes['param'] as $v){?>
            <tr>
                <td><?= $v[1];?></td>
                <td><?= $v[2];?></td>
                <td><?= $v[0];?></td>
                <td class="td">
                    <input type="text" class="form-control" name="<?= $v[1];?>" value="<?= $v[4] ?? null;?>">
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-10" style="line-height: 2.4em;word-break: break-all;">
            <strong>接口地址：</strong>
            <span style="color: #953b39;"><?= $host_api . '/' . $route;?><span>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-success" id="submit">提交请求</button>
        </div>
    </div>
    <div class="alert alert-info" role="alert" id="json_output"></div>
    <div class="alert alert-success" role="alert">
        <strong>温馨提示：</strong> 此接口服务列表根据后台代码自动生成，如有疑问，请咨询PHP架构师 <?= $author;?>，邮箱：<a href="mailto:<?= $email;?>"><?= $email;?></a>
    </div>
</div>
<script>
    <?php $this->beginBlock('my_js');?>

    function getData() {
        var _data={};

        $(".td input").each(function(index,e) {
            if ($.trim(e.value)){
                _data[e.name] = e.value;
            }
        });

        return _data;
    }

    $(function(){
        $("#json_output").hide();
        $("#submit").on("click",function(){
            //var _header = getHeaderData();
            var _data = getData();
            //var url = $("textarea[name=request_url]").val();
            let url = '<?= $host_api . '/' . $route;?>';
            //console.log(url);
            var method = '<?= $notes['method'];?>';
            $.ajax({
                url: url,
                data: method=='POST' ? JSON.stringify(_data) : {},
                dataType: 'json',
                type: method,
                //headers: _header,
                contentType: 'application/json',
                beforeSend: function(request) {
                    <?php if($token != 0){?>
                    //request.setRequestHeader("token", $("textarea[name=token]").val());
                    request.setRequestHeader("Authorization", 'Bearer ' + $("textarea[name=token]").val());
                    <?php }?>
                },
                success:function(res,status,xhr){
                    //console.log(xhr);
                    var statu = xhr.status + ' ' + xhr.statusText;
                    var header = xhr.getAllResponseHeaders();
                    var json_text = JSON.stringify(res, null, 4);    // 缩进4个空格
                    $("#json_output").html('<code style="white-space: pre-wrap;word-wrap: break-word;color: #31708f;background-color: #d9edf7;">' + statu + '<br/>' + header + '<br/>' + json_text + '</code>');
                    $("#json_output").show();
                },
                error:function(error){
                    console.log(error);
                    var statu = error.status + ' ' + error.statusText;
                    var header = error.getAllResponseHeaders();
                    var json_text = JSON.stringify(error.responseJSON, null, 4);    // 缩进4个空格
                    $("#json_output").html('<code style="white-space: pre-wrap;word-wrap: break-word;color: #31708f;background-color: #d9edf7;">' + statu + '<br/>' + header + '<br/>' + json_text + '</code>');
                    $("#json_output").show();
                }
            })
        })
    });

    <?php $this->endBlock()?>
</script>

<?php $this->registerJs($this->blocks['my_js'],View::POS_END);?>
