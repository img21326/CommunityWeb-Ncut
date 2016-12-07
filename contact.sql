-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2016-12-06 06:21:15
-- 伺服器版本: 5.7.15-log
-- PHP 版本： 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `contact`
--

-- --------------------------------------------------------

--
-- 資料表結構 `dynamic_data`
--

CREATE TABLE `dynamic_data` (
  `post_id` int(20) NOT NULL,
  `SID` int(20) NOT NULL COMMENT '誰PO的',
  `contact` text COMMENT '內容',
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '時間',
  `group_id` int(20) NOT NULL COMMENT '社團ID(在哪個社團)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='動態消息資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `friend_data`
--

CREATE TABLE `friend_data` (
  `SID` int(20) NOT NULL COMMENT '會員ID',
  `FID` int(20) NOT NULL COMMENT '好友ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `groud_data`
--

CREATE TABLE `groud_data` (
  `group_id` int(20) NOT NULL COMMENT '社團編號',
  `gname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社團名稱',
  `manager` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理員',
  `group_member` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '社團成員'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `leave_data`
--

CREATE TABLE `leave_data` (
  `com_id` int(20) NOT NULL,
  `commiter` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SID留言者',
  `contact` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內容',
  `leave_time` datetime NOT NULL COMMENT '留言時間',
  `post_id` int(20) NOT NULL COMMENT '動態消息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='留言資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `member_data`
--

CREATE TABLE `member_data` (
  `SID` int(20) NOT NULL COMMENT '會員ID',
  `num_txt` varchar(20) NOT NULL COMMENT '帳號',
  `password` varchar(20) NOT NULL COMMENT '密碼',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `phone` varchar(10) DEFAULT NULL COMMENT '電話',
  `email` varchar(30) NOT NULL COMMENT 'email',
  `FID` int(20) NOT NULL COMMENT '好友ID(連friend_data)',
  `group_id` int(20) NOT NULL COMMENT '社團ID(連group_data)',
  `sday` date NOT NULL COMMENT '創辦日期',
  `status` tinyint(1) NOT NULL COMMENT '1.啟動。0.關閉。'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='會員資料';

-- --------------------------------------------------------

--
-- 資料表結構 `message_data`
--

CREATE TABLE `message_data` (
  `message_id` int(20) NOT NULL,
  `sender` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '寄件人',
  `recipient` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '收件人',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '內容',
  `status` tinyint(1) NOT NULL COMMENT '1.已讀。2.未讀'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
