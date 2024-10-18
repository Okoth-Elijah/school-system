-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 09:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kitudesacco`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_collection_history`
--

CREATE TABLE `account_collection_history` (
  `accch_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `accch_amount` varchar(200) NOT NULL,
  `accch_time_paid` varchar(200) NOT NULL,
  `accch_date_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_payment_history`
--

CREATE TABLE `account_payment_history` (
  `accph_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `accph_amount` varchar(200) NOT NULL,
  `accph_time` varchar(200) NOT NULL,
  `accph_date` varchar(200) NOT NULL,
  `recieved_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_payment_history`
--

INSERT INTO `account_payment_history` (`accph_id`, `account_number`, `accph_amount`, `accph_time`, `accph_date`, `recieved_by`) VALUES
(6, 'K003', '4000', '2024-10-15 14:20:11 PM', '2024-10-15', 1),
(7, 'K003', '2000', '2024-10-15 14:20:41 PM', '2024-10-15', 1),
(8, 'K003', '1250', '2024-10-15 14:21:55 PM', '2024-10-15', 1),
(9, 'K003', '2000', '2024-10-15 14:27:07 PM', '2024-10-15', 1),
(10, 'K003', '50', '2024-10-15 14:28:39 PM', '2024-10-15', 1),
(11, 'K003', '150', '2024-10-15 14:31:58 PM', '2024-10-15', 1),
(12, 'K006', '2000', '2024-10-15 20:29:13 PM', '2024-10-15', 1),
(13, 'K006', '2350', '2024-10-15 20:29:40 PM', '2024-10-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `acc_id` int(11) NOT NULL,
  `acc_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`acc_id`, `acc_type`) VALUES
(1, 'Ordinary Savings Account'),
(2, 'Junior Account'),
(3, 'Fixed Deposit Account'),
(4, 'Joint or Group Account');

-- --------------------------------------------------------

--
-- Table structure for table `customer_accounts`
--

CREATE TABLE `customer_accounts` (
  `account_number` varchar(200) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `userid` int(20) NOT NULL,
  `opening_amount` varchar(200) NOT NULL,
  `opening_amount_paid` varchar(200) NOT NULL,
  `account_balance` varchar(200) NOT NULL,
  `acc_status` varchar(200) NOT NULL,
  `acc_opening_time` varchar(200) NOT NULL,
  `acc_opening_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_accounts`
--

INSERT INTO `customer_accounts` (`account_number`, `acc_id`, `userid`, `opening_amount`, `opening_amount_paid`, `account_balance`, `acc_status`, `acc_opening_time`, `acc_opening_date`) VALUES
('K001', 2, 4, '10000', '0', '0', 'pending', '2024-10-14 18:09:57 PM', '2024-10-14'),
('K002', 3, 4, '5000', '0', '0', 'pending', '2024-10-14 18:17:10 PM', '2024-10-14'),
('K003', 4, 5, '10000', '9450', '0', 'partial', '2024-10-14 18:30:48 PM', '2024-10-14'),
('K004', 2, 5, '30000', '0', '0', 'pending', '2024-10-14 19:39:54 PM', '2024-10-14'),
('K005', 4, 4, '20000', '0', '0', 'pending', '2024-10-15 10:13:25 AM', '2024-10-15'),
('K006', 2, 7, '5000', '4350', '0', 'partial', '2024-10-15 20:27:45 PM', '2024-10-15'),
('K007', 2, 7, '5000', '0', '0', 'pending', '2024-10-16 05:07:00 AM', '2024-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `customer_withdraws`
--

CREATE TABLE `customer_withdraws` (
  `cw_id` bigint(30) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `cw_amount` varchar(200) NOT NULL,
  `cw_time` varchar(200) NOT NULL,
  `cw_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_withdraws`
--

INSERT INTO `customer_withdraws` (`cw_id`, `account_number`, `cw_amount`, `cw_time`, `cw_date`) VALUES
(2, 'K007', '0', '2024-10-16 05:07:00 AM', '2024-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `customer_withdraw_history`
--

CREATE TABLE `customer_withdraw_history` (
  `cwh_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `cwh_amount` varchar(200) NOT NULL,
  `cwh_status` varchar(200) NOT NULL,
  `cwh_reference` varchar(200) NOT NULL,
  `cwh_time` varchar(200) NOT NULL,
  `cwh_date` varchar(200) NOT NULL,
  `approved_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` bigint(20) NOT NULL,
  `expense_category` varchar(250) NOT NULL,
  `expense_title` varchar(250) NOT NULL,
  `expense_amount` varchar(200) NOT NULL,
  `expense_date` varchar(200) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_category`, `expense_title`, `expense_amount`, `expense_date`, `added_by`) VALUES
(1, 'Utilities', 'Food', '45000', '2024-07-31', 200002),
(2, 'Utilities', 'Food', '90000', '2024-07-31', 200002);

-- --------------------------------------------------------

--
-- Table structure for table `membership_fee`
--

CREATE TABLE `membership_fee` (
  `mfee_id` bigint(20) NOT NULL,
  `membership_amount` varchar(200) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `membership_time_paid` varchar(200) NOT NULL,
  `membership_date_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_fee`
--

INSERT INTO `membership_fee` (`mfee_id`, `membership_amount`, `account_number`, `membership_time_paid`, `membership_date_paid`) VALUES
(1, '0', '', '2024-10-14 11:34:39 AM', '2024-10-14'),
(2, '0', '', '2024-10-14 11:43:59 AM', '2024-10-14'),
(3, '0', '', '2024-10-14 11:51:04 AM', '2024-10-14'),
(4, '0', '', '2024-10-14 15:58:57 PM', '2024-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `membership_fee_history`
--

CREATE TABLE `membership_fee_history` (
  `mfh_id` bigint(20) NOT NULL,
  `mfee_id` int(11) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `mfh_amount` varchar(200) NOT NULL,
  `recieved_by` int(11) NOT NULL,
  `mfh_date_paid` varchar(200) NOT NULL,
  `mfh_time_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passbook`
--

CREATE TABLE `passbook` (
  `passbook_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `passbook_amount` varchar(200) NOT NULL,
  `passbook_date_paid` varchar(200) NOT NULL,
  `passbook_time_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passbook_history`
--

CREATE TABLE `passbook_history` (
  `pbh_id` bigint(20) NOT NULL,
  `passbook_id` int(11) NOT NULL,
  `pbh_amount` varchar(200) NOT NULL,
  `recieved_by` varchar(200) NOT NULL,
  `pbh_date_paid` varchar(200) NOT NULL,
  `pbh_time_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `saving_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `saving_last_datetime` varchar(200) NOT NULL,
  `saving_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saving_history`
--

CREATE TABLE `saving_history` (
  `saving_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `saving_amount` varchar(200) NOT NULL,
  `saving_date_time` varchar(200) NOT NULL,
  `saving_last_date` varchar(200) NOT NULL,
  `sh_received_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_capital`
--

CREATE TABLE `share_capital` (
  `share_capital_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `share_capital_amount` varchar(200) NOT NULL,
  `share_capital_last_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_capital_history`
--

CREATE TABLE `share_capital_history` (
  `sch_id` bigint(20) NOT NULL,
  `share_capital_id` int(11) NOT NULL,
  `sch_amount` varchar(200) NOT NULL,
  `recieved_by` int(11) NOT NULL,
  `sch_date_paid` varchar(200) NOT NULL,
  `sch_time_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stationary`
--

CREATE TABLE `stationary` (
  `stationary_id` bigint(20) NOT NULL,
  `account_number` varchar(200) NOT NULL,
  `stationary_amount` varchar(200) NOT NULL,
  `stationary_date_paid` varchar(200) NOT NULL,
  `stationary_time_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stationary_history`
--

CREATE TABLE `stationary_history` (
  `sh_id` bigint(20) NOT NULL,
  `stationary_id` int(11) NOT NULL,
  `sh_amount` varchar(200) NOT NULL,
  `recieved_by` int(11) NOT NULL,
  `sh_date_paid` varchar(200) NOT NULL,
  `sh_time_paid` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `theme_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `theme_code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`theme_id`, `userid`, `theme_code`) VALUES
(1, 1, 'light');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` bigint(20) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_type` varchar(200) NOT NULL,
  `id_number` varchar(200) NOT NULL,
  `id_front` varchar(200) NOT NULL,
  `id_back` varchar(200) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `physical_address` varchar(200) NOT NULL,
  `parish` varchar(250) NOT NULL,
  `sub_county` varchar(200) NOT NULL,
  `district` varchar(200) NOT NULL,
  `account_status` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `token` varchar(100) NOT NULL,
  `date_registered` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `gender`, `phone`, `email`, `password`, `id_type`, `id_number`, `id_front`, `id_back`, `pic`, `physical_address`, `parish`, `sub_county`, `district`, `account_status`, `role`, `token`, `date_registered`) VALUES
(1, 'Oguti', 'David', 'male', '0704487563', 'osp123ug@gmail.com', 'bd8da86331934bc695d34a103a42beb18d072dd6', 'Driving Permit', 'C496949584856666565t0946940569', '', '', '', 'Kawanda', 'Wakiso', 'Wakiso', 'Wakiso', 'active', 'admin', '', '2024-09-24'),
(4, 'Francis', 'Lub', 'male', '0708175244', '', '', 'National ID', 'C49694958485666656', 'http://localhost/kitudesacco/uploadx/8617385495977.jpg', 'http://localhost/kitudesacco/uploadx/4159109388343.jpg', 'http://localhost/kitudesacco/uploadx/670ce67687cb4.png', 'Masaka', 'Masaka', 'Masaka', 'Masaka', 'pending', 'customer', '', '2024-10-14'),
(5, 'Manager', 'Joseph', 'male', '0704336118', '', '', 'National ID', 'C4969495848', 'http://localhost/kitudesacco/uploadx/8440740673636.png', 'http://localhost/kitudesacco/uploadx/2747365295633.jpg', 'http://localhost/kitudesacco/uploadx/670ea4ce65197.png', 'Kiwangala', 'Kiwangala', 'Kiwangala', 'Kiwangala', 'pending', 'customer', '', '2024-10-14'),
(7, 'oguti', 'brian', 'male', '0772727716', 'osp123ug@gmail.com', '', 'Village ID', '3457grgr', 'http://localhost/kitudesacco/uploadx/8032095229673.png', 'http://localhost/kitudesacco/uploadx/2288008104098.png', 'http://localhost/kitudesacco/uploadx/670ea5e801aed.png', 'kampala uganda', 'Kiwangala', 'Masaka', 'Kampala', 'pending', 'customer', '', '2024-10-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_collection_history`
--
ALTER TABLE `account_collection_history`
  ADD PRIMARY KEY (`accch_id`),
  ADD KEY `abh_id` (`accch_id`,`account_number`,`accch_amount`,`accch_time_paid`),
  ADD KEY `abh_date_paid` (`accch_date_paid`),
  ADD KEY `account_number` (`account_number`,`accch_amount`,`accch_time_paid`),
  ADD KEY `accch_id` (`accch_id`,`accch_date_paid`);

--
-- Indexes for table `account_payment_history`
--
ALTER TABLE `account_payment_history`
  ADD PRIMARY KEY (`accph_id`),
  ADD KEY `accph_id` (`accph_id`,`account_number`,`accph_time`,`accph_date`,`recieved_by`),
  ADD KEY `accph_amount` (`accph_amount`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  ADD PRIMARY KEY (`account_number`),
  ADD KEY `fee_date` (`acc_opening_date`,`acc_opening_time`),
  ADD KEY `userid` (`userid`,`acc_id`,`opening_amount`),
  ADD KEY `account_number` (`account_number`,`acc_status`),
  ADD KEY `acc_id` (`acc_id`),
  ADD KEY `account_balance` (`account_balance`),
  ADD KEY `opening_amount_paid` (`opening_amount_paid`);

--
-- Indexes for table `customer_withdraws`
--
ALTER TABLE `customer_withdraws`
  ADD PRIMARY KEY (`cw_id`),
  ADD KEY `cw_id` (`cw_id`,`account_number`,`cw_amount`),
  ADD KEY `cw_time` (`cw_time`,`cw_date`);

--
-- Indexes for table `customer_withdraw_history`
--
ALTER TABLE `customer_withdraw_history`
  ADD PRIMARY KEY (`cwh_id`),
  ADD KEY `cwh_id` (`cwh_id`,`account_number`,`cwh_amount`),
  ADD KEY `cwh_status` (`cwh_status`,`cwh_reference`,`cwh_time`),
  ADD KEY `cwh_date` (`cwh_date`,`approved_by`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expense_id` (`expense_id`,`expense_category`,`expense_title`,`expense_amount`,`expense_date`),
  ADD KEY `expense_id_2` (`expense_id`,`expense_category`,`expense_title`,`expense_amount`,`expense_date`,`added_by`);

--
-- Indexes for table `membership_fee`
--
ALTER TABLE `membership_fee`
  ADD PRIMARY KEY (`mfee_id`),
  ADD KEY `mfee_id` (`mfee_id`,`membership_time_paid`),
  ADD KEY `membership_amount` (`membership_amount`,`account_number`),
  ADD KEY `date_paid` (`membership_date_paid`),
  ADD KEY `membership_time_paid` (`membership_time_paid`,`membership_date_paid`);

--
-- Indexes for table `membership_fee_history`
--
ALTER TABLE `membership_fee_history`
  ADD PRIMARY KEY (`mfh_id`),
  ADD KEY `mfh_id` (`mfh_id`,`mfee_id`,`account_number`),
  ADD KEY `mfh_amount` (`mfh_amount`,`recieved_by`,`mfh_date_paid`),
  ADD KEY `mfh_time_paid` (`mfh_time_paid`);

--
-- Indexes for table `passbook`
--
ALTER TABLE `passbook`
  ADD PRIMARY KEY (`passbook_id`),
  ADD KEY `passbook_id` (`passbook_id`,`passbook_date_paid`,`passbook_time_paid`),
  ADD KEY `account_number` (`account_number`,`passbook_amount`);

--
-- Indexes for table `passbook_history`
--
ALTER TABLE `passbook_history`
  ADD PRIMARY KEY (`pbh_id`),
  ADD KEY `pbh_id` (`pbh_id`,`passbook_id`,`pbh_date_paid`,`pbh_time_paid`),
  ADD KEY `pbh_amount` (`pbh_amount`,`recieved_by`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`saving_id`),
  ADD KEY `saving_id` (`saving_id`,`account_number`,`amount`),
  ADD KEY `saving_last_datetime` (`saving_last_datetime`,`saving_date`);

--
-- Indexes for table `saving_history`
--
ALTER TABLE `saving_history`
  ADD PRIMARY KEY (`saving_id`),
  ADD KEY `saving_id` (`saving_id`,`account_number`,`saving_amount`,`saving_last_date`),
  ADD KEY `saving_date_time` (`saving_date_time`),
  ADD KEY `sh_received_by` (`sh_received_by`);

--
-- Indexes for table `share_capital`
--
ALTER TABLE `share_capital`
  ADD PRIMARY KEY (`share_capital_id`),
  ADD KEY `share_capital_id` (`share_capital_id`,`account_number`,`share_capital_amount`,`share_capital_last_paid`);

--
-- Indexes for table `share_capital_history`
--
ALTER TABLE `share_capital_history`
  ADD PRIMARY KEY (`sch_id`),
  ADD KEY `sch_id` (`sch_id`,`share_capital_id`,`sch_date_paid`,`sch_time_paid`),
  ADD KEY `sch_amount` (`sch_amount`,`recieved_by`);

--
-- Indexes for table `stationary`
--
ALTER TABLE `stationary`
  ADD PRIMARY KEY (`stationary_id`),
  ADD KEY `stationary_id` (`stationary_id`,`account_number`,`stationary_time_paid`),
  ADD KEY `stationary_amount` (`stationary_amount`,`stationary_date_paid`);

--
-- Indexes for table `stationary_history`
--
ALTER TABLE `stationary_history`
  ADD PRIMARY KEY (`sh_id`),
  ADD KEY `sh_id` (`sh_id`,`sh_date_paid`,`sh_time_paid`),
  ADD KEY `stationary_id` (`stationary_id`,`sh_amount`,`recieved_by`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`theme_id`),
  ADD KEY `theme_id` (`theme_id`,`userid`,`theme_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `token` (`token`),
  ADD KEY `userid` (`userid`,`firstname`,`lastname`,`gender`),
  ADD KEY `id_type` (`id_type`,`id_number`,`id_front`),
  ADD KEY `physical_address` (`physical_address`,`account_status`),
  ADD KEY `role` (`role`,`date_registered`),
  ADD KEY `id_front` (`id_front`),
  ADD KEY `id_back` (`id_back`),
  ADD KEY `phone` (`phone`),
  ADD KEY `email` (`email`),
  ADD KEY `parish` (`parish`,`sub_county`,`district`),
  ADD KEY `password` (`password`),
  ADD KEY `pic` (`pic`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_collection_history`
--
ALTER TABLE `account_collection_history`
  MODIFY `accch_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_payment_history`
--
ALTER TABLE `account_payment_history`
  MODIFY `accph_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_withdraws`
--
ALTER TABLE `customer_withdraws`
  MODIFY `cw_id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_withdraw_history`
--
ALTER TABLE `customer_withdraw_history`
  MODIFY `cwh_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `membership_fee`
--
ALTER TABLE `membership_fee`
  MODIFY `mfee_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `membership_fee_history`
--
ALTER TABLE `membership_fee_history`
  MODIFY `mfh_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passbook`
--
ALTER TABLE `passbook`
  MODIFY `passbook_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passbook_history`
--
ALTER TABLE `passbook_history`
  MODIFY `pbh_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `saving_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saving_history`
--
ALTER TABLE `saving_history`
  MODIFY `saving_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_capital`
--
ALTER TABLE `share_capital`
  MODIFY `share_capital_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_capital_history`
--
ALTER TABLE `share_capital_history`
  MODIFY `sch_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stationary`
--
ALTER TABLE `stationary`
  MODIFY `stationary_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stationary_history`
--
ALTER TABLE `stationary_history`
  MODIFY `sh_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
