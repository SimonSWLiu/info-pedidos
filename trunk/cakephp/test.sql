-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 03 月 25 日 10:19
-- 服务器版本: 5.1.39
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `dbtests`
--

DROP TABLE IF EXISTS `dbtests`;
CREATE TABLE IF NOT EXISTS `dbtests` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(255) NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `dbtests`
--

INSERT INTO `dbtests` (`test_id`, `test_name`) VALUES
(1, 'abc');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `O_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `OrderDate` date NOT NULL,
  `OrderPrice` float NOT NULL,
  `Customer` varchar(50) NOT NULL,
  PRIMARY KEY (`O_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`O_Id`, `OrderDate`, `OrderPrice`, `Customer`) VALUES
(1, '2010-05-11', 1000, 'Bush'),
(2, '2010-05-02', 1600, 'Carter'),
(3, '2010-05-02', 700, 'Bush'),
(4, '2010-05-02', 300, 'Bush'),
(5, '2010-03-09', 2000, 'Adams'),
(6, '2010-02-23', 100, 'Carter');

-- --------------------------------------------------------

--
-- 表的结构 `pinyin`
--

DROP TABLE IF EXISTS `pinyin`;
CREATE TABLE IF NOT EXISTS `pinyin` (
  `zi` varchar(100) NOT NULL,
  `pinyin` varchar(100) NOT NULL,
  PRIMARY KEY (`zi`,`pinyin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `pinyin`
--

INSERT INTO `pinyin` (`zi`, `pinyin`) VALUES
('aa', 'daf'),
('xsasda', 'dfadsfef');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`) VALUES
(1, 'zaphod', 'secret', 'beeblebrox@heartofgold.hhg', 'zaphod', 'beeblebrox'),
(2, 'benson', 'aaa', 'aaa', 'aaa', 'aaa');
