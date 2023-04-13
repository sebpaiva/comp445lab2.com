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
  `id` int AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `Segments` (
  `id` int AUTO_INCREMENT,
  `video_id` int NOT NULL,
  `sequenceNumber` int NOT NULL,
  `seg_data` LONGBLOB NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT `videoFK` FOREIGN KEY (`video_id`) REFERENCES `Videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- DATA INSERTS
--
INSERT INTO `Videos` (id, name) VALUES
(1, 'sample1.mp4'),
(2, 'sample2.mp4'),
(3, 'sample3.mp4'),
(4, 'sample4.mp4'),
(5, 'sample5.mp4');

# INSERT INTO `Segments` VALUES
# TODO
