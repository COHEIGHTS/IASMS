-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 01:07 PM
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
-- Database: `iasms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` text NOT NULL,
  `device_info` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachment_positions`
--

CREATE TABLE `attachment_positions` (
  `id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text NOT NULL,
  `available_positions` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `organization_email` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachment_positions`
--

INSERT INTO `attachment_positions` (`id`, `position_name`, `department`, `start_date`, `end_date`, `description`, `available_positions`, `organization_name`, `organization_email`, `status`, `created_at`) VALUES
(1, 'MANAGER', 'DEPARTMENT OF AGGE', '2025-02-07', '2025-05-07', 'efmlwflkfk', 4, 'SAFARICOM', 'collinske823@gmail.com', 'Active', '2025-02-07 10:58:10'),
(2, 'ATTACHEE', 'COMPUTER SECURITY', '2025-02-16', '2025-09-16', 'Attachee opportunity', 3, 'Greentech solution', 'thomasnguma76@gmail.com', 'Active', '2025-02-16 09:20:48'),
(3, 'SOFTWARE DEVELOPER', 'ICT', '2025-02-16', '2025-10-16', 'DEVELOPER', 2, 'SOFTECH  AGENCIES', 'softechagencies@gmail.com', 'Active', '2025-02-16 09:24:51'),
(4, 'AGRICULTURAL ATTACHEE', 'Agriculture', '2025-02-16', '2025-02-28', 'A student persuing agricultural career or related field', 5, 'KALRO', 'kalroagri@gmail.com', 'Active', '2025-02-16 09:26:43'),
(6, 'GURU NANANK', 'COMPUTER TECH', '2025-03-18', '2025-10-18', 'kfkfkglkgrlk', 3, 'GHGH nakanr', 'collinsheights@gmail.com', 'Active', '2025-03-18 12:58:38'),
(7, 'ENGINEERING INTERN', 'Engineering', '2025-03-28', '2025-04-06', 'A engineering student looking for intern to leverage his skills', 4, 'TechCorp', 'techcorpeng@gmail.com', 'Active', '2025-03-28 10:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `company_supervisor_grade`
--

CREATE TABLE `company_supervisor_grade` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_index` varchar(100) NOT NULL,
  `specific_skill_1` varchar(100) NOT NULL,
  `specific_skill_1_score` int(11) NOT NULL,
  `specific_skill_2` varchar(100) NOT NULL,
  `specific_skill_2_score` int(11) NOT NULL,
  `specific_skill_3` varchar(100) NOT NULL,
  `specific_skill_3_score` int(11) NOT NULL,
  `specific_skill_4` varchar(100) NOT NULL,
  `specific_skill_4_score` int(11) NOT NULL,
  `specific_skill_5` varchar(100) NOT NULL,
  `specific_skill_5_score` int(5) NOT NULL,
  `ability_to_complete_work_on_time` int(5) NOT NULL,
  `ability_to_follow_instructions_carefully` int(5) NOT NULL,
  `ability_to_take_initiatives` int(5) NOT NULL,
  `ability_to_work_with_little_supervision` int(5) NOT NULL,
  `adherence_to_organizations_rules` int(5) NOT NULL,
  `adherence_to_safety` int(5) NOT NULL,
  `resourcefulness` int(5) NOT NULL,
  `attendance_to_work` int(5) NOT NULL,
  `punctuality` int(5) NOT NULL,
  `desire_to_work` int(5) NOT NULL,
  `williness_to_accept_new_ideas` int(5) NOT NULL,
  `relationship_with_colleagues` int(5) NOT NULL,
  `relationship_with_supervisors` int(5) NOT NULL,
  `ability_to_control_emotions_when_provoked` int(5) NOT NULL,
  `grade` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company_supervisor_grade`
--

INSERT INTO `company_supervisor_grade` (`id`, `username`, `user_index`, `specific_skill_1`, `specific_skill_1_score`, `specific_skill_2`, `specific_skill_2_score`, `specific_skill_3`, `specific_skill_3_score`, `specific_skill_4`, `specific_skill_4_score`, `specific_skill_5`, `specific_skill_5_score`, `ability_to_complete_work_on_time`, `ability_to_follow_instructions_carefully`, `ability_to_take_initiatives`, `ability_to_work_with_little_supervision`, `adherence_to_organizations_rules`, `adherence_to_safety`, `resourcefulness`, `attendance_to_work`, `punctuality`, `desire_to_work`, `williness_to_accept_new_ideas`, `relationship_with_colleagues`, `relationship_with_supervisors`, `ability_to_control_emotions_when_provoked`, `grade`, `date`) VALUES
(11, 'Masaka Robert MAITHYA', 'K11/1234/21', 'vrfjfjgf', 5, 'ndnkjbgj', 4, 'vnfjgjgj', 5, 'fhfhgj', 4, 'rhfhfh', 5, 4, 5, 4, 5, 4, 5, 4, 5, 5, 5, 5, 5, 5, 5, 94, '2025-01-17 09:18:22'),
(12, 'ALPHONSE OWENGAMALCOM', 'K12/1234/21', 'cnkdbvfv', 4, 'jdkdjbj', 5, 'nvjfjf', 5, 'dhdwfji', 5, 'chchfjiffi', 5, 4, 2, 5, 3, 5, 5, 5, 5, 5, 5, 5, 3, 4, 5, 90, '2025-03-28 10:38:14'),
(13, 'VALARIE OCHIENGMAKDI', 'E11/04344/21', 'ekwjfkngbrk', 0, 'kjjifvjflk', 1, 'kfjifjogrok', 2, 'fvnfvjfkj', 3, 'ffjgbkgtk', 4, 3, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 82, '2025-03-28 10:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'MAITHYA NDAVI', 'collinske823@gmail.com', 'fgg', '2025-02-07 10:49:37'),
(2, 'MAITHYA NDAVI', 'collinske823@gmail.com', 'vvffef', '2025-02-07 10:50:02'),
(3, 'MAITHYA NDAVI', 'coheigts254@gmail.com', 'fkdwfjfrfj', '2025-02-07 10:50:48'),
(4, 'COLLINS HEIGHTS', 'collinsheights@gmail.com', 'dhbjbidjjfvkn', '2025-02-16 09:28:13'),
(5, 'MAITHYA NDAVI', 'collinske823@gmail.com', 'hqsbwwdjdej', '2025-03-29 08:44:02'),
(6, 'COLLINS HEIGHTS', 'collohke693@gmail.com', 'snkdjdkdfk', '2025-03-29 08:47:11'),
(7, 'COLLINS HEIGHTS', 'collohke693@gmail.com', 'snkdjdkdfk', '2025-03-29 08:52:33'),
(8, 'MAITHYA NDAVI', 'collinsheights14@gmail.com', 'ddjrejrej', '2025-03-29 08:54:49');

-- --------------------------------------------------------

--
-- Table structure for table `industrial_registration`
--

CREATE TABLE `industrial_registration` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `other_name` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL,
  `programme` varchar(200) NOT NULL,
  `session` varchar(200) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `index_number` varchar(255) NOT NULL,
  `company_supervisor_grade` int(11) NOT NULL,
  `visiting_supervisor_grade` int(11) NOT NULL,
  `company_supervisor_name` varchar(100) NOT NULL DEFAULT 'unassigned',
  `visiting_supervisor_name` varchar(100) NOT NULL DEFAULT 'unassigned',
  `company_supervisor_contact` varchar(11) NOT NULL,
  `visiting_supervisor_contact` varchar(11) NOT NULL,
  `attachment_region` varchar(100) NOT NULL DEFAULT 'unassigned'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `industrial_registration`
--

INSERT INTO `industrial_registration` (`id`, `first_name`, `last_name`, `other_name`, `level`, `programme`, `session`, `faculty`, `date`, `index_number`, `company_supervisor_grade`, `visiting_supervisor_grade`, `company_supervisor_name`, `visiting_supervisor_name`, `company_supervisor_contact`, `visiting_supervisor_contact`, `attachment_region`) VALUES
(13, 'Masaka Robert ', 'MAITHYA', '', '4', 'Computer Science', 'Remote', 'Science', '2025-01-17 09:16:22', 'K11/1234/21', 94, 95, 'Mr. Alphonso', 'unassigned', '0727126714', '', 'Nyanza'),
(14, 'ALPHONSE OWENGA', 'MALCOM', '', '4', 'Electrical Engineering', 'On-site', 'Engineering', '2025-03-28 09:39:58', 'K12/1234/21', 90, 88, 'Mr. Alphonso', 'unassigned', '08474783', '', 'Nairobi'),
(15, 'VALARIE OCHIENG', 'MAKDI', '', '3', 'Econ&Stat', 'On-site', 'FASS', '2025-03-28 10:47:51', 'E11/04344/21', 82, 92, 'Mr antony musyoka', 'unassigned', '0712345678', '', 'Coast');

-- --------------------------------------------------------

--
-- Table structure for table `internal_registration`
--

CREATE TABLE `internal_registration` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `other_name` varchar(255) NOT NULL,
  `index_number` varchar(200) NOT NULL,
  `programme` varchar(200) NOT NULL,
  `level` varchar(100) NOT NULL,
  `session` varchar(200) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `visiting_supervisor_grade` int(100) NOT NULL,
  `company_supervisor_grade` int(11) NOT NULL,
  `visiting_supervisor_name` varchar(100) NOT NULL DEFAULT 'unassigned',
  `company_supervisor_name` varchar(100) NOT NULL DEFAULT 'unassigned',
  `company_supervisor_contact` varchar(11) NOT NULL,
  `visiting_supervisor_contact` varchar(11) NOT NULL,
  `attachment_region` varchar(100) NOT NULL DEFAULT 'unassigned'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `internal_registration`
--

INSERT INTO `internal_registration` (`id`, `first_name`, `last_name`, `other_name`, `index_number`, `programme`, `level`, `session`, `faculty`, `date`, `visiting_supervisor_grade`, `company_supervisor_grade`, `visiting_supervisor_name`, `company_supervisor_name`, `company_supervisor_contact`, `visiting_supervisor_contact`, `attachment_region`) VALUES
(12, 'Masaka Robert ', 'MAITHYA', '', 'K11/1234/21', 'Education', '4', 'Remote', 'FASS', '2025-01-17 09:36:29', 0, 0, 'unassigned', 'unassigned', '', '', 'unassigned');

-- --------------------------------------------------------

--
-- Table structure for table `registered_students`
--

CREATE TABLE `registered_students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `index_number` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activation_token` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_created_at` datetime(6) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `registered_students`
--

