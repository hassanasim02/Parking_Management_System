-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 03:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vpmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `logtable`
--

CREATE TABLE `logtable` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `comapny` varchar(50) DEFAULT NULL,
  `registration` varchar(50) DEFAULT NULL,
  `ParkingNumber` int(10) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Triggers `logtable`
--
DELIMITER $$
CREATE TRIGGER `log_entry` AFTER INSERT ON `logtable` FOR EACH ROW BEGIN
    INSERT INTO `logtable` (id, name, email, mobile, category, comapny, registration, ParkingNumber, reg_date)
    VALUES (NEW.id, NEW.name, NEW.email, NEW.mobile, NEW.category, NEW.comapny, NEW.registration, NEW.ParkingNumber, NEW.reg_date);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7898799798, 'tester1@gmail.com', '123456', '2019-07-05 00:38:23'),
(2, 'Admin', 'admin', 7898799798, 'tester1@gmail.com', '123456', '2019-07-05 00:38:23'),
(3, 'Admin', 'admin', 7898799798, 'tester1@gmail.com', '123456', '2019-07-05 00:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL,
  `VehicleCat` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `VehicleCat`, `CreationDate`) VALUES
(1, 'Two Wheeler', '2024-11-16 23:24:23'),
(2, 'Four Wheeler', '2024-11-17 05:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomplaints_feedback`
--

CREATE TABLE `tblcomplaints_feedback` (
  `ComplaintID` int(11) NOT NULL,
  `VehicleID` int(11) NOT NULL,
  `ComplaintDescription` text NOT NULL,
  `ComplaintStatus` enum('Pending','Resolved') NOT NULL DEFAULT 'Pending',
  `DateSubmitted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcomplaints_feedback`
--

INSERT INTO `tblcomplaints_feedback` (`ComplaintID`, `VehicleID`, `ComplaintDescription`, `ComplaintStatus`, `DateSubmitted`) VALUES
(2, 1, 'mirror broken', 'Resolved', '2024-11-17 07:06:25');

-- --------------------------------------------------------

--
-- Table structure for table `tblparkingslot`
--

CREATE TABLE `tblparkingslot` (
  `SlotID` int(11) NOT NULL,
  `SlotNumber` int(11) NOT NULL,
  `Status` enum('Available','Occupied') NOT NULL DEFAULT 'Available',
  `VehicleID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblparkingslot`
--

INSERT INTO `tblparkingslot` (`SlotID`, `SlotNumber`, `Status`, `VehicleID`) VALUES
(1, 556, 'Available', NULL),
(2, 2, 'Available', NULL),
(3, 2, 'Available', NULL),
(4, 555, 'Occupied', NULL),
(5, 564, 'Available', NULL),
(6, 101, 'Occupied', 1),
(7, 102, 'Available', NULL),
(8, 565, 'Available', NULL),
(9, 104, 'Available', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `PaymentID` int(11) NOT NULL,
  `PaymentAmount` decimal(10,2) NOT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PaymentStatus` enum('Pending','Paid','Failed') NOT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `VehicleID` int(11) NOT NULL,
  `InvoiceNumber` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`PaymentID`, `PaymentAmount`, `PaymentDate`, `PaymentStatus`, `PaymentMethod`, `VehicleID`, `InvoiceNumber`) VALUES
(2, 440.00, '2024-11-16 23:54:53', 'Pending', 'Cash', 1, '810624');

-- --------------------------------------------------------

--
-- Table structure for table `tblvehicle`
--

CREATE TABLE `tblvehicle` (
  `ID` int(10) NOT NULL,
  `ParkingNumber` varchar(120) DEFAULT NULL,
  `VehicleCategory` int(10) NOT NULL,
  `VehicleCompanyname` varchar(120) DEFAULT NULL,
  `RegistrationNumber` varchar(120) DEFAULT NULL,
  `OwnerName` varchar(120) DEFAULT NULL,
  `OwnerContactNumber` bigint(10) DEFAULT NULL,
  `InTime` timestamp NULL DEFAULT current_timestamp(),
  `OutTime` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ParkingCharge` varchar(120) NOT NULL,
  `Remark` mediumtext NOT NULL,
  `Status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblvehicle`
--

INSERT INTO `tblvehicle` (`ID`, `ParkingNumber`, `VehicleCategory`, `VehicleCompanyname`, `RegistrationNumber`, `OwnerName`, `OwnerContactNumber`, `InTime`, `OutTime`, `ParkingCharge`, `Remark`, `Status`) VALUES
(1, '572561246', 1, 'xyz', '55555', 'ssss', 364556454, '2024-11-16 23:24:37', '2024-11-17 13:06:53', 'RS.20', 'Out', 'Out'),
(2, '674075522', 1, 'abc', '5545', 'Hassan', 123456, '2024-11-17 11:27:38', NULL, '', '', ''),
(3, '572561246', 1, 'Honda', 'ABC-123', 'Ali Khan', 3001234567, '2024-11-17 03:00:00', '2024-11-17 07:00:00', '50', 'Quick Exit', 'Out'),
(4, '674075522', 2, 'Toyota', 'XYZ-789', 'Sara Ahmed', 3007654321, '2024-11-16 04:30:00', NULL, '70', 'Parked', 'In');

-- --------------------------------------------------------

--
-- Table structure for table `tblvisitor`
--

CREATE TABLE `tblvisitor` (
  `VisitorID` int(11) NOT NULL,
  `Name` varchar(120) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL,
  `VehicleDetails` varchar(200) NOT NULL,
  `ParkingSlotID` int(11) NOT NULL,
  `EntryTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ExitTime` timestamp NULL DEFAULT NULL,
  `ParkingCharge` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblvisitor`
--

INSERT INTO `tblvisitor` (`VisitorID`, `Name`, `ContactNumber`, `VehicleDetails`, `ParkingSlotID`, `EntryTime`, `ExitTime`, `ParkingCharge`) VALUES
(1, 'Muhammad Hassan Asim ', '3120827639', '4561', 4, '2024-11-17 08:41:36', '2024-11-17 08:42:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `comapny` varchar(50) DEFAULT NULL,
  `registration` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `category`, `comapny`, `registration`, `reg_date`, `role`) VALUES
(2, 'newk', 'new@xyz.xomm', '12345', 'Four Wheeler Vehicle', 'hond', '87454378', '2019-10-05 03:38:21', 'user'),
(3, 'again', 'again@xyz.com', '123456789', 'Bicycles', 'sdf', '234567', '2019-10-05 03:09:45', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logtable`
--
ALTER TABLE `logtable`
  ADD PRIMARY KEY (`id`,`ParkingNumber`),
  ADD KEY `fk_logtable_vehicle` (`ParkingNumber`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcomplaints_feedback`
--
ALTER TABLE `tblcomplaints_feedback`
  ADD PRIMARY KEY (`ComplaintID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `tblparkingslot`
--
ALTER TABLE `tblparkingslot`
  ADD PRIMARY KEY (`SlotID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `tblvehicle`
--
ALTER TABLE `tblvehicle`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_vehicle_category` (`VehicleCategory`);

--
-- Indexes for table `tblvisitor`
--
ALTER TABLE `tblvisitor`
  ADD PRIMARY KEY (`VisitorID`),
  ADD KEY `ParkingSlotID` (`ParkingSlotID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcomplaints_feedback`
--
ALTER TABLE `tblcomplaints_feedback`
  MODIFY `ComplaintID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblparkingslot`
--
ALTER TABLE `tblparkingslot`
  MODIFY `SlotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblvehicle`
--
ALTER TABLE `tblvehicle`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblvisitor`
--
ALTER TABLE `tblvisitor`
  MODIFY `VisitorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logtable`
--
ALTER TABLE `logtable`
  ADD CONSTRAINT `fk_logtable_users` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_logtable_vehicle` FOREIGN KEY (`ParkingNumber`) REFERENCES `tblvehicle` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblcomplaints_feedback`
--
ALTER TABLE `tblcomplaints_feedback`
  ADD CONSTRAINT `tblcomplaints_feedback_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `tblvehicle` (`ID`);

--
-- Constraints for table `tblparkingslot`
--
ALTER TABLE `tblparkingslot`
  ADD CONSTRAINT `tblparkingslot_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `tblvehicle` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD CONSTRAINT `tblpayment_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `tblvehicle` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `tblvehicle`
--
ALTER TABLE `tblvehicle`
  ADD CONSTRAINT `fk_vehicle_category` FOREIGN KEY (`VehicleCategory`) REFERENCES `tblcategory` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblvisitor`
--
ALTER TABLE `tblvisitor`
  ADD CONSTRAINT `tblvisitor_ibfk_1` FOREIGN KEY (`ParkingSlotID`) REFERENCES `tblparkingslot` (`SlotID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
