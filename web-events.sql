-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 06:46 PM
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
-- Database: `web-events`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `fn` varchar(10) NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`fn`, `event_id`) VALUES
('123123123', 3),
('123123123', 4),
('123123123', 5),
('123123123', 6),
('123456', 5),
('25', 4),
('564321', 4),
('82215', 3),
('82215', 4),
('82215', 6);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fm_x_subject_id` bigint(20) UNSIGNED NOT NULL,
  `start_date_time` datetime DEFAULT NULL,
  `end_date_time` datetime DEFAULT NULL,
  `event_password` varchar(255) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `fm_x_subject_id`, `start_date_time`, `end_date_time`, `event_password`, `event_name`) VALUES
(3, 1, '2020-10-01 09:15:00', '2020-10-01 12:00:00', 'bobec', 'UKAZATELI'),
(4, 1, '2020-10-10 09:15:00', '2020-10-10 12:00:00', 'bobec', 'DINAMICHNA PAMET'),
(5, 1, '2024-02-28 19:00:00', '2024-02-28 22:00:00', 'fmi', 'FMI Codes 2024'),
(6, 1, '2021-01-20 10:00:00', '2021-01-20 13:00:00', 'bobec', 'IZPIT');

-- --------------------------------------------------------

--
-- Table structure for table `event_comments`
--

CREATE TABLE `event_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `review` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_comments`
--

INSERT INTO `event_comments` (`id`, `event_id`, `comment`, `review`) VALUES
(1, 3, 'alo', 5),
(2, 3, 'mn dobre ;)', 5),
(3, 3, 'zdr, sonche', 5),
(4, 3, 'kp, ks, nn', 3),
(5, 3, 'здрррррррр', 4),
(6, 4, 'hi', 2),
(7, 4, 'alo, da', 3),
(8, 3, 'bravoooo', 4),
(9, 5, 'alo, da', 5),
(10, 5, 'alo', 4);

-- --------------------------------------------------------

--
-- Table structure for table `event_recordings`
--

CREATE TABLE `event_recordings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_recordings`
--

INSERT INTO `event_recordings` (`id`, `event_id`, `link`, `is_approved`) VALUES
(1, 4, '', 1),
(2, 4, 'https://www.youtube.com/', 1),
(3, 6, 'https://mail.google.com/mail/u/0/#inbox', 1),
(4, 3, 'https://www.msn.com/en-xl/news/other/trump-added-trillions-to-the-national-debt-analysis-finds/ss-BB1hu2L0?ocid=msedgntp&amp;pc=U531&amp;cvid=adf2d30006d54d2784e64f39354166b8&amp;ei=16', 0),
(5, 3, 'https://www.youtube.com/', 1),
(6, 5, '5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_resources`
--

CREATE TABLE `event_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_resources`
--

