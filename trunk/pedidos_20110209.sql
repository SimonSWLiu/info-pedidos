-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2011 at 04:29 PM
-- Server version: 5.1.39
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pedidos`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
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
-- Dumping data for table `category`
--

INSERT INTO `category` (`cid`, `c_name`, `rid`) VALUES
(1, '套餐', 1),
(2, '单品', 1),
(5, '早餐', 1),
(4, '汤水', 1),
(6, '粥粉', 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
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
  PRIMARY KEY (`mid`),
  KEY `email` (`email`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mid`, `email`, `pwd`, `name`, `status`, `level`, `balance`) VALUES
(1, 'benson.chen@infothinker.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', 0, 1, 185.5),
(2, 'benson.rc86@gmail.com', '13550d8cf326289a5f7e368869b1be72', 'benson', 0, 3, 58.8);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
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
  PRIMARY KEY (`menu_id`),
  KEY `m_name` (`m_name`,`m_price`),
  KEY `cat_id` (`cat_id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `m_num`, `m_name`, `m_price`, `m_note`, `cat_id`, `restaurant_id`) VALUES
(1, '', '玉燕饺米线', 15, '小', 6, 1),
(2, '', '蝴蝶骨套餐', 25, '蝴蝶骨套餐+汤一个', 1, 1),
(3, '', '老娘叉烧套餐', 19, '老娘叉烧饭+汤一个', 1, 1),
(4, '', '老娘叉烧饭', 15, '', 2, 1),
(5, '', '蝴蝶骨饭', 19, '', 2, 1),
(6, '', '杨梅汁鸡扒饭', 18, '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos_log`
--

DROP TABLE IF EXISTS `pedidos_log`;
CREATE TABLE IF NOT EXISTS `pedidos_log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `mid` int(10) unsigned NOT NULL COMMENT '用户id',
  `edit_time` int(10) unsigned NOT NULL COMMENT '日志录入时间',
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
  PRIMARY KEY (`log_id`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pedidos_log`
--

INSERT INTO `pedidos_log` (`log_id`, `mid`, `edit_time`, `rid`, `r_name`, `cid`, `c_name`, `menu_id`, `dish_name`, `unit_price`, `dish_count`, `total_price`, `note`, `status`) VALUES
(1, 1, 1296811788, 1, '大西豪', 1, '套餐', 2, '蝴蝶骨套餐', 25, 1, 25, '', 1),
(2, 1, 1297095311, 1, '大西豪', 6, '粥粉', 1, '玉燕饺米线', 15, 1, 15, '', 1),
(3, 1, 1297180373, 1, '大西豪', 1, '套餐', 3, '老娘叉烧套餐', 19, 1, 19, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `recharge_log`
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
-- Dumping data for table `recharge_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `rid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '餐馆id',
  `r_name` varchar(100) NOT NULL COMMENT '餐馆名称',
  PRIMARY KEY (`rid`),
  KEY `r_name` (`r_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='餐馆信息' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rid`, `r_name`) VALUES
(1, '大西豪'),
(2, '华辉'),
(3, '生辉美食'),
(4, '大家乐'),
(5, '肯德基'),
(6, '必胜客'),
(7, '麦当劳');
