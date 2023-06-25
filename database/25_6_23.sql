-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2023 at 11:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rangs_hr_rml`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_password_history`
--

CREATE TABLE `tbl_password_history` (
  `id` int(11) NOT NULL,
  `changed_date` date DEFAULT NULL,
  `changed_by` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_password_history`
--

INSERT INTO `tbl_password_history` (`id`, `changed_date`, `changed_by`) VALUES
(6, '2022-11-29', 'RML-00954'),
(7, '2022-12-12', 'RML-00955'),
(8, '2023-01-15', 'RMWL-0634'),
(9, '2023-01-17', 'RML-01228'),
(10, '2023-01-22', 'RMWL-0605'),
(11, '2023-01-22', 'RMWL-0107'),
(12, '2023-02-08', 'RML-01129');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `permission_module_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`id`, `name`, `slug`, `permission_module_id`, `created_at`, `updated_at`) VALUES
(1, 'Role-List', 'role-list', 1, '2023-06-01 00:46:25', '2023-06-01 00:46:25'),
(2, 'Role-Create', 'role-create', 1, '2023-06-01 00:46:29', '2023-06-01 00:46:29'),
(3, 'Role-Edit', 'role-edit', 1, '2023-06-01 00:46:32', '2023-06-01 00:46:32'),
(4, 'Role-Delete', 'role-delete', 1, '2023-06-01 00:46:36', '2023-06-01 00:46:36'),
(5, 'Permission-List', 'permission-list', 1, '2023-06-01 00:46:56', '2023-06-01 00:46:56'),
(6, 'Permission-Create', 'permission-create', 1, '2023-06-01 00:47:05', '2023-06-01 00:47:05'),
(7, 'Permission-Edit', 'permission-edit', 1, '2023-06-01 00:47:09', '2023-06-01 00:47:09'),
(8, 'Permission-Delete', 'permission-delete', 1, '2023-06-01 00:47:13', '2023-06-01 00:47:13'),
(9, 'Role-Permission-List', 'role-permission-list', 1, '2023-06-01 00:47:32', '2023-06-01 00:47:32'),
(10, 'Role-Permission-Create', 'role-permission-create', 1, '2023-06-01 00:47:35', '2023-06-01 00:47:35'),
(11, 'Role-Permission-Edit', 'role-permission-edit', 1, '2023-06-01 00:47:38', '2023-06-01 00:47:38'),
(12, 'Role-Permission-Delete', 'role-permission-delete', 1, '2023-06-01 00:47:42', '2023-06-01 00:47:42'),
(13, 'User-Role-List', 'user-role-list', 1, '2023-06-01 00:48:23', '2023-06-01 00:48:23'),
(14, 'User-Role-Create', 'user-role-create', 1, '2023-06-01 00:48:52', '2023-06-01 00:48:52'),
(15, 'User-Role-Edit', 'user-role-edit', 1, '2023-06-01 00:48:55', '2023-06-01 00:48:55'),
(16, 'User-Role-Delete', 'user-role-delete', 1, '2023-06-01 00:48:58', '2023-06-01 00:48:58'),
(17, 'PMS-List', 'pms-list', 5, '2023-06-04 03:19:19', '2023-06-04 03:19:19'),
(18, 'PMS-Create', 'pms-create', 5, '2023-06-04 03:19:22', '2023-06-04 03:19:22'),
(19, 'PMS-Edit', 'pms-edit', 5, '2023-06-04 03:19:31', '2023-06-04 03:19:31'),
(20, 'PMS-Delete', 'pms-delete', 5, '2023-06-04 03:19:38', '2023-06-04 03:19:38'),
(21, 'PMS-Year-List', 'pms-year-list', 5, '2023-06-04 03:19:51', '2023-06-04 03:19:51'),
(22, 'PMS-Year-Create', 'pms-year-create', 5, '2023-06-04 03:19:54', '2023-06-04 03:19:54'),
(23, 'PMS-Year-Edit', 'pms-year-edit', 5, '2023-06-04 03:20:00', '2023-06-04 03:20:00'),
(24, 'PMS-Year-Delete', 'pms-year-delete', 5, '2023-06-04 03:20:04', '2023-06-04 03:20:04'),
(25, 'PMS-KRA-List', 'pms-kra-list', 5, '2023-06-04 03:22:12', '2023-06-04 03:22:12'),
(26, 'PMS-KRA-Create', 'pms-kra-create', 5, '2023-06-04 03:22:15', '2023-06-04 03:22:15'),
(27, 'PMS-KRA-Edit', 'pms-kra-edit', 5, '2023-06-04 03:22:18', '2023-06-04 03:22:18'),
(28, 'PMS-KRA-Delete', 'pms-kra-delete', 5, '2023-06-04 03:22:23', '2023-06-04 03:22:23'),
(29, 'PMS-KPI-List', 'pms-kpi-list', 5, '2023-06-04 03:22:34', '2023-06-04 03:22:34'),
(30, 'PMS-KPI-Create', 'pms-kpi-create', 5, '2023-06-04 03:22:37', '2023-06-04 03:22:37'),
(31, 'PMS-KPI-Edit', 'pms-kpi-edit', 5, '2023-06-04 03:22:41', '2023-06-04 03:22:41'),
(32, 'PMS-KPI-Delete', 'pms-kpi-delete', 5, '2023-06-04 03:23:43', '2023-06-04 03:23:43'),
(39, 'Self-Leave-List', 'self-leave-list', 2, '2023-06-04 04:02:55', '2023-06-04 04:02:55'),
(40, 'Self-Leave-Create', 'self-leave-create', 2, '2023-06-04 04:02:58', '2023-06-04 04:02:58'),
(41, 'Self-Leave-Edit', 'self-leave-edit', 2, '2023-06-04 04:03:02', '2023-06-04 04:03:02'),
(42, 'Self-Leave-Delete', 'self-leave-delete', 2, '2023-06-04 04:03:05', '2023-06-04 04:03:05'),
(51, 'HR-Leave-List', 'hr-leave-list', 2, NULL, NULL),
(52, 'HR-Leave-Create', 'hr-leave-create', 2, NULL, NULL),
(53, 'HR-Leave-Edit', 'hr-leave-edit', 2, NULL, NULL),
(54, 'HR-Leave-Delete', 'hr-leave-delete', 2, NULL, NULL),
(55, 'LM-Leave-List', 'lm-leave-list', 2, NULL, NULL),
(56, 'LM-Leave-Create', 'lm-leave-create', 2, NULL, NULL),
(57, 'LM-Leave-Edit', 'lm-leave-edit', 2, NULL, NULL),
(58, 'LM-Leave-Delete', 'lm-leave-delete', 2, NULL, NULL),
(59, 'Concern-Leave-List', 'concern-leave-list', 2, NULL, NULL),
(60, 'Concern-Leave-Create', 'concern-leave-create', 2, NULL, NULL),
(61, 'Concern-Leave-Edit', 'concern-leave-edit', 2, NULL, NULL),
(62, 'Concern-Leave-Delete', 'concern-leave-delete', 2, NULL, NULL),
(63, 'Self-Tour-Report', 'self-tour-report', 3, NULL, NULL),
(64, 'Self-Tour-Create', 'self-tour-create', 3, NULL, NULL),
(65, 'Self-Tour-Edit', 'self-tour-edit', 3, NULL, NULL),
(66, 'Self-Tour-Delete', 'self-tour-delete', 3, NULL, NULL),
(67, 'HR-Tour-Report', 'hr-tour-report', 3, NULL, NULL),
(68, 'HR-Tour-Create', 'hr-tour-create', 3, NULL, NULL),
(69, 'HR-Tour-Edit', 'hr-tour-edit', 3, NULL, NULL),
(70, 'HR-Tour-Delete', 'hr-tour-delete', 3, NULL, NULL),
(71, 'LM-Tour-Report', 'lm-tour-report', 3, NULL, NULL),
(72, 'LM-Tour-Create', 'lm-tour-create', 3, NULL, NULL),
(73, 'LM-Tour-Edit', 'lm-tour-edit', 3, NULL, NULL),
(74, 'LM-Tour-Delete', 'lm-tour-delete', 3, NULL, NULL),
(75, 'Concern-Tour-Report', 'concern-tour-report', 3, NULL, NULL),
(76, 'Concern-Tour-Create', 'concern-tour-create', 3, NULL, NULL),
(77, 'Concern-Tour-Edit', 'concern-tour-edit', 3, NULL, NULL),
(78, 'Concern-Tour-Delete', 'concern-tour-delete', 3, NULL, NULL),
(80, 'Roster-Create', 'roster-create', 7, NULL, NULL),
(81, 'Roster-List', 'roster-list', 7, NULL, NULL),
(82, 'Self-Attendance-Report', 'self-attendance-report', 4, NULL, NULL),
(83, 'HR-Attendance-Create', 'hr-attendance-create', 4, NULL, NULL),
(84, 'HR-Attendance-Single-Report', 'hr-attendance-single-report', 4, NULL, NULL),
(85, 'HR-Attendance-Advance-Report', 'hr-attendance-advance-report', 4, NULL, NULL),
(86, 'HR-Attendance-Punch-Data-Syn', 'hr-attendance-punch-data-syn', 4, NULL, NULL),
(87, 'LM-Attendance-Report', 'lm-attendance-report', 4, NULL, NULL),
(88, 'LM-Attendance-Create', 'lm-attendance-create', 4, NULL, NULL),
(89, 'Concern-Attendance-Report', 'concern-attendance-report', 4, NULL, NULL),
(90, 'Concern-Attendance-Create', 'concern-attendance-create', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permission_module`
--

CREATE TABLE `tbl_permission_module` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_permission_module`
--

INSERT INTO `tbl_permission_module` (`id`, `name`) VALUES
(1, 'Role & Permission '),
(2, 'Leave Module'),
(3, 'Tour Module'),
(4, 'Attendance  Module'),
(5, 'PMS Module'),
(7, 'Roster Module');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `name`, `slug`) VALUES
(1, 'Super Admin', 'super-admin'),
(2, 'HR', 'hr'),
(3, 'Line Manger', 'line-manger'),
(6, 'Concern', 'concern'),
(7, 'Public', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles_permissions`
--

CREATE TABLE `tbl_roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_roles_permissions`
--

INSERT INTO `tbl_roles_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 39),
(34, 1, 40),
(35, 1, 41),
(36, 1, 42),
(37, 1, 51),
(38, 1, 52),
(39, 1, 53),
(40, 1, 54),
(41, 1, 55),
(42, 1, 56),
(43, 1, 57),
(44, 1, 58),
(45, 1, 59),
(46, 1, 60),
(47, 1, 61),
(48, 1, 62),
(49, 1, 63),
(50, 1, 64),
(51, 1, 65),
(52, 1, 66),
(53, 1, 67),
(54, 1, 68),
(55, 1, 69),
(56, 1, 70),
(57, 1, 71),
(58, 1, 72),
(59, 1, 73),
(60, 1, 74),
(61, 1, 75),
(62, 1, 76),
(63, 1, 77),
(64, 1, 78),
(65, 1, 80),
(66, 1, 81),
(67, 1, 82),
(68, 1, 83),
(69, 1, 84),
(70, 1, 85),
(71, 1, 86),
(72, 1, 87),
(73, 1, 88),
(74, 1, 89),
(75, 1, 90),
(76, 2, 1),
(77, 2, 2),
(78, 2, 3),
(79, 2, 4),
(80, 2, 5),
(81, 2, 6),
(82, 2, 7),
(83, 2, 8),
(84, 2, 9),
(85, 2, 10),
(86, 2, 11),
(87, 2, 12),
(88, 2, 13),
(89, 2, 14),
(90, 2, 15),
(91, 2, 16),
(92, 2, 17),
(93, 2, 18),
(94, 2, 19),
(95, 2, 20),
(96, 2, 21),
(97, 2, 22),
(98, 2, 23),
(99, 2, 24),
(100, 2, 25),
(101, 2, 26),
(102, 2, 27),
(103, 2, 28),
(104, 2, 29),
(105, 2, 30),
(106, 2, 31),
(107, 2, 32),
(108, 2, 39),
(109, 2, 40),
(110, 2, 41),
(111, 2, 42),
(112, 2, 51),
(113, 2, 52),
(114, 2, 53),
(115, 2, 54),
(116, 2, 63),
(117, 2, 64),
(118, 2, 65),
(119, 2, 66),
(120, 2, 67),
(121, 2, 68),
(122, 2, 69),
(123, 2, 70),
(124, 2, 80),
(125, 2, 81),
(126, 2, 82),
(127, 2, 83),
(128, 2, 84),
(129, 2, 85),
(130, 2, 86),
(131, 6, 1),
(132, 6, 2),
(133, 6, 3),
(134, 6, 4),
(135, 6, 5),
(136, 6, 6),
(137, 6, 7),
(138, 6, 8),
(139, 6, 9),
(140, 6, 10),
(141, 6, 11),
(142, 6, 12),
(143, 6, 13),
(144, 6, 14),
(145, 6, 15),
(146, 6, 16),
(147, 6, 17),
(148, 6, 18),
(149, 6, 19),
(150, 6, 20),
(151, 6, 21),
(152, 6, 22),
(153, 6, 23),
(154, 6, 24),
(155, 6, 25),
(156, 6, 26),
(157, 6, 27),
(158, 6, 28),
(159, 6, 29),
(160, 6, 30),
(161, 6, 31),
(162, 6, 32),
(163, 6, 39),
(164, 6, 40),
(165, 6, 41),
(166, 6, 42),
(167, 6, 59),
(168, 6, 60),
(169, 6, 61),
(170, 6, 62),
(171, 6, 63),
(172, 6, 64),
(173, 6, 65),
(174, 6, 66),
(175, 6, 75),
(176, 6, 76),
(177, 6, 77),
(178, 6, 78),
(179, 6, 80),
(180, 6, 81),
(181, 6, 82),
(182, 6, 89),
(183, 6, 90),
(184, 7, 17),
(185, 7, 18),
(186, 7, 19),
(187, 7, 20),
(188, 7, 25),
(189, 7, 26),
(190, 7, 27),
(191, 7, 28),
(192, 7, 29),
(193, 7, 30),
(194, 7, 31),
(195, 7, 32),
(196, 7, 39),
(197, 7, 40),
(198, 7, 41),
(199, 7, 42),
(200, 7, 63),
(201, 7, 64),
(202, 7, 65),
(203, 7, 66),
(204, 7, 82),
(205, 3, 17),
(206, 3, 18),
(207, 3, 19),
(208, 3, 20),
(209, 3, 25),
(210, 3, 26),
(211, 3, 27),
(212, 3, 28),
(213, 3, 29),
(214, 3, 30),
(215, 3, 31),
(216, 3, 32),
(217, 3, 39),
(218, 3, 40),
(219, 3, 41),
(220, 3, 42),
(221, 3, 63),
(222, 3, 64),
(223, 3, 65),
(224, 3, 66),
(225, 3, 82);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `emp_id` varchar(20) NOT NULL,
  `concern` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `real_pass` varchar(100) NOT NULL,
  `image_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_role_id`, `first_name`, `emp_id`, `concern`, `email`, `password`, `real_pass`, `image_url`) VALUES
