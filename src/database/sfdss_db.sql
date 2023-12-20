-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 01:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfdss_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_calendar`
--

CREATE TABLE `academic_calendar` (
  `event_id` int(150) NOT NULL,
  `event_name` text NOT NULL,
  `event_month` text NOT NULL,
  `event_start_date` date NOT NULL,
  `event_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_calendar`
--

INSERT INTO `academic_calendar` (`event_id`, `event_name`, `event_month`, `event_start_date`, `event_end_date`) VALUES
(33616422, 'Exam', 'January', '2023-01-01', '0000-00-00'),
(46985188, 'Kasal', 'January', '2023-01-01', '2023-01-13'),
(63854916, 'test event', 'April', '2023-04-01', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_posted_feed`
--

CREATE TABLE `admin_posted_feed` (
  `post_id` int(100) NOT NULL,
  `admin_id` int(100) NOT NULL,
  `post_description` text NOT NULL,
  `user_posted_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_exam_grade`
--

CREATE TABLE `student_exam_grade` (
  `id` int(100) NOT NULL,
  `student_number` bigint(100) NOT NULL,
  `student_name` text NOT NULL,
  `student_section` text NOT NULL,
  `student_year` text NOT NULL,
  `subject_quarter` text NOT NULL,
  `exam_score` int(100) NOT NULL,
  `pw` double NOT NULL,
  `ws` double NOT NULL,
  `initial_grade` double NOT NULL,
  `quarterly_grade` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_performance_tasks_grade`
--

CREATE TABLE `student_performance_tasks_grade` (
  `id` int(100) NOT NULL,
  `student_number` bigint(100) NOT NULL,
  `student_name` text NOT NULL,
  `student_section` text NOT NULL,
  `student_year` text NOT NULL,
  `subject_quarter` text NOT NULL,
  `p1` int(100) NOT NULL,
  `p2` int(100) NOT NULL,
  `p3` int(100) NOT NULL,
  `p4` int(100) NOT NULL,
  `p5` int(100) NOT NULL,
  `p6` int(100) NOT NULL,
  `p7` int(100) NOT NULL,
  `p8` int(100) NOT NULL,
  `p9` int(100) NOT NULL,
  `p10` int(100) NOT NULL,
  `total` int(100) NOT NULL,
  `pw` double NOT NULL,
  `ws` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_requested_credentials`
--

CREATE TABLE `student_requested_credentials` (
  `request_id` int(100) NOT NULL,
  `student_number` int(100) NOT NULL,
  `student_name` text NOT NULL,
  `student_email` text NOT NULL,
  `student_contact_number` text NOT NULL,
  `student_year_graduated` text NOT NULL,
  `student_requested` text NOT NULL,
  `student_purpose` text NOT NULL,
  `request_status` text NOT NULL,
  `requested_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_written_works_grade`
--

CREATE TABLE `student_written_works_grade` (
  `id` int(100) NOT NULL,
  `student_number` bigint(100) NOT NULL,
  `student_name` text NOT NULL,
  `student_section` text NOT NULL,
  `student_year` text NOT NULL,
  `subject_quarter` text NOT NULL,
  `w1` int(100) NOT NULL,
  `w2` int(100) NOT NULL,
  `w3` int(100) NOT NULL,
  `w4` int(100) NOT NULL,
  `w5` int(100) NOT NULL,
  `w6` int(100) NOT NULL,
  `w7` int(100) NOT NULL,
  `w8` int(100) NOT NULL,
  `w9` int(100) NOT NULL,
  `w10` int(100) NOT NULL,
  `total` int(100) NOT NULL,
  `pw` double NOT NULL,
  `ws` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE `users_accounts` (
  `user_id` bigint(250) NOT NULL,
  `user_name` text NOT NULL,
  `user_year_level` text NOT NULL,
  `user_section` text NOT NULL,
  `user_photo` text NOT NULL,
  `user_password` text NOT NULL,
  `user_status` text NOT NULL,
  `user_type` text NOT NULL,
  `account_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`user_id`, `user_name`, `user_year_level`, `user_section`, `user_photo`, `user_password`, `user_status`, `user_type`, `account_created`) VALUES
(1001, 'Levy Talay', '', '', 'default-image.png', 'dGVzdDEyMy4=', 'Offline', 'admin', '2023-08-27 12:56:37'),
(1002, 'Frederick Rudolf', '', '', 'default-image.png', 'dGVzdDEyMy4=', 'Offline', 'admin', '2023-08-27 12:56:37'),
(1003, 'Michelle Aquino', '', '', 'default-image.png', 'dGVzdDEyMy4=', 'Offline', 'registrar', '2023-08-27 12:56:37'),
(107901000046, 'Aaron Simmons', 'Grade 7', 'EARTH', 'default-image.png', 'T05TMDAwNDY=', 'Offline', 'student', '2023-11-12 23:34:13'),
(107901000047, 'Keith Edwards', 'Grade 7', 'EARTH', 'default-image.png', 'UkRTMDAwNDc=', 'Offline', 'student', '2023-11-12 23:34:13'),
(107901000048, 'Albert Bennett', 'Grade 7', 'EARTH', 'default-image.png', 'RVRUMDAwNDg=', 'Offline', 'student', '2023-11-12 23:34:13'),
(107901000049, 'Scott Murphy', 'Grade 7', 'EARTH', 'default-image.png', 'UEhZMDAwNDk=', 'Offline', 'student', '2023-11-12 23:34:13'),
(107901000050, 'Gary Parker', 'Grade 7', 'EARTH', 'default-image.png', 'S0VSMDAwNTA=', 'Offline', 'student', '2023-11-12 23:34:13'),
(107901000200, 'Leonardo DiCaprio', 'Grade 11', 'AABM', 'default-image.png', 'UklPMDAyMDA=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000201, 'Robert Downey', 'Grade 11', 'AABM', 'default-image.png', 'TkVZMDAyMDE=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000202, 'Chris Hemsworth', 'Grade 11', 'AABM', 'default-image.png', 'UlRIMDAyMDI=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000203, 'Brad Pitt', 'Grade 11', 'AABM', 'default-image.png', 'SVRUMDAyMDM=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000204, 'Tom Hanks', 'Grade 11', 'AABM', 'default-image.png', 'TktTMDAyMDQ=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000300, 'Scarlett Johansson', 'Grade 11', 'AABM', 'default-image.png', 'U09OMDAzMDA=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000301, 'Jennifer Lawrence', 'Grade 11', 'AABM', 'default-image.png', 'TkNFMDAzMDE=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000302, 'Angelina Jolie', 'Grade 11', 'AABM', 'default-image.png', 'TElFMDAzMDI=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000303, 'Meryl Streep', 'Grade 11', 'AABM', 'default-image.png', 'RUVQMDAzMDM=', 'Offline', 'student', '2023-11-12 22:42:05'),
(107901000304, 'Julia Roberts', 'Grade 11', 'AABM', 'default-image.png', 'UlRTMDAzMDQ=', 'Offline', 'student', '2023-11-12 22:42:05'),
(207901000056, 'Tammy Smith', 'Grade 7', 'EARTH', 'default-image.png', 'SVRIMDAwNTY=', 'Offline', 'student', '2023-11-12 23:34:13'),
(207901000057, 'Marjorie Hall', 'Grade 7', 'EARTH', 'default-image.png', 'QUxMMDAwNTc=', 'Offline', 'student', '2023-11-12 23:34:13'),
(207901000058, 'Nicole Adams', 'Grade 7', 'EARTH', 'default-image.png', 'QU1TMDAwNTg=', 'Offline', 'student', '2023-11-12 23:34:13'),
(207901000059, 'Agnes Lewis', 'Grade 7', 'EARTH', 'default-image.png', 'V0lTMDAwNTk=', 'Offline', 'student', '2023-11-12 23:34:13'),
(207901000060, 'Connie Martin', 'Grade 7', 'EARTH', 'default-image.png', 'VElOMDAwNjA=', 'Offline', 'student', '2023-11-12 23:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `notification_id` int(150) NOT NULL,
  `user_id` int(150) NOT NULL,
  `activity_type` text NOT NULL,
  `activity_id` int(150) NOT NULL,
  `student_id` int(150) NOT NULL,
  `registrar_remarks` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `is_read` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`notification_id`, `user_id`, `activity_type`, `activity_id`, `student_id`, `registrar_remarks`, `sent_at`, `is_read`) VALUES
(12383286, 2147483647, 'approved_request', 27029290, 123, 'You are now welcome to visit the school\'s registrar office. Kindly ensure to bring along a request letter with you.', '2023-11-08 14:15:50', 'false'),
(79191835, 123, 'request_credentials', 27029290, 2147483647, '', '2023-11-08 14:14:50', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_calendar`
--
ALTER TABLE `academic_calendar`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `admin_posted_feed`
--
ALTER TABLE `admin_posted_feed`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `student_exam_grade`
--
ALTER TABLE `student_exam_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_performance_tasks_grade`
--
ALTER TABLE `student_performance_tasks_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_requested_credentials`
--
ALTER TABLE `student_requested_credentials`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `student_written_works_grade`
--
ALTER TABLE `student_written_works_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_accounts`
--
ALTER TABLE `users_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_calendar`
--
ALTER TABLE `academic_calendar`
  MODIFY `event_id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98109896;

--
-- AUTO_INCREMENT for table `student_exam_grade`
--
ALTER TABLE `student_exam_grade`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- AUTO_INCREMENT for table `student_performance_tasks_grade`
--
ALTER TABLE `student_performance_tasks_grade`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT for table `student_requested_credentials`
--
ALTER TABLE `student_requested_credentials`
  MODIFY `request_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `student_written_works_grade`
--
ALTER TABLE `student_written_works_grade`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
