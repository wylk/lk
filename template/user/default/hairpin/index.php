<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>平台币管理</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
        <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
        <style type="text/css">
            .accountBtn{display: flex;justify-content: center;height:300px;align-items:center;}
            .info{background-color: #a2999966;width:230px;height:130px;border-radius:20px;padding: 40px;}
            .info span{margin: 10px auto; display: block;}
        </style>
<script type="text/javascript">
    layui.use(['layer'],function(){
    // layui.use(['element','layer'],function(){
        // var layer = layyui.layer;

        $("#addAccount").bind('click',function(){
            // var phone = "<?php echo $phone ?>";
            // var data={phone:phone}
            var data = {type:'add'};
            $.post("?c=hairpin&a=addAdminAccount",data,function(result){
                // console.log(result);
                if(!result.res){
                    layer.msg(result.msg,{icon:1,skin:"demo-class"});
                    window.location.reload(true);
                }else{
                    layer.msg(result.msg,{icon:5,skin:"demo-class"});
                }
            },"json");
        })
    })
</script>
    </head>
    <body>
    <?php if(!$userInfo && $_SESSION["admin"]['name'] == 'admin'){ ?>
        <div class="accountBtn">
            <div class="info">
                <p>现在还没有账户，点击下面按钮进行注册</p>
                <span class="layui-btn layui-btn-normal" id="addAccount">注册平台币账户</span>
            </div>
        </div>

    <div class="x-body layui-anim layui-anim-up" style="display:none;">
    <?php }else{ ?>
    <div class="x-body layui-anim layui-anim-up">
    <?php } ?>
        <fieldset class="layui-elem-field">
            <legend>交易统计</legend>
            <div class="layui-field-box">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body">
                            <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                                <div carousel-item="">
                                    <ul class="layui-row layui-col-space10 layui-this">
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>全部卖单</h3>
                                                <p><cite><?php echo number_format($datas['sellNumTotal'],2); ?></cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>全部买单</h3>
                                                <p><cite><?php echo number_format($datas['buyNumTotal'],2); ?></cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>申诉单</h3>
                                                <p><cite>99</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>今日交易量</h3>
                                                <p><cite><?php echo number_format($datas['tranNumToday'],2); ?></cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>全部交易量</h3>
                                                <p><cite><?php echo number_format($datas['tranNumTotal'],2); ?></cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>账户余额</h3>
                                                <p><cite><?php echo number_format($datas['totalNumNow'],2); ?></cite></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="layui-elem-field">
            <legend>全部交易</legend>
            <div class="layui-field-box">
               <table class="layui-table" lay-skin="line">
                  <colgroup>
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col>
                  </colgroup>
                  <thead>
                    <tr>
                      <th>转出</th>
                      <th>转入</th>
                      <th>数量</th>
                      <th>交易额</th>
                      <th>成交时间</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($books as $key=>$value){ ?>
                        <tr>
                            <td title="<?php echo $value['send_address'] ?>"><?php echo substr($value['send_address'],0,10); ?>...</td>
                            <td title="<?php echo $value['get_address']; ?>"><?php echo substr($value['get_address'],0,10); ?>...</td>
                            <td><?php echo number_format($value['num'],2); ?></td>
                            <td><?php echo number_format($value['num']*$value['price'],2); ?></td>
                            <td><?php echo date("Y-m-d H:i:s",$value['createtime']); ?></td>
                        </tr>
                    <?php } ?>
                    <?php for($i = 0; $i < 10 ; $i++){?>
                    <tr>
                      <td>老王</td>
                      <td>老李</td>
                      <td>2412</td>
                      <td>123</td>
                      <td>2016-11-29</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
        </fieldset>

    </div>

    </body>

</html>
