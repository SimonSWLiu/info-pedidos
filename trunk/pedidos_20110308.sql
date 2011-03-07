-- phpMyAdmin SQL Dump
-- version 3.3.9.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 03 月 07 日 16:21
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单分类信息表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`cid`, `c_name`, `rid`) VALUES
(1, '套餐', 1),
(2, '单品', 1),
(5, '早餐', 1),
(4, '汤水', 1),
(6, '粥粉', 1),
(7, '饭', 2);

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
  `level` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '权限：1：su；2：admin；3：普通会员',
  `balance` float NOT NULL DEFAULT '0' COMMENT '用户余额',
  `ordering_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录用户订餐次数（每次订餐加一）',
  `delivery_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录用户缴外卖费的次数（每次缴费加一）',
  `delivery_ratio` float unsigned NOT NULL DEFAULT '1' COMMENT '缴付外卖费的比率：delivery_count / ordering_count',
  PRIMARY KEY (`mid`),
  KEY `email` (`email`,`name`),
  KEY `ordering_count` (`ordering_count`,`delivery_count`),
  KEY `delivery_ratio` (`delivery_ratio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `members`
--

INSERT INTO `members` (`mid`, `email`, `pwd`, `name`, `status`, `level`, `balance`, `ordering_count`, `delivery_count`, `delivery_ratio`) VALUES
(1, 'benson.chen@infothinker.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', 0, 1, 80, 0, 0, 1),
(2, 'benson.rc86@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'benson', 0, 3, 46.3, 0, 0, 1),
(3, 'test1@mail.com', '21232f297a57a5a743894a0e4a801fc3', 'test1', 0, 3, 64, 0, 0, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`menu_id`, `m_num`, `m_name`, `m_price`, `m_note`, `cat_id`, `restaurant_id`, `delivery_charges`) VALUES
(1, '', '玉燕饺米线', 15, '小', 6, 1, 0),
(2, '', '蝴蝶骨套餐', 25, '蝴蝶骨套餐+汤一个', 1, 1, 0),
(3, '', '老娘叉烧套餐', 19, '老娘叉烧饭+汤一个', 1, 1, 0),
(4, '', '老娘叉烧饭', 15, '', 2, 1, 0),
(5, '', '蝴蝶骨饭', 19, '', 2, 1, 0),
(6, '', '杨梅汁鸡扒饭', 18, '', 2, 1, 0),
(7, '', '梅菜肉饼饭', 11, '', 7, 2, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `pedidos_log`
--

INSERT INTO `pedidos_log` (`log_id`, `mid`, `edit_time`, `year`, `month`, `day`, `hour`, `minute`, `rid`, `r_name`, `cid`, `c_name`, `menu_id`, `dish_name`, `unit_price`, `dish_count`, `total_price`, `note`, `status`, `type_tag`) VALUES
(1, 1, 1296811788, 2011, 2, 11, 10, 31, 1, '大西豪', 1, '套餐', 2, '蝴蝶骨套餐', 25, 1, 25, '', 1, 0),
(2, 1, 1297095311, 2011, 2, 11, 10, 59, 1, '大西豪', 6, '粥粉', 1, '玉燕饺米线', 15, 1, 15, '', 1, 0),
(3, 1, 1297180373, 2011, 2, 11, 11, 29, 1, '大西豪', 1, '套餐', 3, '老娘叉烧套餐', 19, 1, 19, '', 0, 0),
(4, 1, 1297392671, 2011, 2, 11, 11, 30, 1, '大西豪', 1, '套餐', 3, '老娘叉烧套餐', 19, 1, 19, '', 0, 0),
(5, 1, 1297407634, 2011, 2, 11, 11, 0, 2, '华辉', 7, '饭', 7, '梅菜肉饼饭', 11, 1, 11, '', 0, 0),
(6, 2, 1297417127, 2011, 2, 11, 17, 38, 1, '大西豪', 1, '套餐', 2, '蝴蝶骨套餐', 25, 1, 25, '', 0, 0),
(7, 2, 1297417127, 2011, 2, 15, 10, 10, 1, '大西豪', 1, '套餐', 3, '老娘叉烧套餐', 19, 1, 19, '', 0, 0),
(8, 1, 1297417505, 2011, 2, 16, 10, 45, 2, '华辉', 7, '饭', 7, '梅菜肉饼饭', 11, 1, 11, '', 1, 0),
(9, 2, 1297417639, 2011, 2, 16, 11, 29, 2, '华辉', 7, '饭', 7, '梅菜肉饼饭', 11, 1, 11, '', 1, 0),
(10, 2, 1297865686, 2011, 2, 16, 22, 14, 2, '华辉', 0, '', 0, '', 1, 1, 1, '外卖费', 1, 0),
(11, 1, 1297869094, 2011, 2, 16, 23, 11, 2, '华辉', 0, '', 0, '', 0.5, 1, 0.5, '外卖费', 1, 0),
(12, 2, 1297869094, 2011, 2, 24, 10, 11, 2, '华辉', 0, '', 0, '', 0.5, 1, 0.5, '外卖费', 1, 0),
(13, 1, 1297947078, 2011, 3, 3, 10, 59, 1, '大西豪', 1, '套餐', 3, '老娘叉烧套餐', 19, 1, 19, '65477', 0, 0),
(14, 3, 1298901360, 2011, 3, 3, 10, 56, 1, '大西豪', 1, '套餐', 3, '老娘叉烧套餐', 19, 1, 20, '1蚊额外附加', 1, 0),
(15, 3, 1298901482, 2011, 3, 3, 21, 58, 1, '大西豪', 0, '', 0, '', 2, 1, 2, '外卖费', 1, 0),
(16, 1, 1299081520, 2011, 3, 7, 11, 28, 2, '华辉', 7, '饭', 7, '梅菜肉饼饭', 11, 1, 11, '', 0, 0),
(17, 1, 1299081520, 2011, 3, 7, 11, 28, 1, '大西豪', 6, '粥粉', 1, '玉燕饺米线', 15, 1, 15, '', 0, 0),
(18, 3, 1299081594, 2011, 3, 7, 10, 59, 1, '大西豪', 6, '粥粉', 1, '玉燕饺米线', 15, 1, 15, '', 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='餐馆信息' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `restaurant`
--

INSERT INTO `restaurant` (`rid`, `r_name`, `delivery_charges`) VALUES
(1, '大西豪', 2),
(2, '华辉', 1),
(3, '生辉美食', 0),
(4, '大家乐', 0),
(5, '肯德基', 0),
(6, '必胜客', 0),
(7, '麦当劳', 0),
(8, '仁信', 2);

-- --------------------------------------------------------

--
-- 表的结构 `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `test_f` float NOT NULL,
  PRIMARY KEY (`test_f`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `test`
--

INSERT INTO `test` (`test_f`) VALUES
(1.2),
(1.22);
