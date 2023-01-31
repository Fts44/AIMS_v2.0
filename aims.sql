-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2023 at 06:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aims`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pfp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `sr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gsuite_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prsn_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffixname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ttl_id` int(11) DEFAULT NULL,
  `home_add_id` int(11) DEFAULT NULL,
  `birth_add_id` int(11) DEFAULT NULL,
  `dorm_add_id` int(11) DEFAULT NULL,
  `fam_id` int(11) DEFAULT NULL,
  `fih_id` int(11) DEFAULT NULL,
  `ec_id` int(11) DEFAULT NULL,
  `curriculum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `gl_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `prog_id` int(11) DEFAULT NULL,
  `mhpi_id` int(11) DEFAULT NULL,
  `mha_id` int(11) DEFAULT NULL,
  `mhp_id` int(11) DEFAULT NULL,
  `mhmi_id` int(11) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `vs_id` int(11) DEFAULT NULL,
  `vdd_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `password`, `pfp`, `is_verified`, `date_created`, `sr_code`, `gsuite_email`, `prsn_email`, `contact_no`, `firstname`, `middlename`, `lastname`, `suffixname`, `birthdate`, `sex`, `civil_status`, `religion`, `height`, `weight`, `blood_type`, `classification`, `position`, `license_no`, `signature`, `ttl_id`, `home_add_id`, `birth_add_id`, `dorm_add_id`, `fam_id`, `fih_id`, `ec_id`, `curriculum`, `year_level`, `gl_id`, `dept_id`, `prog_id`, `mhpi_id`, `mha_id`, `mhp_id`, `mhmi_id`, `ad_id`, `vs_id`, `vdd_id`) VALUES
(9, '$2y$10$/KBOQG2Z1trk5yH9NuXO6OXJ7m47zvalP1nR.KuFjaDlqnmRo0L7y', NULL, 1, '2023-01-30 11:40:46', NULL, 'joseph.calma@g.batstate-u.edu.ph', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tr', 'pt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '$2y$10$KJZ4rHwU8Wqec/pK9N31g.lowCanSXLo.S7ZYNBjWwrQLrIYWCAUO', NULL, 0, '2023-01-30 11:50:17', NULL, NULL, 'calmajoseph7@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'st', 'pt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_01_28_035957_create_accounts_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`),
  ADD UNIQUE KEY `accounts_sr_code_unique` (`sr_code`),
  ADD UNIQUE KEY `accounts_gsuite_email_unique` (`gsuite_email`),
  ADD UNIQUE KEY `accounts_prsn_email_unique` (`prsn_email`),
  ADD UNIQUE KEY `accounts_contact_no_unique` (`contact_no`),
  ADD UNIQUE KEY `accounts_ttl_id_unique` (`ttl_id`),
  ADD UNIQUE KEY `accounts_home_add_id_unique` (`home_add_id`),
  ADD UNIQUE KEY `accounts_birth_add_id_unique` (`birth_add_id`),
  ADD UNIQUE KEY `accounts_dorm_add_id_unique` (`dorm_add_id`),
  ADD UNIQUE KEY `accounts_fam_id_unique` (`fam_id`),
  ADD UNIQUE KEY `accounts_fih_id_unique` (`fih_id`),
  ADD UNIQUE KEY `accounts_ec_id_unique` (`ec_id`),
  ADD UNIQUE KEY `accounts_mhpi_id_unique` (`mhpi_id`),
  ADD UNIQUE KEY `accounts_mha_id_unique` (`mha_id`),
  ADD UNIQUE KEY `accounts_mhp_id_unique` (`mhp_id`),
  ADD UNIQUE KEY `accounts_mhmi_id_unique` (`mhmi_id`),
  ADD UNIQUE KEY `accounts_ad_id_unique` (`ad_id`),
  ADD UNIQUE KEY `accounts_vs_id_unique` (`vs_id`),
  ADD UNIQUE KEY `accounts_vdd_id_unique` (`vdd_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
