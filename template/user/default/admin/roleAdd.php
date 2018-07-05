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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>/js/common.js?r=<?php echo time();?>"></script>
  </head>
  <body>
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="role_name" required="" lay-verify="required" value="<?= $role['role_name'] ?>"

                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                            <?php foreach($lk_auth as $k=>$v){ ?>
                            <tr>
                                <?php if($v['pid'] == 0){ ?>
                                <td>
                                    <input type="checkbox" name="auth_id" lay-skin="primary" title="<?= $v['name'] ?>" value="<?= $v['id'] ?>"  lay-filter="allChoose" >
                                </td>
                                <td>
                                    <?php foreach($lk_auth as $kk=>$vv){
                                    ?>
                                    <?php if($vv['pid'] == $v['id']  ){ ?>
                                    <div class="layui-input-block" style="float: left;">
                                        <input name="auth_id" lay-skin="primary" type="checkbox" title="<?= $vv['name'] ?>" value="<?= $vv['id'] ?>" lay-filter="allChoose" >
                                    </div>
                                     <?php }} ?>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
              </div>
            </form>
    </div>
  </body>
</html>
<script type="text/javascript" src="<?php echo TPL_URL;?>/js/admin_roleAdd.js?r=<?php echo time();?>"></script>
