-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2023 pada 03.40
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `image` text NOT NULL DEFAULT 'default.png',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `image`, `password`) VALUES
(1, 'Administrator', 'superadmin', 'default.png', '$2y$10$aX3KtHwTSYkN0AZ0fn7LcO727KuqwFEu91mL4kEKw7fYsOou1exSu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `ket` varchar(7) NOT NULL,
  `nama` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `file`
--

INSERT INTO `file` (`id`, `ket`, `nama`, `createdAt`, `updatedAt`) VALUES
(1, 'masuk', 'qrcode-20230521083129.png', '2023-03-11 05:35:17', '2023-05-21 01:31:29'),
(2, 'keluar', 'qrcode-20230521083133.png', '2023-03-11 05:35:17', '2023-05-21 01:31:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `queue`
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
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id`, `status`, `createdAt`, `updatedAt`) VALUES
(1, 'REGISTRASI', '2023-04-06 07:42:36', '2023-05-21 01:37:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `jk` int(1) DEFAULT NULL,
  `level` varchar(10) NOT NULL,
  `noKartu` varchar(20) DEFAULT NULL,
  `image` varchar(50) NOT NULL,
  `createAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nama`, `nim`, `jk`, `level`, `noKartu`, `image`, `createAt`, `updateAt`) VALUES
(18, 'default@gmail.com', '$2y$10$PBkYCzQId1EAEajG9X.BBedqzcXHGTJzYxJJ/i0sALrD75rPPBpay', 'Tamu 1', '', NULL, 'Tamu', '90 C2 12 20', 'd6b6c38c706c8c8db5b722c2a080f508.png', '2023-04-16 06:03:20', '2023-05-21 01:37:57'),
(25, 'mahasiswa1@gmail.com', '$2y$10$ayMTeJgE8mLLyeVFeOk10.WlggobYFwV0r5Q7cFAmdH/vv0bjIXSi', 'Mahasiswa 1', '19089091', 1, 'Mahasiswa', '', 'default.png', '2023-05-21 01:38:32', NULL),
(26, 'karyawan.1@gmail.com', '$2y$10$gXjU9QK3tnF1bAwSYW5vF.8DU8sbp542X7DPE4t7J5LbffphL4l5C', 'Karyawan 1', '', 1, 'Karyawan', '', 'default.png', '2023-05-21 01:39:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
