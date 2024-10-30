-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 04:25 PM
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
-- Database: `pets`
--

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `age` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_caption` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `user_id`, `name`, `type`, `description`, `age`, `location`, `image_path`, `image_caption`, `created_at`) VALUES
(4, 2, 'Eagle', 'Bird', 'Taimed', 1, 'Dubai', 'images/67207ffea1a57_pexels-pixabay-36846.jpg', 'da', '2024-10-29 06:26:06'),
(5, 3, 'Persian Cat', 'Cat', 'Fluffy', 12, 'UAE', 'images/6720cf90e3c6a_images (1).jpg', 'Cat', '2024-10-29 12:05:36'),
(6, 3, 'Fluffy kitten', 'Cat', 'Healthy and Friendly', 2, 'UAE', 'images/67224e469e40d_download (19).jfif', 'Kitten', '2024-10-30 15:18:30'),
(7, 3, 'Dog', 'Dog', 'Healthy', 8, 'UAE', 'images/67224e90e2a7a_pet_672075f236ff84.55494607.jpg', 'Dog', '2024-10-30 15:19:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `bio`, `created_at`) VALUES
(1, 'nasir12', 'nasiryt.827@gmail.com', '$2y$10$6rXsbGPoXrQURrPSPp1LceYzzgQWo28GjKfroAcZhG.K52y14ttjG', 'daeef', '2024-10-29 04:35:30'),
(2, 'Haider', 'haider@gmail.com', '$2y$10$hlEY01GUYxC4o4O1hZVxauOJ4GRHC8XEBzVp.Clqan0IqOsnSDeeq', 'fdae', '2024-10-29 06:24:58'),
(3, 'shahzaib', 'shahzaibyounas601@gmail.com', '$2y$10$jVGRnPqx.tv/uZAd8hpFz.jNGtXQB3bl0DznqPq.QWgrDCrPCTQPu', '', '2024-10-29 12:03:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
