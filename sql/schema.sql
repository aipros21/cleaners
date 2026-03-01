-- FindMyCleaner Database Schema
-- Run this on the cleaners247 database

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ==========================================
-- USERS (all user types)
-- ==========================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('customer','cleaner','admin') NOT NULL DEFAULT 'customer',
    `first_name` VARCHAR(100) NOT NULL DEFAULT '',
    `last_name` VARCHAR(100) NOT NULL DEFAULT '',
    `phone` VARCHAR(20) NOT NULL DEFAULT '',
    `avatar` VARCHAR(500) DEFAULT NULL,
    `email_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `email_token` VARCHAR(100) DEFAULT NULL,
    `reset_token` VARCHAR(100) DEFAULT NULL,
    `reset_expires` DATETIME DEFAULT NULL,
    `status` ENUM('active','suspended','deleted') NOT NULL DEFAULT 'active',
    `last_login` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_role` (`role`),
    INDEX `idx_status` (`status`),
    INDEX `idx_email_token` (`email_token`),
    INDEX `idx_reset_token` (`reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CATEGORIES
-- ==========================================
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `icon` VARCHAR(100) DEFAULT NULL,
    `image` VARCHAR(500) DEFAULT NULL,
    `meta_title` VARCHAR(200) DEFAULT NULL,
    `meta_description` VARCHAR(300) DEFAULT NULL,
    `lead_price` DECIMAL(8,2) NOT NULL DEFAULT 25.00,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_slug` (`slug`),
    INDEX `idx_active_sort` (`is_active`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- STATES
-- ==========================================
CREATE TABLE IF NOT EXISTS `states` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `code` CHAR(2) NOT NULL UNIQUE,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `lat` DECIMAL(10,7) DEFAULT NULL,
    `lng` DECIMAL(10,7) DEFAULT NULL,
    INDEX `idx_code` (`code`),
    INDEX `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CITIES
-- ==========================================
CREATE TABLE IF NOT EXISTS `cities` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `state_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `lat` DECIMAL(10,7) DEFAULT NULL,
    `lng` DECIMAL(10,7) DEFAULT NULL,
    `population` INT UNSIGNED DEFAULT NULL,
    INDEX `idx_state` (`state_id`),
    INDEX `idx_slug` (`slug`),
    UNIQUE KEY `uk_state_slug` (`state_id`, `slug`),
    CONSTRAINT `fk_cities_state` FOREIGN KEY (`state_id`) REFERENCES `states`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CLEANERS
-- ==========================================
CREATE TABLE IF NOT EXISTS `cleaners` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL UNIQUE,
    `business_name` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(200) NOT NULL UNIQUE,
    `tagline` VARCHAR(300) DEFAULT NULL,
    `description` TEXT,
    `logo` VARCHAR(500) DEFAULT NULL,
    `cover_image` VARCHAR(500) DEFAULT NULL,
    `phone` VARCHAR(20) NOT NULL DEFAULT '',
    `email` VARCHAR(255) NOT NULL DEFAULT '',
    `website` VARCHAR(300) DEFAULT NULL,
    `address` VARCHAR(300) DEFAULT NULL,
    `city_id` INT UNSIGNED DEFAULT NULL,
    `state_id` INT UNSIGNED DEFAULT NULL,
    `zip_code` VARCHAR(10) DEFAULT NULL,
    `lat` DECIMAL(10,7) DEFAULT NULL,
    `lng` DECIMAL(10,7) DEFAULT NULL,
    `license_number` VARCHAR(100) DEFAULT NULL,
    `license_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `is_insured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `years_experience` INT UNSIGNED DEFAULT NULL,
    `employees_count` VARCHAR(20) DEFAULT NULL,
    `plan` ENUM('free','basic','pro','premium') NOT NULL DEFAULT 'free',
    `plan_expires` DATETIME DEFAULT NULL,
    `stripe_customer_id` VARCHAR(100) DEFAULT NULL,
    `stripe_subscription_id` VARCHAR(100) DEFAULT NULL,
    `profile_views` INT UNSIGNED NOT NULL DEFAULT 0,
    `leads_received` INT UNSIGNED NOT NULL DEFAULT 0,
    `avg_rating` DECIMAL(3,2) NOT NULL DEFAULT 0.00,
    `review_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `status` ENUM('active','pending','suspended') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_user` (`user_id`),
    INDEX `idx_slug` (`slug`),
    INDEX `idx_state` (`state_id`),
    INDEX `idx_city` (`city_id`),
    INDEX `idx_plan` (`plan`),
    INDEX `idx_status` (`status`),
    INDEX `idx_featured` (`is_featured`),
    INDEX `idx_rating` (`avg_rating` DESC),
    FULLTEXT INDEX `ft_search` (`business_name`, `description`, `tagline`),
    CONSTRAINT `fk_cleaners_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_cleaners_city` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_cleaners_state` FOREIGN KEY (`state_id`) REFERENCES `states`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CLEANER_CATEGORIES (many-to-many)
-- ==========================================
CREATE TABLE IF NOT EXISTS `cleaner_categories` (
    `cleaner_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`cleaner_id`, `category_id`),
    INDEX `idx_category_id` (`category_id`),
    CONSTRAINT `fk_cc_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_cc_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CLEANER_PHOTOS
-- ==========================================
CREATE TABLE IF NOT EXISTS `cleaner_photos` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `url` VARCHAR(500) NOT NULL,
    `thumbnail` VARCHAR(500) DEFAULT NULL,
    `caption` VARCHAR(300) DEFAULT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cleaner` (`cleaner_id`),
    CONSTRAINT `fk_photos_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CLEANER_SPECIALTIES
-- ==========================================
CREATE TABLE IF NOT EXISTS `cleaner_specialties` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    INDEX `idx_cleaner` (`cleaner_id`),
    CONSTRAINT `fk_specialties_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CLEANER_DISCOUNTS
-- ==========================================
CREATE TABLE IF NOT EXISTS `cleaner_discounts` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT,
    `discount_percent` DECIMAL(5,2) DEFAULT NULL,
    `valid_from` DATE DEFAULT NULL,
    `valid_until` DATE DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cleaner` (`cleaner_id`),
    CONSTRAINT `fk_discounts_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- CLEANER_SERVICE_AREAS
-- ==========================================
CREATE TABLE IF NOT EXISTS `cleaner_service_areas` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `city_id` INT UNSIGNED DEFAULT NULL,
    `state_id` INT UNSIGNED DEFAULT NULL,
    `radius_miles` INT UNSIGNED DEFAULT 25,
    INDEX `idx_cleaner` (`cleaner_id`),
    CONSTRAINT `fk_sa_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- LEADS
-- ==========================================
CREATE TABLE IF NOT EXISTS `leads` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT UNSIGNED DEFAULT NULL,
    `customer_name` VARCHAR(200) NOT NULL,
    `customer_email` VARCHAR(255) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL DEFAULT '',
    `city_id` INT UNSIGNED DEFAULT NULL,
    `state_id` INT UNSIGNED DEFAULT NULL,
    `zip_code` VARCHAR(10) DEFAULT NULL,
    `project_description` TEXT,
    `budget_range` VARCHAR(50) DEFAULT NULL,
    `urgency` ENUM('asap','within_week','within_month','flexible') DEFAULT 'flexible',
    `property_type` VARCHAR(50) DEFAULT NULL,
    `status` ENUM('new','assigned','contacted','completed','cancelled') NOT NULL DEFAULT 'new',
    `source` VARCHAR(50) DEFAULT 'website',
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category_id`),
    INDEX `idx_status` (`status`),
    INDEX `idx_state` (`state_id`),
    INDEX `idx_created` (`created_at`),
    CONSTRAINT `fk_leads_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_leads_city` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_leads_state` FOREIGN KEY (`state_id`) REFERENCES `states`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- LEAD_ASSIGNMENTS
-- ==========================================
CREATE TABLE IF NOT EXISTS `lead_assignments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `lead_id` INT UNSIGNED NOT NULL,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `price` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    `status` ENUM('sent','viewed','accepted','contacted','completed','declined') NOT NULL DEFAULT 'sent',
    `notes` TEXT,
    `assigned_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_lead` (`lead_id`),
    INDEX `idx_cleaner` (`cleaner_id`),
    UNIQUE KEY `uk_lead_cleaner` (`lead_id`, `cleaner_id`),
    CONSTRAINT `fk_la_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_la_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- REVIEWS
-- ==========================================
CREATE TABLE IF NOT EXISTS `reviews` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED DEFAULT NULL,
    `author_name` VARCHAR(100) NOT NULL,
    `author_email` VARCHAR(255) DEFAULT NULL,
    `rating` TINYINT UNSIGNED NOT NULL,
    `title` VARCHAR(200) DEFAULT NULL,
    `content` TEXT,
    `response` TEXT,
    `response_date` DATETIME DEFAULT NULL,
    `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cleaner` (`cleaner_id`),
    INDEX `idx_cleaner_status` (`cleaner_id`, `status`),
    INDEX `idx_status` (`status`),
    INDEX `idx_rating` (`rating`),
    CONSTRAINT `fk_reviews_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- BANNERS
