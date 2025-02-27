-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 11:28 AM
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
-- Table structure for table `character_items`
--

CREATE TABLE `character_items` (
  `id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `is_equipped` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `enchantlvl` int(11) NOT NULL DEFAULT 0,
  `is_id` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `durability` int(2) NOT NULL DEFAULT 0,
  `charge_count` int(11) NOT NULL DEFAULT 0,
  `remaining_time` int(11) NOT NULL DEFAULT 0,
  `last_used` datetime DEFAULT NULL,
  `bless` int(3) NOT NULL DEFAULT 1,
  `attr_enchantlvl` int(3) NOT NULL DEFAULT 0,
  `special_enchant` int(3) NOT NULL DEFAULT 0,
  `doll_ablity` int(4) NOT NULL DEFAULT 0,
  `end_time` datetime DEFAULT NULL,
  `KeyVal` int(6) NOT NULL DEFAULT 0,
  `package` tinyint(1) NOT NULL DEFAULT 0,
  `engrave` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `scheduled` tinyint(1) NOT NULL DEFAULT 0,
  `slot_0` int(5) NOT NULL DEFAULT 0,
  `slot_1` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- Dumping data for table `character_items`
--

INSERT INTO `character_items` (`id`, `item_id`, `char_id`, `item_name`, `count`, `is_equipped`, `enchantlvl`, `is_id`, `durability`, `charge_count`, `remaining_time`, `last_used`, `bless`, `attr_enchantlvl`, `special_enchant`, `doll_ablity`, `end_time`, `KeyVal`, `package`, `engrave`, `scheduled`, `slot_0`, `slot_1`) VALUES
(336380012, 40030, 336380011, 'Templar Haste Potion', 10, 0, 0, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0),
(336380013, 35, 336380011, 'Templar Sword', 1, 0, 0, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0),
(336380014, 60723, 336380011, 'Templar Red Potion', 200, 0, 0, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0),
(336380015, 40095, 336380011, 'Templar Escape Scroll', 10, 0, 0, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0),
(336380018, 40308, 336380011, 'Adena', 10000, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `character_items`
--
ALTER TABLE `character_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`char_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
