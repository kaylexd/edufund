-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 05:28 AM
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
-- Database: `scholarship`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `username`, `password`, `email`) VALUES
(1, 'officer', '$2y$10$Sep//dL0sY9CQR/gTcwByeaHWCJdMDKA2semN5rCTT4uddFRWuy6y', ''),
(2, 'admin', '$2y$10$Um1weIui5/uGsEc7eNve1OPd5yIHCQUuQUa.HYhVc.lKnou/g12Iq', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin_status`
--

CREATE TABLE `admin_status` (
  `id` int(11) NOT NULL,
  `is_scholar` tinyint(1) DEFAULT 0,
  `s_scholar_status` varchar(20) DEFAULT 'Pending',
  `added_on` date DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_status`
--

INSERT INTO `admin_status` (`id`, `is_scholar`, `s_scholar_status`, `added_on`, `student_id`) VALUES
(1, 1, 'Approved', NULL, 55),
(6, 1, 'Approved', NULL, 58),
(7, 0, 'Pending', NULL, 59),
(10, 1, 'Rejected', NULL, 75);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `student_id`, `subject`, `message`, `created_at`, `is_read`, `admin_id`) VALUES
(1, 55, 'asd', 'asd', '2024-12-13 03:22:38', 1, NULL),
(2, 55, 'asd', 'asd', '2024-12-13 03:23:56', 1, NULL),
(3, 55, 'asd', 'asd', '2024-12-13 03:24:34', 1, NULL),
(4, 55, 'asd', 'asdasdd', '2024-12-13 03:27:10', 1, NULL),
(5, 55, 'asd', 'asdsd', '2024-12-13 03:27:28', 1, NULL),
(6, 55, 'aaaa', 'aaaaaaaaaaaaaaaaa', '2024-12-13 03:29:02', 1, NULL),
(7, 55, '123', '123', '2024-12-13 04:11:56', 1, NULL),
(8, 59, 'asd', 'asd', '2024-12-13 10:38:22', 1, NULL),
(9, 59, 'aa', 'aaaaa', '2024-12-13 10:43:02', 1, NULL),
(10, 55, 'test', 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT', '2025-01-12 08:01:42', 1, NULL),
(11, 58, '', 'ATTENTION STUDENTS NO SCHOLARSHIP AVAILABLE ATM', '2025-01-12 08:06:37', 0, NULL),
(12, 59, '', 'AAAAAAAAAA', '2025-01-12 08:27:45', 0, NULL),
(13, 55, '', 'AAAAAAAAAA', '2025-01-12 08:27:45', 1, NULL),
(14, 75, '', 'AAAAAAAAAA', '2025-01-12 08:27:45', 0, NULL),
(15, 80, '', 'AAAAAAAAAA', '2025-01-12 08:27:45', 1, NULL),
(16, 58, '', 'AAAAAAAAAA', '2025-01-12 08:27:45', 0, NULL),
(19, 59, NULL, 'ANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT', '2025-01-12 08:28:53', 0, NULL),
(20, 55, NULL, 'ANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT', '2025-01-12 08:28:53', 1, NULL),
(21, 75, NULL, 'ANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT', '2025-01-12 08:28:53', 0, NULL),
(22, 80, NULL, 'ANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT', '2025-01-12 08:28:53', 1, NULL),
(23, 58, NULL, 'ANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT\nANNOUNCEMENT', '2025-01-12 08:28:53', 0, NULL),
(26, 59, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\n', '2025-01-12 09:05:46', 0, NULL),
(27, 55, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\n', '2025-01-12 09:05:46', 1, NULL),
(28, 75, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\n', '2025-01-12 09:05:46', 0, NULL),
(29, 80, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\n', '2025-01-12 09:05:46', 1, NULL),
(30, 58, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\n', '2025-01-12 09:05:46', 0, NULL),
(33, 59, NULL, 'asddddddd', '2025-01-12 09:39:30', 0, NULL),
(34, 55, NULL, 'asddddddd', '2025-01-12 09:39:30', 1, NULL),
(35, 75, NULL, 'asddddddd', '2025-01-12 09:39:30', 0, NULL),
(36, 80, NULL, 'asddddddd', '2025-01-12 09:39:30', 1, NULL),
(37, 58, NULL, 'asddddddd', '2025-01-12 09:39:30', 0, NULL),
(40, 59, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT', '2025-01-12 09:41:52', 0, NULL),
(41, 55, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT', '2025-01-12 09:41:52', 1, NULL),
(42, 75, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT', '2025-01-12 09:41:52', 0, NULL),
(43, 80, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT', '2025-01-12 09:41:52', 1, NULL),
(44, 58, NULL, 'ANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT\nANNOUNCEMENT ANNOUNCEMENT ANNOUNCEMENT', '2025-01-12 09:41:52', 0, NULL),
(47, 59, NULL, 'ACADEMIC APPLICATION IS NOW OPEN!', '2025-01-12 10:07:43', 0, NULL),
(48, 55, NULL, 'ACADEMIC APPLICATION IS NOW OPEN!', '2025-01-12 10:07:43', 0, NULL),
(49, 75, NULL, 'ACADEMIC APPLICATION IS NOW OPEN!', '2025-01-12 10:07:43', 0, NULL),
(50, 80, NULL, 'ACADEMIC APPLICATION IS NOW OPEN!', '2025-01-12 10:07:43', 0, NULL),
(51, 58, NULL, 'ACADEMIC APPLICATION IS NOW OPEN!', '2025-01-12 10:07:43', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `scholarship_application_id` int(11) NOT NULL,
  `sschool` varchar(50) DEFAULT NULL,
  `saward` varchar(50) DEFAULT NULL,
  `sreceive` date DEFAULT NULL,
  `cert_file_path` varchar(255) DEFAULT NULL,
  `moral_file_path_acad` varchar(255) DEFAULT NULL,
  `grades_file_path` varchar(255) DEFAULT NULL,
  `grad_file_path` varchar(255) DEFAULT NULL,
  `coe_file` varchar(255) DEFAULT NULL,
  `psa_file` varchar(255) DEFAULT NULL,
  `moral_file_path_admin` varchar(255) DEFAULT NULL,
  `form_file` varchar(255) DEFAULT NULL,
  `medc_file` varchar(255) DEFAULT NULL,
  `moral_file_path_cultural` varchar(255) DEFAULT NULL,
  `s_nas` text DEFAULT NULL,
  `s_basic` text DEFAULT NULL,
  `s_skills` text DEFAULT NULL,
  `s_work` text DEFAULT NULL,
  `grades_file_non_acad` varchar(255) DEFAULT NULL,
  `moral_file_path_non_acad` varchar(255) DEFAULT NULL,
  `indigency_file` varchar(255) DEFAULT NULL,
  `medical_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `scholarship_application_id`, `sschool`, `saward`, `sreceive`, `cert_file_path`, `moral_file_path_acad`, `grades_file_path`, `grad_file_path`, `coe_file`, `psa_file`, `moral_file_path_admin`, `form_file`, `medc_file`, `moral_file_path_cultural`, `s_nas`, `s_basic`, `s_skills`, `s_work`, `grades_file_non_acad`, `moral_file_path_non_acad`, `indigency_file`, `medical_file`) VALUES
(3, 6, 'N/A', 'N/A', '2024-12-11', '../img/1734050776_55_yala.JPG', '../img/1734050776_55_yala.JPG', '../img/1734050776_55_yala.JPG', '../img/1734050776_55_yala.JPG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 25, NULL, NULL, NULL, '../img/1734067079_58_yala.JPG', NULL, NULL, '../img/1734067079_58_yala.JPG', NULL, NULL, NULL, NULL, NULL, NULL, 'scholarship', 'excel', 'n/a', 'any', '../img/1734067079_58_440148981_478113197877338_7045799006530597717_n.jpg', '../img/1734067079_58_448725380_834358308601776_7293715849427963828_n.png', NULL, NULL),
(9, 26, 'N/A', 'N/A', '2024-12-13', '../img/1734076734_59_yala.JPG', '../img/1734076734_59_yala.JPG', '../img/1734076734_59_yala.JPG', '../img/1734076734_59_yala.JPG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 30, 'a', 'a', '2024-12-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `officer`
--

CREATE TABLE `officer` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `snote` text DEFAULT NULL,
  `s_account_status` varchar(20) DEFAULT 'Pending',
  `account_status` varchar(20) DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officer`
--

INSERT INTO `officer` (`id`, `student_id`, `snote`, `s_account_status`, `account_status`) VALUES
(7, 55, NULL, 'Pending', 'Active'),
(10, 58, NULL, 'Pending', 'Active'),
(11, 59, NULL, 'Pending', 'Active'),
(13, 80, NULL, 'Pending', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_applications`
--

CREATE TABLE `scholarship_applications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `officer_id` int(11) DEFAULT NULL,
  `s_scholarship_type` varchar(20) NOT NULL,
  `s_account_status` varchar(20) DEFAULT 'Pending',
  `snote` text DEFAULT NULL,
  `applied_on` date NOT NULL,
  `updated_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_applications`
--

INSERT INTO `scholarship_applications` (`id`, `student_id`, `officer_id`, `s_scholarship_type`, `s_account_status`, `snote`, `applied_on`, `updated_on`) VALUES
(6, 55, NULL, 'Academic', 'Valid', 'asdss', '2024-12-13', NULL),
(25, 58, NULL, 'Non-Academic', 'Valid', NULL, '2024-12-13', NULL),
(26, 59, NULL, 'Academic', 'Valid', NULL, '2024-12-13', NULL),
(30, 75, NULL, 'Academic', 'Pending', NULL, '2024-12-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_status`
--

CREATE TABLE `scholarship_status` (
  `id` int(11) NOT NULL,
  `scholarship_name` varchar(255) DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_status`
--

INSERT INTO `scholarship_status` (`id`, `scholarship_name`, `status`, `type`) VALUES
(1, 'Academic', 'open', 'Academic'),
(2, 'Non-Academic', 'open', 'Non-Academic'),
(3, 'Admin Scholar', 'open', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `sid` varchar(30) NOT NULL,
  `sfname` varchar(50) NOT NULL,
  `smname` varchar(50) NOT NULL,
  `slname` varchar(50) NOT NULL,
  `sfix` varchar(10) NOT NULL,
  `sgender` varchar(10) NOT NULL,
  `sdbirth` date NOT NULL,
  `semail` varchar(50) NOT NULL,
  `spass` varchar(255) NOT NULL,
  `saddress` varchar(255) NOT NULL,
  `scontact` varchar(20) NOT NULL,
  `sctship` varchar(50) NOT NULL,
  `scourse` varchar(20) NOT NULL,
  `syear` varchar(20) NOT NULL,
  `simg` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `sid`, `sfname`, `smname`, `slname`, `sfix`, `sgender`, `sdbirth`, `semail`, `spass`, `saddress`, `scontact`, `sctship`, `scourse`, `syear`, `simg`, `is_verified`, `verification_token`) VALUES
(55, 'SCC-00-012330', 'John', 'Dela', 'Cruz', 'N/A', 'Male', '1999-03-01', 'john@gmail.com', '$2y$10$tl2uluZs988elKtDUC9PGO8GdYVb7FdNNQ2lqsuP7o9Pbz.2O9fBe', 'Naga', '0956-056-1438', 'Filipino', 'BSCRIM', '4th Year', 'img/6757d14775396.jpg', 1, 'b159de17255d0cff044d1b3ac9f7b4487eefa64d5c47c745b1d9c8c0d42f3bfa'),
(58, 'SCC-00-012663', 'Alexandria', 'Roble', 'Ky', 'N/A', 'Male', '2001-04-06', 'alexandria@gmail.com', '$2y$10$bVCmXXWmypO5FSaHUrw.aeumSdTF8uPb0rDmZ5PDxDj9tXou93TAi', 'Tungkil, Minglanilla Cebu', '09420619976', 'Filipino', 'BSIT', '4th Year', 'img/675bbb8147e9e.jpg', 1, NULL),
(59, 'SCC-00-0121132', 'Johnn', 'D', 'Doe', 'Jr.', 'Male', '2002-05-04', 'doe@gmail.com', '$2y$10$PT4pY6qiHaGM1tX4Lh6pIu6PPdz7JkXRKbgDC4gu4T6E/v.tIw77K', 'Minglla, Cebu', '09560561438', 'Filipino', 'BSED', '2nd Year', 'img/675be87c44f23.jpg', 1, 'ee4273a50514b70d72ad88c760afdfcf4a8587f497cbf803a7cd9839e00ad830'),
(75, 'SCC-00-012413', 'Jeff', 'A', 'Casa', 'N/A', 'Male', '2024-12-12', 'ze@gmail.com', '', 'asd', '09982375819', 'Filipino', 'BSIT', '1st Year', '', 1, NULL),
(80, 'SCC-00-01261534', 'Elmar', '', 'Glenna', '', '', '0000-00-00', 'elmar@gmail.com', '$2y$10$ykE9vQXGFd2pjSCTxZkBDe9URoRU/q4gkEVhnYxYzOxdbAsuuEBXK', '', '', '', '', '', 'img/678354b05888b.jpg', 1, '054e693fcd35caa22463d6f76734c685b9b96021eae17165adfee697019c235a');

-- --------------------------------------------------------

--
-- Table structure for table `s_family`
--

CREATE TABLE `s_family` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `sffname` varchar(50) DEFAULT NULL,
  `sfaddress` varchar(255) DEFAULT NULL,
  `sfcontact` varchar(20) DEFAULT NULL,
  `sfoccu` varchar(50) DEFAULT NULL,
  `sfcompany` varchar(255) DEFAULT NULL,
  `smfname` varchar(50) DEFAULT NULL,
  `smaddress` varchar(255) DEFAULT NULL,
  `smcontact` varchar(20) DEFAULT NULL,
  `smoccu` varchar(50) DEFAULT NULL,
  `smcompany` varchar(255) DEFAULT NULL,
  `sgfname` varchar(50) DEFAULT NULL,
  `sgaddress` varchar(255) DEFAULT NULL,
  `sgcontact` varchar(20) DEFAULT NULL,
  `sgoccu` varchar(50) DEFAULT NULL,
  `sgcompany` varchar(255) DEFAULT NULL,
  `spcyincome` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `s_family`
--

INSERT INTO `s_family` (`id`, `student_id`, `sffname`, `sfaddress`, `sfcontact`, `sfoccu`, `sfcompany`, `smfname`, `smaddress`, `smcontact`, `smoccu`, `smcompany`, `sgfname`, `sgaddress`, `sgcontact`, `sgoccu`, `sgcompany`, `spcyincome`) VALUES
(10, 55, 'Patrick Cruz', 'Naga', '0956-056-1438', 'Police', 'PNP', 'Hazel Cruz', 'Naga', '0956-056-1438', 'house wife', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 90000),
(15, 58, 'Juan Lumapay', 'N/A', 'N/A', 'Waiter', 'City Sports Club Cebu', 'Jovy Lumapay', 'Tungkil, Minglanilla Cebu', '09420619976', 'Officer Clerk', 'Roble Shipping', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 100000),
(16, 59, 'John Doe', 'Minglanilla, Cebu', '09560561438', 'Police', 'PNP', 'Hope Doe', 'Minglanilla, Cebu', '09560561438', 'House wife', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 100000),
(31, 75, 'a', 'a', '123', 'a', 'a', 'a', 'a', '123', 'a', 'a', 'a', 'a', '123', 'a', 'a', 123);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_status`
--
ALTER TABLE `admin_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_admin` (`student_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholarship_application_id` (`scholarship_application_id`);

--
-- Indexes for table `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_officer_student` (`student_id`);

--
-- Indexes for table `scholarship_applications`
--
ALTER TABLE `scholarship_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student` (`student_id`),
  ADD KEY `officer_id` (`officer_id`);

--
-- Indexes for table `scholarship_status`
--
ALTER TABLE `scholarship_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sid` (`sid`),
  ADD UNIQUE KEY `semail` (`semail`);

--
-- Indexes for table `s_family`
--
ALTER TABLE `s_family`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_status`
--
ALTER TABLE `admin_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `officer`
--
ALTER TABLE `officer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `scholarship_applications`
--
ALTER TABLE `scholarship_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `scholarship_status`
--
ALTER TABLE `scholarship_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `s_family`
--
ALTER TABLE `s_family`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_status`
--
ALTER TABLE `admin_status`
  ADD CONSTRAINT `fk_student_admin` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_status` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`scholarship_application_id`) REFERENCES `scholarship_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `officer`
--
ALTER TABLE `officer`
  ADD CONSTRAINT `fk_officer_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scholarship_applications`
--
ALTER TABLE `scholarship_applications`
  ADD CONSTRAINT `scholarship_applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scholarship_applications_ibfk_2` FOREIGN KEY (`officer_id`) REFERENCES `officer` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `s_family`
--
ALTER TABLE `s_family`
  ADD CONSTRAINT `s_family_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
