-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-12-14 11:32:47
-- 服务器版本： 5.6.17
-- PHP Version: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cherrymanager`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_rules_right`(IN `big_name` VARCHAR(255) CHARSET utf8, IN `big_rgt` INT, IN `big_deep` INT, IN `id` INT)
BEGIN
				DECLARE t_error INTEGER DEFAULT 0;  
				DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
				START TRANSACTION;  
				UPDATE rules_data set lid=lid+2 WHERE lid>big_rgt;     
				UPDATE rules_data set rid=rid+2 WHERE rid>big_rgt;
				INSERT INTO rules_data set lid=big_rgt+1, rid=big_rgt+2, name=big_name, deep=big_deep, pid=id;
				IF t_error = 1 THEN  
				ROLLBACK;  
				ELSE
				COMMIT;
				END IF;  
				END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_rules_sub`(IN `big_name` VARCHAR(255) CHARSET utf8, IN `big_lft` INT, IN `big_deep` INT, IN `id` INT)
BEGIN
				DECLARE t_error INTEGER DEFAULT 0;  
				DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
				START TRANSACTION;  
				UPDATE rules_data set lid=lid+2 WHERE lid>big_lft;     
				UPDATE rules_data set rid=rid+2 WHERE rid>big_lft;
				INSERT INTO rules_data set lid=big_lft+1, rid=big_lft+2, name=big_name, deep=big_deep+1, pid=id;
				IF t_error = 1 THEN  
				ROLLBACK;
				ELSE
				COMMIT;
				END IF;
				END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_rules`(IN `t_id` INT, IN `big_rgt` INT)
BEGIN
			DECLARE t_error INTEGER DEFAULT 0;  
			DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
			START TRANSACTION;  
			UPDATE rules_data set lid=lid-2 WHERE lid>big_rgt;     
			UPDATE rules_data set rid=rid-2 WHERE rid>big_rgt;
			DELETE FROM rules_data WHERE id=t_id;
			IF t_error = 1 THEN  
			ROLLBACK;
			ELSE
			COMMIT;
			END IF;
			END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `urid` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `passwd` char(32) NOT NULL,
  `token` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `urid` (`urid`),
  KEY `token` (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `urid`, `name`, `passwd`, `token`) VALUES
(5, 3, 'root', 'e10adc3949ba59abbe56e057f20f883e', '80a4503f082640eb0a859897d4c8af3b');

-- --------------------------------------------------------

--
-- 表的结构 `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(20) NOT NULL,
  `msg` text NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `rules_data`
--

CREATE TABLE IF NOT EXISTS `rules_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(10) NOT NULL,
  `rid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pid` int(10) NOT NULL,
  `deep` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lid` (`lid`,`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `rules_data`
--

INSERT INTO `rules_data` (`id`, `lid`, `rid`, `name`, `pid`, `deep`) VALUES
(1, 0, 41, '/', 0, 0),
(2, 1, 34, 'authorization', 1, 1),
(3, 2, 13, 'authorization/admin', 2, 2),
(4, 14, 23, 'authorization/roles', 2, 2),
(5, 24, 33, 'authorization/rules', 2, 2),
(6, 3, 4, 'authorization/admin/view', 3, 3),
(7, 5, 6, 'authorization/admin/add', 3, 3),
(8, 7, 8, 'authorization/admin/changepassword', 3, 3),
(9, 9, 10, 'authorization/admin/modify', 3, 3),
(10, 11, 12, 'authorization/admin/delete', 3, 3),
(11, 15, 16, 'authorization/roles/view', 4, 3),
(12, 17, 18, 'authorization/roles/add', 4, 3),
(13, 19, 20, 'authorization/roles/modify', 4, 3),
(14, 21, 22, 'authorization/roles/delete', 4, 3),
(15, 25, 26, 'authorization/rules/view', 5, 3),
(16, 27, 28, 'authorization/rules/add', 5, 3),
(17, 29, 30, 'authorization/rules/modify', 5, 3),
(18, 31, 32, 'authorization/rules/delete', 5, 3),
(19, 35, 40, 'log', 1, 1),
(20, 36, 39, 'log/loginfo', 19, 2),
(21, 37, 38, 'log/loginfo/view', 20, 3);

-- --------------------------------------------------------

--
-- 表的结构 `user_rules`
--

CREATE TABLE IF NOT EXISTS `user_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `rules` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `user_rules`
--

INSERT INTO `user_rules` (`id`, `name`, `rules`) VALUES
(3, '超级管理员', '1,2,3,6,7,8,9,10,4,11,12,13,14,5,15,16,17,18,19,20,21');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
