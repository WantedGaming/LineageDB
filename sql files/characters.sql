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
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `account_name` varchar(50) DEFAULT NULL,
  `objid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `char_name` varchar(45) NOT NULL DEFAULT '',
  `level` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `HighLevel` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `Exp` bigint(11) UNSIGNED NOT NULL DEFAULT 0,
  `MaxHp` int(5) NOT NULL DEFAULT 0,
  `CurHp` int(5) NOT NULL DEFAULT 0,
  `MaxMp` int(5) NOT NULL DEFAULT 0,
  `CurMp` int(5) NOT NULL DEFAULT 0,
  `Ac` int(3) NOT NULL DEFAULT 0,
  `Str` int(3) NOT NULL DEFAULT 0,
  `BaseStr` int(3) NOT NULL DEFAULT 0,
  `Con` int(3) NOT NULL DEFAULT 0,
  `BaseCon` int(3) NOT NULL DEFAULT 0,
  `Dex` int(3) NOT NULL DEFAULT 0,
  `BaseDex` int(3) NOT NULL DEFAULT 0,
  `Cha` int(3) NOT NULL DEFAULT 0,
  `BaseCha` int(3) NOT NULL DEFAULT 0,
  `Intel` int(3) NOT NULL DEFAULT 0,
  `BaseIntel` int(3) NOT NULL DEFAULT 0,
  `Wis` int(3) NOT NULL DEFAULT 0,
  `BaseWis` int(3) NOT NULL DEFAULT 0,
  `Status` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `Class` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `gender` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `Type` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `Heading` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `LocX` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `LocY` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `MapID` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `Food` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Alignment` int(6) NOT NULL DEFAULT 0,
  `Title` varchar(35) NOT NULL DEFAULT '',
  `ClanID` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Clanname` varchar(45) NOT NULL,
  `ClanRank` int(3) NOT NULL DEFAULT 0,
  `ClanContribution` int(8) NOT NULL DEFAULT 0,
  `ClanWeekContribution` int(8) NOT NULL DEFAULT 0,
  `pledgeJoinDate` int(10) NOT NULL DEFAULT 0,
  `pledgeRankDate` int(10) NOT NULL DEFAULT 0,
  `notes` varchar(60) NOT NULL,
  `BonusStatus` int(4) NOT NULL DEFAULT 0,
  `ElixirStatus` int(2) NOT NULL DEFAULT 0,
  `ElfAttr` int(2) NOT NULL DEFAULT 0,
  `PKcount` int(6) NOT NULL DEFAULT 0,
  `ExpRes` int(10) NOT NULL DEFAULT 0,
  `PartnerID` int(10) NOT NULL DEFAULT 0,
  `AccessLevel` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `OnlineStatus` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `HomeTownID` int(2) NOT NULL DEFAULT 0,
  `Contribution` int(10) NOT NULL DEFAULT 0,
  `HellTime` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Banned` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `Karma` int(10) NOT NULL DEFAULT 0,
  `LastPk` datetime DEFAULT NULL,
  `DeleteTime` datetime DEFAULT NULL,
  `ReturnStat` bigint(10) NOT NULL,
  `lastLoginTime` datetime DEFAULT NULL,
  `lastLogoutTime` datetime DEFAULT NULL,
  `BirthDay` int(11) DEFAULT NULL,
  `PC_Kill` int(6) DEFAULT NULL,
  `PC_Death` int(6) DEFAULT NULL,
  `Mark_Count` int(10) NOT NULL DEFAULT 60,
  `TamEndTime` datetime DEFAULT NULL,
  `SpecialSize` int(3) NOT NULL DEFAULT 0,
  `HuntPrice` int(10) DEFAULT NULL,
  `HuntText` varchar(30) DEFAULT NULL,
  `HuntCount` int(10) DEFAULT NULL,
  `RingAddSlot` int(3) DEFAULT 0,
  `EarringAddSlot` int(3) DEFAULT 0,
  `BadgeAddSlot` int(3) DEFAULT 0,
  `ShoulderAddSlot` int(3) DEFAULT 0,
  `fatigue_point` int(3) NOT NULL DEFAULT 0,
  `fatigue_rest_time` datetime DEFAULT NULL,
  `EMETime` datetime DEFAULT NULL,
  `EMETime2` datetime DEFAULT NULL,
  `PUPLETime` datetime DEFAULT NULL,
  `TOPAZTime` datetime DEFAULT NULL,
  `EinhasadGraceTime` datetime DEFAULT NULL,
  `EinPoint` int(11) DEFAULT 0,
  `EinCardLess` int(2) NOT NULL DEFAULT 0,
  `EinCardState` int(3) NOT NULL DEFAULT 0,
  `EinCardBonusValue` int(1) NOT NULL DEFAULT 0,
  `ThirdSkillTime` datetime DEFAULT NULL,
  `FiveSkillTime` datetime DEFAULT NULL,
  `SurvivalTime` datetime DEFAULT NULL,
  `potentialTargetId` int(10) NOT NULL DEFAULT 0,
  `potentialBonusGrade` int(1) NOT NULL DEFAULT 0,
  `potentialBonusId` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`account_name`, `objid`, `char_name`, `level`, `HighLevel`, `Exp`, `MaxHp`, `CurHp`, `MaxMp`, `CurMp`, `Ac`, `Str`, `BaseStr`, `Con`, `BaseCon`, `Dex`, `BaseDex`, `Cha`, `BaseCha`, `Intel`, `BaseIntel`, `Wis`, `BaseWis`, `Status`, `Class`, `gender`, `Type`, `Heading`, `LocX`, `LocY`, `MapID`, `Food`, `Alignment`, `Title`, `ClanID`, `Clanname`, `ClanRank`, `ClanContribution`, `ClanWeekContribution`, `pledgeJoinDate`, `pledgeRankDate`, `notes`, `BonusStatus`, `ElixirStatus`, `ElfAttr`, `PKcount`, `ExpRes`, `PartnerID`, `AccessLevel`, `OnlineStatus`, `HomeTownID`, `Contribution`, `HellTime`, `Banned`, `Karma`, `LastPk`, `DeleteTime`, `ReturnStat`, `lastLoginTime`, `lastLogoutTime`, `BirthDay`, `PC_Kill`, `PC_Death`, `Mark_Count`, `TamEndTime`, `SpecialSize`, `HuntPrice`, `HuntText`, `HuntCount`, `RingAddSlot`, `EarringAddSlot`, `BadgeAddSlot`, `ShoulderAddSlot`, `fatigue_point`, `fatigue_rest_time`, `EMETime`, `EMETime2`, `PUPLETime`, `TOPAZTime`, `EinhasadGraceTime`, `EinPoint`, `EinCardLess`, `EinCardState`, `EinCardBonusValue`, `ThirdSkillTime`, `FiveSkillTime`, `SurvivalTime`, `potentialTargetId`, `potentialBonusGrade`, `potentialBonusId`) VALUES
('hiteshpat4@gmail.com', 336380011, 'Wanted', 1, 1, 0, 16, 16, 2, 2, 6, 16, 16, 20, 20, 12, 12, 10, 10, 8, 8, 9, 9, 0, 48, 1, 1, 2, 32733, 32814, 3, 225, 0, '', 0, '', 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, '2025-02-26 01:39:26', '2025-02-26 04:31:40', 20250226, 0, 0, 60, NULL, 0, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, '2025-02-26 01:39:26', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`objid`),
  ADD KEY `key_id` (`account_name`,`char_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
