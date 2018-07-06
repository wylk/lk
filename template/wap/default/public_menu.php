<style type="text/css">
.wx_nav {
display: box;
display: -ms-box;
display: -webkit-box;
display: flex;
display: -ms-flexbox;
display: -webkit-flex;
}
.wx_nav {
overflow: hidden;
height: 49px;
border-top: 1px solid #ddd;
position: fixed;
z-index: 900;
width: 100%;
bottom: 0;
left: 0;
}
.wx_nav a {
display: block;
flex: 1;
-ms-flex: 1;
-webkit-flex: 1;
box-flex: 1;
-ms-box-flex: 1;
-webkit-box-flex: 1;
}
.wx_nav a {
position: relative;
width: 200px;
height: 45px;
padding-top: 4px;
color: #999;
font-size: 12px;
background-color: #F9F5F5;
text-align: center;
}
.wx_nav a:active, .wx_nav a.on {
	color: #f6bc00;
}
.wx_nav a:before {
background-image: url(../template/wap/default/images/icon_nav.png);
background-repeat: no-repeat;
background-size: 207px 46px;
-webkit-background-size: 207px 46px;
}
.wx_nav a:before {
width: 23px;
height: 23px;
content: '\20';
display: block;
margin: 0 auto 2px auto;
}
.wx_nav .nav_index:before {
background-position: 0 0;
}
.wx_nav .nav_search:before {
background-position: -46px 0;
}
.wx_nav .nav_shopcart:before {
background-position: -138px 0;
}
.wx_nav .nav_me:before {
background-position: -69px 0;
}
.wx_nav a:active:before, .wx_nav a.on:before {
background-position-y: -23px;
}
</style>
<div class="wx_nav">
	<a href="./index.php" class="nav_index <?php if($php_self == 'index.php'){ echo 'on';}?>">首页</a>
	<a href="./card_buy.php" class="card_buy <?php if($php_self == 'card_buy.php'){ echo 'on';}?>">卡包</a>
	<a href="" class="nav_shopcart <?php if($php_self == 'weidian.php'){ echo 'on';}?>">核销</a>
	<a href="./my.php" class="nav_me <?php if($php_self == 'my.php'){ echo 'on';}?>">个人中心</a>
</div>
