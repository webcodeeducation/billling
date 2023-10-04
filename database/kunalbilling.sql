-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2023 at 06:40 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kunalbilling`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(1, 'fatehbad', '2023-04-10 09:00:27'),
(2, 'karnal', '2023-04-10 09:01:12'),
(3, 'panipat', '2023-04-10 09:01:12'),
(4, 'Kurukshetra', '2023-04-12 10:24:49'),
(5, 'shahbad', '2023-04-12 10:45:16'),
(6, 'chandigarh', '2023-04-12 10:45:16'),
(7, 'panipat', '2023-04-12 10:45:16'),
(9, 'bhiwani', '2023-04-12 10:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_address` varchar(250) NOT NULL,
  `customer_number` bigint(15) NOT NULL,
  `customer_pan` bigint(15) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`, `customer_name`, `customer_address`, `customer_number`, `customer_pan`, `created_date`) VALUES
(15, 1, 'Aakash Sharma', 'Sector 17 kurukshetra', 124567890, 123456, '2023-04-12 16:22:40'),
(16, 1, 'Gb glass', 'alsdkfjaf sadlfkjfakdlf jlfasdkfkafakdl', 1234567890, 123456, '2023-04-14 15:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order`
--

CREATE TABLE `invoice_order` (
  `order_id` int(11) NOT NULL,
  `category_id` int(10) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` varchar(20) NOT NULL,
  `bill_no` varchar(50) DEFAULT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `order_total_tax` decimal(10,2) NOT NULL,
  `cgst` varchar(20) NOT NULL DEFAULT '0',
  `sgst` varchar(20) NOT NULL DEFAULT '0',
  `igst` varchar(20) NOT NULL DEFAULT '0',
  `order_tax_per` varchar(250) DEFAULT NULL,
  `order_total_after_tax` double(10,2) NOT NULL,
  `order_amount_paid` decimal(10,2) NOT NULL,
  `order_total_amount_due` decimal(10,2) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_order`
--

INSERT INTO `invoice_order` (`order_id`, `category_id`, `user_id`, `customer_id`, `order_date`, `bill_no`, `order_total_before_tax`, `order_total_tax`, `cgst`, `sgst`, `igst`, `order_tax_per`, `order_total_after_tax`, `order_amount_paid`, `order_total_amount_due`, `note`) VALUES
(37, 7, 1, 16, '04/26/2023', '20042023/491', '42028.10', '7565.06', '9', '9', '0', '81', 49593.16, '0.00', '49593.16', '							Bank Name: Bank of Baroda\r\nPlace: Thanesar Branch, Thanesar 136118\r\nA/C No: 50720200000194\r\nIFSC Code: Thanesar Branch, Thanesar 136118\r\n						'),
(38, 4, 1, 16, '04/01/2023', '26042023/871', '3919268.00', '705468.24', '0', '0', '0', '81', 705468.24, '0.00', '4624736.24', '							Bank Name: Bank of Baroda\r\nPlace: Thanesar Branch, Thanesar 136118\r\nA/C No: 50720200000194\r\nIFSC Code: Thanesar Branch, Thanesar 136118\r\n						'),
(40, 2, 1, 15, '08/16/2023', '11082023/802', '83757.00', '15076.26', '9', '9', '0', '81', 15076.00, '0.00', '98833.00', '							Bank Name: Bank of Baroda\r\nPlace: Thanesar Branch, Thanesar 136118\r\nA/C No: 50720200000194\r\nIFSC Code: Thanesar Branch, Thanesar 136118\r\n						');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order_item`
--

CREATE TABLE `invoice_order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_code` varchar(250) DEFAULT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_hsn` varchar(100) DEFAULT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `order_item_price` decimal(10,2) NOT NULL,
  `order_item_final_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_order_item`
--

INSERT INTO `invoice_order_item` (`order_item_id`, `order_id`, `item_code`, `item_name`, `order_item_hsn`, `order_item_quantity`, `order_item_price`, `order_item_final_amount`) VALUES
(51, 37, '', 'aa', NULL, '25.00', '32.32', '808.00'),
(52, 37, '', 'bb', NULL, '45.00', '65.65', '2954.25'),
(53, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(54, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(55, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(56, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(57, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(58, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(59, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(60, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(61, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(62, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(63, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(64, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(65, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(66, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(67, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(68, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(69, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(70, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(71, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(72, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(73, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(74, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(75, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(76, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(77, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(78, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(79, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(80, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(81, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(82, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(83, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(84, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(85, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(86, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(87, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(88, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(89, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(90, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(91, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(92, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(93, 37, '', 'cc', NULL, '789.00', '32.65', '25760.85'),
(94, 38, NULL, 'a1', NULL, '100.00', '25.22', '2522.00'),
(95, 38, NULL, 'a1', NULL, '150.00', '25.50', '3825.00'),
(96, 38, NULL, 'a3', NULL, '250.00', '1547.00', '386750.00'),
(97, 38, NULL, 'a4', NULL, '150.00', '236.32', '35448.00'),
(98, 38, NULL, 'a5', NULL, '58.00', '214.00', '12412.00'),
(99, 38, NULL, 'a6', NULL, '478.00', '2145.00', '1025310.00'),
(100, 38, NULL, 'a7', NULL, '258.00', '325.00', '83850.00'),
(101, 38, NULL, 'a8', NULL, '47.00', '54.00', '2538.00'),
(102, 38, NULL, 'a9', NULL, '74.00', '5.00', '370.00'),
(103, 38, NULL, 'a10', NULL, '145.00', '214.00', '31030.00'),
(104, 38, NULL, 'a11', NULL, '547.00', '54.00', '29538.00'),
(105, 38, NULL, 'a12', NULL, '745.00', '854.00', '636230.00'),
(106, 38, NULL, 'a13', NULL, '47.00', '52.00', '2444.00'),
(107, 38, NULL, 'a14', NULL, '745.00', '547.00', '407515.00'),
(108, 38, NULL, 'a15', NULL, '2154.00', '521.00', '1122234.00'),
(109, 38, NULL, 'a16', NULL, '215.00', '52.00', '11180.00'),
(110, 38, NULL, 'a17', NULL, '548.00', '54.00', '29592.00'),
(111, 38, NULL, 'a18', NULL, '65.00', '58.00', '3770.00'),
(112, 38, NULL, 'a19', NULL, '365.00', '254.00', '92710.00'),
(136, 40, '333', 'product A', 'sdf', '654.00', '10.00', '6540.00'),
(137, 40, '2322', 'product B', 'fff', '25.00', '21.00', '525.00'),
(138, 40, '23213', 'product C', 'ddd', '14.00', '5478.00', '76692.00'),
(139, 40, '323', 'product SS', 'ee', '14.00', '5478.00', '76692.00'),
(140, 40, '23', 'product SS', 'ss', '14.00', '5478.00', '76692.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_user`
--

CREATE TABLE `invoice_user` (
  `id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_user`
--

INSERT INTO `invoice_user` (`id`, `email`, `password`, `first_name`, `last_name`, `mobile`, `address`) VALUES
(1, 'kunal@gmail.com', 'bill@123', 'Kunal', 'Sharma', 8814871038, 'Kalal Majra, Near Hanuman Mandir, Thanesar, Kurukshetra');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `receipt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Customer_id` int(11) NOT NULL,
  `invoice_id` int(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `cgst` varchar(15) NOT NULL,
  `sgst` varchar(15) NOT NULL,
  `gstno` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_place` text NOT NULL,
  `acc_no` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `cgst`, `sgst`, `gstno`, `bank_name`, `bank_place`, `acc_no`, `phone`, `ifsc`, `address`, `email`) VALUES
(4, '9', '9', 'O6E0EPK2745NIZL', 'Bank of Baroda', 'Thanesar Branch, Thanesar 136118', '50720200000194', '8814871038', 'PUNB0400100', '123Kalal Majra, Near Hanuman Mandir, Thanesar, Kurukshetra', 'ks744322@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `invoice_order`
--
ALTER TABLE `invoice_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `invoice_customer_key` (`customer_id`);

--
-- Indexes for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `invoice_user`
--
ALTER TABLE `invoice_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_number`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `foreign_key` (`invoice_id`),
  ADD KEY `key` (`Customer_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `invoice_order`
--
ALTER TABLE `invoice_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `invoice_user`
--
ALTER TABLE `invoice_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_order`
--
ALTER TABLE `invoice_order`
  ADD CONSTRAINT `invoice_customer_key` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `foreign_key` FOREIGN KEY (`invoice_id`) REFERENCES `invoice_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key` FOREIGN KEY (`Customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
