-- Database schema for KP-Penelitian-Dosen

CREATE DATABASE IF NOT EXISTS `kp-penelitian-db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `kp-penelitian-db`;

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

-- Table: scraping_jobs
-- Stores metadata for all scraping jobs
CREATE TABLE IF NOT EXISTS scraping_jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id VARCHAR(36) UNIQUE NOT NULL,
    status ENUM('pending', 'running', 'finished', 'failed') NOT NULL DEFAULT 'pending',
    total_records INT DEFAULT 0,
    processed_records INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    started_at DATETIME NULL,
    finished_at DATETIME NULL,
    error_message TEXT NULL,
    parameters JSON NULL,
    
    INDEX idx_job_id (job_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: scraping_logs
-- Stores detailed log entries for each scraping job
CREATE TABLE IF NOT EXISTS scraping_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    level ENUM('DEBUG', 'INFO', 'WARNING', 'ERROR') DEFAULT 'INFO',
    message TEXT NOT NULL,
    extra_data JSON NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (job_id) REFERENCES scraping_jobs(id) ON DELETE CASCADE,
    INDEX idx_job_level (job_id, level),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
