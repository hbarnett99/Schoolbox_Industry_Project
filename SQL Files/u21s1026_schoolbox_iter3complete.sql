-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 01:00 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u21s1026_schoolbox`
--
CREATE DATABASE IF NOT EXISTS `u21s1026_schoolbox` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `u21s1026_schoolbox`;

-- --------------------------------------------------------

--
-- Table structure for table `a_dmad_social_auth_phinxlog`
--

DROP TABLE IF EXISTS `a_dmad_social_auth_phinxlog`;
CREATE TABLE `a_dmad_social_auth_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `historical_facts`
--

DROP TABLE IF EXISTS `historical_facts`;
CREATE TABLE `historical_facts` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `schoolbox_totalusers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_config_site_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_users_student` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_users_staff` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_users_parent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_totalcampus` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_package_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolboxdev_package_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_config_site_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `virtual` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `lsbdistdescription` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `kernelmajversion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `kernelrelease` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `php_cli_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mysql_extra_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `processorcount` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `memorysize` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_config_date_timezone` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_config_external_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schoolbox_first_file_upload_year` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `social_profiles`
--

DROP TABLE IF EXISTS `social_profiles`;
CREATE TABLE `social_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `access_token` blob NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL COMMENT 'User''s email address',
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_dmad_social_auth_phinxlog`
--
ALTER TABLE `a_dmad_social_auth_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `historical_facts`
--
ALTER TABLE `historical_facts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_profiles`
--
ALTER TABLE `social_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historical_facts`
--
ALTER TABLE `historical_facts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_profiles`
--
ALTER TABLE `social_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
