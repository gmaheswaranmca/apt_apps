-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.8-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema aptjob
--

CREATE DATABASE IF NOT EXISTS aptjob;
USE aptjob;

--
-- Definition of table `apt_job_base`
--

DROP TABLE IF EXISTS `apt_job_base`;
CREATE TABLE `apt_job_base` (
  `job_dbid` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_dbid` bigint(20) DEFAULT NULL,
  `job_id` varchar(50) NOT NULL DEFAULT '',
  `version_no` int(11) DEFAULT NULL,
  `job_type` int(11) DEFAULT NULL,
  `job_src_text` varchar(1000) DEFAULT NULL,
  `job_py_text` varchar(1000) DEFAULT NULL,
  `job_date` datetime DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `test_link_name` varchar(100) DEFAULT NULL,
  `is_job_done` tinyint(1) DEFAULT '0',
  `job_done_date` datetime DEFAULT NULL,
  `job_cost` double DEFAULT '0',
  PRIMARY KEY (`job_dbid`),
  UNIQUE KEY `job_id` (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apt_job_base`
--

/*!40000 ALTER TABLE `apt_job_base` DISABLE KEYS */;
INSERT INTO `apt_job_base` (`job_dbid`,`schedule_dbid`,`job_id`,`version_no`,`job_type`,`job_src_text`,`job_py_text`,`job_date`,`added_date`,`test_link_name`,`is_job_done`,`job_done_date`,`job_cost`) VALUES 
 (1,1,'A210820FrA-01',2,2,'First Job-2','First Job-2','2021-08-20 00:00:00','2021-08-20 15:35:47','apple',0,NULL,150),
 (2,1,'A210820FrA-02',1,1,'two','two','2021-08-20 00:00:00','2021-08-20 18:22:18','apple',0,NULL,125);
/*!40000 ALTER TABLE `apt_job_base` ENABLE KEYS */;


--
-- Definition of table `apt_job_base_version`
--

DROP TABLE IF EXISTS `apt_job_base_version`;
CREATE TABLE `apt_job_base_version` (
  `job_dbid` bigint(20) NOT NULL DEFAULT '0',
  `schedule_dbid` bigint(20) DEFAULT NULL,
  `job_id` varchar(50) DEFAULT NULL,
  `version_no` int(11) NOT NULL DEFAULT '0',
  `job_type` int(11) DEFAULT NULL,
  `job_src_text` varchar(1000) DEFAULT NULL,
  `job_py_text` varchar(1000) DEFAULT NULL,
  `job_date` datetime DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `test_link_name` varchar(100) DEFAULT NULL,
  `is_job_done` tinyint(1) DEFAULT NULL,
  `job_done_date` datetime DEFAULT NULL,
  `job_cost` double DEFAULT '0',
  PRIMARY KEY (`job_dbid`,`version_no`),
  UNIQUE KEY `job_id` (`job_id`,`version_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apt_job_base_version`
--

/*!40000 ALTER TABLE `apt_job_base_version` DISABLE KEYS */;
INSERT INTO `apt_job_base_version` (`job_dbid`,`schedule_dbid`,`job_id`,`version_no`,`job_type`,`job_src_text`,`job_py_text`,`job_date`,`added_date`,`test_link_name`,`is_job_done`,`job_done_date`,`job_cost`) VALUES 
 (1,1,'A210820FrA-01',1,1,'First Job-1','First Job-1','2021-08-20 00:00:00','2021-08-20 15:35:02','apple',0,NULL,125),
 (1,1,'A210820FrA-01',2,2,'First Job-2','First Job-2','2021-08-20 00:00:00','2021-08-20 15:35:47','apple',0,NULL,150),
 (2,1,'A210820FrA-02',1,1,'two','two','2021-08-20 00:00:00','2021-08-20 18:22:18','apple',0,NULL,125);
/*!40000 ALTER TABLE `apt_job_base_version` ENABLE KEYS */;


--
-- Definition of table `apt_job_config`
--

DROP TABLE IF EXISTS `apt_job_config`;
CREATE TABLE `apt_job_config` (
  `config_dbid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_master_path` varchar(1000) NOT NULL,
  `live_status` varchar(8000) NOT NULL DEFAULT 'NA',
  PRIMARY KEY (`config_dbid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apt_job_config`
--

/*!40000 ALTER TABLE `apt_job_config` DISABLE KEYS */;
INSERT INTO `apt_job_config` (`config_dbid`,`job_master_path`,`live_status`) VALUES 
 (1,'/var/www/html/jobfile/apt_job_master.json','{\"server\":\"local\",\"apps\":[{\"linkCodeName\":\"one\",\"linkName\":\"Apple\",\"appName\":\"Green\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":70,\"testLiveCount\":1,\"statusTime\":\"2024-02-01T18:30:50.312Z\",\"activityStatus\":\"DOWNLOADABLE\",\"activityTime\":\"2024-02-01T18:30:55.493Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2024-01-28T14:18:41.491Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2024-02-01T18:30:50.314Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2024-01-28T14:18:41.491Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2024-02-01T18:30:47.120Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2024-02-01T18:30:55.493Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2024-01-28T14:18:41.491Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2024-01-28T14:18:41.491Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2024-01-28T14:18:41.491Z\"}]}},{\"linkCodeName\":\"two\",\"linkName\":\"Technique\",\"appName\":\"Everest\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":47,\"testLiveCount\":0,\"statusTime\":\"2024-01-17T20:30:29.262Z\",\"activityStatus\":\"DOWNLOADABLE\",\"activityTime\":\"2024-01-09T01:41:11.273Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2024-01-06T04:54:22.841Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2024-01-06T04:54:59.203Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2024-01-06T04:49:42.824Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2024-01-09T01:40:45.517Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2024-01-09T01:41:11.273Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2024-01-06T04:49:42.824Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2024-01-06T04:49:42.824Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2024-01-06T04:49:42.824Z\"}]}},{\"linkCodeName\":\"three\",\"linkName\":\"Speed\",\"appName\":\"Princess\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":255,\"testLiveCount\":0,\"statusTime\":\"2023-11-29T13:32:42.326Z\",\"activityStatus\":\"PULLRESULT\",\"activityTime\":\"2023-08-21T04:38:06.002Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2023-08-17T07:57:17.614Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2023-08-17T08:01:36.786Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2022-11-14T16:08:12.108Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2023-08-18T06:43:43.031Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2023-08-18T06:44:07.471Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2022-11-14T16:08:12.108Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2022-11-14T16:08:12.108Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2023-08-21T04:38:06.002Z\"}]}},{\"linkCodeName\":\"four\",\"linkName\":\"Rainbow\",\"appName\":\"Himalaya\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":27,\"testLiveCount\":5,\"statusTime\":\"2024-01-29T16:44:37.637Z\",\"activityStatus\":\"DOWNLOADABLE\",\"activityTime\":\"2024-01-29T16:44:46.802Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2024-01-27T05:12:02.991Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2024-01-27T05:12:10.646Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2023-12-07T05:41:27.293Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2024-01-29T16:44:37.639Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2024-01-29T16:44:46.802Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2023-10-27T17:16:53.510Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2023-10-27T17:16:53.510Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2024-01-08T00:21:19.931Z\"}]}},{\"linkCodeName\":\"five\",\"linkName\":\"Ultra\",\"appName\":\"Harappa\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":88,\"testLiveCount\":1,\"statusTime\":\"2024-01-22T03:49:53.038Z\",\"activityStatus\":\"DOWNLOADABLE\",\"activityTime\":\"2024-01-21T05:40:16.966Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2024-01-17T20:49:51.267Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2024-01-20T02:02:27.100Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2024-01-02T11:35:23.081Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2024-01-21T05:39:32.990Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2024-01-21T05:40:16.966Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2024-01-02T11:35:23.081Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2024-01-02T11:35:23.081Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2024-01-19T07:47:15.214Z\"}]}},{\"linkCodeName\":\"six\",\"linkName\":\"Jack\",\"appName\":\"Poompuhar\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":29,\"testLiveCount\":0,\"statusTime\":\"2024-01-09T02:24:43.794Z\",\"activityStatus\":\"PULLRESULT\",\"activityTime\":\"2023-09-25T08:20:34.969Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2023-09-24T12:45:49.109Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2023-09-24T12:45:57.949Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2023-09-24T12:45:14.188Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2023-09-25T05:12:35.787Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2023-09-25T05:12:40.055Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2023-09-24T12:45:14.188Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2023-09-24T12:45:14.188Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2023-09-25T08:20:34.969Z\"}]}},{\"linkCodeName\":\"seven\",\"linkName\":\"Pluto\",\"appName\":\"Chozha\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":163,\"testLiveCount\":6,\"statusTime\":\"2024-01-09T02:24:46.944Z\",\"activityStatus\":\"PULLRESULT\",\"activityTime\":\"2023-10-04T02:48:51.705Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2023-09-30T12:24:44.244Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2023-10-02T12:32:11.524Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2023-09-30T06:14:44.270Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2023-10-03T10:37:51.902Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2023-10-03T15:50:28.713Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2023-09-30T06:14:44.270Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2023-09-30T06:14:44.270Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2023-10-04T02:48:51.705Z\"}]}},{\"linkCodeName\":\"eight\",\"linkName\":\"Winner\",\"appName\":\"Pallava\",\"localServer\":\"Apps(Local 1)\",\"liveServer\":\"Apps(Live 1)\",\"liveStatus\":{\"testStatus\":3,\"testAttendance\":266,\"testLiveCount\":0,\"statusTime\":\"2024-02-01T11:21:05.556Z\",\"activityStatus\":\"PUSHTEST\",\"activityTime\":\"2024-02-01T12:20:46.513Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2024-02-01T12:20:46.513Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2024-01-27T05:16:19.468Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2024-01-22T05:10:34.493Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2024-01-29T16:47:37.134Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2024-02-01T11:52:06.614Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2024-01-22T05:10:34.493Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2024-01-22T05:10:34.493Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2024-02-01T12:17:58.598Z\"}]}},{\"linkCodeName\":\"base\",\"linkName\":\"Qn DB\",\"appName\":\"Qn DB\",\"localServer\":\"QnDB(Local 2)\",\"liveServer\":\"\",\"liveStatus\":{\"testStatus\":0,\"testAttendance\":0,\"testLiveCount\":0,\"statusTime\":\"2021-10-28T11:29:38.766Z\",\"activityStatus\":\"NA\",\"activityTime\":\"2021-10-28T11:29:38.766Z\",\"activityTimeLine\":[{\"sno\":1,\"activity\":\"PUSHTEST\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":2,\"activity\":\"ON\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":3,\"activity\":\"OFF\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":4,\"activity\":\"FINISH\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":5,\"activity\":\"DOWNLOADABLE\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":6,\"activity\":\"DOWNLOAD\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":7,\"activity\":\"SENDMAIL\",\"time\":\"2021-10-28T11:29:38.766Z\"},{\"sno\":8,\"activity\":\"PULLRESULT\",\"time\":\"2021-10-28T11:29:38.766Z\"}]}}]}');
/*!40000 ALTER TABLE `apt_job_config` ENABLE KEYS */;


--
-- Definition of table `apt_job_schedule`
--

DROP TABLE IF EXISTS `apt_job_schedule`;
CREATE TABLE `apt_job_schedule` (
  `schedule_dbid` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_id` varchar(50) NOT NULL DEFAULT '',
  `version_no` int(11) DEFAULT NULL,
  `job_from_date` datetime DEFAULT NULL,
  `job_to_date` datetime DEFAULT NULL,
  `added_date` varchar(100) DEFAULT NULL,
  `is_closed` tinyint(1) DEFAULT '0',
  `test_link_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`schedule_dbid`),
  UNIQUE KEY `schedule_id` (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apt_job_schedule`
--

/*!40000 ALTER TABLE `apt_job_schedule` DISABLE KEYS */;
INSERT INTO `apt_job_schedule` (`schedule_dbid`,`schedule_id`,`version_no`,`job_from_date`,`job_to_date`,`added_date`,`is_closed`,`test_link_name`) VALUES 
 (1,'A21Aug',2,'2021-08-18 00:00:00','2021-09-17 00:00:00','2021-08-19 10:55:01',0,'apple'),
 (2,'B21Aug',1,'2021-08-02 00:00:00','2021-08-31 00:00:00','2021-08-19 16:21:50',0,'bag'),
 (3,'C21Aug',1,'2021-08-19 00:00:00','2021-08-30 00:00:00','2021-08-19 16:22:17',0,'camel'),
 (4,'Q21Aug',1,'2021-08-21 00:00:00','2021-08-31 00:00:00','2021-08-19 16:41:18',0,'quick');
/*!40000 ALTER TABLE `apt_job_schedule` ENABLE KEYS */;


--
-- Definition of table `apt_job_schedule_version`
--

DROP TABLE IF EXISTS `apt_job_schedule_version`;
CREATE TABLE `apt_job_schedule_version` (
  `schedule_dbid` bigint(20) NOT NULL DEFAULT '0',
  `schedule_id` varchar(50) DEFAULT NULL,
  `version_no` int(11) NOT NULL DEFAULT '0',
  `job_from_date` datetime DEFAULT NULL,
  `job_to_date` datetime DEFAULT NULL,
  `added_date` varchar(100) DEFAULT NULL,
  `is_closed` tinyint(1) DEFAULT NULL,
  `test_link_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`schedule_dbid`,`version_no`),
  UNIQUE KEY `schedule_id` (`schedule_id`,`version_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apt_job_schedule_version`
--

/*!40000 ALTER TABLE `apt_job_schedule_version` DISABLE KEYS */;
INSERT INTO `apt_job_schedule_version` (`schedule_dbid`,`schedule_id`,`version_no`,`job_from_date`,`job_to_date`,`added_date`,`is_closed`,`test_link_name`) VALUES 
 (1,'A21Aug',1,'2021-08-18 00:00:00','2021-09-20 00:00:00','2021-08-19 10:48:41',0,'apple'),
 (1,'A21Aug',2,'2021-08-18 00:00:00','2021-09-17 00:00:00','2021-08-19 10:55:01',0,'apple'),
 (2,'B21Aug',1,'2021-08-02 00:00:00','2021-08-31 00:00:00','2021-08-19 16:21:50',0,'bag'),
 (3,'C21Aug',1,'2021-08-19 00:00:00','2021-08-30 00:00:00','2021-08-19 16:22:17',0,'camel'),
 (4,'Q21Aug',1,'2021-08-21 00:00:00','2021-08-31 00:00:00','2021-08-19 16:41:18',0,'quick');
/*!40000 ALTER TABLE `apt_job_schedule_version` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
