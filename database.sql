-- Database Schema for The Rise Project

CREATE DATABASE IF NOT EXISTS `fullstack_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `fullstack_project`;

-- Table for enquiries and site visits
CREATE TABLE IF NOT EXISTS `enquiries` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `country_code` VARCHAR(10) DEFAULT '+91',
    `phone` VARCHAR(20) NOT NULL,
    `bhk_preference` VARCHAR(50) DEFAULT '2BHK',
    `site_visit_date` DATE DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for brochure requests
CREATE TABLE IF NOT EXISTS `brochure_requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `country_code` VARCHAR(10) DEFAULT '+91',
    `phone` VARCHAR(20) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for admin users
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin user (admin / admin123)
INSERT INTO `admin_users` (`username`, `password`, `email`)
VALUES ('admin', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1fWbHhH4d9/bX5mG9v8E5eM9A.GzLSm', 'admin@therise.com')
ON DUPLICATE KEY UPDATE `id`=`id`;
