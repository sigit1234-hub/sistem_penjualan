-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 03:40 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemesanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id` int(11) NOT NULL,
  `id_user` int(3) NOT NULL,
  `lengkap` varchar(255) NOT NULL,
  `provinsi` int(3) NOT NULL,
  `kota` int(3) NOT NULL,
  `kecamatan` int(3) NOT NULL,
  `desa` varchar(255) NOT NULL,
  `patokan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id`, `id_user`, `lengkap`, `provinsi`, `kota`, `kecamatan`, `desa`, `patokan`) VALUES
(8, 34, 'RT 04/ RW 05', 33, 3307, 3307010, '3307010013', 'Gang pertama');

-- --------------------------------------------------------

--
-- Table structure for table `gambar_produk`
--

CREATE TABLE `gambar_produk` (
  `id_gambar` int(11) NOT NULL,
  `kode_produk` varchar(25) NOT NULL,
  `nama_gambar` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gambar_produk`
--

INSERT INTO `gambar_produk` (`id_gambar`, `kode_produk`, `nama_gambar`, `is_active`) VALUES
(95, 'P0001', 'Sample-Keripik-Pisang.png', 1),
(96, 'P0001', 'Sample-Keripik-Pisang1.pn', 1),
(97, 'P0001', 'Sample-Keripik-Pisang2.pn', 1),
(98, 'P0001', 'Sample-Keripik-Pisang3.pn', 1),
(99, 'P0002', 'Sample-Peyek-1024x1024.png', 1),
(100, 'P0002', 'Sample-Peyek-1024x10241.png', 1),
(101, 'P0002', 'Sample-Peyek-1024x10242.png', 1),
(102, 'P0003', 'Sample-Peyek-1024x10243.png', 1),
(103, 'P0003', 'Sample-Peyek-1024x10244.png', 1),
(104, 'P0003', 'Sample-Peyek-1024x10245.png', 1),
(105, 'P0003', 'Sample-Peyek-1024x10246.png', 1),
(106, 'P0004', 'Sample-Peyek-1024x10247.png', 1),
(107, 'P0004', 'Sample-Peyek-1024x10248.png', 1),
(108, 'P0004', 'Sample-Peyek-1024x10249.png', 1),
(109, 'P0004', 'Sample-Peyek-1024x102410.png', 1),
(110, 'P0005', 'Sample-Keripik-Pisang4.png', 1),
(111, 'P0005', 'Sample-Keripik-Pisang5.png', 1),
(112, 'P0006', '899489f8210f7efb680b9b8c7645a515.png', 1),
(113, 'P0006', '899489f8210f7efb680b9b8c7645a5151.png', 1),
(114, 'P0007', 'images.png', 1),
(115, 'P0007', 'images1.png', 1),
(116, 'P0008', 'images2.png', 1),
(117, 'P0008', 'images3.png', 1),
(118, 'P0009', 'lg_62bab85d64b01.jpg', 1),
(119, 'P0009', 'lg_62bab85d64b011.jpg', 1),
(120, 'P0010', 'lg_62bab85d64b012.jpg', 1),
(121, 'P0010', 'lg_62bab85d64b013.jpg', 1),
(122, 'P0011', '20230701211421-64a034bd3ad84-screenshot-2023-07-01-211333.png', 1),
(123, 'P0011', '20230701211421-64a034bd3ad84-screenshot-2023-07-01-2113331.png', 1),
(124, 'P0012', '20230701211421-64a034bd3ad84-screenshot-2023-07-01-2113332.png', 1),
(125, 'P0012', '20230701211421-64a034bd3ad84-screenshot-2023-07-01-2113333.png', 1),
(126, 'P0013', '70947852476f5a219fe4e372362c886e_jpg_720x720q80.jpg', 1),
(127, 'P0013', '70947852476f5a219fe4e372362c886e_jpg_720x720q801.jpg', 1),
(128, 'P0014', '70947852476f5a219fe4e372362c886e_jpg_720x720q802.jpg', 1),
(129, 'P0014', '70947852476f5a219fe4e372362c886e_jpg_720x720q803.jpg', 1),
(130, 'P0015', 'Keripik_Pisang_Sweet_sugar.jpg', 1),
(132, 'P0016', '6096c93f-16c0-42ae-83e3-17d1cdd3b553.jpg', 1),
(133, 'P0017', 'thai_tea.png', 1),
(134, 'P0018', 'images.jpg', 1),
(135, 'P0018', 'images1.jpg', 1),
(136, 'P0019', 'oasis.jpg', 1),
(137, 'P0015', '70947852476f5a219fe4e372362c886e_jpg_720x720q804.jpg', 1),
(138, 'P0015', 'images4.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `is_active`) VALUES
(21, 'Cemilan Ringan', 1),
(22, 'Minuman', 1),
(23, 'Makanan', 1),
(24, 'Kue Kering', 1),
(25, 'Brownis', 1);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_produk` int(2) NOT NULL,
  `id_user` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `checked` int(1) NOT NULL,
  `date_created` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_produk`, `id_user`, `jumlah`, `checked`, `date_created`) VALUES
