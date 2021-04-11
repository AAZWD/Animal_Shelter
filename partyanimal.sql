-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2017 at 03:59 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `partyanimal`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllVetsCareAllAnimals` ()  NO SQL
SELECT VID, First_Name, Last_Name
FROM Vet v 
WHERE NOT EXISTS 
(SELECT *
FROM Medical_Record mr
WHERE NOT EXISTS 
(SELECT * 
FROM Medical_Record mr 
WHERE mr.VID = v.VID ))$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAnimalAndMedInfo` ()  SELECT *
FROM animal_and_med_info$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAnimalInfo` ()  BEGIN
SELECT *
FROM animals;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetApplicationHistory` (IN `email` VARCHAR(50))  SELECT a.AppID, a.Application_Status, a.Date_Of_Creation, a.Email, c.AnimalID
FROM applications AS a LEFT JOIN created_for AS c ON c.AppID=a.AppID
WHERE a.Email = email$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetEmployees` ()  BEGIN
SELECT *
FROM employees;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetMedical` ()  BEGIN
SELECT *
FROM medical_record;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetNumberAdoptedEach` ()  NO SQL
SELECT t.Species, COUNT(t.AnimalID) AS Successfully_Adopted 
FROM (SELECT an.Species, cf.AnimalID 
FROM Animals an, Created_For cf, Applications app
WHERE an.AnimalID = cf.AnimalID 
AND cf.AppID = app.AppID 
AND app.Application_Status = 'Accepted') t
GROUP BY t.Species$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetReviewApplication` ()  BEGIN
SELECT applications.*, review.AppID AS RAppID, review.EmpID
FROM (Applications LEFT JOIN review 
       ON review.AppID=applications.AppID 
       );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetSuccess` ()  SELECT animals.Name AS 'names', animals.AnimalID AS 'ID', adopter.Success_Story AS 'story'
FROM adopter, animals, created_for
WHERE adopter.AppID = created_for.AppID AND animals.AnimalID = created_for.AnimalID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetVets` ()  BEGIN
SELECT *
FROM vet;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `adopter`
--

