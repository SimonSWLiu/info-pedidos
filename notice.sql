-- phpMyAdmin SQL Dump
-- version 3.3.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2011 at 12:54 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.5

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
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE IF NOT EXISTS `notice` (
  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `notice_member` int(10) unsigned NOT NULL COMMENT '发公告人的id',
  `notice_content` varchar(1000) NOT NULL COMMENT '公告内容',
  `notice_date` int(11) NOT NULL COMMENT '公告时间（时间戳）',
  `notice_status` tinyint(1) unsigned NOT NULL COMMENT '公告的状态。0：不公布；1：公布',
  PRIMARY KEY (`notice_id`),
  KEY `notice_member` (`notice_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保存公告表' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notice`
--

