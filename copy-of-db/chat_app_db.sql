-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2023 at 11:22 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(4) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `image`) VALUES
(1, 'Test Group', '/src/public_site/media/placeholder.png'),
(4, 'Test Group 2', '/src/public_site/media/groups/vrBM8im70D.jpeg'),
(5, 'Test Group 3', '/src/public_site/media/groups/UNGOBvzHiB.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(4) NOT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `dateofmessage` date DEFAULT NULL,
  `timeofmessage` time DEFAULT NULL,
  `groups_id` int(4) DEFAULT NULL,
  `users_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `media`, `dateofmessage`, `timeofmessage`, `groups_id`, `users_id`) VALUES
(1, 'This is a test message from database.', NULL, '2023-01-24', '21:45:00', 1, 6),
(2, 'test', NULL, '2023-01-24', '21:13:15', 1, 6),
(4, 'test', NULL, '2023-01-25', '21:23:00', 1, 11),
(5, 'Hello', NULL, '2023-01-25', '21:24:00', 1, 11),
(9, 'hey', NULL, '2023-01-26', '18:00:00', 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `pw` varchar(255) DEFAULT NULL,
  `identifier` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `pw`, `identifier`) VALUES
(6, 'test', '/src/public_site/media/users/ogScUarxAb.jpeg', '$2y$10$RQ5J/UC1Az.9Mu8mFlCQjeKzJ7h80md3REokNGPhBdtj6fTv61y5G', 'ulIms5aC8FMIGcm38cmy'),
(11, 'test2', '/src/public_site/media/users/zgJPBVjKS9.jpeg', '$2y$10$z87ENCUOKbaW/3IQaj3kOO/kiXX0ve3liK3FBISA1xwVGG7ZZzr6i', 'cz1dtK3ulihTUGXv4b5I'),
(12, 'test3', '/src/public_site/media/users/VqkGJxXt7K.jpg', '$2y$10$uA4tSo5E6ehnf1oOcq/BeexNj6DZD6WmFxeKBlyMRwSrSqVFypJZa', 'J9TWvmZhIU9M5uPbdtOT'),
(13, 'ape', '/src/public_site/media/users/YOmAnHAdDm.jpeg', '$2y$10$LDKLQs6E7AH38bPPxLAUwO4zCz7mV5vkAxoGJ5U6YiGC5OKrvz9ya', 'HUdFA4eUdua0D5DUUxTF'),
(14, 'test4', '/src/public_site/media/users/eHPcZeOywp.jpeg', '$2y$10$KglZlxFUoOcyJgcmqslkBeHnsP5.BkpLJWS8B4MOi/pJlZhOnVYJS', 'fJq0R5dsDIqFjDnR849x');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(4) NOT NULL,
  `users_id` int(4) DEFAULT NULL,
  `groups_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `users_id`, `groups_id`) VALUES
(1, 6, 1),
(2, 11, 1),
(4, 6, 4),
(19, 11, 4),
(20, 12, 4),
(21, 13, 4),
(22, 14, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
