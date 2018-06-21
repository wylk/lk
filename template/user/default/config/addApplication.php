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
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/common.js?r=<?php echo time();?>"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/config_addApplication.js?r=<?php echo time();?>"></script>
  </head>
  <body>
    <div class="x-body">
        <form class="layui-form">
          <input type="hidden" name="id" value="<?php echo $contract['id'];?>">
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>合约名
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="contract_name" name="contract_name" required="" lay-verify="required"
                  autocomplete="off" value="<?php echo $contract['contract_name'];?>" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>将会成为您唯一的合约名
              </div>
          </div>
          <div class="layui-form-item">
              <label for="phone" class="layui-form-label">
                  <span class="x-red">*</span>合约标识
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="<?php echo $contract['contract_title'];?>" id="contract_title" name="contract_title" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>将会成为您唯一合约标记
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>合约介绍
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="<?php echo $contract['contract_explain'];?>" id="contract_explain" name="contract_explain" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*合约描述</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label"><span class="x-red">*</span>是否免费</label>
              <div class="layui-input-block">
                <input type="radio" name="free" value="0" title="免费" <?php echo $contract['free'] == '0'?'checked':'';?>>
                <input type="radio" name="free" value="1" title="收费" <?php echo $contract['free'] == '1'?'checked':'';?>>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>合约封面(pc)
              </label>
              <div class="layui-input-inline ">
                <div class="layui-row">
                  <div class="layui-col-xs4">
                    <a href="javascript:;" type="button" class="layui-btn layui-col-md4" id="img" data-type="pc_logo">
                    <i class="layui-icon">&#xe67c;</i></a>
                  </div>
                  <div class="layui-col-xs8">
                    <input type="text" value="<?php echo $contract['pc_logo'];?>" id="pc_logo" name="pc_logo" required="" lay-verify="required" autocomplete="off" class="layui-input" style="width: 190px">
                  </div>
                </div>
                  
              </div>
          </div>
         <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>合约封面(wap)
              </label>
              <div class="layui-input-inline ">
                <div class="layui-row">
                  <div class="layui-col-xs4">
                    <a href="javascript:;" type="button" class="layui-btn layui-col-md4" id="img" data-type="wap_logo">
                    <i class="layui-icon">&#xe67c;</i></a>
                  </div>
                  <div class="layui-col-xs8">
                    <input type="text" value="<?php echo $contract['pc_logo'];?>" id="wap_logo" name="wap_logo" required="" lay-verify="required" autocomplete="off" class="layui-input" style="width: 190px">
                  </div>
                </div>
                  
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  <?php echo $contract['btn'];?>
              </button>
          </div>
      </form>
    </div>
    <input type="file" name="image" style="opacity:0;filter:alpha(opacity=0);" id="inputfile"/>
    <input type="hidden" name="" value="" id="hidden_img">
  </body>
</html>