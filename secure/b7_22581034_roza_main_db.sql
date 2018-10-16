-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql305.byethost.com
-- Generation Time: Oct 11, 2018 at 07:18 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b7_22581034_roza_main_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
  `address` char(16) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ip-registration`
--

CREATE TABLE IF NOT EXISTS `ip-registration` (
  `address` char(16) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `rating` tinyint(4) NOT NULL,
  `content` varchar(300) NOT NULL,
  `user_id` int(12) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`rating`, `content`, `user_id`) VALUES
(5, 'bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla bla bla bla bla bla bla bla bla ', 5),
(4, 'SELECT schema_name FROM information_schema.schemata;', 38),
(4, 'my man!!!', 7),
(5, 'amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing amazing ', 6),
(1, 'la la li, I use php', 4),
(5, 'jj here\r\n<script>alert(''xss'');</script>', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `firstName`, `lastName`, `password`, `created_at`) VALUES
(3, 'jj@jj.jj', 'jj', 'jj', '123456', '2018-08-19 06:39:55'),
(4, 'tt', 'jj', 'jj', '123456', '2018-08-19 06:40:27'),
(5, 'zz', 'tt', 'tt', '1234567', '2018-08-19 06:46:42'),
(6, 'aaa', 'aaa', 'aaa', 'aaaaaa', '2018-08-19 06:50:20'),
(7, 'admin', 'admin', 'admin', 'admin', '2018-08-19 09:01:45'),
(40, 'ff@ff.ff', 'lala', 'lili', 'passpass', '2018-08-22 09:54:45'),
(39, 'ee@ee.ee', 'lala', 'lili', 'passpass', '2018-08-22 09:54:35'),
(38, 'dd@dd.dd', 'lala', 'lili', 'passpass', '2018-08-22 09:54:25'),
(37, 'cc@cc.cc', 'lala', 'lili', 'passpass', '2018-08-22 09:54:16'),
(35, 'aa@aa.aa', 'lala', 'lili', 'passpass', '2018-08-22 09:53:56'),
(36, 'bb@bb.bb', 'lala', 'lili', 'passpass', '2018-08-22 09:54:06'),
(41, 'gg@gg.gg', 'lala', 'lili', 'passpass', '2018-08-22 09:54:55'),
(42, 'qq@qq.qq', 'qq', 'qq', '123456', '2018-10-08 06:39:55'),
(43, 'qqq@qqq.qqq', 'qqq', 'qqq', '123456', '2018-10-08 06:40:48'),
(45, 'secure@secure.secure', 'secure', 'secure', '$2y$10$Wo9XGJkedc1pwPnb5i57Ku5Veapn/Sf.qw5cON74o5JPayuKG6Y32', '2018-10-11 06:56:37'),
(46, 'secure2@secure2.secure2', 'secureSecond', 'secureSecond', '$2y$10$dK3SSDPltzldOTfq1TPV4.Gyc.PBx6b/AEejIRXRPvobAWr0VXgrC', '2018-10-11 07:05:30');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
