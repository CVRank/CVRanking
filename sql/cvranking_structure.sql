-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2012 at 07:29 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cvranking`
--

-- --------------------------------------------------------

--
-- Table structure for table `CVR_company_entity`
--

CREATE TABLE IF NOT EXISTS `CVR_company_entity` (
  `company_id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(103) DEFAULT NULL,
  `country` varchar(21) DEFAULT NULL,
  `incomecap` int(11) NOT NULL,
  `assetcap` int(11) NOT NULL,
  `marketcap` int(11) NOT NULL,
  `currencycap` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `workers` int(11) NOT NULL,
  `industryclass` int(11) NOT NULL,
  `ranked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=966 ;

-- --------------------------------------------------------

--
-- Table structure for table `CVR_cv_rating`
--

CREATE TABLE IF NOT EXISTS `CVR_cv_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `branch` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `CVR_language_entity`
--

CREATE TABLE IF NOT EXISTS `CVR_language_entity` (
  `language_id` int(2) DEFAULT NULL,
  `name_id` varchar(13) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `students` varchar(10) DEFAULT NULL,
  `official` varchar(10) DEFAULT NULL,
  `valid` varchar(10) DEFAULT NULL,
  `rating` varchar(7) DEFAULT NULL,
  `country` varchar(17) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CVR_QS12`
--

CREATE TABLE IF NOT EXISTS `CVR_QS12` (
  `university_id` int(4) DEFAULT NULL,
  `university` varchar(103) DEFAULT NULL,
  `country` varchar(21) DEFAULT NULL,
  `rating` decimal(28,13) DEFAULT NULL,
  `field` varchar(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CVR_university_entity`
--

CREATE TABLE IF NOT EXISTS `CVR_university_entity` (
  `university_id` int(3) NOT NULL AUTO_INCREMENT,
  `type` varchar(21) DEFAULT NULL,
  `name` varchar(103) DEFAULT NULL,
  `country` varchar(21) DEFAULT NULL,
  `budget` int(11) NOT NULL,
  `professors` int(11) NOT NULL,
  `students` int(11) NOT NULL,
  `ranked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`university_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=959 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
