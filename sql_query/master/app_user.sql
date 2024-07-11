-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 05, 2023 at 07:04 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kenesfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE `app_user` (
  `user_id` int(11) NOT NULL,
  `user_code` varchar(30) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `user_alias` varchar(50) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_key` varchar(16) DEFAULT NULL,
  `user_pass` varchar(250) DEFAULT NULL,
  `token` varchar(250) DEFAULT NULL,
  `time_token` timestamp NULL DEFAULT NULL,
  `user_photo` varchar(50) DEFAULT NULL,
  `user_st` enum('0','1') DEFAULT '0' COMMENT '0: active, 1: inactive',
  `user_lock` enum('0','1') DEFAULT '0' COMMENT '0: unlock, 1: lock',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_user`
--

INSERT INTO `app_user` (`user_id`, `user_code`, `user_name`, `user_alias`, `user_email`, `user_key`, `user_pass`, `token`, `time_token`, `user_photo`, `user_st`, `user_lock`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, '2010001', 'admin', 'Administrator', 'admin', '68169392', 'a0d11705380597ccc361dfa81542d3ff14c1269982907d58d52c42cfe5b1b230f1050924dade579cf3bd77c2ab91fceb104d43fcd3e8b7469518340c84f4309cyUElbF5+9EspYo3ajol+AP00p9599IXmeLCArdZYzO/1qhwxCVlNClKQrEeMzFDM', NULL, NULL, NULL, '0', '0', NULL, NULL, NULL, NULL),
(124, '1102024', 'faizat', '', 'faizaindahlutfiana@gmail.com', '62905086', 'b3babb89b9d7759ded9ea15990bff21a1393ecf6f5dfac49c563773b084c082464cb7ee39e89c1fa9f87428b4e0b0b90a80f5e20a90370741208879bdbb410d8UwOdR5B2cMmFk0z59J7PM376Y70OdNeO2+zr4MN6CVhOqsoE1bd/y1C/HsRQNnEt', NULL, NULL, NULL, '0', '0', NULL, NULL, NULL, NULL),
(125, '1102025', 'test1', NULL, 'test3@gmail.com', '67451530', '8d120cb37a0a36ef00235a89421afb400795f147b4a33982e01a672810dbb8987a9acf8ca1e55ce4a656c05d9c294dac84466bdda18b3916cc91043f58e0465dWzvWBZx03fLZ4Pv20yJrOfPPiMFJhzQilyDfwv0GNQiuEWfoj5xg8HrGJlyfNq22', NULL, NULL, NULL, '0', '0', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_user`
--
ALTER TABLE `app_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
