-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2015 at 12:11 AM
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

CREATE TABLE IF NOT EXISTS `comune` (
  `comune_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comune_uid` varchar(64) NOT NULL,
  `comune_name` varchar(64) NOT NULL,
  PRIMARY KEY (`comune_ID`),
  UNIQUE KEY `comune_uid` (`comune_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5197 ;

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `idImpianto` int(10) unsigned NOT NULL,
  `descCarburante` varchar(64) NOT NULL,
  `prezzo` float NOT NULL,
  `isSelf` tinyint(1) NOT NULL,
  `dtComu` varchar(64) NOT NULL,
  KEY `idImpianto` (`idImpianto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provincia`
--

CREATE TABLE IF NOT EXISTS `provincia` (
  `provincia_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provincia_uid` varchar(2) NOT NULL,
  `provincia_name` varchar(64) NOT NULL,
  PRIMARY KEY (`provincia_ID`),
  UNIQUE KEY `provincia_uid` (`provincia_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Table structure for table `rel_provincia_comune`
--

CREATE TABLE IF NOT EXISTS `rel_provincia_comune` (
  `provincia_ID` int(10) unsigned NOT NULL,
  `comune_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`provincia_ID`,`comune_ID`),
  KEY `comune_ID` (`comune_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE IF NOT EXISTS `station` (
  `idImpianto` int(11) NOT NULL,
  `gestore` varchar(64) NOT NULL,
  `bandiera` varchar(64) NOT NULL,
  `tipoImpianto` varchar(64) NOT NULL,
  `nomeImpianto` varchar(255) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `latitudine` float NOT NULL,
  `longitudine` float NOT NULL,
  `comune_ID` int(10) unsigned NOT NULL,
  KEY `station_uid` (`idImpianto`),
  KEY `latitudine` (`latitudine`),
  KEY `longitudine` (`longitudine`),
  KEY `comune_ID` (`comune_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
