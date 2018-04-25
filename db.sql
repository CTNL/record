-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2018 at 03:52 PM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE `record18`;
CREATE DATABASE IF NOT EXISTS `record18`;
USE `record18`;

--
-- Database: `record18`
--

-- --------------------------------------------------------

--
-- Table structure for table `mesaj`
--

CREATE TABLE IF NOT EXISTS `mesaj` (
  `id` smallint(5) unsigned NOT NULL,
  `sid` int(8) unsigned NOT NULL,
  `name` varchar(80) CHARACTER SET utf8 NOT NULL,
  `text` varchar(800) CHARACTER SET utf8 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1255 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mesaj`
--

INSERT INTO `mesaj` VALUES
( 1000, 2014706057, 'Deneme Soyad', 'Sana şunları söylemek istiyorum ki, \r\nkarman çorman bir sistem yapmışsın!', '2016-04-10 20:19:49', 784693629, 0, 0),
( 1001, 2014706057, 'İkinci Denemeoğlu', 'Umarım bu sefer düzgün çalışır...', '2016-04-10 20:21:52', 784693629, 0, 0);
-- --------------------------------------------------------

--
-- Table structure for table `ogrenci`
--

CREATE TABLE IF NOT EXISTS `ogrenci` (
  `id` int(8) unsigned NOT NULL,
  `ksifre` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `zsifre` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ogrenci`
--

INSERT INTO `ogrenci` VALUES
(2014706057, 'CTNL1990', 'YIGIT123', 'YİĞİT ÇETİNEL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mesaj`
--
ALTER TABLE `mesaj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ogrenci`
--
ALTER TABLE `ogrenci`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mesaj`
--
ALTER TABLE `mesaj`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1002;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
