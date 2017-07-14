-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2017 at 11:42 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `search_location`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `Loc_ID` int(11) NOT NULL,
  `Loc_Location` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `Loc_Latitude` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Loc_Longitude` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Loc_Address` text COLLATE utf8_unicode_ci NOT NULL,
  `Loc_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`Loc_ID`, `Loc_Location`, `Loc_Latitude`, `Loc_Longitude`, `Loc_Address`, `Loc_Date`) VALUES
(1, 'บางบ่อ', '13.5847536', '100.85180889999992', 'ตำบล บางบ่อ อำเภอ บางบ่อ สมุทรปราการ ประเทศไทย', '2017-07-13 16:38:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`Loc_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `Loc_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
