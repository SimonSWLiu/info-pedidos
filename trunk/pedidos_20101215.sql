-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 12 月 15 日 15:36
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单分类信息表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`cid`, `c_name`, `rid`) VALUES
(1, '12', 6),
(2, '套餐', 1);

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
  PRIMARY KEY (`mid`),
  KEY `email` (`email`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `members`
--

INSERT INTO `members` (`mid`, `email`, `pwd`, `name`, `status`, `level`) VALUES
(1, 'benson.chen@infothinker.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 0, 3),
(2, 'benson.rc86@gmail.com', '13550d8cf326289a5f7e368869b1be72', 'benson', 0, 3);

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `m_num` varchar(20) DEFAULT NULL COMMENT '菜式num',
  `m_name` varchar(100) NOT NULL COMMENT '菜式名称',
  `m_price` float NOT NULL COMMENT '价钱',
  `m_note` varchar(255) DEFAULT NULL COMMENT '菜式备注',
  PRIMARY KEY (`menu_id`),
  KEY `m_name` (`m_name`,`m_price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `menu`
--


-- --------------------------------------------------------

--
-- 表的结构 `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `rid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '餐馆id',
  `r_name` varchar(100) NOT NULL COMMENT '餐馆名称',
  PRIMARY KEY (`rid`),
  KEY `r_name` (`r_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='餐馆信息' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `restaurant`
--

INSERT INTO `restaurant` (`rid`, `r_name`) VALUES
(1, '大西豪'),
(2, '华辉'),
(7, 'test1'),
(6, '表叔'),
(8, 'test2'),
(9, 'test3'),
(10, 'test4');
