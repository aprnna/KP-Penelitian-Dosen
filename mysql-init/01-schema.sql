-- Frontend Database Schema
-- Database: kp_penelitian_db (Display Database)

CREATE DATABASE IF NOT EXISTS `kp_penelitian_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `kp_penelitian_db`;

-- Table: users
-- Stores user accounts (local password or Google OAuth)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) DEFAULT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `sso_provider` VARCHAR(50) DEFAULT NULL,
    `google_id` VARCHAR(255) DEFAULT NULL,
    `picture` VARCHAR(500) DEFAULT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `last_login` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY `idx_username` (`username`),
    UNIQUE KEY `idx_email` (`email`),
    INDEX `idx_google_id` (`google_id`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: authors
-- Stores author data synced from backend
CREATE TABLE IF NOT EXISTS `authors` (
    `id_sinta` INT PRIMARY KEY,
    `fullname` TEXT,
    `nidn` VARCHAR(20),
    `degree` VARCHAR(10),
    `major` TEXT,
    `faculty` TEXT,
    `sinta_score_overall` INT,
    `sinta_score_3yr` INT,
    `affil_score` INT,
    `affil_score_3yr` INT,
    `subject_research` TEXT,
    `s_article_scopus` INT,
    `s_citation_scopus` INT,
    `s_cited_document_scopus` INT,
    `s_hindex_scopus` INT,
    `s_i10_index_scopus` INT,
    `s_gindex_scopus` INT,
    `s_article_gscholar` INT,
    `s_citation_gscholar` INT,
    `s_cited_document_gscholar` INT,
    `s_hindex_gscholar` INT,
    `s_i10_index_gscholar` INT,
    `s_gindex_gscholar` INT,

    INDEX `idx_faculty` (`faculty`(100)),
    INDEX `idx_sinta_score` (`sinta_score_overall`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: articles
-- Stores article data synced from backend
CREATE TABLE IF NOT EXISTS `articles` (
    `id_article` INT PRIMARY KEY,
    `id_sinta` INT,
    `doi` VARCHAR(255),
    `title` TEXT,
    `authors` TEXT,
    `journal_title` VARCHAR(255),
    `short_journal_title` VARCHAR(255),
    `publisher` TEXT,
    `issue` VARCHAR(50),
    `volume` VARCHAR(50),
    `page` VARCHAR(50),
    `published` VARCHAR(20),
    `type` VARCHAR(50),
    `pdf_link` TEXT,
    `issn` VARCHAR(20),
    `issn_type` VARCHAR(20),
    `indexed_date_time` DATETIME,
    `indexed_date_parts` VARCHAR(50),
    `url` TEXT,

    INDEX `idx_id_sinta` (`id_sinta`),
    INDEX `idx_published` (`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: author_article (junction table)
CREATE TABLE IF NOT EXISTS `author_article` (
    `id_sinta` INT NOT NULL,
    `id_article` INT NOT NULL,
    PRIMARY KEY (`id_sinta`, `id_article`),
    FOREIGN KEY (`id_sinta`) REFERENCES `authors`(`id_sinta`),
    FOREIGN KEY (`id_article`) REFERENCES `articles`(`id_article`),

    INDEX `idx_author_article_sinta` (`id_sinta`),
    INDEX `idx_author_article_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
