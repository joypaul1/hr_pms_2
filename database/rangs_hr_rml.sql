-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 01:52 PM
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Role-List', 'role-list', '2023-06-01 00:46:25', '2023-06-01 00:46:25'),
(2, 'Role-Create', 'role-create', '2023-06-01 00:46:29', '2023-06-01 00:46:29'),
(3, 'Role-Edit', 'role-edit', '2023-06-01 00:46:32', '2023-06-01 00:46:32'),
(4, 'Role-Delete', 'role-delete', '2023-06-01 00:46:36', '2023-06-01 00:46:36'),
(5, 'Permission-List', 'permission-list', '2023-06-01 00:46:56', '2023-06-01 00:46:56'),
(6, 'Permission-Create', 'permission-create', '2023-06-01 00:47:05', '2023-06-01 00:47:05'),
(7, 'Permission-Edit', 'permission-edit', '2023-06-01 00:47:09', '2023-06-01 00:47:09'),
(8, 'Permission-Delete', 'permission-delete', '2023-06-01 00:47:13', '2023-06-01 00:47:13'),
(9, 'Role-Permission-List', 'role-permission-list', '2023-06-01 00:47:32', '2023-06-01 00:47:32'),
(10, 'Role-Permission-Create', 'role-permission-create', '2023-06-01 00:47:35', '2023-06-01 00:47:35'),
(11, 'Role-Permission-Edit', 'role-permission-edit', '2023-06-01 00:47:38', '2023-06-01 00:47:38'),
(12, 'Role-Permission-Delete', 'role-permission-delete', '2023-06-01 00:47:42', '2023-06-01 00:47:42'),
(13, 'User-Role-List', 'user-role-list', '2023-06-01 00:48:23', '2023-06-01 00:48:23'),
(14, 'User-Role-Create', 'user-role-create', '2023-06-01 00:48:52', '2023-06-01 00:48:52'),
(15, 'User-Role-Edit', 'user-role-edit', '2023-06-01 00:48:55', '2023-06-01 00:48:55'),
(16, 'User-Role-Delete', 'user-role-delete', '2023-06-01 00:48:58', '2023-06-01 00:48:58'),
(17, 'PMS-List', 'pms-list', '2023-06-04 03:19:19', '2023-06-04 03:19:19'),
(18, 'PMS-Create', 'pms-create', '2023-06-04 03:19:22', '2023-06-04 03:19:22'),
(19, 'PMS-Edit', 'pms-edit', '2023-06-04 03:19:31', '2023-06-04 03:19:31'),
(20, 'PMS-Delete', 'pms-delete', '2023-06-04 03:19:38', '2023-06-04 03:19:38'),
(21, 'PMS-Year-List', 'pms-year-list', '2023-06-04 03:19:51', '2023-06-04 03:19:51'),
(22, 'PMS-Year-Create', 'pms-year-create', '2023-06-04 03:19:54', '2023-06-04 03:19:54'),
(23, 'PMS-Year-Edit', 'pms-year-edit', '2023-06-04 03:20:00', '2023-06-04 03:20:00'),
(24, 'PMS-Year-Delete', 'pms-year-delete', '2023-06-04 03:20:04', '2023-06-04 03:20:04'),
(25, 'PMS-KRA-List', 'pms-kra-list', '2023-06-04 03:22:12', '2023-06-04 03:22:12'),
(26, 'PMS-KRA-Create', 'pms-kra-create', '2023-06-04 03:22:15', '2023-06-04 03:22:15'),
(27, 'PMS-KRA-Edit', 'pms-kra-edit', '2023-06-04 03:22:18', '2023-06-04 03:22:18'),
(28, 'PMS-KRA-Delete', 'pms-kra-delete', '2023-06-04 03:22:23', '2023-06-04 03:22:23'),
(29, 'PMS-KPI-List', 'pms-kpi-list', '2023-06-04 03:22:34', '2023-06-04 03:22:34'),
(30, 'PMS-KPI-Create', 'pms-kpi-create', '2023-06-04 03:22:37', '2023-06-04 03:22:37'),
(31, 'PMS-KPI-Edit', 'pms-kpi-edit', '2023-06-04 03:22:41', '2023-06-04 03:22:41'),
(32, 'PMS-KPI-Delete', 'pms-kpi-delete', '2023-06-04 03:23:43', '2023-06-04 03:23:43'),
(33, 'Report -Outdoor- Attendance', 'report-outdoor-attendance', '2023-06-04 03:32:05', '2023-06-04 03:36:28'),
(34, 'Report -Self- Attendance', 'report-self-attendance', '2023-06-04 04:01:35', '2023-06-04 04:01:35'),
(35, 'Tour-List', 'tour-list', '2023-06-04 04:01:44', '2023-06-04 04:01:54'),
(36, 'Tour-Create', 'tour-create', '2023-06-04 04:01:58', '2023-06-04 04:01:58'),
(37, 'Tour-Edit', 'tour-edit', '2023-06-04 04:02:02', '2023-06-04 04:02:02'),
(38, 'Tour-Delete', 'tour-delete', '2023-06-04 04:02:06', '2023-06-04 04:02:06'),
(39, 'Leave-List', 'leave-list', '2023-06-04 04:02:55', '2023-06-04 04:02:55'),
(40, 'Leave-Create', 'leave-create', '2023-06-04 04:02:58', '2023-06-04 04:02:58'),
(41, 'Leave-Edit', 'leave-edit', '2023-06-04 04:03:02', '2023-06-04 04:03:02'),
(42, 'Leave-Delete', 'leave-delete', '2023-06-04 04:03:05', '2023-06-04 04:03:05'),
(43, 'User-List', 'user-list', '2023-06-04 04:38:11', '2023-06-04 04:38:11'),
(44, 'User-Create', 'user-create', '2023-06-04 04:38:18', '2023-06-04 04:38:18'),
(45, 'User-Edit', 'user-edit', '2023-06-04 04:40:35', '2023-06-04 04:40:35'),
(46, 'User-Delete', 'user-delete', '2023-06-04 04:40:36', '2023-06-04 04:40:36');

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
(3, 'Line Manger-1', 'line-manger-1'),
(4, 'Line Manger -2', 'line-manger-2'),
(5, 'Line Manger -3', 'line-manger-3'),
(6, 'Employee', 'employee'),
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
(17, 1, 14),
(19, 1, 15),
(20, 1, 16),
(21, 1, 17),
(22, 1, 18),
(23, 1, 19),
(24, 1, 20),
(25, 1, 21),
(26, 1, 22),
(27, 1, 23),
(28, 1, 24),
(29, 1, 25),
(30, 1, 26),
(31, 1, 27),
(32, 1, 28),
(33, 1, 29),
(34, 1, 30),
(35, 1, 31),
(36, 1, 32),
(37, 1, 33),
(38, 1, 34),
(39, 1, 35),
(40, 1, 36),
(41, 1, 37),
(42, 1, 38),
(43, 1, 39),
(44, 1, 40),
(45, 1, 41),
(46, 1, 42),
(47, 1, 43),
(48, 1, 44),
(49, 1, 45),
(50, 1, 46),
(51, 7, 17),
(52, 7, 18),
(53, 7, 19),
(54, 7, 20),
(55, 7, 21),
(56, 7, 22),
(57, 7, 23),
(58, 7, 24),
(59, 7, 25),
(60, 7, 26),
(61, 7, 27),
(62, 7, 28),
(63, 7, 29),
(64, 7, 30),
(65, 7, 31),
(66, 7, 32),
(67, 7, 33),
(68, 7, 34),
(69, 7, 35),
(70, 7, 36),
(71, 7, 37),
(72, 7, 38),
(73, 7, 39),
(74, 7, 40),
(78, 7, 42),
(79, 7, 41),
(82, 5, 6),
(83, 5, 13),
(84, 2, 1),
(85, 2, 2),
(86, 3, 1),
(87, 3, 2),
(88, 6, 45),
(89, 4, 1),
(90, 4, 2),
(91, 4, 35),
(92, 4, 36),
(93, 4, 45);

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
(51, 3, 'Md. Zahirul Islam', 'RMWL-0887', 'RML', 'webuser@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', NULL),
(52, 4, 'Joy Paul g', 'RML-01260', 'RML', 'joy.paul@rangsgroup.com', '0192023a7bbd73250516f069df18b500', 'admin123', 'uploads/50_1686633365.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_permissions`
--

CREATE TABLE `tbl_users_permissions` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_roles`
--

CREATE TABLE `tbl_users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users_roles`
--

INSERT INTO `tbl_users_roles` (`user_id`, `role_id`) VALUES
(52, 1),
(1, 1),
(52, 2);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `tbl_users_roles`
--
ALTER TABLE `tbl_users_roles`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_roles_permissions`
--
ALTER TABLE `tbl_roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
