-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 06 月 20 日 01:45
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lk`
--

-- --------------------------------------------------------

--
-- 表的结构 `lk_access`
--

CREATE TABLE IF NOT EXISTS `lk_access` (
  `role_id` int(20) unsigned NOT NULL COMMENT '角色标识',
  `auth_id` int(20) unsigned NOT NULL COMMENT '权限标识',
  `level` tinyint(4) NOT NULL COMMENT '层次',
  `model` varchar(50) DEFAULT NULL COMMENT '模块'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lk_access`
--

INSERT INTO `lk_access` (`role_id`, `auth_id`, `level`, `model`) VALUES
(125, 68, 0, NULL),
(125, 65, 0, NULL),
(125, 69, 0, NULL),
(4, 88, 0, NULL),
(4, 87, 0, NULL),
(4, 86, 0, NULL),
(4, 85, 0, NULL),
(125, 64, 0, NULL),
(125, 60, 0, NULL),
(4, 84, 0, NULL),
(4, 83, 0, NULL),
(4, 82, 0, NULL),
(4, 80, 0, NULL),
(4, 79, 0, NULL),
(4, 78, 0, NULL),
(4, 77, 0, NULL),
(4, 76, 0, NULL),
(4, 74, 0, NULL),
(4, 73, 0, NULL),
(4, 68, 0, NULL),
(4, 65, 0, NULL),
(4, 72, 0, NULL),
(4, 71, 0, NULL),
(4, 60, 0, NULL),
(4, 89, 0, NULL),
(0, 0, 0, NULL),
(0, 0, 0, NULL),
(0, 0, 0, NULL),
(127, 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `lk_admin`
--

CREATE TABLE IF NOT EXISTS `lk_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `name` varchar(30) NOT NULL COMMENT '用户名',
  `upwd` varchar(50) NOT NULL COMMENT '用户密码',
  `phone` char(12) NOT NULL COMMENT '用户手机号',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `timestamp` int(11) DEFAULT NULL COMMENT '注册时间',
  `status` int(11) DEFAULT '0' COMMENT '用户状态  0启用  1禁止',
  `authority` tinyint(5) DEFAULT '0' COMMENT '用户角色',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `lk_admin`
--

INSERT INTO `lk_admin` (`id`, `name`, `upwd`, `phone`, `email`, `timestamp`, `status`, `authority`) VALUES
(40, 'admin', '96e79218965eb72c92a549dd5a330112', '17301288811', 'dasasdas@qq.com', NULL, 1, 0),
(43, 'lallal', '96e79218965eb72c92a549dd5a330112', '17301288811', 'dasasdas@qq.com', NULL, 0, 0),
(42, 'dsadsa', '96e79218965eb72c92a549dd5a330112', '17301288811', 'dasasdas@qq.com', NULL, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `lk_auth`
--

CREATE TABLE IF NOT EXISTS `lk_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` int(11) NOT NULL,
  `auth_c` varchar(32) NOT NULL,
  `auth_a` varchar(32) NOT NULL,
  `icon` varchar(30) NOT NULL COMMENT '图标',
  `level` tinyint(4) NOT NULL,
  `is_show` int(10) unsigned DEFAULT NULL COMMENT '是否显示',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0不能用,1能用',
  `sort` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- 转存表中的数据 `lk_auth`
--

INSERT INTO `lk_auth` (`id`, `name`, `pid`, `auth_c`, `auth_a`, `icon`, `level`, `is_show`, `status`, `sort`) VALUES
(60, '会员管理', 0, 'user', 'index', '', 1, 1, 1, 0),
(71, '会员列表', 60, 'user', 'index', '', 2, 1, 1, 0),
(65, '订单管理', 0, 'order', 'index', '&amp;#xe6ae;', 1, 1, 1, 0),
(68, '订单列表', 65, 'order', 'orderList', '&amp;#xe6a7;', 2, 1, 1, 0),
(72, '会员删除', 60, 'user', 'delete', '', 2, 1, 1, 0),
(73, '商家管理', 0, 'perm', 'index', '&#xe6c9;', 1, 1, 1, 0),
(74, '店铺管理', 73, 'perm', 'seller', '&amp;#xe6a7;', 2, 1, 1, 0),
(76, '发卷人管理', 73, 'perm', 'getAdd', '&amp;#xe6a7;', 2, 1, 1, 0),
(77, '卡卷管理', 0, 'coiling', 'index', '&amp;#xe69f;', 1, 1, 1, 0),
(78, '卡管理', 77, 'coiling', 'card', '&amp;#xe6a7;', 2, 1, 1, 0),
(79, '卷管理', 77, 'coiling', 'curly', '&amp;#xe6a7;', 2, 1, 1, 0),
(80, '管理员管理', 0, 'admin', 'index', '&amp;#xe6f5;', 1, 1, 1, 0),
(82, '管理员列表', 80, 'admin', 'index', '&amp;#xe6a7;', 2, 1, 1, 0),
(83, '角色管理', 80, 'admin', 'role', '&amp;#xe6a7;', 2, 1, 1, 0),
(84, '菜单管理', 80, 'admin', 'auth', '&amp;#xe6a7;', 2, 1, 1, 0),
(85, '财务管理', 0, 'account', 'index', '&amp;#xe6e5;', 1, 1, 1, 0),
(86, '提现管理', 85, 'account', 'withdraw', '&#xe6a7;', 2, 1, 1, 0),
(87, '财务对账', 85, 'account', 'finance', '&amp;#xe6a7;', 2, 1, 1, 0),
(88, '系统管理', 0, 'config', 'index', '', 1, 1, 1, 0),
(89, '系统设置', 88, 'config', 'index', '', 2, 1, 1, 0),
(93, '合约管理', 88, 'config', 'application', 'xe6a7', 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `lk_config`
--

CREATE TABLE IF NOT EXISTS `lk_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(150) NOT NULL COMMENT '多个默认值用|分隔',
  `value` text NOT NULL,
  `info` varchar(20) NOT NULL,
  `desc` varchar(250) NOT NULL,
  `tab_id` varchar(20) NOT NULL DEFAULT '0' COMMENT '小分组ID',
  `tab_name` varchar(20) NOT NULL COMMENT '小分组名称',
  `gid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  UNIQUE KEY `name_3` (`name`),
  KEY `gid` (`gid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='配置表' AUTO_INCREMENT=161 ;

--
-- 转存表中的数据 `lk_config`
--

INSERT INTO `lk_config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES
(1, 'site_name', 'type=text&validate=required:true', '五一乐卡有限公司', '网站名称', '网站的名称', '0', '', 1, 0, 1),
(2, 'site_url', 'type=text&validate=required:true,url:true', 'http://lk.com', '网站网址', '请填写网站的网址，包含（http://域名）', '0', '', 1, 0, 1),
(3, 'site_logo', 'type=image&validate=required:true,url:true', 'http://lk.com/upload/images/000/000/001/201806/5b17b226171db.jpg', '网站LOGO', '请填写LOGO的网址，包含（http://域名）', '0', '', 1, 0, 1),
(4, 'site_qq', 'type=text&validate=qq:true', '13157839883', '联系QQ', '前台涉及到需要显示QQ的地方，将显示此值！', '0', '', 1, 0, 1),
(5, 'site_email', 'type=text&validate=email:true', '2931393342@qq.com', '联系邮箱', '前台涉及到需要显示邮箱的地方，将显示此值！', '0', '', 1, 0, 1),
(6, 'site_icp', 'type=text', '23432wsddgf', 'ICP备案号', '可不填写。放置于大陆的服务器，需要网站备案。', '0', '', 1, 0, 1),
(7, 'seo_title', 'type=text&size=80&validate=required:true', '壹商城', 'SEO标题', '一般不超过80个字符！', '0', '', 1, 0, 1),
(8, 'seo_keywords', 'type=text&size=80', '壹商城', 'SEO关键词', '一般不超过100个字符！', '0', '', 1, 0, 1),
(9, 'seo_description', 'type=textarea&rows=4&cols=93', '搭建微信商城的平台,提供店铺、商品、订单、物流、消息和客户的管理模块,同时还提供丰富的营销应用和活动插件。', 'SEO描述', '一般不超过200个字符！', '0', '', 1, 0, 1),
(10, 'site_footer', 'type=textarea&rows=6&cols=93', '<p>京ICP备16035623号 版权所有 © 北京五一乐卡科技有限公司</p>\r\n<p>全国客服热线：400-8932-227</p>', '网站底部信息', '可填写统计、客服等HTML代码，代码前台隐藏不可见！！', '0', '', 1, 0, 1),
(118, 'allow_agent_invite', 'type=radio&value=1:是|0:否', '1', '推广邀请码注册', '', '0', '', 1, 0, 1),
(11, 'register_check_phone', 'type=radio&value=1:验证|0:不验证', '0', '验证手机', '注册时是否发送短信验证手机号码！请确保短信配置成功。', '0', '', 1, 0, 0),
(14, 'trade_pay_cancel_time', 'type=text&size=10&validate=required:true', '30', '默认自动取消订单时间', '默认自动取消订单时间，填0表示关闭该功能', '0', '', 0, 0, 0),
(16, 'trade_sucess_notice', 'type=radio&value=1:通知|0:不通知', '1', '支付成功是否通知用户', '支付成功是否通知用户', '0', '', 1, 0, 0),
(17, 'trade_send_notice', 'type=radio&value=1:通知|0:不通知', '1', '发货是否通知用户', '发货是否通知用户', '0', '', 0, 0, 0),
(18, 'trade_complain_notice', 'type=radio&value=1:通知|0:不通知', '1', '维权通知是否通知用户', '维权通知是否通知用户', '0', '', 0, 0, 0),
(25, 'wx_token', 'type=text', 'lepay', '公众号消息校验Token', '公众号消息校验Token', '0', '', 1, 0, 1),
(26, 'wx_appsecret', 'type=text', 'lepay', '网页授权AppSecret', '网页授权AppSecret', '0', '', 1, 0, 1),
(27, 'wx_appid', 'type=text', 'lepay', '网页授权AppID', '网页授权AppID', '0', '', 1, 0, 1),
(29, 'orderid_prefix', 'type=text&size=20', 'WJ', '订单号前缀', '用户看到的订单号 = 订单号前缀+订单号', '0', '', 1, 0, 1),
(30, 'pay_alipay_open', 'type=radio&value=1:开启|0:关闭', '0', '支付宝支付开启', '', 'alipay', '支付宝', 1, 0, 1),
(31, 'pay_alipay_name', 'type=text&size=80', 'lepay', '帐号', '', 'alipay', '支付宝', 7, 0, 1),
(32, 'pay_alipay_pid', 'type=text&size=80', 'lepay', 'PID', '', 'alipay', '支付宝', 7, 0, 1),
(33, 'pay_alipay_key', 'type=text&size=80', 'lepay', 'KEY', '', 'alipay', '支付宝', 7, 0, 1),
(46, 'pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '微信支付开启', '', 'weixin', '微信支付', 1, 0, 1),
(48, 'pay_weixin_mchid', 'type=text&size=80', '1487812912', 'Mchid', '受理商ID，身份标识', 'weixin', '微信支付', 1, 0, 1),
(49, 'pay_weixin_key', 'type=text&size=80', '1toiqg81tlknwgqiqlk0815ymdvqi1lk', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', 1, 0, 1),
(50, 'wx_encodingaeskey', 'type=text', 'lepay', '公众号消息加解密Key', '公众号消息加解密Key', '0', '', 13, 0, 1),
(51, 'wechat_appid', 'type=text&validate=required:true', 'wx7941ffea4379e027', 'AppID', 'AppID', '0', '', 8, 0, 1),
(52, 'wechat_appsecret', 'type=text&validate=required:true', 'ffe5c6671e2f2b873611883cdf56fd6f', 'AppSecret', 'AppSecret', '0', '', 8, 0, 1),
(53, 'bbs_url', 'type=text&validate=required:false', 'http://lk.com', '交流论坛网址', '商家用于交流的论坛网址，需自行搭建', '0', '', 1, 0, 1),
(54, 'user_store_num_limit', 'type=text&size=20', '-1', '开店数限制', '限制开店数量，-1为不限制', '0', '每个用户最多可开店数限制，0为不限', 1, 0, 1),
(55, 'sync_login_key', '', 'KKgybUkzUqrBGwCTgnAhKmqJmrzfZajJUnZenBZEVQN', '', '', '0', '', 0, 0, 0),
(56, 'is_check_mobile', '', '0', '手机号验证', '手机号验证', '0', '', 0, 0, 0),
(57, 'readme_title', 'type=text', '微商城代理销售服务和结算协议', '开店协议标题', '开店协议标题', '0', '', 1, 0, 1),
(59, 'max_store_drp_level', 'type=text&size=10', '3', '分销级别', '允许分销的最大级别，0或空为无限级分销', '0', '', 12, 0, 1),
(60, 'open_store_drp', 'type=radio&value=1:开启|0:关闭', '1', '分销开关', '', '0', '', 12, 0, 1),
(61, 'open_platform_drp', 'type=radio&value=1:开启|0:关闭', '1', '全网分销', '', '0', '', 12, 0, 1),
(62, 'platform_mall_index_page', 'type=page&validate=required:true,number:true', '6', '平台商城首页内容', '选择一篇微页面作为平台商城首页的内容', '0', '', 11, 1, 1),
(63, 'platform_mall_open', 'type=radio&value=1:开启|0:关闭', '1', '是否开启平台商城', '如果不开启平台商城，则首页将显示为宣传介绍页面！否则显示平台商城', '0', '', 11, 2, 1),
(64, 'theme_index_group', '', 'default', '', '', '0', '', 0, 0, 0),
(65, 'wechat_qrcode', 'type=image&validate=required:true,url:true', 'https://mall.epaikj.com/template/index/default/images/lepaycom.jpg', '公众号二维码', '您的公众号二维码', '0', '', 8, 0, 1),
(66, 'wechat_name', 'type=text&validate=required:true', '共联商家服务中心', '公众号名称', '公众号的名称', '0', '', 8, 0, 1),
(67, 'wechat_sourceid', 'type=text&validate=required:true', 'gh_6f17f72558ae', '公众号原始id', '公众号原始id', '0', '', 8, 0, 1),
(68, 'wechat_id', 'type=text&validate=required:true', 'gh_6f17f72558ae', '微信号', '微信号', '0', '', 8, 0, 1),
(69, 'wechat_token', 'type=text&validate=required:true', 'fa75c60e02f17d9ab8624a4815ca27d8', '微信验证TOKEN', '微信验证TOKEN', '0', '', 8, 0, 0),
(70, 'wechat_encodingaeskey', 'type=text', '35WsxMjCGD3VWvxLYTez4bbC67BsLANC5kusyRu4VmM', 'EncodingAESKey', '公众号消息加解密Key,在使用安全模式情况下要填写该值，请先在管理中心修改，然后填写该值，仅限服务号和认证订阅号', '0', '', 8, 0, 1),
(71, 'wechat_encode', 'type=select&value=0:明文模式|1:兼容模式|2:安全模式', '0', '消息加解密方式', '如需使用安全模式请在管理中心修改，仅限服务号和认证订阅号', '0', '', 8, 0, 1),
(72, 'web_login_show', 'type=select&value=0:两种方式|1:仅允许帐号密码登录|2:仅允许微信扫码登录', '0', '用户登录电脑网站的方式', '用户登录电脑网站的方式', '0', '', 2, 0, 1),
(73, 'store_pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '', 'store_weixin', '商家微信支付', 7, 0, 1),
(74, 'im_appid', '', '44208', '', '', '0', '', 0, 0, 1),
(75, 'im_appkey', '', 'e5dbb021d3e3bd4dfc6fb35deddebcb3', '', '', '0', '', 0, 0, 1),
(76, 'attachment_upload_type', 'type=select&value=0:保存到本服务器|1:保存到又拍云', '0', '附件保存方式', '附件保存方式', 'base', '基础配置', 14, 0, 1),
(77, 'attachment_up_bucket', 'type=text&size=50', 'image-yp', 'BUCKET', 'BUCKET', 'upyun', '又拍云', 14, 0, 1),
(78, 'attachment_up_form_api_secret', 'type=text&size=50', 'frcKOEYeSPP7m12RMkfWjLk+CdE=', 'FORM_API_SECRET', 'FORM_API_SECRET', 'upyun', '又拍云', 14, 0, 1),
(79, 'attachment_up_username', 'type=text&size=50', 'test', '操作员用户名', '操作员用户名', 'upyun', '又拍云', 14, 0, 1),
(80, 'attachment_up_password', 'type=text&size=50', '111111..', '操作员密码', '操作员密码', 'upyun', '又拍云', 14, 0, 1),
(81, 'attachment_up_domainname', 'type=text&size=50', 'pic.mall.epaikj.com', '云存储域名', '云存储域名 不包含http://', 'upyun', '又拍云', 14, 0, 1),
(83, 'notify_appid', '', 'aabbccddeeffgghhiijjkkllmmnn', '', '通知的appid', '0', '', 0, 0, 0),
(84, 'notify_appkey', '', 'aabbccddeeffgghhiijjkkll', '', '通知的KEY', '0', '', 0, 0, 0),
(85, 'is_diy_template', 'type=radio&value=1:开启|0:关闭', '1', '是否使用自定模板', '开启后平台商城首页将不使用微杂志。自定义模板目录/template/wap/default/theme', '0', '', 11, 3, 1),
(86, 'service_key', 'type=text&validate=required:false', 'ecc3642ecf264da914a5ab3048ecc3f2', '服务key', '请填写购买产品时的服务key', '0', '', 1, 0, 1),
(87, 'attachment_upload_unlink', 'type=select&value=0:不删除本地附件|1:删除本地附件', '0', '是否删除本地附件', '当附件存放在远程时，如果本地服务器空间充足，不建议删除本地附件', 'base', '基础配置', 14, 0, 1),
(88, 'syn_domain', 'type=text', 'http://www.lepay.com', '营销活动地址', '部分功能需要调用平台内容，需要用到该网址', '0', '', 8, 0, 1),
(89, 'withdrawal_min_amount', 'type=text&validate=required:true,number:true', '0', '单次提现最低金额', '单次提现最低金额，0为不限', '0', '', 1, 0, 1),
(90, 'encryption', 'type=text', 'lepay', '营销活动key', '与平台对接时需要用到', '0', '', 8, 0, 1),
(91, 'is_allow_comment_control', 'type=select&value=1:允许商户管理评论|2:不允许商户管理评论', '2', '是否允许商户管理评论', '开启后，商户可对评论进行删、改操作', '0', '', 1, 0, 1),
(92, 'ischeck_to_show_by_comment', 'type=select&value=1:不需要审核评论才显示|0:需审核即可显示评论', '1', '评论是否需要审核显示', '开启后，需商家或管理员审核方可显示，反之：不需审核即可显示', '0', '', 1, 0, 1),
(95, 'pc_shopercenter_logo', 'type=image&validate=required:false,url:false', 'http://lk.com/upload/images/000/000/001/201806/5b17b23e38e67.jpg', '商家中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', 1, 0, 1),
(96, 'sales_ratio', 'type=text&size=5&validate=required:true,number:true,maxlength:5,max:100', '0', '商家销售分成比例', '例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除', '0', '', 1, 0, 1),
(98, 'weidian_key', 'type=salt', 'epcms', '微店KEY', '对接微店使用的KEY，请妥善保管', '0', '', 1, 0, 1),
(99, 'ischeck_store', 'type=select&value=1:开店需要审核|0:开店无需审核', '1', '开店是否要审核', '开启后，会员开店需要后台审核通过后，店铺才能正常使用', '0', '', 1, 0, 1),
(100, 'synthesize_store', '', '1', '是否有综合商城', '是否有综合商城', '0', '', 1, 0, 0),
(82, 'web_index_cache', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', 'PC端首页缓存时间', 'PC端首页缓存时间，0为不缓存', '0', '', 1, 0, 1),
(93, 'is_have_activity', 'type=radio&value=1:有|0:没有', '1', '活动', '首页是否需要展示营销活动', '0', '0', 1, 0, 1),
(94, 'pc_usercenter_logo', 'type=image&validate=required:true,url:true', 'http://lk.com/upload/images/000/000/001/201806/5b17b2340d0e9.jpg', 'PC-个人用户中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', 1, 0, 1),
(101, 'sms_topdomain', 'type=text&validate=required:true,url:true', 'https://mall.epaikj.com', '发送短信授权域名', '发送短信授权域名', '0', '平台短信平台', 15, 0, 1),
(102, 'sms_key', 'type=text&validate=required:true', '23662099', '短信key', '短信的key（必填）', '0', '平台短信平台', 15, 0, 1),
(103, 'sms_price', 'type=text&validate=required:true,number:true,maxlength:2', '10', '短信价格(单位:分)', '每条多少分钱(卖给客户的)', '0', '平台短信平台', 15, 0, 1),
(104, 'sms_sign', 'type=text&validate=required:true,maxlength:5', 'E派速达', '短信签名', '短信的前缀（一起发送给客户的）', '0', '平台短信平台', 15, 0, 1),
(105, 'sms_test_mobile', 'type=otext&validate=required:false,mobile:true', '', '测试', '输入手机号以后，然后<a href=''javascript:test_send_sms()''>点击这里</a>进行测试', '0', '平台短信平台', 15, 0, 1),
(106, 'sms_open', 'type=radio&value=1:开启|0:关闭', '1', '短信是否开启', '在以上内容全部完整的情况下，开启有效', '0', '平台短信平台', 15, 0, 1),
(109, 'emergent_mode', 'type=radio&value=1:开启|0:关闭', '0', '紧急模式', '请不要随意开启，开启后会导致无法升级，使用短信等服务（接到五一乐卡紧急通知时可开启此项）。', '0', '平台短信平台', 1, 0, 0),
(107, 'order_return_date', 'type=text&size=2&validate=required:true,number:true,maxlength:2', '7', '退货周期', '确认收货后多长时间内可以退货', '0', '', 1, 0, 1),
(108, 'order_complete_date', 'type=text&size=2&validate=required:true,number:true,maxlength:2', '1', '默认交易完成时间', '发货后，用户一直没有确认收货，此值为发货后的交易完成时间周期', '0', '', 1, 0, 1),
(110, 'weidian_version', '', '0', '微店版本', '微店版本 0 普通 1 对接', '0', '', 1, 0, 0),
(111, 'is_open_wap_login_sms_check', 'type=select&value=0:不开启微信短信注册验证|1:开启短信注册验证', '0', 'wap站注册短信验证', 'wap站注册是否开启短信验证', '0', '', 2, 0, 1),
(120, 'withdraw_limit', 'type=text&size=10&validate=required:true,number:true,min:0', '0', '提现审批金额限制', '大于该金额的提现记录不允许非超级管理员操作，0为不做限制', '0', '', 1, 0, 1),
(121, 'offline_money', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', '订单额度', '需要总管里员审核的订单额度，0表示不需要', '', '订单额度', 17, 0, 1),
(123, 'open_drp_team', 'type=radio&value=1:开启|0:关闭', '1', '分销团队', '是否允许店铺开启分销团队', '0', '', 12, 0, 1),
(122, 'open_drp_degree', 'type=radio&value=1:开启|0:关闭', '1', '分销等级', '', '0', '', 12, 0, 1),
(125, 'is_show_float_menu', 'type=radio&value=1:开启|0:关闭', '0', '是否显示浮动菜单', '开启后，wap店铺首页和商品详情页右下角将会显示浮动菜单', '0', '', 11, 0, 0),
(127, 'is_allow_diy_drp_degree', 'type=radio&value=1:开启|0:关闭', '1', '店铺自定义分销等级', '是否允许供货商自定义分销等级，修改平台设置的默认等级名称，图标', '0', '', 12, 0, 1),
(128, 'open_test_payment', 'type=radio&value=1:开启|0:禁用', '1', '余额支付', '余额支付', 'test_pay', '余额支付', 7, 0, 1),
(129, 'is_need_sub_register', 'type=radio&value=1:开启|0:关闭', '0', '强制pc用户关注后再注册', '开启后，pc注册需要先扫码关注公众号', '0', '', 2, 0, 1),
(130, 'allow_store_public_display', 'type=radio&value=1:是|0:否', '1', '开启店铺综合展示', '', '0', '', 1, 0, 1),
(131, 'allow_account_pwd_confirm', 'type=radio&value=1:是|0:否', '0', '开启我的账号密码确认', '', '0', '', 1, 0, 1),
(133, 'is_change_bankcard_open', 'type=radio&value=1:是|0:否', '0', '店铺修改提现银行卡', '开启后，店铺可以自由修改提现银行卡账号。关闭后用户不能随意修改银行卡账号。', '0', '', 2, 0, 1),
(140, 'user_point_total', 'type=text&size=20&validate=required:true,number:true,maxlength:10', '1000000', '用户积分购买', '当用户所有积分总额（待释放+可用）超过此值，用户不能用现金购物，不能受赠，0表示不限', '', '用户积分购买', 17, 0, 1),
(141, 'store_point_total', 'type=text&size=20&validate=required:true,number:true,maxlength:10', '0', '店铺每日做单限额', '商家每日做单，返送的积分，达到此值，当日就不能再次做单了，0表示不限', '', '店铺每日做单限额', 17, 0, 1),
(142, 'platform_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '平台保证金充值帐户', 'platform_weixin', '微信支付', 16, 0, 1),
(143, 'platform_wechat_appid', 'type=text&size=80', '', 'AppID', 'AppID', 'platform_weixin', '微信支付', 16, 0, 1),
(144, 'platform_wechat_appsecret', 'type=text&size=80', '', 'AppSecret', 'AppSecret', 'platform_weixin', '微信支付', 16, 0, 1),
(145, 'platform_weixin_appid', 'type=text&size=80', '', 'Appid', '微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看。', 'platform_weixin', '微信支付', 16, 0, 1),
(146, 'platform_weixin_mchid', 'type=text&size=80', '', 'Mchid', '受理商ID，身份标识', 'platform_weixin', '微信支付', 16, 0, 1),
(147, 'platform_weixin_key', 'type=text&size=80', '', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'platform_weixin', '微信支付', 16, 0, 1),
(148, 'platform_alipay_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '平台保证金充值帐户', 'platform_alipay', '支付宝', 16, 0, 1),
(149, 'platform_alipay_name', 'type=text&size=80', '', '帐号', '', 'platform_alipay', '支付宝', 16, 0, 1),
(150, 'platform_alipay_pid', 'type=text&size=80', '', 'PID', '', 'platform_alipay', '支付宝', 16, 0, 1),
(151, 'platform_alipay_key', 'type=text&size=80', '', 'KEY', '', 'platform_alipay', '支付宝', 16, 0, 1),
(160, 'is_show_credit', 'type=radio&value=1:是|0:否', '1', '是否展示诚信', '产品详情页是否展示诚信内容', '0', '0', 1, 0, 1),
(134, 'wap_login_bind', 'type=select&value=1:绑定手机号登录|0:静默登录|2:手机号密码登录', '1', 'wap端登录模式', '0:静默登录,1:绑定手机号登录,2:手机号密码登录', '0', '', 2, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `lk_role`
--

CREATE TABLE IF NOT EXISTS `lk_role` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色表',
  `role_name` varchar(255) NOT NULL COMMENT '角色名称',
  `status` int(11) DEFAULT '0' COMMENT '角色状态  0启用  1禁止',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `role_as` int(12) NOT NULL COMMENT '等级',
  `pid` smallint(20) DEFAULT NULL COMMENT '角色识别',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

--
-- 转存表中的数据 `lk_role`
--

INSERT INTO `lk_role` (`id`, `role_name`, `status`, `created_at`, `role_as`, `pid`) VALUES
(4, '超级管理员', 0, NULL, 2, NULL),
(127, 'SaaS', 0, 1529144896, 0, NULL),
(125, '经理', 0, 1528960445, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `lk_roleadmin`
--

CREATE TABLE IF NOT EXISTS `lk_roleadmin` (
  `role_id` mediumint(8) unsigned NOT NULL,
  `admin_id` char(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lk_roleadmin`
--

INSERT INTO `lk_roleadmin` (`role_id`, `admin_id`) VALUES
(4, '40'),
(127, '42'),
(4, '40'),
(127, '42'),
(127, '42'),
(127, '42');

-- --------------------------------------------------------

--
-- 表的结构 `lk_user`
--

CREATE TABLE IF NOT EXISTS `lk_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ep_id` varchar(225) NOT NULL COMMENT 'E派Uid',
  `name` varchar(20) NOT NULL,
  `upwd` char(32) NOT NULL,
  `pay_password` varchar(255) NOT NULL COMMENT '支付密码',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `openid` varchar(50) NOT NULL COMMENT '微信唯一标识',
  `wx_openid` varchar(100) NOT NULL COMMENT '小程序openID',
  `ali_userid` varchar(100) NOT NULL COMMENT '支付宝获取的用户号',
  `app_openid` varchar(50) DEFAULT NULL COMMENT 'app端微信唯一标识',
  `timestamp` int(10) unsigned NOT NULL COMMENT '创建时间',
  `reg_ip` bigint(20) unsigned NOT NULL,
  `last_time` int(10) unsigned NOT NULL,
  `last_ip` bigint(20) unsigned NOT NULL,
  `check_phone` tinyint(1) NOT NULL DEFAULT '0',
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `intro` varchar(500) NOT NULL DEFAULT '' COMMENT '个人签名',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `is_weixin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是微信用户 0否 1是',
  `stores` smallint(6) NOT NULL DEFAULT '0' COMMENT '店铺数量',
  `token` varchar(100) NOT NULL DEFAULT '' COMMENT '微信token',
  `smscount` int(10) NOT NULL DEFAULT '1000' COMMENT '剩余短信数量',
  `point_balance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额（平台积分，可直接当现金使用）',
  `point_unbalance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'E币(平台总积分，不可用的积分)',
  `ep_balance` float(10,4) NOT NULL COMMENT 'e币',
  `point_gift` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台积分，礼物兑换积分',
  `spend_point_gift` decimal(10,2) DEFAULT '0.00' COMMENT '消耗的平台积分',
  `point_used` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已抵现使用的积分',
  `session_id` varchar(50) NOT NULL DEFAULT '' COMMENT 'session id',
  `server_key` varchar(50) NOT NULL DEFAULT '',
  `source_site_url` varchar(200) NOT NULL DEFAULT '' COMMENT '来源网站',
  `payment_url` varchar(200) NOT NULL DEFAULT '' COMMENT '站外支付地址',
  `notify_url` varchar(200) NOT NULL DEFAULT '' COMMENT '通知地址',
  `oauth_url` varchar(200) NOT NULL DEFAULT '' COMMENT '对接网站用户认证地址',
  `is_seller` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是卖家',
  `third_id` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方id',
  `drp_store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户所属店铺',
  `app_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对接应用id',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '后台ID',
  `item_store_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `weixin_bind` tinyint(1) DEFAULT '1' COMMENT '1:需要绑定手机号方可登陆wap，2.无需绑定即可登陆',
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别：1男 2女 0未知',
  `province` varchar(50) NOT NULL COMMENT '省份',
  `city` varchar(50) NOT NULL COMMENT '城市',
  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分总额',
  `invite_admin` int(11) NOT NULL DEFAULT '0' COMMENT '邀请者(总后台代理商)的id',
  `point_given` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已赠送积分',
  `point_received` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已获赠积分',
  `package_id` int(11) unsigned NOT NULL COMMENT '套餐ID',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`) USING BTREE,
  KEY `nickname` (`name`) USING BTREE,
  KEY `openid` (`openid`) USING BTREE,
  KEY `app_openid` (`app_openid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=913 ;

--
-- 转存表中的数据 `lk_user`
--

INSERT INTO `lk_user` (`id`, `ep_id`, `name`, `upwd`, `pay_password`, `phone`, `openid`, `wx_openid`, `ali_userid`, `app_openid`, `timestamp`, `reg_ip`, `last_time`, `last_ip`, `check_phone`, `login_count`, `status`, `intro`, `avatar`, `is_weixin`, `stores`, `token`, `smscount`, `point_balance`, `point_unbalance`, `ep_balance`, `point_gift`, `spend_point_gift`, `point_used`, `session_id`, `server_key`, `source_site_url`, `payment_url`, `notify_url`, `oauth_url`, `is_seller`, `third_id`, `drp_store_id`, `app_id`, `admin_id`, `item_store_id`, `type`, `weixin_bind`, `sex`, `province`, `city`, `point_total`, `invite_admin`, `point_given`, `point_received`, `package_id`) VALUES
(1, '2', '22', '2', '2', '2', '2', '2', '', NULL, 0, 0, 0, 0, 0, 0, 1, '', '', 0, 0, '', 1000, 0.00, 0.00, 0.0000, 0.00, '0.00', '0.00', '', '', '', '', '', '', 0, '', 0, 0, 0, 0, 0, 1, 2, '', '', '0.00', 0, '0.00', '0.00', 0),
(911, '', '1111', '96e79218965eb72c92a549dd5a330112', '', '', '', '', '', NULL, 0, 0, 0, 0, 0, 0, 1, '', '', 0, 0, '', 1000, 0.00, 0.00, 0.0000, 0.00, '0.00', '0.00', '', '', '', '', '', '', 0, '', 0, 0, 0, 0, 0, 1, 0, '', '', '0.00', 0, '0.00', '0.00', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
