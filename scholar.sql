-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 07:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scholar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$ckRHP0Jv5DSMuWbd8oWT8OsJl8C6YzEInR4eSQBJ4zk6xshBWn7sC'),
(2, 'officer', '$2y$10$tYpqqmF/ebuuebQuuA0ap.yQxGEz6EXyresmlMdiRFifoeOwjBv.O');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `recipient_email` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `student_id`, `recipient_email`, `subject`, `message`, `created_at`, `is_read`) VALUES
(1, 17, 'kaylexd6@gmail.com', NULL, 'hi', '2024-11-14 05:07:34', 0),
(2, 17, 'kaylexd6@gmail.com', NULL, 'aysig scatter dong', '2024-11-14 05:28:15', 0),
(3, 17, 'kaylexd6@gmail.com', NULL, '', '2024-11-14 05:31:18', 0),
(4, 17, 'kaylexd6@gmail.com', 'scatter', 'aysig scatter dong', '2024-11-14 05:33:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `f_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `sffname` varchar(50) NOT NULL,
  `sfaddress` varchar(50) NOT NULL,
  `sfcontact` varchar(20) NOT NULL,
  `sfoccu` varchar(30) NOT NULL,
  `sfcompany` varchar(50) NOT NULL,
  `smfname` varchar(50) NOT NULL,
  `smaddress` varchar(50) NOT NULL,
  `smcontact` varchar(20) NOT NULL,
  `smoccu` varchar(30) NOT NULL,
  `smcompany` varchar(50) NOT NULL,
  `sgfname` varchar(50) NOT NULL,
  `sgaddress` varchar(50) NOT NULL,
  `sgcontact` varchar(20) NOT NULL,
  `sgoccu` varchar(30) NOT NULL,
  `sgcompany` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`f_id`, `student_id`, `sffname`, `sfaddress`, `sfcontact`, `sfoccu`, `sfcompany`, `smfname`, `smaddress`, `smcontact`, `smoccu`, `smcompany`, `sgfname`, `sgaddress`, `sgcontact`, `sgoccu`, `sgcompany`) VALUES
