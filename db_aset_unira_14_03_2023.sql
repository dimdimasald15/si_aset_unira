-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2023 at 01:41 PM
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
-- Table structure for table `gedung`
--

CREATE TABLE `gedung` (
  `id` int(11) UNSIGNED NOT NULL,
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
  `deskripsi` text NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kd_kategori`, `nama_kategori`, `deskripsi`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'A', 'Tanah dan Bangunan', 'Kategori A meliputi Tanah dan Bangunan yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(2, 'A.01', 'Tanah ', 'Kategori A.01 meliputi Tanah  yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(3, 'A.01.01', 'Tanah Kampus I', 'Kategori A.01.01 meliputi Tanah Kampus I yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(4, 'A.01.02 ', 'Tanah Kampus II ', 'Kategori A.01.02  meliputi Tanah Kampus II  yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(5, 'A.02', 'Bangunan', 'Kategori A.02 meliputi Bangunan yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(6, 'A.02.01', 'Bangunan Kampus I ', 'Kategori A.02.01 meliputi Bangunan Kampus I  yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(7, 'A.02.01.01', 'Gedung A', 'Kategori A.02.01.01 meliputi Gedung A yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(8, 'A.02.01.02', 'Gedung B', 'Kategori A.02.01.02 meliputi Gedung B yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(9, 'A.02.01.03', 'Gedung C', 'Kategori A.02.01.03 meliputi Gedung C yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(10, 'A.02.01.04', 'Pos Keamanan', 'Kategori A.02.01.04 meliputi Pos Keamanan yang dimiliki oleh Bangunan Kampus I  UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(11, 'A.03', 'Bangunan Tempat Tinggal ', 'Kategori A.03 meliputi Bangunan Tempat Tinggal  yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(12, 'A.03.01', 'Rusunawa ', 'Kategori A.03.01 meliputi Rusunawa  yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(13, 'B', 'Alat-alat', 'Kategori B meliputi Alat-alat yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(14, 'B.01', 'Alat Besar ', 'Kategori B.01 meliputi Alat Besar  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(15, 'B.02', 'Alat-Alat Laboratorium ', 'Kategori B.02 meliputi Alat-Alat Laboratorium  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(16, 'B.03', 'Alat Peraga', 'Kategori B.03 meliputi Alat Peraga yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(17, 'B.03.01', 'Alat Peraga Bidang Pendidikan ', 'Kategori B.03.01 meliputi Alat Peraga Bidang Pendidikan  yang merupakan jenis Alat Peraga yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(18, 'B.04', 'Alat Kesenian/Musik', 'Kategori B.04 meliputi Alat Kesenian/Musik yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(19, 'B.04.01', 'Alat Musik Modern', 'Kategori B.04.01 meliputi Alat Musik Modern yang merupakan jenis Alat Kesenian/Musik yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(20, 'B.04.02', 'Alat Musik Tradisional', 'Kategori B.04.02 meliputi Alat Musik Tradisional yang merupakan jenis Alat Kesenian/Musik yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(21, 'B.05', 'Alat Olahraga ', 'Kategori B.05 meliputi Alat Olahraga  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(22, 'B.06', 'Alat Telekomunikasi ', 'Kategori B.06 meliputi Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(23, 'B.06.01', 'Operator Set ', 'Kategori B.06.01 meliputi Operator Set  yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(24, 'B.06.02', 'Pesawat Telephone/HP ', 'Kategori B.06.02 meliputi Pesawat Telephone/HP  yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(25, 'B.06.03', 'Handy Talky ', 'Kategori B.06.03 meliputi Handy Talky  yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(26, 'B.06.04', 'Camera Video Conference', 'Kategori B.06.04 meliputi Camera Video Conference yang merupakan jenis Alat Telekomunikasi  yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(27, 'B.07', 'Alat Kesehatan', 'Kategori B.07 meliputi Alat Kesehatan yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(28, 'B.07.01', 'Termometer Badan', 'Kategori B.07.01 meliputi Termometer Badan yang merupakan jenis Alat Kesehatan yang termasuk Alat-alat di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(29, 'C', 'Peralatan Kantor', 'Kategori C meliputi Peralatan Kantor yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(30, 'C.01', 'Mebeler ', 'Kategori C.01 meliputi Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(31, 'C.01.01', 'Almari', 'Kategori C.01.01 meliputi Almari yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(32, 'C.01.01.01', 'Lemari Rak Besar / Rak Buku Besar', 'Kategori C.01.01.01 meliputi Lemari Rak Besar / Rak Buku Besar yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(33, 'C.01.01.02', 'Lemari Rak Sedang  / Rak Buku Sedang', 'Kategori C.01.01.02 meliputi Lemari Rak Sedang  / Rak Buku Sedang yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(34, 'C.01.01.03', 'Lemari Rak Kecil / Rak Buku Kecil', 'Kategori C.01.01.03 meliputi Lemari Rak Kecil / Rak Buku Kecil yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(35, 'C.01.01.04', 'Lemari Arsip Besar ', 'Kategori C.01.01.04 meliputi Lemari Arsip Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(36, 'C.01.01.05', 'Lemari Arsip Sedang', 'Kategori C.01.01.05 meliputi Lemari Arsip Sedang yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(37, 'C.01.01.06', 'Lemari Arsip Kecil ', 'Kategori C.01.01.06 meliputi Lemari Arsip Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(38, 'C.01.01.07', 'Lemari Arsip Besi Besar ', 'Kategori C.01.01.07 meliputi Lemari Arsip Besi Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(39, 'C.01.01.08', 'Lemari Arsip Besi Sedang ', 'Kategori C.01.01.08 meliputi Lemari Arsip Besi Sedang  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(40, 'C.01.01.09', 'Lemari Arsip Besi Kecil ', 'Kategori C.01.01.09 meliputi Lemari Arsip Besi Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(41, 'C.01.01.10', 'Lemari Barang Besar ', 'Kategori C.01.01.10 meliputi Lemari Barang Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(42, 'C.01.01.11', 'Lemari Barang Sedang ', 'Kategori C.01.01.11 meliputi Lemari Barang Sedang  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(43, 'C.01.01.12', 'Lemari Barang Kecil', 'Kategori C.01.01.12 meliputi Lemari Barang Kecil yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(44, 'C.01.01.13', 'Lemari File Kabinet Besar', 'Kategori C.01.01.13 meliputi Lemari File Kabinet Besar yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(45, 'C.01.01.14', 'Lemari File Kabinet Sedang', 'Kategori C.01.01.14 meliputi Lemari File Kabinet Sedang yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(46, 'C.01.01.15', 'Lemari File Kabinet Kecil ', 'Kategori C.01.01.15 meliputi Lemari File Kabinet Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(47, 'C.01.01.16', 'Lemari Alat Besar ', 'Kategori C.01.01.16 meliputi Lemari Alat Besar  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(48, 'C.01.01.17', 'Lemari Alat Sedang ', 'Kategori C.01.01.17 meliputi Lemari Alat Sedang  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(49, 'C.01.01.18', 'Lemari Alat Kecil ', 'Kategori C.01.01.18 meliputi Lemari Alat Kecil  yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(50, 'C.01.01.19', 'Lemari TV', 'Kategori C.01.01.19 meliputi Lemari TV yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(51, 'C.01.01.20', 'Etalase', 'Kategori C.01.01.20 meliputi Etalase yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(52, 'C.01.01.21', 'Brankas', 'Kategori C.01.01.21 meliputi Brankas yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(53, 'C.01.01.22', 'Loker', 'Kategori C.01.01.22 meliputi Loker yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(54, 'C.01.01.23', 'Lemari lain-lain', 'Kategori C.01.01.23 meliputi Lemari lain-lain yang termasuk kategori Almari dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(55, 'C.01.02', 'Meja', 'Kategori C.01.02 meliputi Meja yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(56, 'C.01.02.01', 'Meja 1 Biro ', 'Kategori C.01.02.01 meliputi Meja 1 Biro  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(57, 'C.01.02.02', 'Meja ? Biro ', 'Kategori C.01.02.02 meliputi Meja ? Biro  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(58, 'C.01.02.03', 'Meja Komputer', 'Kategori C.01.02.03 meliputi Meja Komputer yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(59, 'C.01.02.04', 'Meja Laboratorium Besar ', 'Kategori C.01.02.04 meliputi Meja Laboratorium Besar  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(60, 'C.01.02.05', 'Meja Laboratorium Sedang', 'Kategori C.01.02.05 meliputi Meja Laboratorium Sedang yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(61, 'C.01.02.06', 'Meja Laboratorium Kecil ', 'Kategori C.01.02.06 meliputi Meja Laboratorium Kecil  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(62, 'C.01.02.07', 'Meja Sidang Panjang ', 'Kategori C.01.02.07 meliputi Meja Sidang Panjang  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(63, 'C.01.02.08', 'Meja Baca Perpustakaan ', 'Kategori C.01.02.08 meliputi Meja Baca Perpustakaan  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(64, 'C.01.02.09', 'Podium ', 'Kategori C.01.02.09 meliputi Podium  yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(65, 'C.01.02.10', 'Meja Front Office Besar', 'Kategori C.01.02.10 meliputi Meja Front Office Besar yang termasuk kategori Meja dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(66, 'C.01.03', 'Kursi ', 'Kategori C.01.03 meliputi Kursi  yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(67, 'C.01.03.01', 'Kursi Putar Eksekutif ', 'Kategori C.01.03.01 meliputi Kursi Putar Eksekutif  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(68, 'C.01.03.02', 'Kursi Putar Biasa ', 'Kategori C.01.03.02 meliputi Kursi Putar Biasa  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(69, 'C.01.03.03', 'Kursi Lipat Stainless ', 'Kategori C.01.03.03 meliputi Kursi Lipat Stainless  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(70, 'C.01.03.04', 'Kursi Kuliah Lipat Stainless ', 'Kategori C.01.03.04 meliputi Kursi Kuliah Lipat Stainless  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(71, 'C.01.03.05', 'Kursi Kuliah Kayu', 'Kategori C.01.03.05 meliputi Kursi Kuliah Kayu yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(72, 'C.01.03.06', 'Kursi Audience ', 'Kategori C.01.03.06 meliputi Kursi Audience  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(73, 'C.01.03.07', 'Kursi Laboratorium Kayu ', 'Kategori C.01.03.07 meliputi Kursi Laboratorium Kayu  yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(74, 'C.01.03.08', 'Kursi Laboratorium Besi', 'Kategori C.01.03.08 meliputi Kursi Laboratorium Besi yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(75, 'C.01.03.09', 'Kursi Tunggu', 'Kategori C.01.03.09 meliputi Kursi Tunggu yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(76, 'C.01.03.10', 'Kursi Sofa', 'Kategori C.01.03.10 meliputi Kursi Sofa yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(77, 'C.01.03.11', 'Kursi Lain-Lain', 'Kategori C.01.03.11 meliputi Kursi Lain-Lain yang termasuk kategori Kursi  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(78, 'C.01.04', 'Papan Tulis/White Board Gantung ', 'Kategori C.01.04 meliputi Papan Tulis/White Board Gantung  yang merupakan jenis Mebeler  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(79, 'C.01.04.01', 'Papan Tulis/White Board Gantung Biasa', 'Kategori C.01.04.01 meliputi Papan Tulis/White Board Gantung Biasa yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(80, 'C.01.04.02', 'Papan Tulis/White Board Beroda Besar', 'Kategori C.01.04.02 meliputi Papan Tulis/White Board Beroda Besar yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(81, 'C.01.04.03', 'Papan Pengumuman Besar ', 'Kategori C.01.04.03 meliputi Papan Pengumuman Besar  yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(82, 'C.01.04.04', 'Papan Pengumuman Sedang ', 'Kategori C.01.04.04 meliputi Papan Pengumuman Sedang  yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(83, 'C.01.04.05', 'Papan Pengumuman Kecil ', 'Kategori C.01.04.05 meliputi Papan Pengumuman Kecil  yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(84, 'C.01.04.06', 'Papan Agenda', 'Kategori C.01.04.06 meliputi Papan Agenda yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(85, 'C.01.04.07', 'Benner, Papan Nama, Papan Struktural', 'Kategori C.01.04.07 meliputi Benner, Papan Nama, Papan Struktural yang termasuk kategori Papan Tulis/White Board Gantung  dan merupakan jenis Mebeler  dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(86, 'C.02', 'Alat Tulis Elektronik', 'Kategori C.02 meliputi Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(87, 'C.02.01', 'PC All in One', 'Kategori C.02.01 meliputi PC All in One yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(88, 'C.02.02', 'PC', 'Kategori C.02.02 meliputi PC yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(89, 'C.02.03', 'Keyboard', 'Kategori C.02.03 meliputi Keyboard yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(90, 'C.02.04', 'Laptop/Note Book ', 'Kategori C.02.04 meliputi Laptop/Note Book  yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(91, 'C.02.05', 'Mesin Cetak', 'Kategori C.02.05 meliputi Mesin Cetak yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(92, 'C.02.06.01', 'Printer ', 'Kategori C.02.06.01 meliputi Printer  yang termasuk kategori Mesin Cetak dan merupakan jenis Alat Tulis Elektronik dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(93, 'C.02.06.02', 'Printer + Scanner', 'Kategori C.02.06.02 meliputi Printer + Scanner yang termasuk kategori Mesin Cetak dan merupakan jenis Alat Tulis Elektronik dan termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(94, 'C.02.07', 'Scanner ', 'Kategori C.02.07 meliputi Scanner  yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(95, 'C.02.08', 'Finger Print', 'Kategori C.02.08 meliputi Finger Print yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(96, 'C.02.09', 'Scanner Barcode', 'Kategori C.02.09 meliputi Scanner Barcode yang merupakan jenis Alat Tulis Elektronik yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(97, 'C.03', 'Barang Persediaan ', 'Kategori C.03 meliputi Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(98, 'C.03.01', 'Pompa Air ', 'Kategori C.03.01 meliputi Pompa Air  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(99, 'C.03.02', 'Pendingin Ruangan', 'Kategori C.03.02 meliputi Pendingin Ruangan yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(100, 'C.03.03', 'Dispender ', 'Kategori C.03.03 meliputi Dispender  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(101, 'C.03.04', 'Kabel Roll', 'Kategori C.03.04 meliputi Kabel Roll yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(102, 'C.03.05', 'Stavolt ', 'Kategori C.03.05 meliputi Stavolt  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(103, 'C.03.06', 'Layar LCD ', 'Kategori C.03.06 meliputi Layar LCD  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(104, 'C.03.07', 'UPS ', 'Kategori C.03.07 meliputi UPS  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(105, 'C.03.08', 'Karpet ', 'Kategori C.03.08 meliputi Karpet  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(106, 'C.03.09', 'Kulkas ', 'Kategori C.03.09 meliputi Kulkas  yang merupakan jenis Barang Persediaan  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(107, 'C.04', 'Peralatan Rumah Tangga, Wisma dan Asrama ', 'Kategori C.04 meliputi Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(108, 'C.04.01', 'Kasur', 'Kategori C.04.01 meliputi Kasur yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(109, 'C.04.02', 'Bantal ', 'Kategori C.04.02 meliputi Bantal  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(110, 'C.04.03', 'Selimut ', 'Kategori C.04.03 meliputi Selimut  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(111, 'C.04.04', 'Sprei ', 'Kategori C.04.04 meliputi Sprei  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(112, 'C.04.05', 'Springbed', 'Kategori C.04.05 meliputi Springbed yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(113, 'C.04.06', 'Korden ', 'Kategori C.04.06 meliputi Korden  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(114, 'C.04.07', 'Peralatan Makan dan Minum ', 'Kategori C.04.07 meliputi Peralatan Makan dan Minum  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(115, 'C.04.08', 'Keset ', 'Kategori C.04.08 meliputi Keset  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(116, 'C.04.09', 'Tempat sampah ', 'Kategori C.04.09 meliputi Tempat sampah  yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(117, 'C.04.10', 'Kompor', 'Kategori C.04.10 meliputi Kompor yang merupakan jenis Peralatan Rumah Tangga, Wisma dan Asrama  yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(118, 'C.05', 'Perhiasan Ruangan', 'Kategori C.05 meliputi Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(119, 'C.05.01', 'Lambang Negara ', 'Kategori C.05.01 meliputi Lambang Negara  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(120, 'C.05.02', 'Lambang Organisasi', 'Kategori C.05.02 meliputi Lambang Organisasi yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(121, 'C.05.03', 'Lukisan Berbingkai', 'Kategori C.05.03 meliputi Lukisan Berbingkai yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(122, 'C.05.04', 'Peta Dinding ', 'Kategori C.05.04 meliputi Peta Dinding  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(123, 'C.05.05', 'Globe', 'Kategori C.05.05 meliputi Globe yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(124, 'C.05.06', 'Bunga dan Vas ', 'Kategori C.05.06 meliputi Bunga dan Vas  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(125, 'C.05.07', 'Jam Dinding', 'Kategori C.05.07 meliputi Jam Dinding yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(126, 'C.05.08', 'Tropi/Piala ', 'Kategori C.05.08 meliputi Tropi/Piala  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(127, 'C.05.09', 'Sketsel/Pembatas Ruangan', 'Kategori C.05.09 meliputi Sketsel/Pembatas Ruangan yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(128, 'C.05.10', 'Perhiasan ruangan lain-lain ', 'Kategori C.05.10 meliputi Perhiasan ruangan lain-lain  yang merupakan jenis Perhiasan Ruangan yang termasuk Peralatan Kantor di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(129, 'D', 'Audio Visual', 'Kategori D meliputi Audio Visual yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(130, 'D.01', 'Audio ', 'Kategori D.01 meliputi Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(131, 'D.01.01', 'Mic Kabel', 'Kategori D.01.01 meliputi Mic Kabel yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(132, 'D.01.01', 'Mic Wearless ', 'Kategori D.01.01 meliputi Mic Wearless  yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(133, 'D.01.03', 'Speaker', 'Kategori D.01.03 meliputi Speaker yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(134, 'D.01.03', 'Sound Active', 'Kategori D.01.03 meliputi Sound Active yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(135, 'D.01.04', 'Amplifier ', 'Kategori D.01.04 meliputi Amplifier  yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(136, 'D.01.04', 'Headset', 'Kategori D.01.04 meliputi Headset yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(137, 'D.01.04', 'Standing Mic', 'Kategori D.01.04 meliputi Standing Mic yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(138, 'D.01.04', 'Tripod Sound', 'Kategori D.01.04 meliputi Tripod Sound yang merupakan jenis kategori Audio  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(139, 'D.02', 'Visual ', 'Kategori D.02 meliputi Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(140, 'D.02.01', 'LCD Proyektor', 'Kategori D.02.01 meliputi LCD Proyektor yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(141, 'D.02.02', 'Monitor ', 'Kategori D.02.02 meliputi Monitor  yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(142, 'D.02.03', 'Camera Digital ', 'Kategori D.02.03 meliputi Camera Digital  yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(143, 'D.02.04', 'Handycam', 'Kategori D.02.04 meliputi Handycam yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(144, 'D.02.05', 'CCTV', 'Kategori D.02.05 meliputi CCTV yang merupakan jenis kategori Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(145, 'D.03', 'Audio-Visual ', 'Kategori D.03 meliputi Audio-Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(146, 'D.03.01', 'Televisi ', 'Kategori D.03.01 meliputi Televisi  yang merupakan jenis kategori Audio-Visual  yang termasuk Audio Visual di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(147, 'E', 'Kendaraan', 'Kategori E meliputi Kendaraan yang dimiliki oleh UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL),
(148, 'E.01', 'Mobil ', 'Kategori E.01 meliputi Mobil  yang termasuk Kendaraan di UNIRA Malang', 'Admin', '2023-03-12 00:00:00', NULL, NULL, NULL, NULL);

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
(9, '2023-03-03-173211', 'App\\Database\\Migrations\\Gedung', 'default', 'App', 1677890008, 1),
(10, '2023-03-03-173218', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1677890008, 1),
(11, '2023-03-04-031647', 'App\\Database\\Migrations\\Ruang', 'default', 'App', 1677899913, 2),
(12, '2023-03-04-031651', 'App\\Database\\Migrations\\Petugas', 'default', 'App', 1677899913, 2);

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
  `role` varchar(50) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nip`, `email`, `username`, `password`, `role`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, '1111111', 'admin@mail.com', 'admin1', '$2y$10$zsfyuW2EKbUmdSflwBlbwO79HnBbCIMuSF5UxR3dnie.dp6xb5Jhm', 'Administrator', 'Admin', '2023-03-05 09:28:02', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` int(11) NOT NULL,
  `nama_ruang` varchar(50) NOT NULL,
  `nama_lantai` varchar(100) NOT NULL,
  `gedung_id` int(10) UNSIGNED NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `nama_ruang`, `nama_lantai`, `gedung_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'BSI', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(2, 'Ruang Rektor', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(3, 'Ruang Yayasan', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(4, 'Ruang Rapat', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(5, 'Lobby UNIRA', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(6, 'Ruang Administrasi', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(7, 'Rektorat', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(8, 'KaBiro 3', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(9, 'PDTI', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(10, 'Toilet', '1', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(11, 'Humas', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(12, 'FEB', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(13, 'FIK', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(14, 'Ruang GIS', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(15, 'Mini Bank Syariah', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(16, 'A 2-2 (Micro Teaching)', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(17, 'LPM', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(18, 'Pasca Sarjana', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(19, 'LPPM', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(20, 'SPI', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(21, 'PAKU', '2', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(23, 'AULA KH. Moch. Said', '3', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(24, 'Gudang', '3', 1, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(26, 'FISIP', '1', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(27, 'FIP', '1', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(28, 'Lab TE', '1', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(29, 'Lab Mesin', '1', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(31, 'B 2-1A', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(32, 'B 2-1B', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(33, 'B 2-2A', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(34, 'B 2-2B', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(35, 'B 2-3A', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(36, 'B 2-3B', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(37, 'Ruang UKM', '2', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(38, 'B 3-1B', '3', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(39, 'B 3-1A', '3', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(40, 'B 3-3', '3', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(42, 'BEM', '3', 2, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(43, 'Digital Center', '1', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(44, 'Perpustakaan', '1', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(45, 'Kemahasiswaan', '1', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(46, 'F. Saintek', '2', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(47, 'C 2-2', '2', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(48, 'C 2-3A', '2', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(49, 'C 2-3B', '2', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(50, 'C 3-1', '3', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(51, 'Lab TI', '3', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(52, 'C 3-3A', '3', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(53, 'C 3-3B (Lab Psikologi)', '3', 3, 'Admin', '2023-03-04 10:58:43', NULL, NULL, NULL, NULL),
(96, 'Ruang Tunggu 2', '2', 1, NULL, '2023-03-13 00:39:58', 'admin1', '2023-03-13 00:44:31', 'admin1', '2023-03-13 00:44:31'),
(97, 'Ruang Dekan 121', '2', 2, NULL, '2023-03-13 00:41:32', 'admin1', '2023-03-13 00:44:27', 'admin1', '2023-03-13 00:44:27'),
(98, 'Ruang Tunggu', '3', 3, 'admin1', '2023-03-13 00:42:09', 'admin1', '2023-03-13 00:44:22', 'admin1', '2023-03-13 00:44:22'),
(99, 'Ruang Tunggu 433', '3', 2, 'admin1', '2023-03-13 00:43:27', 'admin1', '2023-03-13 00:44:12', 'admin1', '2023-03-13 00:44:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gedung`
--
ALTER TABLE `gedung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gedung_kat_id` (`kat_id`);

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
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gedung_id` (`gedung_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gedung`
--
ALTER TABLE `gedung`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gedung`
--
ALTER TABLE `gedung`
  ADD CONSTRAINT `fk_gedung_kat_id` FOREIGN KEY (`kat_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `ruang`
--
ALTER TABLE `ruang`
  ADD CONSTRAINT `ruang_ibfk_1` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