INSERT INTO `event_resources` (`id`, `event_id`, `link`) VALUES
(4, 4, 'https://www.youtube.com/'),
(5, 4, 'http://localhost/events/event_view.php?event_id=4'),
(6, 4, 'https://mail.google.com/mail/u/0/#inbox'),
(7, 5, 'zdr');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_members`
--

CREATE TABLE `faculty_members` (
  `fm_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_members`
--

INSERT INTO `faculty_members` (`fm_id`, `user_id`) VALUES
(1, 2),
(2, 3),
(3, 4),
(4, 16),
(5, 17),
(6, 18),
(7, 19),
(8, 21),
(9, 24);

-- --------------------------------------------------------

--
-- Table structure for table `fm_x_subject`
--

CREATE TABLE `fm_x_subject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fm_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_x_subject`
--

INSERT INTO `fm_x_subject` (`id`, `fm_id`, `subject_id`, `start_date`, `end_date`) VALUES
(1, 3, 2, '2001-06-11', '2024-06-11'),
(2, 2, 2, '2020-12-06', '2023-06-06'),
(3, 3, 4, '2002-06-11', '2020-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `fn` varchar(10) NOT NULL,
  `major` enum('SI','IS','KN','IS') NOT NULL,
  `adm_group` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`fn`, `major`, `adm_group`, `user_id`, `course`) VALUES
('123123123', '', 3, 22, 1),
('123456', 'KN', 4, 12, 4),
('16052004', 'KN', 8, 14, 1),
('25', 'KN', 1, 15, 3),
('373737', 'SI', 6, 13, 4),
('564321', 'IS', 2, 20, 2),
('81712', 'KN', 2, 5, 4),
('82214', 'KN', 4, 1, NULL),
('82215', 'KN', 4, 6, 4),
('85000', 'IS', 3, 11, 4),
('999888', 'KN', 2, 23, 5);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(3, 'Algebra 1'),
(7, 'alo'),
(1, 'DIS'),
(4, 'DSTR'),
(5, 'EAI'),
(6, 'Scala'),
(2, 'UP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `names` text NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `names`, `email`, `password`, `is_admin`) VALUES
(1, 'Peter Kolev', 'peter.kolev2001@gmail.com', '$2y$10$FhQLbRMg3YumCo9qozqk8ej39usy0fjplfBa0EHlB84dr8QspVa6S', 0),
(2, 'Admin Adminov', 'admin@example.com', '$2y$10$UNmTzozst9SF1na84vu/uuICp.p2l69Qydq3kpGgbM8QYhk9VaS2C', 1),
(3, 'Luben Georgiev', 'lyubo@gmail.com', '$2y$10$R/ETe57ZbC5sPY5K/bMn2OCahRQ/6Y0f8uZiS67TZfUqaDBRBRXLy', 1),
(4, 'Petar Armyanov', 'armianov@gmail.com', '$2y$10$pNPZb3hVOAViehPs6Nti7O1dFN4OnMb85nLfnMvaQhLEeLkUBy/3K', 1),
(5, 'Каменчо Вакавчиев', 'kamencho@gmail.com', '$2y$10$YmpVrj57.AF1KABtrDshDOk6salBrVqWIvA0M3PWllfcS/XfqH8im', 1),
(6, 'Steliana Petkova', 'steliana@gmail.com', '$2y$10$Ly6fRF3xIy6C9G1iFGpkWeo6te3R.CCuo1s6zGfcS10x4bL7JIeFW', 0),
(11, 'Pamela Hristova', 'pamdispam@gmail.com', '$2y$10$HTTP1a4pwBh1WZ1MMNCj1OyeFLj1DIpRddBL82h/WBVwIr7hQBbCi', 0),
(12, 'Georgi Ivanov', 'gosho@gmail.com', '$2y$10$vGdF4lazor6n6gk81X0YLu50jmSZZ.pxZvjEVnELCzSVvYLlNaw9G', 0),
(13, 'Radoslav Sozonov', 'rado_sz@gmail.com', '$2y$10$INqDJBptdfmwhmv0WwXIB.tMt5SihA9uoKZf/yPw5C1qDHVwDNWLa', 0),
(14, 'Mirela Nikolova', 'mirelian@gmail.com', '$2y$10$wg5dzenMRNtdh5ge3OOG0eRoSy2/Hk8puBOOXXJ6arzWR44H7WQk2', 0),
(15, 'Anastasia Kasarova', 'asi_kasi@gmail.com', '$2y$10$gyjgLc60YSqvHKW3fblCbedwGoH9s53Ol3uVRmMvZtyLi.9FYBTyG', 0),
(16, 'Atanas Semerdzhiev', 'nasko@gmail.com', '$2y$10$CgQEYYumpTTfp6HJHZ1YR.YQgD.qJieBiZlk8WLeXSZMIOjaDJLrm', 0),
(17, 'Deyancho', 'deyancho@gmail.com', '$2y$10$nQkrB8iRzVa.4cwo./nRaO872wg4CWIUNfWESVDkbawNXc3DRzsgy', 0),
(18, '100enchev', 'tochka_na_sgustqwane@gmail.com', '$2y$10$BsAlDvywqh/Ncd7oODLjyuXl0C8ucEa7CWMBactfu3qVlwAeNzNq2', 0),
(19, 'Tinko Tinchev', 'tinko@gmail.com', '$2y$10$tUFGWr/UtJ.CKNYb2DnYFegNkNuIx9faK4LO3CDyySdLr2KVdvsWy', 0),
(20, 'Tedi Petrova', 'laz@gmail.com', '$2y$10$w3KckE7PBtzoCCEa5qpcnOIhv8nuNB/pPXfptutYLN.syHwKCU9YC', 0),
(21, 'Ivan Koychev', 'koychev@gmail.com', '$2y$10$LATTXg8uh/XlDsNmC0W3q.pkr3vNm1512ktI87J95Xa22F4xHXiuO', 0),
(22, 'Maksim Enchev', 'maksi@gmail.com', '$2y$10$OUKlzE/CkFu184WzbHram.hlEj4MQdKIQZ5N5qTb8AZkWQ8fk2swC', 0),
(23, 'Vladi Rizhdov', 'vladi@gmail.com', '$2y$10$e.RK/3XW6fu5fvrJfXvu5.ORWEJD20pXmJpqF8un9qZUHXplnfGAK', 0),
(24, 'Milenkata', 'milenkata@gmail.com', '$2y$10$1RXiD2QI23xlTC4R6nIaremH8HXpNZXDpHe2oYkshB3EMkmezUeZa', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`fn`,`event_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fm_x_subject_id` (`fm_x_subject_id`);

--
-- Indexes for table `event_comments`
--
ALTER TABLE `event_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event_recordings`
--
ALTER TABLE `event_recordings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event_resources`
--
ALTER TABLE `event_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `faculty_members`
--
ALTER TABLE `faculty_members`
  ADD PRIMARY KEY (`fm_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `fm_x_subject`
--
ALTER TABLE `fm_x_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fm_id` (`fm_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`fn`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name_constraint` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `unique_email_constraint` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_comments`
--
ALTER TABLE `event_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_recordings`
--
ALTER TABLE `event_recordings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_resources`
--
ALTER TABLE `event_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faculty_members`
--
ALTER TABLE `faculty_members`
  MODIFY `fm_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fm_x_subject`
--
ALTER TABLE `fm_x_subject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`fn`) REFERENCES `students` (`fn`),
  ADD CONSTRAINT `attendances_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`fm_x_subject_id`) REFERENCES `fm_x_subject` (`id`);

--
-- Constraints for table `event_comments`
--
ALTER TABLE `event_comments`
  ADD CONSTRAINT `event_comments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `event_recordings`
--
ALTER TABLE `event_recordings`
  ADD CONSTRAINT `event_recordings_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `event_resources`
--
ALTER TABLE `event_resources`
  ADD CONSTRAINT `event_resources_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `faculty_members`
--
ALTER TABLE `faculty_members`
  ADD CONSTRAINT `faculty_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fm_x_subject`
--
ALTER TABLE `fm_x_subject`
  ADD CONSTRAINT `fm_x_subject_ibfk_1` FOREIGN KEY (`fm_id`) REFERENCES `faculty_members` (`fm_id`),
  ADD CONSTRAINT `fm_x_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
