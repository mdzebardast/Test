-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2013 at 09:53 PM
-- Server version: 5.5.25a-log
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jaajoor`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `gid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `name` varchar(100) NOT NULL COMMENT 'group name',
  `parentid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`gid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`gid`, `name`, `parentid`, `uid`) VALUES
(1, 'خريد و فروش', 0, 0),
(2, 'خودرو', 0, 0),
(3, 'لباس', 0, 0),
(4, 'رستوران', 0, 0),
(5, 'بيمارستان و مطب', 0, 0),
(6, 'آرايشي', 0, 1),
(7, 'سلامتي', 0, 1),
(8, 'مردم', 0, 1),
(9, 'ورزش', 0, 9),
(12, 'خرید', 1, 13),
(13, 'خودرو', 2, 13),
(15, 'رستوران', 4, 13),
(17, 'سلامتی', 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `positionid` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `positionid` (`positionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `positionid`, `name`, `uid`) VALUES
(34, 14, 'mz_13727005396773805.jpg', 0),
(35, 14, 'mz_13727005393655547.jpg', 0),
(36, 14, 'mz_137270053915091466.jpg', 0),
(37, 15, 'mz_13727009871561425.jpg', 0),
(38, 15, 'mz_137270098711203199.jpg', 0),
(39, 15, 'mz_137270098716991378.jpg', 0),
(40, 16, 'mz_13727015675536437.jpg', 0),
(41, 16, 'mz_137270156711180995.jpg', 0),
(42, 16, 'mz_13727015672160282.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `uid` int(11) NOT NULL COMMENT 'user id',
  `name` varchar(500) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `streetid` int(11) NOT NULL,
  `site` varchar(70) NOT NULL,
  `tel` varchar(16) NOT NULL,
  `fax` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `manager` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `logo` varchar(60) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`pid`, `uid`, `name`, `region`, `streetid`, `site`, `tel`, `fax`, `email`, `manager`, `address`, `logo`, `keywords`) VALUES
(14, 1, 'تست', 2, 5, 'www.bahra.com', '09123212432', '021888222333', 'info@bahar.com', 'bahar', 'تهران - خ آزادی - خ بهار', 'mz_13727005393818255.jpg', 'بهار - آزادی - تهران'),
(15, 1, 'بهار', 3, 4, 'www.fff.com', '22', '222', 'info@gmail.com', 'تست', 'تست', 'mz_13727009873921379.jpg', 'تست'),
(16, 13, 'ساسان', 3, 4, 'سس', 'سس', 'سس', 'سس', 'سس', 'شسشس', 'mz_1372701567277495.jpg', 'شسشسش');

-- --------------------------------------------------------

--
-- Table structure for table `positiongroup`
--

CREATE TABLE IF NOT EXISTS `positiongroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL COMMENT 'group id',
  `pid` int(11) NOT NULL COMMENT 'position id',
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `street`
--

CREATE TABLE IF NOT EXISTS `street` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Street name' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `street`
--

INSERT INTO `street` (`sid`, `name`, `uid`) VALUES
(1, 'ولیعصر', 1),
(2, 'آزادی', 1),
(3, 'بهار', 2),
(4, 'مطهری', 2),
(5, 'خرمشهر', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(35) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `UserName` varchar(25) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sec_code` varchar(64) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email`, `name`, `phone`, `UserName`, `Pass`, `active`, `join_date`, `sec_code`, `type`) VALUES
(1, 'mzg@gmail.com', 'Mohammad Zebardast', '', 'mzg', 'fcea920f7412b5da7be0cf42b8c93759', 1, '2013-07-01 16:08:42', '3f5ee243547dee91fbd053c1c4a845aa', 3),
(10, 'hrz@g.com', 'Hamid Reza Jamshidi', '', 'hrz', 'fcea920f7412b5da7be0cf42b8c93759', 1, '2013-07-01 18:02:40', '2dbf21633f03afcf882eaf10e4b5caca', 1),
(11, 'admin@admin.com', 'admin', '', 'admin', 'f6fdffe48c908deb0f4c3bd36c032e72', 1, '2013-07-01 18:02:45', '07cb5f86508f146774a2fac4373a8e50', 1),
(13, 'm@t.com', 'mahdi toloei', '', 'mahdi', 'fcea920f7412b5da7be0cf42b8c93759', 1, '2013-07-01 18:02:49', '95cc7ef498e141173576365264fc5fba', 1),
(19, 'asasa@qwqwq.com', 'aasa', '', 'asss', '5d793fc5b00a2348c3fb9ab59e5ca98a', 1, '2013-06-26 19:30:24', 'd04d42cdf14579cd294e5079e0745411', 1),
(15, 'rezq@gmail.com', 'reza', '', 'reza', 'fcea920f7412b5da7be0cf42b8c93759', 1, '2012-11-14 16:24:13', '3ce3bd7d63a2c9c81983cc8e9bd02ae5', 1),
(16, 'alireza@gmail.com', 'alireza', '', 'alireza', '1a6c7b48041dd5e63de87848fe5bc68a', 1, '2012-11-17 18:46:58', 'fb2697869f56484404c8ceee2985b01d', 1),
(17, 'dsfs@sdsd.com', 'gholi', '', 'gholi', '70b4ba7e8d969a0b5a35d08f83263132', 1, '2013-06-06 13:09:27', 'dffa23e3f38973de8a5a2bce627e261b', 1),
(18, 'gnome@gmail.com', 'gnome', '', 'gnome', 'e10adc3949ba59abbe56e057f20f883e', 1, '2013-06-25 15:29:48', 'c646a3b8b24cb64c1314c03292fff0fd', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
