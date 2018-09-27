<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/font.css">
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>x-admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>x-admin/js/xadmin.js"></script>
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a> <cite>应用管理</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <div class="layui-form layui-col-md12 x-so layui-form-pane">
          <button class="layui-btn"  lay-submit="" onclick="x_admin_show('增加合约','?c=config&a=addApplication',600,500)"><i class="layui-icon"></i>增加</button>
        </div>
      </div>
      <table class="layui-table layui-form">
        <thead>
          <tr>
            <th width="70">ID</th>
            <th width="70">合约名</th>
            <th width="70">合约logo</th>
            <th width="250" >合约描述</th>
            <th width="50" >排序</th>
            <th width="50" >状态</th>
            <th width="220">操作</th>
        </thead>
        <tbody class="x-cate">
          <?php if(isset($contracts)){ foreach($contracts as $k => $v){?>
          <tr cate-id='1' fid='0' >
            <td><?php echo $v['id']?></td>
            <td><?php echo $v['contract_name']?> </td>
            <td><img src="<?php echo $v['pc_logo']?>" style="width: 60px;height: 60px;border-radius: 10%"></td>
             <td><?php echo $v['contract_explain'];?></td>
            <td><input type="text" class="layui-input x-sort" name="order" data-id='<?php echo $v['id'];?>' value="<?php echo $v['sort']?>"></td>
            <td>
              <input type="checkbox"  data-id='<?php echo $v['id'];?>' name="switch"  lay-text="开启|停用"  <?php echo $v['status']==1?'checked':'';?> lay-skin="switch" lay-filter="ifNullDemo" value="<?php echo $v['status'];?>">
            </td>
            <td class="td-manage">
              <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑合约','?c=config&a=addApplication&id=<?php echo $v['id'];?>',600,500)" ><i class="layui-icon">&#xe642;</i>编辑</button>
              <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'<?php echo $v['id'];?>')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
            </td>
          </tr>
        <?php }?>
        <?php }?>
        </tbody>
      </table>
    </div>
  </body>
 <script type="text/javascript" src="<?php echo TPL_URL;?>js/config_application.js?r=<?php echo time();?>"></script>
</html>
