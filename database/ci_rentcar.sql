-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2020 at 12:19 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 5.6.40-26+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_rentcar`
--

-- --------------------------------------------------------

--
-- Table structure for table `M_MasterCar`
--

CREATE TABLE `M_MasterCar` (
  `CarID` int(11) NOT NULL,
  `CarName` varchar(30) DEFAULT NULL,
  `CarCat` varchar(20) DEFAULT NULL,
  `CarNumber` varchar(10) DEFAULT NULL,
  `CarSeat` int(1) DEFAULT NULL,
  `CarBuyYear` int(4) DEFAULT NULL,
  `CarImage` varchar(100) DEFAULT NULL,
  `MerkID` int(11) DEFAULT NULL,
  `DailyRentalFee` double NOT NULL,
  `DailyRentalFines` double NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `M_MasterCar`
--

INSERT INTO `M_MasterCar` (`CarID`, `CarName`, `CarCat`, `CarNumber`, `CarSeat`, `CarBuyYear`, `CarImage`, `MerkID`, `DailyRentalFee`, `DailyRentalFines`, `IsActive`, `EntryDate`, `EntryBy`, `LastUpdateDate`, `LastUpdateBy`) VALUES
(16, 'Expander', 'Black', 'B 9080 KHA', 7, 2019, 'expander.jpg', 15, 400000, 450000, 'Y', '2020-04-24 17:33:28', 'brian', '2020-07-13 20:49:15', 'brian'),
(17, 'Kijang Inova', 'Black', 'B 9080 KIT', 8, 2017, 'kijang-inova.jpg', 8, 400000, 420000, 'Y', '2020-04-30 13:46:12', 'brian', '2020-07-13 20:50:28', 'brian'),
(18, 'Avanza', 'Silver', 'B 9167 KST', 7, 2017, 'New_Avanza.png', 8, 350000, 350000, 'Y', '2020-05-06 14:24:32', 'brian', '2020-07-13 20:51:30', 'brian'),
(19, 'Ertiga', 'BLACK', 'B 9675 KTT', 7, 2018, 'suzuki-ertiga.jpg', 9, 380000, 380000, 'Y', '2020-05-06 14:26:16', 'brian', '2020-07-13 20:52:25', 'brian'),
(20, 'Mobilio', 'RED', 'B 9688 KLV', 7, 2019, 'mobilio-honda.png', 12, 410000, 410000, 'Y', '2020-05-06 14:27:27', 'brian', '2020-07-13 20:54:50', 'brian'),
(21, 'Nissan Juke', 'merah', 'B 9067 KHA', 4, 20218, 'logo-rental.png', 18, 300000, 350000, 'Y', '2020-07-14 13:19:34', 'brian', '2020-07-14 13:19:56', 'brian');

-- --------------------------------------------------------

--
-- Table structure for table `M_MasterDriver`
--

CREATE TABLE `M_MasterDriver` (
  `DriverID` varchar(10) NOT NULL,
  `DriverName` varchar(200) NOT NULL,
  `IdentityID` varchar(20) NOT NULL,
  `MobilePhone` varchar(14) NOT NULL,
  `HomePhone` varchar(14) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` longtext NOT NULL,
  `DailyDrivingCosts` double NOT NULL,
  `DriverImage` varchar(200) NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `M_MasterDriver`
--

