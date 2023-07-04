-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 11:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aset_unira`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `no_anggota` varchar(20) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `level` enum('Karyawan','Mahasiswa') NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `no_anggota`, `nama_anggota`, `no_hp`, `level`, `unit_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, '323892', 'Bambang', NULL, 'Karyawan', 52, 'admin1', '2023-05-07 10:43:09', 'admin1', '2023-06-19 17:25:07', NULL, NULL),
(2, '323213', 'Irenna', NULL, 'Karyawan', 34, 'admin1', '2023-05-07 11:25:19', NULL, NULL, NULL, NULL),
(3, '12121', 'Lintang Kawuriyan', NULL, 'Karyawan', 35, 'admin1', '2023-05-09 14:52:08', NULL, NULL, NULL, NULL),
(4, '23123444', 'Rohman', NULL, 'Mahasiswa', 46, 'admin1', '2023-05-12 13:05:16', 'admin1', '2023-05-25 00:55:52', NULL, NULL),
(5, '23143243', 'Cinta', '087654321443', 'Mahasiswa', 42, 'admin1', '2023-05-24 23:44:20', 'admin1', '2023-05-25 00:55:51', NULL, NULL),
(6, '2312344442', 'Boby', '09819324', 'Mahasiswa', 50, 'admin1', '2023-06-07 05:14:45', NULL, NULL, NULL, NULL),
(7, '1967789929', 'Indri', '088793889098', 'Mahasiswa', 48, 'admin1', '2023-06-11 11:29:54', NULL, NULL, NULL, NULL),
(8, '9304903488', 'Ramadhan Sananta', '09883989900', 'Mahasiswa', 47, 'admin1', '2023-06-20 10:27:10', NULL, NULL, NULL, NULL),
(22, '894893242', 'Ridwan Kamil', '088994839843', 'Mahasiswa', 32, NULL, NULL, 'admin1', '2023-06-22 22:59:43', NULL, NULL),
(32, '4034309034', 'Leni Sylviani', '09045584985', 'Mahasiswa', 40, 'admin1', '2023-06-23 10:54:52', NULL, NULL, NULL, NULL),
(33, '2020212122', 'Aris Indarto', '088789987765', 'Mahasiswa', 47, 'admin1', '2023-06-30 21:49:02', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kat_id` int(11) NOT NULL,
  `kode_brg` varchar(20) NOT NULL,
  `nama_brg` varchar(255) NOT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `asal` varchar(20) DEFAULT NULL,
  `harga_beli` decimal(14,0) DEFAULT NULL,
  `harga_jual` decimal(14,0) DEFAULT NULL,
  `toko` varchar(50) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `no_seri` varchar(100) DEFAULT NULL,
  `no_dokumen` varchar(100) DEFAULT NULL,
  `foto_barang` varchar(100) DEFAULT NULL,
  `tgl_pembelian` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kat_id`, `kode_brg`, `nama_brg`, `merk`, `warna`, `tipe`, `asal`, `harga_beli`, `harga_jual`, `toko`, `instansi`, `no_seri`, `no_dokumen`, `foto_barang`, `tgl_pembelian`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 185, 'PKB.0010.001', 'Tissue 250 sheets', 'Paseo', 'putih', NULL, 'Beli baru', '20000', '20000', 'Indomaret', '', '', '', NULL, '2023-05-07', 'admin1', '2023-05-07 10:35:09', NULL, NULL, NULL, NULL),
