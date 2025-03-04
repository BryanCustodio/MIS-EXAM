-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 10:37 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examination`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(2, 'traineehr', '$2y$10$TCCaZ5X64HvuwWI571fGKObIb/3EAK6GkFSo5lh2ydVB7Fcj00GJe');

-- --------------------------------------------------------

--
-- Table structure for table `enumeration_questions`
--

CREATE TABLE `enumeration_questions` (
  `id` int(11) NOT NULL,
  `enumeration_text` text NOT NULL,
  `answers` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enumeration_questions`
--

INSERT INTO `enumeration_questions` (`id`, `enumeration_text`, `answers`, `created_at`, `exam_id`) VALUES
(4, 'repairs', '172.17.9.254', '2025-02-19 00:09:42', 0),
(31, 'mis-event', '172.17.9.152', '2025-02-19 00:21:43', 0),
(33, 'not working', 'dynamic pagination', '2025-02-21 09:34:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_questions` int(11) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in minutes',
  `passing_score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examss`
--

CREATE TABLE `examss` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examss`
--

INSERT INTO `examss` (`id`, `exam_name`, `created_at`) VALUES
(3, 'try', '2025-02-28 08:45:36'),
(4, 'Examination 1', '2025-02-28 09:41:39'),
(5, 'tryiiiii', '2025-03-03 00:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_type` enum('multiple_choice','identification','enumeration') NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_type`, `question_id`) VALUES
(1, 3, 'multiple_choice', 214),
(2, 3, 'multiple_choice', 217),
(3, 3, 'multiple_choice', 221),
(4, 3, 'identification', 42),
(5, 3, 'identification', 43),
(6, 3, 'identification', 44),
(7, 3, 'enumeration', 30),
(8, 3, 'enumeration', 32),
(9, 3, 'enumeration', 28),
(10, 4, 'multiple_choice', 218),
(11, 4, 'multiple_choice', 214),
(12, 4, 'multiple_choice', 216),
(13, 4, 'multiple_choice', 178),
(14, 4, 'multiple_choice', 220),
(15, 4, 'identification', 43),
(16, 4, 'identification', 39),
(17, 4, 'identification', 44),
(18, 4, 'identification', 40),
(19, 4, 'identification', 32),
(20, 4, 'enumeration', 28),
(21, 4, 'enumeration', 5),
(22, 4, 'enumeration', 24),
(23, 4, 'enumeration', 30),
(24, 4, 'enumeration', 31),
(25, 5, 'multiple_choice', 218),
(26, 5, 'multiple_choice', 216),
(27, 5, 'multiple_choice', 221),
(28, 5, 'multiple_choice', 178),
(29, 5, 'multiple_choice', 222),
(30, 5, 'identification', 43),
(31, 5, 'identification', 44),
(32, 5, 'identification', 39),
(33, 5, 'identification', 38),
(34, 5, 'identification', 41),
(35, 5, 'enumeration', 4),
(36, 5, 'enumeration', 31),
(37, 5, 'enumeration', 30),
(38, 5, 'enumeration', 24),
(39, 5, 'enumeration', 28);

-- --------------------------------------------------------

--
-- Table structure for table `exam_requests`
--

CREATE TABLE `exam_requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `status` enum('Pending','Approved','Disapproved') DEFAULT 'Pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identification_questions`
--

CREATE TABLE `identification_questions` (
  `id` int(11) NOT NULL,
  `identification_text` text NOT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `identification_questions`
--

INSERT INTO `identification_questions` (`id`, `identification_text`, `answer`, `created_at`, `exam_id`) VALUES
(44, 'not working', 'dynamic pagination', '2025-02-21 09:33:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('multiple_choice','identification','enumeration') NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `question_type`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `answer`, `created_at`) VALUES
(1, 'What is the capital of France?', 'multiple_choice', 'Berlin', 'Madrid', 'Paris', 'Rome', 'C', NULL, '2025-03-03 02:08:40'),
(2, 'Who wrote Romeo and Juliet?', 'identification', NULL, NULL, NULL, NULL, NULL, 'William Shakespeare', '2025-03-03 02:08:40'),
(3, 'List three primary colors.', 'enumeration', NULL, NULL, NULL, NULL, NULL, 'Red,Blue,Yellow', '2025-03-03 02:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `questionss`
--

CREATE TABLE `questionss` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionss`
--

INSERT INTO `questionss` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `exam_id`) VALUES
(223, 'try', 'try', 'try', 'try', 'D', 'D', 0);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `username`, `password`, `created_at`) VALUES
(6, 'QWE', 'ASD', 'ZXC', 'Male', 'QWE', '$2y$10$0L0MdVLUds48IHCmAd4kBOIuUf6mz7O67wzbX8ZMD.GdYjvtMq4VS', '2025-02-26 00:10:04'),
(7, 'bryan', 'guevarra', 'custodio', 'Male', 'bryshiee', '$2y$10$Wgg1KQJNEYWpipDGA7.3Buu9WL.CgwVZu8As6nolSatWg4XZViCzC', '2025-02-28 09:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `student_exams`
--

CREATE TABLE `student_exams` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam`
--

CREATE TABLE `tbl_exam` (
  `id` int(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `total_questions` int(255) NOT NULL,
  `duration` text NOT NULL,
  `passing_score` int(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enumeration_questions`
--
ALTER TABLE `enumeration_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examss`
--
ALTER TABLE `examss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_requests`
--
ALTER TABLE `exam_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identification_questions`
--
ALTER TABLE `identification_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionss`
--
ALTER TABLE `questionss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `student_exams`
--
ALTER TABLE `student_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
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
-- AUTO_INCREMENT for table `enumeration_questions`
--
ALTER TABLE `enumeration_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examss`
--
ALTER TABLE `examss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `exam_requests`
--
ALTER TABLE `exam_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `identification_questions`
--
ALTER TABLE `identification_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `questionss`
--
ALTER TABLE `questionss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_exams`
--
ALTER TABLE `student_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `examss` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `student_exams`
--
ALTER TABLE `student_exams`
  ADD CONSTRAINT `student_exams_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_exams_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `examss` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
