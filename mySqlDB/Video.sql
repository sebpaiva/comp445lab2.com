-- 
-- DATABASE CREATION
--

CREATE DATABASE IF NOT EXISTS comp445;
USE comp445;

--
-- TABLE CREATION
--

-- Drop tables
DROP TABLE IF EXISTS `Segments`;
DROP TABLE IF EXISTS `Videos`;

-- Create tables
CREATE TABLE `Videos` (
  `id` Number AUTO_INCREMENT,
  `date` Date DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `Segments` (
  `id` Number AUTO_INCREMENT,
  `video_id` Number NOT NULL,
  `size` Number NOT NULL,
  `data` LONGBLOB NOT NULL,
  PRIMARY KEY (id)
  CONSTRAINT `videoFK` FOREIGN KEY (`video_id`) REFERENCES `Videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
);

-- 
-- DATA INSERTS
--
INSERT INTO `Videos` VALUES 
(2,11),
(3,11);

INSERT INTO `Segments` VALUES 
(2,11),
(3,11);
