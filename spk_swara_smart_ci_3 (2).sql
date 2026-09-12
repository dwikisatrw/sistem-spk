-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Sep 2026 pada 14.55
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `file_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama`, `telepon`, `file_pdf`) VALUES
(23, 'I Made Dwiki Satria Wibawa', '081529417166', '2456c3a94165f4f05bfbd0c2c9655b0f.pdf'),
(24, 'Kadek Tasya Juliantari', '0811', NULL),
(25, 'I Putu Arsya Prabaswara Dwipayana', '0812', NULL),
(27, 'a', '021', NULL),
(28, 'abc', '1', NULL),
(29, 'ita', '087321123881', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_alternatif`, `nilai`) VALUES
(1, 23, 0.781691),
(2, 24, 0.712715),
(3, 25, 0.5877),
(4, 27, 0.779188),
(5, 28, 0.509103),
(6, 29, 0.260137);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kode_kriteria` varchar(100) NOT NULL,
  `bobot_awal` float NOT NULL,
  `bobot_swara` float DEFAULT NULL,
  `jenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `keterangan`, `kode_kriteria`, `bobot_awal`, `bobot_swara`, `jenis`) VALUES
(26, 'Umur', 'C1', 0.13, 0.0188638, 'Cost'),
(27, 'Pendidikan', 'C2', 0.15, 0.0458122, 'Benefit'),
(28, 'Pengalaman Kerja', 'C3', 0.2, 0.368348, 'Benefit'),
(29, 'Kemampuan Teknis', 'C4', 0.19, 0.286493, 'Benefit'),
(30, 'Kesesuaian Persyaratan Kerja', 'C5', 0.16, 0.0981689, 'Benefit'),
(31, 'Kesesuaian Ekspektasi Kompensasi', 'C6', 0.17, 0.182314, 'Cost');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(153, 23, 26, 107),
(154, 23, 27, 111),
(155, 23, 28, 115),
(156, 23, 29, 122),
(157, 23, 30, 127),
(159, 24, 26, 103),
(160, 24, 27, 109),
(161, 24, 28, 115),
(162, 24, 29, 121),
(163, 24, 30, 127),
(164, 25, 26, 103),
(165, 25, 27, 109),
(166, 25, 28, 115),
(167, 25, 29, 122),
(168, 25, 30, 127),
(174, 27, 26, 107),
(175, 27, 27, 112),
(176, 27, 28, 117),
(177, 27, 29, 122),
(178, 27, 30, 126),
(179, 27, 31, 138),
(180, 25, 31, 138),
(181, 28, 26, 106),
(182, 28, 27, 112),
(183, 28, 28, 116),
(184, 28, 29, 133),
(185, 28, 30, 134),
(186, 28, 31, 143),
(187, 29, 26, 107),
(188, 29, 27, 111),
(189, 29, 28, 113),
(190, 29, 29, 119),
(191, 29, 30, 126),
(192, 29, 31, 139);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `deskripsi`, `nilai`) VALUES
(103, 26, '> 40 Tahun', 1),
(104, 26, '36 – 40 Tahun', 2),
(105, 26, '31 – 35 Tahun', 3),
(106, 26, '26 – 30 Tahun', 4),
(107, 26, '20 – 25 Tahun', 5),
(108, 27, 'SD - SMP', 1),
(109, 27, 'SMA / SMK', 2),
(110, 27, 'D3', 3),
(111, 27, 'S1 / D4', 4),
(112, 27, 'S2', 5),
(113, 28, 'Tidak Ada Pengalaman', 1),
(114, 28, '< 1 Tahun', 2),
(115, 28, '1 – 2 Tahun', 3),
(116, 28, '3 – 5 Tahun', 4),
(117, 28, '> 5 Tahun', 5),
(118, 29, 'Tidak Menguasai', 1),
(119, 29, 'Kurang Menguasai', 2),
(120, 29, 'Cukup Menguasai', 3),
(121, 29, 'Menguasai', 4),
(122, 29, 'Sangat Menguasai', 5),
(123, 30, 'Sangat Kurang', 1),
(124, 30, 'Kurang', 2),
(125, 30, 'Cukup', 3),
(126, 30, 'Baik', 4),
(127, 30, 'Sangat Baik', 5),
(133, 29, 'Data Belum Lengkap', 0),
(134, 30, 'Data Belum Lengkap', 0),
(135, 26, 'Data Belum Lengkap', 0),
(136, 27, 'Data Belum Lengkap', 0),
(137, 28, 'Data Belum Lengkap', 0),
(138, 31, 'Rp. 2.000.000 - Rp. 2.500.000', 5),
(139, 31, 'Rp. 2.500.000 - Rp. 3.000.000', 4),
(140, 31, 'Rp. 3.000.000 - Rp. 3.500.000', 3),
(141, 31, 'Rp. 3.500.000 - Rp. 4.000.000', 2),
(142, 31, 'Rp. 4.000.000 - Rp. 4.500.000', 1),
(143, 31, 'Data Belum Lengkap', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_user_level`, `nama`, `email`, `username`, `password`) VALUES
(1, 1, 'Administrator', 'administrator@gmail.com', 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4'),
(7, 2, 'Manager', 'manager@gmail.com', 'manager', '1d0258c2440a8d19e716292b231e3190');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level`
--

CREATE TABLE `user_level` (
  `id_user_level` int(11) NOT NULL,
  `user_level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_level`
--

INSERT INTO `user_level` (`id_user_level`, `user_level`) VALUES
(1, 'Administrator'),
(2, 'Manager');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wawancara`
--

CREATE TABLE `wawancara` (
  `id_wawancara` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `jawaban1` int(11) NOT NULL,
  `jawaban2` int(11) NOT NULL,
  `jawaban3` int(11) NOT NULL,
  `jawaban4` int(11) NOT NULL,
  `jawaban5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `wawancara`
--

INSERT INTO `wawancara` (`id_wawancara`, `id_alternatif`, `jawaban1`, `jawaban2`, `jawaban3`, `jawaban4`, `jawaban5`) VALUES
(1, 23, 1, 0, 1, 0, 1),
(4, 29, 1, 1, 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_alternatif` (`id_alternatif`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `nilai` (`nilai`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_user_level` (`id_user_level`);

--
-- Indeks untuk tabel `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id_user_level`);

--
-- Indeks untuk tabel `wawancara`
--
ALTER TABLE `wawancara`
  ADD PRIMARY KEY (`id_wawancara`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id_user_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `wawancara`
--
ALTER TABLE `wawancara`
  MODIFY `id_wawancara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