INSERT INTO `M_MasterDriver` (`DriverID`, `DriverName`, `IdentityID`, `MobilePhone`, `HomePhone`, `Email`, `Address`, `DailyDrivingCosts`, `DriverImage`, `IsActive`, `EntryBy`, `EntryDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
('DRV-000001', 'Suhadi', '3275119292009988', '08977896789', '0213773373', 'suhadi@gmail.com', 'Bekasi Utara', 170000, 'driver1.png', 'Y', '2020-04-27 14:23:29', '0000-00-00 00:00:00', 'brian', '2020-07-13 20:58:29'),
('DRV-000002', 'Suhari', '373738377377373', '08976888655', '02198677778', 'suhari@gmail.com', 'Bekasi Selatan', 150000, 'driver2.png', 'Y', 'brian', '2020-04-30 16:39:25', 'brian', '2020-07-13 20:59:11'),
('DRV-000003', 'Maman', '122552522522', '0219383833', '08565755885', 'maman@gmail.com', 'Tebing Tinggi', 120000, 'driver3.png', 'Y', 'brian', '2020-07-13 21:00:53', 'brian', '2020-07-13 21:00:53'),
('DRV-000004', 'Subagyo', '3275333117373', '021837337', '081784644748', 'subagyo@gmail.com', 'Jalan Raya Kampung Melayu', 120000, 'avatar5.png', 'Y', 'brian', '2020-07-14 13:24:03', 'brian', '2020-07-14 13:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `M_MasterMerk`
--

CREATE TABLE `M_MasterMerk` (
  `MerkID` int(11) NOT NULL,
  `MerkName` varchar(20) DEFAULT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `M_MasterMerk`
--

INSERT INTO `M_MasterMerk` (`MerkID`, `MerkName`, `IsActive`, `EntryDate`, `EntryBy`, `LastUpdateDate`, `LastUpdateBy`) VALUES
(8, 'Toyota', 'Y', '0000-00-00 00:00:00', '', '2020-07-09 21:41:23', 'brian'),
(9, 'Suzuki', 'Y', '0000-00-00 00:00:00', '', '2020-04-22 16:28:18', 'brian'),
(10, 'Daihatsu', 'Y', '0000-00-00 00:00:00', '', '2020-04-22 16:28:24', 'brian'),
(11, 'Wuling', 'Y', '0000-00-00 00:00:00', '2020-04-22', '2020-04-22 16:12:39', 'brian'),
(12, 'Honda', 'Y', '2020-04-22 16:12:50', 'brian', '2020-04-22 16:12:50', 'brian'),
(13, 'Ford', 'Y', '2020-04-22 16:13:16', 'brian', '2020-04-22 16:13:16', 'brian'),
(14, 'Mazda', 'Y', '2020-04-22 16:19:52', 'brian', '2020-04-22 16:19:52', 'brian'),
(15, 'Mitsubishi', 'Y', '2020-04-22 16:22:25', 'brian', '2020-04-22 16:22:25', 'brian'),
(16, 'Tata', 'Y', '2020-04-22 16:22:50', 'brian', '2020-07-13 20:56:00', 'brian'),
(17, 'Hyundai', 'Y', '2020-07-14 13:17:28', 'brian', '2020-07-14 13:17:28', 'brian'),
(18, 'Nissan', 'Y', '2020-07-14 13:18:05', 'brian', '2020-07-14 13:18:05', 'brian');

-- --------------------------------------------------------

--
-- Table structure for table `M_Months`
--

CREATE TABLE `M_Months` (
  `MonthID` int(11) NOT NULL,
  `MonthName` varchar(100) NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `M_Months`
--

INSERT INTO `M_Months` (`MonthID`, `MonthName`, `IsActive`, `EntryBy`, `EntryDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
(1, 'Januari', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(2, 'Febuari', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(3, 'Maret', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(4, 'April', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(5, 'Mei', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(6, 'Juni', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(7, 'Juli', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(8, 'Agustus', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(9, 'September', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(10, 'Oktober', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(11, 'November', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(12, 'Desember', 'Y', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `M_Setupprofile`
--

CREATE TABLE `M_Setupprofile` (
  `SetupprofileID` int(11) NOT NULL,
  `SetupTitle` varchar(200) NOT NULL,
  `SetupName` varchar(200) NOT NULL,
  `SetupDescription` longtext NOT NULL,
  `SetupImageDasbor` varchar(1) NOT NULL,
  `SetupImage` longtext NOT NULL,
  `SetupImageLogo` longtext NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `M_Setupprofile`
--

INSERT INTO `M_Setupprofile` (`SetupprofileID`, `SetupTitle`, `SetupName`, `SetupDescription`, `SetupImageDasbor`, `SetupImage`, `SetupImageLogo`, `IsActive`, `EntryBy`, `EntryDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
(1, 'Rent Car Bryn', 'Aplikasi Rental Car Bryn', 'Aplikasi Rental Car Bryn', '', 'logo2.png', 'icon-logo.png', 'Y', 'brian', '2020-07-09 23:08:42', 'brian', '2020-07-13 21:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `M_User`
--

CREATE TABLE `M_User` (
  `AdminID` int(11) NOT NULL,
  `AdminName` varchar(100) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varbinary(50) NOT NULL,
  `SuperUser` varchar(1) NOT NULL,
  `AdminImage` longtext NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryBy` varchar(30) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `LastUpdateBy` varchar(30) NOT NULL,
  `LastUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `M_User`
--

INSERT INTO `M_User` (`AdminID`, `AdminName`, `DateOfBirth`, `email`, `UserName`, `Password`, `SuperUser`, `AdminImage`, `IsActive`, `EntryBy`, `EntryDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
(2, 'abrian Inf', '2020-07-20', 'abriantama@gmail.com', 'brian', 0x6362643434663862356234386135316637646162393861626364663435643465, 'Y', 'cs5.png', 'Y', 'admin', '2020-01-10 16:37:32', 'brian', '2020-07-13 21:13:33'),
(6, 'efira', '1994-02-01', 'efivara.steela@gmail.com', 'efi', 0x6139353835656532366239396230326664313934363539303266326664346435, 'N', '', 'Y', 'brian', '2020-05-09 15:01:43', 'efi', '2020-07-14 13:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `T_CustomerOrder`
--

CREATE TABLE `T_CustomerOrder` (
  `OrderID` varchar(10) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `MobilePhone` varchar(14) NOT NULL,
  `HomePhone` varchar(14) NOT NULL,
  `Address` longtext NOT NULL,
  `IdentityID` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `OrderImage` varchar(200) NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `T_CustomerOrder`
--

INSERT INTO `T_CustomerOrder` (`OrderID`, `CustomerName`, `MobilePhone`, `HomePhone`, `Address`, `IdentityID`, `Email`, `Gender`, `OrderImage`, `IsActive`, `EntryBy`, `EntryDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
('CUS-000001', 'Abrian', '085778906494', '0211222', 'Bekasi Timur', '123456789', 'abrian@gmail.com', 'M', 'cs1.png', 'Y', 'brian', '2020-04-24 05:49:57', 'brian', '2020-07-13 21:14:10'),
('CUS-000002', 'Dani Herdiman', '08976758990', '0218774774', 'Jakarta Utara', '8973636367', 'danistrif@gmail.com', 'M', 'cs2.png', 'Y', 'brian', '2020-04-24 06:15:01', 'brian', '2020-07-13 21:14:51'),
('CUS-000003', 'Muhammad Ibrahim', '08976653431', '021933737', 'Jagakarsa Jakarta Selatan', '32751992982', 'm.ibrahim@gmail.com', 'M', 'cs6.png', 'Y', 'brian', '2020-05-06 14:30:01', 'brian', '2020-07-13 21:15:09'),
('CUS-000004', 'Anita Kusuma', '08134664789', '021937373', 'Jl. Boulevard Barat Raya Kelapa Gading ', '3276544884992', 'anita.ks@gmail.com', 'F', 'cs4.jpg', 'Y', 'brian', '2020-05-06 14:31:11', 'brian', '2020-07-13 21:15:33'),
('CUS-000005', 'Kartika Tjendana', '08186789067', '02183366734', 'Apartement Mall Of Indonesia No 326 Lt.8', '327684844789', 'tika.tjend@gmail.com', 'F', 'cs3.png', 'Y', 'brian', '2020-05-06 14:32:46', 'brian', '2020-07-13 21:15:45'),
('CUS-000006', 'Anto Wijaya', '0857575565', '02193737733', 'Bekasi Barat', '2626266222', 'antowijaya@gmail.com', 'M', 'cs7.png', 'Y', 'brian', '2020-07-13 21:17:02', 'brian', '2020-07-13 21:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `T_PaymentType`
--

CREATE TABLE `T_PaymentType` (
  `PaymentID` int(11) NOT NULL,
  `PaymentType` varchar(50) NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `T_PaymentType`
--

INSERT INTO `T_PaymentType` (`PaymentID`, `PaymentType`, `IsActive`, `EntryDate`, `EntryBy`, `LastUpdateDate`, `LastUpdateBy`) VALUES
(1, 'Card', 'Y', '2020-04-22 17:16:22', 'brian', '2020-07-09 22:31:02', 'brian'),
(2, 'Cash', 'Y', '2020-05-07 13:23:15', 'brian', '2020-07-09 22:30:59', 'brian'),
(3, 'Hutang', 'Y', '2020-07-09 22:13:02', 'brian', '2020-07-13 21:17:18', 'brian');

-- --------------------------------------------------------

--
-- Table structure for table `T_Rental`
--

CREATE TABLE `T_Rental` (
  `RentalID` varchar(10) NOT NULL,
  `OrderID` varchar(10) NOT NULL,
  `CarID` int(11) NOT NULL,
  `StartDate` varchar(10) NOT NULL,
  `EndDate` varchar(10) NOT NULL,
  `RentalCosts` double NOT NULL,
  `PaymentID` int(11) NOT NULL,
  `DriverID` varchar(20) NOT NULL,
  `DriverRentalFee` double NOT NULL,
  `TotalRentalFee` double NOT NULL,
  `Status` varchar(2) NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `T_Rental`
--

INSERT INTO `T_Rental` (`RentalID`, `OrderID`, `CarID`, `StartDate`, `EndDate`, `RentalCosts`, `PaymentID`, `DriverID`, `DriverRentalFee`, `TotalRentalFee`, `Status`, `IsActive`, `EntryDate`, `EntryBy`, `LastUpdateDate`, `LastUpdateBy`) VALUES
('RTL-000001', 'CUS-000006', 20, '2020-07-14', '2020-07-20', 410000, 1, '', 0, 2460000, '7', 'Y', '2020-07-13 21:32:15', 'brian', '2020-07-13 21:54:19', 'brian'),
('RTL-000007', 'CUS-000001', 19, '2020-07-15', '2020-07-18', 380000, 2, '', 0, 1140000, '7', 'Y', '2020-07-13 22:17:03', 'brian', '2020-07-13 22:21:50', 'brian'),
('RTL-000008', 'CUS-000005', 16, '2020-07-22', '2020-07-26', 400000, 1, '', 0, 1600000, '7', 'Y', '2020-07-13 22:25:33', 'brian', '2020-07-13 22:27:08', 'brian');

-- --------------------------------------------------------

--
-- Table structure for table `T_Return`
--

CREATE TABLE `T_Return` (
  `ReturnID` varchar(10) NOT NULL,
  `RentalID` varchar(10) NOT NULL,
  `ReturnDate` varchar(10) NOT NULL,
  `LateCharge` double NOT NULL,
  `Status` varchar(1) NOT NULL,
  `IsActive` varchar(1) NOT NULL,
  `EntryBy` varchar(20) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `LastUpdateBy` varchar(20) NOT NULL,
  `LastUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `T_Return`
--

INSERT INTO `T_Return` (`ReturnID`, `RentalID`, `ReturnDate`, `LateCharge`, `Status`, `IsActive`, `EntryBy`, `EntryDate`, `LastUpdateBy`, `LastUpdateDate`) VALUES
('RTN-000001', 'RTL-000001', '2020-07-20', 0, '7', 'Y', 'brian', '2020-07-13 21:54:09', 'brian', '2020-07-13 21:54:19'),
('RTN-000002', 'RTL-000007', '2020-07-19', 380000, '7', 'Y', 'brian', '2020-07-13 22:20:35', 'brian', '2020-07-13 22:21:50'),
('RTN-000003', 'RTL-000008', '2020-07-26', 0, '5', 'N', 'brian', '2020-07-13 22:26:19', 'brian', '2020-07-13 22:26:43'),
('RTN-000004', 'RTL-000008', '2020-07-27', 450000, '7', 'Y', 'brian', '2020-07-13 22:27:00', 'brian', '2020-07-13 22:27:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `M_MasterCar`
--
ALTER TABLE `M_MasterCar`
  ADD PRIMARY KEY (`CarID`),
  ADD KEY `tbl_mobil_ibfk_2` (`MerkID`);

--
-- Indexes for table `M_MasterDriver`
--
ALTER TABLE `M_MasterDriver`
  ADD PRIMARY KEY (`DriverID`);

--
-- Indexes for table `M_MasterMerk`
--
ALTER TABLE `M_MasterMerk`
  ADD PRIMARY KEY (`MerkID`);

--
-- Indexes for table `M_Months`
--
ALTER TABLE `M_Months`
  ADD PRIMARY KEY (`MonthID`);

--
-- Indexes for table `M_Setupprofile`
--
ALTER TABLE `M_Setupprofile`
  ADD PRIMARY KEY (`SetupprofileID`);

--
-- Indexes for table `M_User`
--
ALTER TABLE `M_User`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `T_CustomerOrder`
--
ALTER TABLE `T_CustomerOrder`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `T_PaymentType`
--
ALTER TABLE `T_PaymentType`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `T_Rental`
--
ALTER TABLE `T_Rental`
  ADD PRIMARY KEY (`RentalID`);

--
-- Indexes for table `T_Return`
--
ALTER TABLE `T_Return`
  ADD PRIMARY KEY (`ReturnID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `M_MasterCar`
--
ALTER TABLE `M_MasterCar`
  MODIFY `CarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `M_MasterMerk`
--
ALTER TABLE `M_MasterMerk`
  MODIFY `MerkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `M_Setupprofile`
--
ALTER TABLE `M_Setupprofile`
  MODIFY `SetupprofileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `M_User`
--
ALTER TABLE `M_User`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `T_PaymentType`
--
ALTER TABLE `T_PaymentType`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
