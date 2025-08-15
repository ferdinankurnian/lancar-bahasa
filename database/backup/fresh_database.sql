-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2024 at 05:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `forget_password_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `image`, `password`, `bio`, `status`, `created_at`, `updated_at`, `forget_password_token`) VALUES
(1, 'John Doe', 'admin@gmail.com', 'uploads/website-images/admin.jpg', '$2y$12$0KsScrqZwYPZQnuZOgBOAeleKYFDyLdiTbmUSJ9DyiC6/9SyEdjlS', NULL, 'active', '2024-08-14 21:23:20', '2024-08-14 21:23:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `announcement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE IF NOT EXISTS `badges` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `condition_from` int NOT NULL DEFAULT '0',
  `condition_to` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `key`, `image`, `name`, `description`, `condition_from`, `condition_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 'registration_badge_one', 'uploads/custom-images/wsus-img-2024-06-05-08-13-59-9888.png', 'Badge 1', NULL, 1, 2, 1, '2024-06-05 02:13:58', '2024-06-05 02:13:59'),
(2, 'registration_badge_two', 'uploads/custom-images/wsus-img-2024-06-05-08-14-23-4795.png', 'badge 2', NULL, 3, 4, 1, '2024-06-05 02:14:23', '2024-06-05 02:14:23'),
(3, 'registration_badge_three', 'uploads/custom-images/wsus-img-2024-06-05-08-14-55-9047.png', 'Badge 3', NULL, 5, 6, 1, '2024-06-05 02:14:55', '2024-06-05 02:14:55'),
(4, 'course_count_badge_one', 'uploads/custom-images/wsus-img-2024-06-05-08-15-33-5592.png', 'Badge 1', NULL, 1, 2, 1, '2024-06-05 02:15:33', '2024-06-05 02:15:33'),
(5, 'course_count_badge_two', 'uploads/custom-images/wsus-img-2024-06-05-08-16-01-1865.png', 'Badge 2', NULL, 3, 4, 1, '2024-06-05 02:16:01', '2024-06-05 02:16:01'),
(6, 'course_count_badge_three', 'uploads/custom-images/wsus-img-2024-06-05-08-16-24-6251.png', 'Badge 3', NULL, 4, 5, 1, '2024-06-05 02:16:24', '2024-06-05 02:16:24'),
(7, 'course_rating_badge_one', 'uploads/custom-images/wsus-img-2024-06-05-08-16-57-4076.png', 'Badge 1', NULL, 0, 1, 1, '2024-06-05 02:16:57', '2024-06-05 02:18:18'),
(8, 'course_rating_badge_two', 'uploads/custom-images/wsus-img-2024-06-05-08-17-26-1574.png', 'Badge 2', NULL, 2, 3, 1, '2024-06-05 02:17:26', '2024-06-05 02:18:28'),
(9, 'course_rating_badge_three', 'uploads/custom-images/wsus-img-2024-06-05-08-18-48-6887.png', 'Badge 3', NULL, 4, 5, 1, '2024-06-05 02:17:52', '2024-06-05 02:18:48'),
(10, 'course_enroll_badge_one', 'uploads/custom-images/wsus-img-2024-06-05-08-19-08-6764.png', 'Badge 1', NULL, 1, 2, 1, '2024-06-05 02:19:08', '2024-06-05 02:19:08'),
(11, 'course_enroll_badge_two', 'uploads/custom-images/wsus-img-2024-06-05-08-19-24-6958.png', 'Badge 2', NULL, 2, 3, 1, '2024-06-05 02:19:24', '2024-06-05 02:19:24'),
(12, 'course_enroll_badge_three', 'uploads/custom-images/wsus-img-2024-06-05-08-19-52-2846.png', 'Badge 3', NULL, 4, 5, 1, '2024-06-05 02:19:52', '2024-06-05 02:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `banned_histories`
--

CREATE TABLE IF NOT EXISTS `banned_histories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reasone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `basic_payments`
--

