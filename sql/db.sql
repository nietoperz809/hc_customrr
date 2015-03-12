-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2015 at 06:21 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hc_customer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `vname` varchar(32) DEFAULT NULL,
  `telnr` varchar(32) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  `street` char(32) DEFAULT NULL,
  `ort` varchar(32) DEFAULT NULL,
  `hausnr` varchar(32) DEFAULT NULL,
  `plz` varchar(32) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `remarks` varchar(256) DEFAULT NULL,
  `anrede` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `vname`, `telnr`, `email`, `street`, `ort`, `hausnr`, `plz`, `enabled`, `remarks`, `anrede`) VALUES
(1, 'test', '', '', '', '', '', '', '', 1, '', ''),
(2, 'hallo2', 'hallo3', '', '', '', '', '', '', 0, 'doof', 'hallo1'),
(3, 'hallo2', 'hallo3', '', '', '', '', '', '', 0, 'doof', 'hallo1'),
(4, 'hallo2', 'hallo3', '2334455', '', '', '', '', '', 1, 'doof', 'hallo1'),
(5, 'hallo2', 'hallo3', '', '', '', '', '', '', 0, 'doof', 'hallo1'),
(6, 'fuxx', 'hallo3', '', '', '', '', '', '', 1, 'doof', 'hallo1'),
(7, 'hallo2', 'hallo3', '', '', '', '', '', '', 1, 'doof', 'hallo1'),
(8, '', '', '', '', '', '', '', '', 1, '', ''),
(9, '', '', '', '', '', '', '', '', 1, '', ''),
(10, '', '', '', '', '', '', '', '', 1, '', ''),
(11, '', '', '', '', '', '', '', '', 1, '', ''),
(12, '', '', '', '', '', '', '', '', 1, '', ''),
(13, '', '', '', '', '', '', '', '', 1, '', ''),
(14, '', '', '', '', '', '', '', '', 1, '', 'blah'),
(15, '', '', '', '', '', '', '', '', 1, '', 'blah'),
(16, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(17, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(18, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(19, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(20, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(21, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(22, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(23, '', '', 'sss', '', '', '', '', '', 1, '', 'blah'),
(24, '', '', '', '', '', '', '', '', 1, '', ''),
(25, '', '', '', '', '', '', '', '', 1, '', ''),
(26, '', '', '', '', '', '', '', '', 1, '', ''),
(27, '', '', '', '', '', '', '', '', 1, '', ''),
(28, '', '', '', '', '', '', '', '', 1, '', ''),
(29, '', '', '', '', '', '', '', '', 1, '', ''),
(30, 'hallo2', 'hallo3', '', '', '', '', '', '', 1, 'doof', 'hallo1'),
(31, 'hallo2', 'hallo3', '', '', '', '', '', '', 1, 'doof', 'hallo1'),
(32, 'hallo2', 'hallo3', '', '', '', '', '', '', 1, 'doof', 'hallo1'),
(33, 'hallo2', 'hallo3', '', '', '', '', '', '', 1, 'doof', 'hallo1'),
(34, '', '', '', '', '', '', '', '', 1, '', ''),
(35, '', '', '', '', '', '', '', '', 1, '', ''),
(36, '', '', '', '', '', '', '', '', 1, '', ''),
(37, 'krass', 'gut', '', '', '', '', '', '', 1, '', 'peter'),
(38, 'krass', 'gut', '', '', '', '', '', '', 1, '', 'peter'),
(39, 'krass', 'gut', '', '', '', '', '', '', 1, '', 'peter'),
(40, '', '', '', '', '', '', 'na', 'sowas', 1, '            $link = connect();', 'hallo'),
(41, '', '', '', '', '', '', '', '', 1, '', ''),
(42, '', '', '', '', '', '', '', '', 1, '', ''),
(43, '', '', '', '', '', '', '', '', 1, '', ''),
(44, '', '', '', '', '', '', '', '', 1, '', ''),
(45, 'laladumm', 'fuck', '', 'off', '', '', 'you', 'bastard', 1, '', 'ddd'),
(46, '', '', '', '', '', '', '', '', 1, '', ''),
(47, '', '', '', '', '', '', '', '', 1, '', ''),
(48, '', '', '', '', '', '', '', '', 1, '', ''),
(49, '', '', '', '', '', '', '', '', 1, '', ''),
(50, '', '', '', '', '', '', '', '', 1, '', ''),
(51, '', '', '', '', '', '', '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cust_id` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `typ` tinyint(1) NOT NULL,
  `payment` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `cust_id`, `date`, `typ`, `payment`) VALUES
(1, 4, '2015-03-11 19:53:20', 1, 0),
(2, 4, '2015-03-11 19:54:50', 1, 1),
(3, 4, '2015-03-11 19:55:34', 0, 1),
(4, 4, '2015-03-11 20:14:03', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_line`
--

CREATE TABLE IF NOT EXISTS `invoice_line` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(10) unsigned NOT NULL,
  `items` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `text` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `invoice_line`
--

INSERT INTO `invoice_line` (`id`, `invoice_id`, `items`, `price`, `text`) VALUES
(1, 4, 2, 4, 'lala'),
(2, 4, 5, 22, 'doof');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
