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
    </head>
    <body>
    <div class="x-body layui-anim layui-anim-up">
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
                                                <p>
                                                    <cite>66</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>全部买单</h3>
                                                <p> <cite>12</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>申诉单</h3>
                                                <p>
                                                    <cite>99</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>今日交易量</h3>
                                                <p>
                                                    <cite>67</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>全部交易量</h3>
                                                <p>
                                                    <cite>67</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>账户余额</h3>
                                                <p>
                                                    <cite>6766</cite></p>
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
