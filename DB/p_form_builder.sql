-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2024 at 12:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p_form_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1 = Published, 2 = Pending',
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PHP Developer', '1', 'Admin', NULL, '2024-10-04 23:01:51', '2024-10-04 23:01:51'),
(2, 'Python', '1', 'Admin', NULL, '2024-10-05 04:26:44', '2024-10-05 04:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `url` text NOT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 = Published, 2 = Pending',
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `category_id`, `title`, `description`, `url`, `status`, `created_by`, `updated_by`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, 'Full Stack Software Engineer (Laravel/Django/ Node.js, React, and Next.js', 'We are looking for a talented Full Stack Software Engineer with expertise in Laravel/Django/ Node.js, React, and Next.js to join our dynamic team. The ideal candidate should have a passion for technology, an eagerness to work on both front-end and back-end development, and a strong problem-solving mindset.', 'kftrdqam0v', '1', 'Admin', 'Admin', '2024-10-04 23:03:11', NULL, '2024-10-05 04:42:51'),
(2, 1, 'New Form', 'Description', 'ipxkuzoamt', '1', 'Admin', 'Admin', '2024-10-04 23:13:46', NULL, '2024-10-05 03:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `form_datas`
--

CREATE TABLE `form_datas` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `label` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `value` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `form_datas`
--

INSERT INTO `form_datas` (`id`, `form_id`, `category_id`, `label`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Name', 'text', 'Perferendis laboris', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(2, 1, 1, 'Phone Number', 'tel', '+1 (745) 489-4281', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(3, 1, 1, 'Email', 'email', 'fumubovod@mailinator.com', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(4, 1, 1, 'Gender', 'radio', 'Female', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(5, 1, 1, 'Marital Status', 'radio', 'Unmarried', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(6, 1, 1, 'Division', 'select', '[\"Rajshahi\"]', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(7, 1, 1, 'Framework', 'select', '[\"Python\"]', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(8, 1, 1, 'Interested', 'checkbox', '[\"Sports\",\"Technology\"]', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(9, 1, 1, 'Birthday', 'date', '1973-07-16', '2024-10-05 12:03:25', '2024-10-05 12:03:25'),
(10, 1, 1, 'Profile', 'file', 'favicon-916881.png', '2024-10-05 12:03:25', '2024-10-05 12:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `label` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `placeholder` varchar(191) DEFAULT NULL,
  `options` longtext COMMENT 'multiple value input',
  `required` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1 = Required, 2 = Optional',
  `multiple` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1 = Multiple, 2 = Single',
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 = Published, 2 = Pending',
  `ordering` int NOT NULL DEFAULT '0',
  `created_by` varchar(191) DEFAULT NULL,
  `updated_by` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `form_id`, `label`, `type`, `placeholder`, `options`, `required`, `multiple`, `status`, `ordering`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Name', 'text', NULL, NULL, '1', '2', '1', 1, 'Admin', NULL, NULL, '2024-10-04 23:32:32', '2024-10-05 03:10:31'),
(2, 1, 'Email', 'email', NULL, NULL, '1', '2', '1', 3, 'Admin', NULL, NULL, '2024-10-04 23:32:52', '2024-10-05 02:35:23'),
(3, 1, 'Phone Number', 'tel', NULL, NULL, '1', '2', '1', 2, 'Admin', NULL, NULL, '2024-10-05 00:38:13', '2024-10-05 02:35:23'),
(4, 1, 'Birthday', 'date', NULL, NULL, '1', '2', '1', 9, 'Admin', NULL, NULL, '2024-10-05 00:43:45', '2024-10-05 02:35:39'),
(5, 1, 'Profile', 'file', NULL, NULL, '1', '2', '1', 10, 'Admin', NULL, NULL, '2024-10-05 00:44:31', '2024-10-05 02:35:39'),
(6, 1, 'Gender', 'radio', NULL, 'Male,Female,Others', '1', '2', '1', 4, 'Admin', NULL, NULL, '2024-10-05 01:21:06', '2024-10-05 04:50:49'),
(7, 1, 'Interested', 'checkbox', NULL, 'Sports,Music,Technology,Travel', '1', '2', '1', 8, 'Admin', NULL, NULL, '2024-10-05 01:31:35', '2024-10-05 02:35:23'),
(8, 1, 'Division', 'select', NULL, 'Dhaka,Rajshahi,Sylhet', '1', '2', '1', 6, 'Admin', NULL, NULL, '2024-10-05 01:33:08', '2024-10-05 02:35:23'),
(9, 1, 'Framework', 'select', NULL, 'Python,Laravel,Node Js', '1', '2', '1', 7, 'Admin', NULL, NULL, '2024-10-05 01:53:34', '2024-10-05 02:35:23'),
(10, 1, 'Marital Status', 'radio', NULL, 'Married,Unmarried', '1', '2', '1', 5, 'Admin', NULL, NULL, '2024-10-05 01:57:01', '2024-10-05 04:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_10_04_155054_create_roles_table', 1),
(6, '2024_10_04_155055_create_users_table', 1),
(7, '2024_10_04_155056_create_categories_table', 1),
(8, '2024_10_04_155057_create_forms_table', 1),
(9, '2024_10_04_155058_create_form_fields_table', 1),
(12, '2024_10_05_113300_create_form_datas_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2024-10-04 23:01:00', '2024-10-04 23:01:00'),
(2, 'User', 'user', '2024-10-04 23:01:00', '2024-10-04 23:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `is_active` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 = Enabled, 2 = Disabled',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$cdsxzholp04UEBGnAMz2W.UwTaJ6oKREiU7SLHZ.vHYsOBGNenV3m', NULL, '1', NULL, NULL, NULL),
(2, 2, 'User', 'user@gmail.com', NULL, '$2y$12$R7f.ySuvNMztwyC.2PW5m.D.D.Ja6/nE6PWQAnOj61LKpBKcc.QFq', NULL, '1', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_category_id_foreign` (`category_id`);

--
-- Indexes for table `form_datas`
--
ALTER TABLE `form_datas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_datas_form_id_foreign` (`form_id`),
  ADD KEY `form_datas_category_id_foreign` (`category_id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_fields_form_id_foreign` (`form_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_datas`
--
ALTER TABLE `form_datas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_datas`
--
ALTER TABLE `form_datas`
  ADD CONSTRAINT `form_datas_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `form_datas_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
