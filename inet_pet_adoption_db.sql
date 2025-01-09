-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 07:02 PM
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
-- Database: `inet_pet_adoption_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity_log`
--

CREATE TABLE `tbl_activity_log` (
  `log_record_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `log_type` enum('add','update','delete') DEFAULT NULL,
  `details` text DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_activity_log`
--

INSERT INTO `tbl_activity_log` (`log_record_id`, `user_id`, `log_type`, `details`, `date_time`) VALUES
(1, 1, NULL, 'Add new barangay: testss', '2024-06-15 21:09:15'),
(2, 1, NULL, 'Add new pet_type_name: Dog', '2024-09-17 09:53:54'),
(3, 1, NULL, 'Updated pet_type_name: Dog to Cat', '2024-09-17 09:56:44'),
(4, 1, NULL, 'Add new pet_type_name: test to delete', '2024-09-17 09:58:01'),
(5, 1, NULL, 'Deleted pet_type_name: test to delete', '2024-09-17 09:58:28'),
(6, 1, NULL, 'Added new pet owner: pet owner 1', '2024-09-17 12:06:10'),
(7, 1, NULL, 'Added new pet owner: pet owner 11111', '2024-09-17 12:12:50'),
(8, 1, NULL, 'Added new pet owner: pet owner 11111', '2024-09-17 12:15:51'),
(9, 1, NULL, 'Updated pet owner: pet owner 11111 to pet owner 11111x, 1213sdfsdf to 1213sdfsdfx, p21@gmail.com to p21@gmail.comx, 121213 to 121213x', '2024-09-17 12:30:30'),
(10, 1, NULL, 'Updated pet owner: pet owner 11111x to pet owner 11111x, 1213sdfsdfx to 1213sdfsdfxxx, p21@gmail.comx to p21@gmail.comx, 121213x to 121213x', '2024-09-17 12:30:35'),
(11, 1, NULL, 'Added new pet: test', '2024-09-17 15:24:54'),
(12, 1, NULL, 'Added new pet: test', '2024-09-17 15:38:25'),
(13, 1, NULL, 'Added new pet owner: testsdffsdfsdfsdf', '2024-09-17 16:08:56'),
(14, 1, 'delete', 'Deleted pet_owner: testsdffsdfsdfsdf', '2024-09-17 16:08:59'),
(15, 1, NULL, 'Added new pet: test', '2024-09-17 16:17:13'),
(16, 1, 'delete', 'Deleted pet: test', '2024-09-17 16:17:20'),
(17, 1, NULL, 'Updated pet: test to test1, Health: Healthy to Healthy, Vaccination: Vaccinated to Vaccinated', '2024-09-17 16:19:22'),
(18, 1, NULL, 'Updated pet: test1 to test1x, Health: Healthy to Healthy, Vaccination: Vaccinated to Vaccinated', '2024-09-17 16:19:51'),
(19, 1, NULL, 'Updated pet: test1x to test1x, Health: Healthy to Healthy, Vaccination: Vaccinated to Vaccinated', '2024-09-17 16:20:17'),
(20, 1, NULL, 'Updated pet: test1x to test1x, Health: Healthy to Healthy, Vaccination: Vaccinated to Vaccinated', '2024-09-17 16:23:51'),
(21, 1, NULL, 'Added new adopter: test', '2024-09-17 16:30:23'),
(22, 1, NULL, 'Updated pet owner: test to test, 12112 to 12112a, test@gmail.com to test@gmail.com, 121212 to 121212', '2024-09-17 16:32:50'),
(23, 1, NULL, 'Updated pet owner: test to testa, 12112a to 12112a, test@gmail.com to testa@gmail.com, 121212 to 121212a', '2024-09-17 16:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adopter`
--

CREATE TABLE `tbl_adopter` (
  `adopter_id` int(11) NOT NULL,
  `adopter_name` varchar(100) NOT NULL,
  `adopter_contact` varchar(15) DEFAULT NULL,
  `adopter_email` varchar(100) DEFAULT NULL,
  `adopter_address` varchar(255) DEFAULT NULL,
  `adopter_profile` text DEFAULT NULL,
  `adopter_username` varchar(50) NOT NULL,
  `adopter_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_adopter`
--

INSERT INTO `tbl_adopter` (`adopter_id`, `adopter_name`, `adopter_contact`, `adopter_email`, `adopter_address`, `adopter_profile`, `adopter_username`, `adopter_password`) VALUES
(1, 'testa', '12112a', 'testa@gmail.com', '121212a', 'testa.png', 'landlord2', '$2y$10$qnV3X0jXgzLNghy33hkPROPdRcLa6a1mMpwktzMkne2Y43SwXgl3O');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adoption`
--

CREATE TABLE `tbl_adoption` (
  `adoption_id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `adopter_id` int(11) DEFAULT NULL,
  `adoption_date` date DEFAULT NULL,
  `upload_adoption_document` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adoption_request`
--

CREATE TABLE `tbl_adoption_request` (
  `adoption_request_id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `adopter_id` int(11) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL,
  `approval_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_backup`
--

CREATE TABLE `tbl_backup` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `backup_file` varchar(255) NOT NULL,
  `backup_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_backup`
--

INSERT INTO `tbl_backup` (`id`, `user_id`, `backup_file`, `backup_date`) VALUES
(1, 1, 'backup/database_backup_2024-06-15_13-12-35.sql', '2024-06-15 11:12:35'),
(2, 1, 'backup/database_backup_2024-06-15_14-55-29.sql', '2024-06-15 12:55:29'),
(3, 1, 'backup/database_backup_2024-06-15_14-55-37.sql', '2024-06-15 12:55:37'),
(4, 1, 'backup/database_backup_2024-06-15_15-08-50.sql', '2024-06-15 13:08:50'),
(5, 1, 'backup/database_backup_2024-06-15_15-08-52.sql', '2024-06-15 13:08:52'),
(6, 1, 'backup/database_backup_2024-06-15_15-08-56.sql', '2024-06-15 13:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barangay`
--

CREATE TABLE `tbl_barangay` (
  `location_id` int(11) NOT NULL,
  `barangay` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_barangay`
--

INSERT INTO `tbl_barangay` (`location_id`, `barangay`) VALUES
(9, 'test'),
(11, 'testxd'),
(12, 'dfdddf'),
(13, 'test bara'),
(14, 'testttaaa'),
(17, 'tstt'),
(19, 'asdfsdfsdf'),
(20, 'sdfsdfsdf'),
(21, 'xdfsdfsdgdsfg'),
(24, 'sdfsdfasdfsdsdfa'),
(25, 'Vitosdsdf'),
(26, 'tstdfff'),
(28, 'testss');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE `tbl_company` (
  `company_id` int(11) NOT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_contact` varchar(255) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`company_id`, `company_logo`, `company_name`, `company_address`, `company_contact`, `company_website`) VALUES
(1, 'logo.png', 'ProjectName', 'Manila, Philippines', '1234564444', 'https://inettutor.com/');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `pet_id` int(11) NOT NULL,
  `pet_owner_id` int(11) DEFAULT NULL,
  `pet_name` varchar(100) NOT NULL,
  `pet_type_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `health_status` enum('Healthy','Needs Treatment') NOT NULL,
  `upload_health_history` text DEFAULT NULL,
  `vaccination_status` enum('Vaccinated','Not Vaccinated') NOT NULL,
  `proof_of_vaccination` text DEFAULT NULL,
  `adoption_status` enum('Available','Pending','Adopted') NOT NULL,
  `pet_profile_image` varchar(255) NOT NULL,
  `date_registered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`pet_id`, `pet_owner_id`, `pet_name`, `pet_type_id`, `description`, `age`, `gender`, `health_status`, `upload_health_history`, `vaccination_status`, `proof_of_vaccination`, `adoption_status`, `pet_profile_image`, `date_registered`) VALUES
(1, 1, 'test1x', 1, 'testx11', 51, 'Female', 'Healthy', 'pet adoption system.docx', 'Vaccinated', 'course_outline_c#.docx', 'Available', 'test.png', '2024-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet_media`
--

CREATE TABLE `tbl_pet_media` (
  `pet_media_id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `pet_media_name` varchar(255) DEFAULT NULL,
  `pet_media_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet_owner`
--

CREATE TABLE `tbl_pet_owner` (
  `pet_owner_id` int(11) NOT NULL,
  `pet_owner_name` varchar(100) NOT NULL,
  `pet_owner_contact` varchar(15) DEFAULT NULL,
  `pet_owner_email` varchar(100) DEFAULT NULL,
  `pet_owner_address` varchar(255) DEFAULT NULL,
  `pet_owner_profile` text DEFAULT NULL,
  `pet_owner_username` varchar(50) NOT NULL,
  `pet_owner_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet_owner`
--

INSERT INTO `tbl_pet_owner` (`pet_owner_id`, `pet_owner_name`, `pet_owner_contact`, `pet_owner_email`, `pet_owner_address`, `pet_owner_profile`, `pet_owner_username`, `pet_owner_password`) VALUES
(1, 'pet owner 11111x', '1213sdfsdfxxx', 'p21@gmail.comx', '121213x', 'pet owner 11111x.gif', 'landlord2', '$2y$10$sgTLQFLOLuodnRf9OM1p1O3r830IXGDuG/rRBtY1uFkoSRTr0y47e');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet_type`
--

CREATE TABLE `tbl_pet_type` (
  `pet_type_id` int(11) NOT NULL,
  `pet_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet_type`
--

INSERT INTO `tbl_pet_type` (`pet_type_id`, `pet_type_name`) VALUES
(1, 'Cat');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `complete_name` varchar(255) DEFAULT NULL,
  `designation` text NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `user_type` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `password`, `complete_name`, `designation`, `profile_image`, `user_type`) VALUES
(1, 'admin', '$2y$10$IeVe1I43uBioGWRLw3SBaem3aTGBc7lmV0fXTZcb/EVIM/o5zv5..', 'Administrator', 'Admin account has all access to the features of the project', 'avatar.png', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activity_log`
--
ALTER TABLE `tbl_activity_log`
  ADD PRIMARY KEY (`log_record_id`);

--
-- Indexes for table `tbl_adopter`
--
ALTER TABLE `tbl_adopter`
  ADD PRIMARY KEY (`adopter_id`),
  ADD UNIQUE KEY `adopter_username` (`adopter_username`);

--
-- Indexes for table `tbl_adoption`
--
ALTER TABLE `tbl_adoption`
  ADD PRIMARY KEY (`adoption_id`);

--
-- Indexes for table `tbl_adoption_request`
--
ALTER TABLE `tbl_adoption_request`
  ADD PRIMARY KEY (`adoption_request_id`);

--
-- Indexes for table `tbl_backup`
--
ALTER TABLE `tbl_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_barangay`
--
ALTER TABLE `tbl_barangay`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `tbl_pet_media`
--
ALTER TABLE `tbl_pet_media`
  ADD PRIMARY KEY (`pet_media_id`);

--
-- Indexes for table `tbl_pet_owner`
--
ALTER TABLE `tbl_pet_owner`
  ADD PRIMARY KEY (`pet_owner_id`),
  ADD UNIQUE KEY `pet_owner_username` (`pet_owner_username`),
  ADD UNIQUE KEY `pet_owner_name` (`pet_owner_name`);

--
-- Indexes for table `tbl_pet_type`
--
ALTER TABLE `tbl_pet_type`
  ADD PRIMARY KEY (`pet_type_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `complete_name` (`complete_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activity_log`
--
ALTER TABLE `tbl_activity_log`
  MODIFY `log_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_adopter`
--
ALTER TABLE `tbl_adopter`
  MODIFY `adopter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_adoption`
--
ALTER TABLE `tbl_adoption`
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_adoption_request`
--
ALTER TABLE `tbl_adoption_request`
  MODIFY `adoption_request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_backup`
--
ALTER TABLE `tbl_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_barangay`
--
ALTER TABLE `tbl_barangay`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pet_media`
--
ALTER TABLE `tbl_pet_media`
  MODIFY `pet_media_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pet_owner`
--
ALTER TABLE `tbl_pet_owner`
  MODIFY `pet_owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pet_type`
--
ALTER TABLE `tbl_pet_type`
  MODIFY `pet_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
