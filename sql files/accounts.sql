-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 11:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `l1j_remastered`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `login` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `lastactive` datetime DEFAULT NULL,
  `lastQuit` datetime DEFAULT NULL,
  `access_level` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `host` varchar(20) NOT NULL DEFAULT '',
  `banned` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `charslot` int(11) NOT NULL DEFAULT 6,
  `warehouse_password` int(11) NOT NULL DEFAULT 0,
  `notice` varchar(20) DEFAULT '0',
  `quiz` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `hddId` varchar(255) DEFAULT NULL,
  `boardId` varchar(255) DEFAULT NULL,
  `Tam_Point` int(11) NOT NULL DEFAULT 0,
  `Buff_DMG_Time` datetime DEFAULT NULL,
  `Buff_Reduc_Time` datetime DEFAULT NULL,
  `Buff_Magic_Time` datetime DEFAULT NULL,
  `Buff_Stun_Time` datetime DEFAULT NULL,
  `Buff_Hold_Time` datetime DEFAULT NULL,
  `BUFF_PCROOM_Time` datetime DEFAULT NULL,
  `Buff_FireDefence_Time` datetime DEFAULT NULL,
  `Buff_EarthDefence_Time` datetime DEFAULT NULL,
  `Buff_WaterDefence_Time` datetime DEFAULT NULL,
  `Buff_WindDefence_Time` datetime DEFAULT NULL,
  `Buff_SoulDefence_Time` datetime DEFAULT NULL,
  `Buff_Str_Time` datetime DEFAULT NULL,
  `Buff_Dex_Time` datetime DEFAULT NULL,
  `Buff_Wis_Time` datetime DEFAULT NULL,
  `Buff_Int_Time` datetime DEFAULT NULL,
  `Buff_FireAttack_Time` datetime DEFAULT NULL,
  `Buff_EarthAttack_Time` datetime DEFAULT NULL,
  `Buff_WaterAttack_Time` datetime DEFAULT NULL,
  `Buff_WindAttack_Time` datetime DEFAULT NULL,
  `Buff_Hero_Time` datetime DEFAULT NULL,
  `Buff_Life_Time` datetime DEFAULT NULL,
  `second_password` varchar(11) DEFAULT NULL,
  `Ncoin` int(11) NOT NULL DEFAULT 0,
  `Npoint` int(11) NOT NULL DEFAULT 0,
  `Shop_open_count` int(6) NOT NULL DEFAULT 0,
  `DragonRaid_Buff` datetime DEFAULT NULL,
  `Einhasad` int(11) NOT NULL DEFAULT 0,
  `EinDayBonus` int(2) NOT NULL DEFAULT 0,
  `IndunCheckTime` datetime DEFAULT NULL,
  `IndunCount` int(2) NOT NULL DEFAULT 0,
  `app_char` int(10) NOT NULL DEFAULT 0,
  `app_terms_agree` enum('false','true') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `PSSTime` int(11) NOT NULL DEFAULT 1800
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`login`, `password`, `lastactive`, `lastQuit`, `access_level`, `ip`, `host`, `banned`, `charslot`, `warehouse_password`, `notice`, `quiz`, `phone`, `hddId`, `boardId`, `Tam_Point`, `Buff_DMG_Time`, `Buff_Reduc_Time`, `Buff_Magic_Time`, `Buff_Stun_Time`, `Buff_Hold_Time`, `BUFF_PCROOM_Time`, `Buff_FireDefence_Time`, `Buff_EarthDefence_Time`, `Buff_WaterDefence_Time`, `Buff_WindDefence_Time`, `Buff_SoulDefence_Time`, `Buff_Str_Time`, `Buff_Dex_Time`, `Buff_Wis_Time`, `Buff_Int_Time`, `Buff_FireAttack_Time`, `Buff_EarthAttack_Time`, `Buff_WaterAttack_Time`, `Buff_WindAttack_Time`, `Buff_Hero_Time`, `Buff_Life_Time`, `second_password`, `Ncoin`, `Npoint`, `Shop_open_count`, `DragonRaid_Buff`, `Einhasad`, `EinDayBonus`, `IndunCheckTime`, `IndunCount`, `app_char`, `app_terms_agree`, `PSSTime`) VALUES
('hiteshpat4@gmail.com', 'riyasen79', '2025-02-26 01:39:02', '2025-02-26 04:31:40', 0, '127.0.0.1', '127.0.0.1', 0, 6, 0, '5', NULL, NULL, 'SCSI\\DISK&VEN_&PROD_MK0800GCTZB\\5&80103C0&0&010000', 'SABERTOOTH P67\\SKU', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 2000000, 1, NULL, 0, 0, 'false', 1800);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