INSERT INTO `registered_students` (`id`, `first_name`, `last_name`, `Email`, `index_number`, `password`, `activation_token`, `is_active`, `reset_token_hash`, `reset_token_created_at`, `reset_token_expires_at`) VALUES
(48, 'Masaka Robert ', 'MAITHYA', 'collinsheights@gmail.com', 'K11/1234/21', '$2y$10$GXGM5PEVWVJyDXoG4/9BmO1UWCp9oh2/h1f4bP386sjCx6SkypIO6', '01d42012ee777f482b6de1821b9208f0', 1, NULL, NULL, NULL),
(55, 'ALPHONSE OWENGA', 'MALCOM', 'collohke693@gmail.com', 'K12/1234/21', '$2y$10$3z2TeN31WZVsrvT.s0XODeuGSb4QBaYaZLUyIftj.BPu7WmPtwRxW', '', 1, NULL, '2025-03-28 11:31:02.000000', NULL),
(58, 'VALARIE OCHIENG', 'MAKDI', 'otiiiruga@gmail.com', 'E11/04344/21', '$2y$10$xdfmRHa36EavPTOQdT6edunyTm6ee1oFNRPTfd.bW9J7/kbNtOaAi', '', 1, NULL, NULL, NULL),
(59, 'VALARIE OCHIENG', 'MAKDI', 'otiiiruga@gmail.com', 'E11/04344/21', '$2y$10$dMhSRrg86jIkHXx32fOIu.OTX3yJEMhMP5dHTOQGRAKyDJmxq2D2C', 'be0ebd5d4c5f8326550f46faa2657abd', 0, NULL, NULL, NULL),
(60, 'VALARIE OCHIENG', 'MAKDI', 'otiiiruga@gmail.com', 'E11/04344/21', '$2y$10$Z0CXNr3A3BqApoUBQe3F0.p9wv9O8/gKYrNh8MXUtG0AKDhfeL8FS', '419a242d2d1c99b42004aba02d781182', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `student_index` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `student_index`, `file_path`, `submission_date`) VALUES
(1, 'S13/04344/21', 'uploads/Database Management System Tutorial.pdf', '2025-03-17 13:12:28'),
(2, 'S13/04344/21', 'uploads/FINAL YEAR PROJECT DOCUMENT1.pdf', '2025-03-17 13:40:21'),
(3, 'K12/1234/21', 'uploads/Data-Science-Pdf-3.pdf', '2025-03-28 10:40:44'),
(4, 'E11/04344/21', 'uploads/Artificial Intelligence_ The Basics ( PDFDrive ).pdf', '2025-03-28 10:53:39');

