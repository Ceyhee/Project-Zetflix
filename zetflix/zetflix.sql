-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2024 pada 05.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zetflix`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `email`, `password`) VALUES
(1, 'Aji', 'admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_film`
--

CREATE TABLE `tb_film` (
  `id_film` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `sutradara` varchar(100) DEFAULT NULL,
  `pemeran` text DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `link_film` varchar(255) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_film`
--

INSERT INTO `tb_film` (`id_film`, `judul`, `deskripsi`, `tahun`, `sutradara`, `pemeran`, `genre_id`, `rating`, `poster`, `link_film`, `harga`) VALUES
(18, 'Agak Laen (2024)', 'Film Agak Laen bercerita tentang 4 orang yang membutuhkan uang. Mereka berniat merenovasi wahana rumah hantu agar lebih seram. Ada seorang pria yang masuk ke wahana rumah hantu untuk bersembunyi. Dia terkena serangan jantung saat kaget melihat hantu.', '2024', ' Matt Bettinelli-OlpinTyler Gillett jacl', ' Bene Dion RajagukgukOki RenggaIndra Jegel', 3, 8.0, 'agak.jpg', 'https://www.youtube.com/embed/0YLSPyGA4h0', 23000.00),
(19, 'Abigail (2024)', 'Seorang penari balet bernama Abigail (Alisha Weir) diculik oleh sekelompok penjahat yang dipimpin oleh seorang informan bernama Lambert (Giancarlo Esposito). Mereka membawa Abigail ke sebuah rumah besar yang terpencil di pedesaan dengan motif yang belum terungkap. Dalam upaya menyamarkan identitas mereka, kelompok tersebut menggunakan nama samaran Rat Pack dan mematuhi aturan untuk tidak saling mengungkapkan informasi pribadi satu sama lain atau kepada Abigail.', '2024', ' Muhadkly Acho', ' Rebecca HallBrian Tyree HenryDan Stevens', 4, 7.0, 'abigail.jpg', 'https://www.youtube.com/embed/3PsP8MFH8p0', 22000.00),
(20, 'Atlas (2024)', 'In a bleak-sounding future, an A.I. soldier has determined that the only way to end war is to end humanity.', '2024', ' Matt Bettinelli-OlpinTyler Gillett', ' Rebecca HallBrian Tyree HenryDan Stevens', 1, 5.6, 'atlas.jpg', 'https://www.youtube.com/embed/TiJAfxzqDso', 16000.00),
(21, 'Boy Kill Worlds (2023)', 'A fever dream action film that follows Boy, a deaf person with a vibrant imagination. When his family is murdered, he is trained by a mysterious shaman to repress his childish imagination and become an instrument of death.', '2023', ' Matt Bettinelli-OlpinTyler Gillett', ' Rebecca HallBrian Tyree HenryDan Stevens', 1, 7.2, 'boy_kills_world.jpg', 'https://www.youtube.com/embed/tztCsUyiQv8', 30000.00),
(22, 'Civil War (2024)', 'A journey across a dystopian future America, following a team of military-embedded journalists as they race against time to reach DC before rebel factions descend upon the White House.', '2024', ' Matt Bettinelli-OlpinTyler Gillett', ' Melissa BarreraDan StevensAlisha Weir', 1, 8.0, 'civil_war.jpg', 'https://www.youtube.com/embed/U7_0-Su-pus', 40000.00),
(23, 'Dune: Part Two (2024)', 'Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family.', '2024', 'Adam WIngard', ' Kirsten DunstWagner MouraCailee Spaeny', 1, 8.0, 'dune_part_two.jpg', 'https://www.youtube.com/embed/_YUzQa_1RCE', 36000.00),
(24, 'The First Omen (2024)', 'A young American woman is sent to Rome to begin a life of service to the church, but encounters a darkness that causes her to question her faith and uncovers a terrifying conspiracy that hopes to bring about the birth of evil incarnate.', '2024', ' Matt Bettinelli-OlpinTyler Gillett', ' Rebecca HallBrian Tyree HenryDan Stevens', 1, 8.0, 'first_omen.jpg', 'https://www.youtube.com/embed//lmN1Op8ygno', 45000.00),
(25, 'Furiosa: A Mad Max Saga (2024)', 'The origin story of renegade warrior Furiosa before her encounter and teamup with Mad Max.', '2024', 'Adam WIngard', ' Kirsten DunstWagner MouraCailee Spaeny', 1, 7.9, 'furiosa.jpg', 'https://www.youtube.com/embed/XJMuhwVlca4', 40000.00),
(26, 'Godzilla Minus One (2023)', 'Post-war Japan is at its lowest point when a new crisis emerges in the form of a giant monster, baptized in the horrific power of the atomic bomb.', '2023', 'Adam WIngard', ' Rebecca HallBrian Tyree HenryDan Stevens', 1, 8.0, 'godzilla_minus_one.jpg', 'https://www.youtube.com/embed/r7DqccP1Q_4', 35000.00),
(27, 'Godzilla x Kong: The New Empire (2024)', 'Two ancient titans, Godzilla and Kong, clash in an epic battle as humans unravel their intertwined origins and connection to Skull Island\\\'s mysteries.', '2024', 'Adam WIngard', ' Bene Dion RajagukgukOki RenggaIndra Jegel', 1, 6.0, 'godzilla_x_kong.jpg', 'https://www.youtube.com/embed/lV1OOlGwExM', 23000.00),
(28, 'Joker: Folie à Deux (2024)', 'Sequel to the film \\\"Joker\\\" from 2019.', '2024', ' Alex Garland', ' Kirsten DunstWagner MouraCailee Spaeny', 1, 7.0, 'joker_folie_a_deux.jpg', 'https://www.youtube.com/embed/XyYx89UPrbs', 22000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_filmfavorit`
--

CREATE TABLE `tb_filmfavorit` (
  `id_favorit` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_film` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_filmfavorit`
--

INSERT INTO `tb_filmfavorit` (`id_favorit`, `id_user`, `id_film`) VALUES
(21, 7, 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_genre`
--

CREATE TABLE `tb_genre` (
  `id_genre` int(11) NOT NULL,
  `nama_genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_genre`
--

INSERT INTO `tb_genre` (`id_genre`, `nama_genre`) VALUES
(1, 'Action'),
(2, 'Drama'),
(3, 'Comedy'),
(4, 'Horror'),
(5, 'Romance'),
(6, 'Sci-Fi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nota`
--

CREATE TABLE `tb_nota` (
  `id_nota` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_film` int(11) NOT NULL,
  `harga_film` int(11) NOT NULL,
  `nominal_bayar` int(11) NOT NULL,
  `uang_kembalian` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jam_bayar` time DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `jam_kembali` time DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_nota`
--

INSERT INTO `tb_nota` (`id_nota`, `id_user`, `id_film`, `harga_film`, `nominal_bayar`, `uang_kembalian`, `tanggal_bayar`, `jam_bayar`, `tanggal_kembali`, `jam_kembali`, `metode_pembayaran`) VALUES
(74, 7, 25, 40000, 50000, 10000, '2024-06-04', '22:53:53', '2024-06-11', '22:53:53', 'OVO'),
(75, 7, 23, 36000, 50000, 14000, '2024-06-05', '07:50:19', '2024-06-12', '07:50:19', 'Dana'),
(76, 7, 22, 40000, 50000, 10000, '2024-06-05', '07:54:31', '2024-06-12', '07:54:31', 'GoPay'),
(77, 7, 28, 22000, 22000, 0, '2024-06-05', '22:02:47', '2024-06-12', '22:02:47', 'OVO'),
(78, 8, 18, 23000, 50000, 27000, '2024-06-06', '08:29:22', '2024-06-13', '08:29:22', 'Dana'),
(79, 8, 22, 40000, 40000, 0, '2024-06-06', '08:30:12', '2024-06-13', '08:30:12', 'GoPay'),
(80, 9, 18, 23000, 50000, 27000, '2024-08-08', '10:07:39', '2024-08-15', '10:07:39', 'GoPay');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sewafilm`
--

CREATE TABLE `tb_sewafilm` (
  `id_sewa` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_film` int(11) DEFAULT NULL,
  `tanggal_sewa` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sewafilm`
--

INSERT INTO `tb_sewafilm` (`id_sewa`, `id_user`, `id_film`, `tanggal_sewa`, `tanggal_kembali`) VALUES
(101, 7, 25, '2024-06-04', '2024-06-11'),
(102, 7, 23, '2024-06-05', '2024-06-12'),
(103, 7, 22, '2024-06-05', '2024-06-12'),
(104, 7, 28, '2024-06-05', '2024-06-12'),
(105, 8, 18, '2024-06-06', '2024-06-13'),
(106, 8, 22, '2024-06-06', '2024-06-13'),
(107, 9, 18, '2024-08-08', '2024-08-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ulasan`
--

CREATE TABLE `tb_ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_film` int(11) DEFAULT NULL,
  `ulasan` text DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `tanggal_ulasan` date DEFAULT NULL,
  `id_balasan` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_ulasan`
--

INSERT INTO `tb_ulasan` (`id_ulasan`, `id_user`, `id_film`, `ulasan`, `rating`, `tanggal_ulasan`, `id_balasan`, `id_admin`) VALUES
(78, 7, 25, 'Keren Banget filmnya', 8.0, '2024-06-04', NULL, NULL),
(79, 7, 25, 'mantap', 0.0, '2024-06-05', NULL, NULL),
(80, 7, 22, 'keren juga', 0.0, '2024-06-05', NULL, NULL),
(81, NULL, 22, 'Keren', NULL, '2024-06-05', NULL, NULL),
(82, NULL, 18, 'film sangat sangat sangat', NULL, '2024-08-06', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `email`, `password`, `tanggal_lahir`, `alamat`, `foto`) VALUES
(7, 'M.Aji Sukma', 'ajisukma@gmail.com', '$2y$10$fTe9WPjXdik9wx0VkQOqGu1Dos4XGCkwLxNvsR0HDH3YmiFktuZj.', '1998-06-19', 'Palembang', NULL),
(8, 'Son', 'son@gmail.com', '$2y$10$IPt5MJLw5cWqUBg6qVCkcOK6ydJklst3n2ycoVVsygCwvuX3AzOhm', '2004-07-16', 'Palembang', NULL),
(9, 'Aji', 'aji@gmail.com', '$2y$10$RCnvRTrWXEi5FQ0pcqyPsOkehcRhORrthHtN2CPKg3xfeIIBYxAsm', '1998-02-26', 'Jakarta', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `tb_film`
--
ALTER TABLE `tb_film`
  ADD PRIMARY KEY (`id_film`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indeks untuk tabel `tb_filmfavorit`
--
ALTER TABLE `tb_filmfavorit`
  ADD PRIMARY KEY (`id_favorit`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_film` (`id_film`);

--
-- Indeks untuk tabel `tb_genre`
--
ALTER TABLE `tb_genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Indeks untuk tabel `tb_nota`
--
ALTER TABLE `tb_nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_film` (`id_film`);

--
-- Indeks untuk tabel `tb_sewafilm`
--
ALTER TABLE `tb_sewafilm`
  ADD PRIMARY KEY (`id_sewa`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_film` (`id_film`);

--
-- Indeks untuk tabel `tb_ulasan`
--
ALTER TABLE `tb_ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_film` (`id_film`),
  ADD KEY `id_balasan` (`id_balasan`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_film`
--
ALTER TABLE `tb_film`
  MODIFY `id_film` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `tb_filmfavorit`
--
ALTER TABLE `tb_filmfavorit`
  MODIFY `id_favorit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tb_genre`
--
ALTER TABLE `tb_genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_nota`
--
ALTER TABLE `tb_nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `tb_sewafilm`
--
ALTER TABLE `tb_sewafilm`
  MODIFY `id_sewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT untuk tabel `tb_ulasan`
--
ALTER TABLE `tb_ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_film`
--
ALTER TABLE `tb_film`
  ADD CONSTRAINT `tb_film_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `tb_genre` (`id_genre`);

--
-- Ketidakleluasaan untuk tabel `tb_filmfavorit`
--
ALTER TABLE `tb_filmfavorit`
  ADD CONSTRAINT `tb_filmfavorit_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  ADD CONSTRAINT `tb_filmfavorit_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `tb_film` (`id_film`);

--
-- Ketidakleluasaan untuk tabel `tb_nota`
--
ALTER TABLE `tb_nota`
  ADD CONSTRAINT `tb_nota_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  ADD CONSTRAINT `tb_nota_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `tb_film` (`id_film`);

--
-- Ketidakleluasaan untuk tabel `tb_sewafilm`
--
ALTER TABLE `tb_sewafilm`
  ADD CONSTRAINT `tb_sewafilm_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  ADD CONSTRAINT `tb_sewafilm_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `tb_film` (`id_film`);

--
-- Ketidakleluasaan untuk tabel `tb_ulasan`
--
ALTER TABLE `tb_ulasan`
  ADD CONSTRAINT `tb_ulasan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  ADD CONSTRAINT `tb_ulasan_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `tb_film` (`id_film`),
  ADD CONSTRAINT `tb_ulasan_ibfk_3` FOREIGN KEY (`id_balasan`) REFERENCES `tb_ulasan` (`id_ulasan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
