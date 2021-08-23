-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2021 at 12:27 PM
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
-- Table structure for table `historical_facts`
--

CREATE TABLE `historical_facts` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `schoolbox_totalusers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_totalusers`)),
  `schoolbox_config_site_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_config_site_type`)),
  `schoolbox_users_student` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_users_student`)),
  `schoolbox_users_staff` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_users_staff`)),
  `schoolbox_users_parent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_users_parent`)),
  `schoolbox_totalcampus` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_totalcampus`)),
  `schoolbox_package_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_package_version`)),
  `schoolboxdev_package_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolboxdev_package_version`)),
  `schoolbox_config_site_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_config_site_version`)),
  `virtual` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`virtual`)),
  `lsbdistdescription` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`lsbdistdescription`)),
  `kernelmajversion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`kernelmajversion`)),
  `kernelrelease` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`kernelrelease`)),
  `php_cli_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`php_cli_version`)),
  `mysql_extra_version` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`mysql_extra_version`)),
  `processorcount` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`processorcount`)),
  `memorysize` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`memorysize`)),
  `schoolbox_config_date_timezone` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_config_date_timezone`)),
  `schoolbox_config_external_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_config_external_type`)),
  `schoolbox_first_file_upload_year` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schoolbox_first_file_upload_year`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `historical_facts`
--

INSERT INTO `historical_facts` (`id`, `timestamp`, `schoolbox_totalusers`, `schoolbox_config_site_type`, `schoolbox_users_student`, `schoolbox_users_staff`, `schoolbox_users_parent`, `schoolbox_totalcampus`, `schoolbox_package_version`, `schoolboxdev_package_version`, `schoolbox_config_site_version`, `virtual`, `lsbdistdescription`, `kernelmajversion`, `kernelrelease`, `php_cli_version`, `mysql_extra_version`, `processorcount`, `memorysize`, `schoolbox_config_date_timezone`, `schoolbox_config_external_type`, `schoolbox_first_file_upload_year`) VALUES
(1, '2021-08-13 20:21:56', '{\"totalUsersFleetCount\": 686324, \"totalUsers\": {\"0\": 25, \"3\": 34, \"2\": 55, \"6\": 5, \"4\": 25, \"5\": 17, \"10\": 4, \"1\": 26, \"9\": 5, \"7\": 3, \"8\": 2, \"13\": 1}}', '{\"gg_dev\": \"dev\", \"1052c3fc\": \"prod\", \"cantco_dev\": \"dev\", \"kags_dev\": \"dev\", \"bfb6859e\": \"dev\", \"cispl_dev\": \"dev\", \"bhcs_dev\": \"dev\", \"bbc_dev\": \"dev\", \"sedc_dev\": \"dev\", \"lc_dev\": \"dev\", \"mcsl_dev\": \"dev\", \"hqjhtisc\": \"dev\", \"62014cd2\": \"dev\", \"msotturw\": \"dev\", \"digistorm_dev\": \"dev\", \"fhs_dev\": \"dev\", \"help_dev\": \"dev\", \"vist_dev\": \"dev\", \"adg4dnkh\": \"dev\", \"campion_dev\": \"dev\", \"alrs_dev\": \"dev\", \"aoku86yd\": \"dev\", \"wyyjmhm3\": \"dev\", \"012d8c83\": \"dev\", \"q4duuu9p\": \"dev\", \"sacc_dev\": \"dev\", \"rm4hwnlp\": \"dev\", \"kami_dev\": \"dev\", \"cps_dev\": \"dev\", \"inq3dqmx\": \"dev\", \"ft31xenj\": \"dev\", \"9w3fvais\": \"dev\", \"fjwcgrjs\": \"dev\", \"swpc_dev\": \"dev\", \"smcps_dev\": \"dev\", \"sohcs_dev\": \"dev\", \"stacc_dev\": \"dev\", \"bbb4ece7\": \"dev\", \"sbcbc_dev\": \"dev\", \"spcecn_dev\": \"dev\", \"smags_dev\": \"dev\", \"06d198a4\": \"dev\", \"tlc_dev\": \"dev\", \"1885ba46\": \"dev\", \"dcc_dev\": \"dev\", \"d93ea628\": \"dev\", \"eab130df\": \"dev\", \"9b0525bb\": \"dev\", \"kcc_dev\": \"dev\", \"smcs_dev\": \"dev\", \"scotspgc_dev\": \"dev\", \"skc_dev\": \"dev\", \"da20df2c\": \"dev\", \"ccgs_dev\": \"dev\", \"scg_dev\": \"dev\", \"tynd_dev\": \"dev\", \"bc0aeb6a\": \"dev\", \"wcs_dev\": \"dev\", \"a561dd7b\": \"dev\", \"mc_dev\": \"dev\", \"sts_dev\": \"dev\", \"sjac_dev\": \"dev\", \"pci_dev\": \"dev\", \"hcs_dev\": \"dev\", \"spcedy_dev\": \"dev\", \"fc83a6ff\": \"dev\", \"bcc_dev\": \"dev\", \"mac_dev\": \"dev\", \"8a77ebe6\": \"prod\", \"ms_dev\": \"dev\", \"tkds_dev\": \"dev\", \"grss_dev\": \"dev\", \"mrc_dev\": \"dev\", \"77496c07\": \"dev\", \"alpgs_dev\": \"dev\", \"0682994d\": \"dev\", \"wmac_dev\": \"dev\", \"5109e144\": \"dev\", \"spc_dev\": \"dev\", \"otcs_dev\": \"dev\", \"saags_dev\": \"dev\", \"as_dev\": \"dev\", \"soc_dev\": \"dev\", \"igs_dev\": \"dev\", \"spcc_dev\": \"dev\", \"bc_dev\": \"dev\", \"cas_dev\": \"dev\", \"tereaspcs_dev\": \"dev\", \"luc_dev\": \"dev\", \"dlsc_dev\": \"dev\", \"tbas_dev\": \"dev\", \"imm_dev\": \"dev\", \"f461dfee\": \"dev\", \"rpcs_dev\": \"dev\", \"bmg_dev\": \"dev\", \"cbgs_dev\": \"dev\", \"86d9fe43\": \"dev\", \"spgs_dev\": \"dev\", \"shelf_dev\": \"dev\", \"ss_dev\": \"dev\", \"pacl_dev\": \"dev\", \"kc_dev\": \"dev\", \"tccll_dev\": \"dev\", \"wgs_dev\": \"dev\", \"ngsl_dev\": \"dev\", \"crcnk_dev\": \"dev\", \"wes_dev\": \"dev\", \"vlc_dev\": \"dev\", \"spcedl_dev\": \"dev\", \"bggs_dev\": \"dev\", \"spcefl_dev\": \"dev\", \"wc_dev\": \"dev\", \"ccgsl_dev\": \"dev\", \"slc_dev\": \"dev\", \"322d233f\": \"dev\", \"75227d97\": \"dev\", \"ccs_dev\": \"dev\", \"ofgsl_dev\": \"dev\", \"rsfg_dev\": \"dev\", \"sk_dev\": \"dev\", \"kings_dev\": \"dev\", \"tsc_dev\": \"dev\", \"tigs_dev\": \"dev\", \"glacc_dev\": \"dev\", \"wilcc_dev\": \"dev\", \"tssa_dev\": \"dev\", \"ce37f3a9\": \"dev\", \"gfc_dev\": \"dev\", \"shc_dev\": \"dev\", \"krbs_dev\": \"dev\", \"63bfd87e\": \"dev\", \"gslc_dev\": \"dev\", \"bgs_dev\": \"dev\", \"pcl_dev\": \"dev\", \"deed64ce\": \"prod\", \"tc_dev\": \"dev\", \"mecs_dev\": \"dev\", \"17d796db\": \"dev\", \"agsbot_dev\": \"dev\", \"34caedaa\": \"dev\", \"944c55f6\": \"dev\", \"somvil_dev\": \"dev\", \"scc_dev\": \"dev\", \"ilimc_dev\": \"dev\", \"ggs_dev\": \"dev\", \"scsb_dev\": \"dev\", \"ducs_dev\": \"dev\", \"sicol_dev\": \"dev\", \"mzrc_dev\": \"dev\", \"sscl_dev\": \"dev\", \"tcc_dev\": \"dev\", \"tsac_dev\": \"dev\", \"pbs_dev\": \"dev\", \"spct_dev\": \"dev\", \"mfac_dev\": \"dev\", \"coolbcc_dev\": \"dev\", \"srcl_dev\": \"dev\", \"lk_dev\": \"dev\", \"spags_dev\": \"dev\", \"ba26af21\": \"dev\", \"kam_dev\": \"dev\", \"1fed6f27\": \"dev\", \"scgs_dev\": \"dev\", \"asas_dev\": \"dev\", \"nhs_dev\": \"dev\", \"meggs_dev\": \"dev\", \"calvc_dev\": \"dev\", \"lgs_dev\": \"dev\", \"ffc25a6f\": \"dev\", \"fct_dev\": \"dev\", \"scs_dev\": \"dev\", \"cel_dev\": \"dev\", \"ccca_dev\": \"dev\", \"lcs_dev\": \"dev\", \"fs_dev\": \"dev\", \"dcl_dev\": \"dev\", \"lhags_dev\": \"dev\", \"plcv_dev\": \"dev\", \"spcnt_dev\": \"dev\", \"spcenc_dev\": \"dev\", \"bfc0f114\": \"dev\", \"kgsl_dev\": \"dev\", \"pcc_dev\": \"dev\", \"shcl_dev\": \"dev\", \"spcegf_dev\": \"dev\", \"ps_dev\": \"dev\", \"ec_dev\": \"dev\", \"iggs_dev\": \"dev\", \"ecad69d1\": \"dev\", \"ab263c6d\": \"dev\", \"staloy_dev\": \"dev\", \"tcgi_dev\": \"dev\", \"fgs_dev\": \"dev\", \"smgs_dev\": \"dev\", \"acgs_dev\": \"dev\", \"mtc_dev\": \"dev\", \"hcc_dev\": \"dev\", \"ea3649cb\": \"dev\", \"d02a8288\": \"dev\", \"spceps_dev\": \"dev\", \"ducv_dev\": \"dev\", \"secl_dev\": \"dev\", \"baqags_dev\": \"dev\", \"ecc_dev\": \"dev\", \"0e3b67b6\": \"prod\", \"1b2b8b83\": \"prod\", \"a3a9715f\": \"prod\", \"b9e9ac67\": \"prod\", \"c3ef511e\": \"prod\", \"d373c7d4\": \"prod\", \"24d3025b\": \"prod\", \"390289c6\": \"prod\", \"21a1f964\": \"prod\", \"48905899\": \"prod\", \"2cae8d7d\": \"prod\", \"a5e610fa\": \"prod\", \"48a9b615\": \"prod\", \"924415f2\": \"prod\", \"eefe31c3\": \"prod\", \"ffa82b59\": \"prod\", \"5b27eadc\": \"prod\", \"58ff2b28\": \"prod\", \"2ea10bf0\": \"prod\", \"somvil_live\": \"prod\", \"bangae6z\": \"prod\", \"ghdwxthf\": \"prod\", \"vmoqagkg\": \"prod\", \"eb184178\": \"prod\", \"7341950b\": \"prod\", \"b6e1c9c7\": \"prod\", \"4e279b3c\": \"prod\", \"hcs_live\": \"prod\", \"e9d21212\": \"prod\", \"2ebd7fb6\": \"prod\", \"e7ac27ef\": \"prod\", \"pacl_live\": \"prod\", \"44bd610e\": \"prod\", \"10ee1fee\": \"prod\", \"46d82471\": \"prod\", \"e288a2ea\": \"prod\", \"unbfg9tj\": \"prod\", \"7bfc89dc\": \"prod\", \"098956bf\": \"prod\", \"b932beef\": \"prod\", \"f51e7c91\": \"prod\", \"4ca83458\": \"prod\", \"21f10df8\": \"prod\", \"rcq_dev\": \"dev\", \"rcq_live\": \"prod\", \"m4q378ks\": \"prod\", \"glacc_live\": \"prod\", \"d443333c\": \"prod\", \"083b3d1a\": \"prod\", \"bcc_live\": \"prod\", \"7142ea7a\": \"prod\", \"a178b9e3\": \"prod\", \"90dfc1a8\": \"prod\", \"18da8450\": \"prod\", \"d82ea2b3\": \"prod\", \"c8e8e33f\": \"prod\", \"4e373f6d\": \"prod\", \"5e2da47b\": \"prod\", \"80a718d4\": \"prod\", \"cbe3b16e\": \"prod\", \"7fb96191\": \"prod\", \"ac53bd24\": \"prod\", \"9f335c81\": \"prod\", \"lwg0hayv\": \"prod\", \"mcwsjfta\": \"prod\", \"8ab5402d\": \"prod\", \"8ecef6e9\": \"prod\", \"e0ace2f4\": \"prod\", \"830acea7\": \"prod\", \"daxq3ici\": \"prod\", \"8352a7f4\": \"prod\", \"8nw73mkj\": \"prod\", \"88ae27cd\": \"prod\", \"9b255167\": \"prod\", \"4d36adde\": \"prod\", \"dgzrdmcu\": \"prod\", \"537eb13e\": \"prod\", \"0hfik5ea\": \"prod\", \"sibkk1ds\": \"prod\", \"90fb8e13\": \"prod\", \"f4b176c9\": \"prod\", \"1c22b7ff\": \"prod\", \"tvk2zyfg\": \"prod\", \"ycw6vgdj\": \"prod\", \"5ebcbdc8\": \"prod\", \"61deba3f\": \"prod\", \"c005af17\": \"prod\", \"ja92okly\": \"prod\", \"dcfc14e6\": \"prod\", \"e2wc02rl\": \"prod\", \"ogh7diik\": \"prod\", \"yo2zbeta\": \"prod\", \"5nlykdx2\": \"prod\", \"6e4e9cec\": \"prod\", \"69bf9d6b\": \"prod\", \"f99c2ca0\": \"prod\", \"irognbfb\": \"prod\", \"1e7feccc\": \"prod\", \"ga4hkbqk\": \"prod\", \"9ferglch\": \"prod\", \"c0db5bdf\": \"prod\", \"stpvgvfz\": \"prod\", \"5fd6bab5\": \"prod\", \"fb24d2b3\": \"prod\", \"19ff6ab2\": \"prod\", \"l6TnBGIu\": \"prod\", \"1iviw2wu\": \"prod\", \"2df8bb8c\": \"prod\", \"a60cd612\": \"prod\", \"4511e856\": \"prod\", \"iijtbnlq\": \"prod\", \"z2jynaxq\": \"prod\", \"fd5r6pt9\": \"prod\", \"55b6822e\": \"prod\", \"1c285104\": \"prod\", \"c4dd5094\": \"prod\", \"1ae49a7f\": \"prod\", \"a47c04d6\": \"prod\", \"f60c49be\": \"prod\", \"1bdee159\": \"prod\", \"xqkqhzqd\": \"prod\", \"3kbmftaf\": \"prod\", \"9f52a516\": \"prod\", \"0a88a7dd\": \"prod\", \"lqygxccg\": \"prod\", \"6297b884\": \"prod\", \"e91b7394\": \"prod\", \"wdfouf60\": \"prod\", \"442aa404\": \"prod\", \"gXoZ1wVJ\": \"prod\", \"7c70c9ac\": \"prod\", \"fabqvl5d\": \"prod\", \"cce33292\": \"prod\", \"oje7siaK\": \"prod\", \"ii16aef5\": \"prod\", \"2093a06e\": \"prod\", \"3d844bfe\": \"prod\", \"613c15b1\": \"prod\", \"d2c0d293\": \"prod\", \"b81d28ca\": \"prod\", \"f824e2ea\": \"prod\", \"emqb87sj\": \"prod\", \"a1dsd1wn\": \"prod\", \"f677e883\": \"prod\", \"71vbh3yw\": \"prod\", \"e1454a1b\": \"prod\", \"0ef84781\": \"prod\", \"ac18ca51\": \"prod\", \"4a727c3e\": \"prod\", \"c7lgcksz\": \"prod\", \"2tcy6eu1\": \"prod\", \"b12c0f26\": \"prod\", \"vn4gemmn\": \"prod\", \"469b76f9\": \"prod\", \"fbe3116a\": \"prod\", \"fe8b768b\": \"prod\", \"68e296d5\": \"prod\", \"fdrpko3x\": \"prod\", \"afcd5a0e\": \"prod\", \"2ec033fb\": \"prod\", \"954298af\": \"prod\", \"bwzd7sit\": \"prod\", \"2138aed4\": \"prod\", \"vruf6vol\": \"prod\", \"zdYqpzG6\": \"prod\", \"7a6de682\": \"prod\", \"nhgli1w0\": \"prod\", \"6e3b9e63\": \"prod\", \"luq0h78z\": \"prod\", \"1d8e6718\": \"prod\", \"f8n0lieg\": \"prod\", \"cad825e9\": \"prod\", \"30d19f3b\": \"prod\", \"e8c4b651\": \"prod\", \"efeisho1\": \"prod\", \"54ca3f8a\": \"prod\", \"swkenzzz\": \"prod\", \"e2086d32\": \"prod\", \"07e3eecd\": \"prod\", \"93ca1c84\": \"prod\", \"zvbtabk2\": \"prod\", \"5815ad61\": \"prod\", \"air8ie9p\": \"prod\", \"cj1jjwz3\": \"prod\", \"1713960e\": \"prod\", \"17c87ba5\": \"prod\", \"7cgrj4py\": \"prod\", \"6cb3a5c8\": \"prod\", \"cd6a7f2f\": \"prod\", \"fwe4orcn\": \"prod\", \"cycvr08u\": \"prod\", \"5724e3cc\": \"prod\", \"92bd5e02\": \"prod\", \"2b8a23c0\": \"prod\", \"omx9bavz\": \"prod\", \"47e9c6e8\": \"prod\", \"9m6b2asu\": \"prod\", \"8aelzdmv\": \"prod\", \"77298da5\": \"prod\", \"f3e207af\": \"prod\", \"f41a52ca\": \"prod\", \"cf2f48c1\": \"prod\", \"5dffdcee\": \"prod\", \"765c3989\": \"prod\", \"969d1663\": \"prod\", \"coomac_live\": \"prod\", \"4c0179d5\": \"prod\", \"decs_live\": \"prod\", \"66705c0a\": \"prod\", \"b4fa17ba\": \"prod\", \"98c3df2c\": \"prod\", \"6475e889\": \"prod\", \"18e116cd\": \"prod\", \"05ebe059\": \"prod\", \"1dae7f3b\": \"prod\", \"3edfdd5f\": \"prod\", \"fbecadca\": \"prod\", \"0b1ff68b\": \"prod\", \"scotspgc_live\": \"prod\", \"13a8885e\": \"prod\", \"b3220b0c\": \"prod\", \"54cf8fa4\": \"prod\", \"2c9c7503\": \"prod\", \"54288617\": \"prod\", \"04c51de5\": \"prod\", \"2d3edbad\": \"prod\", \"4d11bd39\": \"prod\", \"00cadfa9\": \"prod\", \"3e2971f4\": \"prod\", \"oss_dev\": \"dev\", \"81536cf5\": \"prod\", \"8fc0b8e3\": \"prod\", \"957df395\": \"prod\", \"cantco_live\": \"prod\", \"fcb15bb6\": \"prod\", \"calvc_live\": \"prod\", \"bggs_live\": \"prod\", \"spcnt_live\": \"prod\", \"9f121ec4\": \"prod\", \"1c704f57\": \"prod\", \"acgs_live\": \"prod\", \"054ff814\": \"prod\", \"24ed292c\": \"prod\", \"567c7c25\": \"prod\", \"saccl_live\": \"prod\", \"mzrc_live\": \"prod\", \"pbs_live\": \"prod\", \"22d68f47\": \"prod\", \"d5b3eda0\": \"prod\", \"3312ed04\": \"prod\", \"coolbcc_live\": \"prod\", \"otcs_live\": \"prod\", \"75d09e23\": \"prod\", \"8737c594\": \"prod\", \"wes_live\": \"prod\", \"wel_live\": \"prod\", \"30fc8656\": \"prod\", \"065d71c5\": \"prod\", \"a15ee2df\": \"prod\", \"9b51cf26\": \"prod\", \"52fc47a2\": \"prod\", \"61092fdc\": \"prod\", \"0e72478a\": \"prod\", \"288c8858\": \"prod\", \"tynd_live\": \"prod\", \"d7397c92\": \"prod\", \"c18bbb8b\": \"prod\", \"shelf_live\": \"prod\", \"c15ac0dd\": \"prod\", \"4db534c9\": \"prod\", \"c6f799c4\": \"prod\", \"gslps_live\": \"prod\", \"8100454f\": \"prod\", \"25e96eb6\": \"prod\", \"c8431a7f\": \"prod\", \"ddc14a36\": \"prod\", \"6d3c7394\": \"prod\", \"e61ae45d\": \"prod\", \"008efcf2\": \"prod\", \"e572d3a4\": \"prod\", \"tssa_live\": \"prod\", \"08e597d0\": \"prod\", \"cbgs_live\": \"prod\", \"00e392f3\": \"prod\", \"0bbc92ca\": \"prod\", \"4509c602\": \"prod\", \"8a2a7c7e\": \"prod\", \"7f5797ef\": \"prod\", \"mtc_live\": \"prod\", \"686e8622\": \"prod\", \"8938e4ef\": \"prod\", \"hcc_live\": \"prod\", \"52c23320\": \"prod\", \"5725a8ff\": \"prod\", \"171b16da\": \"prod\", \"59982b67\": \"prod\", \"d3eb5ad8\": \"prod\", \"vlc_live\": \"prod\", \"065712aa\": \"prod\", \"b9dbbdf2\": \"prod\", \"bhcs_live\": \"prod\", \"4f0dc0f3\": \"prod\", \"8ff8acc9\": \"prod\", \"1b285b04\": \"prod\", \"bmg_live\": \"prod\", \"7c9f600d\": \"prod\", \"crcnk_live\": \"prod\", \"ca5bac8d\": \"prod\", \"6ab5b609\": \"prod\", \"2303c40d\": \"prod\", \"sjac_live\": \"prod\", \"f1d6aeba\": \"prod\", \"3eaf1188\": \"prod\", \"12f5e88b\": \"prod\", \"04b27ed3\": \"prod\", \"189b3c88\": \"prod\", \"0bd600a0\": \"prod\", \"a54a8498\": \"prod\", \"035ea0ed\": \"prod\", \"119845fd\": \"prod\", \"7a6e822f\": \"prod\", \"92560180\": \"prod\", \"qahs_dev\": \"dev\", \"ca3734d5\": \"prod\", \"5408c8f9\": \"prod\", \"039a2bd9\": \"prod\", \"47fdcaff\": \"prod\", \"f99c826b\": \"prod\", \"4323ce78\": \"prod\", \"wcs_live\": \"prod\", \"staloy_live\": \"prod\", \"7b7f534d\": \"prod\", \"70033bd1\": \"prod\", \"1ba293f2\": \"prod\", \"29a2fc98\": \"dev\", \"7635996d\": \"prod\", \"d7f767ca\": \"prod\", \"ilimc_live\": \"prod\", \"ce790af0\": \"prod\", \"krbs_live\": \"prod\", \"ec3992d5\": \"prod\", \"13806303\": \"prod\", \"2f0eaa51\": \"prod\", \"ff57f337\": \"prod\", \"4a3b3825\": \"prod\", \"mcsl_live\": \"prod\"}', '{\"totalStudentCount\": 261082}', '{\"totalStaffCount\": 68018}', '{\"totalParentCount\": 349436}', '{\"totalCampus\": 1013}', '{\"productionPackageVersions\": {\"21.0.5-2\": {\"count\": 150, \"percent\": 74.26}, \"20.2.12-2\": {\"count\": 37, \"percent\": 18.32}, \"20.1.8-2\": {\"count\": 6, \"percent\": 2.97}, \"20.0.12-1\": {\"count\": 3, \"percent\": 1.49}, \"21.0.4-2\": {\"count\": 3, \"percent\": 1.49}, \"19.1.12-3\": {\"count\": 1, \"percent\": 0.5}, \"18.1.8-1\": {\"count\": 1, \"percent\": 0.5}, \"21.0.3-5\": {\"count\": 1, \"percent\": 0.5}}, \"developmentPackageVersions\": {\"20.2.11-1\": {\"count\": 1, \"percent\": 0.5}, \"20.2.12-2\": {\"count\": 1, \"percent\": 0.5}, \"20.2.9-2\": {\"count\": 1, \"percent\": 0.5}}}', '{\"productionPackageVersions\": {\"21.0.5-2\": {\"count\": 2, \"percent\": 66.67}, \"21.0.3-5\": {\"count\": 1, \"percent\": 33.33}}, \"developmentPackageVersions\": {\"21.0.5-2\": {\"count\": 174, \"percent\": 5800.0}, \"21.0.4-2\": {\"count\": 1, \"percent\": 33.33}, \"20.2.0-0\": {\"count\": 1, \"percent\": 33.33}, \"21.0.2-1\": {\"count\": 1, \"percent\": 33.33}, \"19.1.12-3\": {\"count\": 1, \"percent\": 33.33}}}', '{\"stagingServers\": {\"21.0.5\": {\"count\": 229, \"percent\": 98.28}, \"21.0.4\": {\"count\": 1, \"percent\": 0.43}, \"20.2.beta6\": {\"count\": 1, \"percent\": 0.43}, \"21.0.2\": {\"count\": 1, \"percent\": 0.43}, \"20.2.7\": {\"count\": 1, \"percent\": 0.43}}, \"productionServers\": {\"20.2.11\": {\"count\": 1, \"percent\": 0.16}, \"20.2.12\": {\"count\": 38, \"percent\": 6.06}, \"20.2.9\": {\"count\": 1, \"percent\": 0.16}, \"21.0.5\": {\"count\": 571, \"percent\": 91.07}, \"20.1.8\": {\"count\": 6, \"percent\": 0.96}, \"20.0.12\": {\"count\": 3, \"percent\": 0.48}, \"21.0.4\": {\"count\": 3, \"percent\": 0.48}, \"19.1.12\": {\"count\": 1, \"percent\": 0.16}, \"18.1.8\": {\"count\": 1, \"percent\": 0.16}, \"21.0.3\": {\"count\": 2, \"percent\": 0.32}}}', '{\"hyperv\": {\"count\": 87, \"percent\": 22.83}, \"virtualbox\": {\"count\": 1, \"percent\": 0.26}, \"vmware\": {\"count\": 268, \"percent\": 70.34}, \"xenhvm\": {\"count\": 5, \"percent\": 1.31}, \"kvm\": {\"count\": 17, \"percent\": 4.46}, \"physical\": {\"count\": 2, \"percent\": 0.52}, \"xenu\": {\"count\": 1, \"percent\": 0.26}}', '{\"Ubuntu 18.04.5 LTS\": {\"count\": 391, \"percent\": 98.24}, \"Ubuntu 18.04.4 LTS\": {\"count\": 2, \"percent\": 0.5}, \"Ubuntu 16.04.6 LTS\": {\"count\": 2, \"percent\": 0.5}, \"Ubuntu 18.04 LTS\": {\"count\": 1, \"percent\": 0.25}, \"Ubuntu 16.04.1 LTS\": {\"count\": 1, \"percent\": 0.25}, \"Ubuntu 16.04.3 LTS\": {\"count\": 1, \"percent\": 0.25}}', '{\"4.18\": {\"count\": 10, \"percent\": 2.51}, \"4.15\": {\"count\": 362, \"percent\": 90.95}, \"5.0\": {\"count\": 6, \"percent\": 1.51}, \"5.3\": {\"count\": 1, \"percent\": 0.25}, \"5.4\": {\"count\": 15, \"percent\": 3.77}, \"4.4\": {\"count\": 4, \"percent\": 1.01}}', '{\"4.18.0-1024-azure\": {\"count\": 10, \"percent\": 2.51}, \"4.15.0-111-generic\": {\"count\": 3, \"percent\": 0.75}, \"4.15.0-76-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-54-generic\": {\"count\": 250, \"percent\": 62.81}, \"4.15.0-118-generic\": {\"count\": 4, \"percent\": 1.01}, \"4.15.0-1043-aws\": {\"count\": 6, \"percent\": 1.51}, \"5.0.0-1023-azure\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-99-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-47-generic\": {\"count\": 4, \"percent\": 1.01}, \"5.3.0-1028-aws\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-1057-aws\": {\"count\": 3, \"percent\": 0.75}, \"4.15.0-52-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-29-generic\": {\"count\": 11, \"percent\": 2.76}, \"4.15.0-48-generic\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1051-aws\": {\"count\": 4, \"percent\": 1.01}, \"4.15.0-112-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-39-generic\": {\"count\": 2, \"percent\": 0.5}, \"5.4.0-1043-azure\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-123-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-1044-aws\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-142-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-72-generic\": {\"count\": 11, \"percent\": 2.76}, \"4.15.0-96-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-58-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-88-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-55-generic\": {\"count\": 7, \"percent\": 1.76}, \"4.15.0-32-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-117-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-135-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-140-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-136-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-122-generic\": {\"count\": 5, \"percent\": 1.26}, \"4.15.0-74-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-106-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-91-generic\": {\"count\": 5, \"percent\": 1.26}, \"5.4.0-1023-azure\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-36-generic\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1039-azure\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-115-generic\": {\"count\": 3, \"percent\": 0.75}, \"4.15.0-62-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-130-generic\": {\"count\": 3, \"percent\": 0.75}, \"4.4.0-1102-aws\": {\"count\": 3, \"percent\": 0.75}, \"4.15.0-42-generic\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-43-generic\": {\"count\": 4, \"percent\": 1.01}, \"5.0.0-1035-azure\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1029-aws\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-65-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-132-generic\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1045-aws\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-143-generic\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1040-azure\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1049-aws\": {\"count\": 2, \"percent\": 0.5}, \"4.15.0-108-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-124-generic\": {\"count\": 1, \"percent\": 0.25}, \"5.4.0-1028-aws\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-60-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-34-generic\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-1010-aws\": {\"count\": 1, \"percent\": 0.25}, \"5.0.0-1027-azure\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-1051-aws\": {\"count\": 1, \"percent\": 0.25}, \"4.4.0-1049-aws\": {\"count\": 1, \"percent\": 0.25}, \"5.0.0-1022-azure\": {\"count\": 1, \"percent\": 0.25}, \"5.0.0-1036-azure\": {\"count\": 1, \"percent\": 0.25}, \"4.15.0-64-generic\": {\"count\": 1, \"percent\": 0.25}}', '{\"7.4.21\": {\"count\": 363, \"percent\": 95.78}, \"7.4.16\": {\"count\": 3, \"percent\": 0.79}, \"7.4.12\": {\"count\": 1, \"percent\": 0.26}, \"7.1.33-24+ubuntu18.04.1+deb.sury.org+1\": {\"count\": 1, \"percent\": 0.26}, \"7.1.33-34+ubuntu18.04.1+deb.sury.org+1\": {\"count\": 11, \"percent\": 2.9}}', '{\"10.5.10-MariaDB-1:10.5.10+maria~bionic-log\": {\"count\": 215, \"percent\": 56.73}, \"10.1.48-MariaDB-1~bionic\": {\"count\": 51, \"percent\": 13.46}, \"10.5.11-MariaDB-1:10.5.11+maria~bionic-log\": {\"count\": 112, \"percent\": 29.55}, \"10.5.12-MariaDB-1:10.5.12+maria~bionic-log\": {\"count\": 1, \"percent\": 0.26}}', '{\"1\": {\"count\": 17, \"percent\": 4.27}, \"4\": {\"count\": 159, \"percent\": 39.95}, \"16\": {\"count\": 28, \"percent\": 7.04}, \"2\": {\"count\": 19, \"percent\": 4.77}, \"8\": {\"count\": 120, \"percent\": 30.15}, \"9\": {\"count\": 1, \"percent\": 0.25}, \"20\": {\"count\": 6, \"percent\": 1.51}, \"6\": {\"count\": 8, \"percent\": 2.01}, \"32\": {\"count\": 8, \"percent\": 2.01}, \"3\": {\"count\": 1, \"percent\": 0.25}, \"12\": {\"count\": 13, \"percent\": 3.27}, \"28\": {\"count\": 1, \"percent\": 0.25}, \"10\": {\"count\": 6, \"percent\": 1.51}, \"15\": {\"count\": 2, \"percent\": 0.5}, \"24\": {\"count\": 6, \"percent\": 1.51}, \"14\": {\"count\": 1, \"percent\": 0.25}, \"25\": {\"count\": 1, \"percent\": 0.25}, \"11\": {\"count\": 1, \"percent\": 0.25}}', '{\"2\": {\"count\": 5, \"percent\": 1.26}, \"4\": {\"count\": 12, \"percent\": 3.02}, \"8\": {\"count\": 115, \"percent\": 28.89}, \"32\": {\"count\": 41, \"percent\": 10.3}, \"15\": {\"count\": 5, \"percent\": 1.26}, \"16\": {\"count\": 133, \"percent\": 33.42}, \"1\": {\"count\": 7, \"percent\": 1.76}, \"10\": {\"count\": 1, \"percent\": 0.25}, \"14\": {\"count\": 6, \"percent\": 1.51}, \"45\": {\"count\": 1, \"percent\": 0.25}, \"87\": {\"count\": 1, \"percent\": 0.25}, \"12\": {\"count\": 4, \"percent\": 1.01}, \"63\": {\"count\": 7, \"percent\": 1.76}, \"6\": {\"count\": 1, \"percent\": 0.25}, \"7\": {\"count\": 2, \"percent\": 0.5}, \"9\": {\"count\": 1, \"percent\": 0.25}, \"5\": {\"count\": 1, \"percent\": 0.25}, \"24\": {\"count\": 13, \"percent\": 3.27}, \"49\": {\"count\": 1, \"percent\": 0.25}, \"95\": {\"count\": 3, \"percent\": 0.75}, \"20\": {\"count\": 6, \"percent\": 1.51}, \"31\": {\"count\": 3, \"percent\": 0.75}, \"126\": {\"count\": 1, \"percent\": 0.25}, \"25\": {\"count\": 2, \"percent\": 0.5}, \"79\": {\"count\": 1, \"percent\": 0.25}, \"48\": {\"count\": 7, \"percent\": 1.76}, \"53\": {\"count\": 1, \"percent\": 0.25}, \"40\": {\"count\": 2, \"percent\": 0.5}, \"56\": {\"count\": 2, \"percent\": 0.5}, \"158\": {\"count\": 1, \"percent\": 0.25}, \"30\": {\"count\": 1, \"percent\": 0.25}, \"28\": {\"count\": 3, \"percent\": 0.75}, \"77\": {\"count\": 1, \"percent\": 0.25}, \"252\": {\"count\": 1, \"percent\": 0.25}, \"59\": {\"count\": 1, \"percent\": 0.25}, \"99\": {\"count\": 1, \"percent\": 0.25}, \"44\": {\"count\": 1, \"percent\": 0.25}, \"35\": {\"count\": 1, \"percent\": 0.25}, \"26\": {\"count\": 1, \"percent\": 0.25}, \"67\": {\"count\": 1, \"percent\": 0.25}}', '{\"Australia/Melbourne\": {\"count\": 88, \"percent\": 43.78}, \"Australia/Sydney\": {\"count\": 38, \"percent\": 18.91}, \"Pacific/Auckland\": {\"count\": 9, \"percent\": 4.48}, \"Australia/Brisbane\": {\"count\": 45, \"percent\": 22.39}, \"Asia/Hong_Kong\": {\"count\": 1, \"percent\": 0.5}, \"Australia/Perth\": {\"count\": 6, \"percent\": 2.99}, \"Asia/Shanghai\": {\"count\": 2, \"percent\": 1.0}, \"Australia/Darwin\": {\"count\": 2, \"percent\": 1.0}, \"Australia/Adelaide\": {\"count\": 8, \"percent\": 3.98}, \"Australia/Hobart\": {\"count\": 1, \"percent\": 0.5}, \"Asia/Singapore\": {\"count\": 1, \"percent\": 0.5}}', '{\"schoolbox\": {\"count\": 25, \"percent\": 12.44}, \"synergetic\": {\"count\": 118, \"percent\": 58.71}, \"denbigh\": {\"count\": 2, \"percent\": 1.0}, \"tass\": {\"count\": 40, \"percent\": 19.9}, \"pcschools\": {\"count\": 7, \"percent\": 3.48}, \"doublefirst\": {\"count\": 2, \"percent\": 1.0}, \"schoolpro\": {\"count\": 3, \"percent\": 1.49}, \"schooledge\": {\"count\": 1, \"percent\": 0.5}, \"maze\": {\"count\": 1, \"percent\": 0.5}, \"isams\": {\"count\": 1, \"percent\": 0.5}, \"edumate\": {\"count\": 1, \"percent\": 0.5}}', '{\"2020\": {\"count\": 16, \"percent\": 7.96}, \"2015\": {\"count\": 36, \"percent\": 17.91}, \"2021\": {\"count\": 7, \"percent\": 3.48}, \"2010\": {\"count\": 1, \"percent\": 0.5}, \"2014\": {\"count\": 16, \"percent\": 7.96}, \"2016\": {\"count\": 27, \"percent\": 13.43}, \"2019\": {\"count\": 22, \"percent\": 10.95}, \"2017\": {\"count\": 27, \"percent\": 13.43}, \"2012\": {\"count\": 5, \"percent\": 2.49}, \"2018\": {\"count\": 26, \"percent\": 12.94}, \"2013\": {\"count\": 13, \"percent\": 6.47}, \"2009\": {\"count\": 1, \"percent\": 0.5}, \"2011\": {\"count\": 4, \"percent\": 1.99}}');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
