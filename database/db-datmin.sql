-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2017 at 02:52 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db-datmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_claster`
--

CREATE TABLE IF NOT EXISTS `kriteria_claster` (
  `krcID` varchar(30) NOT NULL,
  `krcKode` varchar(10) NOT NULL,
  `krcNama` varchar(255) NOT NULL,
  `krcLama` int(11) NOT NULL,
  `krcNCluster` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria_claster`
--

INSERT INTO `kriteria_claster` (`krcID`, `krcKode`, `krcNama`, `krcLama`, `krcNCluster`) VALUES
('593d1df31ba10', 'C1', 'Lama Peminjaman 2 Hari', 2, 1),
('593d1e1620063', 'C2', 'Lama Peminjaman 4 Hari', 4, 2),
('593d1e594a38d', 'C3', 'Lama Peminjaman 5 Hari', 5, 3),
('593e96d51933e', 'C4', 'Lama Peminjaman 10 Hari', 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `penID` varchar(30) NOT NULL,
  `penUsername` varchar(100) NOT NULL,
  `penPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`penID`, `penUsername`, `penPassword`) VALUES
('qwerty12345', 'admin', 'lKHWNyXd67FBDtboOy6ufG04k7dBWtU12S7MO9_aX9g,');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_buku`
--

CREATE TABLE IF NOT EXISTS `transaksi_buku` (
  `trbID` varchar(30) NOT NULL,
  `trbKodeBuku` varchar(10) DEFAULT NULL,
  `trbNamaBuku` text,
  `trbTopikBuku` text,
  `trbPenulisBuku` text,
  `trbJmlStok` varchar(10) DEFAULT NULL,
  `trbJmlDiminati` varchar(10) DEFAULT NULL,
  `trbJmlAnggota` varchar(10) DEFAULT NULL,
  `trbTglInput` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_buku_cluster`
--

CREATE TABLE IF NOT EXISTS `transaksi_buku_cluster` (
  `tbcID` varchar(30) NOT NULL,
  `tbcKrcID` varchar(30) NOT NULL,
  `tbcTrbID` varchar(30) NOT NULL,
  `tbcTglCluster` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kriteria_claster`
--
ALTER TABLE `kriteria_claster`
  ADD PRIMARY KEY (`krcID`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`penID`);

--
-- Indexes for table `transaksi_buku`
--
ALTER TABLE `transaksi_buku`
  ADD PRIMARY KEY (`trbID`);

--
-- Indexes for table `transaksi_buku_cluster`
--
ALTER TABLE `transaksi_buku_cluster`
  ADD PRIMARY KEY (`tbcID`), ADD KEY `tbcKrcID` (`tbcKrcID`), ADD KEY `tbcTrbID` (`tbcTrbID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi_buku_cluster`
--
ALTER TABLE `transaksi_buku_cluster`
ADD CONSTRAINT `transaksi_buku_cluster_ibfk_1` FOREIGN KEY (`tbcKrcID`) REFERENCES `kriteria_claster` (`krcID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `transaksi_buku_cluster_ibfk_2` FOREIGN KEY (`tbcTrbID`) REFERENCES `transaksi_buku` (`trbID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