CREATE TABLE `adopter` (
  `AppID` int(11) NOT NULL,
  `Success_Story` varchar(767) DEFAULT NULL,
  `Date_Of_Approval` date DEFAULT NULL,
  `Date_Of_Adoption` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adopter`
--

INSERT INTO `adopter` (`AppID`, `Success_Story`, `Date_Of_Approval`, `Date_Of_Adoption`) VALUES
(1001, 'Adopting my dog, Honey-Boo-Boo, really changed my life. I can get out of bed and function like a normal human being now. Also, my hair is shinier.', '2017-10-27', '2017-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `AnimalID` int(11) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Species` varchar(20) NOT NULL,
  `Breed` varchar(50) DEFAULT NULL,
  `Sex` varchar(1) DEFAULT NULL,
  `Age` varchar(11) DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `Application_Status` varchar(25) DEFAULT 'No Applicants',
  `Housebroken` varchar(1) NOT NULL,
  `Temperament` varchar(50) DEFAULT NULL,
  `Intake_Date` date NOT NULL,
  `Intake_Condition` varchar(5) NOT NULL,
  `Intake_Location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`AnimalID`, `Name`, `Species`, `Breed`, `Sex`, `Age`, `Weight`, `Application_Status`, `Housebroken`, `Temperament`, `Intake_Date`, `Intake_Condition`, `Intake_Location`) VALUES
(10001, 'The Don', 'Cat', 'Siamese', 'M', 'Senior', 10.24, 'No Applicants', 'Y', 'Silent Companion', '2015-12-04', 'domst', 'RCAS Cat Sanctuary'),
(10003, 'Leo', 'Dog', 'Saint Bernard', 'M', 'Senior', 52.1, 'No Applicants', 'Y', 'Hidden Gem', '2015-02-19', 'stray', 'RCAS'),
(10005, 'Skipper', 'Dog', 'Siberian Husky', 'F', 'Young Adult', 23.9, 'Pending', 'Y', 'Gatorade', '2017-10-04', 'abusd', 'RCAS'),
(10006, 'Papa', 'Parrot', 'African Grey', 'M', 'Senior', 1, 'No Applicants', 'N', 'Secret Agent', '2017-02-14', 'surnd', 'DCAS'),
(10008, 'Neapolitan', 'Dog', 'Unknown', 'F', 'Adult', 30.2, 'No Applicants', 'N', 'Silent Companion', '2016-09-30', 'feral', 'West Van Sanctuary'),
(10009, 'Kirby', 'Cat', 'Maine Coon', 'M', 'Senior', 10.15, 'No Applicants', 'Y', 'Secret Agent', '2017-04-20', 'surnd', 'RCAS Cat Sanctuary'),
(10011, 'Boston', 'Dog', 'Unknown', 'M', 'Adult', 25.8, 'No Applicants', 'Y', 'Mac Daddy', '2017-09-18', 'domst', 'DCAS'),
(10012, 'Lucy', 'Cat', 'Sphynx', 'F', 'Juvenile', 6.66, 'No Applicants', 'Y', 'Mac Daddy', '2016-12-31', 'domst', 'West Van Sanctuary'),
(10013, 'Kathmandu', 'Cat', 'Manx', 'M', 'Adult', 12.4, 'No Applicants', 'Y', 'Mac Daddy', '2017-09-19', 'abusd', 'Party Animal Rescue'),
(10017, 'Missy', 'Dog', 'Pomeranian', 'F', 'Young Adult', 10.9, 'No Applicants', 'Y', 'Gatorade', '2017-04-13', 'surnd', 'West Van Sancuary'),
(10019, 'Nutmeg', 'Cat', 'Unknown', 'F', 'Juvenile', 3.04, 'Pending', 'N', 'Hidden Gem', '2017-10-14', 'stray', 'DCAS'),
(10022, 'Smudge', 'Cat', 'American Shorthair', 'M', 'Young Adult', 6.13, 'No Applicants', 'Y', 'Secret Agent', '2017-07-30', 'domst', 'DCAS'),
(10023, 'Honey Boo Boo', 'Dog', 'Jack Russell Terrier', 'F', 'Adult', 10, 'Adopted', 'Y', 'Silent Companion', '2016-09-22', 'surnd', 'West Van Sanctuary'),
(10025, 'Papaya', 'Lovebird', 'Masked', 'F', 'Juvenile', 0.55, 'No Applicants', 'N', 'Gatorade', '2017-02-28', 'domst', 'DCAS'),
(10027, 'Little Mac', 'Cat', 'Unknown', 'M', 'Young Adult', 5.43, 'No Applicants', 'Y', 'Gatorade', '2017-10-31', 'domst', 'RCAS'),
(10029, 'Baroness', 'Chinchilla', 'Long-tailed', 'F', 'Adult', 1.14, 'No Applicants', 'N', 'Secret Agent', '2017-01-09', 'surnd', 'DCAS'),
(10030, 'Suzumi', 'Dog', 'Shiba Inu', 'F', 'Juvenile', 9.8, 'No Applicants', 'N', 'Hidden Gem', '2016-08-10', 'domst', 'RCAS'),
(10031, 'Ronnie', 'Rabbit', 'Palomino', 'F', 'Young Adult', 4.65, 'No Applicants', 'N', 'Silent Companion', '2016-10-14', 'domst', 'West Van Sanctuary'),
(10034, 'Alan', 'Dog', 'Unknown', 'M', 'Young Adult', 12.8, 'No Appliants', 'Y', 'Mac Daddy', '2016-08-10', 'abusd', 'Party Animal Rescue'),
(10042, 'Rolo', 'Cat', 'Calico', 'F', 'Young Adult', 7.43, 'No Applicants', 'Y', 'Silent Companion', '2017-05-14', 'abusd', 'RCAS'),
(10046, 'Alexa', 'Dog', 'Whippet', 'F', 'Adult', 26.3, 'No Applicants', 'Y', 'Silent Companion', '2017-07-12', 'surnd', 'West Van Sanctuary'),
(10051, 'Betsy', 'Rabbit', 'Palomino', 'F', 'Young Adult', 5.3, 'No Applicants', 'N', 'Hidden Gem', '2016-10-14', 'domst', 'West Van Sanctuary'),
(10052, 'Roscoe', 'Cat', 'Unknown', 'M', 'Juvenile', 4.36, 'No Applicants', 'N', 'Gatorade', '2017-11-01', 'surnd', 'Party Animal Rescue'),
(10062, 'Pepper', 'Dog', 'Pit Bull', 'F', 'Adult', 46.2, 'No Applicants', 'Y', 'Hidden Gem', '2014-12-01', 'stray', 'Party Animal Rescue'),
(10082, 'Juliano', 'Cat', 'Unknown', 'M', 'Adult', 5.55, 'No Applicants', 'Y', 'Hidden Gem', '2016-08-12', 'feral', 'West Van Sanctuary');

-- --------------------------------------------------------

--
-- Stand-in structure for view `animal_and_med_info`
-- (See below for the actual view)
--
CREATE TABLE `animal_and_med_info` (
`AnimalID` int(11)
,`Name` varchar(25)
,`Species` varchar(20)
,`Breed` varchar(50)
,`Sex` varchar(1)
,`Age` varchar(11)
,`Weight` float
,`Application_Status` varchar(25)
,`Housebroken` varchar(1)
,`Temperament` varchar(50)
,`Intake_Date` date
,`Intake_Condition` varchar(5)
,`Intake_Location` varchar(50)
,`Animal` int(11)
,`VID` int(11)
,`Last_Checkup` date
,`Vaccinated` varchar(1)
,`Declawed` varchar(1)
,`Special_Needs` varchar(50)
,`Pregnant` varchar(1)
,`Offspring` int(11)
,`Tagged` varchar(1)
,`Tag_ID` int(11)
,`Parasites` varchar(50)
,`Major_Illness` varchar(50)
,`Spay_Neut` varchar(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `AppID` int(11) NOT NULL,
  `First_Name` varchar(16) NOT NULL,
  `Last_Name` varchar(32) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Postal_Code` varchar(8) NOT NULL,
  `BCID_DL` int(11) NOT NULL,
  `DOB` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone_Num` varchar(25) NOT NULL,
  `Household_size` int(11) NOT NULL,
  `Have_Small_Children` char(1) NOT NULL,
  `Home_Type` varchar(50) NOT NULL,
  `Home_Size` int(11) NOT NULL,
  `Own_Home` char(1) NOT NULL,
  `Landlord_Name` varchar(50) DEFAULT NULL,
  `Landlord_Contact` varchar(50) DEFAULT NULL,
  `Reference_Name` varchar(50) NOT NULL,
  `Reference_Contact` varchar(50) NOT NULL,
  `First_Time_Owner` char(1) NOT NULL,
  `Vet_Name` varchar(50) DEFAULT NULL,
  `Vet_Contact` varchar(50) DEFAULT NULL,
  `Have_Surrendered` char(1) NOT NULL,
  `Surrender_Reason` varchar(2500) DEFAULT NULL,
  `Application_Status` varchar(25) NOT NULL DEFAULT 'Pending',
  `Date_Of_Creation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`AppID`, `First_Name`, `Last_Name`, `Address`, `City`, `Postal_Code`, `BCID_DL`, `DOB`, `Email`, `Phone_Num`, `Household_size`, `Have_Small_Children`, `Home_Type`, `Home_Size`, `Own_Home`, `Landlord_Name`, `Landlord_Contact`, `Reference_Name`, `Reference_Contact`, `First_Time_Owner`, `Vet_Name`, `Vet_Contact`, `Have_Surrendered`, `Surrender_Reason`, `Application_Status`, `Date_Of_Creation`) VALUES
