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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remotesdb`.`view_protocoldata` AS select `remotesdb`.`irp_protocols`.`idprotocol` AS `idprotocol`,`remotesdb`.`irp_protocols`.`name` AS `name`,`remotesdb`.`irp_protocols`.`IRP` AS `IRP`,`remotesdb`.`irp_protocoldata`.`base_time` AS `base_time`,`remotesdb`.`irp_protocoldata`.`coding` AS `coding`,`remotesdb`.`irp_protocoldata`.`min` AS `min`,`remotesdb`.`irp_protocoldata`.`MAX` AS `MAX`,least(`remotesdb`.`irp_protocoldata`.`len00`,`remotesdb`.`irp_protocoldata`.`len55`,`remotesdb`.`irp_protocoldata`.`lenAA`,`remotesdb`.`irp_protocoldata`.`lenFF`) AS `minLEN`,greatest(`remotesdb`.`irp_protocoldata`.`len00`,`remotesdb`.`irp_protocoldata`.`len55`,`remotesdb`.`irp_protocoldata`.`lenAA`,`remotesdb`.`irp_protocoldata`.`lenFF`) AS `maxLEN`,least(`remotesdb`.`irp_protocoldata`.`rawMicros00`,`remotesdb`.`irp_protocoldata`.`rawMicros55`,`remotesdb`.`irp_protocoldata`.`rawMicrosAA`,`remotesdb`.`irp_protocoldata`.`rawMicrosFF`) AS `minRAWms`,greatest(`remotesdb`.`irp_protocoldata`.`rawMicros00`,`remotesdb`.`irp_protocoldata`.`rawMicros55`,`remotesdb`.`irp_protocoldata`.`rawMicrosAA`,`remotesdb`.`irp_protocoldata`.`rawMicrosFF`) AS `maxRAWms` from (`remotesdb`.`irp_protocols` left join `remotesdb`.`irp_protocoldata` on((`remotesdb`.`irp_protocols`.`idprotocol` = `remotesdb`.`irp_protocoldata`.`idprotocol`)));
