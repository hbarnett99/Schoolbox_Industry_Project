-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2021 at 03:21 AM
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
-- Database: `u21s2026_schoolbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_dmad_social_auth_phinxlog`
--

CREATE TABLE `a_dmad_social_auth_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `a_dmad_social_auth_phinxlog`
--

INSERT INTO `a_dmad_social_auth_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20190914000000, 'CreateSocialProfiles', '2021-08-09 23:57:13', '2021-08-09 23:57:13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `social_profiles`
--

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

--
-- Dumping data for table `social_profiles`
--

INSERT INTO `social_profiles` (`id`, `user_id`, `provider`, `access_token`, `identifier`, `username`, `first_name`, `last_name`, `full_name`, `email`, `birth_date`, `gender`, `picture_url`, `email_verified`, `created`, `modified`) VALUES
(1, 1, 'google', 0x4f3a33393a22536f6369616c436f6e6e6563745c4f70656e4944436f6e6e6563745c416363657373546f6b656e223a363a7b733a363a22002a006a7774223b4f3a32313a22536f6369616c436f6e6e6563745c4a57585c4a5754223a333a7b733a31303a22002a0068656164657273223b613a333a7b733a333a22616c67223b733a353a225253323536223b733a333a226b6964223b733a34303a2234363239343931373466316565646634663966393433343837376265343833623332343134306635223b733a333a22747970223b733a333a224a5754223b7d733a31303a22002a007061796c6f6164223b613a31303a7b733a333a22697373223b733a31393a226163636f756e74732e676f6f676c652e636f6d223b733a333a22617a70223b733a37323a223239303434323338323936342d336b6b706d6973313061646b6634323639623336766a6d3468697071393535682e617070732e676f6f676c6575736572636f6e74656e742e636f6d223b733a333a22617564223b733a37323a223239303434323338323936342d336b6b706d6973313061646b6634323639623336766a6d3468697071393535682e617070732e676f6f676c6575736572636f6e74656e742e636f6d223b733a333a22737562223b733a32313a22313039393833343533383130303935343232303931223b733a323a226864223b733a31383a2273747564656e742e6d6f6e6173682e656475223b733a353a22656d61696c223b733a32373a2264726169303030314073747564656e742e6d6f6e6173682e656475223b733a31343a22656d61696c5f7665726966696564223b623a313b733a373a2261745f68617368223b733a32323a222d4c324f4471653454736b494f5f796e714f68654667223b733a333a22696174223b693a313632383733303133343b733a333a22657870223b693a313632383733333733343b7d733a31323a22002a007369676e6174757265223b733a3235363a220bb093acc0464713e4dbb01364280f82000ef6618c1aff2a38ee108695793e442edcad32d3ced8cfc541b72525bd5cf77dc42ffb9dbfd3a74f18d88f6be3a8e7758c7eafb1484b26045c0b788235bc01f4f72c30d42861f52ee151942f501dffe6ea90b664de1f44027fd5ebade11767129483b34fa873597e883aa5d7f10963a998f80e4fc335f6c59ebe3c7e51d4ec8a33c314ddac8554e69ef942d177234e16205ec50ec486cf0d81310bb3a16b09a4e4457f652b2ec1055aade1ee2ae3cee15215d576fdd439e6ca9fa86e1c5f65abf4571857321eca4fe519a697774ad8d116bfe4de5efc0235aab6dd3453b5f079efa96a305e9b2e154d91d060a1590a223b7d733a383a22002a00746f6b656e223b733a3136353a22796132392e613041527264614d39476d46306c564558327a49784a75506f6678632d2d6b7975687176467371596a737161354e5931317069317376483772545661797762715a3841776930424d45496532333161385634516a5a6d4b4a4b7433472d5f5a6a5875426b64306431614e3432396662524c426b77324a546b764d624645784a454b71746c6a682d534a65324a43642d4c5a6b5673746d41514476536b71346667223b733a31353a22002a0072656672657368546f6b656e223b4e3b733a31303a22002a0065787069726573223b693a313632383733333733333b733a363a22002a00756964223b733a32313a22313039393833343533383130303935343232303931223b733a383a22002a00656d61696c223b4e3b7d, '109983453810095422091', NULL, 'Dane', 'Rainbird', 'Dane Rainbird', 'drai0001@student.monash.edu', NULL, NULL, 'https://lh3.googleusercontent.com/a-/AOh14GhMs0LK4bgfyV6TBudcVYXBlKe-CgqzsyHfIi_z=s96-c', 1, '2021-08-10 10:43:34', '2021-08-12 01:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL COMMENT 'User''s email address'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`) VALUES
(1, 'drai0001@student.monash.edu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_dmad_social_auth_phinxlog`
--
ALTER TABLE `a_dmad_social_auth_phinxlog`
  ADD PRIMARY KEY (`version`);

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
-- AUTO_INCREMENT for table `social_profiles`
--
ALTER TABLE `social_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;