-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: ccgweb
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bows_span`
--

DROP TABLE IF EXISTS `bows_span`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bows_span` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `time` datetime NOT NULL,
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `offset_from` int(11) NOT NULL,
  `offset_to` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  KEY `sentence` (`lang`,`sentence_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1212 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bows_super`
--

DROP TABLE IF EXISTS `bows_super`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bows_super` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `time` datetime NOT NULL,
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `offset_from` int(11) NOT NULL,
  `offset_to` int(11) NOT NULL,
  `tag` varchar(1024) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  KEY `sentence` (`lang`,`sentence_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6939 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bows_tok`
--

DROP TABLE IF EXISTS `bows_tok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bows_tok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `time` datetime NOT NULL,
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `offset` int(11) NOT NULL,
  `tag` enum('O','I','T','S') COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  KEY `sentence` (`lang`,`sentence_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` varchar(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `user_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `time` datetime NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`lang`,`sentence_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `correct`
--

DROP TABLE IF EXISTS `correct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `correct` (
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` varchar(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `user_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `time` datetime NOT NULL,
  `derxml` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parse` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`lang`,`sentence_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sentence_links`
--

DROP TABLE IF EXISTS `sentence_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sentence_links` (
  `lang1` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `id1` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `lang2` char(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `id2` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  UNIQUE KEY `lang1` (`lang1`,`id1`,`lang2`,`id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sentence_pmbids`
--

DROP TABLE IF EXISTS `sentence_pmbids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sentence_pmbids` (
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `pmb_part` char(2) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `pmb_doc_id` char(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  PRIMARY KEY (`lang`,`sentence_id`,`pmb_part`,`pmb_doc_id`),
  KEY `lang` (`lang`),
  KEY `doc` (`pmb_part`,`pmb_doc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sentences`
--

DROP TABLE IF EXISTS `sentences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sentences` (
  `lang` varchar(4) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence_id` char(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `sentence` text COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'Should contain one trailing LF character. Should not contain any other line breaks or traling whitespace.',
  `assigned` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `lang` (`lang`,`sentence_id`),
  KEY `assigned` (`assigned`),
  FULLTEXT KEY `sentence` (`sentence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password_hash` mediumblob NOT NULL,
  `session_id` varchar(32) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `session_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-25  9:35:36
