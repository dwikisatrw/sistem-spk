-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 06 Nov 2022 pada 01.51
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_swara_smart_ci_3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama`) VALUES
(19, 'Galaxy'),
(20, 'iPhone'),
(21, 'BB'),
(22, 'Lumia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_alternatif`, `nilai`) VALUES
(1, 19, 0.580065),
(2, 20, 0.623358),
(3, 21, 0.541449),
(4, 22, 0.16211);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kode_kriteria` varchar(100) NOT NULL,
  `bobot_awal` float NOT NULL,
  `bobot_swara` float DEFAULT NULL,
  `jenis` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `keterangan`, `kode_kriteria`, `bobot_awal`, `bobot_swara`, `jenis`) VALUES
(26, 'Harga', 'C1', 0.2, 0.286493, 'Cost'),
(27, 'Kualitas', 'C2', 0.3, 0.368348, 'Benefit'),
(28, 'Fitur', 'C3', 0.2, 0.182314, 'Benefit'),
(29, 'Populer', 'C4', 0.15, 0.0981689, 'Benefit'),
(30, 'Purna Jual', 'C5', 0.1, 0.0458122, 'Benefit'),
(31, 'Keawetan', 'C6', 0.05, 0.0188638, 'Benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` int(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(129, 19, 26, 105),
(130, 19, 27, 110),
(131, 19, 28, 117),
(132, 19, 29, 121),
(133, 19, 30, 127),
(134, 19, 31, 130),
(135, 20, 26, 107),
(136, 20, 27, 112),
(137, 20, 28, 117),
(138, 20, 29, 120),
(139, 20, 30, 126),
(140, 20, 31, 131),
(141, 21, 26, 106),
(142, 21, 27, 111),
(143, 21, 28, 116),
(144, 21, 29, 122),
(145, 21, 30, 125),
(146, 21, 31, 131),
(147, 22, 26, 106),
(148, 22, 27, 110),
(149, 22, 28, 115),
(150, 22, 29, 119),
(151, 22, 30, 124),
(152, 22, 31, 132);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE IF NOT EXISTS `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `deskripsi`, `nilai`) VALUES
(103, 26, 'Sangat Mahal', 1),
(104, 26, 'Mahal', 2),
(105, 26, 'Cukup Murah', 3),
(106, 26, 'Murah', 4),
(107, 26, 'Sangat Murah', 5),
(108, 27, 'Sangat Buruk', 1),
(109, 27, 'Buruk', 2),
(110, 27, 'Cukup Baik', 3),
(111, 27, 'Baik', 4),
(112, 27, 'Sangat Baik', 5),
(113, 28, 'Sangat Sedikit', 1),
(114, 28, 'Sedikit', 2),
(115, 28, 'Cukup Lengkap', 3),
(116, 28, 'Lengkap', 4),
(117, 28, 'Sangat Lengkap', 5),
(118, 29, 'Sangat Tidak Populer', 1),
(119, 29, 'Tidak Populer', 2),
(120, 29, 'Cukup Populer', 3),
(121, 29, 'Populer', 4),
(122, 29, 'Sangat Populer', 5),
(123, 30, 'Sangat Tidak Baik', 1),
(124, 30, 'Tidak Baik', 2),
(125, 30, 'Cukup Baik', 3),
(126, 30, 'Baik', 4),
(127, 30, 'Sangat Baik', 5),
(128, 31, 'Sangat Tidak Awet', 1),
(129, 31, 'Tidak Awet', 2),
(130, 31, 'Cukup Awet', 3),
(131, 31, 'Awet', 4),
(132, 31, 'Sangat Awet', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_user_level`, `nama`, `email`, `username`, `password`) VALUES
(1, 1, 'Admin', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(7, 2, 'User', 'user@gmail.com', 'user', 'ee11cbb19052e40b07aac0ca060c23ee');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level`
--

CREATE TABLE IF NOT EXISTS `user_level` (
  `id_user_level` int(11) NOT NULL,
  `user_level` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_level`
--

INSERT INTO `user_level` (`id_user_level`, `user_level`) VALUES
(1, 'Administrator'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_alternatif` (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `nilai` (`nilai`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_user_level` (`id_user_level`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id_user_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=153;
--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id_user_level` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`nilai`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_user_level`) REFERENCES `user_level` (`id_user_level`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