(45, 26, 34, 3, 1, '2024-01-11 19:00:33'),
(46, 28, 34, 2, 0, '2024-01-11 19:00:40'),
(47, 24, 34, 12, 0, '2024-01-18 17:07:31'),
(48, 16, 34, 5, 0, '2024-01-18 15:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(8) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori` int(1) NOT NULL,
  `harga` int(25) NOT NULL,
  `diskon` int(25) NOT NULL,
  `berat` int(5) NOT NULL,
  `deskripsi` varchar(2000) NOT NULL,
  `stok` int(25) NOT NULL,
  `tgl_input` varchar(25) NOT NULL,
  `id_petugas` int(2) NOT NULL,
  `tgl_update` varchar(25) NOT NULL,
  `id_updatePetugas` int(2) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `kategori`, `harga`, `diskon`, `berat`, `deskripsi`, `stok`, `tgl_input`, `id_petugas`, `tgl_update`, `id_updatePetugas`, `is_active`) VALUES
(15, 'P0001', 'Kripik pisang- ngehe', 21, 17500, 0, 500, 'kripik pisang panggang', 1000, '2024-01-11 18:00:59', 34, '', 0, 1),
(16, 'P0002', 'Peyek Kece -  snack nusantara', 0, 15000, 0, 500, 'Peyek Kece\r\n\r\nberat : 500 gram', 1000, '2024-01-11 18:06:25', 34, '', 0, 1),
(17, 'P0003', 'Peyek Kece -  snack nusantara 1kg', 0, 25000, 0, 1000, 'Peyek Kece \r\n\r\nBerat  : 1kg', 1000, '2024-01-11 18:09:02', 34, '2024-01-11 18:10:52', 34, 1),
(18, 'P0004', 'Peyek Kece -  snack nusantara 2kg', 0, 45000, 0, 2000, 'Peyek Kece\r\n\r\nBerat 2kg', 1000, '2024-01-11 18:10:01', 34, '2024-01-11 18:11:20', 34, 1),
(19, 'P0005', 'Kripik pisang- ngehe 2kg', 21, 30000, 0, 2000, 'Berat 2kg', 1000, '2024-01-11 18:12:02', 34, '2024-01-11 18:58:59', 34, 1),
(21, 'P0006', 'Brownis Coklat', 25, 45000, 0, 250, 'Brownis coklat 25o gram', 50, '2024-01-11 18:17:23', 34, '2024-01-11 18:58:47', 34, 1),
(22, 'P0007', 'Kripik Kentang 250 Gram', 21, 15000, 0, 250, 'Berat 250 gram', 1000, '2024-01-11 18:18:15', 34, '2024-01-11 18:58:33', 34, 1),
(23, 'P0008', 'Kripik Kentang 1000 Gram', 21, 60000, 0, 1000, 'Berat : 1kg', 1000, '2024-01-11 18:18:53', 34, '2024-01-11 18:55:17', 34, 1),
(24, 'P0009', 'Kripik Pisang balado 250 gram', 21, 35000, 500, 250, 'Berat 250 gram', 1000, '2024-01-11 18:19:37', 34, '2024-01-11 18:55:06', 34, 1),
(25, 'P0010', 'Kripik Pisang balado 500 gram', 21, 65000, 5000, 500, 'Berat : 500 gram', 1000, '2024-01-11 18:20:04', 34, '2024-01-11 18:48:00', 34, 1),
(26, 'P0011', 'Kripik Pisang Sang Cau 500gram', 21, 35000, 1000, 500, 'Berat 500 gram', 1000, '2024-01-11 18:20:59', 34, '2024-01-11 18:54:52', 34, 1),
(27, 'P0012', 'Kripik Pisang Sang Cau 100gram', 21, 65000, 5000, 1000, 'Pisang Sang Cau', 1000, '2024-01-11 18:21:26', 34, '2024-01-11 18:47:39', 34, 1),
(28, 'P0013', 'Kripik Pisang Pedas manis 500 gram', 21, 35000, 2000, 500, 'Berat 500 gram', 1000, '2024-01-11 18:22:33', 34, '2024-01-11 18:54:01', 34, 1),
(29, 'P0014', 'Kripik Pisang Pedas manis 1000 gram', 21, 65000, 3000, 1000, 'Berat : 1kg', 1000, '2024-01-11 18:23:00', 34, '2024-01-11 18:59:10', 34, 1),
(30, 'P0015', 'Kripik pisang Dewi 1 KG ', 21, 45000, 4000, 1000, 'Kripik pisang Dewi\r\n\r\nberat 1KG', 1000, '2024-01-11 18:28:28', 34, '2024-01-18 14:04:51', 34, 1),
(31, 'P0016', 'Sandiwara Kopi 600ml', 22, 15000, 0, 250, 'Sandiwara kopi\r\n\r\nkompisisi\r\nair\r\nkopi \r\ngula aren\r\nes', 1000, '2024-01-11 18:32:19', 34, '2024-01-11 18:32:46', 34, 1),
(32, 'P0017', 'ichatan thai tea', 22, 10000, 0, 200, 'thai tea ichita', 1000, '2024-01-11 18:33:18', 34, '2024-01-11 18:35:18', 34, 1),
(33, 'P0018', 'Nu green tea', 22, 5000, 0, 250, 'Nu Green tea ', 100, '2024-01-11 18:46:44', 34, '2024-01-11 18:58:10', 34, 1),
(34, 'P0019', 'Air mineral Oasis', 22, 3000, 0, 250, 'Air mineral oasis', 1000, '2024-01-11 18:50:55', 34, '2024-01-11 18:56:05', 34, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(25) NOT NULL,
  `id_produk` int(3) NOT NULL,
  `id_user` int(3) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `pengiriman` int(1) NOT NULL,
  `date_created` varchar(25) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL,
  `is_active` int(1) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `tlp`, `alamat`, `date_created`, `role_id`, `is_active`, `foto`) VALUES