(1001, 'Nina', 'Rice', '78 W 14 Ave', 'Surrey', 'V6M2A9', 1627033640, '05071987', 'riceisnice@gmail.com', '6046851209', 3, 'Y', 'House', 5000, 'Y', NULL, NULL, 'George Mason', '7789017824', 'N', 'Katherine Li', '6049847587', 'N', NULL, 'Accepted', '2017-10-18'),
(1002, 'Phoebe', 'Terence', '2109 Hollow Way', 'North Vancouver', 'V9M2L0', 2147483647, '09181991', 'phoebeterrence@gmail.com', '7786851203', 5, 'Y', 'Duplex', 5000, 'Y', 'Marceline Li', NULL, 'Fred Ames', '7786759031', 'Y', NULL, NULL, 'N', 'Financial Troubles', 'Rejected', '2017-10-27'),
(1003, '4', '4', '4', '4', '4', 4, '4', 'test@test.com', '4', 4, 'Y', '4', 4, 'Y', '4', '4', '4', '4', 'N', '4', '4', 'N', '', 'Pending', '2017-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `bonded`
--

CREATE TABLE `bonded` (
  `Animal1` int(11) DEFAULT NULL,
  `Animal2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonded`
--

INSERT INTO `bonded` (`Animal1`, `Animal2`) VALUES
(10031, 10051);

-- --------------------------------------------------------

--
-- Table structure for table `created_for`
--

CREATE TABLE `created_for` (
  `AppID` int(11) NOT NULL,
  `AnimalID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `created_for`
--

INSERT INTO `created_for` (`AppID`, `AnimalID`) VALUES
(1001, 10023),
(1002, 10019),
(1003, 10005);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmpID` int(11) NOT NULL,
  `First_Name` varchar(25) NOT NULL,
  `Last_Name` varchar(25) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Phone_Num` varchar(15) NOT NULL,
  `Certification` varchar(100) NOT NULL,
  `Username` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmpID`, `First_Name`, `Last_Name`, `Email`, `Phone_Num`, `Certification`, `Username`) VALUES
(1, 'Cindy', 'Buns', 'cinnamon_buns@gmail.com', '7786851458', 'Associate Degree for Veterinary Technician', 'cbuns00'),
(2, 'Eva', 'Stahkovski', 'eva.s@hotmail.com', '6049587102', 'Assistant Laboratory Animal Technician Certificate', 'estahkovski00'),
(3, 'Mark', 'Chi', 'markomarkomarko@hotmail.com', '7785691248', 'BSc in Computer Science and Statistics', 'mchi00');

-- --------------------------------------------------------

--
-- Table structure for table `manages`
--

CREATE TABLE `manages` (
  `Supervisor_EmpID` int(11) NOT NULL,
  `Subordinate_EmpID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manages`
--

INSERT INTO `manages` (`Supervisor_EmpID`, `Subordinate_EmpID`) VALUES
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `medical_record`
--

CREATE TABLE `medical_record` (
  `Animal` int(11) NOT NULL,
  `VID` int(11) DEFAULT NULL,
  `Last_Checkup` date DEFAULT NULL,
  `Vaccinated` varchar(1) DEFAULT NULL,
  `Declawed` varchar(1) DEFAULT NULL,
  `Special_Needs` varchar(50) DEFAULT NULL,
  `Pregnant` varchar(1) DEFAULT NULL,
  `Offspring` int(11) DEFAULT NULL,
  `Tagged` varchar(1) DEFAULT NULL,
  `Tag_ID` int(11) DEFAULT NULL,
  `Parasites` varchar(50) DEFAULT NULL,
  `Major_Illness` varchar(50) DEFAULT NULL,
  `Spay_Neut` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medical_record`
--

INSERT INTO `medical_record` (`Animal`, `VID`, `Last_Checkup`, `Vaccinated`, `Declawed`, `Special_Needs`, `Pregnant`, `Offspring`, `Tagged`, `Tag_ID`, `Parasites`, `Major_Illness`, `Spay_Neut`) VALUES
(10001, 4, '2017-10-31', 'Y', 'N', NULL, 'N', 3, 'Y', 10142, NULL, 'Arthritis', 'Y'),
(10006, 4, '2017-10-20', 'Y', 'N', NULL, 'N', 0, 'N', NULL, 'Fleas', NULL, 'N'),
(10011, 4, '2017-11-01', 'Y', 'N', 'Special Diet', 'N', 2, 'Y', 10498, 'Ringworm', NULL, 'Y'),
(10019, 4, '2017-11-09', 'N', 'N', NULL, 'N', 0, 'N', NULL, 'Worms', NULL, 'N'),
(10023, 4, '2017-11-02', 'Y', 'N', NULL, 'N', 0, 'N', NULL, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `pet_ownership_history`
--

CREATE TABLE `pet_ownership_history` (
  `AppID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Sex` char(1) NOT NULL,
  `Age` int(11) NOT NULL,
  `Breed` varchar(50) DEFAULT NULL,
  `Species` varchar(50) NOT NULL,
  `State` varchar(2500) NOT NULL,
  `Cause_Of_Death` varchar(2500) DEFAULT NULL,
  `Spay_Or_Neutered` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pet_ownership_history`
--

INSERT INTO `pet_ownership_history` (`AppID`, `Name`, `Sex`, `Age`, `Breed`, `Species`, `State`, `Cause_Of_Death`, `Spay_Or_Neutered`) VALUES
(1001, 'Baxter', 'F', 11, 'Bulldog', 'Dog', 'Alive', NULL, 'Y'),
(1001, 'Luke', 'M', 5, 'German Shepherd', 'Dog', 'Deceased', 'Liver Cancer', 'Y'),
(1003, '4', 'M', 4, '4', '4', '4', '4', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `AppID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`AppID`, `EmpID`) VALUES
(1001, 1),
(1002, 3),
(1003, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `Username` varchar(25) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`Username`, `Password`, `Email`) VALUES
('cbuns00', 'cbunny', 'cinnamon_buns@gmail.com'),
('estahkovski00', 'ibelieveinmagic', 'eva.s@hotmail.com'),
('mchi00', '123456', 'markomarkomarko@hotmail.com'),
('nrice123', 'cutiepiewins', 'riceisnice@gmail.com'),
('phoebet', 'phoebet', 'phoebeterrence@gmail.com'),
('vetjeeves', 'jeeves', 'bobjeeves@vetcentral.com');

-- --------------------------------------------------------

--
-- Table structure for table `vet`
--

CREATE TABLE `vet` (
  `VID` int(11) NOT NULL,
  `First_Name` varchar(25) NOT NULL,
  `Last_Name` varchar(25) NOT NULL,
  `Phone_Num` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Clinic_Name` varchar(50) DEFAULT NULL,
  `Username` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vet`
--

INSERT INTO `vet` (`VID`, `First_Name`, `Last_Name`, `Phone_Num`, `Email`, `Clinic_Name`, `Username`) VALUES
(4, 'Robert', 'Jeeves', '6043756488', 'bobjeeves@vetcentral.com', 'Vet Central', 'vetjeeves');

-- --------------------------------------------------------

--
-- Structure for view `animal_and_med_info`
--
DROP TABLE IF EXISTS `animal_and_med_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `animal_and_med_info`  AS  select `a`.`AnimalID` AS `AnimalID`,`a`.`Name` AS `Name`,`a`.`Species` AS `Species`,`a`.`Breed` AS `Breed`,`a`.`Sex` AS `Sex`,`a`.`Age` AS `Age`,`a`.`Weight` AS `Weight`,`a`.`Application_Status` AS `Application_Status`,`a`.`Housebroken` AS `Housebroken`,`a`.`Temperament` AS `Temperament`,`a`.`Intake_Date` AS `Intake_Date`,`a`.`Intake_Condition` AS `Intake_Condition`,`a`.`Intake_Location` AS `Intake_Location`,`m`.`Animal` AS `Animal`,`m`.`VID` AS `VID`,`m`.`Last_Checkup` AS `Last_Checkup`,`m`.`Vaccinated` AS `Vaccinated`,`m`.`Declawed` AS `Declawed`,`m`.`Special_Needs` AS `Special_Needs`,`m`.`Pregnant` AS `Pregnant`,`m`.`Offspring` AS `Offspring`,`m`.`Tagged` AS `Tagged`,`m`.`Tag_ID` AS `Tag_ID`,`m`.`Parasites` AS `Parasites`,`m`.`Major_Illness` AS `Major_Illness`,`m`.`Spay_Neut` AS `Spay_Neut` from (`animals` `a` left join `medical_record` `m` on((`m`.`Animal` = `a`.`AnimalID`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adopter`
--
ALTER TABLE `adopter`
  ADD PRIMARY KEY (`AppID`),
  ADD UNIQUE KEY `Success_Story` (`Success_Story`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`AnimalID`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`AppID`);

--
-- Indexes for table `bonded`
--
ALTER TABLE `bonded`
  ADD KEY `Animal1` (`Animal1`),
  ADD KEY `Animal2` (`Animal2`);

--
-- Indexes for table `created_for`
--
ALTER TABLE `created_for`
  ADD PRIMARY KEY (`AppID`,`AnimalID`),
  ADD KEY `AnimalID` (`AnimalID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmpID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `manages`
--
ALTER TABLE `manages`
  ADD PRIMARY KEY (`Supervisor_EmpID`,`Subordinate_EmpID`),
  ADD KEY `Subordinate_EmpID` (`Subordinate_EmpID`);

--
-- Indexes for table `medical_record`
--
ALTER TABLE `medical_record`
  ADD PRIMARY KEY (`Animal`),
  ADD KEY `VID` (`VID`);

--
-- Indexes for table `pet_ownership_history`
--
ALTER TABLE `pet_ownership_history`
  ADD PRIMARY KEY (`AppID`,`Name`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`AppID`,`EmpID`),
  ADD KEY `EmpID` (`EmpID`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `vet`
--
ALTER TABLE `vet`
  ADD PRIMARY KEY (`VID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adopter`
--
ALTER TABLE `adopter`
  ADD CONSTRAINT `adopter_ibfk_1` FOREIGN KEY (`AppID`) REFERENCES `applications` (`AppID`);

--
-- Constraints for table `bonded`
--
ALTER TABLE `bonded`
  ADD CONSTRAINT `bonded_ibfk_1` FOREIGN KEY (`Animal1`) REFERENCES `animals` (`AnimalID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bonded_ibfk_2` FOREIGN KEY (`Animal2`) REFERENCES `animals` (`AnimalID`) ON DELETE CASCADE;

--
-- Constraints for table `created_for`
--
ALTER TABLE `created_for`
  ADD CONSTRAINT `created_for_ibfk_1` FOREIGN KEY (`AppID`) REFERENCES `applications` (`AppID`) ON DELETE CASCADE,
  ADD CONSTRAINT `created_for_ibfk_2` FOREIGN KEY (`AnimalID`) REFERENCES `animals` (`AnimalID`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user_account` (`Username`) ON DELETE CASCADE;

--
-- Constraints for table `manages`
--
ALTER TABLE `manages`
  ADD CONSTRAINT `manages_ibfk_1` FOREIGN KEY (`Supervisor_EmpID`) REFERENCES `employees` (`EmpID`),
  ADD CONSTRAINT `manages_ibfk_2` FOREIGN KEY (`Subordinate_EmpID`) REFERENCES `employees` (`EmpID`);

--
-- Constraints for table `medical_record`
--
ALTER TABLE `medical_record`
  ADD CONSTRAINT `medical_record_ibfk_1` FOREIGN KEY (`Animal`) REFERENCES `animals` (`AnimalID`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_record_ibfk_2` FOREIGN KEY (`VID`) REFERENCES `vet` (`VID`) ON DELETE SET NULL;

--
-- Constraints for table `pet_ownership_history`
--
ALTER TABLE `pet_ownership_history`
  ADD CONSTRAINT `pet_ownership_history_ibfk_1` FOREIGN KEY (`AppID`) REFERENCES `applications` (`AppID`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`AppID`) REFERENCES `applications` (`AppID`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`EmpID`) REFERENCES `employees` (`EmpID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