(1, 4, 'Md. Al Firoz Hossain', 'RML-00955', 'ALL', 'firoz.hossain@rangsgroup.com', '0192023a7bbd73250516f069df18b500', '', NULL),
(2, 7, 'Sohana Rouf Chowdhury', 'RG', 'RML', 'syed.elahee@rangsgroup.com', '33b79f4cf1ba9b2d421cf02d5edfe1a2', '', NULL),
(3, 3, 'Mirza Md. Ahsan Reza', 'RML-00124', 'RML', 'ahsan.reza@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(4, 3, 'Anisur Rahman Sohel', 'RML-00027', 'RML', 'anisur.sohel@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(5, 3, 'Ashraful Bari', 'RML-00002', 'RML', 'ashraful.bari@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(6, 3, 'Ajoy Kumar Deb', 'RML-00302', 'RML', 'ajoy.deb@rangsgroup.com', '', '', NULL),
(7, 3, 'Md.Rafiqul Islam', 'RML-00384', 'RML', 'rafiq.razim@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(8, 5, 'Md. Omar Ali', 'RMWL-0634', 'RML', 'mehraj.hamid@rangsgroup.com', '5221bec79466e4a4c8d2dc873d2a5019', 'o634', NULL),
(9, 3, 'Satyajit Saha', 'RML-00003', 'RML', 'ss@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(10, 3, 'Shawkat Ahmed Siddiky', 'RML-00301', 'RML', 'ss@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(11, 3, 'Md. Amanullah Khan', 'RML-00272', 'RML', 'ss@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(12, 3, 'Md. Faisal Hasan', 'RML-00814', 'RML', 'ss@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(13, 3, 'Shakawat Mahmud', 'RML-00339', 'RML', 'ss@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(14, 2, 'Rashedur Rahman', 'RML-00601', 'ALL', 'rashedur.rahman@rangsgroup.com', '41355B8740AA139E2D631072CA25623A', '601@@', NULL),
(15, 3, 'Shaikh Abidur Rahman', 'RML-00516', 'RML', 'abid.rahman@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(16, 3, 'Sohana Rouf Chowdhury', 'RG001', 'RG', '', '0192023a7bbd73250516f069df18b500', '123', NULL),
(17, 5, 'Anamul Hoque', 'RMWL-0107', 'RMWL', 'anamul.hoque@rangsgroup.com', 'de1efd0dbe48eb5d67914c3c81df6b90', '5959', NULL),
(18, 5, 'Md. Zakir Hossain Chowdhury', 'RMWL-0222', 'RMWL', 'zakir.hossain@rangsgroup.com', '010E406DF2463597C58286A93F8B3160', '5959', NULL),
(19, 5, 'Dity Roy', 'RMWL-0605', 'RMWL', 'dity.roy@rangsgroup.com', 'b76bfff9cf6e4343ee9b3ad54b668f7e', '5959', NULL),
(20, 3, 'Rajesh Kumar Datta', 'RML-00028', 'LM', 'rajesh.datta@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(22, 4, 'Sholayman Hossain', 'RML-00954', 'ALL', 'sholayman.hossain@rangsgroup.com', '45ba6efe56c97f49d4c8ef04e2c9d616', 'RML-00954', NULL),
(23, 4, 'Pabitra Kumar Das', 'RML-00822', 'RML', 'pabitra.kumar@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(24, 3, 'Asya Kashem Asma', 'RML-00632', 'ALL', 'asya.kashem@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(25, 3, 'Md. Saiful Hasan', 'RML-00005', 'RML', 'saiful.hasan@rangsgroup.com', '9ea412ce79f7f107ab11930876cb6947', '123456', NULL),
(26, 4, 'Golam Rafiq Saroar', 'RML-01120', 'RML', 'golam.saroar@rangsgroup.com', '9D49DCED94CD3DC0EE0B783C73F19D4C', '01120', NULL),
(27, 1, 'IT Admin', 'IT', 'ALL', 'firoz.hossain@rangsgroup.com', '0192023a7bbd73250516f069df18b500', '', NULL),
(28, 3, 'Touhidur Rahman', 'RML-00120', 'ALL', 'touhidur.rahman@rangsgroup.com', '70C3FB494F99ED2A1335D581F5C6AEE0', '120120', NULL),
(29, 3, 'Hafizul Islam', 'RML-01207', 'RML', 'hafiz.islam@rangsgroup.com', 'E10ADC3949BA59ABBE56E057F20F883E', '123456', NULL),
(30, 6, 'Ahmmad Monsur Rouf', 'SASH-3051', 'SASH', NULL, 'E10ADC3949BA59ABBE56E057F20F883E', '1234', NULL),
(31, 2, 'Md. Fahad Islam', 'RML-01045', 'RML', 'fahad.islam@rangsgroup.com', 'cb0c3a5fd92c23ea9a157f2a29c19d06', 'fahad.islam', NULL),
(32, 3, 'Syed Mahbub Hossain', 'RML-00024', 'RML', 'mahbub.hossain@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(38, 4, 'Upal Khastagir', 'RML-00192', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(39, 4, 'Tashnuva Tanzin Bidita', 'RML-00068', 'RML', 'webuser@mail.com', '7ec7a97c9077baac8686043ac9bd75d5', '00068', NULL),
(40, 3, 'Golam M Sayeem', 'RML-01231', 'RML', 'webuser@mail.com', 'fc5ee40071d6d41e0e5a8633c8cb96b4', '01231', NULL),
(41, 3, 'Md. Shaiful Islam', 'RML-00878', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(42, 4, 'Sandip Saha', 'RML-01228', 'RML', 'webuser@mail.com', '947bcdb7bf5113c9cc50e7e25a62de5b', '01228', NULL),
(43, 4, 'Year Md Galib', 'RML-01117', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(44, 4, 'Kazi Masuma Akter', 'RML-01112', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(45, 3, 'Pralaya Shankar Bandyopadhyaya', 'RML-00009', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(46, 4, 'Md. Abdur Rahman', 'RML-00202', 'RML', 'abdur.rahman@rangsgroup.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(47, 3, 'S. M. Faysal Reza', 'RML-01129', 'RML', 'webuser@mail.com', 'f6257d428eb550780fd1734f724d2228', '123456', NULL),
(48, 4, 'Hasan Mahamud', 'RML-00713', 'RML', 'dd@gmail.com', '07C5807D0D927DCD0980F86024E5208B', '713', NULL),
(49, 4, 'Avijit Roy', 'RML-01115', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(50, 3, 'Ahmed Shahriar Anwar', 'RML-01248', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(51, 4, 'Md. Zahirul Islam', 'RMWL-0887', 'RML', 'webuser@mail.com', '0192023a7bbd73250516f069df18b500', '123456', NULL),
(52, 2, 'Joy Paul', 'RML-01260', 'RML', 'joy.paul@rangsgroup.com', '0192023a7bbd73250516f069df18b500', 'admin123', 'uploads/50_1686633365.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_permissions`
--

CREATE TABLE `tbl_users_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users_permissions`
--

INSERT INTO `tbl_users_permissions` (`id`, `user_id`, `permission_id`) VALUES
(151, 1, 1),
(152, 1, 2),
(153, 1, 3),
(154, 1, 4),
(155, 1, 5),
(156, 1, 6),
(157, 1, 7),
(158, 1, 8),
(159, 1, 9),
(160, 1, 10),
(161, 1, 11),
(162, 1, 12),
(163, 1, 13),
(164, 1, 14),
(165, 1, 15),
(166, 1, 16),
(167, 1, 17),
(168, 1, 18),
(169, 1, 19),
(170, 1, 20),
(171, 1, 21),
(172, 1, 22),
(173, 1, 23),
(174, 1, 24),
(175, 1, 25),
(176, 1, 26),
(177, 1, 27),
(178, 1, 28),
(179, 1, 29),
(180, 1, 30),
(181, 1, 31),
(182, 1, 32),
(183, 1, 39),
(184, 1, 40),
(185, 1, 41),
(186, 1, 42),
(187, 1, 51),
(188, 1, 52),
(189, 1, 53),
(190, 1, 54),
(191, 1, 55),
(192, 1, 56),
(193, 1, 57),
(194, 1, 58),
(195, 1, 59),
(196, 1, 60),
(197, 1, 61),
(198, 1, 62),
(199, 1, 63),
(200, 1, 64),
(201, 1, 65),
(202, 1, 66),
(203, 1, 67),
(204, 1, 68),
(205, 1, 69),
(206, 1, 70),
(207, 1, 71),
(208, 1, 72),
(209, 1, 73),
(210, 1, 74),
(211, 1, 75),
(212, 1, 76),
(213, 1, 77),
(214, 1, 78),
(215, 1, 80),
(216, 1, 81),
(217, 1, 82),
(218, 1, 83),
(219, 1, 84),
(220, 1, 85),
(221, 1, 86),
(222, 1, 87),
(223, 1, 88),
(224, 1, 89),
(225, 1, 90),
(226, 52, 17),
(227, 52, 18),
(228, 52, 19),
(229, 52, 20),
(230, 52, 25),
(231, 52, 26),
(232, 52, 27),
(233, 52, 28),
(234, 52, 29),
(235, 52, 30),
(236, 52, 31),
(237, 52, 32),
(238, 52, 39),
(239, 52, 40),
(240, 52, 41),
(241, 52, 42),
(242, 52, 63),
(243, 52, 64),
(244, 52, 65),
(245, 52, 66),
(246, 52, 82),
(247, 52, 1),
(248, 52, 2),
(249, 52, 3),
(250, 52, 4),
(251, 52, 5),
(252, 52, 6),
(253, 52, 7),
(254, 52, 8),
(255, 52, 9),
(256, 52, 10),
(257, 52, 11),
(258, 52, 12),
(259, 52, 13),
(260, 52, 14),
(261, 52, 15),
(262, 52, 16),
(263, 52, 21),
(264, 52, 22),
(265, 52, 23),
(266, 52, 24),
(267, 52, 51),
(268, 52, 52),
(269, 52, 53),
(270, 52, 54),
(271, 52, 55),
(272, 52, 56),
(273, 52, 57),
(274, 52, 58),
(275, 52, 59),
(276, 52, 60),
(277, 52, 61),
(278, 52, 62),
(279, 52, 67),
(280, 52, 68),
(281, 52, 69),
(282, 52, 70),
(283, 52, 71),
(284, 52, 72),
(285, 52, 73),
(286, 52, 74),
(287, 52, 75),
(288, 52, 76),
(289, 52, 77),
(290, 52, 78),
(291, 52, 80),
(292, 52, 81),
(293, 52, 83),
(294, 52, 84),
(295, 52, 85),
(296, 52, 86),
(297, 52, 87),
(298, 52, 88),
(299, 52, 89),
(300, 52, 90);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_roles`
--

CREATE TABLE `tbl_users_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users_roles`
--

INSERT INTO `tbl_users_roles` (`id`, `user_id`, `role_id`) VALUES
(17, 1, 1),
(18, 52, 7),
(19, 52, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `id` int(11) NOT NULL,
  `user_role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
(1, 'ADMIN'),
(2, 'HR'),
(3, 'LM'),
(4, 'NU'),
(5, 'RMWL'),
(6, 'SASH'),
(7, 'Test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_password_history`
--
ALTER TABLE `tbl_password_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_module_id`);

--
-- Indexes for table `tbl_permission_module`
--
ALTER TABLE `tbl_permission_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles_permissions`
--
ALTER TABLE `tbl_roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- Indexes for table `tbl_users_permissions`
--
ALTER TABLE `tbl_users_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `tbl_users_roles`
--
ALTER TABLE `tbl_users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `users_roles_ibfk_1` (`role_id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_password_history`
--
ALTER TABLE `tbl_password_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_permission_module`
--
ALTER TABLE `tbl_permission_module`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_roles_permissions`
--
ALTER TABLE `tbl_roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tbl_users_permissions`
--
ALTER TABLE `tbl_users_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `tbl_users_roles`
--
ALTER TABLE `tbl_users_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_roles_permissions`
--
ALTER TABLE `tbl_roles_permissions`
  ADD CONSTRAINT `tbl_roles_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`),
  ADD CONSTRAINT `tbl_roles_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `tbl_permissions` (`id`);

--
-- Constraints for table `tbl_users_permissions`
--
ALTER TABLE `tbl_users_permissions`
  ADD CONSTRAINT `tbl_users_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `tbl_permissions` (`id`),
  ADD CONSTRAINT `tbl_users_permissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

--
-- Constraints for table `tbl_users_roles`
--
ALTER TABLE `tbl_users_roles`
  ADD CONSTRAINT `tbl_users_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`),
  ADD CONSTRAINT `tbl_users_roles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
