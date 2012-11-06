CREATE DATABASE  IF NOT EXISTS `pcp2012` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pcp2012`;
-- MySQL dump 10.13  Distrib 5.5.16, for osx10.5 (i386)
--
-- Host: 49.212.201.99    Database: pcp2012
-- ------------------------------------------------------
-- Server version	5.1.61

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
-- Table structure for table `m_parent`
--

DROP TABLE IF EXISTS `m_parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_parent` (
  `parent_seq` int(11) NOT NULL AUTO_INCREMENT,
  `parent_user_seq` int(11) NOT NULL,
  `child_user_seq` int(11) NOT NULL,
  PRIMARY KEY (`parent_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_parent`
--

LOCK TABLES `m_parent` WRITE;
/*!40000 ALTER TABLE `m_parent` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_student`
--

DROP TABLE IF EXISTS `m_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_student` (
  `student_seq` int(11) NOT NULL AUTO_INCREMENT,
  `user_seq` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  PRIMARY KEY (`student_seq`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_student`
--

LOCK TABLES `m_student` WRITE;
/*!40000 ALTER TABLE `m_student` DISABLE KEYS */;
INSERT INTO `m_student` VALUES (1,1,'1145081');
/*!40000 ALTER TABLE `m_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_access_autho`
--

DROP TABLE IF EXISTS `m_access_autho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_access_autho` (
  `access_autho_seq` int(11) NOT NULL AUTO_INCREMENT,
  `autho_seq` int(11) DEFAULT NULL,
  `page_seq` int(11) DEFAULT NULL,
  `read_flg` int(11) DEFAULT NULL,
  `write_flg` int(11) DEFAULT NULL,
  `delete_flg` int(11) DEFAULT NULL,
  `update_flg` int(11) DEFAULT NULL,
  `delivery_flg` int(11) DEFAULT NULL,
  PRIMARY KEY (`access_autho_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_access_autho`
--

LOCK TABLES `m_access_autho` WRITE;
/*!40000 ALTER TABLE `m_access_autho` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_access_autho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `question_seq` int(11) NOT NULL AUTO_INCREMENT,
  `question_title` varchar(255) NOT NULL,
  `question_target_group_seq` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `question_description` varchar(255) NOT NULL,
  PRIMARY KEY (`question_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_details`
--

DROP TABLE IF EXISTS `question_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_details` (
  `question_details_seq` int(11) NOT NULL AUTO_INCREMENT,
  `quesion_details_title` varchar(255) DEFAULT NULL,
  `quesion_details_description` varchar(255) DEFAULT NULL,
  `quesion_division` int(11) NOT NULL,
  `question_seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`question_details_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_details`
--

LOCK TABLES `question_details` WRITE;
/*!40000 ALTER TABLE `question_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_awnser`
--

DROP TABLE IF EXISTS `question_awnser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_awnser` (
  `question_awnser_seq` int(11) NOT NULL AUTO_INCREMENT,
  `awnser_user_seq` int(11) NOT NULL,
  `question_awnser_list_seq` int(11) NOT NULL,
  `question_details_seq` int(11) NOT NULL,
  `question_seq` int(11) NOT NULL,
  PRIMARY KEY (`question_awnser_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_awnser`
--

LOCK TABLES `question_awnser` WRITE;
/*!40000 ALTER TABLE `question_awnser` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_awnser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_awnser_list`
--

DROP TABLE IF EXISTS `question_awnser_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_awnser_list` (
  `question_awnser_list_seq` int(11) NOT NULL AUTO_INCREMENT,
  `awnser_name` varchar(255) DEFAULT NULL,
  `question_details_seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`question_awnser_list_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_awnser_list`
--

LOCK TABLES `question_awnser_list` WRITE;
/*!40000 ALTER TABLE `question_awnser_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_awnser_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_user`
--

DROP TABLE IF EXISTS `m_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_user` (
  `user_seq` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) DEFAULT NULL,
  `user_kana` varchar(45) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_tel` varchar(45) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  `autho_seq` int(11) DEFAULT '0',
  `delete_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`user_seq`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_user`
--

LOCK TABLES `m_user` WRITE;
/*!40000 ALTER TABLE `m_user` DISABLE KEYS */;
INSERT INTO `m_user` VALUES (1,'植木正太','うえきしょうた','福岡県糟屋郡宇美町','08039013290','spider.d.o.d@gmail.com','ueki','ueki',0,0);
/*!40000 ALTER TABLE `m_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactbook`
--

DROP TABLE IF EXISTS `contactbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactbook` (
  `contactbook_seq` int(11) NOT NULL,
  `title` text,
  `contents` text,
  `send_date` datetime DEFAULT NULL,
  `send_user_seq` int(11) DEFAULT NULL,
  `reception_user_seq` int(11) DEFAULT NULL,
  `link_contactbook_seq` int(11) DEFAULT NULL,
  `new_flg` int(11) DEFAULT '1' COMMENT '				\n			',
  `send_flg` int(11) DEFAULT '1',
  PRIMARY KEY (`contactbook_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactbook`
--

LOCK TABLES `contactbook` WRITE;
/*!40000 ALTER TABLE `contactbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_group`
--

DROP TABLE IF EXISTS `m_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_group` (
  `group_seq` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) DEFAULT NULL,
  `delete_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`group_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_group`
--

LOCK TABLES `m_group` WRITE;
/*!40000 ALTER TABLE `m_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_page`
--

DROP TABLE IF EXISTS `m_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_page` (
  `page_seq` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) DEFAULT NULL,
  `delete_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`page_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_page`
--

LOCK TABLES `m_page` WRITE;
/*!40000 ALTER TABLE `m_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_print_delivery`
--

DROP TABLE IF EXISTS `m_print_delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_print_delivery` (
  `print_delivery_seq` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_date` datetime DEFAULT NULL,
  `delivery_user_seq` int(11) DEFAULT NULL COMMENT '	',
  `target_group_seq` int(11) DEFAULT NULL,
  `print_flg` int(11) DEFAULT '1',
  `print_send_flg` int(11) DEFAULT '1',
  `printurl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`print_delivery_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_print_delivery`
--

LOCK TABLES `m_print_delivery` WRITE;
/*!40000 ALTER TABLE `m_print_delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_print_delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_details`
--

DROP TABLE IF EXISTS `group_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_details` (
  `group_details_seq` int(11) NOT NULL AUTO_INCREMENT,
  `group_seq` int(11) NOT NULL,
  `user_seq` int(11) NOT NULL,
  PRIMARY KEY (`group_details_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_details`
--

LOCK TABLES `group_details` WRITE;
/*!40000 ALTER TABLE `group_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_awnser_coments`
--

DROP TABLE IF EXISTS `question_awnser_coments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_awnser_coments` (
  `question_awnser_coments_seq` int(11) NOT NULL AUTO_INCREMENT,
  `coments` text,
  `question_awnser_user_seq` int(11) DEFAULT NULL,
  `question_details_seq` int(11) DEFAULT NULL,
  `quesion_seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`question_awnser_coments_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_awnser_coments`
--

LOCK TABLES `question_awnser_coments` WRITE;
/*!40000 ALTER TABLE `question_awnser_coments` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_awnser_coments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_autho`
--

DROP TABLE IF EXISTS `m_autho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_autho` (
  `autho_seq` int(11) NOT NULL AUTO_INCREMENT,
  `autho_name` varchar(255) DEFAULT NULL,
  `delete_flg` int(11) DEFAULT '0',
  PRIMARY KEY (`autho_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_autho`
--

LOCK TABLES `m_autho` WRITE;
/*!40000 ALTER TABLE `m_autho` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_autho` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-31  0:47:11
