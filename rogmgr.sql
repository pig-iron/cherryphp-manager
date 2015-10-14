-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-10-15 00:06:57
-- 服务器版本： 5.6.17
-- PHP Version: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rogmgr`
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
				UPDATE rogmgr_rules_data set lid=lid+2 WHERE lid>big_rgt;     
				UPDATE rogmgr_rules_data set rid=rid+2 WHERE rid>big_rgt;
				INSERT INTO rogmgr_rules_data set lid=big_rgt+1, rid=big_rgt+2, name=big_name, deep=big_deep, pid=id;
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
				UPDATE rogmgr_rules_data set lid=lid+2 WHERE lid>big_lft;     
				UPDATE rogmgr_rules_data set rid=rid+2 WHERE rid>big_lft;
				INSERT INTO rogmgr_rules_data set lid=big_lft+1, rid=big_lft+2, name=big_name, deep=big_deep+1, pid=id;
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
			UPDATE rogmgr_rules_data set lid=lid-2 WHERE lid>big_rgt;     
			UPDATE rogmgr_rules_data set rid=rid-2 WHERE rid>big_rgt;
			DELETE FROM rogmgr_rules_data WHERE id=t_id;
			IF t_error = 1 THEN  
			ROLLBACK;
			ELSE
			COMMIT;
			END IF;
			END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `rogmgr_admin`
--

CREATE TABLE IF NOT EXISTS `rogmgr_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `urid` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `passwd` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `urid` (`urid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `rogmgr_admin`
--

INSERT INTO `rogmgr_admin` (`id`, `urid`, `name`, `passwd`) VALUES
(5, 3, 'root', 'e10adc3949ba59abbe56e057f20f883e'),
(6, 4, 'guest', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `rogmgr_gamedata`
--

CREATE TABLE IF NOT EXISTS `rogmgr_gamedata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jsondata` text NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `rogmgr_gamedata`
--

INSERT INTO `rogmgr_gamedata` (`id`, `jsondata`, `type`) VALUES
(1, '{"1":"123","2":"2323","3":"我勒个去"}', 'emailtype'),
(2, '{"1000020":{"type":"11","param":"22","coin":"33","stone":"44","name":"55"}}', 'itemsetting'),
(3, '{"13":{"name":"系统奖励","type":"源晶"},"122":{"name":"系统奖励","type":"金币1"}}', 'rewardsetting'),
(4, '{"multiple":[{"name":"22212aaaa","exp_mult":"2","coin_mult":"2","heropro_mult":"2","year":"*","month":"9/11","day":"1","hour":"2","min":"*","week":"*"},{"name":"1","exp_mult":"2","coin_mult":"3","heropro_mult":"4","year":"5","month":"6","day":"7","hour":"8","min":"9","week":"0"}]}', 'multipleactivity'),
(5, '{"global_reward":[{"guid":1,"id":12,"value":1000,"desc":"开服奖励1000金币"},{"guid":2,"id":13,"value":1000,"desc":"开服奖励1000源晶"},{"guid":"3","id":"1422","value":"1000045","desc":"金币包aaa"}]}', 'reward');

-- --------------------------------------------------------

--
-- 表的结构 `rogmgr_log`
--

CREATE TABLE IF NOT EXISTS `rogmgr_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(20) NOT NULL,
  `msg` text NOT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- 转存表中的数据 `rogmgr_log`
--

INSERT INTO `rogmgr_log` (`id`, `admin`, `msg`, `ctime`) VALUES
(1, 'admin', '1111111', '2015-10-10 10:06:42'),
(2, '啊实打实', '阿大声道', '2015-10-10 10:26:17'),
(3, '', '添加管理员aaabccc', '2015-10-10 11:19:37'),
(4, 'aaaa', '添加管理员aaabccc', '2015-10-10 11:19:56'),
(5, 'aaaa', '添加管理员aaaa', '2015-10-10 11:20:13'),
(6, 'aaaa', '修改管理员密码,ID:7', '2015-10-10 11:32:46'),
(7, 'aaaa', '更新管理员信息,ID:7管理员名称:aaaabbbb角色ID:2', '2015-10-10 11:33:26'),
(8, 'aaaa', '删除管理员,ID:7', '2015-10-10 11:33:50'),
(9, 'aaa', '修改reward，value:{"global_reward":[{"guid":1,"id":12,"value":1000,"desc":"开服奖励1000金币"},{"guid":2,"id":13,"value":1000,"desc":"开服奖励1000源晶"},{"guid":"3","id":"1422","value":"1000045","desc":"金币包aaa"}]}', '2015-10-12 09:36:39'),
(10, 'aaa', '添加权限项，ID:11', '2015-10-12 09:46:20'),
(11, 'aaa', '添加权限项，ID:12', '2015-10-12 09:46:40'),
(12, 'aaa', '删除权限项，ID:28', '2015-10-12 09:48:26'),
(13, 'aaa', '添加权限项，ID:11', '2015-10-12 09:48:26'),
(14, 'aaa', '删除权限项，ID:29', '2015-10-12 09:48:34'),
(15, 'aaa', '添加权限项，ID:12', '2015-10-12 09:48:34'),
(16, 'aaa', '添加权限项，ID:11', '2015-10-12 09:48:58'),
(17, 'aaa', '添加权限项，ID:11', '2015-10-12 09:49:07'),
(18, 'aaa', '添加权限项，ID:12', '2015-10-12 09:49:54'),
(19, 'aaa', '添加权限项，ID:12', '2015-10-12 09:50:03'),
(20, 'aaa', '修改emailtype，value:{"1":"123","2":"2323","3":"我勒个去"}', '2015-10-12 09:50:28'),
(21, 'aaa', '添加权限项，ID:13', '2015-10-12 09:50:53'),
(22, 'aaa', '添加权限项，ID:13', '2015-10-12 09:51:06'),
(23, 'aaa', '添加权限项，ID:13', '2015-10-12 09:51:16'),
(24, 'aaa', '添加权限项，ID:3', '2015-10-12 09:51:29'),
(25, 'aaa', '添加权限项，ID:9', '2015-10-12 09:51:46'),
(26, 'aaa', '添加权限项，ID:9', '2015-10-12 09:51:55'),
(27, 'aaa', '添加权限项，ID:9', '2015-10-12 09:52:13'),
(28, 'aaa', '添加权限项，ID:10', '2015-10-12 09:52:27'),
(29, 'aaa', '添加权限项，ID:10', '2015-10-12 09:52:33'),
(30, 'aaa', '添加权限项，ID:10', '2015-10-12 09:52:55'),
(31, 'aaa', '删除权限项，ID:10', '2015-10-12 09:53:15'),
(32, 'aaa', '添加权限项，ID:3', '2015-10-12 09:53:15'),
(33, 'aaa', '删除权限项，ID:45', '2015-10-12 09:53:43'),
(34, 'aaa', '添加权限项，ID:46', '2015-10-12 09:53:43'),
(35, 'aaa', '删除权限项，ID:44', '2015-10-12 09:53:54'),
(36, 'aaa', '添加权限项，ID:46', '2015-10-12 09:53:54'),
(37, 'aaa', '删除权限项，ID:43', '2015-10-12 09:54:04'),
(38, 'aaa', '添加权限项，ID:46', '2015-10-12 09:54:04'),
(39, 'aaa', '添加权限项，ID:7', '2015-10-12 09:55:23'),
(40, 'aaa', '添加权限项，ID:7', '2015-10-12 09:55:43'),
(41, 'aaa', '添加权限项，ID:7', '2015-10-12 09:55:49'),
(42, 'aaa', '添加权限项，ID:50', '2015-10-12 09:56:10'),
(43, 'aaa', '添加权限项，ID:50', '2015-10-12 09:56:18'),
(44, 'aaa', '添加权限项，ID:51', '2015-10-12 09:56:33'),
(45, 'aaa', '添加权限项，ID:51', '2015-10-12 09:56:41'),
(46, 'aaa', '删除角色,ID:2', '2015-10-12 09:59:22'),
(47, 'aaa', '删除角色,ID:1', '2015-10-12 09:59:24'),
(48, 'aaa', '删除管理员,ID:4', '2015-10-12 09:59:31'),
(49, 'aaa', '删除角色,ID:1', '2015-10-12 09:59:36'),
(50, 'aaa', '删除权限项，ID:39', '2015-10-12 10:05:07'),
(51, 'aaa', '添加权限项，ID:3', '2015-10-12 10:05:07'),
(52, 'aaa', '添加角色,角色名称:角色权限项:1,2,7,50,53,54,51,55,56,52,8,3,9,40,41,42,46,47,48,49,57,4,11,30,32,33,12,31,34,35,13,36,37,38,5,14,18,19,20,21,15,22,23,24,16,25,26,27,6,17', '2015-10-12 10:05:46'),
(53, 'aaa', '修改角色,ID:3角色名称:超级管理员角色权限项:1,2,7,50,53,54,51,55,56,52,8,3,9,40,41,42,46,47,48,49,57,4,11,30,32,33,12,31,34,35,13,36,37,38,5,14,18,19,20,21,15,22,23,24,16,25,26,27,6,17', '2015-10-12 10:05:56'),
(54, 'aaa', '添加管理员root', '2015-10-12 10:06:46'),
(55, 'root', '添加权限项，ID:52', '2015-10-13 13:17:38'),
(56, 'root', '添加权限项，ID:50', '2015-10-13 13:17:51'),
(57, 'root', '添加权限项，ID:51', '2015-10-13 13:18:01'),
(58, 'root', '添加权限项，ID:8', '2015-10-13 13:18:25'),
(59, 'root', '添加权限项，ID:9', '2015-10-13 13:18:36'),
(60, 'root', '添加权限项，ID:46', '2015-10-13 13:18:56'),
(61, 'root', '添加权限项，ID:57', '2015-10-13 13:19:11'),
(62, 'root', '添加权限项，ID:11', '2015-10-13 13:19:33'),
(63, 'root', '添加权限项，ID:12', '2015-10-13 13:19:49'),
(64, 'root', '添加权限项，ID:13', '2015-10-13 13:20:00'),
(65, 'root', '添加权限项，ID:14', '2015-10-13 13:20:12'),
(66, 'root', '添加权限项，ID:15', '2015-10-13 13:20:20'),
(67, 'root', '添加权限项，ID:16', '2015-10-13 13:20:33'),
(68, 'root', '添加权限项，ID:17', '2015-10-13 13:20:52'),
(69, 'root', '修改角色,ID:3角色名称:超级管理员角色权限项:1,2,7,50,53,54,59,51,55,56,60,52,58,8,61,3,9,40,41,42,62,46,47,48,49,63,57,64,4,11,30,32,33,65,12,31,34,35,66,13,36,37,38,67,5,14,18,19,20,21,68,15,22,23,24,69,16,25,26,27,70,6,17,71', '2015-10-13 13:21:49'),
(70, 'root', '添加角色,角色名称:GUEST角色权限项:65,66,67', '2015-10-13 13:22:37'),
(71, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:node-0,node-3,node-9,node-57,node-10,node-58,node-11,node-59', '2015-10-13 13:46:21'),
(72, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:,,,,,,,', '2015-10-13 13:50:13'),
(73, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,65,12,66,13,67', '2015-10-13 13:52:52'),
(74, 'root', '添加管理员guest', '2015-10-13 13:53:21'),
(75, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,65,12,66,13,67,5,14,21', '2015-10-13 14:23:16'),
(76, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,65,12,66,13,67,5,14,68', '2015-10-13 14:25:51'),
(77, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,32,65,12,66,13,67,5,14,68', '2015-10-14 10:18:17'),
(78, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,30,32,65,12,66,13,67,5,14,68', '2015-10-14 10:18:55'),
(79, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,30,65,12,66,13,67,5,14,68', '2015-10-14 10:42:15'),
(80, 'root', '修改角色,ID:4角色名称:GUEST角色权限项:1,4,11,30,33,65,12,66,13,67,5,14,68', '2015-10-14 10:44:41');

-- --------------------------------------------------------

--
-- 表的结构 `rogmgr_rules_data`
--

CREATE TABLE IF NOT EXISTS `rogmgr_rules_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(10) NOT NULL,
  `rid` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `pid` int(10) NOT NULL,
  `deep` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lid` (`lid`,`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- 转存表中的数据 `rogmgr_rules_data`
--

INSERT INTO `rogmgr_rules_data` (`id`, `lid`, `rid`, `name`, `pid`, `deep`) VALUES
(1, 1, 128, '/', 0, 0),
(2, 2, 29, '服务器管理', 1, 1),
(3, 30, 55, '游戏管理', 1, 1),
(4, 56, 87, '系统设置', 1, 1),
(5, 88, 121, '授权管理', 1, 1),
(6, 122, 127, '日志管理', 1, 1),
(7, 3, 24, '游戏服务器', 2, 2),
(8, 25, 28, '邮件服务器', 2, 2),
(9, 31, 40, '奖励发放', 3, 2),
(11, 57, 66, '奖励设置', 4, 2),
(12, 67, 76, '游戏道具设置', 4, 2),
(13, 77, 86, '邮件类型设置', 4, 2),
(14, 89, 100, '管理员管理', 5, 2),
(15, 101, 110, '角色管理', 5, 2),
(16, 111, 120, '权限项管理', 5, 2),
(17, 123, 126, '操作日志', 6, 2),
(18, 90, 91, '管理员管理-添加', 14, 3),
(19, 92, 93, '管理员管理-修改密码', 14, 3),
(20, 94, 95, '管理员管理-修改', 14, 3),
(21, 96, 97, '管理员管理-删除', 14, 3),
(22, 102, 103, '角色管理-添加', 15, 3),
(23, 104, 105, '角色管理-修改', 15, 3),
(24, 106, 107, '角色管理-删除', 15, 3),
(25, 112, 113, '权限项管理-添加', 16, 3),
(26, 114, 115, '权限项管理-修改', 16, 3),
(27, 116, 117, '权限项管理-删除', 16, 3),
(30, 58, 59, '奖励设置-添加', 11, 3),
(31, 68, 69, '游戏道具设置-添加', 12, 3),
(32, 60, 61, '奖励设置-修改', 11, 3),
(33, 62, 63, '奖励设置-删除', 11, 3),
(34, 70, 71, '游戏道具设置-修改', 12, 3),
(35, 72, 73, '游戏道具设置-删除', 12, 3),
(36, 78, 79, '邮件类型设置-添加', 13, 3),
(37, 80, 81, '邮件类型设置-修改', 13, 3),
(38, 82, 83, '邮件类型设置-删除', 13, 3),
(40, 32, 33, '奖励发放-添加', 9, 3),
(41, 34, 35, '奖励发放-修改', 9, 3),
(42, 36, 37, '奖励发放-删除', 9, 3),
(46, 41, 50, '多倍奖励活动', 3, 2),
(47, 42, 43, '多倍奖励活动-删除', 46, 3),
(48, 44, 45, '多倍奖励活动-修改', 46, 3),
(49, 46, 47, '多倍奖励活动-添加', 46, 3),
(50, 4, 11, 'BattleServer', 7, 3),
(51, 12, 19, 'Server', 7, 3),
(52, 20, 23, 'Login', 7, 3),
(53, 5, 6, 'BattleServer-激活', 50, 4),
(54, 7, 8, 'BattleServer-反激活', 50, 4),
(55, 13, 14, 'Server-激活', 51, 4),
(56, 15, 16, 'Server-反激活', 51, 4),
(57, 51, 54, '版本发布', 3, 2),
(58, 21, 22, 'Login-查看', 52, 4),
(59, 9, 10, 'BattleServer-查看', 50, 4),
(60, 17, 18, 'Server-查看', 51, 4),
(61, 26, 27, '邮件服务器-查看', 8, 3),
(62, 38, 39, '奖励发放-查看', 9, 3),
(63, 48, 49, '多倍奖励活动-查看', 46, 3),
(64, 52, 53, '版本发布-查看', 57, 3),
(65, 64, 65, '奖励设置-查看', 11, 3),
(66, 74, 75, '游戏道具设置-查看', 12, 3),
(67, 84, 85, '邮件类型设置-查看', 13, 3),
(68, 98, 99, '管理员管理-查看', 14, 3),
(69, 108, 109, '角色管理-查看', 15, 3),
(70, 118, 119, '权限项管理-查看', 16, 3),
(71, 124, 125, '操作日志-查看', 17, 3);

-- --------------------------------------------------------

--
-- 表的结构 `rogmgr_user_rules`
--

CREATE TABLE IF NOT EXISTS `rogmgr_user_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `rules` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `rogmgr_user_rules`
--

INSERT INTO `rogmgr_user_rules` (`id`, `name`, `rules`) VALUES
(3, '超级管理员', '1,2,7,50,53,54,59,51,55,56,60,52,58,8,61,3,9,40,41,42,62,46,47,48,49,63,57,64,4,11,30,32,33,65,12,31,34,35,66,13,36,37,38,67,5,14,18,19,20,21,68,15,22,23,24,69,16,25,26,27,70,6,17,71'),
(4, 'GUEST', '1,4,11,30,33,65,12,66,13,67,5,14,68');

--
-- 限制导出的表
--

--
-- 限制表 `rogmgr_admin`
--
ALTER TABLE `rogmgr_admin`
  ADD CONSTRAINT `fk_urid_id` FOREIGN KEY (`urid`) REFERENCES `rogmgr_user_rules` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
