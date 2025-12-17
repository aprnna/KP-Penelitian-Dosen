-- Database schema for KP-Penelitian-Dosen

CREATE DATABASE IF NOT EXISTS `kp-penelitian-dosen` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `kp-penelitian-dosen`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `sso_provider` varchar(50) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `picture` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`),
  KEY `idx_google_id` (`google_id`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