-- --------------------------------------------------------

--
-- Table structure for table `students_assumption`
--

CREATE TABLE `students_assumption` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `other_name` varchar(200) NOT NULL,
  `index_number` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL,
  `programme` varchar(200) NOT NULL,
  `session` varchar(200) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `supervisor_name` varchar(200) NOT NULL,
  `supervisor_contact` int(20) NOT NULL,
  `supervisor_email` varchar(100) NOT NULL,
  `company_region` varchar(200) NOT NULL,
  `company_address` mediumtext NOT NULL,
  `registration_type` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students_assumption`
--

INSERT INTO `students_assumption` (`id`, `first_name`, `last_name`, `other_name`, `index_number`, `level`, `programme`, `session`, `company_name`, `supervisor_name`, `supervisor_contact`, `supervisor_email`, `company_region`, `company_address`, `registration_type`, `date`) VALUES
(31, 'Masaka Robert ', 'MAITHYA', '', 'K11/1234/21', '4', 'Computer Science', 'Remote', 'SAFARICOM KENYA LTD', 'Mr. Alphonso', 727126714, 'collinske823@gmail.com', 'Nyanza', 'P.O BOX 272', 'INDUSTRIAL REGISTRATION', '2025-01-17 09:16:49'),
(32, 'ALPHONSE OWENGA', 'MALCOM', '', 'K12/1234/21', '4', 'Electrical Engineering', 'On-site', 'Africa Data School', 'Mr. Alphonso', 8474783, 'collinske823@gmail.com', 'Nairobi', 'P.O BOX 272', 'INDUSTRIAL REGISTRATION', '2025-03-28 09:41:47'),
(33, 'VALARIE OCHIENG', 'MAKDI', '', 'E11/04344/21', '3', 'Econ&Stat', 'On-site', 'Techcorp', 'Mr antony musyoka', 712345678, 'cojldjjfkj@gmail.com', 'Coast', 'Mombasa Diani', 'INDUSTRIAL REGISTRATION', '2025-03-28 10:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `supervisors_login`
--

CREATE TABLE `supervisors_login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supervisors_login`
--

INSERT INTO `supervisors_login` (`id`, `username`, `password`, `date`, `status`) VALUES
(6, 'MASAKA', '$2y$10$.nJ4JbErchL/o9w9WB3Pa.ZOuEjruO86QKCknoP5MH6TZ.uue.1g6', '2025-02-07 08:42:27', 'Company'),
(9, 'NDAVI', '$2y$10$XmyJl8eOp.v6KYMBqhuWnOffbp1OFW09IN2Ou21ETCQjqg/nPkipS', '2025-03-28 08:55:39', 'Visiting'),
(10, 'NDAVI', '$2y$10$XiXAMOaZ60lNYJag5aIEle5yv3qdBBrQr0wwjY2EW.zNueW8s50cO', '2025-03-28 08:56:17', 'Company');

-- --------------------------------------------------------

--
-- Table structure for table `system_admin`
--

CREATE TABLE `system_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `system_admin`
--