-- ==========================================
CREATE TABLE IF NOT EXISTS `banners` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL,
    `image` VARCHAR(500) NOT NULL,
    `url` VARCHAR(500) DEFAULT NULL,
    `position` ENUM('header','sidebar','between_listings','footer') NOT NULL DEFAULT 'sidebar',
    `page_target` VARCHAR(100) DEFAULT NULL,
    `category_id` INT UNSIGNED DEFAULT NULL,
    `impressions` INT UNSIGNED NOT NULL DEFAULT 0,
    `clicks` INT UNSIGNED NOT NULL DEFAULT 0,
    `start_date` DATE DEFAULT NULL,
    `end_date` DATE DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_position` (`position`),
    INDEX `idx_active` (`is_active`),
    CONSTRAINT `fk_banners_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- SPONSORED_LISTINGS
-- ==========================================
CREATE TABLE IF NOT EXISTS `sponsored_listings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cleaner_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED DEFAULT NULL,
    `state_id` INT UNSIGNED DEFAULT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `price_paid` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    `impressions` INT UNSIGNED NOT NULL DEFAULT 0,
    `clicks` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cleaner` (`cleaner_id`),
    INDEX `idx_category` (`category_id`),
    INDEX `idx_active_dates` (`is_active`, `start_date`, `end_date`),
    CONSTRAINT `fk_sl_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sl_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_sl_state` FOREIGN KEY (`state_id`) REFERENCES `states`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- PAGES (blog posts + static pages)