(2, 170, 'ATK.0020.001', 'Kertas HVS A4', 'Sinar Dunia', 'putih', NULL, 'Beli baru', '50000', '50000', 'ATK pojoksatu', '', '', '', NULL, '2023-05-07', 'admin1', '2023-05-07 10:37:21', NULL, NULL, NULL, NULL),
(3, 206, 'ELK.0020.001', 'Tinta Printer Hitam EPSON', 'EPSON', 'hitam', NULL, 'Beli baru', '30000', '30000', 'Dockom Kepanjen', '', '', '', NULL, '2023-05-07', 'admin1', '2023-05-07 10:37:21', NULL, NULL, NULL, NULL),
(4, 197, 'ELK.0011.001', 'Kabel HDMI Male to male 1,5 meter', 'HDMI', 'hitam', 'Male to male 1,5 meter', 'Beli baru', '10000', '10000', 'Dockom Kepanjen', '', '', '', NULL, '2023-05-07', 'admin1', '2023-05-07 10:42:13', NULL, NULL, NULL, NULL),
(5, 140, 'D.02.01.001', 'Epson EB-X06 XGA 3LCD Projector', 'Epson', 'putih', 'EB-X06 XGA 3', 'Beli baru', '5595000', '5592000', 'Dockom Kepanjen', '', '', '', '1683506145_142cc2d9c3eb8fa5e263.png', '2023-05-04', 'admin1', '2023-05-08 00:30:26', 'admin1', '2023-05-08 00:35:45', NULL, NULL),
(6, 101, 'C.03.04.001', 'Kabel Roll 20Mtr Yunior - NEW TURBO LY-118SK', 'Loyal Yunior', 'hitam', '20Mtr NEW TURBO LY-118SK', 'Beli baru', '100000', '100000', 'Tokopedia', '', '', '', '1683506125_5dc6dcad2fcfc067652c.png', '2023-05-01', 'admin1', '2023-05-08 00:30:26', 'admin1', '2023-05-08 00:35:25', NULL, NULL),
(7, 92, 'C.02.06.01.001', 'Printer Epson L3110 ', 'EPSON', 'hitam', 'L3110 ', 'Beli baru', '3000000', '2500000', 'Dockom Kepanjen', '', '', '', '1685532286_ef0b86d9b94fd61b6bd9.png', '2023-05-17', 'admin1', '2023-05-17 11:38:22', 'admin1', '2023-05-31 11:24:46', NULL, NULL),
(8, 141, 'D.02.02.001', 'Monitor LG 21Inch', 'LG', 'hitam', 'Monitor LG 21Inch', 'Beli baru', '5000000', '4500000', 'Dockom Kepanjen', '', '', '', '1686585247_8d7482d68ac5f4b6f681.png', '2023-05-17', 'admin1', '2023-05-17 11:38:23', 'admin1', '2023-06-12 15:54:07', NULL, NULL),
(9, 89, 'C.02.03.001', 'Robot KM3100 Wireless Keyboard', 'Robot', 'hitam', 'KM3100 Wireless ', 'Beli baru', '140000', '140000', 'Tokopedia', '', '', '', NULL, '2023-05-29', 'admin1', '2023-05-29 02:16:24', 'admin1', '2023-05-29 05:57:26', NULL, NULL),
(10, 206, 'ELK.0020.002', 'Tinta printer EPSON biru', 'EPSON', 'biru', '', 'Beli baru', '50000', '50000', 'Dockom Kepanjen', '', '', '', NULL, '2023-05-29', 'admin1', '2023-05-29 02:36:31', 'admin1', '2023-06-16 13:26:30', NULL, NULL),
(11, 70, 'C.01.03.04.001', 'Kursi kuliah lipat stainless olympic', 'olympic', 'putih', NULL, 'Beli baru', '130000', '130000', 'olympic garden', '', '', '', '1685893848_dbd3f7b77b6abee42859.png', '2023-05-31', 'admin1', '2023-05-31 06:48:21', 'admin1', '2023-06-04 15:50:48', NULL, NULL),
(12, 106, 'C.03.09.001', 'Kulkas  LG abu-abu', 'LG', 'abu-abu', '', 'Beli baru', '4000000', '3500000', 'Toko Sri Rejeki', '', '', '', NULL, '2023-06-07', 'admin1', '2023-06-07 02:26:05', 'admin1', '2023-06-16 14:46:36', NULL, NULL),
(13, 106, 'C.03.09.002', 'Kulkas  Panasonic NR-BB221Q-PK - Hitam  ', 'Panasonic', 'hitam', 'NR-BB221Q-PK', 'Beli baru', '4500000', '4000000', 'Toko Barokah', '', '', '', '1687663704_de99aeeabdfbd8565f66.png', '2023-06-15', 'admin1', '2023-06-15 07:33:30', 'admin1', '2023-06-25 10:28:24', NULL, NULL),
(14, 76, 'C.01.03.10.001', 'Kursi Sofa Olympic merah tipe panjang', 'Olympic', 'merah', 'tipe panjang', 'Beli baru', '900000', '900000', 'Toko Abadi', '', '', '', NULL, '2023-06-15', 'admin1', '2023-06-15 07:33:30', 'admin1', '2023-06-20 17:13:07', 'admin1', '2023-06-20 17:13:07'),
(16, 156, 'ATK.0006.001', 'Spidol Snowman hitam permanen', 'Snowman', 'hitam', 'permanen', 'Beli baru', '5000', '5000', 'ATK pojoksatu', '', '', '', NULL, '2023-06-23', 'admin1', '2023-06-23 11:16:24', NULL, NULL, NULL, NULL),
(17, 156, 'ATK.0006.002', 'Spidol Snowman biru permanen', 'Snowman', 'biru', 'permanen', 'Beli baru', '5000', '5000', 'ATK Pojoksatu', '', '', '', NULL, '2023-06-23', 'admin1', '2023-06-23 11:16:24', NULL, NULL, NULL, NULL),
(18, 156, 'ATK.0006.003', 'Spidol snowman merah whiteboard', 'snowman', 'merah', 'whiteboard', 'Beli baru', '5000', '5000', 'ATK pojoksatu', '', '', '', NULL, '2023-06-23', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL),
(19, 156, 'ATK.0006.004', 'Spidol Snowman pink whiteboard', 'Snowman', 'pink', 'whiteboard', 'Beli baru', '5000', '5000', 'ATK Pojoksatu', '', '', '', NULL, '2023-06-23', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gedung`
--

CREATE TABLE `gedung` (
  `id` int(11) NOT NULL,
  `kat_id` int(11) NOT NULL,
  `nama_gedung` varchar(50) NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gedung`
--

INSERT INTO `gedung` (`id`, `kat_id`, `nama_gedung`, `prefix`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 7, 'KH. Mahmud Zubaidi', 'A', 'admin1', '2023-03-04 10:10:25', NULL, NULL, NULL, NULL),
(2, 8, 'KH. M. Tolchah Hasan', 'B', 'admin1', '2023-03-04 10:12:07', NULL, NULL, NULL, NULL),
(3, 9, 'KH. M. Tolchah Hasan', 'C', 'admin1', '2023-03-04 10:12:07', NULL, NULL, NULL, NULL),
(4, 8, 'ghfghgh', 'yuryutu', 'admin1', '2023-03-13 11:05:00', 'admin1', '2023-03-13 15:10:04', 'admin1', '2023-03-13 15:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kd_kategori` varchar(50) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis` enum('Barang Tetap','Barang Persediaan') NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kd_kategori`, `nama_kategori`, `deskripsi`, `jenis`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'A', 'Tanah dan Bangunan', 'Kategori A meliputi Tanah dan Bangunan yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', 'admin1', '2023-04-11 12:10:28', NULL, NULL),
(2, 'A.01', 'Tanah ', 'Kategori A.01 meliputi Tanah  yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(3, 'A.01.01', 'Tanah Kampus I', 'Kategori A.01.01 meliputi Tanah Kampus I yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(4, 'A.01.02 ', 'Tanah Kampus II ', 'Kategori A.01.02  meliputi Tanah Kampus II  yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(5, 'A.02', 'Bangunan', 'Kategori A.02 meliputi Bangunan yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(6, 'A.02.01', 'Bangunan Kampus I', 'Kategori A.02.01 meliputi Bangunan Kampus I  yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(7, 'A.02.01.01', 'Gedung A', 'Kategori A.02.01.01 meliputi Gedung A yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(8, 'A.02.01.02', 'Gedung B', 'Kategori A.02.01.02 meliputi Gedung B yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(9, 'A.02.01.03', 'Gedung C', 'Kategori A.02.01.03 meliputi Gedung C yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(10, 'A.02.01.04', 'Pos Keamanan', 'Kategori A.02.01.04 meliputi Pos Keamanan yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(11, 'A.03', 'Bangunan Tempat Tinggal', 'Kategori A.03 meliputi Bangunan Tempat Tinggal  yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(12, 'A.03.01', 'Rusunawa ', 'Kategori A.03.01 meliputi Rusunawa  yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(13, 'B', 'Alat-alat', 'Kategori B meliputi Alat-alat yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(14, 'B.01', 'Alat Besar ', 'Kategori B.01 meliputi Alat Besar  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(15, 'B.02', 'Alat-Alat Laboratorium ', 'Kategori B.02 meliputi Alat-Alat Laboratorium  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(16, 'B.03', 'Alat Peraga', 'Kategori B.03 meliputi Alat Peraga yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(17, 'B.03.01', 'Alat Peraga Bidang Pendidikan ', 'Kategori B.03.01 meliputi Alat Peraga Bidang Pendidikan  yang merupakan jenis Alat Peraga yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(18, 'B.04', 'Alat Kesenian/Musik', 'Kategori B.04 meliputi Alat Kesenian/Musik yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(19, 'B.04.01', 'Alat Musik Modern', 'Kategori B.04.01 meliputi Alat Musik Modern yang merupakan jenis Alat Kesenian/Musik yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(20, 'B.04.02', 'Alat Musik Tradisional', 'Kategori B.04.02 meliputi Alat Musik Tradisional yang merupakan jenis Alat Kesenian/Musik yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(21, 'B.05', 'Alat Olahraga ', 'Kategori B.05 meliputi Alat Olahraga  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(22, 'B.06', 'Alat Telekomunikasi ', 'Kategori B.06 meliputi Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(23, 'B.06.01', 'Operator Set ', 'Kategori B.06.01 meliputi Operator Set  yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(24, 'B.06.02', 'Pesawat Telephone/HP ', 'Kategori B.06.02 meliputi Pesawat Telephone/HP  yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(25, 'B.06.03', 'Handy Talky ', 'Kategori B.06.03 meliputi Handy Talky  yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(26, 'B.06.04', 'Camera Video Conference', 'Kategori B.06.04 meliputi Camera Video Conference yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(27, 'B.07', 'Alat Kesehatan', 'Kategori B.07 meliputi Alat Kesehatan yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(28, 'B.07.01', 'Termometer Badan', 'Kategori B.07.01 meliputi Termometer Badan yang merupakan jenis Alat Kesehatan yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(29, 'C', 'Peralatan Kantor', 'Kategori C meliputi Peralatan Kantor yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(30, 'C.01', 'Mebeler ', 'Kategori C.01 meliputi Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(31, 'C.01.01', 'Almari', 'Kategori C.01.01 meliputi Almari yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(32, 'C.01.01.01', 'Lemari Rak Besar / Rak Buku Besar', 'Kategori C.01.01.01 meliputi Lemari Rak Besar / Rak Buku Besar yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(33, 'C.01.01.02', 'Lemari Rak Sedang  / Rak Buku Sedang', 'Kategori C.01.01.02 meliputi Lemari Rak Sedang  / Rak Buku Sedang yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(34, 'C.01.01.03', 'Lemari Rak Kecil / Rak Buku Kecil', 'Kategori C.01.01.03 meliputi Lemari Rak Kecil / Rak Buku Kecil yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(35, 'C.01.01.04', 'Lemari Arsip Besar ', 'Kategori C.01.01.04 meliputi Lemari Arsip Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(36, 'C.01.01.05', 'Lemari Arsip Sedang', 'Kategori C.01.01.05 meliputi Lemari Arsip Sedang yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(37, 'C.01.01.06', 'Lemari Arsip Kecil ', 'Kategori C.01.01.06 meliputi Lemari Arsip Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(38, 'C.01.01.07', 'Lemari Arsip Besi Besar ', 'Kategori C.01.01.07 meliputi Lemari Arsip Besi Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(39, 'C.01.01.08', 'Lemari Arsip Besi Sedang ', 'Kategori C.01.01.08 meliputi Lemari Arsip Besi Sedang  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(40, 'C.01.01.09', 'Lemari Arsip Besi Kecil ', 'Kategori C.01.01.09 meliputi Lemari Arsip Besi Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(41, 'C.01.01.10', 'Lemari Barang Besar ', 'Kategori C.01.01.10 meliputi Lemari Barang Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(42, 'C.01.01.11', 'Lemari Barang Sedang ', 'Kategori C.01.01.11 meliputi Lemari Barang Sedang  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(43, 'C.01.01.12', 'Lemari Barang Kecil', 'Kategori C.01.01.12 meliputi Lemari Barang Kecil yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(44, 'C.01.01.13', 'Lemari File Kabinet Besar', 'Kategori C.01.01.13 meliputi Lemari File Kabinet Besar yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(45, 'C.01.01.14', 'Lemari File Kabinet Sedang', 'Kategori C.01.01.14 meliputi Lemari File Kabinet Sedang yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(46, 'C.01.01.15', 'Lemari File Kabinet Kecil ', 'Kategori C.01.01.15 meliputi Lemari File Kabinet Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(47, 'C.01.01.16', 'Lemari Alat Besar ', 'Kategori C.01.01.16 meliputi Lemari Alat Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(48, 'C.01.01.17', 'Lemari Alat Sedang ', 'Kategori C.01.01.17 meliputi Lemari Alat Sedang  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(49, 'C.01.01.18', 'Lemari Alat Kecil ', 'Kategori C.01.01.18 meliputi Lemari Alat Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(50, 'C.01.01.19', 'Lemari TV', 'Kategori C.01.01.19 meliputi Lemari TV yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(51, 'C.01.01.20', 'Etalase', 'Kategori C.01.01.20 meliputi Etalase yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(52, 'C.01.01.21', 'Brankas', 'Kategori C.01.01.21 meliputi Brankas yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(53, 'C.01.01.22', 'Loker', 'Kategori C.01.01.22 meliputi Loker yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(54, 'C.01.01.23', 'Lemari lain-lain', 'Kategori C.01.01.23 meliputi Lemari lain-lain yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(55, 'C.01.02', 'Meja', 'Kategori C.01.02 meliputi Meja yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(56, 'C.01.02.01', 'Meja 1 Biro ', 'Kategori C.01.02.01 meliputi Meja 1 Biro  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(57, 'C.01.02.02', 'Meja ? Biro ', 'Kategori C.01.02.02 meliputi Meja ? Biro  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(58, 'C.01.02.03', 'Meja Komputer', 'Kategori C.01.02.03 meliputi Meja Komputer yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(59, 'C.01.02.04', 'Meja Laboratorium Besar ', 'Kategori C.01.02.04 meliputi Meja Laboratorium Besar  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(60, 'C.01.02.05', 'Meja Laboratorium Sedang', 'Kategori C.01.02.05 meliputi Meja Laboratorium Sedang yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(61, 'C.01.02.06', 'Meja Laboratorium Kecil ', 'Kategori C.01.02.06 meliputi Meja Laboratorium Kecil  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(62, 'C.01.02.07', 'Meja Sidang Panjang ', 'Kategori C.01.02.07 meliputi Meja Sidang Panjang  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(63, 'C.01.02.08', 'Meja Baca Perpustakaan ', 'Kategori C.01.02.08 meliputi Meja Baca Perpustakaan  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(64, 'C.01.02.09', 'Podium ', 'Kategori C.01.02.09 meliputi Podium  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(65, 'C.01.02.10', 'Meja Front Office Besar', 'Kategori C.01.02.10 meliputi Meja Front Office Besar yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(66, 'C.01.03', 'Kursi ', 'Kategori C.01.03 meliputi Kursi  yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(67, 'C.01.03.01', 'Kursi Putar Eksekutif ', 'Kategori C.01.03.01 meliputi Kursi Putar Eksekutif  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(68, 'C.01.03.02', 'Kursi Putar Biasa ', 'Kategori C.01.03.02 meliputi Kursi Putar Biasa  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(69, 'C.01.03.03', 'Kursi Lipat Stainless ', 'Kategori C.01.03.03 meliputi Kursi Lipat Stainless  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(70, 'C.01.03.04', 'Kursi Kuliah Lipat Stainless ', 'Kategori C.01.03.04 meliputi Kursi Kuliah Lipat Stainless  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(71, 'C.01.03.05', 'Kursi Kuliah Kayu', 'Kategori C.01.03.05 meliputi Kursi Kuliah Kayu yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(72, 'C.01.03.06', 'Kursi Audience ', 'Kategori C.01.03.06 meliputi Kursi Audience  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(73, 'C.01.03.07', 'Kursi Laboratorium Kayu ', 'Kategori C.01.03.07 meliputi Kursi Laboratorium Kayu  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(74, 'C.01.03.08', 'Kursi Laboratorium Besi', 'Kategori C.01.03.08 meliputi Kursi Laboratorium Besi yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(75, 'C.01.03.09', 'Kursi Tunggu', 'Kategori C.01.03.09 meliputi Kursi Tunggu yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(76, 'C.01.03.10', 'Kursi Sofa', 'Kategori C.01.03.10 meliputi Kursi Sofa yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(77, 'C.01.03.11', 'Kursi Lain-Lain', 'Kategori C.01.03.11 meliputi Kursi Lain-Lain yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(78, 'C.01.04', 'Papan Tulis/White Board Gantung ', 'Kategori C.01.04 meliputi Papan Tulis/White Board Gantung  yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(79, 'C.01.04.01', 'Papan Tulis/White Board Gantung Biasa', 'Kategori C.01.04.01 meliputi Papan Tulis/White Board Gantung Biasa yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(80, 'C.01.04.02', 'Papan Tulis/White Board Beroda Besar', 'Kategori C.01.04.02 meliputi Papan Tulis/White Board Beroda Besar yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(81, 'C.01.04.03', 'Papan Pengumuman Besar ', 'Kategori C.01.04.03 meliputi Papan Pengumuman Besar  yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(82, 'C.01.04.04', 'Papan Pengumuman Sedang ', 'Kategori C.01.04.04 meliputi Papan Pengumuman Sedang  yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(83, 'C.01.04.05', 'Papan Pengumuman Kecil ', 'Kategori C.01.04.05 meliputi Papan Pengumuman Kecil  yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(84, 'C.01.04.06', 'Papan Agenda', 'Kategori C.01.04.06 meliputi Papan Agenda yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(85, 'C.01.04.07', 'Benner, Papan Nama, Papan Struktural', 'Kategori C.01.04.07 meliputi Benner, Papan Nama, Papan Struktural yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(86, 'C.02', 'Alat Tulis Elektronik', 'Kategori C.02 meliputi Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(87, 'C.02.01', 'PC All in One', 'Kategori C.02.01 meliputi PC All in One yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(88, 'C.02.02', 'PC', 'Kategori C.02.02 meliputi PC yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(89, 'C.02.03', 'Keyboard', 'Kategori C.02.03 meliputi Keyboard yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(90, 'C.02.04', 'Laptop/Note Book ', 'Kategori C.02.04 meliputi Laptop/Note Book  yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(91, 'C.02.05', 'Mesin Cetak', 'Kategori C.02.05 meliputi Mesin Cetak yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(92, 'C.02.06.01', 'Printer ', 'Kategori C.02.06.01 meliputi Printer  yang termasuk kategori Mesin Cetak dan merupakan jenis Alat Tulis Elektronik dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(93, 'C.02.06.02', 'Printer + Scanner', 'Kategori C.02.06.02 meliputi Printer + Scanner yang termasuk kategori Mesin Cetak dan merupakan jenis Alat Tulis Elektronik dan termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(94, 'C.02.07', 'Scanner ', 'Kategori C.02.07 meliputi Scanner  yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(95, 'C.02.08', 'Finger Print', 'Kategori C.02.08 meliputi Finger Print yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(96, 'C.02.09', 'Scanner Barcode', 'Kategori C.02.09 meliputi Scanner Barcode yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(97, 'C.03', 'Barang Persediaan ', 'Kategori C.03 meliputi Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(98, 'C.03.01', 'Pompa Air ', 'Kategori C.03.01 meliputi Pompa Air  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(99, 'C.03.02', 'Pendingin Ruangan', 'Kategori C.03.02 meliputi Pendingin Ruangan yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(100, 'C.03.03', 'Dispender ', 'Kategori C.03.03 meliputi Dispender  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(101, 'C.03.04', 'Kabel Roll', 'Kategori C.03.04 meliputi Kabel Roll yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(102, 'C.03.05', 'Stavolt ', 'Kategori C.03.05 meliputi Stavolt  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(103, 'C.03.06', 'Layar LCD ', 'Kategori C.03.06 meliputi Layar LCD  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(104, 'C.03.07', 'UPS ', 'Kategori C.03.07 meliputi UPS  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(105, 'C.03.08', 'Karpet ', 'Kategori C.03.08 meliputi Karpet  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(106, 'C.03.09', 'Kulkas ', 'Kategori C.03.09 meliputi Kulkas  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(107, 'C.04', 'Peralatan Rumah Tangga, Wisma dan Asrama ', 'Kategori C.04 meliputi Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(108, 'C.04.01', 'Kasur', 'Kategori C.04.01 meliputi Kasur yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(109, 'C.04.02', 'Bantal', 'Kategori C.04.02 meliputi Bantal  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(110, 'C.04.03', 'Selimut ', 'Kategori C.04.03 meliputi Selimut  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(111, 'C.04.04', 'Sprei ', 'Kategori C.04.04 meliputi Sprei  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(112, 'C.04.05', 'Springbed', 'Kategori C.04.05 meliputi Springbed yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(113, 'C.04.06', 'Korden ', 'Kategori C.04.06 meliputi Korden  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(114, 'C.04.07', 'Peralatan Makan dan Minum ', 'Kategori C.04.07 meliputi Peralatan Makan dan Minum  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(115, 'C.04.08', 'Keset ', 'Kategori C.04.08 meliputi Keset  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(116, 'C.04.09', 'Tempat sampah ', 'Kategori C.04.09 meliputi Tempat sampah  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(117, 'C.04.10', 'Kompor', 'Kategori C.04.10 meliputi Kompor yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(118, 'C.05', 'Perhiasan Ruangan', 'Kategori C.05 meliputi Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(119, 'C.05.01', 'Lambang Negara', 'Kategori C.05.01 meliputi Lambang Negara  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(120, 'C.05.02', 'Lambang Organisasi', 'Kategori C.05.02 meliputi Lambang Organisasi yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(121, 'C.05.03', 'Lukisan Berbingkai', 'Kategori C.05.03 meliputi Lukisan Berbingkai yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(122, 'C.05.04', 'Peta Dinding ', 'Kategori C.05.04 meliputi Peta Dinding  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(123, 'C.05.05', 'Globe', 'Kategori C.05.05 meliputi Globe yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(124, 'C.05.06', 'Bunga dan Vas ', 'Kategori C.05.06 meliputi Bunga dan Vas  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(125, 'C.05.07', 'Jam Dinding', 'Kategori C.05.07 meliputi Jam Dinding yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(126, 'C.05.08', 'Tropi/Piala ', 'Kategori C.05.08 meliputi Tropi/Piala  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(127, 'C.05.09', 'Sketsel/Pembatas Ruangan', 'Kategori C.05.09 meliputi Sketsel/Pembatas Ruangan yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(128, 'C.05.10', 'Perhiasan ruangan lain-lain ', 'Kategori C.05.10 meliputi Perhiasan ruangan lain-lain  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(129, 'D', 'Audio Visual', 'Kategori D meliputi Audio Visual yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(130, 'D.01', 'Audio ', 'Kategori D.01 meliputi Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(131, 'D.01.01', 'Mic Kabel', 'Kategori D.01.01 meliputi Mic Kabel yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(132, 'D.01.02', 'Mic Wearless ', 'Kategori D.01.01 meliputi Mic Wearless  yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(133, 'D.01.03', 'Speaker', 'Kategori D.01.03 meliputi Speaker yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(134, 'D.01.04', 'Sound Active', 'Kategori D.01.03 meliputi Sound Active yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(135, 'D.01.05', 'Amplifier ', 'Kategori D.01.04 meliputi Amplifier  yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(136, 'D.01.06', 'Headset', 'Kategori D.01.04 meliputi Headset yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(137, 'D.01.07', 'Standing Mic', 'Kategori D.01.04 meliputi Standing Mic yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(138, 'D.01.08', 'Tripod Sound', 'Kategori D.01.04 meliputi Tripod Sound yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(139, 'D.02', 'Visual ', 'Kategori D.02 meliputi Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(140, 'D.02.01', 'LCD Proyektor', 'Kategori D.02.01 meliputi LCD Proyektor yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(141, 'D.02.02', 'Monitor ', 'Kategori D.02.02 meliputi Monitor  yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(142, 'D.02.03', 'Camera Digital ', 'Kategori D.02.03 meliputi Camera Digital  yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(143, 'D.02.04', 'Handycam', 'Kategori D.02.04 meliputi Handycam yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(144, 'D.02.05', 'CCTV', 'Kategori D.02.05 meliputi CCTV yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(145, 'D.03', 'Audio-Visual ', 'Kategori D.03 meliputi Audio-Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(146, 'D.03.01', 'Televisi ', 'Kategori D.03.01 meliputi Televisi  yang merupakan jenis kategori Audio-Visual  yang termasuk Audio Visual di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(147, 'E', 'Kendaraan', 'Kategori E meliputi Kendaraan yang dimiliki oleh UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(148, 'E.01', 'Mobil ', 'Kategori E.01 meliputi Mobil  yang termasuk Kendaraan di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(149, 'B.08', 'Alat-alat lain', 'Kategori B.08 meliputi Alat-alat lain yang termasuk Kendaraan di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-03-21 11:13:14', 'admin1', '2023-04-11 10:29:28', NULL, NULL),
(150, 'ATK', 'Alat Tulis Kantor', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(151, 'ATK.0001', 'Buku catatan', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(152, 'ATK.0002', 'Buku agenda', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(153, 'ATK.0003', 'Buku telepon', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(154, 'ATK.0004', 'Staples', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(155, 'ATK.0005', 'Pensil', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(156, 'ATK.0006', 'Spidol', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(157, 'ATK.0007', 'Papan tulis', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(158, 'ATK.0008', 'Penghapus papan tulis', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(159, 'ATK.0009', 'Stapler', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(160, 'ATK.0010', 'Gunting kertas', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(161, 'ATK.0011', 'Cutter', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(162, 'ATK.0012', 'Lem', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(163, 'ATK.0013', 'Amplop', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(164, 'ATK.0014', 'Kertas foto', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(165, 'ATK.0015', 'Stempel', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(166, 'ATK.0016', 'Bolpoin', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(167, 'ATK.0017', 'Kertas Fax Roll', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(168, 'ATK.0018', 'Penghapus Karet', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(169, 'ATK.0019', 'Tipe-X', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(170, 'ATK.0020', 'Kertas HVS', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(171, 'ATK.0021', 'Kertas Folio', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(172, 'ATK.0022', 'Map Berwarna', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(173, 'ATK.0023', 'Map Kertas', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(174, 'ATK.0024', 'Kalkulator', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(175, 'PKB', 'Peralatan Kebersihan', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(176, 'PKB.0001', 'Sabun', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(177, 'PKB.0002', 'Cairan Pewangi', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(178, 'PKB.0003', 'Cairan Pembersih', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(179, 'PKB.0004', 'Pengharum', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(180, 'PKB.0005', 'Sikat toilet', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(181, 'PKB.0006', 'Kain lap', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(182, 'PKB.0007', 'Sapu lantai', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(183, 'PKB.0008', 'Kain pel', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(184, 'PKB.0009', 'Alat penyedot debu', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(185, 'PKB.0010', 'Tissue', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', 'admin1', '2023-04-11 02:28:56', NULL, NULL),
(186, 'ELK', 'Bahan Elektronik', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(187, 'ELK.0001', 'Baterai', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(188, 'ELK.0002', 'Compact Disk (CD)', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(189, 'ELK.0003', 'VCD', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(190, 'ELK.0004', 'DVD', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(191, 'ELK.0005', 'Flashdisk', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(192, 'ELK.0006', 'Headset', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(193, 'ELK.0007', 'Keyboard', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(194, 'ELK.0008', 'Mouse', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(195, 'ELK.0009', 'Mousepad', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(196, 'ELK.0010', 'Earphone', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(197, 'ELK.0011', 'Kabel HDMI', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(198, 'ELK.0012', 'Kabel LAN', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(199, 'ELK.0013', 'Kabel USB', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(200, 'ELK.0014', 'Lampu LED', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(201, 'ELK.0015', 'Lampu pijar', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(202, 'ELK.0016', 'Memory card', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(203, 'ELK.0017', 'Speaker mini', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(204, 'ELK.0018', 'Stabilizer', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(205, 'ELK.0019', 'Kipas angin mini', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(206, 'ELK.0020', 'Tinta printer', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(207, 'ELK.0021', 'Cartridge printer', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(208, 'ELK.0022', 'Toner Printer', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(209, 'ELK.0023', 'Lampu Bohlam', NULL, 'Barang Persediaan', 'admin1', '2023-04-01 17:05:38', NULL, NULL, NULL, NULL),
(282, 'F', 'afdafsjgkljfsgag', 'djaskljdaksjdasjdksd', 'Barang Tetap', 'admin1', '2023-04-02 10:34:53', 'admin1', '2023-04-11 12:10:37', 'admin1', '2023-04-11 12:10:37'),
(283, 'SAD', 'jdsalkjdajsdasd', 'nafdanfmadnfafafad', 'Barang Persediaan', 'admin1', '2023-04-02 10:35:26', 'admin1', '2023-04-19 02:36:32', 'admin1', '2023-04-19 02:36:32'),
(284, 'HJK', 'klsajdkasjd djsklajdlas', 'ioasidoasidopsad', 'Barang Persediaan', 'admin1', '2023-04-02 10:35:50', 'admin1', '2023-04-19 02:36:28', 'admin1', '2023-04-19 02:36:28'),
(285, 'B.01.01', 'Peralatan UKM', 'Kategori B.01.01 meliputi Peralatan UKM yang merupakan jenis Alat Besar yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-04-03 01:36:43', NULL, NULL, NULL, NULL),
(286, 'B.01.02', 'Tiang Stainless', 'Kategori B.01.02 meliputi Tiang Stainless yang merupakan jenis Alat Besar yang termasuk Alat-alat di UNIRA Malang', 'Barang Tetap', 'admin1', '2023-04-03 01:41:06', NULL, NULL, NULL, NULL),
(287, 'B.02.01', 'Mikroskop', 'Mikroskop adalah alat untuk penelitian mikrobakteri', 'Barang Tetap', 'admin1', '2023-06-23 11:08:18', 'admin1', '2023-06-23 11:08:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-03-03-173209', 'App\\Database\\Migrations\\Petugas', 'default', 'App', 1683214280, 1),
(2, '2023-03-03-173210', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1683214280, 1),
(3, '2023-03-03-173211', 'App\\Database\\Migrations\\Gedung', 'default', 'App', 1683214280, 1),
(4, '2023-03-04-031647', 'App\\Database\\Migrations\\Ruang', 'default', 'App', 1683214280, 1),
(5, '2023-03-14-120823', 'App\\Database\\Migrations\\Satuan', 'default', 'App', 1683214280, 1),
(6, '2023-03-14-120843', 'App\\Database\\Migrations\\Barang', 'default', 'App', 1683214280, 1),
(7, '2023-03-23-021627', 'App\\Database\\Migrations\\Unit', 'default', 'App', 1683214280, 1),
(8, '2023-04-01-012947', 'App\\Database\\Migrations\\Stokbarang', 'default', 'App', 1683214379, 2),
(9, '2023-04-01-072016', 'App\\Database\\Migrations\\Riwayatbarang', 'default', 'App', 1683214379, 2),
(10, '2023-04-01-091734', 'App\\Database\\Migrations\\Riwayattransaksi', 'default', 'App', 1683214379, 2),
(11, '2023-05-04-152527', 'App\\Database\\Migrations\\Anggota', 'default', 'App', 1683214379, 2),
(12, '2023-05-04-153226', 'App\\Database\\Migrations\\Peminjaman', 'default', 'App', 1683214379, 2),
(13, '2023-05-04-153231', 'App\\Database\\Migrations\\Permintaan', 'default', 'App', 1683214379, 2),
(14, '2023-06-04-141322', 'App\\Database\\Migrations\\Pelaporan', 'default', 'App', 1685889706, 3),
(15, '2023-06-04-141329', 'App\\Database\\Migrations\\Notifikasi', 'default', 'App', 1685889785, 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `petugas_id` int(11) DEFAULT NULL,
  `viewed_by_admin` int(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `laporan_id`, `petugas_id`, `viewed_by_admin`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(4, 4, NULL, 0, 'Boby', '2023-06-08 01:56:01', 'admin1', '2023-06-14 23:32:45', NULL, NULL),
(5, 5, NULL, 0, 'Indri', '2023-06-11 11:29:54', 'admin1', '2023-06-15 00:29:32', NULL, NULL),
(6, 6, 1, 1, 'Irenna', '2023-06-12 15:56:10', 'admin1', '2023-06-19 10:10:40', NULL, NULL),
(7, 7, 1, 1, 'Lintang Kawuriyan', '2023-06-13 07:46:38', 'admin1', '2023-06-18 12:02:26', 'admin1', '2023-06-19 00:01:25'),
(8, 8, 1, 1, 'Irenna', '2023-06-13 08:09:21', 'admin1', '2023-06-15 08:24:27', 'admin1', '2023-06-19 00:01:25'),
(9, 21, 1, 1, 'Boby', '2023-06-16 00:43:18', 'admin1', '2023-06-18 11:47:07', 'admin1', '2023-06-19 00:01:25'),
(10, 22, 1, 1, 'Ramadhan Sananta', '2023-06-20 10:27:10', 'admin1', '2023-06-23 10:38:30', NULL, NULL),
(20, 34, 3, 1, 'Ridwan Kamil', '2023-06-22 13:40:50', 'dimdimasald15', '2023-06-27 19:57:51', NULL, NULL),
(21, 35, 1, 1, 'Leni Sylviani', '2023-06-23 10:54:52', 'admin1', '2023-06-30 22:30:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelaporan_kerusakan`
--

CREATE TABLE `pelaporan_kerusakan` (
  `id` int(11) NOT NULL,
  `stokbrg_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `no_laporan` varchar(20) NOT NULL,
  `jml_barang` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pelaporan_kerusakan`
--

INSERT INTO `pelaporan_kerusakan` (`id`, `stokbrg_id`, `anggota_id`, `no_laporan`, `jml_barang`, `title`, `deskripsi`, `foto`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(4, 16, 6, 'LP-230608-711946133', 1, 'Laporan kerusakan aset Kursi kuliah lipat stainless olympic di B 2-3A', 'Kerusakan meliputi bagian sandaran busanya terlihat, bagian dudukan juga sudah terlihat busanya.', '1686190017_2e409b5684861de7a35b.png', 'Boby', '2023-06-08 01:56:01', 'admin1', '2023-06-14 23:32:45', NULL, NULL),
(5, 17, 7, 'LP-230611-789593753', 2, 'Laporan kerusakan aset Kursi kuliah lipat stainless olympic di B 2-2A', 'Kursi kulit terkelupas, meja terkelupas, dan rangka sudah peyot.', '1686482994_94af34d5d8a3e4c4230f.png', 'Indri', '2023-06-11 11:29:54', 'admin1', '2023-06-14 23:32:45', NULL, NULL),
(6, 9, 2, 'LP-230611-789593754', 1, 'Laporan kerusakan aset Monitor LG 21Inch di Digital Center', 'Layar bergaris, butuh servis atau pembenahan LCD', '1686585370_4e4d54ec880524d533c4.png', 'Irenna', '2023-06-12 15:56:10', 'admin1', '2023-06-18 12:02:26', NULL, NULL),
(7, 10, 3, 'LP-230613-427468081', 1, 'Laporan kerusakan aset Printer Epson L3110  di Digital Center', 'Catridge printer rusak, perlu perbaikan ke service center printer.', '1686642398_2a18ef3fd3fb98b58c98.png', 'Lintang Kawuriyan', '2023-06-13 07:46:38', 'admin1', '2023-06-18 12:02:26', 'admin1', '2023-06-19 00:01:25'),
(8, 10, 2, 'LP-230613-458802656', 1, 'Laporan kerusakan aset Printer Epson L3110  di Digital Center', 'afdkjfdhsajh jsadhfjsadhfjkdshf jfhdsajhsdaflksadj lksdjkljsakfjsdk jflkdsajfklsajfkjdsakjfkl jasdkfjadksljfksddf', '1686643761_111a7e87920286ff3d96.png', 'Irenna', '2023-06-13 08:09:21', NULL, NULL, 'admin1', '2023-06-19 00:01:25'),
(21, 21, 6, 'LP-230616-978162958', 1, 'Laporan kerusakan aset Kursi Sofa Tipe 8000 di F. Saintek', 'dklajlkdjkjsad kjsa kjksajdksjak djskjdksj kajskjakdjkas dsakjdkjask qweiwoqiowi owqi oilsdalksjd jaskjdkajf', '1686876198_b876278c783eb97a03ed.png', 'Boby', '2023-06-16 00:43:18', NULL, NULL, 'admin1', '2023-06-19 00:01:25'),
(22, 16, 8, 'LP-230620-240028811', 2, 'Laporan kerusakan aset Kursi kuliah lipat stainless olympic di B 2-3A', 'Kursi kuliah rusak terdapat kerusakan pada bagian penyangga punggung karena kulit kursi terkelupas dan sudah terlihat spons-nya. Namun kursi masih bisa dipakai, tetapu dari segi estetika masih kurang layak.', '1687231630_bf758b7813b2845f84a7.png', 'Ramadhan Sananta', '2023-06-20 10:27:10', NULL, NULL, NULL, NULL),
(34, 12, 22, 'LP-230622-423743820', 1, 'Laporan kerusakan aset Printer Epson L3110  di Perpustakaan', 'Ketika printer mencoba mencetak, kertas bisa macet di dalam printer. Ini bisa disebabkan oleh kertas yang terlipat atau tidak rata, penggunaan kertas yang tidak sesuai dengan spesifikasi printer, atau bagian penggerak yang rusak. Kertas macet dapat menyebabkan printer berhenti mencetak dan memerlukan pembersihan atau penggantian bagian yang rusak.', '1688200977_620efb14f012827f427d.png', 'Ridwan Kamil', '2023-06-22 13:40:50', 'Ridwan Kamil', '2023-07-01 15:42:57', NULL, NULL),
(35, 16, 32, 'LP-230623-115776543', 3, 'Laporan kerusakan aset Kursi kuliah lipat stainless olympic di B 2-3A', 'fjlksdjfkljsdkf ksjfkdsajfkjask jksadkfjkdsajfkworiw roiflsdfjksalf', '1687492616_0d8e50ce10b8fccb4157.png', 'Leni Sylviani', '2023-06-23 10:54:52', 'Leni Sylviani', '2023-06-23 10:56:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jml_barang` int(3) NOT NULL,
  `jml_hari` int(3) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `kondisi_pinjam` varchar(20) DEFAULT NULL,
  `kondisi_kembali` varchar(20) DEFAULT NULL,
  `tgl_pinjam` datetime DEFAULT NULL,
  `tgl_kembali` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `anggota_id`, `barang_id`, `jml_barang`, `jml_hari`, `keterangan`, `kondisi_pinjam`, `kondisi_kembali`, `tgl_pinjam`, `tgl_kembali`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(2, 2, 6, 1, 1, 'Keperluan kegiatan F Saintek', 'baik', 'Baik', '2023-05-10 00:00:00', '2023-05-11 00:00:00', 1, 'admin1', '2023-05-09 23:31:20', 'admin1', '2023-05-11 07:33:22', NULL, NULL),
(3, 2, 5, 1, 1, 'Keperluan kegiatan F Saintek', 'baik', 'Baik', '2023-05-10 00:00:00', '2023-05-11 00:00:00', 1, 'admin1', '2023-05-09 23:31:20', 'admin1', '2023-05-11 07:33:22', NULL, NULL),
(4, 1, 6, 1, 29, 'Keperluan kegiatan di LOBI Unira', 'baik', 'Baik', '2023-05-12 13:42:00', '2023-06-10 00:00:00', 1, 'admin1', '2023-05-10 01:28:57', 'admin1', '2023-06-10 01:29:47', NULL, NULL),
(9, 1, 5, 1, 28, 'Keperluan kegiatan di LOBI Unira', 'baik', 'Baik', '2023-05-13 14:45:00', '2023-06-10 00:00:00', 1, 'admin1', '2023-05-13 07:45:58', 'admin1', '2023-06-10 01:30:50', NULL, NULL),
(10, 3, 6, 1, 28, 'Keperluan kegiatan di FIK', 'baik', 'Baik', '2023-05-13 14:46:00', '2023-06-10 00:00:00', 1, 'admin1', '2023-05-13 07:47:01', 'admin1', '2023-06-10 01:28:05', NULL, NULL),
(11, 6, 5, 1, 0, 'Keperluan kegiantan di Pascasarjana', 'baik', 'Baik', '2023-06-15 15:55:00', '2023-06-15 00:00:00', 1, 'admin1', '2023-06-15 08:55:45', 'admin1', '2023-06-15 08:57:09', NULL, NULL),
(12, 2, 6, 1, 1, 'Kegiatan Fakultas Sains dan Teknologi', 'baik', 'Baik', '2023-06-17 14:47:00', '2023-06-18 00:00:00', 1, 'admin1', '2023-06-17 07:48:48', 'admin1', '2023-06-17 07:49:20', NULL, NULL),
(13, 2, 5, 1, 1, 'Kegiatan Fakultas Sains dan Teknologi', 'baik', 'Baik', '2023-06-17 14:47:00', '2023-06-18 00:00:00', 1, 'admin1', '2023-06-17 07:48:48', 'admin1', '2023-06-17 07:49:20', NULL, NULL),
(14, 4, 6, 1, 1, 'Untuk kegiatan Himpunan PGMI', 'baik', 'Baik', '2023-06-18 06:31:00', '2023-06-19 17:06:00', 1, 'admin1', '2023-06-18 06:32:51', 'admin1', '2023-06-19 17:06:57', NULL, NULL),
(15, 8, 5, 1, 2, 'Keperluan belajar mengajar di AULA ', 'baik', 'Baik', '2023-06-21 10:01:00', '2023-06-23 11:02:00', 1, 'admin1', '2023-06-21 22:02:59', 'admin1', '2023-06-23 11:02:41', NULL, NULL),
(16, 8, 9, 1, 2, 'Keperluan belajar mengajar di AULA ', 'baik', 'Baik', '2023-06-21 10:01:00', '2023-06-23 13:59:00', 1, 'admin1', '2023-06-21 22:02:59', 'admin1', '2023-06-30 13:59:30', NULL, NULL),
(17, 5, 5, 1, 1, 'Pinjam projector untuk acara HMP Manajemen', 'baik', 'Baik', '2023-06-26 12:42:00', '2023-06-27 16:00:00', 1, 'admin1', '2023-06-26 12:42:35', 'admin1', '2023-06-30 14:34:05', NULL, NULL),
(18, 3, 6, 1, 0, 'Kegiatan FIK', 'baik', NULL, '2023-06-27 08:30:00', NULL, 0, 'admin1', '2023-06-27 05:20:57', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `jml_barang` int(5) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permintaan`
--

INSERT INTO `permintaan` (`id`, `barang_id`, `anggota_id`, `jml_barang`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(12, 2, 3, 1, 'admin1', '2023-06-21 18:22:14', 'admin1', '2023-06-21 21:46:34', NULL, NULL),
(14, 10, 2, 2, 'admin1', '2023-06-21 18:51:15', 'admin1', '2023-06-21 21:47:37', NULL, NULL),
(16, 2, 3, 1, 'admin1', '2023-06-23 11:00:28', NULL, NULL, NULL, NULL),
(17, 1, 3, 1, 'admin1', '2023-06-23 11:00:28', 'admin1', '2023-06-23 11:01:17', NULL, NULL),
(18, 16, 2, 1, 'admin1', '2023-06-24 21:35:14', 'admin1', '2023-06-24 21:35:31', NULL, NULL),
(19, 1, 2, 1, 'admin1', '2023-06-24 21:35:14', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('Administrator','Petugas') NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nip`, `email`, `username`, `password`, `role`, `foto`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, '1111111', 'admin@mail.com', 'admin1', '$2y$10$zsfyuW2EKbUmdSflwBlbwO79HnBbCIMuSF5UxR3dnie.dp6xb5Jhm', 'Administrator', '2.jpg', 'Admin', '2023-03-05 09:28:02', 'admin1', '2023-06-25 06:37:55', NULL, NULL),
(2, '1122334455', 'petugas11@mail.com', 'petugas_keren1', '$2y$10$Cn4h6tFIiu87hqSN42qBIelv4aKDRNh/9Mdw2sFAUaOzCHZvUn7QC', 'Administrator', '', 'admin1', '2023-03-19 16:37:58', 'admin1', '2023-06-09 23:54:30', NULL, NULL),
(3, '1955202026', 'dhymazaldhyz@gmail.com', 'dimdimasald15', '$2y$10$N5797ROJhSj6Q8bUY/50KO2sEN3kYFBZg.Bi4yaFIEXNBuXmde3E6', 'Administrator', '7.jpg', 'admin1', '2023-06-26 14:33:47', 'dimdimasald15', '2023-06-26 14:34:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_barang`
--

CREATE TABLE `riwayat_barang` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `field` varchar(100) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `riwayat_barang`
--

INSERT INTO `riwayat_barang` (`id`, `barang_id`, `field`, `old_value`, `new_value`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(6, 1, 'Semua field', '', '{\"kat_id\":\"185\",\"kode_brg\":\"PKB.0010.001\",\"nama_brg\":\"Tissue 250 sheets\",\"merk\":\"Paseo\",\"warna\":\"#ffffff\",\"asal\":\"Beli baru\",\"toko\":\"Indomaret\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"20000\",\"harga_jual\":\"20000\",\"tgl_pembelian\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:35:09\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:35:09', NULL, NULL, NULL, NULL),
(7, 2, 'Semua field', '', '{\"kat_id\":\"170\",\"kode_brg\":\"ATK.0020.001\",\"nama_brg\":\"Kertas HVS A4\",\"merk\":\"Sinar Dunia\",\"warna\":\"#ffffff\",\"asal\":\"Beli baru\",\"toko\":\"ATK pojoksatu\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"50000\",\"harga_jual\":\"50000\",\"tgl_pembelian\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:37:21\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:37:21', NULL, NULL, NULL, NULL),
(8, 3, 'Semua field', '', '{\"kat_id\":\"206\",\"kode_brg\":\"ELK.0020.001\",\"nama_brg\":\"Tinta Printer Hitam EPSON\",\"merk\":\"EPSON\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Dockom Kepanjen\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"30000\",\"harga_jual\":\"30000\",\"tgl_pembelian\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:37:21\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:37:21', NULL, NULL, NULL, NULL),
(9, 4, 'Semua field', '', '{\"kat_id\":\"197\",\"kode_brg\":\"ELK.0011.001\",\"nama_brg\":\"Kabel HDMI Male to male 1,5 meter\",\"merk\":\"HDMI\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Dockom Kepanjen\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"10000\",\"harga_jual\":\"10000\",\"tgl_pembelian\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:42:13\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:42:13', NULL, NULL, NULL, NULL),
(10, 5, 'Semua field', '', '{\"kat_id\":\"140\",\"kode_brg\":\"D.02.01.001\",\"nama_brg\":\"Epson EB-X06 XGA 3LCD Projector\",\"merk\":\"Epson\",\"warna\":\"#ffffff\",\"asal\":\"Beli baru\",\"toko\":\"Dockom Kepanjen\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"5595000\",\"harga_jual\":\"5592000\",\"tgl_pembelian\":\"2023-05-04\",\"data\":{\"created_at\":\"2023-05-08 00:30:26\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-08 00:30:26', NULL, NULL, NULL, NULL),
(11, 6, 'Semua field', '', '{\"kat_id\":\"101\",\"kode_brg\":\"C.03.04.001\",\"nama_brg\":\"Kabel Roll 20Mtr Yunior - NEW TURBO LY-118SK\",\"merk\":\"Loyal Yunior\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Tokopedia\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"100000\",\"harga_jual\":\"100000\",\"tgl_pembelian\":\"2023-05-01\",\"data\":{\"created_at\":\"2023-05-08 00:30:26\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-08 00:30:26', NULL, NULL, NULL, NULL),
(12, 6, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1683506125_5dc6dcad2fcfc067652c.png\"}', 'admin1', '2023-05-08 00:35:25', NULL, NULL, NULL, NULL),
(13, 5, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1683506145_142cc2d9c3eb8fa5e263.png\"}', 'admin1', '2023-05-08 00:35:45', NULL, NULL, NULL, NULL),
(14, 7, 'Semua field', '', '{\"kat_id\":\"92\",\"kode_brg\":\"C.02.06.01.001\",\"nama_brg\":\"Printer Epson L3110 \",\"merk\":\"EPSON\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Dockom Kepanjen\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"3000000\",\"harga_jual\":\"3000000\",\"tgl_pembelian\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-17 11:38:22\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-17 11:38:22', NULL, NULL, NULL, NULL),
(15, 8, 'Semua field', '', '{\"kat_id\":\"141\",\"kode_brg\":\"D.02.02.001\",\"nama_brg\":\"Monitor LG 21Inch\",\"merk\":\"LG\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Dockom Kepanjen\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"5000000\",\"harga_jual\":\"5000000\",\"tgl_pembelian\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-17 11:38:23\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-17 11:38:23', NULL, NULL, NULL, NULL),
(16, 8, '[\"harga_jual\"]', '{\"harga_jual\":\"5000000\"}', '{\"harga_jual\":\"4500000\"}', 'admin1', '2023-05-27 10:15:00', NULL, NULL, NULL, NULL),
(17, 7, '[\"harga_jual\"]', '{\"harga_jual\":\"3000000\"}', '{\"harga_jual\":\"2500000\"}', 'admin1', '2023-05-27 10:16:49', NULL, NULL, NULL, NULL),
(18, 9, 'Semua field', '', '{\"kat_id\":\"89\",\"kode_brg\":\"C.02.03.001\",\"nama_brg\":\"Robot KM3100 Wireless Keyboard\",\"merk\":\"Robot\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Tokopedia\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"150000\",\"harga_jual\":\"150000\",\"tgl_pembelian\":\"2023-05-29\"}', 'admin1', '2023-05-29 02:16:24', NULL, NULL, NULL, NULL),
(19, 10, 'Semua field', '', '{\"kat_id\":\"206\",\"kode_brg\":\"ELK.0020.002\",\"nama_brg\":\"Tinta Printer Biru EPSON\",\"merk\":\"EPSON\",\"warna\":\"#002aff\",\"asal\":\"Beli baru\",\"toko\":\"Dockom Kepanjen\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"50000\",\"harga_jual\":\"50000\",\"tgl_pembelian\":\"2023-05-29\"}', 'admin1', '2023-05-29 02:36:31', NULL, NULL, NULL, NULL),
(20, 9, '[\"harga_beli\",\"harga_jual\"]', '{\"harga_beli\":\"150000\",\"harga_jual\":\"150000\"}', '{\"harga_beli\":\"140000\",\"harga_jual\":\"140000\"}', 'admin1', '2023-05-29 05:57:26', NULL, NULL, NULL, NULL),
(21, 11, 'Semua field', '', '{\"kat_id\":\"70\",\"kode_brg\":\"C.01.03.04.001\",\"nama_brg\":\"Kursi kuliah olympic\",\"merk\":\"olympic\",\"warna\":\"#ffffff\",\"asal\":\"Beli baru\",\"toko\":\"olympic garden\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"130000\",\"harga_jual\":\"130000\",\"tgl_pembelian\":\"2023-05-31\"}', 'admin1', '2023-05-31 06:48:21', NULL, NULL, NULL, NULL),
(22, 11, '[\"nama_brg\"]', '{\"nama_brg\":\"Kursi kuliah olympic\"}', '{\"nama_brg\":\"Kursi kuliah lipat stainless olympic\"}', 'admin1', '2023-05-31 07:53:33', NULL, NULL, NULL, NULL),
(23, 11, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1685519717_de8b8cbbd655e159c47c.png\"}', 'admin1', '2023-05-31 07:55:17', NULL, NULL, NULL, NULL),
(24, 11, '[\"foto_barang\"]', '{\"foto_barang\":\"1685519717_de8b8cbbd655e159c47c.png\"}', '{\"foto_barang\":\"1685532126_51722243bc27376a25ca.png\"}', 'admin1', '2023-05-31 11:22:06', NULL, NULL, NULL, NULL),
(25, 7, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1685532286_ef0b86d9b94fd61b6bd9.png\"}', 'admin1', '2023-05-31 11:24:46', NULL, NULL, NULL, NULL),
(26, 11, '[\"foto_barang\"]', '{\"foto_barang\":\"1685532126_51722243bc27376a25ca.png\"}', '{\"foto_barang\":\"1685893848_dbd3f7b77b6abee42859.png\"}', 'admin1', '2023-06-04 15:50:48', NULL, NULL, NULL, NULL),
(27, 12, 'Semua field', '', '{\"kat_id\":\"106\",\"kode_brg\":\"C.03.09.001\",\"nama_brg\":\"Kulkas LG 1000 2 pintu\",\"merk\":\"LG\",\"warna\":\"#bababa\",\"asal\":\"Beli baru\",\"toko\":\"Toko Sri Rejeki\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"4000000\",\"harga_jual\":\"3500000\",\"tgl_pembelian\":\"2023-06-07\"}', 'admin1', '2023-06-07 02:26:05', NULL, NULL, NULL, NULL),
(28, 8, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1686585247_8d7482d68ac5f4b6f681.png\"}', 'admin1', '2023-06-12 15:54:07', NULL, NULL, NULL, NULL),
(29, 13, 'Semua field', '', '{\"kat_id\":\"106\",\"kode_brg\":\"C.03.09.002\",\"nama_brg\":\"kulkas panasonic tipe AAAA\",\"merk\":\"Panasonic\",\"warna\":\"#000000\",\"asal\":\"Beli baru\",\"toko\":\"Toko Barokah\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"4000000\",\"harga_jual\":\"4000000\",\"tgl_pembelian\":\"2023-06-15\",\"data\":{\"created_at\":\"2023-06-15 07:33:30\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-15 07:33:30', NULL, NULL, NULL, NULL),
(30, 14, 'Semua field', '', '{\"kat_id\":\"76\",\"kode_brg\":\"C.01.03.10.001\",\"nama_brg\":\"Kursi Sofa Tipe 8000\",\"merk\":\"Olympic\",\"warna\":\"#012900\",\"asal\":\"Beli baru\",\"toko\":\"Toko Abadi\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"900000\",\"harga_jual\":\"900000\",\"tgl_pembelian\":\"2023-06-15\",\"data\":{\"created_at\":\"2023-06-15 07:33:30\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-15 07:33:30', NULL, NULL, NULL, NULL),
(31, 14, '[\"warna\"]', '{\"warna\":\"#012900\"}', '{\"warna\":\"#04ff00\"}', 'admin1', '2023-06-15 07:57:08', NULL, NULL, NULL, NULL),
(32, 14, '[\"warna\"]', '{\"warna\":\"#04ff00\"}', '{\"warna\":\"#050505\"}', 'admin1', '2023-06-15 07:58:31', NULL, NULL, NULL, NULL),
(33, 15, 'Semua field', '', '{\"kat_id\":\"52\",\"kode_brg\":\"C.01.01.21.001\",\"nama_brg\":\"Brankas EPSON hitam 56\",\"merk\":\"EPSON\",\"warna\":\"hitam\",\"asal\":\"Beli baru\",\"toko\":\"AZKom Malang\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"9800000\",\"harga_jual\":\"9800000\",\"tgl_pembelian\":\"2023-06-16\",\"data\":{\"created_at\":\"2023-06-16 12:37:55\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-16 12:37:55', NULL, NULL, NULL, NULL),
(34, 10, '[\"warna\"]', '{\"warna\":\"#002aff\"}', '{\"warna\":\"biru\"}', 'admin1', '2023-06-16 13:10:20', NULL, NULL, NULL, NULL),
(35, 10, '[\"nama_brg\"]', '{\"nama_brg\":\"Tinta Printer Biru EPSON\"}', '{\"nama_brg\":\"Tinta printer EPSON biru\"}', 'admin1', '2023-06-16 13:26:30', NULL, NULL, NULL, NULL),
(36, 14, '[\"nama_brg\",\"warna\"]', '{\"nama_brg\":\"Kursi Sofa Tipe 8000\",\"warna\":\"#050505\"}', '{\"nama_brg\":\"Kursi Sofa Olympic merah tipe panjang\",\"warna\":\"merah\"}', 'admin1', '2023-06-16 14:46:15', NULL, NULL, NULL, NULL),
(37, 12, '[\"nama_brg\",\"warna\"]', '{\"nama_brg\":\"Kulkas LG 1000 2 pintu\",\"warna\":\"#bababa\"}', '{\"nama_brg\":\"Kulkas  LG abu-abu\",\"warna\":\"abu-abu\"}', 'admin1', '2023-06-16 14:46:36', NULL, NULL, NULL, NULL),
(38, 13, '[\"harga_beli\"]', '{\"harga_beli\":\"4000000\"}', '{\"harga_beli\":\"4500000\"}', 'admin1', '2023-06-21 09:32:08', NULL, NULL, NULL, NULL),
(39, 16, 'Semua field', '', '{\"kat_id\":\"156\",\"kode_brg\":\"ATK.0006.001\",\"nama_brg\":\"Spidol Snowman hitam permanen\",\"merk\":\"Snowman\",\"warna\":\"hitam\",\"tipe\":\"permanen\",\"asal\":\"Beli baru\",\"toko\":\"ATK pojoksatu\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"5000\",\"harga_jual\":\"5000\",\"tgl_pembelian\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 11:16:24.400499\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 11:16:24', NULL, NULL, NULL, NULL),
(40, 17, 'Semua field', '', '{\"kat_id\":\"156\",\"kode_brg\":\"ATK.0006.001\",\"nama_brg\":\"Spidol Snowman biru permanen\",\"merk\":\"Snowman\",\"warna\":\"biru\",\"tipe\":\"permanen\",\"asal\":\"Beli baru\",\"toko\":\"ATK Pojoksatu\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"5000\",\"harga_jual\":\"5000\",\"tgl_pembelian\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 11:16:24.419968\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 11:16:24', NULL, NULL, NULL, NULL),
(41, 18, 'Semua field', '', '{\"kat_id\":\"156\",\"kode_brg\":\"ATK.0006.003\",\"nama_brg\":\"Spidol snowman merah whiteboard\",\"merk\":\"snowman\",\"warna\":\"merah\",\"tipe\":\"whiteboard\",\"asal\":\"Beli baru\",\"toko\":\"ATK pojoksatu\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"5000\",\"harga_jual\":\"5000\",\"tgl_pembelian\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 16:05:19.590596\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL),
(42, 19, 'Semua field', '', '{\"kat_id\":\"156\",\"kode_brg\":\"ATK.0006.004\",\"nama_brg\":\"Spidol Snowman pink whiteboard\",\"merk\":\"Snowman\",\"warna\":\"pink\",\"tipe\":\"whiteboard\",\"asal\":\"Beli baru\",\"toko\":\"ATK Pojoksatu\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"5000\",\"harga_jual\":\"5000\",\"tgl_pembelian\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 16:05:19.602807\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL),
(43, 20, 'Semua field', '', '{\"kat_id\":\"106\",\"kode_brg\":\"C.03.09.003\",\"nama_brg\":\"Kulkas  LG 2 Pintu 225Liter Smart Inverter GN-B222SQIB - Abu-abu  \",\"merk\":\"LG\",\"warna\":\"abu-abu\",\"tipe\":\"2 Pintu 225Liter Smart Inverter GN-B222SQIB\",\"asal\":\"Beli baru\",\"toko\":\"AZ Furniture\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"harga_beli\":\"3500000\",\"harga_jual\":\"3500000\",\"tgl_pembelian\":\"2023-06-24\",\"data\":{\"created_at\":{\"date\":\"2023-06-24 19:29:26.383872\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-24 19:29:26', NULL, NULL, NULL, NULL),
(44, 20, '[\"nama_brg\",\"warna\",\"tipe\"]', '{\"nama_brg\":\"Kulkas  LG 2 Pintu 225Liter Smart Inverter GN-B222SQIB - Abu-abu  \",\"warna\":\"abu-abu\",\"tipe\":\"2 Pintu 225Liter Smart Inverter GN-B222SQIB\"}', '{\"nama_brg\":\"Kulkas  LG 2 Pintu 225 L Smart Inverter GN-B222SQIB - Merah  \",\"warna\":\"merah\",\"tipe\":\"2 Pintu 225 L Smart Inverter GN-B222SQIB\"}', 'admin1', '2023-06-24 20:15:46', NULL, NULL, NULL, NULL),
(45, 20, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1687614074_d70de1fdfb12ec17c1d0.png\"}', 'admin1', '2023-06-24 20:41:14', NULL, NULL, NULL, NULL),
(46, 20, '[\"foto_barang\"]', '{\"foto_barang\":\"1687614074_d70de1fdfb12ec17c1d0.png\"}', '{\"foto_barang\":\"1687614315_46393b879388b1ad07bc.png\"}', 'admin1', '2023-06-24 20:45:15', NULL, NULL, NULL, NULL),
(47, 13, '[\"nama_brg\",\"tipe\"]', '{\"nama_brg\":\"kulkas panasonic tipe AAAA\",\"tipe\":\"AAAA\"}', '{\"nama_brg\":\"Kulkas  Panasonic NR-BB221Q-PK - Hitam  \",\"tipe\":\"NR-BB221Q-PK\"}', 'admin1', '2023-06-25 10:27:54', NULL, NULL, NULL, NULL),
(48, 13, '[\"foto_barang\"]', '{\"foto_barang\":null}', '{\"foto_barang\":\"1687663704_de99aeeabdfbd8565f66.png\"}', 'admin1', '2023-06-25 10:28:24', NULL, NULL, NULL, NULL),
(49, 22, 'delete data', '[{\"id\":\"15\",\"kat_id\":\"52\",\"kode_brg\":\"C.01.01.21.001\",\"nama_brg\":\"Brankas EPSON hitam 56\",\"merk\":\"EPSON\",\"warna\":\"hitam\",\"tipe\":null,\"asal\":\"Beli baru\",\"harga_beli\":\"9800000\",\"harga_jual\":\"9800000\",\"toko\":\"AZKom Malang\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"foto_barang\":null,\"tgl_pembelian\":\"2023-06-16\",\"created_by\":\"admin1\",\"created_at\":\"2023-06-16 12:37:55\",\"updated_by\":\"admin1\",\"updated_at\":\"2023-06-20 17:13:07\",\"deleted_by\":\"admin1\",\"deleted_at\":\"2023-06-20 17:13:07\"}]', '', 'admin1', '2023-06-26 18:53:52', NULL, NULL, NULL, NULL),
(50, 28, 'delete data', '[{\"id\":\"20\",\"kat_id\":\"106\",\"kode_brg\":\"C.03.09.003\",\"nama_brg\":\"Kulkas  LG 2 Pintu 225 L Smart Inverter GN-B222SQIB - Merah  \",\"merk\":\"LG\",\"warna\":\"merah\",\"tipe\":\"2 Pintu 225 L Smart Inverter GN-B222SQIB\",\"asal\":\"Beli baru\",\"harga_beli\":\"3500000\",\"harga_jual\":\"3500000\",\"toko\":\"AZ Furniture\",\"instansi\":\"\",\"no_seri\":\"\",\"no_dokumen\":\"\",\"foto_barang\":\"1687614315_46393b879388b1ad07bc.png\",\"tgl_pembelian\":\"2023-06-24\",\"created_by\":\"admin1\",\"created_at\":\"2023-06-24 19:29:26\",\"updated_by\":\"admin1\",\"updated_at\":\"2023-06-26 18:54:07\",\"deleted_by\":\"admin1\",\"deleted_at\":\"2023-06-26 18:54:07\"}]', '', 'admin1', '2023-06-26 18:54:31', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_transaksi`
--

CREATE TABLE `riwayat_transaksi` (
  `id` int(11) NOT NULL,
  `stokbrg_id` int(11) NOT NULL,
  `jenis_transaksi` varchar(50) NOT NULL,
  `field` varchar(100) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `riwayat_transaksi`
--

INSERT INTO `riwayat_transaksi` (`id`, `stokbrg_id`, `jenis_transaksi`, `field`, `old_value`, `new_value`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 'barang persediaan masuk', 'Semua field', '', '{\"barang_id\":1,\"ruang_id\":\"54\",\"satuan_id\":\"1\",\"jumlah_masuk\":\"10\",\"jumlah_keluar\":0,\"sisa_stok\":10,\"tgl_beli\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:35:09\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:35:09', NULL, NULL, NULL, NULL),
(2, 2, 'barang persediaan masuk', 'Semua field', '', '{\"barang_id\":2,\"ruang_id\":\"54\",\"satuan_id\":\"7\",\"jumlah_masuk\":\"5\",\"jumlah_keluar\":0,\"sisa_stok\":5,\"tgl_beli\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:37:21\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:37:21', NULL, NULL, NULL, NULL),
(3, 3, 'barang persediaan masuk', 'Semua field', '', '{\"barang_id\":3,\"ruang_id\":\"54\",\"satuan_id\":\"13\",\"jumlah_masuk\":\"5\",\"jumlah_keluar\":0,\"sisa_stok\":5,\"tgl_beli\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:37:21\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:37:21', NULL, NULL, NULL, NULL),
(4, 4, 'barang persediaan masuk', 'Semua field', '', '{\"barang_id\":4,\"ruang_id\":\"54\",\"satuan_id\":\"1\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":0,\"sisa_stok\":2,\"tgl_beli\":\"2023-05-07\",\"data\":{\"created_at\":\"2023-05-07 10:42:13\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-07 10:42:13', NULL, NULL, NULL, NULL),
(5, 1, 'Permintaan Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":9}', 'admin1', '2023-05-07 10:43:09', NULL, NULL, NULL, NULL),
(6, 2, 'Permintaan Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-07 10:43:09', NULL, NULL, NULL, NULL),
(7, 2, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 10:48:13', NULL, NULL, NULL, NULL),
(8, 1, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":10}', 'admin1', '2023-05-07 10:48:13', NULL, NULL, NULL, NULL),
(9, 2, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', 'admin1', '2023-05-07 10:48:26', NULL, NULL, NULL, NULL),
(10, 1, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', 'admin1', '2023-05-07 10:48:26', NULL, NULL, NULL, NULL),
(11, 2, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 11:01:57', NULL, NULL, NULL, NULL),
(12, 1, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":10}', 'admin1', '2023-05-07 11:01:57', NULL, NULL, NULL, NULL),
(13, 2, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', 'admin1', '2023-05-07 11:02:15', NULL, NULL, NULL, NULL),
(14, 1, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', 'admin1', '2023-05-07 11:02:15', NULL, NULL, NULL, NULL),
(15, 2, 'Permintaan Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-07 11:25:19', NULL, NULL, NULL, NULL),
(16, 2, 'tambah stok barang dari permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-07 11:25:25', NULL, NULL, NULL, NULL),
(17, 2, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 11:25:25', NULL, NULL, NULL, NULL),
(18, 1, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":10}', 'admin1', '2023-05-07 11:25:25', NULL, NULL, NULL, NULL),
(19, 2, 'pemulihan data permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', 'admin1', '2023-05-07 11:25:38', NULL, NULL, NULL, NULL),
(20, 2, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-07 11:29:00', NULL, NULL, NULL, NULL),
(21, 2, 'tambah stok barang dari permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-07 11:31:56', NULL, NULL, NULL, NULL),
(22, 2, 'pemulihan data permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-07 11:42:28', NULL, NULL, NULL, NULL),
(23, 2, 'tambah stok barang dari permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-07 11:44:05', NULL, NULL, NULL, NULL),
(24, 2, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 11:44:05', NULL, NULL, NULL, NULL),
(25, 2, 'pemulihan data permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-07 11:47:33', NULL, NULL, NULL, NULL),
(26, 2, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', 'admin1', '2023-05-07 11:47:38', NULL, NULL, NULL, NULL),
(27, 2, 'tambah stok barang dari permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-07 11:56:54', NULL, NULL, NULL, NULL),
(28, 2, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 11:56:54', NULL, NULL, NULL, NULL),
(29, 2, 'pemulihan data permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', 'admin1', '2023-05-07 12:00:53', NULL, NULL, NULL, NULL),
(30, 1, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', 'admin1', '2023-05-07 12:00:53', NULL, NULL, NULL, NULL),
(31, 2, 'tambah stok barang dari permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 12:04:16', NULL, NULL, NULL, NULL),
(32, 1, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":10}', 'admin1', '2023-05-07 12:04:16', NULL, NULL, NULL, NULL),
(33, 2, 'pemulihan data permintaan 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', 'admin1', '2023-05-07 12:04:22', NULL, NULL, NULL, NULL),
(34, 1, 'pemulihan data permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', 'admin1', '2023-05-07 12:04:22', NULL, NULL, NULL, NULL),
(35, 2, 'tambah stok barang dari permintaan 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-07 12:06:16', NULL, NULL, NULL, NULL),
(36, 1, 'tambah stok barang dari permintaan 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":10}', 'admin1', '2023-05-07 12:06:16', NULL, NULL, NULL, NULL),
(37, 5, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":5,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"3\",\"jumlah_keluar\":0,\"sisa_stok\":3,\"tgl_beli\":\"2023-05-04\",\"data\":{\"created_at\":\"2023-05-08 00:30:26\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-08 00:30:26', NULL, NULL, NULL, NULL),
(38, 6, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":6,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"4\",\"jumlah_keluar\":0,\"sisa_stok\":4,\"tgl_beli\":\"2023-05-01\",\"data\":{\"created_at\":\"2023-05-08 00:30:26\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-08 00:30:26', NULL, NULL, NULL, NULL),
(39, 2, 'Permintaan Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-09 13:48:08', NULL, NULL, NULL, NULL),
(40, 3, 'Permintaan Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-09 13:48:08', NULL, NULL, NULL, NULL),
(41, 2, 'Permintaan Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-09 14:52:08', NULL, NULL, NULL, NULL),
(42, 5, 'Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-09 23:25:57', NULL, NULL, NULL, NULL),
(43, 6, 'Peminjaman Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-09 23:31:20', NULL, NULL, NULL, NULL),
(44, 5, 'Peminjaman Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":1}', 'admin1', '2023-05-09 23:31:20', NULL, NULL, NULL, NULL),
(45, 6, 'Peminjaman Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-05-10 01:28:57', NULL, NULL, NULL, NULL),
(52, 6, 'Pengembalian Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-11 07:33:22', NULL, NULL, NULL, NULL),
(53, 5, 'Pengembalian Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"1\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-11 07:33:22', NULL, NULL, NULL, NULL),
(54, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 06:07:14', NULL, NULL, NULL, NULL),
(55, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":1}', 'admin1', '2023-05-12 06:07:14', NULL, NULL, NULL, NULL),
(57, 5, 'Peminjaman Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-12 06:29:19', NULL, NULL, NULL, NULL),
(59, 5, 'Update Peminjaman Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 06:41:39', NULL, NULL, NULL, NULL),
(60, 6, 'Update Peminjaman Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-05-12 06:41:39', NULL, NULL, NULL, NULL),
(61, 5, 'Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-12 06:45:30', NULL, NULL, NULL, NULL),
(62, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 06:48:15', NULL, NULL, NULL, NULL),
(63, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":1}', 'admin1', '2023-05-12 06:48:15', NULL, NULL, NULL, NULL),
(64, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"1\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 07:13:32', NULL, NULL, NULL, NULL),
(65, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-12 07:13:32', NULL, NULL, NULL, NULL),
(66, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 07:16:02', NULL, NULL, NULL, NULL),
(67, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":1}', 'admin1', '2023-05-12 07:16:02', NULL, NULL, NULL, NULL),
(68, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"1\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 07:16:17', NULL, NULL, NULL, NULL),
(69, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-12 07:16:17', NULL, NULL, NULL, NULL),
(70, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 07:16:37', NULL, NULL, NULL, NULL),
(71, 5, 'Update Peminjaman Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-12 07:16:37', NULL, NULL, NULL, NULL),
(72, 6, 'Update Peminjaman Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', 'admin1', '2023-05-12 07:17:19', NULL, NULL, NULL, NULL),
(73, 6, 'Update Peminjaman Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-12 07:17:19', NULL, NULL, NULL, NULL),
(74, 5, 'tambah stok barang dari peminjaman 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":3}', 'admin1', '2023-05-12 11:26:27', NULL, NULL, NULL, NULL),
(75, 5, 'pemulihan data peminjaman 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', 'admin1', '2023-05-12 12:29:17', NULL, NULL, NULL, NULL),
(198, 2, 'tambah stok barang dari permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:13:26', NULL, NULL, NULL, NULL),
(199, 2, 'tambah stok barang dari permintaan 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-16 02:13:26', NULL, NULL, NULL, NULL),
(200, 2, 'pemulihan data permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:20:09', NULL, NULL, NULL, NULL),
(201, 2, 'pemulihan data permintaan 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-16 02:20:28', NULL, NULL, NULL, NULL),
(202, 2, 'tambah stok barang dari permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:20:40', NULL, NULL, NULL, NULL),
(203, 3, 'tambah stok barang dari permintaan 5', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-16 02:20:40', NULL, NULL, NULL, NULL),
(204, 2, 'tambah stok barang dari permintaan 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-16 02:20:40', NULL, NULL, NULL, NULL),
(205, 2, 'pemulihan data permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:38:50', NULL, NULL, NULL, NULL),
(206, 3, 'pemulihan data permintaan 5', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:38:50', NULL, NULL, NULL, NULL),
(207, 2, 'pemulihan data permintaan 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-16 02:38:50', NULL, NULL, NULL, NULL),
(208, 2, 'tambah stok barang dari permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:52:13', NULL, NULL, NULL, NULL),
(209, 2, 'tambah stok barang dari permintaan 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-05-16 02:52:13', NULL, NULL, NULL, NULL),
(210, 2, 'pemulihan data permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:52:21', NULL, NULL, NULL, NULL),
(211, 2, 'pemulihan data permintaan 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-16 02:52:21', NULL, NULL, NULL, NULL),
(212, 2, 'tambah stok barang dari permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:52:29', NULL, NULL, NULL, NULL),
(213, 2, 'pemulihan data permintaan 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-16 02:52:35', NULL, NULL, NULL, NULL),
(214, 6, 'tambah stok barang dari peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-05-16 02:57:14', NULL, NULL, NULL, NULL),
(215, 5, 'tambah stok barang dari peminjaman 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":3}', 'admin1', '2023-05-16 02:57:14', NULL, NULL, NULL, NULL),
(216, 6, 'tambah stok barang dari peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":-1,\"sisa_stok\":5}', 'admin1', '2023-05-16 02:57:14', NULL, NULL, NULL, NULL),
(217, 6, 'pemulihan data peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-05-16 03:16:30', NULL, NULL, NULL, NULL),
(218, 5, 'pemulihan data peminjaman 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-16 03:17:20', NULL, NULL, NULL, NULL),
(219, 6, 'pemulihan data peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:17:20', NULL, NULL, NULL, NULL),
(220, 6, 'tambah stok barang dari peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-05-16 03:19:05', NULL, NULL, NULL, NULL),
(221, 5, 'tambah stok barang dari peminjaman 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:19:05', NULL, NULL, NULL, NULL),
(222, 6, 'tambah stok barang dari peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":-1,\"sisa_stok\":5}', 'admin1', '2023-05-16 03:19:05', NULL, NULL, NULL, NULL),
(223, 6, 'pemulihan data peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:20:44', NULL, NULL, NULL, NULL),
(224, 5, 'pemulihan data peminjaman 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-16 03:20:44', NULL, NULL, NULL, NULL),
(225, 6, 'pemulihan data peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-05-16 03:20:44', NULL, NULL, NULL, NULL),
(226, 6, 'tambah stok barang dari peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:21:05', NULL, NULL, NULL, NULL),
(227, 6, 'tambah stok barang dari peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-05-16 03:21:05', NULL, NULL, NULL, NULL),
(228, 6, 'pemulihan data peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:21:35', NULL, NULL, NULL, NULL),
(229, 6, 'pemulihan data peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-05-16 03:21:35', NULL, NULL, NULL, NULL),
(230, 6, 'tambah stok barang dari peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:21:51', NULL, NULL, NULL, NULL),
(231, 5, 'tambah stok barang dari peminjaman 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:21:51', NULL, NULL, NULL, NULL),
(232, 6, 'tambah stok barang dari peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-05-16 03:21:51', NULL, NULL, NULL, NULL),
(233, 6, 'pemulihan data peminjaman 10', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-05-16 03:22:01', NULL, NULL, NULL, NULL),
(234, 5, 'pemulihan data peminjaman 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":2}', 'admin1', '2023-05-16 03:22:01', NULL, NULL, NULL, NULL),
(235, 6, 'pemulihan data peminjaman 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-05-16 03:22:01', NULL, NULL, NULL, NULL),
(236, 7, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":7,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"4\",\"jumlah_keluar\":0,\"sisa_stok\":4,\"tgl_beli\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-17 11:38:22\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-17 11:38:23', NULL, NULL, NULL, NULL),
(237, 8, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":8,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"4\",\"jumlah_keluar\":0,\"sisa_stok\":4,\"tgl_beli\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-17 11:38:23\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-17 11:38:23', NULL, NULL, NULL, NULL),
(238, 8, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":\"2\"}', 'admin1', '2023-05-17 11:39:04', NULL, NULL, NULL, NULL),
(239, 9, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"8\",\"ruang_id\":\"43\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":0,\"sisa_stok\":2,\"tgl_beli\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-17 11:39:04\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-17 11:39:04', NULL, NULL, NULL, NULL),
(240, 7, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":\"2\"}', 'admin1', '2023-05-17 11:39:04', NULL, NULL, NULL, NULL),
(241, 10, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"7\",\"ruang_id\":\"43\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":0,\"sisa_stok\":2,\"tgl_beli\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-17 11:39:04\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-17 11:39:04', NULL, NULL, NULL, NULL),
(242, 8, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":\"1\"}', 'admin1', '2023-05-23 06:34:28', NULL, NULL, NULL, NULL),
(243, 11, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"8\",\"ruang_id\":\"44\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"1\",\"jumlah_keluar\":0,\"sisa_stok\":1,\"tgl_beli\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-23 06:34:28\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-23 06:34:28', NULL, NULL, NULL, NULL),
(244, 7, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":\"1\"}', 'admin1', '2023-05-23 06:34:28', NULL, NULL, NULL, NULL),
(245, 12, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"7\",\"ruang_id\":\"44\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"1\",\"jumlah_keluar\":0,\"sisa_stok\":1,\"tgl_beli\":\"2023-05-17\",\"data\":{\"created_at\":\"2023-05-23 06:34:28\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-23 06:34:28', NULL, NULL, NULL, NULL),
(246, 8, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"1\"}', '{\"jumlah_masuk\":4,\"sisa_stok\":1}', 'admin1', '2023-05-27 10:15:00', NULL, NULL, NULL, NULL),
(247, 7, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"1\"}', '{\"jumlah_masuk\":4,\"sisa_stok\":1}', 'admin1', '2023-05-27 10:16:49', NULL, NULL, NULL, NULL),
(248, 13, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":9,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"5\",\"jumlah_keluar\":0,\"sisa_stok\":5,\"tgl_beli\":\"2023-05-29\"}', 'admin1', '2023-05-29 02:16:24', NULL, NULL, NULL, NULL),
(249, 14, 'barang persediaan masuk', 'Semua field', '', '{\"barang_id\":10,\"ruang_id\":\"54\",\"satuan_id\":\"13\",\"jumlah_masuk\":\"4\",\"jumlah_keluar\":0,\"sisa_stok\":4,\"tgl_beli\":\"2023-05-29\"}', 'admin1', '2023-05-29 02:36:31', NULL, NULL, NULL, NULL),
(250, 7, 'Tambah Stok Barang Tetap Masuk di Sarpras', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"1\",\"tgl_beli\":\"2023-05-17\"}', '{\"jumlah_masuk\":6,\"sisa_stok\":3,\"tgl_beli\":\"2023-05-29\"}', 'admin1', '2023-05-29 02:54:06', NULL, NULL, NULL, NULL),
(251, 13, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"5\",\"sisa_stok\":\"5\"}', '{\"jumlah_masuk\":6,\"sisa_stok\":6}', 'admin1', '2023-05-29 05:57:26', NULL, NULL, NULL, NULL),
(257, 15, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":11,\"ruang_id\":\"54\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"100\",\"jumlah_keluar\":0,\"sisa_stok\":100,\"tgl_beli\":\"2023-05-31\"}', 'admin1', '2023-05-31 06:48:21', NULL, NULL, NULL, NULL),
(258, 8, 'tambah stok barang tetap di sarpras', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"1\",\"tgl_beli\":\"2023-05-17\"}', '{\"jumlah_masuk\":6,\"sisa_stok\":3,\"tgl_beli\":\"2023-05-31\"}', 'admin1', '2023-05-31 07:15:34', NULL, NULL, NULL, NULL),
(259, 5, 'tambah stok barang tetap di sarpras', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"3\",\"sisa_stok\":\"2\",\"tgl_beli\":\"2023-05-04\"}', '{\"jumlah_masuk\":4,\"sisa_stok\":3,\"tgl_beli\":\"2023-05-31\"}', 'admin1', '2023-05-31 07:17:34', NULL, NULL, NULL, NULL),
(283, 15, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"100\"}', '{\"jumlah_keluar\":40,\"sisa_stok\":\"60\"}', 'admin1', '2023-05-31 07:51:48', NULL, NULL, NULL, NULL),
(284, 16, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"11\",\"ruang_id\":\"35\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"40\",\"jumlah_keluar\":0,\"sisa_stok\":40,\"tgl_beli\":\"2023-05-31\",\"data\":{\"created_at\":\"2023-05-31 07:51:48\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-31 07:51:48', NULL, NULL, NULL, NULL),
(285, 15, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"100\",\"sisa_stok\":\"60\"}', '{\"jumlah_masuk\":100,\"sisa_stok\":60}', 'admin1', '2023-05-31 07:53:33', NULL, NULL, NULL, NULL),
(286, 16, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"40\"}', '{\"jumlah_keluar\":20,\"sisa_stok\":\"20\"}', 'admin1', '2023-05-31 08:05:47', NULL, NULL, NULL, NULL),
(287, 17, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"11\",\"ruang_id\":\"33\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"20\",\"jumlah_keluar\":0,\"sisa_stok\":20,\"tgl_beli\":\"2023-05-31\",\"data\":{\"created_at\":\"2023-05-31 08:05:47\",\"created_by\":\"admin1\"}}', 'admin1', '2023-05-31 08:05:47', NULL, NULL, NULL, NULL),
(288, 2, 'Permintaan Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":2}', 'admin1', '2023-06-02 10:16:17', NULL, NULL, NULL, NULL),
(289, 14, 'Permintaan Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-02 10:16:48', NULL, NULL, NULL, NULL),
(290, 3, 'Permintaan Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-06-02 10:16:48', NULL, NULL, NULL, NULL),
(293, 18, 'barang tetap masuk', 'Semua field', '', '{\"barang_id\":12,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":0,\"sisa_stok\":2,\"tgl_beli\":\"2023-06-07\"}', 'admin1', '2023-06-07 02:26:05', NULL, NULL, NULL, NULL),
(294, 6, 'Pengembalian Barang 3', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-10 01:28:05', NULL, NULL, NULL, NULL),
(295, 6, 'Pengembalian Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-10 01:29:47', NULL, NULL, NULL, NULL),
(296, 5, 'Pengembalian Barang 1', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-10 01:30:50', NULL, NULL, NULL, NULL),
(297, 19, 'barang tetap', 'Semua field', '', '{\"barang_id\":13,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":0,\"sisa_stok\":2,\"tgl_beli\":\"2023-06-15\",\"data\":{\"created_at\":\"2023-06-15 07:33:30\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-15 07:33:30', NULL, NULL, NULL, NULL),
(298, 20, 'barang tetap', 'Semua field', '', '{\"barang_id\":14,\"ruang_id\":\"54\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"5\",\"jumlah_keluar\":0,\"sisa_stok\":5,\"tgl_beli\":\"2023-06-15\",\"data\":{\"created_at\":\"2023-06-15 07:33:30\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-15 07:33:30', NULL, NULL, NULL, NULL),
(300, 20, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":\"4\"}', 'admin1', '2023-06-15 07:34:29', NULL, NULL, NULL, NULL),
(301, 21, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"14\",\"ruang_id\":\"46\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"1\",\"jumlah_keluar\":0,\"sisa_stok\":1,\"tgl_beli\":\"2023-06-15\",\"data\":{\"created_at\":\"2023-06-15 07:34:29\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-15 07:34:29', NULL, NULL, NULL, NULL),
(302, 20, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"5\",\"sisa_stok\":\"4\"}', '{\"jumlah_masuk\":5,\"sisa_stok\":4}', 'admin1', '2023-06-15 07:57:08', NULL, NULL, NULL, NULL),
(303, 20, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"5\",\"sisa_stok\":\"4\"}', '{\"jumlah_masuk\":5,\"sisa_stok\":4}', 'admin1', '2023-06-15 07:58:31', NULL, NULL, NULL, NULL),
(304, 20, 'tambah stok barang dari ruang lain', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-06-15 08:28:22', NULL, NULL, NULL, NULL),
(305, 21, 'pengembalian barang ke sarpras', '[\"jumlah_masuk\",\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"1\",\"jumlah_keluar\":\"0\",\"sisa_stok\":\"1\"}', '{\"jumlah_masuk\":0,\"jumlah_keluar\":0,\"sisa_stok\":0}', 'admin1', '2023-06-15 08:28:22', NULL, NULL, NULL, NULL),
(306, 5, 'Peminjaman Barang 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-15 08:55:45', NULL, NULL, NULL, NULL),
(307, 5, 'Pengembalian Barang 6', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-15 08:57:09', NULL, NULL, NULL, NULL),
(308, 20, 'tambah stok barang tetap di sarpras', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"5\",\"sisa_stok\":\"5\",\"tgl_beli\":\"2023-06-15\"}', '{\"jumlah_masuk\":7,\"sisa_stok\":7,\"tgl_beli\":\"2023-06-16\"}', 'admin1', '2023-06-16 03:13:59', NULL, NULL, NULL, NULL),
(309, 15, 'tambah stok barang tetap di sarpras', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"100\",\"sisa_stok\":\"60\",\"tgl_beli\":\"2023-05-31\"}', '{\"jumlah_masuk\":120,\"sisa_stok\":80,\"tgl_beli\":\"2023-06-16\"}', 'admin1', '2023-06-16 03:15:47', NULL, NULL, NULL, NULL),
(310, 22, 'barang tetap', 'Semua field', '', '{\"barang_id\":15,\"ruang_id\":\"54\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":0,\"sisa_stok\":2,\"tgl_beli\":\"2023-06-16\",\"data\":{\"created_at\":\"2023-06-16 12:37:55\",\"created_by\":\"admin1\"}}', 'admin1', '2023-06-16 12:37:55', NULL, NULL, NULL, NULL),
(311, 14, 'Update barang persediaan masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"3\"}', '{\"jumlah_masuk\":4,\"sisa_stok\":3}', 'admin1', '2023-06-16 13:10:20', NULL, NULL, NULL, NULL),
(312, 14, 'Update barang persediaan masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"3\"}', '{\"jumlah_masuk\":4,\"sisa_stok\":3}', 'admin1', '2023-06-16 13:26:30', NULL, NULL, NULL, NULL),
(313, 20, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"7\",\"sisa_stok\":\"7\",\"tgl_beli\":\"2023-06-16\"}', '{\"jumlah_masuk\":7,\"sisa_stok\":7,\"tgl_beli\":\"2023-06-15\"}', 'admin1', '2023-06-16 14:46:15', NULL, NULL, NULL, NULL),
(314, 18, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_masuk\":2,\"sisa_stok\":2}', 'admin1', '2023-06-16 14:46:36', NULL, NULL, NULL, NULL),
(315, 3, 'tambah stok barang dari permintaan 9', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-06-17 07:23:23', NULL, NULL, NULL, NULL),
(316, 6, 'Peminjaman Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-17 07:48:48', NULL, NULL, NULL, NULL),
(317, 5, 'Peminjaman Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-17 07:48:48', NULL, NULL, NULL, NULL),
(318, 6, 'Pengembalian Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-17 07:49:20', NULL, NULL, NULL, NULL),
(319, 5, 'Pengembalian Barang 2', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-17 07:49:20', NULL, NULL, NULL, NULL),
(320, 6, 'Peminjaman Barang 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-17 23:32:51', NULL, NULL, NULL, NULL),
(321, 6, 'Pengembalian Barang 4', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-19 10:06:57', NULL, NULL, NULL, NULL),
(336, 19, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_masuk\":2,\"sisa_stok\":2}', 'admin1', '2023-06-21 09:32:08', NULL, NULL, NULL, NULL),
(386, 2, 'Permintaan Barang 12', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-06-21 18:22:14', NULL, NULL, NULL, NULL),
(387, 3, 'Permintaan Barang 13', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-06-21 18:22:14', NULL, NULL, NULL, NULL),
(388, 3, 'Update Barang Persediaan 13', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', 'admin1', '2023-06-21 18:23:29', NULL, NULL, NULL, NULL),
(389, 3, 'Update Permintaan Barang 13', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-06-21 18:23:29', NULL, NULL, NULL, NULL),
(390, 3, 'Update Barang Persediaan 13', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', 'admin1', '2023-06-21 18:23:48', NULL, NULL, NULL, NULL),
(391, 3, 'Update Permintaan Barang 13', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-06-21 18:23:48', NULL, NULL, NULL, NULL),
(392, 3, 'Update Barang Persediaan 13', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', 'admin1', '2023-06-21 18:32:50', NULL, NULL, NULL, NULL),
(393, 2, 'Update Permintaan Barang 12', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-06-21 18:32:50', NULL, NULL, NULL, NULL),
(394, 14, 'Permintaan Barang 14', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-21 18:51:15', NULL, NULL, NULL, NULL),
(395, 2, 'Permintaan Barang 15', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":2}', 'admin1', '2023-06-21 18:51:15', NULL, NULL, NULL, NULL),
(398, 2, 'Update Barang Persediaan 15', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"3\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', 'admin1', '2023-06-21 18:55:39', NULL, NULL, NULL, NULL),
(399, 2, 'Update Permintaan Barang 15', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":2}', 'admin1', '2023-06-21 18:55:39', NULL, NULL, NULL, NULL),
(400, 2, 'Update Barang Persediaan 15', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"3\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', 'admin1', '2023-06-21 18:55:57', NULL, NULL, NULL, NULL),
(401, 14, 'Update Permintaan Barang 14', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-06-21 18:55:57', NULL, NULL, NULL, NULL),
(402, 14, 'Update Barang Persediaan 14', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', 'admin1', '2023-06-21 18:56:10', NULL, NULL, NULL, NULL),
(403, 14, 'Update Permintaan Barang 14', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-21 18:56:10', NULL, NULL, NULL, NULL),
(404, 2, 'Update Barang Persediaan 12', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-06-21 21:46:34', NULL, NULL, NULL, NULL),
(405, 2, 'Update Permintaan Barang 12', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":4}', 'admin1', '2023-06-21 21:46:34', NULL, NULL, NULL, NULL),
(406, 14, 'Update Barang Persediaan 14', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-21 21:47:37', NULL, NULL, NULL, NULL),
(407, 14, 'Update Permintaan Barang 14', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":2}', 'admin1', '2023-06-21 21:47:37', NULL, NULL, NULL, NULL),
(408, 5, 'Peminjaman Barang 15', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-21 22:02:59', NULL, NULL, NULL, NULL),
(409, 6, 'Peminjaman Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-21 22:02:59', NULL, NULL, NULL, NULL),
(410, 6, 'Update Update Barang Tetap 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', 'admin1', '2023-06-21 23:02:47', NULL, NULL, NULL, NULL),
(411, 13, 'Update Peminjaman Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"6\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":5}', 'admin1', '2023-06-21 23:02:47', NULL, NULL, NULL, NULL),
(412, 7, 'tambah stok barang dari ruang lain', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"3\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":5}', 'admin1', '2023-06-22 15:42:45', NULL, NULL, NULL, NULL),
(413, 10, 'pengembalian barang ke sarpras', '[\"jumlah_masuk\",\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"2\",\"jumlah_keluar\":\"0\",\"sisa_stok\":\"2\"}', '{\"jumlah_masuk\":0,\"jumlah_keluar\":0,\"sisa_stok\":0}', 'admin1', '2023-06-22 15:42:45', NULL, NULL, NULL, NULL),
(414, 8, 'tambah stok barang dari ruang lain', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"3\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":5}', 'admin1', '2023-06-22 15:42:45', NULL, NULL, NULL, NULL),
(415, 9, 'pengembalian barang ke sarpras', '[\"jumlah_masuk\",\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"2\",\"jumlah_keluar\":\"0\",\"sisa_stok\":\"2\"}', '{\"jumlah_masuk\":0,\"jumlah_keluar\":0,\"sisa_stok\":0}', 'admin1', '2023-06-22 15:42:45', NULL, NULL, NULL, NULL),
(416, 10, 'pemulihan data Barang Tetap', '[\"jumlah_masuk\",\"sisa_stok\",\"deleted_by\",\"deleted_at\"]', '{\"jumlah_masuk\":\"0\",\"sisa_stok\":\"0\",\"deleted_by\":\"admin1\",\"deleted_at\":\"2023-06-22 15:42:45\"}', '{\"jumlah_masuk\":\"2\",\"sisa_stok\":\"2\",\"deleted_by\":null,\"deleted_at\":null}', 'admin1', '2023-06-22 15:42:51', NULL, NULL, NULL, NULL),
(417, 7, 'pemulihan data Barang Tetap', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":3}', 'admin1', '2023-06-22 15:42:51', NULL, NULL, NULL, NULL),
(418, 9, 'pemulihan data Barang Tetap', '[\"jumlah_masuk\",\"sisa_stok\",\"deleted_by\",\"deleted_at\"]', '{\"jumlah_masuk\":\"0\",\"sisa_stok\":\"0\",\"deleted_by\":\"admin1\",\"deleted_at\":\"2023-06-22 15:42:45\"}', '{\"jumlah_masuk\":\"2\",\"sisa_stok\":\"2\",\"deleted_by\":null,\"deleted_at\":null}', 'admin1', '2023-06-22 15:42:51', NULL, NULL, NULL, NULL),
(419, 8, 'pemulihan data Barang Tetap', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":3,\"sisa_stok\":3}', 'admin1', '2023-06-22 15:42:51', NULL, NULL, NULL, NULL),
(420, 15, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"40\",\"sisa_stok\":\"80\"}', '{\"jumlah_keluar\":60,\"sisa_stok\":\"60\"}', 'admin1', '2023-06-23 10:46:50', NULL, NULL, NULL, NULL),
(421, 23, 'transfer barang tetap', 'Semua field', '', '{\"barang_id\":\"11\",\"ruang_id\":\"39\",\"satuan_id\":\"2\",\"jumlah_masuk\":\"20\",\"jumlah_keluar\":0,\"sisa_stok\":20,\"tgl_beli\":\"2023-06-16\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 10:46:50.517600\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 10:46:50', NULL, NULL, NULL, NULL),
(422, 17, 'update barang tetap masuk', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"20\"}', '{\"jumlah_keluar\":10,\"sisa_stok\":\"10\"}', 'admin1', '2023-06-23 10:47:30', NULL, NULL, NULL, NULL),
(423, 23, 'update transfer barang tetap', '[\"jumlah_masuk\",\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"20\",\"jumlah_keluar\":\"0\",\"sisa_stok\":\"20\"}', '{\"jumlah_masuk\":30,\"jumlah_keluar\":0,\"sisa_stok\":30}', 'admin1', '2023-06-23 10:47:30', NULL, NULL, NULL, NULL),
(424, 2, 'Permintaan Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":3}', 'admin1', '2023-06-23 11:00:28', NULL, NULL, NULL, NULL),
(425, 1, 'Permintaan Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":9}', 'admin1', '2023-06-23 11:00:28', NULL, NULL, NULL, NULL),
(426, 1, 'Update Barang Persediaan 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', 'admin1', '2023-06-23 11:00:43', NULL, NULL, NULL, NULL),
(427, 1, 'Update Permintaan Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":8}', 'admin1', '2023-06-23 11:00:43', NULL, NULL, NULL, NULL),
(428, 1, 'Update Barang Persediaan 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"2\",\"sisa_stok\":\"8\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":10}', 'admin1', '2023-06-23 11:01:17', NULL, NULL, NULL, NULL),
(429, 1, 'Update Permintaan Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"10\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":9}', 'admin1', '2023-06-23 11:01:17', NULL, NULL, NULL, NULL),
(430, 5, 'Pengembalian Barang 8', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'admin1', '2023-06-23 11:02:41', NULL, NULL, NULL, NULL),
(431, 13, 'Pengembalian Barang 8', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":6}', 'admin1', '2023-06-23 11:02:41', NULL, NULL, NULL, NULL),
(432, 24, 'barang persediaan', 'Semua field', '', '{\"barang_id\":16,\"ruang_id\":\"54\",\"satuan_id\":\"1\",\"jumlah_masuk\":\"20\",\"jumlah_keluar\":0,\"sisa_stok\":20,\"tgl_beli\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 11:16:24.404385\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 11:16:24', NULL, NULL, NULL, NULL);
INSERT INTO `riwayat_transaksi` (`id`, `stokbrg_id`, `jenis_transaksi`, `field`, `old_value`, `new_value`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(433, 25, 'barang persediaan', 'Semua field', '', '{\"barang_id\":17,\"ruang_id\":\"54\",\"satuan_id\":\"1\",\"jumlah_masuk\":\"20\",\"jumlah_keluar\":0,\"sisa_stok\":20,\"tgl_beli\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 11:16:24.438970\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 11:16:24', NULL, NULL, NULL, NULL),
(434, 26, 'barang persediaan', 'Semua field', '', '{\"barang_id\":18,\"ruang_id\":\"54\",\"satuan_id\":\"1\",\"jumlah_masuk\":\"10\",\"jumlah_keluar\":0,\"sisa_stok\":10,\"tgl_beli\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 16:05:19.599070\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL),
(435, 27, 'barang persediaan', 'Semua field', '', '{\"barang_id\":19,\"ruang_id\":\"54\",\"satuan_id\":\"1\",\"jumlah_masuk\":\"10\",\"jumlah_keluar\":0,\"sisa_stok\":10,\"tgl_beli\":\"2023-06-23\",\"data\":{\"created_at\":{\"date\":\"2023-06-23 16:05:19.631347\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL),
(436, 28, 'barang tetap', 'Semua field', '', '{\"barang_id\":20,\"ruang_id\":\"54\",\"satuan_id\":\"3\",\"jumlah_masuk\":\"1\",\"jumlah_keluar\":0,\"sisa_stok\":1,\"tgl_beli\":\"2023-06-24\",\"data\":{\"created_at\":{\"date\":\"2023-06-24 19:29:26.410168\",\"timezone_type\":3,\"timezone\":\"Asia\\/Jakarta\"},\"created_by\":\"admin1\"}}', 'admin1', '2023-06-24 19:29:26', NULL, NULL, NULL, NULL),
(437, 28, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"1\",\"sisa_stok\":\"1\"}', '{\"jumlah_masuk\":1,\"sisa_stok\":1}', 'admin1', '2023-06-24 20:15:46', NULL, NULL, NULL, NULL),
(438, 25, 'Permintaan Barang 18', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"20\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":19}', 'admin1', '2023-06-24 21:35:14', NULL, NULL, NULL, NULL),
(439, 1, 'Permintaan Barang 19', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"9\"}', '{\"jumlah_keluar\":2,\"sisa_stok\":8}', 'admin1', '2023-06-24 21:35:14', NULL, NULL, NULL, NULL),
(440, 25, 'Update Barang Persediaan 18', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"19\"}', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"20\"}', 'admin1', '2023-06-24 21:35:31', NULL, NULL, NULL, NULL),
(441, 24, 'Update Permintaan Barang 18', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"20\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":19}', 'admin1', '2023-06-24 21:35:31', NULL, NULL, NULL, NULL),
(442, 19, 'Update barang tetap masuk', '[\"jumlah_masuk\",\"sisa_stok\"]', '{\"jumlah_masuk\":\"2\",\"sisa_stok\":\"2\"}', '{\"jumlah_masuk\":2,\"sisa_stok\":2}', 'admin1', '2023-06-25 10:27:54', NULL, NULL, NULL, NULL),
(443, 5, 'Peminjaman Barang ', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'admin1', '2023-06-26 12:42:35', NULL, NULL, NULL, NULL),
(444, 22, 'penghapusan permanen barang tetap', 'delete data', '[{\"id\":\"22\",\"barang_id\":\"15\",\"satuan_id\":\"2\",\"ruang_id\":\"54\",\"jumlah_masuk\":\"2\",\"jumlah_keluar\":\"0\",\"sisa_stok\":\"2\",\"tgl_beli\":\"2023-06-16\",\"created_by\":\"admin1\",\"created_at\":\"2023-06-16 12:37:55\",\"updated_by\":\"admin1\",\"updated_at\":\"2023-06-20 17:13:07\",\"deleted_by\":\"admin1\",\"deleted_at\":\"2023-06-20 17:13:07\"}]', '', 'admin1', '2023-06-26 18:53:52', NULL, NULL, NULL, NULL),
(445, 28, 'penghapusan permanen barang tetap', 'delete data', '[{\"id\":\"28\",\"barang_id\":\"20\",\"satuan_id\":\"3\",\"ruang_id\":\"54\",\"jumlah_masuk\":\"1\",\"jumlah_keluar\":\"0\",\"sisa_stok\":\"1\",\"tgl_beli\":\"2023-06-24\",\"created_by\":\"admin1\",\"created_at\":\"2023-06-24 19:29:26\",\"updated_by\":\"admin1\",\"updated_at\":\"2023-06-26 18:54:07\",\"deleted_by\":\"admin1\",\"deleted_at\":\"2023-06-26 18:54:07\"}]', '', 'admin1', '2023-06-26 18:54:31', NULL, NULL, NULL, NULL),
(451, 5, 'Update Pengembalian Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'dimdimasald15', '2023-06-27 16:21:59', NULL, NULL, NULL, NULL),
(452, 13, 'Update Pengembalian Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"6\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":5}', 'dimdimasald15', '2023-06-27 16:35:18', NULL, NULL, NULL, NULL),
(459, 13, 'Pengembalian Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":6}', 'dimdimasald15', '2023-06-27 16:45:10', NULL, NULL, NULL, NULL),
(460, 13, 'Update Pengembalian Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"6\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":5}', 'dimdimasald15', '2023-06-27 17:04:41', NULL, NULL, NULL, NULL),
(461, 13, 'Pengembalian Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":6}', 'dimdimasald15', '2023-06-27 17:05:09', NULL, NULL, NULL, NULL),
(462, 5, 'Pengembalian Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"3\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":4}', 'dimdimasald15', '2023-06-27 17:05:40', NULL, NULL, NULL, NULL),
(463, 5, 'Update Pengembalian Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":3}', 'dimdimasald15', '2023-06-27 17:05:49', NULL, NULL, NULL, NULL),
(464, 5, 'tambah stok barang tetap di sarpras', '[\"jumlah_masuk\",\"sisa_stok\",\"tgl_beli\"]', '{\"jumlah_masuk\":\"4\",\"sisa_stok\":\"3\",\"tgl_beli\":\"2023-05-31\"}', '{\"jumlah_masuk\":5,\"sisa_stok\":4,\"tgl_beli\":\"2023-06-28\"}', 'dimdimasald15', '2023-06-28 10:31:02', NULL, NULL, NULL, NULL),
(465, 13, 'Update Pengembalian Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"0\",\"sisa_stok\":\"6\"}', '{\"jumlah_keluar\":1,\"sisa_stok\":5}', 'admin1', '2023-06-30 13:58:54', NULL, NULL, NULL, NULL),
(466, 13, 'Pengembalian Barang 16', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"5\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":6}', 'admin1', '2023-06-30 13:59:30', NULL, NULL, NULL, NULL),
(467, 5, 'Pengembalian Barang 17', '[\"jumlah_keluar\",\"sisa_stok\"]', '{\"jumlah_keluar\":\"1\",\"sisa_stok\":\"4\"}', '{\"jumlah_keluar\":0,\"sisa_stok\":5}', 'admin1', '2023-06-30 14:34:05', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` int(11) NOT NULL,
  `nama_ruang` varchar(50) NOT NULL,
  `nama_lantai` varchar(2) NOT NULL,
  `gedung_id` int(2) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `nama_ruang`, `nama_lantai`, `gedung_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'BSI', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(2, 'Ruang Rektor', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(3, 'Ruang Yayasan', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(4, 'Ruang Rapat', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(5, 'Lobby UNIRA', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(6, 'Ruang Administrasi', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(7, 'Rektorat', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(8, 'KaBiro 3', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(9, 'PDTI', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(10, 'Toilet', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(11, 'Humas', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(12, 'FEB', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(13, 'FIK', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(14, 'Ruang GIS', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(15, 'Mini Bank Syariah', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(16, 'A 2-2 (Micro Teaching)', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(17, 'LPM', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(18, 'Pasca Sarjana', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(19, 'LPPM', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(20, 'SPI', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(21, 'PAKU', '2', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(23, 'AULA KH. Moch. Said', '3', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(24, 'Gudang', '3', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(26, 'FISIP', '1', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(27, 'FIP', '1', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(28, 'Lab TE', '1', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(29, 'Lab Mesin', '1', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(31, 'B 2-1A', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(32, 'B 2-1B', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(33, 'B 2-2A', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(34, 'B 2-2B', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(35, 'B 2-3A', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(36, 'B 2-3B', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(37, 'Ruang UKM', '2', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(38, 'B 3-1B', '3', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(39, 'B 3-1A', '3', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(40, 'B 3-3', '3', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(42, 'BEM', '3', 2, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(43, 'Digital Center', '1', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(44, 'Perpustakaan', '1', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(45, 'Kemahasiswaan', '1', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(46, 'F. Saintek', '2', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(47, 'C 2-2', '2', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(48, 'C 2-3A', '2', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(49, 'C 2-3B', '2', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(50, 'C 3-1', '3', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(51, 'Lab TI', '3', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(52, 'C 3-3A', '3', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(53, 'C 3-3B (Lab Psikologi)', '3', 3, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(54, 'Sarana dan Prasarana', '1', 1, 'admin1', '2023-04-01 16:42:02', NULL, NULL, NULL, NULL),
(55, 'Kabag PMB', '1', 1, 'admin1', '2023-04-01 16:42:02', 'admin1', '2023-06-12 02:29:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `kd_satuan` varchar(10) NOT NULL,
  `nama_satuan` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `kd_satuan`, `nama_satuan`, `deskripsi`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'pcs', 'Pieces', 'Satuan ini merujuk pada jumlah barang yang tidak ditentukan jenisnya. Contohnya adalah satu set peralatan makan yang terdiri dari beberapa jenis namun dihitung hanya sebagai \"pieces\" atau \"pcs\".', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(2, 'buah', 'Buah', 'Satuan untuk sebuah benda secara umum dalam bahasa indonesia', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(3, 'unit', 'Unit', 'Satuan ini mirip dengan \"pieces\" namun lebih sering digunakan dalam konteks elektronik atau mesin. Contohnya adalah satu unit komputer atau satu unit mesin fotokopi.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(4, 'lusin', 'Lusin', 'Satuan ini merujuk pada 12 buah barang. Contohnya, sebuah lusin telur akan berisi 12 butir telur.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(5, 'gross', 'Gross', 'Satuan ini merujuk pada 144 buah barang, atau 12 lusin. Satuan ini biasanya digunakan untuk barang-barang kecil seperti kancing atau jarum.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(6, 'kodi', 'Kodi', 'Satuan ini merujuk pada 20 buah barang. Satuan ini lebih umum digunakan di Indonesia, terutama dalam konteks perdagangan bahan pangan seperti telur dan ikan.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(7, 'rim', 'Rim', 'Satuan ini merujuk pada 500 lembar kertas atau 25 kodi kertas. Satuan ini biasanya digunakan dalam konteks percetakan atau kertas.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(8, 'lbr', 'Lembar', 'Satuan kuantitas yang mengacu pada selembar kertas atau bahan lainnya yang berbentuk datar seperti kain atau plastik.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(9, 'btg', 'Batang', 'Satuan kuantitas batang umumnya digunakan untuk mengukur sejumlah benda yang panjangnya lebih besar dari ukuran standar. Beberapa contoh benda yang sering diukur dengan satuan kuantitas batang antara lain kayu, pipa, besi, dan sebagainya. Ukuran panjang dari satu batang dapat bervariasi tergantung pada jenis benda yang diukur.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(10, 'bks', 'Bungkus', 'Satuan kuantitas bungkus umumnya digunakan untuk mengukur sejumlah produk yang dikemas dalam bungkus tertentu. Bungkus bisa berupa kantong plastik, kertas pembungkus, atau kemasan lainnya. Satuan kuantitas bungkus biasanya digunakan untuk produk yang dijual dalam jumlah banyak dan dikemas dalam satu bungkus, misalnya mie instan, permen, atau rokok.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(11, 'ptg', 'Potong', 'Satuan kuantitas potong umumnya digunakan untuk mengukur sejumlah produk yang dipotong menjadi ukuran tertentu. Contohnya adalah kain yang dijual per meter tapi dipotong menjadi ukuran tertentu, seperti 1 meter x 1,5 meter. Satuan kuantitas potong juga dapat digunakan untuk produk makanan yang dijual dalam bentuk potongan, seperti daging atau ikan.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(12, 'tablet', 'Tablet', 'Satuan kuantitas ini digunakan untuk mengukur obat atau suplemen dalam bentuk tablet.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(13, 'btl', 'Botol', 'Satuan kuantitas yang mengacu pada jumlah botol atau wadah tertentu, yang biasanya berisi cairan seperti minuman atau obat-obatan.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(14, 'btr', 'Butir', 'Satuan kuantitas yang mengacu pada jumlah biji atau butiran, seperti kacang-kacangan, beras, atau pil.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(15, 'roll', 'Roll', 'Satuan kuantitas yang mengacu pada gulungan atau roll bahan seperti kertas, kain, atau plastik.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(16, 'dus', 'Kardus', 'Satuan kuantitas yang mengacu pada kemasan kotak yang terbuat dari karton atau bahan lainnya, yang biasanya digunakan untuk mengemas barang-barang seperti makanan, minuman, atau peralatan elektronik.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(17, 'karung', 'Karung', 'Satuan kuantitas yang mengacu pada kantong besar atau karung yang terbuat dari bahan seperti jaring atau kain, yang biasanya digunakan untuk mengemas produk pertanian atau bahan makanan lainnya.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(18, 'sak', 'Sak', 'Satuan kuantitas yang mengacu pada kantong atau tas yang terbuat dari bahan seperti kertas atau plastik, yang biasanya digunakan untuk mengemas bahan curah seperti pasir atau bahan konstruksi lainnya.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(19, 'bal', 'Bal', 'Satuan kuantitas yang mengacu pada kemasan yang berbentuk kotak atau bungkusan yang terbuat dari bahan seperti kardus atau plastik, yang biasanya digunakan untuk mengemas barang-barang seperti pakaian atau mainan.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(20, 'kaleng', 'Kaleng', 'Satuan kuantitas yang mengacu pada jumlah kaleng yang berisi makanan atau minuman seperti susu, soda, atau konserven.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(21, 'set', 'Set', 'Satuan kuantitas yang mengacu pada sekelompok barang yang dijual sebagai satu kesatuan atau paket, seperti set alat tulis atau set peralatan makan.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(22, 'ton', 'Ton', 'Satuan ini biasanya digunakan untuk mengukur berat atau massa benda yang sangat besar seperti berat mobil, kapal, dan pesawat terbang. Satu ton setara dengan 1000 kilogram.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(23, 'kuintal', 'Kuintal', 'Satuan ini biasanya digunakan untuk mengukur berat atau massa benda. Satu kuintal setara dengan 100 kilogram.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(24, 'kg', 'Kilogram', 'Satuan ini biasanya digunakan untuk mengukur berat atau massa benda yang sedang seperti berat manusia, hewan, makanan, dan barang-barang dagangan. Satu kilogram setara dengan 1000 gram.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(25, 'ons', 'Hektogram', 'Satuannya adalah seperseratus dari satu kilogram atau 10 gram.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(26, 'gr', 'Gram', 'Satuan ini biasanya digunakan untuk mengukur berat atau massa benda yang kecil seperti bumbu dapur, obat-obatan, dan bahan kimia. Satu gram setara dengan 1000 miligram.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(27, 'mg', 'Miligram', 'Satuan ini biasanya digunakan untuk mengukur dosis obat-obatan atau vitamin, dan kadar zat dalam makanan atau minuman. Satu miligram setara dengan 0,001 gram.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(28, 'm', 'Meter', 'Satuan ini biasanya digunakan untuk mengukur panjang atau jarak. Satu meter setara dengan 100 centimeter atau 1000 milimeter.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(29, 'm2', 'Meter Persegi', 'Satuan ini biasanya digunakan untuk mengukur luas sebuah bidang datar seperti lantai atau dinding. Satu meter persegi setara dengan luas sebuah kotak yang sisi-sisinya panjangnya satu meter.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(30, 'm3', 'Meter Kubik', 'Satuan ini biasanya digunakan untuk mengukur volume sebuah benda tiga dimensi seperti kubus atau balok. Satu meter kubik setara dengan volume sebuah kubus yang sisi-sisinya panjangnya satu meter.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(31, 'Inch', 'Inchi', 'Satuan ini biasanya digunakan untuk mengukur panjang atau jarak, terutama dalam dunia industri elektronik dan otomotif. Satu inchi setara dengan 2,54 sentimeter.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(32, 'cc', 'Cc', 'Satuan ini biasanya digunakan untuk mengukur volume cairan atau gas. Satu cc (centimeter kubik) setara dengan 1 mililiter.', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(33, 'liter', 'Liter', 'Satuan ini biasanya digunakan untuk mengukur volume cairan atau gas dalam jumlah yang lebih besar. Satu liter setara dengan 1000 mililiter atau 1 dm3 (decimeter kubik).', 'admin1', '2023-03-19 18:41:58', NULL, NULL, NULL, NULL),
(34, 'lonjor', 'lonjor', 'satuan kuantitas \"1 lonjor\" adalah satuan kuantitas tradisional yang biasanya digunakan untuk mengukur panjang bahan kain, seperti kain batik atau kain songket. Satu lonjor biasanya memiliki panjang sekitar 2,5 meter hingga 3 meter, tergantung pada daerah atau budaya yang menggunakan satuan ini.\r\n', 'admin1', '2023-03-21 11:10:49', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `ruang_id` int(11) NOT NULL,
  `jumlah_masuk` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_keluar` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sisa_stok` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `tgl_beli` date DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stok_barang`
--

INSERT INTO `stok_barang` (`id`, `barang_id`, `satuan_id`, `ruang_id`, `jumlah_masuk`, `jumlah_keluar`, `sisa_stok`, `tgl_beli`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 1, 54, 10, 2, 8, '2023-05-07', 'admin1', '2023-05-07 10:35:09', 'admin1', '2023-06-24 21:35:14', NULL, NULL),
(2, 2, 7, 54, 5, 2, 3, '2023-05-07', 'admin1', '2023-05-07 10:37:21', 'admin1', '2023-06-23 11:00:28', NULL, NULL),
(3, 3, 13, 54, 5, 0, 5, '2023-05-07', 'admin1', '2023-05-07 10:37:21', 'admin1', '2023-06-21 18:32:50', NULL, NULL),
(4, 4, 1, 54, 2, 0, 2, '2023-05-07', 'admin1', '2023-05-07 10:42:13', NULL, NULL, NULL, NULL),
(5, 5, 3, 54, 5, 0, 5, '2023-06-28', 'admin1', '2023-05-08 00:30:26', 'admin1', '2023-06-30 14:34:05', NULL, NULL),
(6, 6, 3, 54, 4, 1, 3, '2023-05-01', 'admin1', '2023-05-08 00:30:26', 'admin1', '2023-06-27 05:20:57', NULL, NULL),
(7, 7, 3, 54, 6, 3, 3, '2023-05-29', 'admin1', '2023-05-17 11:38:22', 'admin1', '2023-06-22 15:42:51', NULL, NULL),
(8, 8, 3, 54, 6, 3, 3, '2023-05-31', 'admin1', '2023-05-17 11:38:23', 'admin1', '2023-06-22 15:42:51', NULL, NULL),
(9, 8, 3, 43, 2, 0, 2, '2023-05-17', 'admin1', '2023-05-17 11:39:04', 'admin1', '2023-06-22 15:42:51', NULL, NULL),
(10, 7, 3, 43, 2, 0, 2, '2023-05-17', 'admin1', '2023-05-17 11:39:04', 'admin1', '2023-06-22 15:42:51', NULL, NULL),
(11, 8, 3, 44, 1, 0, 1, '2023-05-17', 'admin1', '2023-05-23 06:34:28', NULL, NULL, NULL, NULL),
(12, 7, 3, 44, 1, 0, 1, '2023-05-17', 'admin1', '2023-05-23 06:34:28', NULL, NULL, NULL, NULL),
(13, 9, 3, 54, 6, 0, 6, '2023-05-29', 'admin1', '2023-05-29 02:16:24', 'admin1', '2023-06-30 13:59:30', NULL, NULL),
(14, 10, 13, 54, 4, 2, 2, '2023-05-29', 'admin1', '2023-05-29 02:36:31', 'admin1', '2023-06-21 21:47:37', NULL, NULL),
(15, 11, 2, 54, 120, 60, 60, '2023-06-16', 'admin1', '2023-05-31 06:48:21', 'admin1', '2023-06-23 10:46:50', NULL, NULL),
(16, 11, 2, 35, 40, 20, 20, '2023-05-31', 'admin1', '2023-05-31 07:51:48', 'admin1', '2023-05-31 08:05:47', NULL, NULL),
(17, 11, 2, 33, 20, 10, 10, '2023-05-31', 'admin1', '2023-05-31 08:05:47', 'admin1', '2023-06-23 10:47:30', NULL, NULL),
(18, 12, 3, 54, 2, 0, 2, '2023-06-07', 'admin1', '2023-06-07 02:26:05', 'admin1', '2023-06-16 14:46:36', NULL, NULL),
(19, 13, 3, 54, 2, 0, 2, '2023-06-15', 'admin1', '2023-06-15 07:33:30', 'admin1', '2023-06-25 10:27:54', NULL, NULL),
(20, 14, 2, 54, 7, 0, 7, '2023-06-15', 'admin1', '2023-06-15 07:33:30', 'admin1', '2023-06-20 17:13:07', 'admin1', '2023-06-20 17:13:07'),
(21, 14, 2, 46, 0, 0, 0, '2023-06-15', 'admin1', '2023-06-15 07:34:29', 'admin1', '2023-06-15 08:28:22', NULL, NULL),
(23, 11, 2, 39, 30, 0, 30, '2023-06-16', 'admin1', '2023-06-23 10:46:50', 'admin1', '2023-06-23 10:47:30', NULL, NULL),
(24, 16, 1, 54, 20, 1, 19, '2023-06-23', 'admin1', '2023-06-23 11:16:24', 'admin1', '2023-06-24 21:35:31', NULL, NULL),
(25, 17, 1, 54, 20, 0, 20, '2023-06-23', 'admin1', '2023-06-23 11:16:24', 'admin1', '2023-06-24 21:35:31', NULL, NULL),
(26, 18, 1, 54, 10, 0, 10, '2023-06-23', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL),
(27, 19, 1, 54, 10, 0, 10, '2023-06-23', 'admin1', '2023-06-23 16:05:19', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `singkatan` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori_unit` varchar(50) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `nama_unit`, `singkatan`, `deskripsi`, `kategori_unit`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(32, 'Fakultas Ilmu Ekonomi dan Bisnis', 'FEB', 'Fakultas Ekonomi dan Bisnis adalah salah satu fakultas di perguruan tinggi yang fokus pada pendidikan dan penelitian di bidang ekonomi dan bisnis. Di fakultas ini, mahasiswa dapat mempelajari berbagai macam ilmu ekonomi, manajemen, keuangan, pemasaran, dan bisnis secara umum.', 'Fakultas', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-06-22 16:16:09', NULL, NULL),
(33, 'Fakultas Ilmu Sosial dan Politik', 'FISIP', 'Fakultas Ilmu Sosial dan Politik adalah fakultas yang fokus pada studi tentang perilaku manusia dan hubungan antarmanusia dalam konteks sosial dan politik. Di fakultas ini, mahasiswa dapat mempelajari berbagai macam ilmu sosial seperti sosiologi, antropologi, ilmu politik, dan komunikasi.', 'Fakultas', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(34, 'Fakultas Ilmu Sains dan Teknologi', 'FSAINTEK', 'Fakultas Sains dan Teknologi adalah fakultas yang fokus pada pendidikan dan penelitian di bidang ilmu pengetahuan dan teknologi. Di fakultas ini, mahasiswa dapat mempelajari berbagai macam ilmu pengetahuan seperti matematika, fisika, kimia, biologi, teknik, dan informatika.', 'Fakultas', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(35, 'Fakultas Ilmu Keislaman', 'FIK', 'Fakultas Ilmu Keislaman adalah fakultas yang fokus pada pendidikan dan penelitian di bidang keislaman. Di fakultas ini, mahasiswa dapat mempelajari berbagai macam ilmu agama Islam seperti aqidah, fiqh, tasawuf, sejarah Islam, dan bahasa Arab.', 'Fakultas', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(36, 'Fakultas Ilmu Pendidikan', 'FIP', 'Fakultas Ilmu Pendidikan adalah fakultas yang fokus pada pendidikan dan penelitian di bidang pendidikan. Di fakultas ini, mahasiswa dapat mempelajari berbagai macam ilmu pendidikan seperti psikologi pendidikan, kurikulum dan pengajaran, manajemen pendidikan, dan evaluasi pendidikan. Selain itu, fakultas ini juga membekali mahasiswa dengan keterampilan mengajar dan manajemen kelas', 'Fakultas', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(37, 'Teknik Informatika', 'TI', 'Teknik Informatika adalah program studi yang berkaitan dengan pengembangan perangkat lunak dan sistem informasi.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(38, 'Teknik Mesin', 'TM', 'Teknik Mesin adalah program studi yang berkaitan dengan rancangan, pembuatan, dan pengoperasian mesin atau sistem mesin.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(39, 'Teknik Elektro', 'TE', 'Teknik Elektro adalah program studi yang berkaitan dengan penerapan prinsip-prinsip fisika dan matematika dalam perancangan dan pengembangan teknologi listrik, elektronik, dan komunikasi.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(40, 'Agroteknologi', 'Agrotek', 'Agroteknologi adalah program studi yang berkaitan dengan pengembangan teknologi dan inovasi di bidang pertanian.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(41, 'Sistem Informasi', 'SI', 'Sistem Informasi adalah program studi yang berkaitan dengan pengembangan sistem informasi untuk mendukung kebutuhan bisnis.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(42, 'Manajemen', 'Manajemen', 'Manajemen adalah program studi yang mempelajari prinsip-prinsip, teori, dan praktik dalam pengelolaan organisasi, termasuk perencanaan, pengorganisasian, pengendalian, dan pengambilan keputusan.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(43, 'Perbankan dan Ekonomi Syariah', 'PEB', 'Perbankan Ekonomi Syariah adalah program studi yang mempelajari tentang sistem keuangan yang berlandaskan pada prinsip-prinsip syariah.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(44, 'Pendidikan Ilmu Pengetahuan Sosial', 'PIPS', 'Pendidikan IPS (Ilmu Pengetahuan Sosial) adalah program studi yang mempelajari tentang pembelajaran dalam bidang IPS di tingkat sekolah menengah.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(45, 'Pendidikan Guru SD', 'PGSD', 'PGSD (Pendidikan Guru Sekolah Dasar) adalah program studi yang mempersiapkan mahasiswa untuk menjadi guru di sekolah dasar. ', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(46, 'Pendidikan Guru MI', 'PGMI', 'PGMI (Pendidikan Guru Madrasah Ibtidaiyah) adalah program studi yang mempersiapkan mahasiswa untuk menjadi guru di madrasah ibtidaiyah. ', 'Program Studi', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-05-24 05:15:21', NULL, NULL),
(47, 'Pendidikan Agama Islam', 'PAI', 'PAI (Pendidikan Agama Islam) adalah program studi yang mempelajari tentang pembelajaran agama Islam di tingkat sekolah.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-06-22 16:16:09', NULL, NULL),
(48, 'Ilmu Pemerintahan', 'IP', 'Ilmu Pemerintahan adalah program studi yang mempelajari tentang teori dan praktik dalam bidang pemerintahan dan administrasi publik.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(49, 'Psikologi', 'Psikologi', 'Psikologi adalah program studi yang mempelajari tentang perilaku manusia, proses mental, dan interaksi sosial.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(50, 'Pascasarjana', 'Pascasarjana', 'Pascasarjana adalah sebuah institusi atau bagian di universitas yang menawarkan program studi pascasarjana, seperti program magister dan doktor dalam berbagai bidang studi.', 'Program Studi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(51, 'Human Resources Development', 'HRD', 'HRD (Human Resources Development) atau Pengembangan Sumber Daya Manusia adalah sebuah bagian di universitas yang bertanggung jawab untuk mengembangkan keterampilan dan pengetahuan para karyawan universitas.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(52, 'Lobi UNIRA', 'Lobi', 'Lobi adalah sebuah ruangan atau area di universitas yang berfungsi sebagai tempat tunggu atau tempat bertemu, serta memberikan informasi mengenai universitas.', 'Divisi', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-06-19 10:24:53', NULL, NULL),
(53, 'Penerimaan Mahasiswa Baru', 'PMB', 'PMB (Penerimaan Mahasiswa Baru) atau Bagian Pendaftaran adalah sebuah bagian di universitas yang bertanggung jawab untuk memproses pendaftaran mahasiswa baru.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(54, 'Driver', 'Driver', 'Driver atau sopir adalah seorang karyawan di universitas yang bertanggung jawab untuk mengemudikan kendaraan universitas, seperti mobil atau bus.', 'Divisi', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-06-19 10:24:16', NULL, NULL),
(55, 'Perpustakaan', 'Perpustakaan ', 'Perpustakaan adalah sebuah lembaga di universitas yang menyediakan bahan bacaan dan sumber informasi dalam berbagai bidang studi, seperti buku, jurnal, majalah, dan database online.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(56, 'Bagian Kemahasiswaan', 'Kemahasiswaan', 'Kemahasiswaan atau Bagian Kemahasiswaan adalah sebuah bagian di universitas yang bertanggung jawab untuk memfasilitasi kegiatan-kegiatan yang berhubungan dengan mahasiswa, seperti organisasi kemahasiswaan, kegiatan olahraga, seni dan budaya, serta bimbingan dan konseling.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(57, 'Bagian Keuangan', 'Keuangan', 'Keuangan atau Bagian Keuangan adalah sebuah bagian di universitas yang bertanggung jawab untuk mengelola keuangan universitas, termasuk penerimaan dan pengeluaran.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(58, 'Bank Syariah Indonesia', 'BSI', 'sebuah lembaga keuangan di universitas yang menyediakan jasa perbankan untuk mahasiswa dan karyawan universitas.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(59, 'Yayasan', 'Yayasan', 'Yayasan adalah sebuah badan hukum di universitas yang bertanggung jawab untuk mengelola aset dan kegiatan universitas.', 'Divisi', 'admin1', '2023-01-06 07:14:40', NULL, NULL, NULL, NULL),
(60, 'Laboratorium Dasar', 'Lab Dasar', 'Lab Dasar atau Laboratorium Dasar adalah sebuah fasilitas di universitas yang berfungsi sebagai tempat praktikum dan riset di bidang-bidang studi dasar seperti fisika, kimia, dan biologi.', 'Divisi', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-06-22 16:07:42', NULL, NULL),
(61, 'Lembaga Penelitian dan Pengabdian Masyarakat', 'LPPM', 'LPPM (Lembaga Penelitian dan Pengabdian kepada Masyarakat) adalah sebuah bagian di universitas yang bertanggung jawab untuk merencanakan, mengkoordinasikan, dan mengimplementasikan kegiatan penelitian dan pengabdian kepada masyarakat.', 'Divisi', 'admin1', '2023-01-06 07:14:40', 'admin1', '2023-06-22 16:07:42', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_kat_id_foreign` (`kat_id`);

--
-- Indexes for table `gedung`
--
ALTER TABLE `gedung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gedung_kat_id_foreign` (`kat_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasi_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `pelaporan_kerusakan`
--
ALTER TABLE `pelaporan_kerusakan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelaporan_kerusakan_stokbrg_id_foreign` (`stokbrg_id`),
  ADD KEY `pelaporan_kerusakan_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_anggota_id_foreign` (`anggota_id`),
  ADD KEY `peminjaman_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permintaan_barang_id_foreign` (`barang_id`),
  ADD KEY `permintaan_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `riwayat_barang`
--
ALTER TABLE `riwayat_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_gedung_id_foreign` (`gedung_id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_barang_barang_id_foreign` (`barang_id`),
  ADD KEY `stok_barang_ruang_id_foreign` (`ruang_id`),
  ADD KEY `stok_barang_satuan_id_foreign` (`satuan_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gedung`
--
ALTER TABLE `gedung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pelaporan_kerusakan`
--
ALTER TABLE `pelaporan_kerusakan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `riwayat_barang`
--
ALTER TABLE `riwayat_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=468;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_kat_id_foreign` FOREIGN KEY (`kat_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gedung`
--
ALTER TABLE `gedung`
  ADD CONSTRAINT `gedung_kat_id_foreign` FOREIGN KEY (`kat_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `pelaporan_kerusakan` (`id`),
  ADD CONSTRAINT `notifikasi_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`);

--
-- Constraints for table `pelaporan_kerusakan`
--
ALTER TABLE `pelaporan_kerusakan`
  ADD CONSTRAINT `pelaporan_kerusakan_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `pelaporan_kerusakan_stokbrg_id_foreign` FOREIGN KEY (`stokbrg_id`) REFERENCES `stok_barang` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `peminjaman_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);

--
-- Constraints for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `permintaan_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `permintaan_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);

--
-- Constraints for table `ruang`
--
ALTER TABLE `ruang`
  ADD CONSTRAINT `ruang_gedung_id_foreign` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`);

--
-- Constraints for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD CONSTRAINT `stok_barang_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_barang_ruang_id_foreign` FOREIGN KEY (`ruang_id`) REFERENCES `ruang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_barang_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
