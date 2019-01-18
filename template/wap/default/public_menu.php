<style type="text/css">
	.mui-bar-tab{
		background: #fff;
	}
	.mui-bar-tab .mui-tab-item.mui-active {
    	color: #67ccf4;
	}
	.mui-bar .mui-icon {
	    font-size: 22px;
	    position: relative;
	    z-index: 20;
	    padding-top: 10px;
	    padding-bottom: 10px;
	}
</style>

<nav class="mui-bar mui-bar-tab">
	<a class="mui-tab-item <?php if($php_self == 'index.php'){echo 'mui-active';}?>" href="./index.php">
		<span class="mui-icon iconfont icon-shouye1"></span>
		<span class="mui-tab-label">首页</span>
	</a>
	<a class="mui-tab-item <?php if($php_self == 'card_package.php'){echo 'mui-active';}?>" href="./card_package.php">
		<span class="mui-icon iconfont icon-qiabao3"></span>
		<span class="mui-tab-label">卡包</span>
	</a>
	<a class="mui-tab-item <?php if($php_self == 'find.php'){echo 'mui-active';}?>" href="find.php">
		<span class="mui-icon iconfont icon-faxian1"><span class="mui-badge">9</span></span>
		<span class="mui-tab-label">发现</span>
	</a>
	<a class="mui-tab-item <?php if($php_self == 'my.php'){echo 'mui-active';}?>" href="./my.php">
		<span class="mui-icon iconfont icon-wode"></span>
		<span class="mui-tab-label">我的</span>
	</a>
</nav>
