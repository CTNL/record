--
-- Table structure for table `mesaj`
--

CREATE TABLE IF NOT EXISTS `mesaj` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sid` varchar(60) NOT NULL,
  `name` varchar(80) CHARACTER SET utf8 NOT NULL,
  `text` varchar(800) CHARACTER SET utf8 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mesaj`
--

INSERT INTO `mesaj` VALUES
( 1000, 'test@example.com', 'Test Writer', 'Lorem ipsum!', '2018-01-01 00:00:00', 2130706433, 0, 0);
-- --------------------------------------------------------

--
-- Table structure for table `ogrenci`
--

CREATE TABLE IF NOT EXISTS `ogrenci` (
  `id` varchar(60) NOT NULL PRIMARY KEY,
  `ksifre` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `zsifre` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ogrenci`
--

INSERT INTO `ogrenci` VALUES
('test@example.com', '12345', 'qwerty', 'Test User');