(9, 44, 'q', 'q', 'q', 'q', 'q', 'w', 'w', 'e', 'e', 'e', 's', 'q', 'q', 'a', 'q'),
(10, 43, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'aaaaa', 'a', 'a', 'a', 'a'),
(11, 45, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
(12, 46, 'ssssssssssssss', 'assssssssssssssssssssss', 's', 'SDA', 's', 's', 'as', 's', 'SDA', 'ss', 'assssssssss', 'as', 's', 's', 's'),
(13, 17, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
(14, 50, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
(15, 51, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a');

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
  `sgender` varchar(10) NOT NULL,
  `sdbirth` varchar(10) NOT NULL,
  `s_pass` varchar(60) NOT NULL,
  `sfix` varchar(10) NOT NULL,
  `saddress` varchar(50) NOT NULL,
  `scontact` varchar(15) NOT NULL,
  `sctship` varchar(50) NOT NULL,
  `scourse` varchar(50) NOT NULL,
  `syear` varchar(50) NOT NULL,
  `semail` varchar(50) DEFAULT NULL,
  `simg` varchar(60) NOT NULL,
  `spcyincome` varchar(50) DEFAULT NULL,
  `sschool` varchar(20) DEFAULT NULL,
  `saward` varchar(20) DEFAULT NULL,
  `sreceive` date DEFAULT NULL,
  `s_account_status` varchar(20) DEFAULT NULL,
  `account_status` varchar(20) DEFAULT NULL,
  `s_scholarship_type` varchar(20) NOT NULL,
  `s_scholar_status` varchar(20) DEFAULT NULL,
  `snote` text DEFAULT NULL,
  `is_scholar` tinyint(1) DEFAULT 0,
  `added_on` date DEFAULT NULL,
  `applied_on` date DEFAULT NULL,
  `cert_file_path` varchar(255) DEFAULT NULL,
  `moral_file_path` varchar(255) DEFAULT NULL,
  `grades_file_path` varchar(255) DEFAULT NULL,
  `grad_file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `sid`, `sfname`, `smname`, `slname`, `sgender`, `sdbirth`, `s_pass`, `sfix`, `saddress`, `scontact`, `sctship`, `scourse`, `syear`, `semail`, `simg`, `spcyincome`, `sschool`, `saward`, `sreceive`, `s_account_status`, `account_status`, `s_scholarship_type`, `s_scholar_status`, `snote`, `is_scholar`, `added_on`, `applied_on`, `cert_file_path`, `moral_file_path`, `grades_file_path`, `grad_file_path`) VALUES
(17, 'SCC-000123', 'Kayleee', 'Louise', 'Lumapay', 'Male', '2024-11-05', '$2y$10$eUKMTjas54VD4XmATRMxeeJlxB2LcG0.yji7L.KuKUbyh/jJKXFf6', 'N/A', 's', '123123', 's', 'BSIT', '4th', 'kaylexd6@gmail.com', 'img/6717d58438061.png', 'a', 'a', 'a', '2024-11-07', 'Pending', 'Active', 'Academic', 'Approved', 'a', 1, '0000-00-00', '2024-11-12', NULL, NULL, NULL, NULL),
(43, 'SCC-22222', 'John', 'C', 'Doe', 'Male', '2024-11-05', '$2y$10$F0E1I5MVIL1GGxcG0wU96uhsv8nQ3ANa.E6niGMiF5hY20CgNJIHO', 'Jr.', 'asd', '123123', 'sad', 'BSIT', '3rd', 'doe@gmail.com', 'img/672b1914503e7.jpg', 'a', 'a', 'a', '2024-11-06', 'Valid', 'Active', 'Academic', 'Approved', 'asd', 0, '2024-11-07', '2024-11-06', NULL, NULL, NULL, NULL),
(44, 'SCC-0001244', 'Ze', 'A', 'Ze', 'Male', '2024-11-05', '$2y$10$yuykIqIPxOk29W//BPU6uewz9mfTbTKGB1J..U3EMcAdwydVwTzb.', 'N/A', '123123', '123123123123', 'Ze', 'BSIT', '1st', 'ze@gmail.com', 'img/672b5fbfc19b5.jpg', NULL, NULL, NULL, NULL, 'Valid', 'Inactive', 'Academic', NULL, NULL, 0, NULL, '2024-11-06', NULL, NULL, NULL, NULL),
(45, 'SCC-12312322', 'test', 'a', 'test', 'Male', '2024-11-05', '$2y$10$zR/475c/PC7cKDYc5kpUauHUqJ6cJmdf3kL5KPU1uMrPfQjEeuluO', 'N/A', 'a', 'a', 'a', 'a', 'a', 'test1@gmail.com', 'img/672b7f7ef1e21.png', '123213', 'asd', 'asd', '2024-11-06', 'Pending', 'Active', 'Academic', 'Approved', 'asd', 0, NULL, '2024-11-06', NULL, NULL, NULL, NULL),
(46, 'SCC-22222', 'ASD', 'Wyoming Hill', 'Ora Carr', 'Male', '2024-11-23', '$2y$10$j6YdhhsdtJT5iby69Q1nLekqws6XByZbxjZ8Epl97ePCtlbRW.Hwy', 'Jr.', 'Impedit amet ut do', 'Qui mollit nost', 'Amet cupiditate non', 'BSIT', '1st Year', 'test2@gmail.com', 'img/672b8ac49430e.jpg', '876', 'Enim exercitationem ', 'Quis anim dicta ipsa', '2014-11-13', 'Valid', 'Active', 'Academic', 'Approved', 'Sed elit do maxime ', 1, NULL, '2024-11-06', NULL, NULL, NULL, NULL),
(50, 'SCC-00-1233333', 'ww', 'ss', 'qq', 'Male', '2024-11-07', '$2y$10$NZn53aerFPt1s2oZV/l3pOlTbAtdNONyHo0jysE/oEGlF5UNtwtfC', 'N/A', 's', 's', 's', 'BSIT', '1st', 'test3@gmail.com', 'img/672dc82574822.jpg', 'a', '', '', '0000-00-00', 'Pending', 'Active', 'Academic', NULL, NULL, 0, NULL, '2024-11-08', NULL, NULL, NULL, NULL),
(51, 'SCC-00-12333321', 'Dran', 'sd', 'Tray', 'Male', '2024-11-12', '$2y$10$bpv1kJtkqukZ.EZfE0ssP.G7T.iWza8k9..AO5wDzloDrWzDxeGTW', 'N/A', 'asd', 'asd', 'asd', 'asd', 'asd', 'dran@gmail.com', 'img/67330c2096ede.jpg', NULL, NULL, NULL, NULL, 'Pending', 'Active', 'Academic', NULL, NULL, 0, NULL, '2024-11-12', '../img/1731420168_51_440148981_478113197877338_7045799006530597717_n.jpg', '../img/1731420168_51_448696363_3353262531484097_2242455653825519373_n.jpg', '../img/1731420169_51_bakuna.png', '../img/1731420169_51_yala.JPG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id` (`student_id`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `fk_student` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `family`
--
ALTER TABLE `family`
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
