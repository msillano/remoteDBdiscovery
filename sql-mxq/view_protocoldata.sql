-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 29 Ago, 2017 at 12:42 PM
-- Versione MySQL: 5.0.45
-- Versione PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `remotesdb`
--

-- --------------------------------------------------------

--
-- Struttura per la vista `view_protocoldata`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_protocoldata` AS select `irp_protocols`.`idprotocol` AS `idprotocol`,`irp_protocols`.`name` AS `name`,`irp_protocols`.`IRP` AS `IRP`,`irp_protocoldata`.`base_time` AS `base_time`,`irp_protocoldata`.`coding` AS `coding`,`irp_protocoldata`.`min` AS `min`,`irp_protocoldata`.`MAX` AS `MAX`,least(`irp_protocoldata`.`len00`,`irp_protocoldata`.`len55`,`irp_protocoldata`.`lenAA`,`irp_protocoldata`.`lenFF`) AS `minLEN`,greatest(`irp_protocoldata`.`len00`,`irp_protocoldata`.`len55`,`irp_protocoldata`.`lenAA`,`irp_protocoldata`.`lenFF`) AS `maxLEN`,least(`irp_protocoldata`.`rawMicros00`,`irp_protocoldata`.`rawMicros55`,`irp_protocoldata`.`rawMicrosAA`,`irp_protocoldata`.`rawMicrosFF`) AS `minRAWms`,greatest(`irp_protocoldata`.`rawMicros00`,`irp_protocoldata`.`rawMicros55`,`irp_protocoldata`.`rawMicrosAA`,`irp_protocoldata`.`rawMicrosFF`) AS `maxRAWms` from (`irp_protocols` left join `irp_protocoldata` on((`irp_protocols`.`idprotocol` = `irp_protocoldata`.`idprotocol`)));
