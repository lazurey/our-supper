-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 07 月 04 日 04:15
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db name`
--

-- --------------------------------------------------------

--
-- 表的结构 `supperplace`
--

CREATE TABLE IF NOT EXISTS `supperplace` (
  `place_id` int(4) NOT NULL,
  `place_name` varchar(64) NOT NULL,
  `project_name` varchar(64) NOT NULL,
  `project_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  PRIMARY KEY (`place_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `supperplace`
--

INSERT INTO `supperplace` (`place_id`, `place_name`, `project_name`, `project_id`, `group_id`) VALUES
(101, '88号大厅开发团队', '上海CRM', 21, 88),
(102, '88号大厅测试团队', '上海CRM', 21, 88),
(103, '88号割接组办公室', '上海CRM', 21, 88),
(104, '88号经理室', '上海CRM', 21, 88),
(105, '88号接口组办公室', '上海CRM', 21, 88),
(106, '88号专项组办公室', '上海CRM', 21, 88),
(107, '88号门口同步组办公室', '上海CRM', 21, 88),
(108, '88号其他办公室人员', '上海CRM', 21, 88),
(109, '56号楼A1区域', '上海CRM', 21, 56),
(110, '56号楼大会议室', '上海CRM', 21, 56),
(111, '56号楼大厅A2区域', '上海CRM', 21, 56),
(112, '56号楼大厅A3区域', '上海CRM', 21, 56),
(113, '56号楼大厅A4区域', '上海CRM', 21, 56),
(114, '56号楼大厅A5区域', '上海CRM', 21, 56),
(115, '56号楼大厅A6区域', '上海CRM', 21, 56),
(116, '56号楼大厅A7区域', '上海CRM', 21, 56);
