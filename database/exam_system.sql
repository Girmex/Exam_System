-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 07:04 AM
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
-- Database: `exam_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam_list`
--

CREATE TABLE `exam_list` (
  `id` int(30) NOT NULL,
  `title` varchar(200) NOT NULL,
  `qpoints` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_list`
--

INSERT INTO `exam_list` (`id`, `title`, `qpoints`, `user_id`, `date_updated`) VALUES
(5, 'Amharic', 1, 19, '2024-04-20 14:37:36'),
(6, 'English', 1, 0, '2024-04-20 15:09:56');

-- --------------------------------------------------------

--
-- Table structure for table `exam_student_list`
--

CREATE TABLE `exam_student_list` (
  `id` int(30) NOT NULL,
  `exam_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_student_list`
--

INSERT INTO `exam_student_list` (`id`, `exam_id`, `user_id`, `date_updated`) VALUES
(5, 2, 12, '2020-09-07 15:05:58'),
(6, 2, 13, '2020-09-07 15:05:58'),
(10, 2, 17, '2024-04-19 12:50:14'),
(11, 6, 17, '2024-04-20 15:11:19'),
(12, 6, 18, '2024-04-20 15:11:20'),
(13, 5, 17, '2024-04-21 22:06:09');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(30) NOT NULL,
  `exam_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `score` int(5) NOT NULL,
  `total_score` int(5) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `exam_id`, `user_id`, `status`, `score`, `total_score`, `date_updated`) VALUES
(3, 2, 12, 'pending', 4, 4, '2020-09-07 16:59:14'),
(4, 5, 16, 'taken', 3, 3, '2024-04-19 12:34:15'),
(5, 5, 17, 'taken', 3, 3, '2024-04-19 12:39:19'),
(6, 5, 18, 'taken', 0, 3, '2024-04-19 12:41:21'),
(7, 2, 17, 'taken', 1, 1, '2024-04-19 12:52:01'),
(8, 6, 17, 'taken', 1, 1, '2024-04-20 15:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(30) NOT NULL,
  `question` text NOT NULL,
  `eid` int(30) NOT NULL,
  `image_url` varchar(5000) NOT NULL,
  `option1` varchar(5000) NOT NULL,
  `option2` varchar(5000) NOT NULL,
  `option3` varchar(500) NOT NULL,
  `option4` varchar(500) NOT NULL,
  `correct_answer` int(1) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `eid`, `image_url`, `option1`, `option2`, `option3`, `option4`, `correct_answer`, `date_updated`) VALUES
(10, 'asedrftyu', 2, 'http://localhost/oq/uploads/download.jpg', 'sedrftgyhu', 'awsertyu', 'awsedrftgyh', 'awsedrftgy', 2, '2024-04-19 12:50:04'),
(11, '∑πθΔedrftgyhu', 6, 'http://localhost/oq/uploads/download.jpg', 'rftgh', 'fghj', 'edrfg', 'gh', 1, '2024-04-21 12:19:19'),
(12, 'What is the capital of France?', 5, 'http://localhost/oq/uploads/Screenshot 2024-04-20 151040.png', 'Paris', 'London', 'Berlin', 'Rome', 1, '2024-04-21 11:27:32'),
(13, 'f√54+∑πx⁵', 5, '', 'dfghjk', 'ghjkl', 'fghjk', 'fghjk', 3, '2024-04-21 11:57:47'),
(14, 'What is the chemical symbol for water?', 5, 'water.png', 'H', 'O', 'W', 'H2O', 4, '2024-04-21 11:24:33'),
(15, 'What is the powerhouse of the cell?', 5, 'mitochondria.jpg', 'Nucleus', 'Mitochondria', 'Ribosome', 'Chloroplast', 2, '2024-04-21 11:24:33'),
(16, 'How many continents are there?', 5, 'continents.jpg', 'Five', 'Six', 'Seven', 'Eight', 3, '2024-04-21 11:24:33'),
(17, 'What is the capital of France?', 5, 'paris.jpg', 'Paris', 'London', 'Berlin', 'Rome', 1, '2024-04-21 11:38:51'),
(18, 'What is the largest planet in our solar system?', 5, 'jupiter.jpg', 'Mercury', 'Jupiter', 'Earth', 'Saturn', 2, '2024-04-21 11:38:51'),
(19, 'What is the chemical symbol for water?', 5, 'water.png', 'H', 'O', 'W', 'H2O', 4, '2024-04-21 11:38:51'),
(20, 'What is the powerhouse of the cell?', 5, 'mitochondria.jpg', 'Nucleus', 'Mitochondria', 'Ribosome', 'Chloroplast', 2, '2024-04-21 11:38:51'),
(21, 'How many continents are there?', 5, 'continents.jpg', 'Five', 'Six', 'Seven', 'Eight', 3, '2024-04-21 11:38:51'),
(22, 'What is the capital of France?', 5, 'paris.jpg', 'Paris', 'London', 'Berlin', 'Rome', 1, '2024-04-21 11:39:04'),
(23, 'What is the largest planet in our solar system?', 5, 'jupiter.jpg', 'Mercury', 'Jupiter', 'Earth', 'Saturn', 2, '2024-04-21 11:39:04'),
(27, 'What is the capital of France?', 6, 'http://localhost/oq/uploads/computer.jpg', 'Paris', 'London', 'Berlin', 'Rome', 1, '2024-04-21 12:20:05'),
(28, 'What is the largest planet in our solar system?', 6, 'jupiter.jpg', 'Mercury', 'Jupiter', 'Earth', 'Saturn', 2, '2024-04-21 12:18:18'),
(29, 'What is the chemical symbol for water?', 6, 'water.png', 'H', 'O', 'W', 'H2O', 4, '2024-04-21 12:18:19'),
(30, 'What is the powerhouse of the cell?', 6, 'mitochondria.jpg', 'Nucleus', 'Mitochondria', 'Ribosome', 'Chloroplast', 2, '2024-04-21 12:18:19'),
(31, 'How many continents are there?', 6, 'continents.jpg', 'Five', 'Six', 'Seven', 'Eight', 3, '2024-04-21 12:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `grade_section` varchar(100) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `grade_section`, `date_updated`) VALUES
(6, 16, '12-B', '2024-04-19 12:32:54'),
(7, 17, '12-B', '2024-04-19 12:37:40'),
(8, 18, '11-B', '2024-04-19 12:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `subject`, `date_updated`) VALUES
(3, 15, 'Maths', '2024-04-19 08:53:17'),
(4, 19, 'English', '2024-04-20 14:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = admin, 2= faculty , 3 = student',
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = incative , 1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_type`, `username`, `password`, `status`, `date_updated`) VALUES
(1, 'Brother', 1, 'Brother', 'admin123', 1, '2024-04-19 08:44:04'),
(15, 'Aytenew', 2, 'Aytenew', 'teacher123', 1, '2024-04-20 14:33:53'),
(16, 'Nahom', 3, 'Nahom', '1234', 1, '2024-04-19 12:32:53'),
(17, 'Girma', 3, 'Girma', '1234', 1, '2024-04-19 12:37:40'),
(18, 'Kidist', 3, 'Kidist', '1234', 1, '2024-04-19 12:40:36'),
(19, 'Eyuel', 2, 'Eyuel', 'teacher123', 1, '2024-04-20 14:37:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam_list`
--
ALTER TABLE `exam_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_student_list`
--
ALTER TABLE `exam_student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam_list`
--
ALTER TABLE `exam_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exam_student_list`
--
ALTER TABLE `exam_student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