CREATE TABLE IF NOT EXISTS `basic_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `basic_payments`
--

INSERT INTO `basic_payments` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'stripe_key', 'stripe_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(2, 'stripe_secret', 'stripe_secret', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(3, 'stripe_currency_id', '1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(4, 'stripe_status', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(5, 'stripe_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(6, 'stripe_image', 'uploads/website-images/stripe.png', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(7, 'paypal_app_id', 'paypal_app_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(8, 'paypal_client_id', 'paypal_client_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(9, 'paypal_secret_key', 'paypal_secret_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(10, 'paypal_account_mode', 'sandbox', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(11, 'paypal_currency_id', '1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(12, 'paypal_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(13, 'paypal_status', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(14, 'paypal_image', 'uploads/website-images/paypal.jpg', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(15, 'bank_information', 'Bank Name => Your bank name\r\nAccount Number =>  Your bank account number\r\nRouting Number => Your bank routing number\r\nBranch => Your bank branch name', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(16, 'bank_status', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(17, 'bank_image', 'uploads/website-images/bank-pay.png', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(18, 'bank_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(19, 'bank_currency_id', '1', '2024-08-14 21:23:17', '2024-08-14 21:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `show_homepage` tinyint(1) NOT NULL DEFAULT '0',
  `is_popular` tinyint(1) NOT NULL DEFAULT '0',
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `parent_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_translations`
--

CREATE TABLE IF NOT EXISTS `blog_category_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `short_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_category_translations_blog_category_id_foreign` (`blog_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_translations`
--

CREATE TABLE IF NOT EXISTS `blog_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `seo_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `seo_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_builders`
--

CREATE TABLE IF NOT EXISTS `certificate_builders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `background` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `signature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate_builders`
--

INSERT INTO `certificate_builders` (`id`, `background`, `title`, `sub_title`, `description`, `signature`, `created_at`, `updated_at`) VALUES
(1, 'uploads/website-images/certificate.png', 'Awarded to [student_name]', 'For completing [course]', 'This certificate is awarded to recognize the successful completion of the course [course] offered on the platform [platform_name] by [instructor_name]. The recipient,[student_name], has demonstrated commendable dedication and proficiency and has successfully completed the course on \n[date].', 'uploads/website-images/signature.png', '2024-05-15 21:56:38', '2024-05-16 04:02:12');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_builder_items`
--

CREATE TABLE IF NOT EXISTS `certificate_builder_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `element_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `x_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `y_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate_builder_items`
--

INSERT INTO `certificate_builder_items` (`id`, `element_id`, `x_position`, `y_position`, `created_at`, `updated_at`) VALUES
(1, 'title', '326.99993896484375', '208', NULL, '2024-05-15 23:00:14'),
(2, 'sub_title', '377.00006103515625', '249', NULL, '2024-05-16 04:05:19'),
(3, 'description', '25', '306', NULL, '2024-05-16 04:45:02'),
(4, 'signature', '401', '412.99998474121094', NULL, '2024-05-16 04:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id_foreign` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `config` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `config`, `value`, `created_at`, `updated_at`) VALUES
(1, 'setup_complete', '0', '2024-08-10 18:13:31', '2024-08-10 18:13:31'),
(2, 'setup_stage', '1', '2024-08-10 18:13:31', '2024-08-10 18:13:31');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_sections`
--

CREATE TABLE IF NOT EXISTS `contact_sections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_one` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_two` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_one` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_two` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `map` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `offer_percentage` decimal(8,2) NOT NULL,
  `expired_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `min_price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_histories`
--

CREATE TABLE IF NOT EXISTS `coupon_histories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `coupon_id` int NOT NULL,
  `discount_amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('course','webinar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'course',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `seo_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `demo_video_storage` enum('upload','youtube','vimeo','external_link','aws') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'upload',
  `demo_video_source` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `capacity` int DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `discount` double DEFAULT NULL,
  `certificate` tinyint(1) NOT NULL DEFAULT '0',
  `downloadable` tinyint(1) NOT NULL DEFAULT '0',
  `partner_instructor` tinyint(1) NOT NULL DEFAULT '0',
  `qna` tinyint(1) NOT NULL DEFAULT '0',
  `message_for_reviewer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` enum('active','is_draft','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'is_draft',
  `is_approved` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE IF NOT EXISTS `course_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` int DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `show_at_trending` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_category_translations`
--

CREATE TABLE IF NOT EXISTS `course_category_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_category_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_chapters`
--

CREATE TABLE IF NOT EXISTS `course_chapters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `order` int NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_chapters_course_id_foreign` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_chapter_items`
--

CREATE TABLE IF NOT EXISTS `course_chapter_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `chapter_id` bigint UNSIGNED NOT NULL,
  `type` enum('lesson','quiz','document','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'lesson',
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_chapter_items_instructor_id_foreign` (`instructor_id`),
  KEY `course_chapter_items_chapter_id_foreign` (`chapter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_chapter_lessons`
--

CREATE TABLE IF NOT EXISTS `course_chapter_lessons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `chapter_id` bigint UNSIGNED NOT NULL,
  `chapter_item_id` bigint UNSIGNED NOT NULL,
  `file_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `storage` enum('upload','youtube','vimeo','external_link','google_drive','iframe','aws','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'upload',
  `volume` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_type` enum('video','audio','pdf','txt','docx','iframe','image','file','live','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'video',
  `downloadable` tinyint(1) NOT NULL DEFAULT '1',
  `order` int DEFAULT NULL,
  `is_free` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_chapter_lessons_instructor_id_foreign` (`instructor_id`),
  KEY `course_chapter_lessons_chapter_id_foreign` (`chapter_id`),
  KEY `course_chapter_lessons_chapter_item_id_foreign` (`chapter_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_delete_requests`
--

CREATE TABLE IF NOT EXISTS `course_delete_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_languages`
--

CREATE TABLE IF NOT EXISTS `course_languages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_levels`
--

CREATE TABLE IF NOT EXISTS `course_levels` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_level_translations`
--

CREATE TABLE IF NOT EXISTS `course_level_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_level_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_live_classes`
--

CREATE TABLE IF NOT EXISTS `course_live_classes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `start_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` enum('zoom','jitsi') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'zoom',
  `meeting_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `join_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_live_classes_lesson_id_foreign` (`lesson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_partner_instructors`
--

CREATE TABLE IF NOT EXISTS `course_partner_instructors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

CREATE TABLE IF NOT EXISTS `course_progress` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `chapter_id` bigint UNSIGNED DEFAULT NULL,
  `lesson_id` bigint UNSIGNED DEFAULT NULL,
  `watched` tinyint(1) NOT NULL DEFAULT '0',
  `current` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('lesson','quiz','document','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'lesson',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_reviews`
--

CREATE TABLE IF NOT EXISTS `course_reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_selected_filter_options`
--

CREATE TABLE IF NOT EXISTS `course_selected_filter_options` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `filter_id` bigint UNSIGNED NOT NULL,
  `filter_option_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_selected_languages`
--

CREATE TABLE IF NOT EXISTS `course_selected_languages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_selected_levels`
--

CREATE TABLE IF NOT EXISTS `course_selected_levels` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` bigint UNSIGNED NOT NULL,
  `level_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_codes`
--

CREATE TABLE IF NOT EXISTS `custom_codes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `css` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `javascript` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `header_javascript` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

CREATE TABLE IF NOT EXISTS `custom_pages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_page_translations`
--

CREATE TABLE IF NOT EXISTS `custom_page_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `custom_page_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_paginations`
--

CREATE TABLE IF NOT EXISTS `custom_paginations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `item_qty` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_paginations`
--

INSERT INTO `custom_paginations` (`id`, `section_name`, `item_qty`, `created_at`, `updated_at`) VALUES
(1, 'Blog List', 10, '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(2, 'Blog Comment', 10, '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(3, 'Media List', 10, '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(4, 'Language List', 50, '2024-08-14 21:23:17', '2024-08-14 21:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'password_reset', 'Password Reset', '<p>Dear {{user_name}},</p>\n                <p>Do you want to reset your password? Please Click the following link and Reset Your Password.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(2, 'contact_mail', 'Contact Email', '<p>Hello there,</p>\n                <p>&nbsp;Mr. {{name}} has sent a new message. you can see the message details below.&nbsp;</p>\n                <p>Email: {{email}}</p>\n                <p>Phone: {{phone}}</p>\n                <p>Subject: {{subject}}</p>\n                <p>Message: {{message}}</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(3, 'subscribe_notification', 'Subscribe Notification', '<p>Hi there, Congratulations! Your Subscription has been created successfully. Please Click the following link and Verified Your Subscription. If you will not approve this link, you can not get any newsletter from us.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(4, 'user_verification', 'User Verification', '<p>Dear {{user_name}},</p>\n                <p>Congratulations! Your Account has been created successfully. Please Click the following link and Active your Account.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(5, 'approved_refund', 'Refund Request Approval', '<p>Dear {{user_name}},</p>\n                <p>We are happy to say that, we have send {{refund_amount}} USD to your provided bank information. </p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(6, 'new_refund', 'New Refund Request', '<p>Hello websolutionus, </p>\n\n                <p>Mr. {{user_name}} has send a new refund request to you.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(7, 'pending_wallet_payment', 'Wallet Payment Approval', '<p>Hello {{user_name}},</p>\n                <p>We have received your wallet payment request. we find your payment to our bank account.</p>\n                <p>Thanks &amp; Regards</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(8, 'approved_withdraw', 'Withdraw Request Approval', '<p>Dear {{user_name}},</p>\n                <p>We are happy to say that, we have send a withdraw amount to your provided bank information.</p>\n                <p>Thanks &amp; Regards</p>\n                <p>WebSolutionUs</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(9, 'rejected_withdraw', 'Withdraw Request Rejected', '<p>Dear {{user_name}},</p>\n                <p> your withdraw request has been rejected.</p>\n                <p>Thanks &amp; Regards</p>\n                <p>WebSolutionUs</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(10, 'pending_withdraw', 'Withdraw Request Pending', '<p>Dear {{user_name}},</p>\n                <p> your withdraw request is waiting for approval.</p>\n                <p>Thanks &amp; Regards</p>\n                <p>WebSolutionUs</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(11, 'instructor_request_approved', 'Instructor Request Approval', '<p>Dear {{user_name}},</p>\n                <p>you are now approved as an instructor.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(12, 'instructor_request_rejected', 'Instructor Request Rejected', '<p>Dear {{user_name}},</p>\n                <p>your request has been rejected. please resubmit your request with proper document. or contact us.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(13, 'instructor_request_pending', 'Instructor Request is waiting for approval', '<p>Dear {{user_name}},</p>\n                <p>your request for become an instructor is waiting for approval. please wait. we will send you an email when your request is approved.</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(14, 'instructor_quick_contact', 'Mail for instructor contact form', '<p>Name: {{name}}</p>\n                <p>Email: {{email}}</p>\n                <p>Subject: {{subject}}</p>\n                <p>{{message}}</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(15, 'order_completed', 'Your order has been placed', '<p>HI, {{name}}</p>\n                <p>product id: {{order_id}}</p>\n                <p>paid amount: {{paid_amount}}</p>\n                <p>payment method: {{payment_method}}</p>', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(16, 'qna_reply_mail', 'QNA Replay mail', '<p>Hi {{user_name}}, your instructor has replied to your question. Please see the answer below:</p>\r\n<p>Course: {{course}}</p>\r\n<p>Lesson: {{lesson}}</p>\r\n<p>Question: {{question}}</p>', '2024-08-25 03:36:19', '2024-08-25 03:36:19'),
(17, 'live_class_mail', 'Live class notification mail', '<p>Hi {{user_name}},</p>\r\n                <p>Your live class is starting at {{start_time}}. Please see the details below:</p>\r\n                <p><strong>Course:</strong> {{course}}</p>\r\n                <p><strong>Lesson:</strong> {{lesson}}</p>\r\n                <p><strong>Meeting Link:</strong> <a href=\"{{join_url}}\">{{join_url}}</a></p>', '2024-09-03 13:01:51', '2024-09-03 13:01:51');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `has_access` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enrollments_order_id_foreign` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_translations`
--

CREATE TABLE IF NOT EXISTS `faq_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `faq_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `featured_course_sections`
--

CREATE TABLE IF NOT EXISTS `featured_course_sections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `all_category` int DEFAULT NULL,
  `all_category_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `all_category_status` tinyint(1) NOT NULL DEFAULT '1',
  `category_one` int DEFAULT NULL,
  `category_one_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category_one_status` tinyint(1) NOT NULL DEFAULT '1',
  `category_two` int DEFAULT NULL,
  `category_two_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category_two_status` tinyint(1) NOT NULL DEFAULT '1',
  `category_three` int DEFAULT NULL,
  `category_three_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category_three_status` tinyint(1) NOT NULL DEFAULT '1',
  `category_four` int DEFAULT NULL,
  `category_four_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category_four_status` tinyint(1) NOT NULL DEFAULT '1',
  `category_five` int DEFAULT NULL,
  `category_five_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category_five_status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `featured_instructors`
--

CREATE TABLE IF NOT EXISTS `featured_instructors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `button_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instructor_ids` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `featured_instructors`
--

INSERT INTO `featured_instructors` (`id`, `button_url`, `instructor_ids`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '2024-08-14 21:23:21', '2024-08-14 21:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `featured_instructor_translations`
--

CREATE TABLE IF NOT EXISTS `featured_instructor_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `featured_instructor_section_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `button_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

CREATE TABLE IF NOT EXISTS `footer_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `footer_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `get_in_touch_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `google_play_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apple_store_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homes`
--

CREATE TABLE IF NOT EXISTS `homes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homes_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homes`
--

INSERT INTO `homes` (`id`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'main', '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(2, 'online', '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(3, 'university', '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(4, 'business', '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(5, 'yoga', '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(6, 'kitchen', '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(7, 'kindergarten', '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(8, 'language', '2024-11-12 23:33:01', '2024-11-12 23:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_requests`
--

CREATE TABLE IF NOT EXISTS `instructor_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `certificate` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `identity_scan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `payout_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payout_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `extra_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_request_settings`
--

CREATE TABLE IF NOT EXISTS `instructor_request_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `need_certificate` tinyint(1) NOT NULL DEFAULT '1',
  `need_identity_scan` tinyint(1) NOT NULL DEFAULT '1',
  `bank_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_request_setting_translations`
--

CREATE TABLE IF NOT EXISTS `instructor_request_setting_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_request_setting_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instructions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jitsi_settings`
--

CREATE TABLE IF NOT EXISTS `jitsi_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `api_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jitsi_settings_instructor_id_foreign` (`instructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ltr',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `is_default` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_name_unique` (`name`),
  UNIQUE KEY `languages_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `direction`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', NULL, 'ltr', '1', '1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(2, 'Hindi', 'hi', NULL, 'ltr', '1', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(3, 'Arabic', 'ar', NULL, 'rtl', '1', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_questions`
--

CREATE TABLE IF NOT EXISTS `lesson_questions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `question_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_replies`
--

CREATE TABLE IF NOT EXISTS `lesson_replies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reply` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_replies_question_id_foreign` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_settings`
--

CREATE TABLE IF NOT EXISTS `marketing_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marketing_settings`
--

INSERT INTO `marketing_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'register', '1', '2024-06-02 20:02:30', '2024-06-24 18:17:45'),
(2, 'course_details', '1', '2024-06-02 20:02:30', '2024-06-02 20:02:30'),
(3, 'add_to_cart', '1', '2024-06-02 20:02:30', '2024-06-04 00:28:37'),
(4, 'remove_from_cart', '1', '2024-06-02 20:02:30', '2024-06-04 00:28:37'),
(5, 'checkout', '1', '2024-06-02 20:02:30', '2024-06-24 18:17:45'),
(6, 'order_success', '1', '2024-06-02 20:02:30', '2024-06-04 00:28:37'),
(7, 'order_failed', '1', '2024-06-02 20:02:30', '2024-06-13 02:02:21'),
(8, 'contact_page', '1', '2024-06-02 20:02:30', '2024-06-13 02:02:21'),
(9, 'instructor_contact', '1', '2024-06-02 20:02:30', '2024-06-13 02:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(9, 'nav_menu', 'nav-menu', '2024-05-23 06:10:20', '2024-05-23 06:10:20'),
(10, 'footer_col_one', 'footer-col-one', '2024-05-26 00:25:04', '2024-05-26 00:25:04'),
(13, 'footer_col_two', 'footer-col-two-1PiTN', '2024-05-26 00:25:37', '2024-05-26 00:25:37'),
(14, 'footer_col_three', 'footer-col-three', '2024-05-26 00:32:09', '2024-05-26 00:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `sort` int NOT NULL DEFAULT '0',
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `depth` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_translations`
--

CREATE TABLE IF NOT EXISTS `menu_item_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_item_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_item_translations_menu_item_id_foreign` (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_translations`
--

CREATE TABLE IF NOT EXISTS `menu_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_translations_menu_id_foreign` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_translations`
--

INSERT INTO `menu_translations` (`id`, `menu_id`, `lang_code`, `name`, `created_at`, `updated_at`) VALUES
(7, 9, 'en', 'nav_menu', '2024-05-23 06:10:20', '2024-05-23 06:10:20'),
(9, 10, 'en', 'footer_col_one', '2024-05-26 00:25:04', '2024-05-26 00:25:04'),
(15, 13, 'en', 'footer_col_two', '2024-05-26 00:25:37', '2024-05-26 00:25:37'),
(17, 14, 'en', 'footer_col_three', '2024-05-26 00:32:09', '2024-05-26 00:32:09'),
(23, 9, 'bn', 'nav_menu', '2024-05-31 11:14:54', '2024-05-31 11:14:54'),
(24, 10, 'bn', 'footer_col_one', '2024-05-31 11:14:54', '2024-05-31 11:14:54'),
(25, 13, 'bn', 'footer_col_two', '2024-05-31 11:14:54', '2024-05-31 11:14:54'),
(26, 14, 'bn', 'footer_col_three', '2024-05-31 11:14:54', '2024-05-31 11:14:54'),
(27, 9, 'hi', 'nav_menu', '2024-05-31 11:15:13', '2024-05-31 11:15:13'),
(28, 10, 'hi', 'footer_col_one', '2024-05-31 11:15:13', '2024-05-31 11:15:13'),
(29, 13, 'hi', 'footer_col_two', '2024-05-31 11:15:13', '2024-05-31 11:15:13'),
(30, 14, 'hi', 'footer_col_three', '2024-05-31 11:15:13', '2024-05-31 11:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_05_045432_create_admins_table', 1),
(6, '2023_11_05_114814_create_languages_table', 1),
(7, '2023_11_06_043247_create_settings_table', 1),
(8, '2023_11_06_054251_create_seo_settings_table', 1),
(9, '2023_11_06_094842_create_custom_paginations_table', 1),
(10, '2023_11_06_115856_create_email_templates_table', 1),
(11, '2023_11_07_051924_create_multi_currencies_table', 1),
(12, '2023_11_07_103108_create_basic_payments_table', 1),
(13, '2023_11_07_104315_create_blog_categories_table', 1),
(14, '2023_11_07_104328_create_blog_category_translations_table', 1),
(15, '2023_11_07_104336_create_blogs_table', 1),
(16, '2023_11_07_104343_create_blog_translations_table', 1),
(17, '2023_11_07_104546_create_blog_comments_table', 1),
(18, '2023_11_09_035236_create_payment_gateways_table', 1),
(19, '2023_11_09_100621_create_jobs_table', 1),
(20, '2023_11_16_035458_add_user_info_to_users', 1),
(21, '2023_11_16_061508_add_forget_info_to_users', 1),
(22, '2023_11_16_063639_add_phone_to_users', 1),
(23, '2023_11_19_055229_add_image_to_users', 1),
(24, '2023_11_19_064341_create_banned_histories_table', 1),
(25, '2023_11_21_043030_create_news_letters_table', 1),
(26, '2023_11_21_094702_create_contact_messages_table', 1),
(27, '2023_11_22_105539_create_permission_tables', 1),
(28, '2023_11_29_055540_create_orders_table', 1),
(29, '2023_11_29_095126_create_coupons_table', 1),
(30, '2023_11_29_104658_create_testimonials_table', 1),
(31, '2023_11_29_104704_create_testimonial_translations_table', 1),
(32, '2023_11_29_105234_create_coupon_histories_table', 1),
(33, '2023_11_29_113632_add_min_price_to_coupon', 1),
(34, '2023_11_30_044838_create_faqs_table', 1),
(35, '2023_11_30_044844_create_faq_translations_table', 1),
(36, '2023_11_30_095404_add_wallet_balance_to_users', 1),
(37, '2023_12_04_071839_create_withraw_methods_table', 1),
(38, '2023_12_04_095319_create_withdraw_requests_table', 1),
(39, '2024_01_01_054644_create_socialite_credentials_table', 1),
(40, '2024_01_03_092007_create_custom_codes_table', 1),
(41, '2024_02_28_064128_add_forgot_info_to_admins', 1),
(42, '2024_03_28_095207_create_menus_wp_table', 1),
(43, '2024_03_28_095208_create_menu_translations_table', 1),
(44, '2024_03_28_095209_create_menu_items_wp_table', 1),
(45, '2024_03_28_095210_create_menu_item_translations_table', 1),
(46, '2024_03_28_095211_add-role-id-to-menu-items-table', 1),
(47, '2024_04_03_042331_add_new_columns_to_users', 1),
(48, '2024_04_03_044043_create_user_education_table', 1),
(49, '2024_04_03_044103_create_user_experiences_table', 1),
(50, '2024_04_03_044134_create_user_skill_topics_table', 1),
(51, '2024_04_05_060046_create_countries_table', 1),
(52, '2024_04_05_060133_create_states_table', 1),
(53, '2024_04_05_060149_create_cities_table', 1),
(54, '2024_04_08_041719_create_instructor_requests_table', 1),
(55, '2024_04_08_042513_create_instructor_request_settings_table', 1),
(56, '2024_04_15_103628_create_course_categories_table', 1),
(57, '2024_04_15_112656_create_course_category_translations_table', 1),
(58, '2024_04_18_031942_create_course_languages_table', 1),
(59, '2024_04_18_044110_create_course_levels_table', 1),
(60, '2024_04_18_044125_create_course_level_translations_table', 1),
(61, '2024_04_18_070749_create_courses_table', 1),
(62, '2024_04_21_093245_create_course_partner_instructors_table', 1),
(63, '2024_04_21_094654_create_course_selected_levels_table', 1),
(64, '2024_04_21_094841_create_course_selected_languages_table', 1),
(65, '2024_04_21_095342_create_course_selected_filter_options_table', 1),
(66, '2024_04_22_114039_create_course_chapters_table', 1),
(67, '2024_04_23_090340_create_course_chapter_items_table', 1),
(68, '2024_04_23_090700_create_course_chapter_lessons_table', 1),
(69, '2024_04_24_093046_create_quizzes_table', 1),
(70, '2024_04_24_114441_create_quiz_questions_table', 1),
(71, '2024_04_28_034905_create_quiz_question_answers_table', 1),
(72, '2024_05_06_094927_create_order_items_table', 1),
(73, '2024_05_06_094946_create_enrollments_table', 1),
(74, '2024_05_12_035535_create_course_progress_table', 1),
(75, '2024_05_13_041532_create_quiz_results_table', 1),
(76, '2024_05_13_101033_create_lesson_questions_table', 1),
(77, '2024_05_13_101258_create_lesson_replies_table', 1),
(78, '2024_05_14_095807_create_announcements_table', 1),
(79, '2024_05_14_114640_create_course_reviews_table', 1),
(80, '2024_05_16_034644_create_certificate_builders_table', 1),
(81, '2024_05_16_041919_create_certificate_builder_items_table', 1),
(82, '2024_05_16_110701_create_badges_table', 1),
(83, '2024_05_20_052819_create_brands_table', 1),
(84, '2024_05_20_094331_create_featured_course_sections_table', 1),
(85, '2024_05_21_060612_create_featured_instructors_table', 1),
(86, '2024_05_21_060634_create_featured_instructor_translations_table', 1),
(87, '2024_05_26_032547_create_section_settings_table', 1),
(88, '2024_05_26_052359_create_footer_settings_table', 1),
(89, '2024_05_26_065953_create_social_links_table', 1),
(90, '2024_05_26_164008_create_contact_sections_table', 1),
(91, '2024_05_27_045919_create_custom_pages_table', 1),
(92, '2024_05_27_050016_create_custom_page_translations_table', 1),
(93, '2024_06_02_045115_add_softdelete_to_courses_table', 1),
(94, '2024_06_02_080423_create_course_delete_requests_table', 1),
(95, '2024_02_10_060044_create_configurations_table', 1),
(96, '2024_09_01_042120_create_course_live_classes_table', 1),
(97, '2024_09_01_042119_create_zoom_credentials_table', 1),
(98, '2024_09_04_122554_create_jitsi_settings_table', 1),
(99, '2024_09_10_103347_create_marketing_settings_table', 1),
(100, '2024_09_29_090219_create_instructor_request_setting_translations_table', 2),
(101, '2024_10_08_060425_create_homes_table', 3),
(102, '2024_10_08_060618_create_sections_table', 3),
(103, '2024_10_08_060636_create_section_translations_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `multi_currencies`
--

CREATE TABLE IF NOT EXISTS `multi_currencies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `country_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_default` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency_rate` float NOT NULL,
  `currency_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'before_price',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `multi_currencies`
--

INSERT INTO `multi_currencies` (`id`, `currency_name`, `country_code`, `currency_code`, `currency_icon`, `is_default`, `currency_rate`, `currency_position`, `status`, `created_at`, `updated_at`) VALUES
(1, '$-USD', 'US', 'USD', '$', 'yes', 1, 'before_price', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(2, '₦-Naira', 'NG', 'NGN', '₦', 'no', 417.35, 'before_price', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(3, '₹-Rupee', 'IN', 'INR', '₹', 'no', 74.66, 'before_price', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(4, '₱-Peso', 'PH', 'PHP', '₱', 'no', 55.07, 'before_price', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(5, '$-CAD', 'CA', 'CAD', '$', 'no', 1.27, 'before_price', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(6, '৳-Taka', 'BD', 'BDT', '৳', 'no', 80, 'before_price', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `news_letters`
--

CREATE TABLE IF NOT EXISTS `news_letters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'not_verified',
  `verify_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `buyer_id` bigint UNSIGNED DEFAULT NULL,
  `seller_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','processing','completed','declined') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `has_coupon` tinyint(1) NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `coupon_discount_percent` int DEFAULT NULL,
  `coupon_discount_amount` double DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payable_amount` double DEFAULT NULL,
  `gateway_charge` double DEFAULT NULL,
  `payable_with_charge` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `conversion_rate` double DEFAULT NULL,
  `payable_currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `commission_rate` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `price` double NOT NULL,
  `item_type` enum('course','product') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'course',
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `commission_rate` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'razorpay_key', 'razorpay_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(2, 'razorpay_secret', 'razorpay_secret', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(3, 'razorpay_name', 'WebSolutionUs', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(4, 'razorpay_description', 'This is test payment window', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(5, 'razorpay_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(6, 'razorpay_theme_color', '#6d0ce4', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(7, 'razorpay_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(8, 'razorpay_currency_id', '3', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(9, 'razorpay_image', 'uploads/website-images/razorpay.jpeg', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(10, 'flutterwave_public_key', 'flutterwave_public_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(11, 'flutterwave_secret_key', 'flutterwave_secret_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(12, 'flutterwave_app_name', 'WebSolutionUs', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(13, 'flutterwave_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(14, 'flutterwave_currency_id', '2', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(15, 'flutterwave_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(16, 'flutterwave_image', 'uploads/website-images/flutterwave.jpg', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(17, 'paystack_public_key', 'paystack_public_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(18, 'paystack_secret_key', 'paystack_secret_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(19, 'paystack_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(20, 'paystack_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(21, 'paystack_image', 'uploads/website-images/paystack.png', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(22, 'paystack_currency_id', '2', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(23, 'mollie_key', 'mollie_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(24, 'mollie_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(25, 'mollie_image', 'uploads/website-images/mollie.png', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(26, 'mollie_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(27, 'mollie_currency_id', '5', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(28, 'instamojo_account_mode', 'Sandbox', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(29, 'instamojo_api_key', 'instamojo_api_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(30, 'instamojo_auth_token', 'instamojo_auth_token', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(31, 'instamojo_charge', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(32, 'instamojo_image', 'uploads/website-images/instamojo.png', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(33, 'instamojo_currency_id', '3', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(34, 'instamojo_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'admin', 'dashboard', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(2, 'admin.profile.view', 'admin', 'admin profile', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(3, 'admin.profile.update', 'admin', 'admin profile', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(4, 'admin.view', 'admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(5, 'admin.create', 'admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(6, 'admin.store', 'admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(7, 'admin.edit', 'admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(8, 'admin.update', 'admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(9, 'admin.delete', 'admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(10, 'blog.category.view', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(11, 'blog.category.create', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(12, 'blog.category.translate', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(13, 'blog.category.store', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(14, 'blog.category.edit', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(15, 'blog.category.update', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(16, 'blog.category.delete', 'admin', 'blog category', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(17, 'blog.view', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(18, 'blog.create', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(19, 'blog.translate', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(20, 'blog.store', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(21, 'blog.edit', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(22, 'blog.update', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(23, 'blog.delete', 'admin', 'blog', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(24, 'blog.comment.view', 'admin', 'blog comment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(25, 'blog.comment.update', 'admin', 'blog comment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(26, 'blog.comment.delete', 'admin', 'blog comment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(27, 'role.view', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(28, 'role.create', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(29, 'role.store', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(30, 'role.assign', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(31, 'role.edit', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(32, 'role.update', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(33, 'role.delete', 'admin', 'role', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(34, 'setting.view', 'admin', 'setting', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(35, 'setting.update', 'admin', 'setting', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(36, 'basic.payment.view', 'admin', 'basic payment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(37, 'basic.payment.update', 'admin', 'basic payment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(38, 'contect.message.view', 'admin', 'contect message', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(39, 'contect.message.delete', 'admin', 'contect message', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(40, 'currency.view', 'admin', 'currency', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(41, 'currency.create', 'admin', 'currency', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(42, 'currency.store', 'admin', 'currency', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(43, 'currency.edit', 'admin', 'currency', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(44, 'currency.update', 'admin', 'currency', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(45, 'currency.delete', 'admin', 'currency', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(46, 'customer.view', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(47, 'customer.bulk.mail', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(48, 'customer.create', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(49, 'customer.store', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(50, 'customer.edit', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(51, 'customer.update', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(52, 'customer.delete', 'admin', 'customer', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(53, 'language.view', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(54, 'language.create', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(55, 'language.store', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(56, 'language.edit', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(57, 'language.update', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(58, 'language.delete', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(59, 'language.translate', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(60, 'language.single.translate', 'admin', 'language', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(61, 'menu.view', 'admin', 'menu builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(62, 'menu.create', 'admin', 'menu builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(63, 'menu.store', 'admin', 'menu builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(64, 'menu.edit', 'admin', 'menu builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(65, 'menu.update', 'admin', 'menu builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(66, 'menu.delete', 'admin', 'menu builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(67, 'page.management', 'admin', 'page builder', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(68, 'payment.view', 'admin', 'payment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(69, 'payment.update', 'admin', 'payment', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(70, 'newsletter.view', 'admin', 'newsletter', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(71, 'newsletter.mail', 'admin', 'newsletter', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(72, 'newsletter.delete', 'admin', 'newsletter', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(73, 'testimonial.view', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(74, 'testimonial.create', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(75, 'testimonial.translate', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(76, 'testimonial.store', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(77, 'testimonial.edit', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(78, 'testimonial.update', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(79, 'testimonial.delete', 'admin', 'testimonial', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(80, 'faq.view', 'admin', 'faq', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(81, 'faq.create', 'admin', 'faq', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(82, 'faq.translate', 'admin', 'faq', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(83, 'faq.store', 'admin', 'faq', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(84, 'faq.edit', 'admin', 'faq', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(85, 'faq.update', 'admin', 'faq', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(86, 'faq.delete', 'admin', 'faq', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(87, 'location.view', 'admin', 'locations', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(88, 'location.create', 'admin', 'locations', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(89, 'location.store', 'admin', 'locations', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(90, 'location.edit', 'admin', 'locations', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(91, 'location.update', 'admin', 'locations', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(92, 'location.delete', 'admin', 'locations', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(93, 'instructor.request.list', 'admin', 'instructor request', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(94, 'instructor.request.setting', 'admin', 'instructor request', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(95, 'course.management', 'admin', 'courses', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(96, 'course.certificate.management', 'admin', 'course certificate management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(97, 'badge.management', 'admin', 'Badges', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(98, 'order.management', 'admin', 'order management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(99, 'coupon.management', 'admin', 'coupon management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(100, 'withdraw.management', 'admin', 'withdraw management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(101, 'appearance.management', 'admin', 'site appearance management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(102, 'section.management', 'admin', 'site appearance management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(103, 'brand.management', 'admin', 'brand management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(104, 'footer.management', 'admin', 'footer management', '2024-08-14 21:23:19', '2024-08-14 21:23:19'),
(105, 'social.link.management', 'admin', 'social link management', '2024-08-14 21:23:19', '2024-08-14 21:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `chapter_item_id` bigint UNSIGNED NOT NULL,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `chapter_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attempt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pass_mark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_mark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('descriptive','multiple') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'multiple',
  `grade` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_questions_quiz_id_foreign` (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_answers`
--

CREATE TABLE IF NOT EXISTS `quiz_question_answers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `correct` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE IF NOT EXISTS `quiz_results` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `result` json DEFAULT NULL,
  `user_grade` int DEFAULT NULL,
  `status` enum('pass','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', '2024-08-14 21:23:18', '2024-08-14 21:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `home_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `global_content` json DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_home_id_foreign` (`home_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `home_id`, `name`, `global_content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'hero_section', '{\"banner_image\": \"uploads/custom-images/wsus-img-2024-06-26-06-06-24-6800.png\", \"hero_background\": \"uploads/custom-images/wsus-img-2024-06-23-04-25-27-8319.png\", \"video_button_url\": \"https://www.youtube.com/watch?v=pMzGDBP6Bic\", \"action_button_url\": \"/courses\", \"banner_background\": \"uploads/custom-images/wsus-img-2024-06-03-09-44-49-7136.png\", \"enroll_students_image\": \"uploads/custom-images/wsus-img-2024-06-03-09-44-49-4396.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(2, 1, 'about_section', '{\"image\": \"uploads/custom-images/wsus-img-2024-06-03-07-17-53-5562.png\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(3, 1, 'newsletter_section', '{\"image\": \"uploads/custom-images/wsus-img-2024-06-04-11-18-08-2099.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(4, 1, 'counter_section', '{\"total_awards_count\": 50, \"total_courses_count\": 800, \"total_student_count\": 3000, \"total_instructor_count\": 100}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(5, 1, 'faq_section', '{\"image\": \"uploads/custom-images/wsus-img-2024-06-04-11-35-48-7341.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(6, 1, 'our_features_section', '{\"image_one\": \"uploads/custom-images/wsus-img-2024-06-11-05-27-50-9263.png\", \"image_two\": \"uploads/custom-images/wsus-img-2024-06-11-05-49-32-6821.png\", \"image_four\": \"uploads/custom-images/wsus-img-2024-06-11-05-27-50-7828.png\", \"image_three\": \"uploads/custom-images/wsus-img-2024-06-23-05-11-29-2802.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(7, 1, 'banner_section', '{\"student_image\": \"uploads/custom-images/wsus-img-2024-06-04-11-44-52-8789.png\", \"instructor_image\": \"uploads/custom-images/wsus-img-2024-06-04-11-44-52-4232.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(8, 2, 'hero_section', '{\"banner_image\": \"uploads/custom-images/theme_online_banner_img.png\", \"hero_background\": \"uploads/custom-images/theme_online_hero_bg.png\", \"video_button_url\": \"https://www.youtube.com/watch?v=pMzGDBP6Bic\", \"action_button_url\": \"/courses\", \"banner_background\": \"uploads/custom-images/theme_online_banner_bg.svg\", \"enroll_students_image\": \"uploads/custom-images/theme_online_enroll_students_image.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(9, 2, 'about_section', '{\"image\": \"uploads/custom-images/theme_online_about_img.png\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(10, 2, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_online_newsletter.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(11, 2, 'counter_section', '{\"total_courses_count\": 800, \"total_student_count\": 3000, \"total_instructor_count\": 100}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(12, 2, 'faq_section', '{\"image\": \"uploads/custom-images/theme_online_faq.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(13, 2, 'our_features_section', '{\"image_one\": \"uploads/custom-images/theme_online_features_icon_1.png\", \"image_two\": \"uploads/custom-images/theme_online_features_icon_2.png\", \"image_four\": \"uploads/custom-images/theme_online_features_icon_4.png\", \"image_three\": \"uploads/custom-images/theme_online_features_icon_3.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(14, 2, 'banner_section', '{\"student_image\": \"uploads/custom-images/theme_online_student_image.png\", \"instructor_image\": \"uploads/custom-images/theme_online_instructor_image.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(15, 3, 'hero_section', '{\"banner_image\": \"uploads/custom-images/theme_university_banner_img.png\", \"hero_background\": \"uploads/custom-images/theme_university_hero_bg.jpg\", \"action_button_url\": \"/courses\", \"banner_background\": \"uploads/custom-images/theme_university_banner_bg.svg\", \"enroll_students_image\": \"uploads/custom-images/theme_university_enroll_students_image.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(16, 3, 'about_section', '{\"image\": \"uploads/custom-images/theme_university_about_img.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\", \"year_experience\": \"15\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(17, 3, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_university_newsletter.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(18, 3, 'counter_section', '{\"button_url\": \"/courses\", \"total_courses_count\": 800, \"total_student_count\": 3000, \"total_instructor_count\": 100}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(19, 3, 'faq_section', '{\"image\": \"uploads/custom-images/theme_university_faq.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(20, 3, 'our_features_section', '{\"image_one\": \"uploads/custom-images/theme_university_features_icon_1.svg\", \"image_two\": \"uploads/custom-images/theme_university_features_icon_2.svg\", \"image_four\": \"uploads/custom-images/theme_university_features_icon_4.svg\", \"image_three\": \"uploads/custom-images/theme_university_features_icon_3.svg\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(21, 3, 'banner_section', '{\"bg_image\": \"uploads/custom-images/wsus-img-2024-06-04-11-44-52-8799.jpg\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(22, 4, 'slider_section', '{\"image_one\": \"uploads/custom-images/theme_business_slider_1.jpg\", \"image_two\": \"uploads/custom-images/theme_business_slider_2.webp\", \"image_three\": \"uploads/custom-images/theme_business_slider_3.webp\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(23, 4, 'about_section', '{\"image\": \"uploads/custom-images/theme_business_about_img.jpg\", \"image_two\": \"uploads/custom-images/wsus-img-2024-06-03-07-17-53-5555.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\", \"image_three\": \"uploads/custom-images/wsus-img-2024-06-03-07-17-53-6666.jpg\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(24, 4, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_business_newsletter.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(25, 4, 'our_features_section', '{\"image_one\": \"uploads/custom-images/theme_business_features_icon_1.png\", \"image_two\": \"uploads/custom-images/theme_business_features_icon_2.png\", \"image_four\": \"uploads/custom-images/theme_business_features_icon_4.png\", \"image_three\": \"uploads/custom-images/theme_business_features_icon_3.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(26, 4, 'banner_section', '{\"student_image\": \"uploads/custom-images/theme_business_student_image.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(27, 4, 'faq_section', '{\"image\": \"uploads/custom-images/theme_business_faq.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(28, 5, 'hero_section', '{\"banner_image\": \"uploads/custom-images/h4_hero_img.png\", \"booking_number\": \"+1 (123) 909090\", \"hero_background\": \"uploads/custom-images/h4_hero_bg.jpg\", \"action_button_url\": \"/courses\", \"banner_background\": \"uploads/custom-images/h4_hero_img_shape02.svg\", \"banner_background_two\": \"uploads/custom-images/h4_hero_img_shape01.svg\", \"enroll_students_image\": \"uploads/custom-images/theme_yoga_enroll_students_image.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(29, 5, 'our_features_section', '{\"image_one\": \"uploads/custom-images/h4_features_icon01.svg\", \"image_two\": \"uploads/custom-images/h4_features_icon02.svg\", \"image_four\": \"uploads/custom-images/h4_features_icon04.png\", \"image_three\": \"uploads/custom-images/h4_features_icon03.svg\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(30, 5, 'about_section', '{\"image\": \"uploads/custom-images/h4_choose_img.jpg\", \"image_two\": \"uploads/custom-images/h4_choose_img02.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(31, 5, 'banner_section', '{\"bg_image\": \"uploads/custom-images/h4_video_bg.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=pMzGDBP6Bic\", \"student_image\": \"uploads/custom-images/h4_cta_img.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(32, 5, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_yoga_newslettter.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(33, 5, 'faq_section', '{\"image\": \"uploads/custom-images/theme_yoga_faq.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(34, 6, 'hero_section', '{\"banner_image\": \"uploads/custom-images/h8_hero_img.png\", \"hero_background\": \"uploads/custom-images/h8_hero_bg.jpg\", \"banner_background\": \"uploads/custom-images/h8_hero_img_shape.svg\", \"banner_background_two\": \"uploads/custom-images/h8_hero_img_shape02.svg\", \"enroll_students_image\": \"uploads/custom-images/theme_kitchen_enroll_students_image.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(35, 6, 'our_features_section', '{\"image_one\": \"uploads/custom-images/theme_kitchen_features_icon_1.png\", \"image_two\": \"uploads/custom-images/theme_kitchen_features_icon_2.png\", \"image_four\": \"uploads/custom-images/theme_kitchen_features_icon_4.png\", \"image_three\": \"uploads/custom-images/theme_kitchen_features_icon_3.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(36, 6, 'about_section', '{\"image\": \"uploads/custom-images/h8_about_img01.jpg\", \"image_two\": \"uploads/custom-images/h8_about_img02.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\", \"image_three\": \"uploads/custom-images/skillgro-diploma.png\", \"course_success\": \"86\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(37, 6, 'banner_section', '{\"student_image\": \"uploads/custom-images/h8_cta_img.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(38, 6, 'faq_section', '{\"image\": \"uploads/custom-images/theme_kitchen_faq.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(39, 6, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_kitchen_newslettter.png\"}', 1, '2024-10-15 15:42:24', '2024-10-15 15:42:24'),
(40, 7, 'hero_section', '{\"banner_image\": \"uploads/custom-images/h5_hero_img.png\", \"hero_background\": \"uploads/custom-images/h5_hero_bg.jpg\", \"action_button_url\": \"/courses\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(41, 7, 'our_features_section', '{\"image_one\": \"uploads/custom-images/theme_kindergarten_features_icon_1.png\", \"image_two\": \"uploads/custom-images/theme_kindergarten_features_icon_2.png\", \"image_four\": \"uploads/custom-images/theme_kindergarten_features_icon_4.png\", \"image_three\": \"uploads/custom-images/theme_kindergarten_features_icon_3.png\", \"button_url_one\": \"/about-us\", \"button_url_two\": \"/about-us\", \"button_url_four\": \"/about-us\", \"button_url_three\": \"/about-us\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(42, 7, 'about_section', '{\"image\": \"uploads/custom-images/h5_about_img01.jpg\", \"image_two\": \"uploads/custom-images/h5_about_img02.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\", \"phone_number\": \"+985 0059 500\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(43, 7, 'faq_section', '{\"image\": \"uploads/custom-images/h5_faq_img.jpg\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(44, 7, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_kindergarten_newsletter.png\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(45, 7, 'banner_section', '{\"student_image\": \"uploads/custom-images/theme_kindergarten_student_image.png\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(46, 8, 'hero_section', '{\"banner_image\": \"uploads/custom-images/h6_hero_img.jpg\", \"hero_background\": \"uploads/custom-images/h6_hero_bg.jpg\", \"video_button_url\": \"https://www.youtube.com/watch?v=pMzGDBP6Bic\", \"action_button_url\": \"/courses\", \"enroll_students_image\": \"uploads/custom-images/theme_language_enroll_students_image.png\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(47, 8, 'about_section', '{\"image\": \"uploads/custom-images/h6_choose_img.jpg\", \"video_url\": \"https://www.youtube.com/watch?v=VkBnNxneA_A\", \"button_url\": \"/about-us\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(48, 8, 'faq_section', '{\"image\": \"uploads/custom-images/h6_faq_img01.jpg\", \"image_two\": \"uploads/custom-images/h6_faq_img02.jpg\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(49, 8, 'counter_section', '{\"image\": \"uploads/custom-images/theme_language_fact_img.png\", \"total_student_count\": 3000, \"total_instructor_count\": 100}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(50, 8, 'our_features_section', '{\"image_one\": \"uploads/custom-images/theme_language_features_icon_1.png\", \"image_two\": \"uploads/custom-images/theme_language_features_icon_2.png\", \"image_four\": \"uploads/custom-images/theme_language_features_icon_4.png\", \"image_three\": \"uploads/custom-images/theme_language_features_icon_3.png\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(51, 8, 'banner_section', '{\"student_image\": \"uploads/custom-images/theme_language_student_image.png\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01'),
(52, 8, 'newsletter_section', '{\"image\": \"uploads/custom-images/theme_language_newsletter.png\"}', 1, '2024-11-12 23:33:01', '2024-11-12 23:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `section_settings`
--

CREATE TABLE IF NOT EXISTS `section_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hero_section` tinyint(1) NOT NULL DEFAULT '0',
  `top_category_section` tinyint(1) NOT NULL DEFAULT '0',
  `brands_section` tinyint(1) NOT NULL DEFAULT '0',
  `about_section` tinyint(1) NOT NULL DEFAULT '0',
  `featured_course_section` tinyint(1) NOT NULL DEFAULT '0',
  `news_letter_section` tinyint(1) NOT NULL DEFAULT '0',
  `featured_instructor_section` tinyint(1) NOT NULL DEFAULT '0',
  `counter_section` tinyint(1) NOT NULL DEFAULT '0',
  `faq_section` tinyint(1) NOT NULL DEFAULT '0',
  `our_features_section` tinyint(1) NOT NULL DEFAULT '0',
  `testimonial_section` tinyint(1) NOT NULL DEFAULT '0',
  `banner_section` tinyint(1) NOT NULL DEFAULT '0',
  `latest_blog_section` tinyint(1) NOT NULL DEFAULT '0',
  `blog_page` tinyint(1) NOT NULL DEFAULT '0',
  `about_page` tinyint(1) NOT NULL DEFAULT '0',
  `contact_page` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_translations`
--

CREATE TABLE IF NOT EXISTS `section_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `section_translations_section_id_foreign` (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE IF NOT EXISTS `seo_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `seo_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `seo_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `page_name`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(1, 'home_page', 'Home || WebSolutionUS', 'Home || WebSolutionUS', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(2, 'about_page', 'About || WebSolutionUS', 'About || WebSolutionUS', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(3, 'course_page', 'Course || WebSolutionUS', 'Course || WebSolutionUS', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(4, 'blog_page', 'Blog || WebSolutionUS', 'Blog || WebSolutionUS', '2024-08-14 21:23:18', '2024-08-14 21:23:18'),
(5, 'contact_page', 'Contact || WebSolutionUS', 'Contact || WebSolutionUS', '2024-08-14 21:23:18', '2024-08-14 21:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'SkillGro', '2024-06-03 02:02:30', '2024-06-25 00:17:45'),
(2, 'version', '1.7.0', '2024-06-03 02:02:30', '2024-06-03 02:02:30'),
(3, 'logo', 'uploads/website-images/logo.svg', '2024-06-03 02:02:30', '2024-06-04 06:28:37'),
(4, 'timezone', 'Africa/Abidjan', '2024-06-03 02:02:30', '2024-06-25 00:17:45'),
(5, 'favicon', 'uploads/website-images/favicon.png', '2024-06-03 02:02:30', '2024-06-04 06:28:37'),
(6, 'cookie_status', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(7, 'border', 'normal', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(8, 'corners', 'thin', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(9, 'background_color', '#184dec', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(10, 'text_color', '#fafafa', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(11, 'border_color', '#0a58d6', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(12, 'btn_bg_color', '#fffceb', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(13, 'btn_text_color', '#222758', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(14, 'link_text', 'More Info', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(15, 'link', '/', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(16, 'btn_text', 'Yes', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(17, 'message', 'This website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only upon approval.', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(18, 'copyright_text', 'this is copyright text', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(19, 'recaptcha_site_key', 'recaptcha_site_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(20, 'recaptcha_secret_key', 'recaptcha_secret_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(21, 'recaptcha_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(22, 'tawk_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(23, 'tawk_chat_link', 'tawk_chat_link', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(24, 'google_tagmanager_status', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(25, 'google_tagmanager_id', 'google_tagmanager_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(26, 'pixel_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(27, 'pixel_app_id', 'pixel_app_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(28, 'facebook_login_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(29, 'facebook_app_id', 'facebook_app_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(30, 'facebook_app_secret', 'facebook_app_secret', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(31, 'facebook_redirect_url', 'facebook_redirect_url', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(32, 'google_login_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(33, 'gmail_client_id', 'gmail_client_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(34, 'gmail_secret_id', 'gmail_secret_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(35, 'gmail_redirect_url', 'gmail_redirect_url', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(36, 'default_avatar', 'uploads/website-images/default-avatar.png', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(37, 'breadcrumb_image', 'uploads/website-images/breadcrumb-image.jpg', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(38, 'mail_host', 'mail_host', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(39, 'mail_sender_email', 'sender@gmail.com', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(40, 'mail_username', 'mail_username', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(41, 'mail_password', 'mail_password', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(42, 'mail_port', 'mail_port', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(43, 'mail_encryption', 'ssl', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(44, 'mail_sender_name', 'WebSolutionUs', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(45, 'contact_message_receiver_mail', 'receiver@gmail.com', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(46, 'pusher_app_id', 'pusher_app_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(47, 'pusher_app_key', 'pusher_app_key', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(48, 'pusher_app_secret', 'pusher_app_secret', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(49, 'pusher_app_cluster', 'pusher_app_cluster', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(50, 'pusher_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(51, 'club_point_rate', '1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(52, 'club_point_status', 'active', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(53, 'maintenance_mode', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(54, 'maintenance_title', 'Website Under maintenance', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(55, 'maintenance_description', '<p>We are currently performing maintenance on our website to<br>improve your experience. Please check back later.</p>\n            <p><a title=\"Websolutions\" href=\"https://websolutionus.com/\">Websolutions</a></p>', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(56, 'last_update_date', '2024-08-15 03:23:17', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(57, 'is_queable', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(58, 'commission_rate', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(59, 'site_address', 'test address', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(60, 'site_email', 'test@gmail.com', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(61, 'site_theme', 'main', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(62, 'preloader', '/frontend/img/logo/preloader.svg', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(63, 'primary_color', '#5751e1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(64, 'secondary_color', '#ffc224', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(65, 'common_color_one', '#050071', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(66, 'common_color_two', '#282568', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(67, 'common_color_three', '#1C1A4A', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(68, 'common_color_four', '#06042E', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(69, 'common_color_five', '#4a44d1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(70, 'show_all_homepage', '0', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(71, 'google_analytic_status', 'inactive', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(72, 'google_analytic_id', 'google_analytic_id', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(73, 'preloader_status', '1', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(74, 'maintenance_image', '', '2024-08-14 21:23:17', '2024-08-14 21:23:17'),
(75, 'live_mail_send', '5', '2024-09-03 13:02:14', '2024-09-03 13:02:14'),
(80, 'wasabi_access_id', 'wasabi_access_id', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(81, 'wasabi_secret_key', 'wasabi_secret_key', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(82, 'wasabi_bucket', 'wasabi_bucket', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(83, 'wasabi_region', 'us-east-1', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(84, 'wasabi_status', 'inactive', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(85, 'aws_access_id', 'aws_access_id', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(86, 'aws_secret_key', 'aws_secret_key', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(87, 'aws_bucket', 'aws_bucket', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(88, 'aws_region', 'us-east-1', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(89, 'aws_status', 'inactive', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(90, 'header_topbar_status', 'active', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(91, 'cursor_dot_status', 'active', '2024-10-03 12:52:13', '2024-10-03 12:52:13'),
(92, 'header_social_status', 'active', '2024-10-03 12:52:13', '2024-10-03 12:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `socialite_credentials`
--

CREATE TABLE IF NOT EXISTS `socialite_credentials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `provider_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `access_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `refresh_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE IF NOT EXISTS `social_links` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `states_country_id_foreign` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_translations`
--

CREATE TABLE IF NOT EXISTS `testimonial_translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `testimonial_id` bigint UNSIGNED NOT NULL,
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonial_translations_lang_code_index` (`lang_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('instructor','student') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'student',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `is_banned` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `verification_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forget_password_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '/uploads/website-images/frontend-avatar.png',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '/uploads/website-images/frontend-cover.png',
  `wallet_balance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `short_bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` enum('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `github` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_education`
--

CREATE TABLE IF NOT EXISTS `user_education` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `organization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `degree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `current` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_experiences`
--

CREATE TABLE IF NOT EXISTS `user_experiences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `current` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_skill_topics`
--

CREATE TABLE IF NOT EXISTS `user_skill_topics` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE IF NOT EXISTS `withdraw_methods` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `min_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `max_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_requests`
--

CREATE TABLE IF NOT EXISTS `withdraw_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `current_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `withdraw_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `account_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `approved_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zoom_credentials`
--

CREATE TABLE IF NOT EXISTS `zoom_credentials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `client_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `client_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zoom_credentials_instructor_id_foreign` (`instructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_category_translations`
--
ALTER TABLE `blog_category_translations`
  ADD CONSTRAINT `blog_category_translations_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_chapters`
--
ALTER TABLE `course_chapters`
  ADD CONSTRAINT `course_chapters_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_chapter_items`
--
ALTER TABLE `course_chapter_items`
  ADD CONSTRAINT `course_chapter_items_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `course_chapters` (`id`),
  ADD CONSTRAINT `course_chapter_items_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `course_chapter_lessons`
--
ALTER TABLE `course_chapter_lessons`
  ADD CONSTRAINT `course_chapter_lessons_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `course_chapters` (`id`),
  ADD CONSTRAINT `course_chapter_lessons_chapter_item_id_foreign` FOREIGN KEY (`chapter_item_id`) REFERENCES `course_chapter_items` (`id`),
  ADD CONSTRAINT `course_chapter_lessons_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `course_live_classes`
--
ALTER TABLE `course_live_classes`
  ADD CONSTRAINT `course_live_classes_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `course_chapter_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jitsi_settings`
--
ALTER TABLE `jitsi_settings`
  ADD CONSTRAINT `jitsi_settings_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_replies`
--
ALTER TABLE `lesson_replies`
  ADD CONSTRAINT `lesson_replies_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `lesson_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_item_translations`
--
ALTER TABLE `menu_item_translations`
  ADD CONSTRAINT `menu_item_translations_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_translations`
--
ALTER TABLE `menu_translations`
  ADD CONSTRAINT `menu_translations_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `zoom_credentials`
--
ALTER TABLE `zoom_credentials`
  ADD CONSTRAINT `zoom_credentials_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
