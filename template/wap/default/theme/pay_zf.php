<?php if(!defined('LEKA_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>支付绑定</title>
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>mui/css/mui.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <style type="text/css">
         html,body{
            height: 100%;
            background-color: #f2f2f2;
        }
        .lines{width: 90%;margin: 50px auto;}
        .content{margin-top:45px; }
        .line{
            border-bottom: 1px solid #f0f0f0;
        }
        img{
            height: 40px;
            width: 40px;
        }
        .pay_type{
            display: flex;
            line-height: 50px;
            color: #999;
        }
        .pay_type span{
            margin-left: 10px;
        }
        .mui-content>.mui-table-view:first-child {
            margin-top: 0px;
        }
    </style>
</head>
<body> 
    <div class="mui-content">
        <ul class="mui-table-view">
            <?php foreach($pay_type as$k=> $v){?>
            <li class="mui-table-view-cell" >
                <div class="pay_type" data-type="<?php echo $v['id'];?>">
                    <img src="<?php echo $config['site_url'].$v['logo']?>"><span>绑定<?php echo $v['name'];?></span>
                </div><!-- mui-active -->
                <?php if($v['pay_status'] != 2){?>
                <div id="<?php echo $v['pay_id'];?>" class="mui-switch <?php echo ($v['pay_status']==1)?'mui-active':'';?>">
                    <div class="mui-switch-handle"></div>
                </div>
                <?php }?>
            </li>
            <?php }?>
        </ul>
    </div>
    <?php //include display('public_menu');?>
</body>
</html>
<script type="text/javascript" src="<?php echo STATIC_URL;?>mui/js/mui.min.js" charset="utf-8"></script>
<script type="text/javascript">
    window.addEventListener('toggle', function(event) {
        var data = {id:event.target.id};
        data.status = event.detail.isActive?1:0;
        console.log(data);
        $.post('pay_zf.php',data,function(re){
            if(re.error == 0){}else{ } 
        },'json');
    });
    $(function(){
        $('.pay_type').click(function(event) {
            var type = $(this).data('type');
            window.location.href = "./pay_xq.php?type="+type; 
        });
    })


</script>