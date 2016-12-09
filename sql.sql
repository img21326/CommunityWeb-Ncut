-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2016-12-08 08:45:17
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
-- 資料表結構 `friend`
--

CREATE TABLE `friend` (
  `SID` int(20) NOT NULL COMMENT '會員ID',
  `FID` int(20) NOT NULL COMMENT '好友ID',
  `request` tinyint(1) NOT NULL COMMENT '邀請成為好友',
  `respond` tinyint(1) DEFAULT NULL COMMENT '答覆'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `group`
--

CREATE TABLE `group` (
  `group_id` int(20) NOT NULL COMMENT '社團編號',
  `gname` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '社團名稱',
  `manager` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理員',
  `group_member` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '社團成員'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `leave`
--

CREATE TABLE `leave` (
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
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '帳號',
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '密碼',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '電話',
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'email',
  `FID` int(20) DEFAULT NULL COMMENT '好友ID(連friend_data)',
  `group_id` int(20) DEFAULT NULL COMMENT '社團ID(連group_data)',
  `sday` date NOT NULL COMMENT '創辦日期',
  `status` tinyint(1) NOT NULL COMMENT '1.啟動。0.關閉。'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='會員資料';

--
-- 資料表的匯出資料 `member_data`
--

INSERT INTO `member_data` (`SID`, `username`, `password`, `name`, `phone`, `email`, `FID`, `group_id`, `sday`, `status`) VALUES
(4, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', '0919552148', 'test@user.com', NULL, NULL, '2016-12-08', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `message`
--

CREATE TABLE `message` (
  `message_id` int(20) NOT NULL,
  `sender` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '寄件人',
  `recipient` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '收件人',
  `content` text COLLATE utf8_unicode_ci COMMENT '內容',
  `status` tinyint(1) NOT NULL COMMENT '1.已讀。2.未讀'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `post`
--

CREATE TABLE `post` (
  `post_id` int(20) NOT NULL,
  `SID` int(20) NOT NULL COMMENT '誰PO的',
  `contact` text COLLATE utf8_unicode_ci NOT NULL COMMENT '內容',
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '時間',
  `group_id` int(20) DEFAULT NULL COMMENT '社團ID(在哪個社團)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='動態消息資料表';

--
-- 資料表的匯出資料 `post`
--

INSERT INTO `post` (`post_id`, `SID`, `contact`, `post_time`, `group_id`) VALUES
(1, 4, '大家好~', '2016-12-08 07:25:13', NULL),
(2, 4, 'ne1w one', '0000-00-00 00:00:00', 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `leave`
--
ALTER TABLE `leave`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `post_id` (`post_id`);

--
-- 資料表索引 `member_data`
--
ALTER TABLE `member_data`
  ADD PRIMARY KEY (`SID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `FID` (`FID`);

--
-- 資料表索引 `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `SID` (`SID`),
  ADD KEY `group_id` (`group_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `member_data`
--
ALTER TABLE `member_data`
  MODIFY `SID` int(20) NOT NULL AUTO_INCREMENT COMMENT '會員ID', AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
