-- Migration: Fix indexed_date_time type to prevent false-positive sync updates
-- Issue: MySQL DATETIME reformats ISO strings (e.g., 2022-04-05T03:39:26Z → 2022-04-05 03:39:26),
-- causing the sync preview to always detect a change after insert.
-- Fix: Change column to VARCHAR(50) so the exact string from the backend is preserved.

USE `kp_penelitian_dosen`;

ALTER TABLE `articles` MODIFY COLUMN `indexed_date_time` VARCHAR(50);
