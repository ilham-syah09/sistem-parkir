-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 07, 2023 at 04:48 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `image` text NOT NULL DEFAULT 'default.png',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `image`, `password`) VALUES
(1, 'Admin Kepegawaian', 'superadmin', 'default.png', '$2y$10$aX3KtHwTSYkN0AZ0fn7LcO727KuqwFEu91mL4kEKw7fYsOou1exSu');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `metode` varchar(4) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `parkirMasuk` time DEFAULT NULL,
  `pictureMasuk` text DEFAULT NULL,
  `parkirKeluar` time DEFAULT NULL,
  `pictureKeluar` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `metode`, `idUser`, `tanggal`, `parkirMasuk`, `pictureMasuk`, `parkirKeluar`, `pictureKeluar`, `createdAt`, `updatedAt`) VALUES
(1, 'scan', 1, '2023-04-05', '07:20:00', 'sample.png', '11:30:00', 'sample.png', '2023-04-05 07:00:10', '2023-04-05 07:13:52'),
(2, 'scan', 1, '2023-04-05', '14:20:00', 'sample.png', '16:58:00', 'sample.png', '2023-04-05 07:00:10', '2023-04-05 07:13:52'),
(3, 'rfid', 3, '2023-04-06', '14:20:00', 'sample.png', '16:58:00', 'sample.png', '2023-04-06 07:00:10', NULL),
(4, 'scan', 2, '2023-04-06', '13:13:00', 'sample.png', '14:10:00', 'sample.png', '2023-04-06 06:13:15', '2023-04-06 07:20:02'),
(5, 'scan', 2, '2023-04-06', '15:13:00', 'sample.png', NULL, NULL, '2023-04-06 07:13:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `ket` varchar(7) NOT NULL,
  `nama` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `ket`, `nama`, `createdAt`, `updatedAt`) VALUES
(1, 'masuk', 'qrcode-20230406113602.png', '2023-03-11 05:35:17', '2023-04-06 04:36:02'),
(2, 'keluar', 'qrcode-20230407214317.png', '2023-03-11 05:35:17', '2023-04-07 14:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `idData` int(11) NOT NULL,
  `act` varchar(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `status`, `createdAt`, `updatedAt`) VALUES
(1, 'REGISTRASI', '2023-04-06 07:42:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `jk` int(1) DEFAULT NULL,
  `level` varchar(10) NOT NULL,
  `noKartu` varchar(20) DEFAULT NULL,
  `image` text NOT NULL DEFAULT 'default.png',
  `createAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nama`, `nip`, `jk`, `level`, `noKartu`, `image`, `createAt`, `updateAt`) VALUES
(1, 'user.1@gmail.com', '$2y$10$eX4S9GG3Ko2NgIRfCLwfEOHf5zknAxKU38I6ecSEYYG3JM/K3zMcq', 'User 1', '199912030001', 2, 'Karyawan', NULL, 'default.png', '2023-02-20 02:17:29', '2023-04-06 02:38:33'),
(2, 'ilham@gmail.com', '$2y$10$eX4S9GG3Ko2NgIRfCLwfEOHf5zknAxKU38I6ecSEYYG3JM/K3zMcq', 'Ilham', '129091209', 1, 'Mahasiswa', NULL, 'default.png', '2023-02-20 04:15:23', '2023-04-06 02:38:36'),
(3, 'rfid@gmail.com', '$2y$10$eX4S9GG3Ko2NgIRfCLwfEOHf5zknAxKU38I6ecSEYYG3JM/K3zMcq', 'RFID', '129091209', 1, 'Tamu', 'AA AA AA AA', 'default.png', '2023-02-20 04:15:23', '2023-04-06 02:38:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
