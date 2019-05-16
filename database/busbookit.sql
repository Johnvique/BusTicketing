-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2019 at 07:55 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `busbookit`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `seat_no` varchar(255) DEFAULT NULL,
  `departure` datetime DEFAULT NULL,
  `bus_no` varchar(255) DEFAULT NULL,
  `your_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `seat_no`, `departure`, `bus_no`, `your_name`, `phone`) VALUES
(1, '45', '0000-00-00 00:00:00', '4545rtgfhfg', NULL, NULL),
(2, '45', '0000-00-00 00:00:00', 'kcd', NULL, NULL),
(3, 'csdacz', '0000-00-00 00:00:00', 'z', NULL, NULL),
(4, 'dfbvjkdfvkdsv', '0000-00-00 00:00:00', 'bjkf', 'jbkb', 'vhgfghyygyugugyu');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL,
  `bus_no` varchar(255) DEFAULT NULL,
  `seats_no` varchar(255) DEFAULT NULL,
  `bus_type` varchar(255) DEFAULT NULL,
  `driver` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_no`, `seats_no`, `bus_type`, `driver`, `status`) VALUES
(1, 'kcd 574k', '50', 'couch', 'mwangi jack', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `booking_id` varchar(255) DEFAULT NULL,
  `driver` varchar(255) DEFAULT NULL,
  `bus_no` varchar(255) DEFAULT NULL,
  `compliaint` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complains`
--

INSERT INTO `complains` (`id`, `name`, `booking_id`, `driver`, `bus_no`, `compliaint`, `date`) VALUES
(1, 'wahome mutahi', 'rgerferr32wr23', 'mwangi jack', 'kcd 574k', 'hii bus inasimama upuuziii, si mlisema ni express', '2019-05-09 19:08:53'),
(2, 'DSFSD', 'SDFSDF', 'DS', 'SDFSD', 'SDGDFSD', '2019-05-09 19:08:53'),
(3, 'DSFS', 'SDFDS', 'FDSFFSDF', 'DSFDSF', 'SDFSDFSDFSD', '2019-05-09 19:08:53'),
(4, 'DSFSDF', 'SDFSDFSD', 'GERFWE', 'EWREG', 'ERWETYRTHGER', '2019-05-09 19:08:53'),
(5, 'DFSDF', 'SDFSDF', 'FSDFDS', 'FSDFSD', 'FSDFSDFSD', '2019-05-09 19:08:53'),
(6, 'rdgdf', 'fgdf', 'dfgdf', 'fdgd', 'fdgdf', '2019-05-09 19:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(20) DEFAULT NULL,
  `password_reset_key` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `password`, `login_session_key`, `email_status`, `password_reset_key`, `role`) VALUES
(1, 'user', '000000000', 'user@user.com', '$2y$10$Ufz2pYCtl8mj6/9VHdWBwutP5tbZR4xO4JTCfgliqcA74PyfuyrrW', NULL, NULL, NULL, NULL),
(2, 'jay', '0395i34949', 'jay@jayu.com', '$2y$10$mgKgUc0MrxGqhiqz9BkpAeUn08GFRMh0N3z8Mmas3eSc2mptYUdEq', NULL, NULL, NULL, 'user'),
(3, 'admin', 'admin', 'admin@admin.com', '$2y$10$oOObysk.MM7f.nC4qfaPpu9nSV3yv8H.ZN8IK10/MUSfzKj45OpMK', NULL, NULL, NULL, 'administrator'),
(4, 'jim', 'jim', 'j@j.com', '$2y$10$TzAJcoSBTgu2JJMWNMYr5etrZD91Y68BhuLzGM/hrJpPh0Kh2sb4u', NULL, NULL, NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(20) DEFAULT NULL,
  `password_reset_key` varchar(255) DEFAULT NULL,
  `roles` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `photo`, `name`, `contact`, `address`, `email`, `login_session_key`, `email_status`, `password_reset_key`, `roles`) VALUES
(1, 'http://localhost/bookit/uploads/files/3fhi8t1nwo_0dx2.jpg', 'new', '07990493', 'nyeri', 'jay@jay.com', NULL, NULL, NULL, NULL),
(2, 'http://localhost/bookit/uploads/files/zx5jpgb_ho96lq2.jpg', 'joseph mwangi', '070099524', 'nairobi', 'jose@gmail.com', NULL, NULL, NULL, NULL),
(3, 'http://localhost/bookit/uploads/files/6mgdpyh3a2sv_i1.jpg', 'zxczx', 'xczx', 'zxcz', 'xzczxczx@cscx.vfs', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `boking_id` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `transaction_no` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `boking_id`, `date`, `transaction_no`, `status`) VALUES
(1, 'bcfh1123', 'Enter Date', 'mvgh1i2355', 'paid'),
(2, 'rgerferr32wr23', 'Enter Date', '23r43egfergfer', '23rrgerger'),
(3, 'dsvsdc', 'Enter Date', 'csdcvsdv', 'sdvsdvs'),
(4, 'scsdcs', 'Enter Date', 'dsvsdvd', 'sdvsdv');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `bus` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `your_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `bus`, `level`, `status`, `your_name`) VALUES
(1, 'kcd 574k', 'vip', 'paid', 'james wahome'),
(2, 'kcd 574k', 'qweqw', 'paid', 'qwdedssax'),
(3, 'kcd 574k', 'gfhrtfg', 'cancled', 'ergergeg');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `From_To` varchar(255) DEFAULT NULL,
  `departure` varchar(255) DEFAULT NULL,
  `arrival` datetime DEFAULT NULL,
  `mode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `From_To`, `departure`, `arrival`, `mode`) VALUES
(1, 'sfwsdfs', 'Enter Departure', '0000-00-00 00:00:00', 'Express'),
(2, 'NYERI- THIKA', '2019-05-15 12:05:00', '2019-05-10 12:00:00', 'Express');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
