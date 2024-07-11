-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2023 at 03:10 AM
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
-- Table structure for table `data_product`
--

CREATE TABLE `data_product` (
  `product_id` int(11) NOT NULL,
  `product_parent` int(11) NOT NULL DEFAULT '0' COMMENT 'diisi id product utama jika produk variasi',
  `product_code` varchar(30) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_type` enum('Konsinyasi','Makanan','Minuman','Bakery') NOT NULL,
  `product_price` decimal(16,2) DEFAULT NULL,
  `product_desc` text,
  `product_pict` varchar(250) DEFAULT NULL,
  `product_st` enum('0','1') DEFAULT NULL COMMENT '0: active,1: inactive',
  `status_product` enum('Arrival','Prelaunch','Product') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_product`
--

INSERT INTO `data_product` (`product_id`, `product_parent`, `product_code`, `product_name`, `product_type`, `product_price`, `product_desc`, `product_pict`, `product_st`, `status_product`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(2, 0, 'PKE1000', 'Bakpia Nyoba', 'Konsinyasi', '50000.00', NULL, 'GreenTea_E.jpg', '0', 'Product', '2023-10-16 08:39:47', 1, '2023-11-03 19:29:54', 1),
(3, 2, 'PKE1001', 'Bakpia Kumbu Isi 15', 'Bakery', '50000.00', NULL, '30becbc00779107e91f5214da5cb3c47.jpg', '0', 'Product', '2023-10-16 08:40:18', 1, NULL, NULL),
(4, 0, 'PKE1016', 'cilok bandung', 'Konsinyasi', '35000.00', NULL, NULL, '0', 'Product', '2023-10-11 09:44:18', 1, NULL, NULL),
(5, 0, 'PKE1008', 'bakpiasss', 'Konsinyasi', '35000.00', NULL, 'db8ef1cd5cd768e54364d9df8785e7c5.jpg', '0', 'Product', '2023-09-23 08:38:29', 1, NULL, NULL),
(6, 0, 'PKE1012', 'marlboro filter black', 'Konsinyasi', '35000.00', NULL, 'eeeddbadf18c5df8a873aabed017bad2.jpeg', '0', 'Product', '2023-09-23 08:41:28', 1, '2023-09-23 08:42:29', 1),
(7, 0, 'PKE1014', 'camel purple boost', 'Konsinyasi', '20000.00', NULL, 'bc0d8679bf3a77bc74f6b8b6d9944a03.jpg', '0', 'Product', '2023-09-23 08:43:16', 1, NULL, NULL),
(9, 0, 'PKE1015', 'bakso', 'Konsinyasi', '15000.00', NULL, 'fb9dbc22548a4840b1fd0e9312275ae1.jpg', '0', 'Product', '2023-09-23 08:46:05', 1, NULL, NULL),
(12, 0, 'PKE1009', 'seblak glosor', 'Konsinyasi', '24000.00', NULL, '47247818cdd3710a53cbb9091dc198bf.jpeg', '0', 'Product', '2023-09-23 08:40:28', 1, NULL, NULL),
(13, 0, 'PKE1010', 'cilok bandung', 'Konsinyasi', '20000.00', NULL, 'bf9af0231dc763d5168b61897f8c3821.jpg', '0', 'Product', '2023-09-23 08:40:44', 1, NULL, NULL),
(14, 0, 'PKE1011', 'bata goreng', 'Konsinyasi', '15000.00', NULL, 'da6f3193d6b3763b37e662737b7a3e31.jpg', '0', 'Product', '2023-09-23 08:41:07', 1, NULL, NULL),
(21, 0, 'PKE1017', 'Kastangel Ubah', 'Konsinyasi', '20000.00', NULL, NULL, '0', 'Product', '2023-11-03 22:13:48', 1, '2023-11-03 22:21:42', 1),
(22, 21, 'PKE1018', 'Kastangel Isi 20', 'Konsinyasi', '20000.00', NULL, NULL, '0', 'Product', '2023-11-03 22:14:27', 1, NULL, NULL),
(23, 0, 'PKE1019', 'Tes  1', 'Konsinyasi', '20000.00', NULL, NULL, '0', 'Arrival', '2023-11-04 08:11:42', 1, NULL, NULL),
(24, 0, 'PKE1020', 'Nyobaaa', 'Konsinyasi', '40000.00', '<p><b><u>INI NYOBA NYOBA SAJA</u></b></p>', NULL, '0', 'Product', '2023-11-08 10:08:49', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_product`
--
ALTER TABLE `data_product`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_product`
--
ALTER TABLE `data_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
