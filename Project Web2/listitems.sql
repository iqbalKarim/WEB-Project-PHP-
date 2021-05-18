-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 12, 2021 at 08:50 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `listitems`
--

DROP TABLE IF EXISTS `listitems`;
CREATE TABLE IF NOT EXISTS `listitems` (
  `list_name` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `item` varchar(61) COLLATE utf8_turkish_ci NOT NULL,
  `fav` varchar(60) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `listitems`
--

INSERT INTO `listitems` (`list_name`, `email`, `item`, `fav`) VALUES
('shopping', 'iqbal.karim@ug.bilkent.edu.tr', 'meh', 'yes'),
(' shopping ', 'iqbal.karim@ug.bilkent.edu.tr', 'eggs', 'yes'),
(' 3rd March ', 'iqbal.karim@ug.bilkent.edu.tr', 'youtube video', 'no');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
