-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 03 月 16 日 10:44
-- 服务器版本: 5.1.39
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `pedidos`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `c_name` varchar(100) NOT NULL COMMENT '分类名称',
  `rid` smallint(5) unsigned NOT NULL COMMENT '所属餐馆',
  PRIMARY KEY (`cid`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单分类信息表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`cid`, `c_name`, `rid`) VALUES
(1, '套餐', 1),
(2, '单品', 1),
(3, '粉', 1),
(4, '小食', 1),
(5, '炖汤', 1),
(6, '碟头饭', 6);

-- --------------------------------------------------------

--
-- 表的结构 `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` varchar(50) NOT NULL COMMENT '用户email',
  `pwd` varchar(32) NOT NULL COMMENT '用户密码',
  `name` varchar(30) NOT NULL COMMENT '用户名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态：0：未通过；1：通过',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '权限：1：su；2：admin；3：下单员；4：普通会员',
  `balance` float NOT NULL DEFAULT '0' COMMENT '用户余额',
  `ordering_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录用户订餐次数（每次订餐加一）',
  `delivery_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录用户缴外卖费的次数（每次缴费加一）',
  `delivery_ratio` float unsigned NOT NULL DEFAULT '1' COMMENT '缴付外卖费的比率：delivery_count / ordering_count',
  PRIMARY KEY (`mid`),
  KEY `email` (`email`,`name`),
  KEY `ordering_count` (`ordering_count`,`delivery_count`),
  KEY `delivery_ratio` (`delivery_ratio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `members`
--

INSERT INTO `members` (`mid`, `email`, `pwd`, `name`, `status`, `level`, `balance`, `ordering_count`, `delivery_count`, `delivery_ratio`) VALUES
(1, 'cecilia.zhang@infothinker.com', '4530df028a60b0949da2d1d9de885143', 'Cecilia', 0, 2, 0, 1, 1, 1),
(2, 'benson.chen@infothinker.com', 'e10adc3949ba59abbe56e057f20f883e', '泊成', 0, 1, 0, 1, 1, 1),
(3, 'jiachun.ke@infothinker.com', '1835526ac43643a0e18f8c6ceb6f25bd', '柯佳春', 0, 4, 0, 1, 0, 1),
(4, 'yonghui.li@infothinker.com', '014eaedb4c4dfc9afe3dd4d1c162bb2e', '李永辉', 0, 4, 0, 0, 0, 1),
(5, 'cathy.huang@infothinker.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'cathy', 0, 2, 0, 0, 0, 1),
(6, 'webb.peng@infothinker.com', '670b14728ad9902aecba32e22fa4f6bd', '三文二', 0, 4, 0, 0, 0, 1),
(7, 'john.chen@infothinker.com', 'ca371f09d8e7f10196ae6d4d50820bbf', '陈均卓', 0, 4, 0, 0, 0, 1),
(8, 'xuhanjie@live.com', '99754106633f94d350db34d548d6091a', 'xuhanjie', 0, 4, 0, 0, 0, 1),
(9, 'yuke.lai@infothinker.com', '8542516f8870173d7d1daba1daaaf0a1', 'yuke', 0, 4, 0, 0, 0, 1),
(10, 'jerry@jerry-chan.com', '8e2ae40c29477630b576f5a0fc13a817', 'jerry', 0, 4, 0, 0, 0, 1),
(11, 'test@a.com', 'e10adc3949ba59abbe56e057f20f883e', 'test', 0, 4, 0, 0, 0, 1),
(12, 'cererd.long@infothinker.com', 'e10adc3949ba59abbe56e057f20f883e', '龙磊', 0, 4, 0, 0, 0, 1),
(13, 'cererd.long@infothinker.com', '96e79218965eb72c92a549dd5a330112', 'cererd', 0, 4, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `m_num` varchar(20) NOT NULL DEFAULT '' COMMENT '菜式num',
  `m_name` varchar(100) NOT NULL COMMENT '菜式名称',
  `m_price` float NOT NULL COMMENT '价钱',
  `m_note` varchar(255) NOT NULL DEFAULT '' COMMENT '菜式备注',
  `cat_id` int(10) unsigned NOT NULL COMMENT '类别id',
  `restaurant_id` int(10) unsigned NOT NULL COMMENT '该菜色所属餐馆的id',
  `delivery_charges` float unsigned NOT NULL DEFAULT '0' COMMENT '外卖费',
  PRIMARY KEY (`menu_id`),
  KEY `m_name` (`m_name`,`m_price`),
  KEY `cat_id` (`cat_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单' AUTO_INCREMENT=88 ;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`menu_id`, `m_num`, `m_name`, `m_price`, `m_note`, `cat_id`, `restaurant_id`, `delivery_charges`) VALUES
(1, '', '杨梅汁鸡腿扒套餐', 25, '配花旗参清炖瘦肉汤/港式奶茶', 1, 1, 0),
(2, '', '秘制蝴蝶骨套餐', 25, '', 1, 1, 0),
(3, '', '怡香卤鱼套餐', 23, '', 1, 1, 0),
(4, '', '酱汁梅菜扣肉套餐', 23, '', 1, 1, 0),
(5, '', '星洲肉骨茶套餐', 25, '', 1, 1, 0),
(6, '', '叉烧三宝套餐', 25, '', 1, 1, 0),
(7, '', '玫瑰鸭套餐', 23, '', 1, 1, 0),
(8, '', '咖喱皇鸡腿肉套餐', 23, '', 1, 1, 0),
(9, '', '虾子葱油鸡套餐', 22, '', 1, 1, 0),
(10, '', '陈香老娘叉烧套餐', 19, '', 1, 1, 0),
(11, '', '秘制蝴蝶骨', 21.5, '', 2, 1, 0),
(12, '', '杨梅汁鸡腿扒', 18, '', 2, 1, 0),
(13, '', '怡香卤鱼', 17, '', 2, 1, 0),
(14, '', '酱汁梅菜扣肉', 17, '', 2, 1, 0),
(15, '', '星洲肉骨茶', 21, '', 2, 1, 0),
(16, '', '叉烧三宝', 20, '', 2, 1, 0),
(17, '', '玫瑰鸭', 17, '', 2, 1, 0),
(18, '', '咖喱皇鸡腿肉', 18, '', 2, 1, 0),
(19, '', '虾子葱油鸡', 17, '', 2, 1, 0),
(20, '', '陈香老娘叉烧', 16.5, '', 2, 1, 0),
(21, '', '丽人常餐A', 18, '', 1, 1, 0),
(22, '', '丽人常餐B', 17, '', 1, 1, 0),
(23, '', '丽人常餐C', 16, '', 1, 1, 0),
(24, '', '蒜香鸡肉排骨饭', 19, '含青菜', 2, 1, 0),
(36, '', '咸鱼鸡粒炒饭', 15, '', 2, 1, 0),
(26, '', '台湾卤肉饭', 17, '含青菜', 2, 1, 0),
(37, '', '菜粒蛋炒饭', 8, '', 2, 1, 0),
(28, '', '特色卤汁排骨饭', 16, '含青菜', 2, 1, 0),
(38, '', '黑椒鸡腿肉饭', 9, '', 2, 1, 0),
(30, '', '香露豉油鸡饭', 16, '含青菜', 2, 1, 0),
(39, '', '梅菜蒸肉饼饭', 8, '', 2, 1, 0),
(32, '', '蜜汁叉烧饭', 15, '含青菜', 2, 1, 0),
(40, '', '面酱蒸排骨花肉饭', 15, '含菜', 2, 1, 0),
(34, '', '果汁番茄猪扒饭', 15, '含青菜', 2, 1, 0),
(41, '', '酸菜红烧肉饭', 14, '菜', 2, 1, 0),
(42, '', '宫保酱鸡丁饭', 14, '菜', 2, 1, 0),
(43, '', '椒酱茄粒牛肉饭', 13, '菜', 2, 1, 0),
(44, '', '韭菜肉丝炒蛋饭', 13, '菜', 2, 1, 0),
(45, '', '雪菜肉粒香干饭', 11, '菜', 2, 1, 0),
(46, '', '紫菜鱼板鱼汤米线', 15, '大', 3, 1, 0),
(47, '', '紫菜鱼板鱼汤米线', 11, '小', 3, 1, 0),
(48, '', '鱼茸鱼汤米线', 15, '大', 3, 1, 0),
(49, '', '鱼茸鱼汤米线', 11, '小', 3, 1, 0),
(50, '', '黑椒鱼卷鱼汤米线', 15, '大', 3, 1, 0),
(51, '', '黑椒鱼卷鱼汤米线	', 12, '小', 3, 1, 0),
(52, '', '玉燕饺鱼汤米线', 13, '大', 3, 1, 0),
(53, '', '玉燕饺鱼汤米线	', 9.5, '小', 3, 1, 0),
(54, '', '顺德鱼饼鱼汤米线', 13, '大', 3, 1, 0),
(55, '', '顺德鱼饼鱼汤米线	', 9.5, '小', 3, 1, 0),
(56, '', '手打鱼腐鱼汤米线', 13, '大', 3, 1, 0),
(57, '', '手打鱼腐鱼汤米线	', 9.5, '小', 3, 1, 0),
(58, '', '三色鱼汤米线', 11, '大', 3, 1, 0),
(59, '', '三色鱼汤米线	', 8, '小', 3, 1, 0),
(60, '', '杨梅汁鸡柳捞米线', 15, '', 3, 1, 0),
(61, '', '咖喱鸡腿肉捞米线', 14, '', 3, 1, 0),
(62, '', '果汁猪扒捞米线', 13, '', 3, 1, 0),
(63, '', '酱皇捞米线', 11, '', 3, 1, 0),
(64, '', '星洲肉骨茶', 17, '', 5, 1, 0),
(65, '', '花旗参清炖瘦肉汁', 13, '', 5, 1, 0),
(66, '', '石蔘根元肉炖鸡汤', 11, '', 5, 1, 0),
(67, '', '菜胆花菇炖螺片汤', 10, '', 5, 1, 0),
(68, '', '五叶神炖龙骨汤', 9, '', 5, 1, 0),
(69, '', '麻婆豆腐饭', 12, '辣', 6, 6, 0),
(70, '', '五柳蛋饭', 12, '', 6, 6, 0),
(71, '', '土豆丝牛肉饭', 12, '', 6, 6, 0),
(72, '', '榨菜肉片饭', 12, '', 6, 6, 0),
(73, '', '香干肉片饭', 12, '', 6, 6, 0),
(74, '', '咖喱薯仔鸡饭', 12, '', 6, 6, 0),
(75, '', '红烧豆腐肉丝饭', 12, '', 6, 6, 0),
(76, '', '酸菜猪肚丝饭', 13, '', 6, 6, 0),
(77, '', '烧汁猪柳饭', 13, '', 6, 6, 0),
(78, '', '葡汁猪柳饭', 13, '', 6, 6, 0),
(79, '', '黑椒牛柳饭', 13, '', 6, 6, 0),
(80, '', '鲜菇牛肉饭', 13, '', 6, 6, 0),
(81, '', '香波生炒骨饭', 13, '', 6, 6, 0),
(82, '', '青瓜牛肉饭', 13, '', 6, 6, 0),
(83, '', '支竹炆鸭饭', 13, '', 6, 6, 0),
(84, '', '鲍汁炆鱼腩饭', 13, '', 6, 6, 0),
(85, '', '茄汁鱼块饭', 13, '', 6, 6, 0),
(86, '', '菠萝鸡丝饭', 13, '', 6, 6, 0),
(87, '', '滑蛋牛肉饭', 13, '', 6, 6, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pedidos_log`
--

DROP TABLE IF EXISTS `pedidos_log`;
CREATE TABLE IF NOT EXISTS `pedidos_log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `mid` int(10) unsigned NOT NULL COMMENT '用户id',
  `edit_time` int(10) unsigned NOT NULL COMMENT '日志录入时间',
  `year` smallint(5) unsigned NOT NULL COMMENT '年',
  `month` tinyint(3) unsigned NOT NULL COMMENT '月',
  `day` tinyint(3) unsigned NOT NULL COMMENT '日',
  `hour` tinyint(3) unsigned NOT NULL COMMENT '时',
  `minute` tinyint(3) unsigned NOT NULL COMMENT '分',
  `rid` int(10) unsigned NOT NULL COMMENT '餐厅id',
  `r_name` varchar(100) NOT NULL DEFAULT '' COMMENT '餐厅名',
  `cid` int(10) unsigned NOT NULL COMMENT '类别id',
  `c_name` varchar(100) NOT NULL DEFAULT '' COMMENT '类别名',
  `menu_id` int(10) unsigned NOT NULL COMMENT '菜单id',
  `dish_name` varchar(100) NOT NULL COMMENT '菜式名',
  `unit_price` float NOT NULL COMMENT '单价',
  `dish_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '数量',
  `total_price` float NOT NULL COMMENT '总价',
  `note` text NOT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态：0：未处理；1、通过；2、不通过',
  `type_tag` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型：0：菜单；1：外卖费',
  PRIMARY KEY (`log_id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `pedidos_log`
--

INSERT INTO `pedidos_log` (`log_id`, `mid`, `edit_time`, `year`, `month`, `day`, `hour`, `minute`, `rid`, `r_name`, `cid`, `c_name`, `menu_id`, `dish_name`, `unit_price`, `dish_count`, `total_price`, `note`, `status`, `type_tag`) VALUES
(1, 1, 1299642130, 2011, 3, 9, 11, 29, 1, '大西豪', 1, '套餐', 1, '杨梅汁鸡腿扒套餐', 25, 1, 25, '', 1, 0),
(2, 1, 1299642240, 2011, 3, 9, 11, 44, 0, '0', 0, '0', 0, '0', 0, 0, 1, '外卖费', 1, 1),
(3, 2, 1299658011, 2011, 3, 9, 16, 6, 1, '大西豪', 1, '套餐', 1, '杨梅汁鸡腿扒套餐', 25, 1, 25, '', 1, 0),
(4, 3, 1299658396, 2011, 3, 9, 16, 13, 1, '大西豪', 2, '单品', 11, '秘制蝴蝶骨', 21.5, 1, 21.5, '', 1, 0),
(5, 8, 1299658413, 2011, 3, 9, 16, 13, 1, '大西豪', 2, '单品', 11, '秘制蝴蝶骨', 21.5, 1, 21.5, '', 0, 0),
(6, 8, 1299658420, 2011, 3, 9, 16, 13, 1, '大西豪', 1, '套餐', 1, '杨梅汁鸡腿扒套餐', 25, 1, 25, '', 0, 0),
(7, 2, 1299658457, 2011, 3, 9, 16, 14, 0, '0', 0, '0', 0, '0', 0, 0, 1, '外卖费', 1, 1),
(8, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 1, '杨梅汁鸡腿扒套餐', 25, 1, 25, '', 0, 0),
(9, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 2, '秘制蝴蝶骨套餐', 25, 4, 100, '', 0, 0),
(10, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 3, '怡香卤鱼套餐', 23, 9, 207, '', 0, 0),
(11, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 4, '酱汁梅菜扣肉套餐', 23, 2, 46, '', 0, 0),
(12, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 6, '叉烧三宝套餐', 25, 3, 75, '', 0, 0),
(13, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 9, '虾子葱油鸡套餐', 22, 1, 22, '', 0, 0),
(14, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 5, '星洲肉骨茶套餐', 25, 1, 25, '', 0, 0),
(15, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 2, '单品', 11, '秘制蝴蝶骨', 21.5, 13, 279.5, '', 0, 0),
(16, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 10, '陈香老娘叉烧套餐', 19, 1, 19, '', 0, 0),
(17, 12, 1299663371, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 8, '咖喱皇鸡腿肉套餐', 23, 1, 23, '', 0, 0),
(18, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 2, '秘制蝴蝶骨套餐', 25, 1, 25, '', 0, 0),
(19, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 3, '怡香卤鱼套餐', 23, 1, 23, '', 0, 0),
(20, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 4, '酱汁梅菜扣肉套餐', 23, 1, 23, '', 0, 0),
(21, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 7, '玫瑰鸭套餐', 23, 6, 138, '', 0, 0),
(22, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 8, '咖喱皇鸡腿肉套餐', 23, 3, 69, '', 0, 0),
(23, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 9, '虾子葱油鸡套餐', 22, 1, 22, '', 0, 0),
(24, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 2, '单品', 11, '秘制蝴蝶骨', 21.5, 15, 322.5, '', 0, 0),
(25, 12, 1299663391, 2011, 3, 9, 17, 36, 1, '大西豪', 1, '套餐', 10, '陈香老娘叉烧套餐', 19, 1, 19, '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `recharge_log`
--

DROP TABLE IF EXISTS `recharge_log`;
CREATE TABLE IF NOT EXISTS `recharge_log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `mid` int(10) unsigned NOT NULL COMMENT '会员id',
  `charge_money` float NOT NULL COMMENT '充值金额',
  `recharge_time` int(11) NOT NULL COMMENT '充值时间',
  PRIMARY KEY (`log_id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `recharge_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `rid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '餐馆id',
  `r_name` varchar(100) NOT NULL COMMENT '餐馆名称',
  `delivery_charges` float unsigned NOT NULL DEFAULT '0' COMMENT '外卖费',
  PRIMARY KEY (`rid`),
  KEY `r_name` (`r_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='餐馆信息' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `restaurant`
--

INSERT INTO `restaurant` (`rid`, `r_name`, `delivery_charges`) VALUES
(1, '大西豪', 1),
(5, '华辉', 5),
(6, '壹鼎', 0);
