-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql302.infinityfree.com
-- Generation Time: Jun 05, 2025 at 12:37 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39155967_inget_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `status` enum('belum','selesai') DEFAULT 'belum',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `description`, `event_time`, `status`, `created_at`, `updated_at`, `username`) VALUES
(14, 'Kondangan ', 'Tiwi', '08:39:00', 'belum', '2025-06-02 20:39:22', NULL, 'Fira'),
(16, 'ooo', 'jicjj', '22:00:00', 'selesai', '2025-06-02 22:16:52', '2025-06-02 22:32:30', 'Lawuk'),
(17, 'Disun Mabok', 'jooo', '10:10:00', 'selesai', '2025-06-02 22:28:25', '2025-06-02 22:31:27', 'Lawuk'),
(18, 'Kontol', 'ashdsh', '11:11:00', 'selesai', '2025-06-02 22:40:57', '2025-06-02 22:41:08', 'Lawuk'),
(26, 'sdnjf', 'csa', '09:10:00', 'selesai', '2025-06-03 13:15:28', '2025-06-03 13:15:34', 'Lawuk'),
(46, 'I', 'Jsj', '09:14:00', 'belum', '2025-06-04 16:15:02', NULL, ')('),
(47, 'I', 'Jsj', '09:14:00', 'belum', '2025-06-04 16:15:06', NULL, ')('),
(48, 'I', 'Jsj', '09:14:00', 'belum', '2025-06-04 16:15:07', NULL, ')('),
(49, 'I', 'Jsj', '09:14:00', 'belum', '2025-06-04 16:15:07', NULL, ')('),
(50, 'I', 'Jsj', '09:14:00', 'belum', '2025-06-04 16:15:11', NULL, ')('),
(51, 'Hahaha', 'Hahaj', '04:18:00', 'selesai', '2025-06-04 16:18:38', '2025-06-04 19:04:00', 'Abim');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `pesan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status_baca` enum('belum','sudah') DEFAULT 'belum',
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `pesan`, `created_at`, `status_baca`, `username`) VALUES
(10, 'Tabungan baru telah dibuat.', '2025-06-02 14:42:57', 'sudah', '--'),
(11, 'Tabungan baru telah dibuat.', '2025-06-02 15:34:23', 'belum', '--'),
(25, 'Tabungan baru telah dibuat.', '2025-06-03 08:41:59', 'sudah', 'Lawuk'),
(31, 'Tabungan baru telah dibuat.', '2025-06-04 03:27:37', 'sudah', 'Abim'),
(32, 'Tabungan baru telah dibuat.', '2025-06-04 10:40:36', 'belum', 'apeng'),
(33, 'Tabungan baru telah dibuat.', '2025-06-04 10:41:08', 'belum', 'apeng'),
(35, 'Tabungan baru telah dibuat.', '2025-06-04 19:13:48', 'belum', ')(');

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `target_amount` decimal(10,2) NOT NULL,
  `current_amount` decimal(10,2) DEFAULT 0.00,
  `target_date` date NOT NULL,
  `status` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`id`, `purpose`, `target_amount`, `current_amount`, `target_date`, `status`, `created_at`, `updated_at`, `username`) VALUES