(30, 'Sigit Prasetyo', 'admin@gmail.com', '$2y$10$E17h5IpYLiGSK3mfJVRTvehQuetEOBH9tITiKI.9w3im/cdkfvItG', '12345', 'Jl. Sanggata 1 No.8, RT.007RW.013, Jatiwaringin', '2024-01-08 14:09:56', 1, 1, 'full_body.jpg'),
(32, 'aku', 'aku@gmail.com', '$2y$10$75XnJHGzjyBw2pW/FreyF.dkVH6.1E.xY0A.Pbnl4IMFI5wNzmoWu', '12423', 'Jl. Sanggata 1 No.8, RT.007RW.013, Jatiwaringin', '2024-01-08 23:10:59', 2, 1, 'foto_sigit4.jpg'),
(33, 'kustomer 1', 'kus@gmail.com', '$2y$10$hyw0qtTPvhBEOib0OQstz.5SVQk8/RXbBAm1BhtHQHi6inrjSYIf.', '085553403930', '', '1704881687', 2, 1, 'default.png'),
(34, 'Akhsan Mirzan al khawarizmi', 'ssprasetyo08@gmail.com', '$2y$10$E17h5IpYLiGSK3mfJVRTvehQuetEOBH9tITiKI.9w3im/cdkfvItG', '085156272172', 'no 3NUSA TENGGARA TIMURKABUPATEN NAGEKEO', '2024-01-19 16:41:19', 1, 1, 'images.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(128) NOT NULL,
  `menu_id` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(49, 1, 1),
(50, 1, 2),
(51, 1, 3),
(52, 1, 4),
(53, 1, 5),
(54, 1, 6),
(55, 2, 1),
(56, 2, 2),
(57, 2, 3),
(58, 2, 4),
(59, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `nama_menu` varchar(128) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `nama_menu`, `link`) VALUES
(1, 'Home', 'Beranda', 'Home'),
(2, 'Belanja', 'Belanja', 'Belanja'),
(3, 'Page', 'Keranjang', 'Keranjang'),
(4, 'Pesanan', 'Pesanan Saya', 'Pesanan'),
(5, 'Akun', 'Akun Saya', 'Akun/updateAkun'),
(6, 'Admin', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Dashboard'),
(2, 'Akun'),
(3, 'Produk'),
(4, 'Menu');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(256) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL,
  `label` varchar(128) NOT NULL,
  `isi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`, `label`, `isi`) VALUES
(2, 1, 'Dashboard', 'Admin', 'bx-home-circle', 1, '', ''),
(3, 1, 'Lihat Website', 'Home', 'bx-log-in-circle', 1, '', ''),
(4, 2, 'Data User', 'Admin/user', 'bx-user', 1, 'label label-pill label-primary float-right', ''),
(24, 3, 'Data Produk', 'Admin/produk', 'bx-news', 1, '', ''),
(25, 3, 'Kategori Produk', 'Admin/kategori', 'bx-pie-chart-alt', 1, '', ''),
(36, 4, 'Slider', 'Admin/sliders', 'bx-shape-triangle', 0, '', ''),
(51, 4, 'Banner', 'Admin/banner', 'bx-shape-triangle', 0, 'label pull-right bg-blue', ''),
(52, 4, 'Menu', 'Admin/menu', 'bx-file', 0, 'label pull-right bg-blue', ''),
(72, 3, 'Data Transaksi', 'Admin/transaksi', 'bx-pie-chart-alt', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_created` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(13, 'a@gmail.com', 'V4K0EOwAYVrZ3mbe1+DLgm99Yxkmgp/GH5ytRU6RSMI=', '1699971853'),
(16, 'user@mail.com', 'iOUBEGZW5UNkJ+xKaz6rvqIYN0+cFR6zP7MlhoPR/b8=', '1704642760'),
(17, 'kus@gmail.com', 'RLoi4qeGDHBdS/BdZSxwu4+0dmXc2Xqgr3Sifo2jQ/M=', '1704881687');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD PRIMARY KEY (`id_gambar`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