INSERT INTO `system_admin` (`id`, `username`, `password`) VALUES
(6, 'MASAKA', '$2y$10$s2zoR4VpASo9eBfvCJTiCea2FwxYHOX8OyG9SHVa2CtH6RSHrNuUy'),
(9, 'MATHIAS', '$2y$10$eALC.nq0R7KnYsdAS7feQOvVbz/5SUBTqFZmzbWdlLPPdr3xOzyP.'),
(10, 'NDAVI', '$2y$10$ynEVA.2G9PpQCNIeEjRQKu1yTATao5VzZoOU4oRSWuRNj9ZTRHgnW');

-- --------------------------------------------------------

--
-- Table structure for table `visiting_lecturers`
--

CREATE TABLE `visiting_lecturers` (
  `id` int(11) NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `lecturer_faculty` varchar(255) NOT NULL,
  `lecturer_phone_number` varchar(11) NOT NULL,
  `lecturer_region_residence` varchar(255) NOT NULL,
  `lecturer_department` varchar(255) NOT NULL,
  `lecturer_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `visiting_lecturers`
--

INSERT INTO `visiting_lecturers` (`id`, `lecturer_name`, `lecturer_faculty`, `lecturer_phone_number`, `lecturer_region_residence`, `lecturer_department`, `lecturer_email`) VALUES
(68, 'Mr Katiku Jones', 'Science', '0742702766', 'Rift Valley', 'Computer Science', 'collinske823@gmail.com'),
(69, 'Mr Katiku Jones', 'Science', '0742702766', 'Rift Valley', 'Computer Science', 'collinske823@gmail.com'),
(70, 'Dr oguta', 'Science', '0112233456', 'Rift Valley', 'Secretariaship', 'collinske823@gmail.com'),
(71, 'MR BOSIRE ', 'Science', '0742702766', 'Rift Valley', 'Civil Engineering', 'collinske823@gmail.com'),
(72, 'Mr Kemei', 'Education', '0742702766', 'Eastern', 'Hospitality', 'collinske823@gmail.com'),
(73, 'Mr Kemei', 'Education', '0742702766', 'Eastern', 'Hospitality', 'collinske823@gmail.com'),
(74, 'Dr.Kasyoka', 'Engineering', '2337348848', 'Coast', 'Energy Systems Engineering', 'collinske823@gmail.com'),
(75, 'Dr.Kasyoka', 'Engineering', '2337348848', 'Coast', 'Energy Systems Engineering', 'collinske823@gmail.com'),
(76, 'Mr Maithya', 'FASS', '0742702766', 'Northern', 'Energy Systems Engineering', 'collinske823@gmail.com'),
(77, 'Mr Maithya', 'FASS', '0742702766', 'Northern', 'Energy Systems Engineering', 'collinske823@gmail.com'),
(78, 'MASAKA ROBERT', 'Agriculture', '0112233456', 'Coast', 'Accountancy', 'collinske823@gmail.com'),
(79, 'MASAKA ROBERT', 'Agriculture', '0112233456', 'Coast', 'Accountancy', 'collinske823@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `visiting_supervisor_grade`
--

CREATE TABLE `visiting_supervisor_grade` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_index` varchar(100) NOT NULL,
  `specific_skill_1` varchar(100) NOT NULL,
  `specific_skill_1_score` int(11) NOT NULL,
  `specific_skill_2` varchar(100) NOT NULL,
  `specific_skill_2_score` int(11) NOT NULL,
  `specific_skill_3` varchar(100) NOT NULL,
  `specific_skill_3_score` int(11) NOT NULL,
  `specific_skill_4` varchar(100) NOT NULL,
  `specific_skill_4_score` int(11) NOT NULL,
  `specific_skill_5` varchar(100) NOT NULL,
  `specific_skill_5_score` int(5) NOT NULL,
  `ability_to_complete_work_on_time` int(5) NOT NULL,
  `ability_to_follow_instructions_carefully` int(5) NOT NULL,
  `ability_to_take_initiatives` int(5) NOT NULL,
  `ability_to_work_with_little_supervision` int(5) NOT NULL,
  `adherence_to_organizations_rules` int(5) NOT NULL,
  `adherence_to_safety` int(5) NOT NULL,
  `resourcefulness` int(5) NOT NULL,
  `attendance_to_work` int(5) NOT NULL,
  `punctuality` int(5) NOT NULL,
  `desire_to_work` int(5) NOT NULL,
  `williness_to_accept_new_ideas` int(5) NOT NULL,
  `relationship_with_colleagues` int(5) NOT NULL,
  `relationship_with_supervisors` int(5) NOT NULL,
  `ability_to_control_emotions_when_provoked` int(5) NOT NULL,
  `grade` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `visiting_supervisor_grade`
--

INSERT INTO `visiting_supervisor_grade` (`id`, `username`, `user_index`, `specific_skill_1`, `specific_skill_1_score`, `specific_skill_2`, `specific_skill_2_score`, `specific_skill_3`, `specific_skill_3_score`, `specific_skill_4`, `specific_skill_4_score`, `specific_skill_5`, `specific_skill_5_score`, `ability_to_complete_work_on_time`, `ability_to_follow_instructions_carefully`, `ability_to_take_initiatives`, `ability_to_work_with_little_supervision`, `adherence_to_organizations_rules`, `adherence_to_safety`, `resourcefulness`, `attendance_to_work`, `punctuality`, `desire_to_work`, `williness_to_accept_new_ideas`, `relationship_with_colleagues`, `relationship_with_supervisors`, `ability_to_control_emotions_when_provoked`, `grade`, `date`) VALUES
(10, 'Masaka Robert MAITHYA', 'K11/1234/21', 'hhffj', 5, 'dnjj', 4, 'cfjfjfj', 5, 'fbfhffj', 4, 'nfjffj', 5, 5, 5, 5, 5, 5, 5, 5, 4, 5, 4, 5, 4, 5, 5, 95, '2025-01-17 09:19:24'),
(11, 'ALPHONSE OWENGAMALCOM', 'K12/1234/21', 'dcnvvfjfeok', 3, 'nkfjrfrgo', 4, 'jrjoro', 5, 'jvjfjf', 5, 'efjfjogeokggtok', 5, 5, 5, 5, 5, 4, 5, 4, 3, 3, 4, 5, 4, 5, 4, 88, '2025-03-28 10:39:19'),
(12, 'VALARIE OCHIENGMAKDI', 'E11/04344/21', 'fwjjgkg', 2, 'ccjfjfk', 3, 'fjfjigo', 4, 'fkjgjto', 5, 'fjfgjgko', 5, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 92, '2025-03-28 10:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `week1_table`
--

CREATE TABLE `week1_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week1_table`
--

INSERT INTO `week1_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(66, 'NDAVI MAITHYA', 'S13/04344/21', 'LARAVEL', '2024-12-13 07:29:38', 'jSOHO', 'fhfjgfkgk', 'fjfjfjfj', 'njcjckcvk', 'vhjfjfk', 'jfjffgi', 'fhfjfjff', 'hfjfjfj', 'ffhfhfj'),
(67, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'LARAVEL', '2025-03-29 09:22:30', 'fkfjkffk', 'SQL', 'fjkkdfkjfkj', 'JAVA', 'kdfkjdfklf', 'MYSQLI', 'coding', 'dfnkdfkjdfkj', 'dfkjdfkjfdjk');

-- --------------------------------------------------------

--
-- Table structure for table `week2_table`
--

CREATE TABLE `week2_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week2_table`
--

INSERT INTO `week2_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(62, 'NDAVI MAITHYA', 'S13/04344/21', 'HELLO', '2024-12-13 07:30:54', 'FNFNF', 'DATA ANALYSIS', 'VNVV', 'VBVV', 'VNVVJ', 'BVV', 'VVHV', 'VBVVV', 'VBVV'),
(63, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:31:24', 'dkjdjffkj', 'SQL', 'fnfkfkn', 'HTML', 'fdnfdjfdkj', 'dnfkjfdkj', 'fgkjfgokgfk', 'gkgfkjgfk', 'gfkgkgk');

-- --------------------------------------------------------

--
-- Table structure for table `week3_table`
--

CREATE TABLE `week3_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week3_table`
--

INSERT INTO `week3_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(57, 'COLLINS HEIGHTS', 'K11/1234/21', 'XNDCCMV', '2024-07-16 08:04:10', 'FJFJFJF', 'CNVMFVVNVNV', 'FFFNFFN', 'VVVVVVV', 'FNFNVNF', 'NJJFF', 'FNFFJ', 'FJFJFJFFJ', 'FNFNFN'),
(60, 'COLLINS HEIGHTS', 'S11/1234/21', 'SQAQKQSQK', '2024-11-01 08:35:48', 'hhvhgjggj', 'bgjggj', 'fbfhh', 'ffhgh', 'bfgfgh', 'fbghgh', 'gbghg', 'gnggj', 'gbghgh'),
(62, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:34:52', 'fjfjfjkfkj', 'SQL', 'kjfgkjfgk', 'fnfjkfkjf', 'fkjgfjkgk', 'knfgkjfgkj', 'gkjgfkjgfkj', 'fngfjgfklgfkl', 'gnkgjkgjk');

-- --------------------------------------------------------

--
-- Table structure for table `week4_table`
--

CREATE TABLE `week4_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week4_table`
--

INSERT INTO `week4_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(59, 'COLLINS HEIGHTS', 'K11/1234/21', 'fhfhfhf', '2024-07-16 08:19:51', 'ccbccb', 'hello', 'hff', 'world', 'cnh', 'vison', 'cbbf', 'kensy', 'ddhfh'),
(60, 'COLLINS HEIGHTS', 'S11/1234/21', 'laravel', '2024-11-01 07:49:11', 'hdffdjfk', 'cncvvfvfvkfve', 'djdjffjf', 'qndjjfefj', 'efhfhfjfrfrj', 'enffjfgfjk', 'dndnvn', 'dndffj', 'fnfffgn'),
(61, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:43:56', 'dfjdfjkfkj', 'sql', 'fnjfjdfkj', 'fjnfkjfdkj', 'fndfjkfdjk', 'fnfdkjfdjk', 'fdjkfdkjfdkj', 'dfnfdjfdj', 'dnmvkjvkj');

-- --------------------------------------------------------

--
-- Table structure for table `week5_table`
--

CREATE TABLE `week5_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week5_table`
--

INSERT INTO `week5_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(56, 'COLLINS HEIGHTS', 'K11/1234/21', 'snsddh', '2024-07-16 08:08:39', 'cccch', 'ndndn', 'chchcch', 'dhdhfjf', ' mnknnk', 'cnchcchc', 'bjbjbbj', 'HELLO', 'HELLO'),
(59, 'COLLINS HEIGHTS', 'S11/1234/21', 'ccjdjvfj', '2024-11-01 08:20:57', 'zbxxccsxbxchc', 'cbcncnvn', 'ccbcc', 'vddhf', 'cbcbcbcxcbcb', 'cbcbcb', 'dbdd', 'dbdbdhd', 'dvdbd'),
(60, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:46:08', 'nkkjffkj', 'sql', 'fjkfjfj', 'fenefkjerkj', 'fjkfjifj', 'enjejkf', 'fjfjfj', 'fjhfjf', 'fjkgrjigj');

-- --------------------------------------------------------

--
-- Table structure for table `week6_table`
--

CREATE TABLE `week6_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week6_table`
--

INSERT INTO `week6_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(56, 'COLLINS HEIGHTS', 'K11/1234/21', 'CVJJFF', '2024-07-16 08:10:25', 'DHDHDHNC', 'CVD', 'NCNC', 'CN', 'HHDH', 'FJFJ', 'DHFHFH', 'FNFJF', 'FJFJF'),
(57, 'COLLINS HEIGHTS', 'K11/1234/21', 'NCVJCJC', '2024-07-16 08:12:14', 'FFHFJFFJ', 'VNVNV', 'FFJFJFFJ', 'VNVJVJVVJV', 'FFHFJFJ', 'FNVJVJV', 'FHFHFH', 'VNVJVJ', 'VVBVNVN'),
(58, 'COLLINS HEIGHTS', 'S11/1234/21', 'hhifjorkjtyk', '2024-11-01 08:08:52', 'rmtkgltl', 'erkrll5l', 'fgkgkhkh', 'fjgkgkgk', 'fngkhgkhl', 'fngbhkhl', 'fngmgmhh', 'fgngghh', 'dnnfngngng'),
(59, 'COLLINS HEIGHTS', 'S11/1234/21', 'hhifjorkjtyk', '2024-11-01 08:14:15', 'rmtkgltl', 'erkrll5l', 'fgkgkhkh', 'fjgkgkgk', 'fngkhgkhl', 'fngbhkhl', 'fngmgmhh', 'fgngghh', 'dnnfngngng'),
(60, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'SQL', '2025-03-29 09:48:42', 'dnfjkf', 'CLOUD', 'fnfdjkdf', 'fdnkfdkjdf', 'fdnkfdjfdj', 'fjkfgkgfk', 'fnkfgjfgjgjogrjg', 'fkjfrjror', 'gjgjgkog');

-- --------------------------------------------------------

--
-- Table structure for table `week7_table`
--

CREATE TABLE `week7_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week7_table`
--

INSERT INTO `week7_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(57, 'COLLINS HEIGHTS', 'K11/1234/21', 'HHFHHHHH', '2024-07-16 08:13:50', 'VVCVCV', 'HHHHJJJHHHH', 'VVVBVB', 'BHHHHH', 'BGF', 'VGGG', 'VVBVV', 'GGGG', 'MANUUU'),
(58, 'COLLINS HEIGHTS', 'K11/1234/21', 'HHFHHHHH', '2024-07-16 08:14:34', 'VVCVCV', 'HHHHJJJHHHH', 'VVVBVB', 'BHHHHH', 'BGF', 'VGGG', 'VVBVV', 'GGGG', 'MANUUU'),
(68, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'CODING', '2025-03-29 09:51:02', 'gmlhktk', 'SQL', 'tmthkh', 'CLOUD', 'gmkkt', 'fkjgroirtg', 'tkjtto', 'gkjokhtk', 'tgmkgjg');

-- --------------------------------------------------------

--
-- Table structure for table `week8_table`
--

CREATE TABLE `week8_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week8_table`
--

INSERT INTO `week8_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(54, 'Lious Vuiton', '04/2013/0688D', 'This', '2017-04-23 19:17:22', 'A', 'Lious', 'Vuiton', 'The', 'Only', 'Stanger', 'Nanger', 'In', 'Lown'),
(56, 'Masaka Robert  simion', 'S13/04344/21', 'cm mcmcv', '2024-06-19 13:23:42', 'Laravel', 'cncnj', 'snxndmdm', 'xnxncckck', 'mmddd', 'cncckck', 'ncmccm', 'mcmckck', 'nxndjdj'),
(57, 'COLLINS HEIGHTS', 'K11/1234/21', 'fffffjfhfhf', '2024-07-16 08:16:01', 'hhffhf', 'hfhfhfh', 'fhfhfhf', 'fhfhfhfhh', 'hello', 'hfhfhfh', 'hfhfhffh', 'hhhf', 'hello'),
(58, 'COLLINS HEIGHTS', 'S11/1234/21', 'ndnfmfmf', '2024-11-01 08:28:22', 'cnnnv', 'fnfnfng', 'nfnfnf', 'dfnfnf', 'cnfnncnfnfn', 'fffff', 'nfnnfgngng', 'fgngn', 'fnfnfng'),
(59, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:53:31', 'dfjfgiogroi', 'sql', 'fjkgfogfoi', 'fkfkjfk', 'gfjgoigfo', 'vnkjfdkj', 'gfjkgfogo', 'fdnfjkfdk', 'gfmgkjgoig');

-- --------------------------------------------------------

--
-- Table structure for table `week9_table`
--

CREATE TABLE `week9_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week9_table`
--

INSERT INTO `week9_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(54, 'Lious Vuiton', '04/2013/0688D', 'This', '2017-04-23 19:17:22', 'A', 'Lious', 'Vuiton', 'The', 'Only', 'Stanger', 'Nanger', 'In', 'Lown'),
(56, 'Masaka Robert  simion', 'S13/04344/21', 'cmcmmv', '2024-06-19 13:33:00', 'Laravel', 'cncn', 'nssnsdndn', 'snsnddmm', 'nsnnxmccmnxnxn', 'ccmcmcm', 'mdjdjdsnsdjdjd', 'ncncjck', 'nndjdjdj'),
(57, 'Masaka Robert  simion', 'S13/04344/21', 'cmcmmv', '2024-06-19 13:34:08', 'Laravel', 'cncn', 'nssnsdndn', 'snsnddmm', 'nsnnxmccmnxnxn', 'ccmcmcm', 'mdjdjdsnsdjdjd', 'ncncjck', 'nndjdjdj'),
(58, 'COLLINS HEIGHTS', 'K11/1234/21', 'chchchc', '2024-07-16 08:17:31', 'hhfjfjfj', ' nncncn', 'fmfjfjfj', 'cncjccjc', 'hello', 'jcjcjcc', 'hello', 'djdjjf', 'hello'),
(59, 'COLLINS HEIGHTS', 'S11/1234/21', 'xbdncjjv', '2024-11-01 08:28:57', 'gjgjghk', 'nbnbbbm', 'ghmhmh', ' nvnvjb', 'gngjhj', 'vnbjb', 'gmghjhj', 'vnvjbjb', 'gjgjhj'),
(60, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:56:06', 'fjkfkjfgk', 'sql', 'fjkff', 'djfkfj', 'jkfiug', 'jkfkjf', 'vjkgjg', 'fkjgogo', 'gkjgkjgkj');

-- --------------------------------------------------------

--
-- Table structure for table `week10_table`
--

CREATE TABLE `week10_table` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `index_number` varchar(100) NOT NULL,
  `monday_job_assigned` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `monday_special_skill_acquired` mediumtext NOT NULL,
  `tuesday_job_assigned` mediumtext NOT NULL,
  `tuesday_special_skill_acquired` mediumtext NOT NULL,
  `wednesday_job_assigned` mediumtext NOT NULL,
  `wednesday_special_skill_acquired` mediumtext NOT NULL,
  `thursday_job_assigned` mediumtext NOT NULL,
  `thursday_special_skill_acquired` mediumtext NOT NULL,
  `friday_job_assigned` mediumtext NOT NULL,
  `friday_special_skill_acquired` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `week10_table`
--

INSERT INTO `week10_table` (`id`, `username`, `index_number`, `monday_job_assigned`, `date`, `monday_special_skill_acquired`, `tuesday_job_assigned`, `tuesday_special_skill_acquired`, `wednesday_job_assigned`, `wednesday_special_skill_acquired`, `thursday_job_assigned`, `thursday_special_skill_acquired`, `friday_job_assigned`, `friday_special_skill_acquired`) VALUES
(59, 'COLLINS HEIGHTS', 'S11/1234/21', 'laravel', '2024-11-01 08:29:44', 'fgjgjgj', 'fnfnfn', 'ffhffggjgj', 'bfbfgngn', 'fhfhfhhfjfj', 'fngn', 'hfhfjfjff', 'bbfb', 'rhfhghg'),
(60, 'ALPHONSE OWENGA MALCOM', 'K12/1234/21', 'coding', '2025-03-29 09:58:48', 'fkrfkjfkj', 'sql', 'kfvkjfgfjkfnkfkjfgj', 'fjkfkjfk', 'fjfjfjk', 'efnkfkjfg', 'fjfijfj', 'fnfkjfg', 'fjffj');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attachment_positions`
--
ALTER TABLE `attachment_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_supervisor_grade`
--
ALTER TABLE `company_supervisor_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industrial_registration`
--
ALTER TABLE `industrial_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_registration`
--
ALTER TABLE `internal_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_students`
--
ALTER TABLE `registered_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_assumption`
--
ALTER TABLE `students_assumption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisors_login`
--
ALTER TABLE `supervisors_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_admin`
--
ALTER TABLE `system_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visiting_lecturers`
--
ALTER TABLE `visiting_lecturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visiting_supervisor_grade`
--
ALTER TABLE `visiting_supervisor_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week1_table`
--
ALTER TABLE `week1_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week2_table`
--
ALTER TABLE `week2_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week3_table`
--
ALTER TABLE `week3_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week4_table`
--
ALTER TABLE `week4_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week5_table`
--
ALTER TABLE `week5_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week6_table`
--
ALTER TABLE `week6_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week7_table`
--
ALTER TABLE `week7_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week8_table`
--
ALTER TABLE `week8_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week9_table`
--
ALTER TABLE `week9_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week10_table`
--
ALTER TABLE `week10_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachment_positions`
--
ALTER TABLE `attachment_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `company_supervisor_grade`
--
ALTER TABLE `company_supervisor_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `industrial_registration`
--
ALTER TABLE `industrial_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `internal_registration`
--
ALTER TABLE `internal_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registered_students`
--
ALTER TABLE `registered_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students_assumption`
--
ALTER TABLE `students_assumption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `supervisors_login`
--
ALTER TABLE `supervisors_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `system_admin`
--
ALTER TABLE `system_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `visiting_lecturers`
--
ALTER TABLE `visiting_lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `visiting_supervisor_grade`
--
ALTER TABLE `visiting_supervisor_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `week1_table`
--
ALTER TABLE `week1_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `week2_table`
--
ALTER TABLE `week2_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `week3_table`
--
ALTER TABLE `week3_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `week4_table`
--
ALTER TABLE `week4_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `week5_table`
--
ALTER TABLE `week5_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `week6_table`
--
ALTER TABLE `week6_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `week7_table`
--
ALTER TABLE `week7_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `week8_table`
--
ALTER TABLE `week8_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `week9_table`
--
ALTER TABLE `week9_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `week10_table`
--
ALTER TABLE `week10_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registered_students` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
