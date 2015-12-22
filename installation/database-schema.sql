-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2015 at 01:26 AM
-- Server version: 5.5.38
-- PHP Version: 5.4.45-1~dotdeb+6.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `facile.it`
--

-- --------------------------------------------------------

--
-- Table structure for table `comune`
--

CREATE TABLE `comune` (
  `comune_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comune_uid` varchar(35) NOT NULL,
  `comune_name` varchar(35) NOT NULL,
  PRIMARY KEY (`comune_ID`),
  UNIQUE KEY `comune_uid` (`comune_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fuel`
--

CREATE TABLE `fuel` (
  `fuel_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fuel_uid` varchar(32) NOT NULL,
  `fuel_name` varchar(32) NOT NULL,
  PRIMARY KEY (`fuel_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fuelprovider`
--

CREATE TABLE `fuelprovider` (
  `fuelprovider_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fuelprovider_uid` varchar(260) NOT NULL,
  `fuelprovider_name` varchar(260) NOT NULL,
  PRIMARY KEY (`fuelprovider_ID`),
  UNIQUE KEY `fuelprovider_uid` (`fuelprovider_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `price_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price_value` float NOT NULL,
  `price_self` tinyint(1) NOT NULL,
  `price_date` varchar(16) NOT NULL,
  `fuel_ID` int(10) unsigned NOT NULL,
  `station_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`price_ID`),
  KEY `station_ID` (`station_ID`),
  KEY `fuel_ID` (`fuel_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provincia`
--

CREATE TABLE `provincia` (
  `provincia_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provincia_uid` varchar(2) NOT NULL,
  `provincia_name` varchar(32) NOT NULL,
  PRIMARY KEY (`provincia_ID`),
  UNIQUE KEY `provincia_uid` (`provincia_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rel_provincia_comune`
--

CREATE TABLE `rel_provincia_comune` (
  `provincia_ID` int(10) unsigned NOT NULL,
  `comune_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`provincia_ID`,`comune_ID`),
  KEY `comune_ID` (`comune_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `station_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_miseID` int(10) unsigned NOT NULL,
  `station_name` varchar(128) NOT NULL,
  `station_type` enum('STRADA_STATALE','AUTOSTRADALE','ALTRO') NOT NULL,
  `station_address` varchar(255) NOT NULL,
  `station_lat` float NOT NULL,
  `station_lon` float NOT NULL,
  `comune_ID` int(10) unsigned NOT NULL,
  `stationowner_ID` int(10) unsigned NOT NULL,
  `fuelprovider_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`station_ID`),
  UNIQUE KEY `station_miseID` (`station_miseID`),
  KEY `comune_ID` (`comune_ID`),
  KEY `station_lat` (`station_lat`),
  KEY `station_lon` (`station_lon`),
  KEY `fuelprovider_ID` (`fuelprovider_ID`),
  KEY `stationowner_ID` (`stationowner_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stationowner`
--

CREATE TABLE `stationowner` (
  `stationowner_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stationowner_uid` varchar(256) NOT NULL,
  `stationowner_name` varchar(256) NOT NULL,
  `stationowner_note` text,
  PRIMARY KEY (`stationowner_ID`),
  UNIQUE KEY `stationowner_uid` (`stationowner_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