(16, 'Liburan ke Bali', '10000000.00', '50001000.00', '2025-06-07', 'completed', '2025-05-28 04:52:01', '2025-06-03 06:44:09', 'Abim'),
(18, 'Ngombe', '25000.00', '75000.00', '2025-06-28', 'completed', '2025-06-01 13:20:39', '2025-06-03 06:44:02', 'Abim'),
(21, 'Minumm', '25000.00', '25000.00', '2025-06-15', 'completed', '2025-06-02 04:51:23', '2025-06-04 06:15:55', 'Abim'),
(24, 'Beli Laptop', '4000000.00', '0.00', '2025-09-08', 'not_started', '2025-06-02 12:42:57', '2025-06-02 12:42:57', '--'),
(25, '<h1>Hello World</h1>', '100000.00', '0.00', '2025-06-30', 'not_started', '2025-06-02 13:34:23', '2025-06-02 13:34:23', '--'),
(34, 'velg rossi', '900000.00', '511000.00', '2025-12-15', 'in_progress', '2025-06-03 05:22:12', '2025-06-04 05:42:50', 'Abim'),
(45, 'Pernikahan bima sama apenk', '6568668.00', '300000.00', '2025-06-05', 'in_progress', '2025-06-04 07:27:37', '2025-06-04 23:18:21', 'Abim'),
(47, 'Reflektor riting mio ', '100000.00', '45000.00', '2025-06-15', 'in_progress', '2025-06-04 14:41:08', '2025-06-05 01:35:53', 'apeng'),
(49, 'Kaa', '30000.00', '3000.00', '2025-06-14', 'in_progress', '2025-06-04 23:13:48', '2025-06-04 23:13:48', ')(');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` date NOT NULL,
  `status` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `deadline`, `status`, `created_at`, `updated_at`, `username`) VALUES
(41, 'Pr', 'Rekapan', '2025-06-14', 'completed', '2025-06-02 13:41:20', '2025-06-02 14:18:16', 'Fira'),
(43, 'p', 'cek', '2025-06-28', 'not_started', '2025-06-02 15:06:16', '2025-06-04 15:19:21', 'Lawuk'),
(58, 'g', 'g', '2025-07-02', 'not_started', '2025-06-03 05:16:06', '2025-06-03 06:54:10', 'Lawuk'),
(59, 'hjg', 'h', '2025-06-06', 'completed', '2025-06-03 05:17:17', '2025-06-04 15:19:24', 'Lawuk'),
(60, 'sdnjf', 'edljaks', '2025-06-28', 'completed', '2025-06-03 05:45:59', '2025-06-03 06:41:00', 'Lawuk'),
(63, 'sdsdsds', 'asnj', '2025-06-03', 'not_started', '2025-06-03 06:24:20', '2025-06-03 06:47:41', 'Lawuk'),
(71, 'Tambah', 'Ajn', '2025-06-16', 'not_started', '2025-06-04 23:51:07', '2025-06-04 23:51:18', ')(');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `phone`) VALUES
(1, 'Rafli', '121212', '', NULL, NULL),
(3, 'Abim', '$2y$10$G/dKyr1AilWRWYYSVQOEoum/uWS/5PCYJoHGzaG3pI/7OvEukule6', 'bimasaxti7@gmail.com', 'Bima love rafly', '+6285727152082'),
(4, 'admin', '$2y$10$afo9x9vTZ5mN2mWS6juQoek3kDd9MZ2DAncjjNOLx8ScDOd3rUxD2', '', NULL, NULL),
(5, 'Yahrabang', '$2y$10$34Shc9wHsYY5aqxrDWT1rOyiBCcvd1aYE5qODNFypcowkcjPAYWoy', '', NULL, NULL),
(6, 'Biasanya', '$2y$10$Z.U5IDJtTx1v7965orZcNuoufOgszVmeUJ7wbTsZMjseORbyJnkrK', '', NULL, NULL),
(7, '--', '$2y$10$rhRDB/yBJNyKEP.I9.WWoes6NJOUWKNzAeXRdJRwGMfZuAdh7dNte', '', NULL, NULL),
(8, 'test', '$2y$10$mn.aLBg6KEy4dmK/oAPd.OfikGFWCyLRBorW/WzGhYT/O/jLgKcdC', '', NULL, NULL),
(9, 'Fira', '$2y$10$8IRaGB/27Ra.XZaa7OLU5e1A8tyuKfKu9wT/QiDqQwRYXy1XsRO2e', '', NULL, NULL),
(10, 'Lawuk', '$2y$10$v.ahj142o6oGHjv/qtK04O802shnpwL.r22wYvrRrHRr7tjL5vYha', '', NULL, NULL),
(11, 'hadi', '$2y$10$kXoh3ny4kzsNVKJ/Y.vp1uN4S7x950HzVFgwNXT6aRbc6thHLqeHS', 'hadi@gmail.vom', 'Hadiiiii', '383838299'),
(12, 'rafli subhi', '$2y$10$Z2wJ.zpF9W1sNW9kmixM0.12KAsVtBIkcJhcJMP3kGDAcyJIjPKeK', '', NULL, NULL),
(13, 'maoel', '$2y$10$9I36j5e4R9jZjYWLpERzOuH0TA52t5EXoVeQ0dxwzwtDJvkcHRxGK', '', NULL, NULL),
(14, 'apeng', '$2y$10$7vvjKLn2N31wvvIQ/czTk.7GtFm1QqwrtBGgpLY8bmroDANMBlP3O', '', NULL, NULL),
(15, ')(', '$2y$10$Odfy9.nuvf6VilfVQGvgLuQyEvTiFc8LYFqt2zzrOJYgCDLRFxs3.', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