-- ==========================================
CREATE TABLE IF NOT EXISTS `pages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(300) NOT NULL,
    `slug` VARCHAR(300) NOT NULL UNIQUE,
    `content` LONGTEXT,
    `excerpt` TEXT,
    `image` VARCHAR(500) DEFAULT NULL,
    `type` ENUM('blog','page') NOT NULL DEFAULT 'blog',
    `category_id` INT UNSIGNED DEFAULT NULL,
    `author_id` INT UNSIGNED DEFAULT NULL,
    `meta_title` VARCHAR(200) DEFAULT NULL,
    `meta_description` VARCHAR(300) DEFAULT NULL,
    `status` ENUM('published','draft') NOT NULL DEFAULT 'draft',
    `views` INT UNSIGNED NOT NULL DEFAULT 0,
    `published_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_slug` (`slug`),
    INDEX `idx_type_status` (`type`, `status`),
    INDEX `idx_published` (`published_at`),
    FULLTEXT INDEX `ft_search` (`title`, `content`),
    CONSTRAINT `fk_pages_author` FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- PAYMENTS
-- ==========================================
CREATE TABLE IF NOT EXISTS `payments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED DEFAULT NULL,
    `cleaner_id` INT UNSIGNED DEFAULT NULL,
    `type` ENUM('subscription','lead','sponsored','banner') NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `currency` CHAR(3) NOT NULL DEFAULT 'USD',
    `stripe_payment_id` VARCHAR(100) DEFAULT NULL,
    `stripe_invoice_id` VARCHAR(100) DEFAULT NULL,
    `description` VARCHAR(300) DEFAULT NULL,
    `status` ENUM('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user` (`user_id`),
    INDEX `idx_cleaner` (`cleaner_id`),
    INDEX `idx_type` (`type`),
    INDEX `idx_status` (`status`),
    INDEX `idx_created` (`created_at`),
    CONSTRAINT `fk_payments_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_payments_cleaner` FOREIGN KEY (`cleaner_id`) REFERENCES `cleaners`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- EMAIL_QUEUE
-- ==========================================
CREATE TABLE IF NOT EXISTS `email_queue` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `to_email` VARCHAR(255) NOT NULL,
    `to_name` VARCHAR(200) DEFAULT NULL,
    `subject` VARCHAR(300) NOT NULL,
    `body` LONGTEXT NOT NULL,
    `status` ENUM('queued','sent','failed') NOT NULL DEFAULT 'queued',
    `attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `error` TEXT DEFAULT NULL,
    `sent_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- ACTIVITY_LOG
-- ==========================================
CREATE TABLE IF NOT EXISTS `activity_log` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED DEFAULT NULL,
    `action` VARCHAR(100) NOT NULL,
    `entity_type` VARCHAR(50) DEFAULT NULL,
    `entity_id` INT UNSIGNED DEFAULT NULL,
    `details` TEXT,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user` (`user_id`),
    INDEX `idx_action` (`action`),
    INDEX `idx_entity` (`entity_type`, `entity_id`),
    INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- SETTINGS
-- ==========================================
CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT,
    `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_key` (`setting_key`),
    INDEX `idx_group` (`setting_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
