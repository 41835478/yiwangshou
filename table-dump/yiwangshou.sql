-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-02-26 08:38:20
-- 服务器版本： 5.7.11
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yiwangshou`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('超级管理员','小区管理员','派单员') COLLATE utf8_unicode_ci NOT NULL,
  `plot_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `role`, `plot_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(23, 'admin1', '$2y$10$xOSFBiBKohMXn.7Vc4WJNOyozSYfIcV5ROjduSThMI1eKn4R78Bki', '小区管理员', 21, '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(24, 'admin2', '$2y$10$nW8qCly9lWd04nOtcYk5WuaZiMAOQiZ6imsLjEl8cYJ6TJdfZTl0y', '小区管理员', 22, '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(25, 'admin3', '$2y$10$3D1.fJLj0iSQxSqWan1grebuEDBWw.aszhdnoy1F53Hjp/4wQu4/O', '小区管理员', 23, '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(26, 'admin4', '$2y$10$UPobTKEORAaVRIJ7wimOoeiq4L/px1Y2FGeMxGw3uq0Lrbc.iKh8i', '小区管理员', 24, '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(27, 'admin5', '$2y$10$uTvOP3WxG/7DyWNxelphTuCJdEXa5aXcRyugIpn7Flkzd0raPdXsy', '小区管理员', 25, '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(28, 'admin6', '$2y$10$lbN4jfb6ZoBV9RWrsZJc8ezmVT7B7WDQ696viOP9Mv/.Ov3swV8oq', '小区管理员', 26, '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(29, 'admin7', '$2y$10$epvXWRiYOsnDMtINDYdgeuS1E3Ltpvr4rBH8priaKOqOux4f4rWpu', '小区管理员', 27, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(30, 'admin8', '$2y$10$.JWyLthBDbSj6ZhevfyxM.txfvo6cEooq1idoGtnh4fe6aMYXBALq', '小区管理员', 28, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(31, 'admin9', '$2y$10$s7VGAUIq1h77VSUbpBiMKORuCWJgK3K3iMeAKVUwkkFRmg3Ub18O.', '小区管理员', 29, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(32, 'admin10', '$2y$10$ULhiKM5hAjULlJzYQ23Qa.mxxu4nZzL9kINnv1EgC4GzSs2Ugvj9a', '小区管理员', 30, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(33, 'yiwangshou', '$2y$10$KECyETPu5YmruZCO4ItPUePnbA7HzmAC9X6qnYIlB.NLklAkvSqt2', '超级管理员', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(34, 'ljm19357', '$2y$10$RjgnrF87Bwd4ZKpjuA0NoOjaG5qNyU2hRRvEfDRMhB02lbMmMebTG', '小区管理员', 31, '2016-11-30 10:01:43', '2016-11-30 10:01:43', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_logs`
--

CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` int(10) unsigned NOT NULL,
  `admin_id` int(10) unsigned NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('INSERT','DELETE','UPDATE','SELECT','OTHER') COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `ip`, `type`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 33, '127.0.0.1', 'OTHER', '登录', '2016-11-30 09:54:15', '2016-11-30 09:54:15', NULL),
(2, 33, '127.0.0.1', 'OTHER', '注销', '2016-11-30 09:57:55', '2016-11-30 09:57:55', NULL),
(3, 33, '127.0.0.1', 'OTHER', '注销', '2016-11-30 10:00:33', '2016-11-30 10:00:33', NULL),
(4, 33, '127.0.0.1', 'OTHER', '注销', '2016-11-30 10:01:47', '2016-11-30 10:01:47', NULL),
(5, 33, '127.0.0.1', 'OTHER', '注销', '2016-11-30 10:04:34', '2016-11-30 10:04:34', NULL),
(6, 33, '127.0.0.1', 'OTHER', '注销', '2016-11-30 10:06:28', '2016-11-30 10:06:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `classifications`
--

CREATE TABLE IF NOT EXISTS `classifications` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('家电回收','纸皮回收','旧衣回收') COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `classifications`
--

INSERT INTO `classifications` (`id`, `name`, `type`, `icon`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '空调', '家电回收', 'kt', 0, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(2, '冰箱', '家电回收', 'bx', 0, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `codes`
--

CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(10) unsigned NOT NULL,
  `code` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `codes`
--

INSERT INTO `codes` (`id`, `code`, `admin_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(29, '201611282101281755', 23, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(30, '201611282101282097', 23, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(31, '201611282101283891', 23, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(32, '201611282101288118', 23, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(33, '201611282101283381', 23, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(34, '201611282101283938', 24, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(35, '201611282101281697', 24, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(36, '201611282101289621', 24, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(37, '201611282101289239', 24, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(38, '201611282101285234', 24, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(39, '201611282101284205', 25, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(40, '201611282101285219', 25, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(41, '201611282101287035', 25, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(42, '201611282101289514', 25, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(43, '201611282101288969', 25, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(44, '201611282101286340', 26, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(45, '201611282101287891', 26, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(46, '201611282101281446', 26, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(47, '201611282101287845', 26, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(48, '201611282101286989', 26, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(49, '201611282101282967', 27, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(50, '201611282101285823', 27, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(51, '201611282101281792', 27, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(52, '201611282101284058', 27, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(53, '201611282101282733', 27, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(54, '201611282101284598', 28, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(55, '201611282101281034', 28, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(56, '201611282101283312', 28, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(57, '201611282101281219', 28, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(58, '201611282101286906', 28, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(59, '201611282101286023', 29, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(60, '201611282101282799', 29, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(61, '201611282101284055', 29, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(62, '201611282101289726', 29, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(63, '201611282101281519', 29, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(64, '201611282101283064', 30, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(65, '201611282101281608', 30, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(66, '201611282101287510', 30, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(67, '201611282101288740', 30, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(68, '201611282101287339', 30, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(69, '201611282101289368', 31, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(70, '201611282101288821', 31, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(71, '201611282101289171', 31, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(72, '201611282101287560', 31, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(73, '201611282101284687', 31, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(74, '201611282101285699', 32, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(75, '201611282101282111', 32, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(76, '201611282101287885', 32, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(77, '201611282101283217', 32, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(78, '201611282101285278', 32, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `ext_value` decimal(8,2) NOT NULL DEFAULT '0.00',
  `type` enum('无成本券','有成本券','以旧换新券') COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `timestamp` int(10) unsigned DEFAULT NULL,
  `business` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `remark`, `value`, `ext_value`, `type`, `expired_at`, `timestamp`, `business`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '测试优惠券', '信息', '1.99', '0.99', '有成本券', '2017-05-27 13:01:28', NULL, '商家信息', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(2, '测试优惠券', '信息', '1.99', '0.99', '无成本券', '2017-05-27 13:01:28', NULL, '商家信息', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(3, '测试优惠券', '信息', '1.99', '0.99', '有成本券', NULL, 3600, '商家信息', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(4, '测试优惠券', '信息', '1.99', '0.99', '无成本券', NULL, 3600, '商家信息', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `coupon_numbers`
--

CREATE TABLE IF NOT EXISTS `coupon_numbers` (
  `id` int(10) unsigned NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coupon_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(10) unsigned NOT NULL,
  `admin_id` int(10) unsigned NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('待审核','已派车') COLLATE utf8_unicode_ci NOT NULL DEFAULT '待审核',
  `refused_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `forms`
--

INSERT INTO `forms` (`id`, `admin_id`, `remark`, `status`, `refused_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 23, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(2, 23, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(3, 23, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(4, 23, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(5, 24, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(6, 24, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(7, 24, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(8, 24, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(9, 25, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(10, 25, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(11, 25, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(12, 25, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(13, 26, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(14, 26, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(15, 26, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(16, 26, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(17, 27, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(18, 27, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(19, 27, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(20, 27, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(21, 28, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(22, 28, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(23, 28, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(24, 28, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(25, 29, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(26, 29, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(27, 29, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(28, 29, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(29, 30, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(30, 30, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(31, 30, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(32, 30, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(33, 31, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(34, 31, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(35, 31, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(36, 31, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(37, 32, '备注信息', '待审核', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(38, 32, '备注信息', '已派车', NULL, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(39, 32, '备注信息', '待审核', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(40, 32, '备注信息', '已派车', '拒绝的理由', '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL,
  `mobile` char(11) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sms_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `messages`
--

INSERT INTO `messages` (`id`, `mobile`, `ip`, `sms_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(22, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(23, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(24, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(25, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(26, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(27, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(28, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(29, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(30, '18649757679', '127.0.0.1', 'test_sms_id', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(31, '13635276231', '127.0.0.1', '20161130160323218', '2016-11-30 08:08:35', '2016-11-30 08:08:35', NULL),
(32, '13635276231', '127.0.0.1', '201611301604366', '2016-11-30 08:09:49', '2016-11-30 08:09:49', NULL),
(33, '13635276231', '127.0.0.1', '20161130160549515', '2016-11-30 08:11:02', '2016-11-30 08:11:02', NULL),
(34, '13635276231', '127.0.0.1', '20161130161837083', '2016-11-30 08:23:49', '2016-11-30 08:23:49', NULL),
(35, '13635276231', '127.0.0.1', '20161130161855257', '2016-11-30 08:24:07', '2016-11-30 08:24:07', NULL),
(36, '13635276231', '127.0.0.1', '20161130162121866', '2016-11-30 08:26:34', '2016-11-30 08:26:34', NULL),
(37, '13635276231', '127.0.0.1', '20161130162354325', '2016-11-30 08:29:06', '2016-11-30 08:29:06', NULL),
(38, '13635276231', '127.0.0.1', '20161130162637923', '2016-11-30 08:31:50', '2016-11-30 08:31:50', NULL),
(39, '13635276231', '127.0.0.1', '20161130163243509', '2016-11-30 08:37:56', '2016-11-30 08:37:56', NULL),
(40, '13635276231', '127.0.0.1', '20161130164614945', '2016-11-30 08:51:27', '2016-11-30 08:51:27', NULL),
(41, '18144059419', '127.0.0.1', '20161130164734271', '2016-11-30 08:52:46', '2016-11-30 08:52:46', NULL),
(42, '18144059419', '127.0.0.1', '20161130165604829', '2016-11-30 09:01:17', '2016-11-30 09:01:17', NULL),
(43, '13635276231', '127.0.0.1', '20161130182506372', '2016-11-30 10:30:18', '2016-11-30 10:30:18', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_06_28_204625_create_messages_table', 1),
('2016_06_28_204636_create_plots_table', 1),
('2016_06_28_204640_create_admins_table', 1),
('2016_06_28_204644_create_admin_logs_table', 1),
('2016_06_28_204647_create_notifications_table', 1),
('2016_06_28_204651_create_codes_table', 1),
('2016_06_28_204655_create_forms_table', 1),
('2016_06_28_204659_create_classifications_table', 1),
('2016_06_28_204702_create_types_table', 1),
('2016_06_28_204706_create_coupons_table', 1),
('2016_06_28_204710_create_type_coupons_table', 1),
('2016_06_28_204714_create_users_table', 1),
('2016_06_28_204722_create_orders_table', 1),
('2016_06_28_204725_create_order_images_table', 1),
('2016_09_22_110917_create_coupon_numbers_table', 1),
('2016_09_23_105455_add_miss_component_reason_orders_table', 1),
('2016_11_18_162900_create_plot_properties_table', 1);

-- --------------------------------------------------------

--
-- 表的结构 `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL,
  `from_id` int(10) unsigned DEFAULT NULL,
  `to_id` int(10) unsigned NOT NULL,
  `type` enum('未读','已读') COLLATE utf8_unicode_ci NOT NULL DEFAULT '未读',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL,
  `number` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `is_unload` tinyint(1) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `type` enum('有成本券','以旧换新券','现金转账','协助下单') COLLATE utf8_unicode_ci NOT NULL,
  `type_coupon_id` int(10) unsigned DEFAULT NULL,
  `coupon_id` int(10) unsigned DEFAULT NULL,
  `money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `wechat_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wechat_paid_at` timestamp NULL DEFAULT NULL,
  `plot_id` int(10) unsigned NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` char(11) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('待支付','已支付','无法回收','已取消','暂存','入库途中','已入库','已出库','退款') COLLATE utf8_unicode_ci NOT NULL,
  `refused_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancel_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `miss_component_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `paid_at` timestamp NULL DEFAULT NULL,
  `code_id` int(10) unsigned DEFAULT NULL,
  `cfm_is_unload` tinyint(1) NOT NULL,
  `cfm_money` decimal(8,2) NOT NULL DEFAULT '0.00',
  `cfm_type_id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `driver_id` int(10) unsigned DEFAULT NULL,
  `out_id` int(10) unsigned DEFAULT NULL,
  `in_id` int(10) unsigned DEFAULT NULL,
  `coupon_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property_at` timestamp NULL DEFAULT NULL,
  `driver_at` timestamp NULL DEFAULT NULL,
  `in_at` timestamp NULL DEFAULT NULL,
  `out_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `number`, `is_unload`, `user_id`, `type_id`, `type`, `type_coupon_id`, `coupon_id`, `money`, `wechat_number`, `wechat_paid_at`, `plot_id`, `address`, `name`, `mobile`, `status`, `refused_reason`, `cancel_reason`, `miss_component_reason`, `is_paid`, `paid_at`, `code_id`, `cfm_is_unload`, `cfm_money`, `cfm_type_id`, `property_id`, `driver_id`, `out_id`, `in_id`, `coupon_number`, `property_at`, `driver_at`, `in_at`, `out_at`, `remarks`, `is_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '201611282101281284', 0, NULL, 1, '协助下单', NULL, NULL, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(2, '201611282101284925', 1, NULL, 1, '协助下单', NULL, NULL, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(3, '201611282101285621', 0, 1, 1, '现金转账', NULL, 2, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(4, '201611282101288442', 0, 2, 1, '现金转账', NULL, 2, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(5, '201611282101286428', 0, 3, 1, '现金转账', NULL, 2, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(6, '201611282101283907', 0, 4, 1, '现金转账', NULL, 2, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(7, '201611282101284307', 0, 5, 1, '现金转账', NULL, 2, '0.00', NULL, NULL, 21, '二区二a108', '庄建家', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-11-28 13:00:28', '2016-11-28 13:00:28', NULL),
(8, '201611291648298368', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdasd', 0, '2016-11-29 08:48:29', '2016-11-29 08:48:29', NULL),
(9, '201611291655249574', 0, 6, 1, '有成本券', 1, 2, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 08:55:24', '2016-11-29 08:55:24', NULL),
(10, '201611291657506986', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 08:57:50', '2016-11-29 08:57:50', NULL),
(11, '201611291659032967', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 08:59:03', '2016-11-29 08:59:03', NULL),
(12, '201611291659354766', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 08:59:35', '2016-11-29 08:59:35', NULL),
(13, '201611291701023157', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:01:02', '2016-11-29 09:01:02', NULL),
(14, '201611291703544406', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:03:54', '2016-11-29 09:03:54', NULL),
(15, '201611291703585891', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:03:58', '2016-11-29 09:03:58', NULL),
(16, '201611291704184204', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:04:18', '2016-11-29 09:04:18', NULL),
(17, '201611291707057030', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:07:05', '2016-11-29 09:07:05', NULL),
(18, '201611291708239911', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:08:23', '2016-11-29 09:08:23', NULL),
(19, '201611291708276760', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:08:27', '2016-11-29 09:08:27', NULL),
(20, '201611291708285390', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:08:28', '2016-11-29 09:08:28', NULL),
(21, '201611291729425610', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已取消', NULL, '', NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:29:42', '2016-11-29 09:39:31', NULL),
(22, '201611291740443575', 0, 6, 1, '有成本券', 1, 2, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:40:44', '2016-11-29 09:40:44', NULL),
(23, '201611291742551283', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:42:55', '2016-11-29 09:42:55', NULL),
(24, '201611291746471028', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:46:47', '2016-11-29 09:46:47', NULL),
(25, '201611291748593462', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:48:59', '2016-11-29 09:48:59', NULL),
(26, '201611291750331321', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:50:33', '2016-11-29 09:50:33', NULL),
(27, '201611291751579591', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:51:57', '2016-11-29 09:51:57', NULL),
(28, '201611291753202832', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:53:20', '2016-11-29 09:53:20', NULL),
(29, '201611291757139513', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:57:13', '2016-11-29 09:57:13', NULL),
(30, '201611291757244458', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:57:24', '2016-11-29 09:57:24', NULL),
(31, '201611291757555521', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:57:55', '2016-11-29 09:57:55', NULL),
(32, '201611291758222959', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:58:22', '2016-11-29 09:58:22', NULL),
(33, '201611291758492629', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 24, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:58:49', '2016-11-29 09:58:49', NULL),
(34, '201611291759206094', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:59:20', '2016-11-29 09:59:20', NULL),
(35, '201611291759466706', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 09:59:46', '2016-11-29 09:59:46', NULL),
(36, '201611291800198284', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:00:19', '2016-11-29 10:00:19', NULL),
(37, '201611291800441773', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:00:44', '2016-11-29 10:00:44', NULL),
(38, '201611291801015185', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:01:01', '2016-11-29 10:01:01', NULL),
(39, '201611291808093476', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:08:09', '2016-11-29 10:08:09', NULL),
(40, '201611291808453889', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:08:45', '2016-11-29 10:08:45', NULL),
(41, '201611291808547326', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:08:54', '2016-11-29 10:08:54', NULL),
(42, '201611291810275121', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:10:27', '2016-11-29 10:10:27', NULL),
(43, '201611291810385027', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:10:38', '2016-11-29 10:10:38', NULL),
(44, '201611291816131876', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:16:13', '2016-11-29 10:16:13', NULL),
(45, '201611291818259832', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:18:25', '2016-11-29 10:18:25', NULL),
(46, '201611291820116140', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:20:11', '2016-11-29 10:20:11', NULL),
(47, '201611291821231429', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:21:23', '2016-11-29 10:21:23', NULL),
(48, '201611291824453343', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:24:45', '2016-11-29 10:24:45', NULL),
(49, '201611291825051461', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:25:05', '2016-11-29 10:25:05', NULL),
(50, '201611291825386609', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:25:38', '2016-11-29 10:25:38', NULL),
(51, '201611291826165839', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:26:16', '2016-11-29 10:26:16', NULL),
(52, '201611291826436029', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:26:43', '2016-11-29 10:26:43', NULL),
(53, '201611291827086175', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:27:08', '2016-11-29 10:27:08', NULL),
(54, '201611291828099317', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:28:09', '2016-11-29 10:28:09', NULL),
(55, '201611291833526514', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:33:52', '2016-11-29 10:33:52', NULL),
(56, '201611291834386486', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 10:34:38', '2016-11-29 10:34:38', NULL),
(57, '201611291921112464', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-29 11:21:11', '2016-11-29 11:21:11', NULL),
(58, '201611301516581668', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:16:58', '2016-11-30 07:16:58', NULL),
(59, '201611301544346146', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:44:34', '2016-11-30 07:44:34', NULL),
(60, '201611301545186998', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:45:18', '2016-11-30 07:45:18', NULL),
(61, '201611301549189586', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:49:18', '2016-11-30 07:49:18', NULL),
(62, '201611301551033783', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:51:03', '2016-11-30 07:51:03', NULL),
(63, '201611301551264860', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已取消', NULL, '', NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:51:26', '2016-11-30 07:53:22', NULL),
(64, '201611301553432340', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:53:43', '2016-11-30 07:53:43', NULL),
(65, '201611301553575522', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 22, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:53:57', '2016-11-30 07:53:57', NULL),
(66, '201611301554054561', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:54:05', '2016-11-30 07:54:05', NULL),
(67, '201611301558223975', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:58:22', '2016-11-30 07:58:22', NULL),
(68, '201611301558372482', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:58:37', '2016-11-30 07:58:37', NULL),
(69, '201611301558566034', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:58:56', '2016-11-30 07:58:56', NULL),
(70, '201611301559148456', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:59:14', '2016-11-30 07:59:14', NULL),
(71, '201611301559278019', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 07:59:27', '2016-11-30 07:59:27', NULL),
(72, '201611301600397628', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:00:39', '2016-11-30 08:00:39', NULL),
(73, '201611301602562348', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:02:56', '2016-11-30 08:02:56', NULL),
(74, '201611301605466924', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:05:46', '2016-11-30 08:05:46', NULL),
(75, '201611301608359053', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:08:35', '2016-11-30 08:08:35', NULL),
(76, '201611301609116889', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:09:11', '2016-11-30 08:09:11', NULL),
(77, '201611301609487245', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:09:48', '2016-11-30 08:09:48', NULL),
(78, '201611301611015268', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:11:01', '2016-11-30 08:11:01', NULL),
(79, '201611301614161069', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:14:16', '2016-11-30 08:14:16', NULL),
(80, '201611301614322776', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:14:32', '2016-11-30 08:14:32', NULL),
(81, '201611301617355039', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:17:35', '2016-11-30 08:17:35', NULL),
(82, '201611301619184393', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:19:18', '2016-11-30 08:19:18', NULL),
(83, '201611301619283911', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:19:28', '2016-11-30 08:19:28', NULL),
(84, '201611301619492687', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:19:49', '2016-11-30 08:19:49', NULL),
(85, '201611301620039370', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:20:03', '2016-11-30 08:20:03', NULL),
(86, '201611301620571527', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:20:57', '2016-11-30 08:20:57', NULL),
(87, '201611301622148460', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:22:14', '2016-11-30 08:22:14', NULL),
(88, '201611301623097052', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:23:09', '2016-11-30 08:23:09', NULL),
(89, '201611301623198330', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:23:19', '2016-11-30 08:23:19', NULL),
(90, '201611301623482026', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:23:48', '2016-11-30 08:23:48', NULL),
(91, '201611301624079288', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:24:07', '2016-11-30 08:24:07', NULL),
(92, '201611301626331633', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:26:33', '2016-11-30 08:26:33', NULL),
(93, '201611301629063140', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:29:06', '2016-11-30 08:29:06', NULL),
(94, '201611301630197451', 0, 3, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:30:19', '2016-11-30 08:30:19', NULL),
(95, '201611301631132721', 0, 3, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:31:13', '2016-11-30 08:31:13', NULL),
(96, '201611301631486314', 0, 3, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:31:48', '2016-11-30 08:31:48', NULL),
(97, '201611301633472045', 0, 3, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:33:47', '2016-11-30 08:33:47', NULL),
(98, '201611301637548140', 0, 3, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:37:54', '2016-11-30 08:37:54', NULL),
(99, '201611301650073637', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:50:07', '2016-11-30 08:50:07', NULL),
(100, '201611301650531496', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:50:53', '2016-11-30 08:50:53', NULL),
(101, '201611301651055313', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:51:05', '2016-11-30 08:51:05', NULL),
(102, '201611301651254954', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:51:25', '2016-11-30 08:51:25', NULL),
(103, '201611301652461159', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 08:52:46', '2016-11-30 08:52:46', NULL),
(104, '201611301701146676', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1, '2016-11-30 09:01:14', '2016-11-30 10:18:30', NULL),
(105, '201611301830188719', 0, 6, 1, '有成本券', 1, NULL, '1.99', NULL, NULL, 21, 'asdasd', 'asdfasdf', '18649757679', '已支付', NULL, NULL, NULL, 0, NULL, NULL, 0, '0.00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2016-11-30 10:30:18', '2016-11-30 10:30:18', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `order_images`
--

CREATE TABLE IF NOT EXISTS `order_images` (
  `id` int(10) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `plots`
--

CREATE TABLE IF NOT EXISTS `plots` (
  `id` int(10) unsigned NOT NULL,
  `province` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `plots`
--

INSERT INTO `plots` (`id`, `province`, `city`, `area`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, '福建省', '福州市', '闽侯县', '闽江学院0', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(22, '福建省', '福州市', '闽侯县', '闽江学院1', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(23, '福建省', '福州市', '闽侯县', '闽江学院2', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(24, '福建省', '福州市', '闽侯县', '闽江学院3', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(25, '福建省', '福州市', '闽侯县', '闽江学院4', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(26, '福建省', '福州市', '闽侯县', '闽江学院5', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(27, '福建省', '福州市', '闽侯县', '闽江学院6', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(28, '福建省', '福州市', '闽侯县', '闽江学院7', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(29, '福建省', '福州市', '闽侯县', '闽江学院8', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(30, '福建省', '福州市', '闽侯县', '闽江学院9', '2016-11-28 13:01:27', '2016-11-28 13:01:27', NULL),
(31, '福建省', '福州市', '台江区', '123123', '2016-11-30 10:01:20', '2016-11-30 10:01:20', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `plot_properties`
--

CREATE TABLE IF NOT EXISTS `plot_properties` (
  `id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned NOT NULL,
  `plot_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `plot_properties`
--

INSERT INTO `plot_properties` (`id`, `property_id`, `plot_id`) VALUES
(1, 6, 21);

-- --------------------------------------------------------

--
-- 表的结构 `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `classification_id` int(10) unsigned NOT NULL,
  `value` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `types`
--

INSERT INTO `types` (`id`, `name`, `classification_id`, `value`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '海尔1号', 1, '0.00', 0, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(2, '海尔2号', 1, '0.00', 0, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(3, '松下1号', 2, '0.00', 0, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(4, '松下2号', 2, '0.00', 0, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `type_coupons`
--

CREATE TABLE IF NOT EXISTS `type_coupons` (
  `id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `coupon_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `type_coupons`
--

INSERT INTO `type_coupons` (`id`, `type_id`, `coupon_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(2, 1, 3, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(3, 2, 1, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(4, 2, 3, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(5, 3, 1, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(6, 3, 3, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(7, 4, 1, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(8, 4, 3, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `open_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sex` enum('男','女','未知') COLLATE utf8_unicode_ci NOT NULL DEFAULT '未知',
  `portrait` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` enum('默认','司机','业务员','入库员','出库员') COLLATE utf8_unicode_ci NOT NULL DEFAULT '默认',
  `plot_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `open_id`, `nickname`, `sex`, `portrait`, `mobile`, `role`, `plot_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '201611282101289847', '默认用户昵称', '未知', '#', '18144059419', '默认', 21, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(2, '201611282101284620', '司机昵称', '未知', '#', '18144059419', '司机', 21, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(3, '201611282101283151', '业务员昵称', '未知', '#', '18144059419', '默认', 21, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(4, '201611282101282617', '入库员昵称', '未知', '#', '18144059419', '入库员', 21, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(5, '201611282101287398', '出库员昵称', '未知', '#', '18144059419', '出库员', 21, '2016-11-28 13:01:28', '2016-11-28 13:01:28', NULL),
(6, 'o9GiLxCy67UFyYG4cJSq4MHTfplo', '林劲民', '男', 'http://wx.qlogo.cn/mmopen/eVVHemVN4pQ5euMs0VvVDpCTUvaIyVR7fQRHIMOHV8LjicJqM1lGiaB8oIsV6eArq08Q2JZFn8ic2rkA9uibdl4h8CAK93AicIZjt/0', '13635276231', '业务员', 21, '2016-11-29 08:24:49', '2016-11-30 07:54:05', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD KEY `admins_role_index` (`role`),
  ADD KEY `admins_plot_id_index` (`plot_id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_logs_admin_id_foreign` (`admin_id`),
  ADD KEY `admin_logs_ip_index` (`ip`),
  ADD KEY `admin_logs_type_index` (`type`);

--
-- Indexes for table `classifications`
--
ALTER TABLE `classifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classifications_name_index` (`name`),
  ADD KEY `classifications_type_index` (`type`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codes_code_unique` (`code`),
  ADD KEY `codes_admin_id_index` (`admin_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_name_index` (`name`),
  ADD KEY `coupons_type_index` (`type`);

--
-- Indexes for table `coupon_numbers`
--
ALTER TABLE `coupon_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_numbers_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_numbers_order_id_foreign` (`order_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_admin_id_index` (`admin_id`),
  ADD KEY `forms_status_index` (`status`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_mobile_index` (`mobile`),
  ADD KEY `messages_ip_index` (`ip`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_from_id_index` (`from_id`),
  ADD KEY `notifications_to_id_index` (`to_id`),
  ADD KEY `notifications_type_index` (`type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_number_unique` (`number`),
  ADD KEY `orders_plot_id_foreign` (`plot_id`),
  ADD KEY `orders_cfm_type_id_foreign` (`cfm_type_id`),
  ADD KEY `orders_property_id_foreign` (`property_id`),
  ADD KEY `orders_driver_id_foreign` (`driver_id`),
  ADD KEY `orders_out_id_foreign` (`out_id`),
  ADD KEY `orders_in_id_foreign` (`in_id`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_type_id_index` (`type_id`),
  ADD KEY `orders_type_index` (`type`),
  ADD KEY `orders_type_coupon_id_index` (`type_coupon_id`),
  ADD KEY `orders_coupon_id_index` (`coupon_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_code_id_index` (`code_id`);

--
-- Indexes for table `order_images`
--
ALTER TABLE `order_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_images_order_id_index` (`order_id`);

--
-- Indexes for table `plots`
--
ALTER TABLE `plots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plots_province_index` (`province`),
  ADD KEY `plots_city_index` (`city`),
  ADD KEY `plots_area_index` (`area`),
  ADD KEY `plots_name_index` (`name`);

--
-- Indexes for table `plot_properties`
--
ALTER TABLE `plot_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plot_properties_property_id_foreign` (`property_id`),
  ADD KEY `plot_properties_plot_id_foreign` (`plot_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `types_name_index` (`name`),
  ADD KEY `types_classification_id_index` (`classification_id`);

--
-- Indexes for table `type_coupons`
--
ALTER TABLE `type_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_coupons_type_id_index` (`type_id`),
  ADD KEY `type_coupons_coupon_id_index` (`coupon_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_open_id_unique` (`open_id`),
  ADD KEY `users_nickname_index` (`nickname`),
  ADD KEY `users_mobile_index` (`mobile`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_plot_id_index` (`plot_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `classifications`
--
ALTER TABLE `classifications`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `coupon_numbers`
--
ALTER TABLE `coupon_numbers`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `order_images`
--
ALTER TABLE `order_images`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plots`
--
ALTER TABLE `plots`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `plot_properties`
--
ALTER TABLE `plot_properties`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `type_coupons`
--
ALTER TABLE `type_coupons`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- 限制导出的表
--

--
-- 限制表 `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_plot_id_foreign` FOREIGN KEY (`plot_id`) REFERENCES `plots` (`id`) ON DELETE CASCADE;

--
-- 限制表 `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- 限制表 `codes`
--
ALTER TABLE `codes`
  ADD CONSTRAINT `codes_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- 限制表 `coupon_numbers`
--
ALTER TABLE `coupon_numbers`
  ADD CONSTRAINT `coupon_numbers_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_numbers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- 限制表 `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- 限制表 `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_cfm_type_id_foreign` FOREIGN KEY (`cfm_type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_code_id_foreign` FOREIGN KEY (`code_id`) REFERENCES `codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_in_id_foreign` FOREIGN KEY (`in_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_out_id_foreign` FOREIGN KEY (`out_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_plot_id_foreign` FOREIGN KEY (`plot_id`) REFERENCES `plots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_type_coupon_id_foreign` FOREIGN KEY (`type_coupon_id`) REFERENCES `type_coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `order_images`
--
ALTER TABLE `order_images`
  ADD CONSTRAINT `order_images_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- 限制表 `plot_properties`
--
ALTER TABLE `plot_properties`
  ADD CONSTRAINT `plot_properties_plot_id_foreign` FOREIGN KEY (`plot_id`) REFERENCES `plots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plot_properties_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `types`
--
ALTER TABLE `types`
  ADD CONSTRAINT `types_classification_id_foreign` FOREIGN KEY (`classification_id`) REFERENCES `classifications` (`id`) ON DELETE CASCADE;

--
-- 限制表 `type_coupons`
--
ALTER TABLE `type_coupons`
  ADD CONSTRAINT `type_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `type_coupons_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- 限制表 `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_plot_id_foreign` FOREIGN KEY (`plot_id`) REFERENCES `plots` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
