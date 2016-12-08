-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2016-12-08 06:47:18
-- 伺服器版本: 5.7.15-log
-- PHP 版本： 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `team1`
--

-- --------------------------------------------------------

--
-- 資料表結構 `dynamic_data`
--

CREATE TABLE `dynamic_data` (
  `post_id` int(20) NOT NULL,
  `SID` int(20) NOT NULL COMMENT '誰PO的',
  `contact` text COLLATE utf8_unicode_ci COMMENT '內容',
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '時間',
  `group_id` int(20) NOT NULL COMMENT '社團ID(在哪個社團)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='動態消息資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `friend_data`
--

CREATE TABLE `friend_data` (
  `SID` int(20) NOT NULL COMMENT '會員ID',
  `FID` int(20) NOT NULL COMMENT '好友ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `groud_data`
--

CREATE TABLE `groud_data` (
  `group_id` int(20) NOT NULL COMMENT '社團編號',
  `gname` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '社團名稱',
  `manager` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理員',
  `group_member` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '社團成員'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `leave_data`
--

CREATE TABLE `leave_data` (
  `com_id` int(20) NOT NULL,
  `commiter` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'SID留言者',
  `contact` text COLLATE utf8_unicode_ci NOT NULL COMMENT '內容',
  `leave_time` datetime NOT NULL COMMENT '留言時間',
  `post_id` int(20) NOT NULL COMMENT '動態消息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='留言資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `member_data`
--

CREATE TABLE `member_data` (
  `SID` int(20) NOT NULL COMMENT '會員ID',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '帳號',
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '密碼',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '電話',
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'email',
  `FID` int(20) DEFAULT NULL COMMENT '好友ID(連friend_data)',
  `group_id` int(20) DEFAULT NULL COMMENT '社團ID(連group_data)',
  `sday` date NOT NULL COMMENT '創辦日期',
  `status` tinyint(1) NOT NULL COMMENT '1.啟動。0.關閉。'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='會員資料';

-- --------------------------------------------------------

--
-- 資料表結構 `message_data`
--

CREATE TABLE `message_data` (
  `message_id` int(20) NOT NULL,
  `sender` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '寄件人',
  `recipient` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '收件人',
  `content` text COLLATE utf8_unicode_ci COMMENT '內容',
  `status` tinyint(1) NOT NULL COMMENT '1.已讀。2.未讀'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `member_data`
--
ALTER TABLE `member_data`
  ADD PRIMARY KEY (`SID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `FID` (`FID`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `member_data`
--
ALTER TABLE `member_data`
  MODIFY `SID` int(20) NOT NULL AUTO_INCREMENT COMMENT '會員ID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
