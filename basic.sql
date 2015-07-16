-- phpMyAdmin SQL Dump
-- version 2.8.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 15, 2015 at 09:36 PM
-- Server version: 5.0.22
-- PHP Version: 5.1.4
-- 
-- Database: `basic`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `codelines`
-- 

CREATE TABLE `codelines` (
  `id` int(1) NOT NULL auto_increment,
  `lineNum` int(1) NOT NULL,
  `lineCmd` varchar(80) NOT NULL,
  `lineAttribute` varchar(80) NOT NULL,
  `userNum` int(1) NOT NULL,
  `fileNum` int(1) NOT NULL,
  `timeDateStamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `lineTemp` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=399 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `filesmanager`
-- 

CREATE TABLE `filesmanager` (
  `id` int(1) NOT NULL auto_increment,
  `fileName` varchar(80) NOT NULL,
  `permission` varchar(80) NOT NULL,
  `userNum` int(1) NOT NULL,
  `timeDateStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(1) NOT NULL auto_increment,
  `userName` varchar(80) NOT NULL default '',
  `passWord` varchar(80) NOT NULL default '',
  `eMail` varchar(80) NOT NULL,
  `level` varchar(80) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;
