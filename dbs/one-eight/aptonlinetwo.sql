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
-- Create schema aptonlinetwo
--

CREATE DATABASE IF NOT EXISTS aptonlinetwo;
USE aptonlinetwo;

--
-- Definition of table `aa_link`
--

DROP TABLE IF EXISTS `aa_link`;
CREATE TABLE `aa_link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_text` varchar(1000) NOT NULL DEFAULT ' ',
  `link_url` varchar(1000) NOT NULL DEFAULT ' ',
  `order_no` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aa_link`
--

/*!40000 ALTER TABLE `aa_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `aa_link` ENABLE KEYS */;


--
-- Definition of table `aa_make_score`
--

DROP TABLE IF EXISTS `aa_make_score`;
CREATE TABLE `aa_make_score` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_name` varchar(100) NOT NULL DEFAULT ' ',
  `test_papers` varchar(2000) NOT NULL DEFAULT ' ',
  `field_list` varchar(1000) NOT NULL DEFAULT ' ',
  `field_caption` varchar(1000) NOT NULL DEFAULT ' ',
  `user_list` varchar(8000) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aa_make_score`
--

/*!40000 ALTER TABLE `aa_make_score` DISABLE KEYS */;
INSERT INTO `aa_make_score` (`report_id`,`report_name`,`test_papers`,`field_list`,`field_caption`,`user_list`,`is_active`) VALUES 
 (15,'Assessment Test #001','Assessment Test #001','sno, fullname, answered_1, score_1, attendance_1, TestStartedAt_1, TimeSpent_1, username','S. No., Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Login User ID','*',1);
/*!40000 ALTER TABLE `aa_make_score` ENABLE KEYS */;


--
-- Definition of table `aa_mkrpt_field`
--

DROP TABLE IF EXISTS `aa_mkrpt_field`;
CREATE TABLE `aa_mkrpt_field` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(250) NOT NULL DEFAULT ' ',
  `field_list` varchar(1000) NOT NULL DEFAULT ' ',
  `field_caption` varchar(1000) NOT NULL DEFAULT ' ',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aa_mkrpt_field`
--

/*!40000 ALTER TABLE `aa_mkrpt_field` DISABLE KEYS */;
INSERT INTO `aa_mkrpt_field` (`field_id`,`field_name`,`field_list`,`field_caption`,`is_active`) VALUES 
 (1,'Single Test Paper - Login ID at Last','sno, fullname, answered_1, score_1, attendance_1, username','S. No., Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Login User ID',0),
 (2,'Single Test Paper - Test Started At(OFF), Time Spent, Login ID Bef Name','sno, username, fullname, answered_1, score_1, attendance_1, TimeSpent_1','S. No., Login ID, Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins)',0),
 (3,'Two Test Paper - Test Started At, Time Spent, Login ID at Last','sno, fullname, answered_1, score_1, attendance_1, TestStartedAt_1, TimeSpent_1, answered_2, score_2, attendance_2, TestStartedAt_2, TimeSpent_2, username','S. No., Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Login User ID',0),
 (4,'Three Test Paper - Test Started At(OFF), Time Spent, Login ID at Last','sno, username, fullname, answered_1, score_1, attendance_1, TimeSpent_1, answered_2, score_2, attendance_2, TimeSpent_2, answered_3, score_3, attendance_3, TimeSpent_3','S. No., Login ID, Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins)',0),
 (5,'Seven Test Paper - Scores Only, Login ID at Last','sno, fullname, score_1, score_2, score_3, score_4, score_5, score_6, score_7, username','S. No., Name of Student, Score (Out of ~qn_count~), Score (Out of ~qn_count~), Score (Out of ~qn_count~), Score (Out of ~qn_count~), Score (Out of ~qn_count~), Score (Out of ~qn_count~), Score (Out of ~qn_count~), Login User ID',0),
 (6,'Four Test Paper - Test Started At, Time Spent, Login ID Bef Name','sno, fullname, answered_1, score_1, attendance_1, TestStartedAt_1, TimeSpent_1, answered_2, score_2, attendance_2, TestStartedAt_2, TimeSpent_2, answered_3, score_3, attendance_3, TestStartedAt_3, TimeSpent_3, answered_4, score_4, attendance_4, TestStartedAt_4, TimeSpent_4, username','S. No., Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Test Started At, Time Spent (Max ~time_limit~ mins), Login User ID',0),
 (7,'Analysis - Three Test Paper - (+Remark) Test Started At, Time Spent, Login ID Bef Name','sno, username, fullname, answered_1, score_1, attendance_1, TimeSpent_1, TimePer_1, ScorePer_1, Remark_1, answered_2, score_2, attendance_2, TimeSpent_2, TimePer_1, ScorePer_1, Remark_2, answered_3, score_3, attendance_3, TimeSpent_3, TimePer_1, ScorePer_1, Remark_3','S. No., Login ID, Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins),Time %(Max 100%), Score %(Max 100%), Remark',0),
 (8,'Analysis + Rule - Three Test Paper - (+Rule For Remark +Remark) Test Started At, Time Spent, Login ID Bef Name','sno, username, fullname, answered_1, score_1, attendance_1, TimeSpent_1, TimePer_1, ScorePer_1, RuleRemark_1, Remark_1, answered_2, score_2, attendance_2, TimeSpent_2, TimePer_2, ScorePer_2, RuleRemark_2, Remark_2, answered_3, score_3, attendance_3, TimeSpent_3, TimePer_3, ScorePer_3, RuleRemark_3, Remark_3','S. No., Login ID, Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins),Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark',0),
 (9,'Analysis + Rule - One Test Paper - (+Rule For Remark +Remark) Test Started At, Time Spent, Login ID Bef Name','sno, username, fullname, answered_1, score_1, attendance_1, TimeSpent_1, TimePer_1, ScorePer_1, RuleRemark_1, Remark_1','S. No., Login ID, Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Rules For Remark, Remarks',1),
 (10,'Analysis + Rule - Four Test Paper - (+Rule For Remark +Remark) Test Started At, Time Spent, Login ID Bef Name','sno, username, fullname, answered_1, score_1, attendance_1, TimeSpent_1, TimePer_1, ScorePer_1, RuleRemark_1, Remark_1, answered_2, score_2, attendance_2, TimeSpent_2, TimePer_2, ScorePer_2, RuleRemark_2, Remark_2, answered_3, score_3, attendance_3, TimeSpent_3, TimePer_3, ScorePer_3, RuleRemark_3, Remark_3, answered_4, score_4, attendance_4, TimeSpent_4, TimePer_4, ScorePer_4, RuleRemark_4, Remark_4','S. No., Login ID, Name of Student, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins), Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins),Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark, Qns Answered (Out of ~qn_count~), Score (Out of ~qn_count~), Attendance, Time Spent (Max ~time_limit~ mins),Time %(Max 100%), Score %(Max 100%), Rule For Remark, Remark',0);
/*!40000 ALTER TABLE `aa_mkrpt_field` ENABLE KEYS */;


--
-- Definition of table `aa_mkrpt_usrgroup`
--

DROP TABLE IF EXISTS `aa_mkrpt_usrgroup`;
CREATE TABLE `aa_mkrpt_usrgroup` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(250) NOT NULL DEFAULT ' ',
  `user_list` varchar(8000) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aa_mkrpt_usrgroup`
--

/*!40000 ALTER TABLE `aa_mkrpt_usrgroup` DISABLE KEYS */;
INSERT INTO `aa_mkrpt_usrgroup` (`group_id`,`group_name`,`user_list`,`is_active`) VALUES 
 (2,'Ultra','*',0),
 (11,'Ultra','*',1);
/*!40000 ALTER TABLE `aa_mkrpt_usrgroup` ENABLE KEYS */;


--
-- Definition of table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `answer_text` varchar(800) CHARACTER SET utf8 DEFAULT NULL,
  `answer_image` varchar(450) CHARACTER SET utf8 DEFAULT NULL,
  `correct_answer` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `correct_answer_text` varchar(800) CHARACTER SET utf8 DEFAULT NULL,
  `answer_pos` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL,
  `answer_text_eng` varchar(800) CHARACTER SET utf8 DEFAULT NULL,
  `control_type` int(11) DEFAULT NULL,
  `answer_parent_id` int(11) DEFAULT NULL,
  `text_unit` char(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `question_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` (`id`,`group_id`,`answer_text`,`answer_image`,`correct_answer`,`priority`,`correct_answer_text`,`answer_pos`,`parent_id`,`answer_text_eng`,`control_type`,`answer_parent_id`,`text_unit`) VALUES 
 (1,1,'A',NULL,0,0,'',0,0,NULL,1,0,''),
 (2,1,'B',NULL,0,0,'',0,0,NULL,1,0,''),
 (3,1,'D',NULL,0,0,'',0,0,NULL,1,0,''),
 (4,1,'E',NULL,1,0,'',0,0,NULL,1,0,''),
 (5,2,'a',NULL,1,0,'',0,0,NULL,1,0,''),
 (6,2,'b',NULL,0,0,'',0,0,NULL,1,0,''),
 (7,2,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (8,2,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (9,3,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (10,3,'b',NULL,1,0,'',0,0,NULL,1,0,''),
 (11,3,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (12,3,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (13,4,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (14,4,'b',NULL,0,0,'',0,0,NULL,1,0,''),
 (15,4,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (16,4,'d',NULL,1,0,'',0,0,NULL,1,0,''),
 (17,5,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (18,5,'b',NULL,0,0,'',0,0,NULL,1,0,''),
 (19,5,'c',NULL,1,0,'',0,0,NULL,1,0,''),
 (20,5,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (21,6,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (22,6,'b',NULL,1,0,'',0,0,NULL,1,0,''),
 (23,6,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (24,6,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (25,7,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (26,7,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (27,7,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (28,7,'e',NULL,1,0,'',0,0,NULL,1,0,''),
 (29,8,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (30,8,'b',NULL,0,0,'',0,0,NULL,1,0,''),
 (31,8,'c',NULL,1,0,'',0,0,NULL,1,0,''),
 (32,8,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (33,9,'a',NULL,0,0,'',0,0,NULL,1,0,''),
 (34,9,'b',NULL,1,0,'',0,0,NULL,1,0,''),
 (35,9,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (36,9,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (37,10,'a',NULL,1,0,'',0,0,NULL,1,0,''),
 (38,10,'b',NULL,0,0,'',0,0,NULL,1,0,''),
 (39,10,'c',NULL,0,0,'',0,0,NULL,1,0,''),
 (40,10,'d',NULL,0,0,'',0,0,NULL,1,0,''),
 (41,10,'e',NULL,0,0,'',0,0,NULL,1,0,''),
 (42,11,'sat',NULL,0,0,'',0,0,NULL,1,0,''),
 (43,11,'crossed',NULL,0,0,'',0,0,NULL,1,0,''),
 (44,11,'leaned',NULL,0,0,'',0,0,NULL,1,0,''),
 (45,11,'lay',NULL,1,0,'',0,0,NULL,1,0,''),
 (46,12,'into',NULL,0,0,'',0,0,NULL,1,0,''),
 (47,12,'down',NULL,1,0,'',0,0,NULL,1,0,''),
 (48,12,'at',NULL,0,0,'',0,0,NULL,1,0,''),
 (49,12,'for',NULL,0,0,'',0,0,NULL,1,0,''),
 (50,13,'number',NULL,1,0,'',0,0,NULL,1,0,''),
 (51,13,'family',NULL,0,0,'',0,0,NULL,1,0,''),
 (52,13,'volume',NULL,0,0,'',0,0,NULL,1,0,''),
 (53,13,'semblance',NULL,0,0,'',0,0,NULL,1,0,''),
 (54,14,'an',NULL,0,0,'',0,0,NULL,1,0,''),
 (55,14,'a',NULL,1,0,'',0,0,NULL,1,0,''),
 (56,14,'one',NULL,0,0,'',0,0,NULL,1,0,''),
 (57,14,'single',NULL,0,0,'',0,0,NULL,1,0,''),
 (58,15,'bank',NULL,0,0,'',0,0,NULL,1,0,''),
 (59,15,'peak',NULL,0,0,'',0,0,NULL,1,0,''),
 (60,15,'pile',NULL,1,0,'',0,0,NULL,1,0,''),
 (61,15,'pit',NULL,0,0,'',0,0,NULL,1,0,''),
 (62,16,'form',NULL,0,0,'',0,0,NULL,1,0,''),
 (63,16,'kind',NULL,0,0,'',0,0,NULL,1,0,''),
 (64,16,'glory',NULL,0,0,'',0,0,NULL,1,0,''),
 (65,16,'number',NULL,1,0,'',0,0,NULL,1,0,''),
 (66,17,'limited',NULL,0,0,'',0,0,NULL,1,0,''),
 (67,17,'shrunk',NULL,1,0,'',0,0,NULL,1,0,''),
 (68,17,'abolished',NULL,0,0,'',0,0,NULL,1,0,''),
 (69,17,'eliminated',NULL,0,0,'',0,0,NULL,1,0,''),
 (70,18,'prevention',NULL,0,0,'',0,0,NULL,1,0,''),
 (71,18,'encroaching',NULL,0,0,'',0,0,NULL,1,0,''),
 (72,18,'shift',NULL,1,0,'',0,0,NULL,1,0,''),
 (73,18,'condition',NULL,0,0,'',0,0,NULL,1,0,''),
 (74,19,'deployed',NULL,1,0,'',0,0,NULL,1,0,''),
 (75,19,'brought',NULL,0,0,'',0,0,NULL,1,0,''),
 (76,19,'swept',NULL,0,0,'',0,0,NULL,1,0,''),
 (77,19,'set',NULL,0,0,'',0,0,NULL,1,0,''),
 (78,20,'agreement',NULL,0,0,'',0,0,NULL,1,0,''),
 (79,20,'contract',NULL,0,0,'',0,0,NULL,1,0,''),
 (80,20,'ban',NULL,1,0,'',0,0,NULL,1,0,''),
 (81,20,'link',NULL,0,0,'',0,0,NULL,1,0,''),
 (82,21,'PSQR',NULL,0,0,'',0,0,NULL,1,0,''),
 (83,21,'PSRQ',NULL,1,0,'',0,0,NULL,1,0,''),
 (84,21,'SPQR',NULL,0,0,'',0,0,NULL,1,0,''),
 (85,21,'SPRQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (86,22,'PRSQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (87,22,'QPSR',NULL,0,0,'',0,0,NULL,1,0,''),
 (88,22,'RPSQ',NULL,1,0,'',0,0,NULL,1,0,''),
 (89,22,'SRPQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (90,23,'PQRS',NULL,0,0,'',0,0,NULL,1,0,''),
 (91,23,'QPSR',NULL,0,0,'',0,0,NULL,1,0,''),
 (92,23,'RPSQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (93,23,'SQRP',NULL,1,0,'',0,0,NULL,1,0,''),
 (94,24,'PRSQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (95,24,'QSPR',NULL,0,0,'',0,0,NULL,1,0,''),
 (96,24,'RQSP',NULL,0,0,'',0,0,NULL,1,0,''),
 (97,24,'SQPR',NULL,1,0,'',0,0,NULL,1,0,''),
 (98,25,'PRSQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (99,25,'RQPS',NULL,1,0,'',0,0,NULL,1,0,''),
 (100,25,'RQPS',NULL,0,0,'',0,0,NULL,1,0,''),
 (101,25,'PSRQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (102,26,'RPSQ',NULL,1,0,'',0,0,NULL,1,0,''),
 (103,26,'QSPR',NULL,0,0,'',0,0,NULL,1,0,''),
 (104,26,'QSRP',NULL,0,0,'',0,0,NULL,1,0,''),
 (105,26,'RSQP',NULL,0,0,'',0,0,NULL,1,0,''),
 (106,27,'PQRS',NULL,0,0,'',0,0,NULL,1,0,''),
 (107,27,'RQPS',NULL,0,0,'',0,0,NULL,1,0,''),
 (108,27,'QPSR',NULL,1,0,'',0,0,NULL,1,0,''),
 (109,27,'RSPQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (110,28,'QPRS',NULL,1,0,'',0,0,NULL,1,0,''),
 (111,28,'QPSR',NULL,0,0,'',0,0,NULL,1,0,''),
 (112,28,'RQPS',NULL,0,0,'',0,0,NULL,1,0,''),
 (113,28,'SRPQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (114,29,'PRSQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (115,29,'QRSP',NULL,1,0,'',0,0,NULL,1,0,''),
 (116,29,'RSPQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (117,29,'RSPQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (118,30,'PQRS',NULL,0,0,'',0,0,NULL,1,0,''),
 (119,30,'QSPR',NULL,0,0,'',0,0,NULL,1,0,''),
 (120,30,'PRSQ',NULL,0,0,'',0,0,NULL,1,0,''),
 (121,30,'RQPS',NULL,1,0,'',0,0,NULL,1,0,''),
 (122,31,'there is a great number of books available to us',NULL,1,0,'',0,0,NULL,1,0,''),
 (123,31,'there is scarcity of books',NULL,0,0,'',0,0,NULL,1,0,''),
 (124,31,'there are only bad books in the market',NULL,0,0,'',0,0,NULL,1,0,''),
 (125,31,'none of the above',NULL,0,0,'',0,0,NULL,1,0,''),
 (126,32,'cost high price',NULL,0,0,'',0,0,NULL,1,0,''),
 (127,32,'come in paperback',NULL,0,0,'',0,0,NULL,1,0,''),
 (128,32,'corrupt our lives by suggesting evils',NULL,1,0,'',0,0,NULL,1,0,''),
 (129,32,'come in more than one volume',NULL,0,0,'',0,0,NULL,1,0,''),
 (130,33,'great books',NULL,0,0,'',0,0,NULL,1,0,''),
 (131,33,'rare books',NULL,0,0,'',0,0,NULL,1,0,''),
 (132,33,'biographies',NULL,0,0,'',0,0,NULL,1,0,''),
 (133,33,'classics',NULL,1,0,'',0,0,NULL,1,0,''),
 (134,34,'They affect our mind in a good way',NULL,0,0,'',0,0,NULL,1,0,''),
 (135,34,'They teach us something great and also entertain us',NULL,0,0,'',0,0,NULL,1,0,''),
 (136,34,'They help us in our spiritual growth',NULL,0,0,'',0,0,NULL,1,0,''),
 (137,34,'All the above',NULL,1,0,'',0,0,NULL,1,0,''),
 (138,35,'Spiritual enjoyment',NULL,0,0,'',0,0,NULL,1,0,''),
 (139,35,'Ennobling influence',NULL,1,0,'',0,0,NULL,1,0,''),
 (140,35,'high ideals',NULL,0,0,'',0,0,NULL,1,0,''),
 (141,35,'Very careful',NULL,0,0,'',0,0,NULL,1,0,''),
 (142,36,'Working force of a country',NULL,0,0,'',0,0,NULL,1,0,''),
 (143,36,'Technology developed in a country',NULL,0,0,'',0,0,NULL,1,0,''),
 (144,36,'Climatic conditions in a country',NULL,0,0,'',0,0,NULL,1,0,''),
 (145,36,'Raw materials available in a country',NULL,1,0,'',0,0,NULL,1,0,''),
 (146,37,'do not create jobs',NULL,0,0,'',0,0,NULL,1,0,''),
 (147,37,'pay minimum wages and exploit natural resources',NULL,1,0,'',0,0,NULL,1,0,''),
 (148,37,'do not bring in new technology',NULL,0,0,'',0,0,NULL,1,0,''),
 (149,37,'make huge profits',NULL,0,0,'',0,0,NULL,1,0,''),
 (150,38,'are a boon to the third world countries',NULL,0,0,'',0,0,NULL,1,0,''),
 (151,38,'become prosperous at the expense of poor countries',NULL,1,0,'',0,0,NULL,1,0,''),
 (152,38,'facilitate the economic growth of poor nations',NULL,0,0,'',0,0,NULL,1,0,''),
 (153,38,'bring technological innovations to poor countries',NULL,0,0,'',0,0,NULL,1,0,''),
 (154,39,'make huge profits',NULL,0,0,'',0,0,NULL,1,0,''),
 (155,39,'operate in at least six countries',NULL,0,0,'',0,0,NULL,1,0,''),
 (156,39,'exploit their employees in the third world',NULL,0,0,'',0,0,NULL,1,0,''),
 (157,39,'All of these',NULL,1,0,'',0,0,NULL,1,0,''),
 (158,40,'Introduction of new gadgets',NULL,0,0,'',0,0,NULL,1,0,''),
 (159,40,'Creation of more jobs',NULL,0,0,'',0,0,NULL,1,0,''),
 (160,40,'Transfer of technical know-how',NULL,1,0,'',0,0,NULL,1,0,''),
 (161,40,'Development of scientific knowledge',NULL,0,0,'',0,0,NULL,1,0,''),
 (162,41,'used paper, tiffin, packings, plastic bags and fallen leaves from trees',NULL,1,0,'',0,0,NULL,1,0,''),
 (163,41,'leftovers of food',NULL,0,0,'',0,0,NULL,1,0,''),
 (164,41,'fallen branches from trees',NULL,0,0,'',0,0,NULL,1,0,''),
 (165,41,'building materials',NULL,0,0,'',0,0,NULL,1,0,''),
 (166,42,'spreading foul smell',NULL,0,0,'',0,0,NULL,1,0,''),
 (167,42,'slowing our vehicles on the road',NULL,0,0,'',0,0,NULL,1,0,''),
 (168,42,'spreading several diseases',NULL,1,0,'',0,0,NULL,1,0,''),
 (169,42,'all the above',NULL,0,0,'',0,0,NULL,1,0,''),
 (170,43,'It is thrown away',NULL,0,0,'',0,0,NULL,1,0,''),
 (171,43,'It is recycled for reuse',NULL,1,0,'',0,0,NULL,1,0,''),
 (172,43,'It is sold to the rag pickers',NULL,0,0,'',0,0,NULL,1,0,''),
 (173,43,'It is dumped into the ground',NULL,0,0,'',0,0,NULL,1,0,''),
 (174,44,'solve the problem of fuel wood in village households',NULL,0,0,'',0,0,NULL,1,0,''),
 (175,44,'enrich water quality',NULL,1,0,'',0,0,NULL,1,0,''),
 (176,44,'enrich soil fertility',NULL,0,0,'',0,0,NULL,1,0,''),
 (177,44,'beautify landscape',NULL,0,0,'',0,0,NULL,1,0,''),
 (178,45,'The refuge is placed with layers of soil with an occasional sprinkling of water',NULL,0,0,'',0,0,NULL,1,0,''),
 (179,45,'It contributes to the manufacture of useful fertilizer',NULL,0,0,'',0,0,NULL,1,0,''),
 (180,45,'It prevents pollution',NULL,0,0,'',0,0,NULL,1,0,''),
 (181,45,'All the above',NULL,1,0,'',0,0,NULL,1,0,''),
 (182,46,'Stems',NULL,0,0,'',0,0,NULL,1,0,''),
 (183,46,'Tubes',NULL,1,0,'',0,0,NULL,1,0,''),
 (184,46,'Pillars',NULL,0,0,'',0,0,NULL,1,0,''),
 (185,46,'Needles',NULL,0,0,'',0,0,NULL,1,0,''),
 (186,47,'Like balls',NULL,0,0,'',0,0,NULL,1,0,''),
 (187,47,'Like tubes',NULL,0,0,'',0,0,NULL,1,0,''),
 (188,47,'Like wheels',NULL,0,0,'',0,0,NULL,1,0,''),
 (189,47,'All of the above',NULL,1,0,'',0,0,NULL,1,0,''),
 (190,48,'North and South America',NULL,1,0,'',0,0,NULL,1,0,''),
 (191,48,'Southern Europe',NULL,0,0,'',0,0,NULL,1,0,''),
 (192,48,'Antarctica',NULL,0,0,'',0,0,NULL,1,0,''),
 (193,48,'Asia',NULL,0,0,'',0,0,NULL,1,0,''),
 (194,49,'Growing Small Leaves',NULL,1,0,'',0,0,NULL,1,0,''),
 (195,49,'Growing Small Stems',NULL,0,0,'',0,0,NULL,1,0,''),
 (196,49,'Growing Large Leaves',NULL,0,0,'',0,0,NULL,1,0,''),
 (197,49,'Growing Deep Roots',NULL,0,0,'',0,0,NULL,1,0,''),
 (198,50,'their flowers fall of',NULL,0,0,'',0,0,NULL,1,0,''),
 (199,50,'their flowers come out',NULL,0,0,'',0,0,NULL,1,0,''),
 (200,50,'they are eaten by insects',NULL,0,0,'',0,0,NULL,1,0,''),
 (201,50,'they are eaten by small animals',NULL,1,0,'',0,0,NULL,1,0,'');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;


--
-- Definition of table `apt_tp_rule`
--

DROP TABLE IF EXISTS `apt_tp_rule`;
CREATE TABLE `apt_tp_rule` (
  `tp_id` bigint(20) unsigned NOT NULL,
  `rule` varchar(4000) NOT NULL DEFAULT '',
  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apt_tp_rule`
--

/*!40000 ALTER TABLE `apt_tp_rule` DISABLE KEYS */;
INSERT INTO `apt_tp_rule` (`tp_id`,`rule`) VALUES 
 (1,''),
 (2,''),
 (3,''),
 (4,''),
 (5,''),
 (6,''),
 (7,''),
 (8,''),
 (9,''),
 (10,''),
 (11,''),
 (12,''),
 (13,''),
 (14,''),
 (15,''),
 (16,''),
 (17,''),
 (18,''),
 (19,''),
 (20,'');
/*!40000 ALTER TABLE `apt_tp_rule` ENABLE KEYS */;


--
-- Definition of table `assignment_users`
--

DROP TABLE IF EXISTS `assignment_users`;
CREATE TABLE `assignment_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) NOT NULL DEFAULT '0',
  `user_type` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `shuffled_qn_ids` varchar(8000) NOT NULL DEFAULT '',
  `answered_ids` varchar(8000) NOT NULL DEFAULT '',
  `qns_time_spent` varchar(8000) NOT NULL DEFAULT ' ',
  `qns_visited` varchar(8000) NOT NULL DEFAULT ' ',
  `time_test_init` datetime DEFAULT NULL,
  `time_test_start` datetime DEFAULT NULL,
  `time_test_lastqn_answered` datetime DEFAULT NULL,
  `time_test_end` datetime DEFAULT NULL,
  `count_qns_answered` int(10) unsigned NOT NULL DEFAULT '0',
  `count_qns_correct` int(10) unsigned NOT NULL DEFAULT '0',
  `count_qns_visited` int(10) unsigned NOT NULL DEFAULT '0',
  `count_test_page_away` int(10) unsigned NOT NULL DEFAULT '0',
  `count_test_app_away` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment_users`
--

/*!40000 ALTER TABLE `assignment_users` DISABLE KEYS */;
INSERT INTO `assignment_users` (`id`,`assignment_id`,`user_type`,`user_id`,`shuffled_qn_ids`,`answered_ids`,`qns_time_spent`,`qns_visited`,`time_test_init`,`time_test_start`,`time_test_lastqn_answered`,`time_test_end`,`count_qns_answered`,`count_qns_correct`,`count_qns_visited`,`count_test_page_away`,`count_test_app_away`) VALUES 
 (1,1,1,2,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (2,1,1,3,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (3,1,1,4,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (4,1,1,5,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (5,1,1,6,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (6,1,1,7,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (7,1,1,8,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (8,1,1,9,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (9,1,1,10,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (10,1,1,11,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (11,1,1,12,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (12,1,1,13,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (13,1,1,14,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (14,1,1,15,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (15,1,1,16,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (16,1,1,17,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (17,1,1,18,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (18,1,1,19,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (19,1,1,20,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (20,1,1,21,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (21,1,1,22,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (22,1,1,23,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (23,1,1,24,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (24,1,1,25,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (25,1,1,26,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (26,1,1,27,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (27,1,1,28,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (28,1,1,29,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (29,1,1,30,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (30,1,1,31,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (31,1,1,32,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (32,1,1,33,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (33,1,1,34,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (34,1,1,35,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (35,1,1,36,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (36,1,1,37,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (37,1,1,38,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (38,1,1,39,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (39,1,1,40,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (40,1,1,41,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (41,1,1,42,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (42,1,1,43,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (43,1,1,44,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (44,1,1,45,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (45,1,1,46,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (46,1,1,47,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (47,1,1,48,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (48,1,1,49,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (49,1,1,50,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (50,1,1,51,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (51,1,1,52,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (52,1,1,53,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (53,1,1,54,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (54,1,1,55,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (55,1,1,56,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (56,1,1,57,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (57,1,1,58,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (58,1,1,59,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (59,1,1,60,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (60,1,1,61,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (61,1,1,62,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (62,1,1,63,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (63,1,1,64,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (64,1,1,65,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (65,1,1,66,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (66,1,1,67,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (67,1,1,68,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (68,1,1,69,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (69,1,1,70,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (70,1,1,71,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (71,1,1,72,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (72,1,1,73,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (73,1,1,74,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (74,1,1,75,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (75,1,1,76,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (76,2,1,77,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (77,2,1,78,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (78,2,1,79,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (79,2,1,80,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (80,2,1,81,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (81,2,1,82,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (82,2,1,83,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (83,2,1,84,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (84,2,1,85,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (85,2,1,86,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (86,2,1,87,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (87,2,1,88,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (88,2,1,89,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (89,2,1,90,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (90,2,1,91,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (91,2,1,92,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (92,2,1,93,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (93,2,1,94,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (94,2,1,95,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (95,2,1,96,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (96,2,1,97,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (97,2,1,98,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (98,2,1,99,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (99,2,1,100,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (100,2,1,101,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (101,2,1,102,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (102,2,1,103,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (103,2,1,104,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (104,2,1,105,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (105,2,1,106,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (106,2,1,107,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (107,2,1,108,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (108,2,1,109,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (109,2,1,110,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (110,2,1,111,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (111,2,1,112,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (112,2,1,113,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (113,2,1,114,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (114,2,1,115,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (115,2,1,116,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (116,2,1,117,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (117,2,1,118,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (118,2,1,119,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (119,2,1,120,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (120,2,1,121,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (121,2,1,122,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (122,2,1,123,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (123,2,1,124,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (124,2,1,125,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (125,2,1,126,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (126,2,1,127,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (127,2,1,128,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (128,2,1,129,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (129,2,1,130,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (130,2,1,131,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (131,2,1,132,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (132,2,1,133,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (133,2,1,134,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (134,2,1,135,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (135,2,1,136,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (136,2,1,137,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (137,2,1,138,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (138,2,1,139,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (139,2,1,140,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (140,2,1,141,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (141,2,1,142,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (142,2,1,143,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (143,2,1,144,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (144,2,1,145,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (145,2,1,146,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (146,2,1,147,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (147,2,1,148,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (148,2,1,149,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (149,2,1,150,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (150,2,1,151,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (151,2,1,152,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (152,2,1,153,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (153,2,1,154,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (154,2,1,155,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (155,2,1,156,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (156,2,1,157,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (157,2,1,158,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (158,2,1,159,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (159,2,1,160,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (160,2,1,161,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (161,2,1,162,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (162,2,1,163,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (163,2,1,164,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (164,2,1,165,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (165,2,1,166,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (166,2,1,167,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (167,2,1,168,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (168,2,1,169,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (169,2,1,170,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (170,2,1,171,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (171,2,1,172,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (172,2,1,173,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (173,2,1,174,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (174,2,1,175,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (175,2,1,176,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (176,2,1,177,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (177,2,1,178,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (178,2,1,179,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (179,2,1,180,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (180,2,1,181,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (181,2,1,182,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (182,2,1,183,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (183,2,1,184,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (184,2,1,185,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (185,2,1,186,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (186,2,1,187,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (187,2,1,188,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (188,2,1,189,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (189,2,1,190,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (190,2,1,191,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (191,2,1,192,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (192,2,1,193,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (193,2,1,194,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (194,2,1,195,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (195,2,1,196,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (196,2,1,197,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (197,2,1,198,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (198,2,1,199,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (199,2,1,200,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (200,2,1,201,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (201,2,1,202,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (202,2,1,203,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (203,2,1,204,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (204,2,1,205,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (205,2,1,206,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (206,2,1,207,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (207,2,1,208,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (208,2,1,209,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (209,2,1,210,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (210,2,1,211,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (211,2,1,212,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (212,2,1,213,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (213,2,1,214,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (214,2,1,215,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (215,2,1,216,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (216,2,1,217,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (217,2,1,218,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (218,2,1,219,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (219,2,1,220,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (220,2,1,221,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (221,2,1,222,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (222,2,1,223,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (223,2,1,224,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (224,2,1,225,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (225,2,1,226,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (226,2,1,227,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (227,2,1,228,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (228,2,1,229,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (229,2,1,230,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (230,2,1,231,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (231,2,1,232,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (232,2,1,233,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (233,2,1,234,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (234,2,1,235,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (235,2,1,236,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (236,2,1,237,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (237,2,1,238,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (238,2,1,239,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (239,2,1,240,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (240,2,1,241,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (241,2,1,242,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (242,2,1,243,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (243,2,1,244,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (244,2,1,245,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (245,2,1,246,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (246,2,1,247,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (247,2,1,248,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (248,2,1,249,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0),
 (249,2,1,250,'','',' ',' ',NULL,NULL,NULL,NULL,0,0,0,0,0);
/*!40000 ALTER TABLE `assignment_users` ENABLE KEYS */;


--
-- Definition of table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL DEFAULT '0',
  `org_quiz_id` int(11) NOT NULL DEFAULT '0',
  `results_mode` int(11) NOT NULL DEFAULT '0',
  `added_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `quiz_time` int(11) NOT NULL DEFAULT '0',
  `show_results` int(11) NOT NULL DEFAULT '0',
  `pass_score` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quiz_type` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` (`id`,`quiz_id`,`org_quiz_id`,`results_mode`,`added_date`,`quiz_time`,`show_results`,`pass_score`,`quiz_type`,`status`) VALUES 
 (1,1,1,1,'2024-01-06 10:23:12',60,1,'50.00',1,0),
 (2,1,1,1,'2024-01-06 10:23:12',60,1,'50.00',1,0);
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;


--
-- Definition of table `cats`
--

DROP TABLE IF EXISTS `cats`;
CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cats`
--

/*!40000 ALTER TABLE `cats` DISABLE KEYS */;
INSERT INTO `cats` (`id`,`cat_name`) VALUES 
 (1,'Assessment Test #002');
/*!40000 ALTER TABLE `cats` ENABLE KEYS */;


--
-- Definition of table `imported_users`
--

DROP TABLE IF EXISTS `imported_users`;
CREATE TABLE `imported_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `surname` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(150) NOT NULL DEFAULT '',
  `password` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imported_users`
--

/*!40000 ALTER TABLE `imported_users` DISABLE KEYS */;
INSERT INTO `imported_users` (`id`,`name`,`surname`,`user_name`,`password`) VALUES 
 (1,'test1','test2','user1','ee11cbb19052e40b07aac0ca060c23ee'),
 (2,'test2','test2','user2','ee11cbb19052e40b07aac0ca060c23ee');
/*!40000 ALTER TABLE `imported_users` ENABLE KEYS */;


--
-- Definition of table `maxedu_cp_loadmax`
--

DROP TABLE IF EXISTS `maxedu_cp_loadmax`;
CREATE TABLE `maxedu_cp_loadmax` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loadtext` varchar(50) NOT NULL,
  `loadval` double NOT NULL DEFAULT '0',
  `loadtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=817 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maxedu_cp_loadmax`
--

/*!40000 ALTER TABLE `maxedu_cp_loadmax` DISABLE KEYS */;
INSERT INTO `maxedu_cp_loadmax` (`id`,`loadtext`,`loadval`,`loadtime`) VALUES 
 (1,'[0,0.01,0.05]',0.05,'2020-07-21 03:03:56'),
 (2,'[0.08,0.03,0.05]',0.08,'2020-07-21 03:05:36'),
 (3,'[0.08,0.1,0.08]',0.1,'2020-07-21 05:05:46'),
 (4,'[0.12,0.11,0.08]',0.12,'2020-07-21 05:06:24'),
 (5,'[0.21,0.12,0.09]',0.21,'2020-07-21 05:07:20'),
 (6,'[0.27,0.14,0.09]',0.27,'2020-07-21 05:07:25'),
 (7,'[0.47,0.18,0.11]',0.47,'2020-07-21 05:12:10'),
 (8,'[0,0.01,0.05]',0.05,'2020-07-21 06:54:37'),
 (9,'[0.07,0.03,0.05]',0.07,'2020-07-21 08:19:46'),
 (10,'[0.14,0.16,0.1]',0.16,'2020-07-21 09:19:03'),
 (11,'[0.04,0.1,0.09]',0.1,'2020-07-21 10:29:42'),
 (12,'[0.15,0.11,0.1]',0.15,'2020-07-21 10:30:45'),
 (13,'[0.29,0.14,0.11]',0.29,'2020-07-21 10:30:53'),
 (14,'[0.35,0.11,0.09]',0.35,'2020-07-21 10:56:10'),
 (15,'[0.01,0.06,0.07]',0.07,'2020-07-21 11:00:01'),
 (16,'[0.08,0.06,0.07]',0.08,'2020-07-21 11:02:06'),
 (17,'[0.13,0.07,0.07]',0.13,'2020-07-21 11:02:31'),
 (18,'[0.17,0.07,0.06]',0.17,'2020-07-21 11:08:04'),
 (19,'[0.18,0.1,0.06]',0.18,'2020-07-21 11:12:18'),
 (20,'[0.22,0.11,0.08]',0.22,'2020-07-21 11:25:37'),
 (21,'[0.27,0.12,0.09]',0.27,'2020-07-21 11:25:45'),
 (22,'[0.29,0.13,0.09]',0.29,'2020-07-21 11:26:01'),
 (23,'[0.09,0.08,0.07]',0.09,'2020-07-22 02:21:04'),
 (24,'[0.33,0.1,0.07]',0.33,'2020-07-22 02:28:04'),
 (25,'[0.39,0.12,0.07]',0.39,'2020-07-22 02:28:12'),
 (26,'[0.68,0.18,0.09]',0.68,'2020-07-22 02:28:16'),
 (27,'[0.02,0.05,0.05]',0.05,'2020-07-22 09:40:09'),
 (28,'[0.11,0.06,0.05]',0.11,'2020-07-22 11:25:48'),
 (29,'[0.15,0.08,0.05]',0.15,'2020-07-22 11:27:26'),
 (30,'[0.25,0.11,0.06]',0.25,'2020-07-22 11:30:00'),
 (31,'[0.29,0.13,0.07]',0.29,'2020-07-22 11:31:37'),
 (32,'[0.09,0.07,0.05]',0.09,'2020-07-22 12:48:04'),
 (33,'[0.15,0.08,0.06]',0.15,'2020-07-22 12:48:11'),
 (34,'[0,0.01,0.05]',0.05,'2020-07-23 02:10:30'),
 (35,'[0.08,0.03,0.05]',0.08,'2020-07-23 02:11:17'),
 (36,'[0.16,0.05,0.06]',0.16,'2020-07-23 02:21:49'),
 (37,'[0.33,0.09,0.07]',0.33,'2020-07-23 02:25:01'),
 (38,'[0.38,0.13,0.07]',0.38,'2020-07-23 02:28:23'),
 (39,'[0.43,0.14,0.08]',0.43,'2020-07-23 02:28:27'),
 (40,'[0.44,0.16,0.08]',0.44,'2020-07-23 02:28:39'),
 (41,'[0.49,0.17,0.09]',0.49,'2020-07-23 02:28:43'),
 (42,'[0.61,0.2,0.1]',0.61,'2020-07-23 02:28:47'),
 (43,'[0.64,0.21,0.1]',0.64,'2020-07-23 02:28:51'),
 (44,'[0.02,0.02,0.05]',0.05,'2020-07-23 04:13:58'),
 (45,'[0.08,0.03,0.05]',0.08,'2020-07-23 04:20:00'),
 (46,'[0.1,0.04,0.05]',0.1,'2020-07-23 04:21:32'),
 (47,'[0.08,0.08,0.06]',0.08,'2020-07-23 09:20:15'),
 (48,'[0.06,0.07,0.06]',0.07,'2020-07-23 13:58:02'),
 (49,'[0.01,0.05,0.05]',0.05,'2020-07-23 14:00:01'),
 (50,'[0.08,0.05,0.05]',0.08,'2020-07-23 14:01:50'),
 (51,'[0.13,0.06,0.05]',0.13,'2020-07-23 14:02:16'),
 (52,'[0.2,0.08,0.06]',0.2,'2020-07-23 14:02:21'),
 (53,'[0.02,0.02,0.05]',0.05,'2020-07-23 18:16:38'),
 (54,'[0.08,0.03,0.05]',0.08,'2020-07-23 18:25:04'),
 (55,'[0.14,0.05,0.05]',0.14,'2020-07-23 18:45:18'),
 (56,'[0.17,0.06,0.06]',0.17,'2020-07-23 18:45:49'),
 (57,'[0.23,0.08,0.06]',0.23,'2020-07-23 18:46:37'),
 (58,'[0,0.01,0.05]',0.05,'2020-07-23 21:07:14'),
 (59,'[0.01,0.06,0.06]',0.06,'2020-07-24 02:32:36'),
 (60,'[0.08,0.04,0.05]',0.08,'2020-07-24 02:37:02'),
 (61,'[0.12,0.06,0.05]',0.12,'2020-07-24 02:37:52'),
 (62,'[0.14,0.07,0.05]',0.14,'2020-07-24 02:38:28'),
 (63,'[0.04,0.03,0.05]',0.05,'2020-07-24 06:47:09'),
 (64,'[0.1,0.04,0.05]',0.1,'2020-07-24 06:47:35'),
 (65,'[0,0.01,0.05]',0.05,'2020-07-24 08:24:03'),
 (66,'[0.09,0.04,0.05]',0.09,'2020-07-24 08:31:27'),
 (67,'[0,0.01,0.05]',0.05,'2020-07-24 09:01:24'),
 (68,'[0.14,0.05,0.06]',0.14,'2020-07-24 09:03:19'),
 (69,'[0,0.01,0.05]',0.05,'2020-07-24 10:33:13'),
 (70,'[0.16,0.05,0.06]',0.16,'2020-07-24 10:36:54'),
 (71,'[0.22,0.06,0.06]',0.22,'2020-07-24 10:37:04'),
 (72,'[0.03,0.22,0.16]',0.22,'2020-07-25 02:33:25'),
 (73,'[0.29,0.14,0.14]',0.29,'2020-07-25 02:38:42'),
 (74,'[0.34,0.16,0.15]',0.34,'2020-07-25 02:38:46'),
 (75,'[0,0.01,0.05]',0.05,'2020-07-25 03:09:15'),
 (76,'[0.06,0.06,0.05]',0.06,'2020-07-25 04:29:16'),
 (77,'[0.1,0.06,0.05]',0.1,'2020-07-25 07:58:04'),
 (78,'[0,0.01,0.05]',0.05,'2020-07-25 10:46:33'),
 (79,'[0,0.01,0.05]',0.05,'2020-07-25 12:08:55'),
 (80,'[0,0.01,0.05]',0.05,'2020-07-25 14:09:35'),
 (81,'[0.08,0.09,0.07]',0.09,'2020-07-26 04:24:18'),
 (82,'[0.06,0.06,0.05]',0.06,'2020-07-26 05:27:44'),
 (83,'[0.1,0.07,0.05]',0.1,'2020-07-26 05:29:02'),
 (84,'[0.11,0.09,0.06]',0.11,'2020-07-26 09:01:25'),
 (85,'[0.15,0.08,0.05]',0.15,'2020-07-26 09:04:30'),
 (86,'[0.16,0.07,0.06]',0.16,'2020-07-26 09:08:47'),
 (87,'[0.19,0.09,0.06]',0.19,'2020-07-26 09:10:02'),
 (88,'[0.25,0.11,0.06]',0.25,'2020-07-26 09:30:43'),
 (89,'[0.02,0.04,0.05]',0.05,'2020-07-26 10:16:37'),
 (90,'[0.08,0.03,0.05]',0.08,'2020-07-26 10:20:17'),
 (91,'[0.13,0.05,0.05]',0.13,'2020-07-26 10:20:46'),
 (92,'[0,0.01,0.05]',0.05,'2020-07-26 12:05:48'),
 (93,'[0.12,0.04,0.05]',0.12,'2020-07-26 12:17:57'),
 (94,'[0,0.01,0.05]',0.05,'2020-08-07 02:55:10'),
 (95,'[0.03,0.04,0.05]',0.05,'2020-08-07 03:16:08'),
 (96,'[0,0.02,0.05]',0.05,'2020-08-07 04:35:01'),
 (97,'[0,0.02,0.05]',0.05,'2020-08-07 07:41:20'),
 (98,'[0,0.01,0.05]',0.05,'2020-08-07 11:25:40'),
 (99,'[0,0.01,0.05]',0.05,'2020-08-08 02:59:50'),
 (100,'[0,0.01,0.05]',0.05,'2020-08-08 03:00:00'),
 (101,'[0.08,0.03,0.05]',0.08,'2020-08-08 03:01:59'),
 (102,'[0.12,0.04,0.05]',0.12,'2020-08-08 03:02:39'),
 (103,'[0,0.01,0.05]',0.05,'2020-08-08 11:07:23'),
 (104,'[0,0.01,0.05]',0.05,'2020-08-08 13:31:53'),
 (105,'[0.08,0.03,0.05]',0.08,'2020-08-08 13:35:08'),
 (106,'[0.02,0.02,0.05]',0.05,'2020-08-09 10:22:48'),
 (107,'[0,0.01,0.05]',0.05,'2020-08-09 14:26:36'),
 (108,'[0,0.13,0.14]',0.14,'2020-08-10 02:36:03'),
 (109,'[0,0.01,0.05]',0.05,'2020-08-10 03:08:15'),
 (110,'[0.08,0.03,0.05]',0.08,'2020-08-10 03:08:18'),
 (111,'[0.38,0.14,0.09]',0.38,'2020-08-10 03:35:15'),
 (112,'[0.1,0.07,0.05]',0.1,'2020-08-10 05:03:33'),
 (113,'[0.14,0.08,0.06]',0.14,'2020-08-10 05:04:04'),
 (114,'[0.25,0.1,0.06]',0.25,'2020-08-10 05:06:20'),
 (115,'[0.28,0.12,0.07]',0.28,'2020-08-10 05:07:03'),
 (116,'[0.03,0.05,0.05]',0.05,'2020-08-10 06:57:58'),
 (117,'[0.09,0.06,0.05]',0.09,'2020-08-10 06:58:56'),
 (118,'[0.13,0.07,0.05]',0.13,'2020-08-10 06:59:24'),
 (119,'[0.08,0.06,0.05]',0.08,'2020-08-10 07:00:02'),
 (120,'[0.1,0.06,0.05]',0.1,'2020-08-10 07:01:30'),
 (121,'[0.13,0.07,0.05]',0.13,'2020-08-10 07:02:10'),
 (122,'[0.03,0.04,0.05]',0.05,'2020-08-10 09:10:20'),
 (123,'[0,0.01,0.05]',0.05,'2020-08-10 11:05:12'),
 (124,'[0.08,0.03,0.05]',0.08,'2020-08-10 11:15:09'),
 (125,'[0.13,0.04,0.05]',0.13,'2020-08-11 03:10:15'),
 (126,'[0.16,0.06,0.06]',0.16,'2020-08-11 03:53:55'),
 (127,'[0.18,0.09,0.06]',0.18,'2020-08-11 03:56:40'),
 (128,'[0.05,0.06,0.05]',0.06,'2020-08-11 04:00:00'),
 (129,'[0.24,0.06,0.06]',0.24,'2020-08-11 04:39:58'),
 (130,'[0.16,0.07,0.06]',0.16,'2020-08-11 07:24:07'),
 (131,'[0.18,0.11,0.07]',0.18,'2020-08-11 09:54:41'),
 (132,'[0.2,0.12,0.07]',0.2,'2020-08-11 09:55:05'),
 (133,'[0,0.03,0.05]',0.05,'2020-08-11 10:19:49'),
 (134,'[0,0.01,0.05]',0.05,'2020-08-11 11:10:23'),
 (135,'[0,0.03,0.05]',0.05,'2020-08-12 13:52:32'),
 (136,'[0.08,0.04,0.05]',0.08,'2020-08-12 13:53:58'),
 (137,'[0.1,0.05,0.05]',0.1,'2020-08-12 13:55:17'),
 (138,'[0.11,0.06,0.05]',0.11,'2020-08-12 13:56:22'),
 (139,'[0.12,0.06,0.05]',0.12,'2020-08-12 13:57:23'),
 (140,'[0.01,0.04,0.05]',0.05,'2020-08-12 14:00:00'),
 (141,'[0.08,0.04,0.05]',0.08,'2020-08-12 14:02:32'),
 (142,'[0.09,0.03,0.05]',0.09,'2020-08-12 14:24:23'),
 (143,'[0.17,0.05,0.06]',0.17,'2020-08-12 14:29:36'),
 (144,'[0.24,0.09,0.06]',0.24,'2020-08-12 14:46:34'),
 (145,'[0.27,0.1,0.06]',0.27,'2020-08-12 14:46:46'),
 (146,'[0.03,0.04,0.05]',0.05,'2020-08-12 15:00:02'),
 (147,'[0.08,0.04,0.05]',0.08,'2020-08-12 15:03:42'),
 (148,'[0.13,0.05,0.05]',0.13,'2020-08-12 15:04:07'),
 (149,'[0.19,0.08,0.06]',0.19,'2020-08-12 15:09:02'),
 (150,'[0.25,0.07,0.06]',0.25,'2020-08-12 15:25:14'),
 (151,'[0.35,0.11,0.07]',0.35,'2020-08-12 15:26:04'),
 (152,'[0.57,0.17,0.09]',0.57,'2020-08-12 15:46:00'),
 (153,'[0.67,0.24,0.12]',0.67,'2020-08-12 15:55:35'),
 (154,'[0.7,0.25,0.13]',0.7,'2020-08-12 15:55:39'),
 (155,'[0.05,0.12,0.11]',0.12,'2020-08-12 16:00:02'),
 (156,'[0.13,0.14,0.11]',0.14,'2020-08-12 16:00:06'),
 (157,'[0.18,0.14,0.12]',0.18,'2020-08-12 16:00:19'),
 (158,'[0.25,0.11,0.1]',0.25,'2020-08-12 16:09:08'),
 (159,'[0.29,0.12,0.11]',0.29,'2020-08-12 16:09:20'),
 (160,'[0,0.01,0.05]',0.05,'2020-08-12 21:31:08'),
 (161,'[0.01,0.07,0.07]',0.07,'2020-08-13 14:07:34'),
 (162,'[0.08,0.08,0.07]',0.08,'2020-08-13 14:08:44'),
 (163,'[0.11,0.08,0.07]',0.11,'2020-08-13 14:09:44'),
 (164,'[0,0.01,0.05]',0.05,'2020-08-13 21:34:02'),
 (165,'[0.08,0.03,0.05]',0.08,'2020-08-13 21:34:05'),
 (166,'[0.14,0.05,0.05]',0.14,'2020-08-13 21:34:25'),
 (167,'[0.02,0.02,0.05]',0.05,'2020-08-14 13:37:48'),
 (168,'[0.08,0.03,0.05]',0.08,'2020-08-14 13:39:02'),
 (169,'[0.14,0.05,0.05]',0.14,'2020-08-14 13:39:22'),
 (170,'[0.2,0.06,0.06]',0.2,'2020-08-14 13:39:30'),
 (171,'[0.3,0.09,0.07]',0.3,'2020-08-14 13:39:50'),
 (172,'[0,0.02,0.05]',0.05,'2020-08-14 14:00:00'),
 (173,'[0.08,0.03,0.05]',0.08,'2020-08-14 14:01:51'),
 (174,'[0.13,0.04,0.05]',0.13,'2020-08-14 14:02:20'),
 (175,'[0.06,0.08,0.12]',0.12,'2020-08-14 19:12:15'),
 (176,'[0.2,0.13,0.14]',0.2,'2020-08-14 19:18:52'),
 (177,'[0.26,0.14,0.14]',0.26,'2020-08-14 19:18:55'),
 (178,'[0,0.01,0.05]',0.05,'2020-08-14 20:24:01'),
 (179,'[0.08,0.03,0.05]',0.08,'2020-08-14 20:25:09'),
 (180,'[0.09,0.04,0.05]',0.09,'2020-08-14 20:50:08'),
 (181,'[0.01,0.02,0.05]',0.05,'2020-08-14 21:00:00'),
 (182,'[0.08,0.03,0.05]',0.08,'2020-08-14 21:02:45'),
 (183,'[0.13,0.04,0.05]',0.13,'2020-08-14 21:03:21'),
 (184,'[0.16,0.05,0.06]',0.16,'2020-08-14 21:38:32'),
 (185,'[0,0.01,0.05]',0.05,'2020-08-14 22:00:02'),
 (186,'[4.89,-1,3.79]',4.89,'2020-10-10 16:40:54'),
 (187,'[3.09,-1,5.33]',5.33,'2020-10-10 16:40:56'),
 (188,'[3.37,-1,6.91]',6.91,'2020-10-15 12:44:38'),
 (189,'[1.57,1.72,1.81]',1.81,'2020-11-12 18:43:32'),
 (190,'[1.06,1.36,1.42]',1.42,'2020-11-13 07:01:01'),
 (191,'[1.44,1.45,1.48]',1.48,'2020-11-13 08:59:28'),
 (192,'[1.48,1.46,1.49]',1.49,'2020-11-13 08:59:32'),
 (193,'[1.52,1.47,1.49]',1.52,'2020-11-13 08:59:37'),
 (194,'[1.8,1.52,1.51]',1.8,'2020-11-13 08:59:43'),
 (195,'[1.82,1.53,1.51]',1.82,'2020-11-13 08:59:46'),
 (196,'[1.91,1.56,1.52]',1.91,'2020-11-13 08:59:52'),
 (197,'[2.16,1.61,1.54]',2.16,'2020-11-13 08:59:57'),
 (198,'[1.99,1.59,1.53]',1.99,'2020-11-13 09:00:02'),
 (199,'[2.09,1.63,1.54]',2.09,'2020-11-13 09:00:32'),
 (200,'[2.25,1.67,1.56]',2.25,'2020-11-13 09:00:37'),
 (201,'[43.12,41.23,40.42]',43.12,'2020-11-13 22:50:26'),
 (202,'[43.91,41.42,40.49]',43.91,'2020-11-13 22:50:31'),
 (203,'[44.16,41.52,40.52]',44.16,'2020-11-13 22:50:36'),
 (204,'[48.43,43.09,41.11]',48.43,'2020-11-13 22:51:24'),
 (205,'[49.72,43.55,41.28]',49.72,'2020-11-13 22:51:36'),
 (206,'[50.23,43.76,41.36]',50.23,'2020-11-13 22:51:43'),
 (207,'[50.72,44.88,41.9]',50.72,'2020-11-13 22:52:47'),
 (208,'[51.47,45.13,41.99]',51.47,'2020-11-13 22:52:51'),
 (209,'[10.05,11.02,11.72]',11.72,'2020-11-14 07:00:55'),
 (210,'[10.47,11.08,11.73]',11.73,'2020-11-14 07:01:05'),
 (211,'[12.2,12.65,12.36]',12.65,'2020-11-14 12:36:09'),
 (212,'[12.27,12.66,12.36]',12.66,'2020-11-14 12:36:14'),
 (213,'[12.33,12.67,12.37]',12.67,'2020-11-14 12:36:19'),
 (214,'[15.27,17.6,17.95]',17.95,'2020-11-16 14:02:03'),
 (215,'[14.36,13.62,13.56]',14.36,'2020-11-16 23:37:16'),
 (216,'[14.4,13.65,13.57]',14.4,'2020-11-16 23:37:24'),
 (217,'[14.97,14.41,14.23]',14.97,'2020-11-17 09:39:23'),
 (218,'[32.88,23.83,18.11]',32.88,'2020-11-17 17:11:52'),
 (219,'[13.15,13.46,13.63]',13.63,'2020-11-18 08:39:39'),
 (220,'[13.43,13.51,13.64]',13.64,'2020-11-18 08:39:45'),
 (221,'[13.56,13.54,13.65]',13.65,'2020-11-18 08:39:51'),
 (222,'[13.67,13.55,13.65]',13.67,'2020-11-18 08:40:06'),
 (223,'[13.91,13.54,13.64]',13.91,'2020-11-18 08:41:01'),
 (224,'[14.8,13.73,13.7]',14.8,'2020-11-18 08:41:09'),
 (225,'[6.47,5.39,5.44]',6.47,'2020-12-13 20:00:08'),
 (226,'[6.54,5.46,5.47]',6.54,'2020-12-13 20:00:30'),
 (227,'[6.58,5.49,5.47]',6.58,'2020-12-13 20:00:35'),
 (228,'[6.72,5.56,5.5]',6.72,'2020-12-13 20:00:50'),
 (229,'[7.5,5.74,5.34]',7.5,'2020-12-13 20:38:03'),
 (230,'[4.24,4.83,5.05]',5.05,'2020-12-13 21:00:01'),
 (231,'[5.9,5.17,5.16]',5.9,'2020-12-13 21:00:04'),
 (232,'[6.47,5.3,5.2]',6.47,'2020-12-13 21:00:09'),
 (233,'[6.23,5.86,5.24]',6.23,'2020-12-14 11:12:57'),
 (234,'[6.29,5.88,5.26]',6.29,'2020-12-14 11:13:05'),
 (235,'[7.4,6.73,6.62]',7.4,'2020-12-14 17:50:24'),
 (236,'[7.67,6.84,6.66]',7.67,'2020-12-14 17:50:52'),
 (237,'[6.26,7.2,7.32]',7.32,'2020-12-19 20:03:47'),
 (238,'[8.19,7.14,7.2]',8.19,'2020-12-19 20:09:14'),
 (239,'[8.26,7.18,7.21]',8.26,'2020-12-19 20:09:17'),
 (240,'[8.38,7.24,7.23]',8.38,'2020-12-19 20:09:29'),
 (241,'[8.51,7.28,7.25]',8.51,'2020-12-19 20:09:33'),
 (242,'[8.95,7.39,7.29]',8.95,'2020-12-19 20:09:41'),
 (243,'[9.12,7.45,7.31]',9.12,'2020-12-19 20:09:45'),
 (244,'[9.13,7.91,7.5]',9.13,'2020-12-19 20:13:20'),
 (245,'[9.5,8.24,7.66]',9.5,'2020-12-19 20:15:28'),
 (246,'[7.52,7.39,7.19]',7.52,'2020-12-19 21:12:05'),
 (247,'[7.68,7.42,7.21]',7.68,'2020-12-19 21:12:11'),
 (248,'[6.78,7.37,7.18]',7.37,'2020-12-20 12:49:08'),
 (249,'[5.36,5.78,6.29]',6.29,'2020-12-21 23:43:53'),
 (250,'[5.93,6,6.27]',6.27,'2020-12-22 16:14:43'),
 (251,'[6.46,6.09,6.29]',6.46,'2020-12-22 16:15:10'),
 (252,'[5.67,5.2,5.03]',5.67,'2020-12-26 12:35:39'),
 (253,'[6.81,6.23,5.75]',6.81,'2020-12-26 19:12:00'),
 (254,'[6.83,6.24,5.75]',6.83,'2020-12-26 19:12:02'),
 (255,'[6.86,6.27,5.77]',6.86,'2020-12-26 19:12:11'),
 (256,'[6.97,6.32,5.79]',6.97,'2020-12-26 19:12:33'),
 (257,'[5.76,5.33,5.48]',5.76,'2020-12-26 20:30:38'),
 (258,'[5.92,5.38,5.48]',5.92,'2020-12-26 20:31:16'),
 (259,'[6.32,5.47,5.51]',6.32,'2020-12-26 20:31:24'),
 (260,'[5.32,5.67,5.77]',5.77,'2020-12-27 09:19:15'),
 (261,'[6.55,6.15,6.33]',6.55,'2020-12-27 16:56:51'),
 (262,'[7.22,6.3,6.38]',7.22,'2020-12-27 16:56:56'),
 (263,'[7.41,6.38,6.41]',7.41,'2020-12-27 16:57:11'),
 (264,'[5.17,5.91,6.23]',6.23,'2020-12-27 17:00:00'),
 (265,'[5.64,6,6.26]',6.26,'2020-12-27 17:00:05'),
 (266,'[6.31,5.81,5.98]',6.31,'2020-12-27 17:14:21'),
 (267,'[6.33,5.84,5.99]',6.33,'2020-12-27 17:14:37'),
 (268,'[6.63,5.91,6.01]',6.63,'2020-12-27 17:14:41'),
 (269,'[6.65,5.95,6.02]',6.65,'2020-12-27 17:14:57'),
 (270,'[6.92,6.01,6.04]',6.92,'2020-12-27 17:15:01'),
 (271,'[7.01,6.05,6.05]',7.01,'2020-12-27 17:15:05'),
 (272,'[7.09,6.11,6.07]',7.09,'2020-12-27 17:15:21'),
 (273,'[7.57,6.23,6.11]',7.57,'2020-12-27 17:15:29'),
 (274,'[7.76,6.29,6.13]',7.76,'2020-12-27 17:15:33'),
 (275,'[7.81,6.45,6.19]',7.81,'2020-12-27 17:16:13'),
 (276,'[7.89,7.52,7.71]',7.89,'2020-12-27 19:46:14'),
 (277,'[7.93,8.49,8.33]',8.49,'2020-12-27 20:31:52'),
 (278,'[8.53,8.54,8.36]',8.54,'2020-12-27 20:32:31'),
 (279,'[8.65,8.57,8.37]',8.65,'2020-12-27 20:32:36'),
 (280,'[8.79,8.6,8.38]',8.79,'2020-12-27 20:32:46'),
 (281,'[8.89,8.62,8.39]',8.89,'2020-12-27 20:32:51'),
 (282,'[8.99,8.65,8.4]',8.99,'2020-12-27 20:33:16'),
 (283,'[8.56,7.68,7.76]',8.56,'2020-12-27 21:50:45'),
 (284,'[4.98,4.67,4.75]',4.98,'2020-12-28 16:56:20'),
 (285,'[5.19,4.74,4.77]',5.19,'2020-12-28 16:56:45'),
 (286,'[5.49,4.81,4.79]',5.49,'2020-12-28 16:56:55'),
 (287,'[5.4,5.33,5.04]',5.4,'2020-12-28 17:07:02'),
 (288,'[5.45,5.3,5.05]',5.45,'2020-12-28 17:08:10'),
 (289,'[5.97,5.41,5.08]',5.97,'2020-12-28 17:08:17'),
 (290,'[4.45,4.54,4.75]',4.75,'2020-12-29 06:50:40'),
 (291,'[4.9,4.63,4.78]',4.9,'2020-12-29 06:50:42'),
 (292,'[8.42,7.74,7.34]',8.42,'2021-01-03 23:26:29'),
 (293,'[8.55,7.77,7.35]',8.55,'2021-01-03 23:26:34'),
 (294,'[8.58,7.79,7.36]',8.58,'2021-01-03 23:26:38'),
 (295,'[4.06,4.98,5.39]',5.39,'2021-01-04 09:52:58'),
 (296,'[5.03,5.1,5.41]',5.41,'2021-01-04 09:53:26'),
 (297,'[5.77,5.32,5.22]',5.77,'2021-01-04 10:14:50'),
 (298,'[6.07,6.1,6.08]',6.1,'2021-01-04 12:36:07'),
 (299,'[6.23,6.13,6.09]',6.23,'2021-01-04 12:36:10'),
 (300,'[6.69,6.23,6.13]',6.69,'2021-01-04 12:36:15'),
 (301,'[5.65,5.87,5.97]',5.97,'2021-01-04 13:00:00'),
 (302,'[5.87,5.91,5.98]',5.98,'2021-01-04 13:00:12'),
 (303,'[5.99,5.93,5.99]',5.99,'2021-01-04 13:00:28'),
 (304,'[6.23,5.98,6]',6.23,'2021-01-04 13:00:32'),
 (305,'[6.46,6.04,6.02]',6.46,'2021-01-04 13:00:48'),
 (306,'[6.58,6.07,6.03]',6.58,'2021-01-04 13:00:52'),
 (307,'[5.45,5.89,6.22]',6.22,'2021-01-04 16:58:32'),
 (308,'[7.27,6.53,6.15]',7.27,'2021-01-04 17:40:48'),
 (309,'[7.57,6.6,6.18]',7.57,'2021-01-04 17:40:53'),
 (310,'[7.76,6.66,6.2]',7.76,'2021-01-04 17:40:59'),
 (311,'[8.26,6.78,6.24]',8.26,'2021-01-04 17:41:04'),
 (312,'[8.3,7.39,7.48]',8.3,'2021-01-04 21:31:31'),
 (313,'[8.8,7.66,7.55]',8.8,'2021-01-04 21:33:12'),
 (314,'[9.06,7.77,7.59]',9.06,'2021-01-04 21:33:28'),
 (315,'[7.82,6.95,6.27]',7.82,'2021-01-05 09:28:38'),
 (316,'[6.41,7.29,7.54]',7.54,'2021-01-05 17:09:16'),
 (317,'[7.58,7.35,7.53]',7.58,'2021-01-05 17:11:07'),
 (318,'[8.58,7.51,7.57]',8.58,'2021-01-05 17:12:03'),
 (319,'[6.49,6.4,6.34]',6.49,'2021-01-05 18:00:00'),
 (320,'[6.53,6.41,6.34]',6.53,'2021-01-05 18:00:07'),
 (321,'[6.57,6.42,6.35]',6.57,'2021-01-05 18:00:11'),
 (322,'[6.7,6.44,6.36]',6.7,'2021-01-05 18:00:31'),
 (323,'[6.97,6.09,6.19]',6.97,'2021-01-05 18:04:05'),
 (324,'[7.13,6.14,6.21]',7.13,'2021-01-05 18:04:10'),
 (325,'[8.14,8.44,8.34]',8.44,'2021-01-05 19:47:51'),
 (326,'[8.45,8.5,8.36]',8.5,'2021-01-05 19:47:53'),
 (327,'[8.72,8.55,8.37]',8.72,'2021-01-05 19:48:04'),
 (328,'[6.76,5.97,6.25]',6.76,'2021-01-06 00:25:03'),
 (329,'[10.4,10.92,10.23]',10.92,'2021-01-07 18:33:14'),
 (330,'[12.21,11.29,10.35]',12.21,'2021-01-07 18:33:22'),
 (331,'[10.52,10.72,10.8]',10.8,'2021-01-07 20:33:26'),
 (332,'[7.59,8.24,9.26]',9.26,'2021-01-07 21:00:01'),
 (333,'[7.78,8.27,9.27]',9.27,'2021-01-07 21:00:06'),
 (334,'[8.36,8.39,9.3]',9.3,'2021-01-07 21:00:11'),
 (335,'[8.73,8.46,9.32]',9.32,'2021-01-07 21:00:16'),
 (336,'[9,8.52,9.33]',9.33,'2021-01-07 21:00:23'),
 (337,'[9.86,8.74,9.37]',9.86,'2021-01-07 21:01:04'),
 (338,'[9.01,7.31,6.83]',9.01,'2021-01-09 13:55:00'),
 (339,'[7.32,7.45,7.05]',7.45,'2021-01-09 14:01:52'),
 (340,'[7.66,7.3,7.04]',7.66,'2021-01-09 14:04:08'),
 (341,'[7.12,7.25,7.23]',7.25,'2021-01-17 00:24:52'),
 (342,'[5.65,5.76,5.69]',5.76,'2021-01-17 07:07:34'),
 (343,'[5.84,5.8,5.7]',5.84,'2021-01-17 07:07:37'),
 (344,'[6.01,5.84,5.71]',6.01,'2021-01-17 07:07:42'),
 (345,'[6.27,5.89,5.73]',6.27,'2021-01-17 07:08:07'),
 (346,'[5.26,5.81,6]',6,'2021-01-17 10:02:12'),
 (347,'[7.17,6.11,6.08]',7.17,'2021-01-17 10:03:03'),
 (348,'[7.3,6.17,6.1]',7.3,'2021-01-17 10:03:13'),
 (349,'[7.36,6.2,6.11]',7.36,'2021-01-17 10:03:18'),
 (350,'[8.45,6.47,6.2]',8.45,'2021-01-17 10:03:33'),
 (351,'[7.16,7.24,7.12]',7.24,'2021-01-17 13:03:48'),
 (352,'[7.31,7.26,7.13]',7.31,'2021-01-17 13:03:56'),
 (353,'[7.36,7.27,7.14]',7.36,'2021-01-17 13:04:01'),
 (354,'[7.57,7.32,7.15]',7.57,'2021-01-17 13:04:06'),
 (355,'[8.59,8.57,8]',8.59,'2021-01-17 13:13:47'),
 (356,'[7.9,7.46,7.27]',7.9,'2021-01-17 14:38:30'),
 (357,'[9.45,8.91,8.85]',9.45,'2021-01-17 20:26:39'),
 (358,'[9.46,8.94,8.86]',9.46,'2021-01-17 20:27:04'),
 (359,'[9.7,8.74,8.74]',9.7,'2021-01-17 20:31:29'),
 (360,'[9.81,8.78,8.75]',9.81,'2021-01-17 20:31:34'),
 (361,'[9.98,8.83,8.77]',9.98,'2021-01-17 20:31:40'),
 (362,'[10.6,9.12,8.86]',10.6,'2021-01-17 20:33:03'),
 (363,'[11.2,8.91,8.77]',11.2,'2021-01-17 20:51:03'),
 (364,'[11.91,9.1,8.83]',11.91,'2021-01-17 20:51:08'),
 (365,'[9.38,9.07,8.9]',9.38,'2021-01-17 21:27:09'),
 (366,'[9.43,9.09,8.91]',9.43,'2021-01-17 21:27:13'),
 (367,'[9.56,9.12,8.92]',9.56,'2021-01-17 21:27:18'),
 (368,'[10,9.22,8.95]',10,'2021-01-17 21:27:23'),
 (369,'[10.29,9.34,9]',10.29,'2021-01-17 21:28:10'),
 (370,'[10.58,9.44,9.04]',10.58,'2021-01-17 21:28:26'),
 (371,'[10.66,9.53,9.08]',10.66,'2021-01-17 21:28:45'),
 (372,'[5.57,5.67,5.75]',5.75,'2021-01-18 09:00:42'),
 (373,'[5.64,5.68,5.76]',5.76,'2021-01-18 09:00:51'),
 (374,'[5.81,5.72,5.77]',5.81,'2021-01-18 09:01:07'),
 (375,'[5.91,5.74,5.77]',5.91,'2021-01-18 09:01:11'),
 (376,'[5.95,5.75,5.77]',5.95,'2021-01-18 09:01:39'),
 (377,'[6.27,5.82,5.8]',6.27,'2021-01-18 09:01:43'),
 (378,'[6.33,5.84,5.8]',6.33,'2021-01-18 09:01:47'),
 (379,'[6.76,5.94,5.84]',6.76,'2021-01-18 09:01:59'),
 (380,'[6.78,5.96,5.84]',6.78,'2021-01-18 09:02:03'),
 (381,'[6.94,6.03,5.87]',6.94,'2021-01-18 09:02:19'),
 (382,'[10.1,9.58,9.32]',10.1,'2021-01-18 17:43:26'),
 (383,'[10.13,9.6,9.33]',10.13,'2021-01-18 17:44:02'),
 (384,'[10.43,9.7,9.37]',10.43,'2021-01-18 17:44:29'),
 (385,'[11.91,10.06,9.5]',11.91,'2021-01-18 17:45:06'),
 (386,'[11.99,10.11,9.52]',11.99,'2021-01-18 17:45:10'),
 (387,'[12.41,10.49,9.73]',12.41,'2021-01-18 17:47:57'),
 (388,'[8.19,8.82,9.25]',9.25,'2021-01-18 18:04:56'),
 (389,'[6.39,6.66,6.26]',6.66,'2021-01-19 06:50:16'),
 (390,'[6.67,6.68,6.28]',6.68,'2021-01-19 06:50:59'),
 (391,'[6.7,6.69,6.29]',6.7,'2021-01-19 06:51:03'),
 (392,'[6.74,6.66,6.29]',6.74,'2021-01-19 06:51:43'),
 (393,'[6.8,6.66,6.3]',6.8,'2021-01-19 06:52:03'),
 (394,'[6.04,6.29,6.32]',6.32,'2021-01-19 07:17:38'),
 (395,'[6.28,6.33,6.33]',6.33,'2021-01-19 07:17:43'),
 (396,'[6.35,6.29,6.31]',6.35,'2021-01-19 07:19:02'),
 (397,'[6.36,6.29,6.31]',6.36,'2021-01-19 07:19:22'),
 (398,'[6.53,6.21,6.27]',6.53,'2021-01-19 07:20:49'),
 (399,'[6.64,6.24,6.28]',6.64,'2021-01-19 07:20:53'),
 (400,'[6.67,6.25,6.28]',6.67,'2021-01-19 07:21:01'),
 (401,'[7.1,6.35,6.31]',7.1,'2021-01-19 07:21:05'),
 (402,'[5.95,6.52,6.09]',6.52,'2021-01-19 09:04:09'),
 (403,'[6.6,6.19,6.03]',6.6,'2021-01-19 09:10:07'),
 (404,'[6.63,6.2,6.03]',6.63,'2021-01-19 09:10:11'),
 (405,'[6.66,6.22,6.04]',6.66,'2021-01-19 09:10:19'),
 (406,'[7.01,6.3,6.07]',7.01,'2021-01-19 09:10:23'),
 (407,'[7.08,6.32,6.11]',7.08,'2021-01-19 09:15:59'),
 (408,'[7.43,6.8,6.82]',7.43,'2021-01-19 14:17:57'),
 (409,'[7.6,6.86,6.84]',7.6,'2021-01-19 14:18:13'),
 (410,'[7.64,6.88,6.84]',7.64,'2021-01-19 14:18:17'),
 (411,'[7.77,8.07,8.01]',8.07,'2021-01-19 17:19:23'),
 (412,'[7.95,8.11,8.02]',8.11,'2021-01-19 17:19:26'),
 (413,'[8.28,8.17,8.04]',8.28,'2021-01-19 17:19:33'),
 (414,'[8.74,8.26,8.07]',8.74,'2021-01-19 17:20:14'),
 (415,'[8.76,8.27,8.08]',8.76,'2021-01-19 17:20:19'),
 (416,'[8.78,8.28,8.08]',8.78,'2021-01-19 17:20:23'),
 (417,'[8.8,8.08,8.02]',8.8,'2021-01-19 17:23:48'),
 (418,'[9.49,8.24,8.07]',9.49,'2021-01-19 17:24:00'),
 (419,'[10.25,8.42,8.13]',10.25,'2021-01-19 17:24:04'),
 (420,'[8.83,8.41,8.06]',8.83,'2021-01-19 20:00:45'),
 (421,'[9.19,8.5,8.09]',9.19,'2021-01-19 20:00:53'),
 (422,'[8.64,7.72,7.09]',8.64,'2021-01-20 08:55:14'),
 (423,'[8.75,7.81,7.13]',8.75,'2021-01-20 08:55:41'),
 (424,'[8.81,7.87,7.17]',8.81,'2021-01-20 08:55:59'),
 (425,'[9.55,8.04,7.23]',9.55,'2021-01-20 08:56:04'),
 (426,'[6.41,7.35,7.13]',7.35,'2021-01-20 09:00:00'),
 (427,'[7.18,7.49,7.18]',7.49,'2021-01-20 09:00:06'),
 (428,'[7.41,7.53,7.2]',7.53,'2021-01-20 09:00:11'),
 (429,'[8.1,7.67,7.24]',8.1,'2021-01-20 09:00:16'),
 (430,'[8.2,7.71,7.27]',8.2,'2021-01-20 09:01:08'),
 (431,'[8.33,7.75,7.29]',8.33,'2021-01-20 09:01:18'),
 (432,'[8.38,7.77,7.3]',8.38,'2021-01-20 09:01:23'),
 (433,'[8.51,7.81,7.32]',8.51,'2021-01-20 09:01:28'),
 (434,'[8.64,7.87,7.34]',8.64,'2021-01-20 09:01:42'),
 (435,'[8.82,7.94,7.38]',8.82,'2021-01-20 09:02:02'),
 (436,'[9.07,8.01,7.41]',9.07,'2021-01-20 09:02:09'),
 (437,'[9.24,8.11,7.45]',9.24,'2021-01-20 09:02:29'),
 (438,'[9.53,8.21,7.49]',9.53,'2021-01-20 09:02:39'),
 (439,'[9.65,8.25,7.51]',9.65,'2021-01-20 09:02:44'),
 (440,'[5.68,5.24,5.65]',5.68,'2021-01-20 10:17:06'),
 (441,'[5.71,5.25,5.66]',5.71,'2021-01-20 10:17:09'),
 (442,'[5.73,5.26,5.66]',5.73,'2021-01-20 10:17:13'),
 (443,'[5.75,5.3,5.66]',5.75,'2021-01-20 10:17:49'),
 (444,'[5.93,5.35,5.67]',5.93,'2021-01-20 10:17:57'),
 (445,'[6.02,5.37,5.68]',6.02,'2021-01-20 10:18:01'),
 (446,'[6.03,5.4,5.68]',6.03,'2021-01-20 10:18:17'),
 (447,'[6.05,5.46,5.69]',6.05,'2021-01-20 10:18:51'),
 (448,'[6.78,5.66,5.73]',6.78,'2021-01-20 10:19:59'),
 (449,'[8.08,5.94,5.82]',8.08,'2021-01-20 10:20:03'),
 (450,'[11.19,9.03,8.67]',11.19,'2021-01-20 17:30:52'),
 (451,'[11.39,9.26,8.75]',11.39,'2021-01-20 17:31:25'),
 (452,'[3.2,3.89,4.33]',4.33,'2021-01-21 09:10:45'),
 (453,'[3.42,3.92,4.34]',4.34,'2021-01-21 09:10:50'),
 (454,'[5.11,4.24,4.44]',5.11,'2021-01-21 09:11:02'),
 (455,'[5.26,4.29,4.45]',5.26,'2021-01-21 09:11:08'),
 (456,'[5.62,3.93,4.03]',5.62,'2021-01-21 09:24:21'),
 (457,'[7.16,4.38,4.17]',7.16,'2021-01-21 09:25:04'),
 (458,'[6.57,6.98,7.55]',7.55,'2021-01-21 17:26:01'),
 (459,'[4.41,4.56,4.53]',4.56,'2021-01-22 08:59:53'),
 (460,'[4.54,4.58,4.54]',4.58,'2021-01-22 08:59:56'),
 (461,'[5.7,4.82,4.62]',5.7,'2021-01-22 09:00:02'),
 (462,'[7.73,8.72,9.5]',9.5,'2021-03-09 11:59:47'),
 (463,'[9.71,9.08,9.6]',9.71,'2021-03-09 12:00:02'),
 (464,'[9.89,9.13,9.62]',9.89,'2021-03-09 12:00:06'),
 (465,'[12.56,12.5,12.16]',12.56,'2021-03-09 16:58:32'),
 (466,'[12.68,12.52,12.17]',12.68,'2021-03-09 16:58:37'),
 (467,'[12.86,12.57,12.19]',12.86,'2021-03-09 16:58:44'),
 (468,'[13.47,12.68,12.23]',13.47,'2021-03-09 16:59:04'),
 (469,'[13.81,12.8,12.28]',13.81,'2021-03-09 16:59:28'),
 (470,'[14.07,12.87,12.31]',14.07,'2021-03-09 16:59:33'),
 (471,'[14.78,13.87,12.82]',14.78,'2021-03-09 17:02:59'),
 (472,'[15.33,14.53,13.57]',15.33,'2021-03-09 17:42:43'),
 (473,'[9.83,9.75,9.86]',9.86,'2021-03-09 22:14:00'),
 (474,'[10,9.79,9.87]',10,'2021-03-09 22:14:06'),
 (475,'[7.64,7.7,7.61]',7.7,'2021-03-10 08:53:42'),
 (476,'[7.75,7.72,7.62]',7.75,'2021-03-10 08:53:44'),
 (477,'[7.77,7.72,7.62]',7.77,'2021-03-10 08:53:49'),
 (478,'[9.43,8.77,8.09]',9.43,'2021-03-10 09:17:56'),
 (479,'[9.46,8.8,8.1]',9.46,'2021-03-10 09:18:04'),
 (480,'[9.58,8.83,8.12]',9.58,'2021-03-10 09:18:08'),
 (481,'[7.65,7.89,8.49]',8.49,'2021-03-10 17:30:24'),
 (482,'[8.21,8,8.51]',8.51,'2021-03-10 17:30:41'),
 (483,'[8.78,8.12,8.52]',8.78,'2021-03-10 17:31:33'),
 (484,'[9.09,8.22,8.54]',9.09,'2021-03-10 17:31:54'),
 (485,'[6.28,6.14,6.53]',6.53,'2021-03-11 08:31:16'),
 (486,'[6.55,6.2,6.55]',6.55,'2021-03-11 08:31:34'),
 (487,'[6.68,6.25,6.55]',6.68,'2021-03-11 08:32:00'),
 (488,'[6.79,6.28,6.56]',6.79,'2021-03-11 08:32:05'),
 (489,'[8.87,8.93,9.35]',9.35,'2021-03-11 17:29:47'),
 (490,'[9.36,8.97,9.32]',9.36,'2021-03-11 17:31:16'),
 (491,'[6.54,7.46,7.43]',7.46,'2021-03-12 10:03:30'),
 (492,'[6.74,7.48,7.44]',7.48,'2021-03-12 10:03:33'),
 (493,'[7.03,7.52,7.45]',7.52,'2021-03-12 10:03:42'),
 (494,'[7.64,7.34,7.38]',7.64,'2021-03-12 10:05:50'),
 (495,'[1.16,-1,6.32]',6.32,'2021-03-19 21:13:09'),
 (496,'[13.69,13.4,13.05]',13.69,'2021-03-19 21:40:04'),
 (497,'[14.12,13.5,13.08]',14.12,'2021-03-19 21:40:09'),
 (498,'[11.38,14.85,13.42]',14.85,'2021-03-20 07:36:14'),
 (499,'[23.89,19.43,15.9]',23.89,'2021-03-20 09:05:38'),
 (500,'[23.9,19.75,16.12]',23.9,'2021-03-20 09:06:10'),
 (501,'[25.4,20.21,16.3]',25.4,'2021-03-20 09:06:18'),
 (502,'[26.92,20.8,16.56]',26.92,'2021-03-20 09:06:38'),
 (503,'[28.77,21.93,17.17]',28.77,'2021-03-20 09:07:31'),
 (504,'[29.11,22.11,17.25]',29.11,'2021-03-20 09:07:36'),
 (505,'[29.5,24.37,20.55]',29.5,'2021-03-20 09:19:27'),
 (506,'[10.76,10.26,11.34]',11.34,'2021-03-20 11:17:51'),
 (507,'[11.99,10.74,11.4]',11.99,'2021-03-20 11:19:28'),
 (508,'[12.03,10.89,11.38]',12.03,'2021-03-20 11:21:00'),
 (509,'[12.16,11.1,11.4]',12.16,'2021-03-20 11:22:35'),
 (510,'[12.4,11.09,11.19]',12.4,'2021-03-20 11:30:11'),
 (511,'[12.5,11.15,11.2]',12.5,'2021-03-20 11:30:21'),
 (512,'[13.18,11.36,11.27]',13.18,'2021-03-20 11:30:37'),
 (513,'[14.69,13.08,11.89]',14.69,'2021-03-20 12:32:20'),
 (514,'[14.71,13.12,11.91]',14.71,'2021-03-20 12:32:23'),
 (515,'[14.74,13.15,11.93]',14.74,'2021-03-20 12:32:28'),
 (516,'[13.45,11.97,12.33]',13.45,'2021-03-20 17:09:06'),
 (517,'[13.48,12.02,12.34]',13.48,'2021-03-20 17:09:14'),
 (518,'[13.52,12.05,12.35]',13.52,'2021-03-20 17:09:19'),
 (519,'[14.64,13.6,12.9]',14.64,'2021-03-20 17:12:31'),
 (520,'[14.79,13.67,12.93]',14.79,'2021-03-20 17:12:45'),
 (521,'[18.65,14.25,13.17]',18.65,'2021-03-20 17:15:16'),
 (522,'[14.48,15.08,14.83]',15.08,'2021-03-21 20:00:40'),
 (523,'[15.37,15.21,14.88]',15.37,'2021-03-21 20:00:59'),
 (524,'[15.38,15.14,14.87]',15.38,'2021-03-21 20:02:02'),
 (525,'[15.5,13.6,13.51]',15.5,'2021-03-21 20:24:59'),
 (526,'[16.02,13.74,13.56]',16.02,'2021-03-21 20:25:04'),
 (527,'[16.66,13.91,13.62]',16.66,'2021-03-21 20:25:10'),
 (528,'[11.47,12.83,14.22]',14.22,'2021-03-21 21:15:51'),
 (529,'[12.58,12.97,14.23]',14.23,'2021-03-21 21:16:16'),
 (530,'[3.67,-1,2.15]',3.67,'2021-03-30 17:18:43'),
 (531,'[5.45,-1,2.26]',5.45,'2021-03-30 17:18:45'),
 (532,'[2.72,-1,6.7]',6.7,'2021-03-30 17:19:05'),
 (533,'[6.75,-1,4.75]',6.75,'2021-03-30 17:19:57'),
 (534,'[1.86,-1,6.95]',6.95,'2021-03-30 17:20:20'),
 (535,'[6.61,-1,7]',7,'2021-03-30 17:24:57'),
 (536,'[2.71,-1,4.94]',4.94,'2021-04-05 18:14:22'),
 (537,'[2.22,-1,1.05]',2.22,'2021-04-12 16:04:50'),
 (538,'[2.92,-1,3.77]',3.77,'2021-04-12 16:04:52'),
 (539,'[3.26,-1,5.84]',5.84,'2021-04-12 16:04:58'),
 (540,'[5.3,-1,6.71]',6.71,'2021-04-12 16:05:03'),
 (541,'[6.38,-1,6.78]',6.78,'2021-04-12 16:06:06'),
 (542,'[3.39,-1,6.81]',6.81,'2021-04-12 16:06:21'),
 (543,'[2.63,-1,3.65]',3.65,'2021-04-13 11:41:21'),
 (544,'[3.73,-1,5.69]',5.69,'2021-04-13 11:41:23'),
 (545,'[1.03,-1,1.92]',1.92,'2021-04-16 17:27:43'),
 (546,'[2.37,-1,0.47]',2.37,'2021-04-16 17:27:45'),
 (547,'[3.42,-1,6.23]',6.23,'2021-04-16 17:27:47'),
 (548,'[6.36,-1,2.99]',6.36,'2021-04-16 17:28:18'),
 (549,'[6.1,-1,6.22]',6.22,'2021-04-20 17:47:31'),
 (550,'[5.02,-1,6.9]',6.9,'2021-04-20 17:47:47'),
 (551,'[2.42,-1,4.95]',4.95,'2021-04-21 08:08:56'),
 (552,'[1.96,-1,6.64]',6.64,'2021-04-21 08:09:02'),
 (553,'[6.9,-1,4.72]',6.9,'2021-04-21 08:09:05'),
 (554,'[3.84,-1,0.47]',3.84,'2021-04-21 18:49:10'),
 (555,'[1.29,-1,3.94]',3.94,'2021-04-21 18:49:17'),
 (556,'[5.91,-1,5.06]',5.91,'2021-04-21 18:49:20'),
 (557,'[1.27,-1,6.09]',6.09,'2021-04-21 18:49:30'),
 (558,'[5.6,-1,6.12]',6.12,'2021-04-21 18:49:55'),
 (559,'[6.67,-1,1.97]',6.67,'2021-04-21 18:50:07'),
 (560,'[5.14,-1,6.99]',6.99,'2021-04-21 18:50:15'),
 (561,'[2.03,-1,1.28]',2.03,'2021-04-22 17:33:26'),
 (562,'[5.4,-1,3.83]',5.4,'2021-04-22 17:33:28'),
 (563,'[2.94,-1,6.88]',6.88,'2021-04-28 15:13:46'),
 (564,'[5.31,-1,0.33]',5.31,'2021-04-29 15:34:07'),
 (565,'[6.74,-1,4.9]',6.74,'2021-04-29 15:34:09'),
 (566,'[3.77,-1,2.38]',3.77,'2021-05-06 18:03:21'),
 (567,'[6.68,-1,1.94]',6.68,'2021-05-06 18:03:25'),
 (568,'[6.61,-1,5.03]',6.61,'2021-05-11 17:31:42'),
 (569,'[12.66,11.67,10.96]',12.66,'2021-05-17 16:42:11'),
 (570,'[13.09,11.77,11]',13.09,'2021-05-17 16:42:14'),
 (571,'[12.08,11.81,11.95]',12.08,'2021-05-17 19:13:19'),
 (572,'[12.13,11.82,11.95]',12.13,'2021-05-17 19:13:32'),
 (573,'[12.43,11.88,11.96]',12.43,'2021-05-17 19:14:03'),
 (574,'[11.89,11.72,12.32]',12.32,'2021-05-17 20:19:48'),
 (575,'[11.84,11.7,11.64]',11.84,'2021-05-17 22:51:17'),
 (576,'[11.85,11.71,11.64]',11.85,'2021-05-17 22:51:19'),
 (577,'[11.87,11.71,11.64]',11.87,'2021-05-17 22:51:24'),
 (578,'[12.36,11.82,11.68]',12.36,'2021-05-17 22:51:29'),
 (579,'[12.41,11.84,11.69]',12.41,'2021-05-17 22:51:34'),
 (580,'[12.47,12.35,11.94]',12.47,'2021-05-17 23:10:37'),
 (581,'[12.76,12.41,11.96]',12.76,'2021-05-17 23:10:39'),
 (582,'[12.89,12.45,11.98]',12.89,'2021-05-17 23:10:50'),
 (583,'[10.91,10.93,10.87]',10.93,'2021-05-18 03:13:03'),
 (584,'[11.08,10.97,10.88]',11.08,'2021-05-18 03:13:06'),
 (585,'[11.15,10.98,10.89]',11.15,'2021-05-18 03:13:10'),
 (586,'[11.37,11.04,10.9]',11.37,'2021-05-18 03:13:23'),
 (587,'[11.5,11.07,10.92]',11.5,'2021-05-18 03:13:27'),
 (588,'[11.71,11.13,10.94]',11.71,'2021-05-18 03:13:46'),
 (589,'[11.73,11.16,10.95]',11.73,'2021-05-18 03:14:02'),
 (590,'[11.9,11.26,11]',11.9,'2021-05-18 03:15:06'),
 (591,'[11.92,11.29,11.01]',11.92,'2021-05-18 03:15:14'),
 (592,'[12.17,11.35,11.03]',12.17,'2021-05-18 03:15:18'),
 (593,'[12.47,11.43,11.06]',12.47,'2021-05-18 03:15:26'),
 (594,'[8.56,8.35,8.44]',8.56,'2021-05-18 07:37:59'),
 (595,'[12.55,11.9,11.61]',12.55,'2021-05-18 15:57:03'),
 (596,'[13.06,12.02,11.65]',13.06,'2021-05-18 15:57:05'),
 (597,'[13.94,12.22,11.71]',13.94,'2021-05-18 15:57:12'),
 (598,'[10.35,11.02,11.44]',11.44,'2021-05-18 16:47:25'),
 (599,'[10.57,11.06,11.45]',11.45,'2021-05-18 16:47:27'),
 (600,'[15.22,14.89,14.7]',15.22,'2021-05-18 18:50:55'),
 (601,'[15.95,15.04,14.75]',15.95,'2021-05-18 18:51:05'),
 (602,'[12.74,12.8,13.32]',13.32,'2021-05-18 23:29:55'),
 (603,'[14.79,13.23,13.45]',14.79,'2021-05-18 23:30:02'),
 (604,'[15.45,13.39,13.51]',15.45,'2021-05-18 23:30:10'),
 (605,'[15.81,13.5,13.54]',15.81,'2021-05-18 23:30:14'),
 (606,'[10.94,11.54,11.35]',11.54,'2021-05-19 15:56:53'),
 (607,'[11.26,11.6,11.37]',11.6,'2021-05-19 15:56:57'),
 (608,'[11.69,11.6,11.38]',11.69,'2021-05-19 15:57:55'),
 (609,'[12.47,11.77,11.43]',12.47,'2021-05-19 15:58:03'),
 (610,'[12.57,11.82,11.47]',12.57,'2021-05-19 15:59:04'),
 (611,'[12.69,11.93,11.52]',12.69,'2021-05-19 16:00:00'),
 (612,'[12.96,12,11.55]',12.96,'2021-05-19 16:00:08'),
 (613,'[13.12,12.05,11.56]',13.12,'2021-05-19 16:00:12'),
 (614,'[15.97,15.14,14.12]',15.97,'2021-05-19 18:18:52'),
 (615,'[9.9,10.5,10.45]',10.5,'2021-05-20 00:03:17'),
 (616,'[10.19,10.3,10.18]',10.3,'2021-05-20 10:03:12'),
 (617,'[11.06,10.87,10.81]',11.06,'2021-05-20 13:07:00'),
 (618,'[11.78,11.08,10.74]',11.78,'2021-05-20 15:58:33'),
 (619,'[11.8,11.14,10.78]',11.8,'2021-05-20 15:59:16'),
 (620,'[13.62,11.55,10.91]',13.62,'2021-05-20 15:59:40'),
 (621,'[13.01,11.56,10.93]',13.01,'2021-05-20 16:00:05'),
 (622,'[11.55,11.05,11.2]',11.55,'2021-05-20 18:05:30'),
 (623,'[11.64,11.08,11.21]',11.64,'2021-05-20 18:05:38'),
 (624,'[12.17,11.13,10.72]',12.17,'2021-05-20 19:46:37'),
 (625,'[12.22,11.3,10.81]',12.22,'2021-05-20 19:48:07'),
 (626,'[12.29,11.32,10.83]',12.29,'2021-05-20 19:48:13'),
 (627,'[10.55,10.77,10.96]',10.96,'2021-05-20 20:28:18'),
 (628,'[11.12,10.85,10.97]',11.12,'2021-05-20 20:29:00'),
 (629,'[11.19,10.87,10.98]',11.19,'2021-05-20 20:29:05'),
 (630,'[11.38,10.74,10.88]',11.38,'2021-05-20 20:32:15'),
 (631,'[11.96,10.89,10.93]',11.96,'2021-05-20 20:32:25'),
 (632,'[12.04,10.92,10.94]',12.04,'2021-05-20 20:32:30'),
 (633,'[10.08,9.87,9.9]',10.08,'2021-05-21 14:27:23'),
 (634,'[10.31,9.92,9.92]',10.31,'2021-05-21 14:28:01'),
 (635,'[10.37,9.94,9.92]',10.37,'2021-05-21 14:28:06'),
 (636,'[8.32,9.59,9.4]',9.59,'2021-05-21 15:07:23'),
 (637,'[8.53,9.61,9.41]',9.61,'2021-05-21 15:07:25'),
 (638,'[10.92,9.79,9.31]',10.92,'2021-05-21 15:41:51'),
 (639,'[11.61,9.99,9.38]',11.61,'2021-05-21 15:42:05'),
 (640,'[10.59,10.94,11.1]',11.1,'2021-05-21 18:57:43'),
 (641,'[10.78,10.98,11.11]',11.11,'2021-05-21 18:57:50'),
 (642,'[10.88,10.99,11.12]',11.12,'2021-05-21 18:57:55'),
 (643,'[10.38,10.58,10.74]',10.74,'2021-05-21 19:50:25'),
 (644,'[10.51,10.61,10.75]',10.75,'2021-05-21 19:50:28'),
 (645,'[10.95,10.7,10.77]',10.95,'2021-05-21 19:50:33'),
 (646,'[11.19,10.75,10.79]',11.19,'2021-05-21 19:50:39'),
 (647,'[11.26,10.77,10.8]',11.26,'2021-05-21 19:50:44'),
 (648,'[11.56,10.84,10.82]',11.56,'2021-05-21 19:50:47'),
 (649,'[11.82,10.94,10.85]',11.82,'2021-05-21 19:51:11'),
 (650,'[11.92,10.97,10.86]',11.92,'2021-05-21 19:51:14'),
 (651,'[12.1,11.05,10.89]',12.1,'2021-05-21 19:55:14'),
 (652,'[12.17,11.1,10.91]',12.17,'2021-05-21 19:55:26'),
 (653,'[12.48,11.18,10.93]',12.48,'2021-05-21 19:55:31'),
 (654,'[12.64,11.27,10.97]',12.64,'2021-05-21 19:55:46'),
 (655,'[12.21,11.26,11]',12.21,'2021-05-21 20:00:03'),
 (656,'[12.25,11.31,11.02]',12.25,'2021-05-21 20:00:18'),
 (657,'[12.59,11.31,11.06]',12.59,'2021-05-21 20:05:04'),
 (658,'[12.75,11.38,11.08]',12.75,'2021-05-21 20:05:15'),
 (659,'[12.87,11.15,10.93]',12.87,'2021-05-21 20:19:03'),
 (660,'[10.53,10.27,10.32]',10.53,'2021-05-21 23:55:01'),
 (661,'[10.56,10.29,10.33]',10.56,'2021-05-21 23:55:07'),
 (662,'[10.68,10.32,10.34]',10.68,'2021-05-21 23:55:12'),
 (663,'[10.76,10.34,10.34]',10.76,'2021-05-21 23:56:05'),
 (664,'[12.11,11.14,10.65]',12.11,'2021-05-22 00:02:16'),
 (665,'[12.22,10.84,10.6]',12.22,'2021-05-22 00:06:04'),
 (666,'[12.53,10.93,10.63]',12.53,'2021-05-22 00:06:08'),
 (667,'[12.57,10.97,10.64]',12.57,'2021-05-22 00:06:12'),
 (668,'[12.6,11,10.65]',12.6,'2021-05-22 00:06:20'),
 (669,'[10.57,10.49,10.8]',10.8,'2021-05-22 16:14:51'),
 (670,'[10.84,10.55,10.81]',10.84,'2021-05-22 16:14:54'),
 (671,'[12.11,11.63,11.27]',12.11,'2021-05-22 16:28:54'),
 (672,'[12.25,11.68,11.29]',12.25,'2021-05-22 16:29:04'),
 (673,'[13.05,12.34,11.79]',13.05,'2021-05-22 16:37:44'),
 (674,'[13.2,12.39,11.8]',13.2,'2021-05-22 16:37:47'),
 (675,'[9.47,10.54,11.01]',11.01,'2021-05-22 19:04:23'),
 (676,'[10.84,10.08,9.76]',10.84,'2021-05-23 01:33:20'),
 (677,'[10.89,11.76,11.8]',11.8,'2021-05-23 16:02:34'),
 (678,'[11.14,11.8,11.81]',11.81,'2021-05-23 16:02:37'),
 (679,'[10.53,10.37,10.23]',10.53,'2021-05-24 00:01:34'),
 (680,'[10.56,10.38,10.24]',10.56,'2021-05-24 00:01:36'),
 (681,'[10.76,10.42,10.25]',10.76,'2021-05-24 00:01:42'),
 (682,'[10.86,10.45,10.26]',10.86,'2021-05-24 00:01:46'),
 (683,'[11.15,10.5,10.29]',11.15,'2021-05-24 00:03:03'),
 (684,'[11.22,10.52,10.29]',11.22,'2021-05-24 00:03:08'),
 (685,'[11.28,10.56,10.31]',11.28,'2021-05-24 00:03:18'),
 (686,'[11.98,10.71,10.36]',11.98,'2021-05-24 00:03:23'),
 (687,'[12.14,10.77,10.38]',12.14,'2021-05-24 00:03:28'),
 (688,'[13.13,13.82,13.81]',13.82,'2021-05-26 17:00:41'),
 (689,'[10.77,11.77,12.09]',12.09,'2021-05-27 01:10:27'),
 (690,'[12.39,11.83,12.07]',12.39,'2021-05-27 01:12:10'),
 (691,'[12.58,11.89,12.08]',12.58,'2021-05-27 01:12:20'),
 (692,'[11.76,11.57,11]',11.76,'2021-05-27 18:08:26'),
 (693,'[12.04,11.3,10.81]',12.04,'2021-05-29 16:53:59'),
 (694,'[10.65,10.51,10.66]',10.66,'2021-05-29 17:36:49'),
 (695,'[10.59,11.19,11.16]',11.19,'2021-05-30 00:13:52'),
 (696,'[11.22,11.3,11.2]',11.3,'2021-05-30 00:14:03'),
 (697,'[11.52,11.36,11.22]',11.52,'2021-05-30 00:14:08'),
 (698,'[11.78,11.37,11.23]',11.78,'2021-05-30 00:15:34'),
 (699,'[14.03,13.31,12.73]',14.03,'2021-05-31 11:25:07'),
 (700,'[14.13,13.35,12.75]',14.13,'2021-05-31 11:25:14'),
 (701,'[14.36,13.41,12.77]',14.36,'2021-05-31 11:25:19'),
 (702,'[14.86,13.54,12.82]',14.86,'2021-05-31 11:25:28'),
 (703,'[11.41,12,12.34]',12.34,'2021-05-31 12:49:31'),
 (704,'[13.04,11.94,11.72]',13.04,'2021-06-03 16:24:13'),
 (705,'[13.11,11.98,11.73]',13.11,'2021-06-03 16:24:17'),
 (706,'[14.08,14.98,14.55]',14.98,'2021-06-03 21:36:01'),
 (707,'[14.56,15.07,14.58]',15.07,'2021-06-03 21:36:03'),
 (708,'[15.09,15.15,14.62]',15.15,'2021-06-03 21:36:18'),
 (709,'[13.18,13.18,13.19]',13.19,'2021-06-03 22:41:36'),
 (710,'[13.52,13.22,13.2]',13.52,'2021-06-03 22:42:07'),
 (711,'[14.23,13.39,13.25]',14.23,'2021-06-03 22:42:31'),
 (712,'[15.01,13.57,13.31]',15.01,'2021-06-03 22:42:36'),
 (713,'[15.17,13.62,13.33]',15.17,'2021-06-03 22:42:41'),
 (714,'[15.24,13.7,13.36]',15.24,'2021-06-03 22:43:01'),
 (715,'[12.47,12.51,12.74]',12.74,'2021-06-03 23:19:24'),
 (716,'[12.68,12.55,12.75]',12.75,'2021-06-03 23:19:29'),
 (717,'[13.5,12.73,12.81]',13.5,'2021-06-03 23:19:34'),
 (718,'[9.63,9.93,9.31]',9.93,'2021-06-04 05:24:04'),
 (719,'[9.79,9.94,9.33]',9.94,'2021-06-04 05:24:26'),
 (720,'[9.89,9.96,9.34]',9.96,'2021-06-04 05:24:34'),
 (721,'[10.34,10.03,9.38]',10.34,'2021-06-04 05:25:01'),
 (722,'[10.63,10.1,9.41]',10.63,'2021-06-04 05:25:08'),
 (723,'[11.06,10.19,9.44]',11.06,'2021-06-04 05:25:14'),
 (724,'[11.54,10.31,9.48]',11.54,'2021-06-04 05:25:19'),
 (725,'[12.01,10.98,10.84]',12.01,'2021-06-04 09:27:12'),
 (726,'[12.33,10.56,10.65]',12.33,'2021-06-04 09:30:02'),
 (727,'[13.07,10.73,10.41]',13.07,'2021-06-04 09:59:04'),
 (728,'[13.14,10.79,10.43]',13.14,'2021-06-04 09:59:08'),
 (729,'[13.29,10.86,10.45]',13.29,'2021-06-04 09:59:12'),
 (730,'[11.42,10.7,10.42]',11.42,'2021-06-04 10:00:00'),
 (731,'[11.71,10.77,10.45]',11.71,'2021-06-04 10:00:04'),
 (732,'[11.81,10.81,10.46]',11.81,'2021-06-04 10:00:08'),
 (733,'[12.07,10.88,10.49]',12.07,'2021-06-04 10:00:16'),
 (734,'[12.13,10.93,10.55]',12.13,'2021-06-04 10:04:53'),
 (735,'[12.2,10.96,10.56]',12.2,'2021-06-04 10:04:56'),
 (736,'[12.65,11.16,10.64]',12.65,'2021-06-04 10:05:28'),
 (737,'[12.76,11.37,10.96]',12.76,'2021-06-04 10:35:57'),
 (738,'[13.21,11.89,11.3]',13.21,'2021-06-04 10:43:07'),
 (739,'[13.27,11.87,11.49]',13.27,'2021-06-04 10:53:15'),
 (740,'[13.85,13.08,12.68]',13.85,'2021-06-04 17:00:18'),
 (741,'[14.02,13.13,12.7]',14.02,'2021-06-04 17:00:27'),
 (742,'[14.26,13.2,12.72]',14.26,'2021-06-04 17:00:31'),
 (743,'[12.88,13.69,13.44]',13.69,'2021-06-04 18:09:22'),
 (744,'[12.54,11.68,11.2]',12.54,'2021-06-06 08:50:03'),
 (745,'[12.73,11.73,11.22]',12.73,'2021-06-06 08:50:06'),
 (746,'[12.84,11.77,11.24]',12.84,'2021-06-06 08:50:11'),
 (747,'[12.85,11.79,11.25]',12.85,'2021-06-06 08:50:15'),
 (748,'[13.1,11.86,11.27]',13.1,'2021-06-06 08:50:23'),
 (749,'[13.17,11.9,11.29]',13.17,'2021-06-06 08:50:27'),
 (750,'[9.48,9.18,9.34]',9.48,'2021-06-06 12:43:31'),
 (751,'[10.08,9.31,9.39]',10.08,'2021-06-06 12:43:33'),
 (752,'[11.56,11.22,11.03]',11.56,'2021-06-06 16:36:28'),
 (753,'[12.08,11.32,11.08]',12.08,'2021-06-06 16:38:07'),
 (754,'[12.15,11.22,11.05]',12.15,'2021-06-06 16:41:48'),
 (755,'[13.49,11.54,11.16]',13.49,'2021-06-06 16:42:04'),
 (756,'[10.24,10.43,10.76]',10.76,'2021-06-06 19:46:16'),
 (757,'[11.1,10.6,10.82]',11.1,'2021-06-06 19:46:18'),
 (758,'[11.25,10.64,10.83]',11.25,'2021-06-06 19:46:21'),
 (759,'[11.3,10.69,10.84]',11.3,'2021-06-06 19:46:57'),
 (760,'[11.75,10.8,10.87]',11.75,'2021-06-06 19:47:05'),
 (761,'[11.77,10.84,10.89]',11.77,'2021-06-06 19:47:17'),
 (762,'[11.98,10.91,10.91]',11.98,'2021-06-06 19:47:29'),
 (763,'[12.29,11.04,10.95]',12.29,'2021-06-06 19:47:49'),
 (764,'[12.42,11.08,10.96]',12.42,'2021-06-06 19:47:53'),
 (765,'[12.85,11.21,11.01]',12.85,'2021-06-06 19:48:05'),
 (766,'[13.35,12.25,11.73]',13.35,'2021-06-06 20:26:39'),
 (767,'[13.63,12.38,11.78]',13.63,'2021-06-06 20:27:05'),
 (768,'[13.98,12.47,11.82]',13.98,'2021-06-06 20:27:09'),
 (769,'[14.22,12.55,11.85]',14.22,'2021-06-06 20:27:17'),
 (770,'[14.35,12.63,11.88]',14.35,'2021-06-06 20:27:26'),
 (771,'[14.39,13.11,12.18]',14.39,'2021-06-06 20:30:18'),
 (772,'[14.52,13.16,12.2]',14.52,'2021-06-06 20:30:25'),
 (773,'[14.72,13.23,12.22]',14.72,'2021-06-06 20:30:29'),
 (774,'[14.74,13.38,12.31]',14.74,'2021-06-06 20:31:05'),
 (775,'[14.82,13.47,12.36]',14.82,'2021-06-06 20:31:25'),
 (776,'[14.91,13.52,12.38]',14.91,'2021-06-06 20:31:33'),
 (777,'[14.95,13.64,12.46]',14.95,'2021-06-06 20:32:01'),
 (778,'[15.04,13.68,12.48]',15.04,'2021-06-06 20:32:09'),
 (779,'[15.2,13.74,12.51]',15.2,'2021-06-06 20:32:13'),
 (780,'[15.26,13.78,12.53]',15.26,'2021-06-06 20:32:17'),
 (781,'[10.97,11.33,11.5]',11.5,'2021-06-06 23:54:21'),
 (782,'[11.14,11.35,11.51]',11.51,'2021-06-06 23:54:36'),
 (783,'[11.6,11.43,11.53]',11.6,'2021-06-06 23:54:46'),
 (784,'[12.07,11.54,11.57]',12.07,'2021-06-06 23:54:57'),
 (785,'[12.22,11.58,11.58]',12.22,'2021-06-06 23:55:01'),
 (786,'[12.8,11.75,11.63]',12.8,'2021-06-06 23:55:27'),
 (787,'[12.9,11.78,11.65]',12.9,'2021-06-06 23:55:33'),
 (788,'[13.15,11.85,11.67]',13.15,'2021-06-06 23:55:39'),
 (789,'[13.3,12,11.72]',13.3,'2021-06-06 23:56:09'),
 (790,'[13.38,11.84,11.65]',13.38,'2021-06-06 23:59:08'),
 (791,'[13.51,11.89,11.67]',13.51,'2021-06-06 23:59:12'),
 (792,'[12.33,11.8,11.65]',12.33,'2021-06-07 00:00:00'),
 (793,'[13.27,12,11.72]',13.27,'2021-06-07 00:00:05'),
 (794,'[13.47,13.2,13.02]',13.47,'2021-06-10 17:33:07'),
 (795,'[12.46,12.26,12.36]',12.46,'2021-06-11 07:17:11'),
 (796,'[10.67,10.89,11.59]',11.59,'2021-06-18 05:17:10'),
 (797,'[11.9,11.4,11.53]',11.9,'2021-06-20 17:45:29'),
 (798,'[12.07,11.44,11.54]',12.07,'2021-06-20 17:45:33'),
 (799,'[12.18,11.67,11.67]',12.18,'2021-06-27 17:09:26'),
 (800,'[9.98,9.98,9.87]',9.98,'2021-07-07 17:25:08'),
 (801,'[10.38,10.07,9.9]',10.38,'2021-07-07 17:25:11'),
 (802,'[10.51,10.1,9.91]',10.51,'2021-07-07 17:25:13'),
 (803,'[11.81,11.11,10.64]',11.81,'2021-07-07 17:41:35'),
 (804,'[11.97,11.17,10.67]',11.97,'2021-07-07 17:41:47'),
 (805,'[12.63,11.33,10.73]',12.63,'2021-07-07 17:42:02'),
 (806,'[9.38,10.28,10.35]',10.35,'2021-07-08 09:38:23'),
 (807,'[14.21,13.45,12.5]',14.21,'2021-07-08 14:04:20'),
 (808,'[12.45,12.57,12.49]',12.57,'2021-07-22 19:31:08'),
 (809,'[12.5,12.58,12.49]',12.58,'2021-07-22 19:31:11'),
 (810,'[12.78,12.63,12.51]',12.78,'2021-07-22 19:31:16'),
 (811,'[12.96,12.67,12.52]',12.96,'2021-07-22 19:31:24'),
 (812,'[13.36,12.76,12.55]',13.36,'2021-07-22 19:31:27'),
 (813,'[14.06,15.55,15.68]',15.68,'2021-07-22 20:47:55'),
 (814,'[14.7,15.66,15.71]',15.71,'2021-07-22 20:48:00'),
 (815,'[14.88,15.68,15.72]',15.72,'2021-07-22 20:48:05'),
 (816,'[13.85,13.41,13.72]',13.85,'2021-07-23 17:03:24');
/*!40000 ALTER TABLE `maxedu_cp_loadmax` ENABLE KEYS */;


--
-- Definition of table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `priority` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` (`id`,`module_name`,`file_name`,`parent_id`,`priority`) VALUES 
 (1,'Test Managment',NULL,0,'1'),
 (2,'Categories','cats',1,'1'),
 (3,'Quizzes','quizzes',1,'2'),
 (4,'Local users','local_users',1,'4'),
 (5,'Test Assignments',NULL,0,'2'),
 (6,'Assignments','assignments',5,'6'),
 (7,'New Assignment','add_assignment',5,'7'),
 (8,'Assignments',NULL,0,'3'),
 (9,'Active Assignments','active_assignments',8,'2'),
 (11,'New user','add_edit_user',1,'5'),
 (12,'New Quiz','add_edit_quiz',1,'3');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;


--
-- Definition of table `question_groups`
--

DROP TABLE IF EXISTS `question_groups`;
CREATE TABLE `question_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(450) NOT NULL,
  `show_header` int(11) NOT NULL,
  `group_total` decimal(18,0) NOT NULL DEFAULT '0',
  `show_footer` int(11) DEFAULT NULL,
  `check_total` decimal(18,0) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `group_name_eng` varchar(450) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_groups`
--

/*!40000 ALTER TABLE `question_groups` DISABLE KEYS */;
INSERT INTO `question_groups` (`id`,`group_name`,`show_header`,`group_total`,`show_footer`,`check_total`,`question_id`,`parent_id`,`group_name_eng`,`added_date`) VALUES 
 (1,'',0,'0',NULL,NULL,1,0,NULL,'2024-01-06 10:23:07'),
 (2,'',0,'0',NULL,NULL,2,0,NULL,'2024-01-06 10:23:07'),
 (3,'',0,'0',NULL,NULL,3,0,NULL,'2024-01-06 10:23:07'),
 (4,'',0,'0',NULL,NULL,4,0,NULL,'2024-01-06 10:23:07'),
 (5,'',0,'0',NULL,NULL,5,0,NULL,'2024-01-06 10:23:07'),
 (6,'',0,'0',NULL,NULL,6,0,NULL,'2024-01-06 10:23:07'),
 (7,'',0,'0',NULL,NULL,7,0,NULL,'2024-01-06 10:23:07'),
 (8,'',0,'0',NULL,NULL,8,0,NULL,'2024-01-06 10:23:07'),
 (9,'',0,'0',NULL,NULL,9,0,NULL,'2024-01-06 10:23:07'),
 (10,'',0,'0',NULL,NULL,10,0,NULL,'2024-01-06 10:23:07'),
 (11,'',0,'0',NULL,NULL,11,0,NULL,'2024-01-06 10:23:07'),
 (12,'',0,'0',NULL,NULL,12,0,NULL,'2024-01-06 10:23:07'),
 (13,'',0,'0',NULL,NULL,13,0,NULL,'2024-01-06 10:23:07'),
 (14,'',0,'0',NULL,NULL,14,0,NULL,'2024-01-06 10:23:07'),
 (15,'',0,'0',NULL,NULL,15,0,NULL,'2024-01-06 10:23:07'),
 (16,'',0,'0',NULL,NULL,16,0,NULL,'2024-01-06 10:23:07'),
 (17,'',0,'0',NULL,NULL,17,0,NULL,'2024-01-06 10:23:07'),
 (18,'',0,'0',NULL,NULL,18,0,NULL,'2024-01-06 10:23:07'),
 (19,'',0,'0',NULL,NULL,19,0,NULL,'2024-01-06 10:23:07'),
 (20,'',0,'0',NULL,NULL,20,0,NULL,'2024-01-06 10:23:07'),
 (21,'',0,'0',NULL,NULL,21,0,NULL,'2024-01-06 10:23:07'),
 (22,'',0,'0',NULL,NULL,22,0,NULL,'2024-01-06 10:23:07'),
 (23,'',0,'0',NULL,NULL,23,0,NULL,'2024-01-06 10:23:07'),
 (24,'',0,'0',NULL,NULL,24,0,NULL,'2024-01-06 10:23:07'),
 (25,'',0,'0',NULL,NULL,25,0,NULL,'2024-01-06 10:23:07'),
 (26,'',0,'0',NULL,NULL,26,0,NULL,'2024-01-06 10:23:07'),
 (27,'',0,'0',NULL,NULL,27,0,NULL,'2024-01-06 10:23:07'),
 (28,'',0,'0',NULL,NULL,28,0,NULL,'2024-01-06 10:23:07'),
 (29,'',0,'0',NULL,NULL,29,0,NULL,'2024-01-06 10:23:07'),
 (30,'',0,'0',NULL,NULL,30,0,NULL,'2024-01-06 10:23:07'),
 (31,'',0,'0',NULL,NULL,31,0,NULL,'2024-01-06 10:23:07'),
 (32,'',0,'0',NULL,NULL,32,0,NULL,'2024-01-06 10:23:07'),
 (33,'',0,'0',NULL,NULL,33,0,NULL,'2024-01-06 10:23:07'),
 (34,'',0,'0',NULL,NULL,34,0,NULL,'2024-01-06 10:23:07'),
 (35,'',0,'0',NULL,NULL,35,0,NULL,'2024-01-06 10:23:07'),
 (36,'',0,'0',NULL,NULL,36,0,NULL,'2024-01-06 10:23:08'),
 (37,'',0,'0',NULL,NULL,37,0,NULL,'2024-01-06 10:23:08'),
 (38,'',0,'0',NULL,NULL,38,0,NULL,'2024-01-06 10:23:08'),
 (39,'',0,'0',NULL,NULL,39,0,NULL,'2024-01-06 10:23:08'),
 (40,'',0,'0',NULL,NULL,40,0,NULL,'2024-01-06 10:23:08'),
 (41,'',0,'0',NULL,NULL,41,0,NULL,'2024-01-06 10:23:08'),
 (42,'',0,'0',NULL,NULL,42,0,NULL,'2024-01-06 10:23:08'),
 (43,'',0,'0',NULL,NULL,43,0,NULL,'2024-01-06 10:23:08'),
 (44,'',0,'0',NULL,NULL,44,0,NULL,'2024-01-06 10:23:08'),
 (45,'',0,'0',NULL,NULL,45,0,NULL,'2024-01-06 10:23:08'),
 (46,'',0,'0',NULL,NULL,46,0,NULL,'2024-01-06 10:23:08'),
 (47,'',0,'0',NULL,NULL,47,0,NULL,'2024-01-06 10:23:08'),
 (48,'',0,'0',NULL,NULL,48,0,NULL,'2024-01-06 10:23:08'),
 (49,'',0,'0',NULL,NULL,49,0,NULL,'2024-01-06 10:23:08'),
 (50,'',0,'0',NULL,NULL,50,0,NULL,'2024-01-06 10:23:08');
/*!40000 ALTER TABLE `question_groups` ENABLE KEYS */;


--
-- Definition of table `question_types`
--

DROP TABLE IF EXISTS `question_types`;
CREATE TABLE `question_types` (
  `id` int(11) NOT NULL,
  `question_type` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_types`
--

/*!40000 ALTER TABLE `question_types` DISABLE KEYS */;
INSERT INTO `question_types` (`id`,`question_type`) VALUES 
 (0,'Multi answer (checkbox)'),
 (3,'Free text (textarea)'),
 (4,'Multi text (numbers only)'),
 (1,'One answer (radio button)');
/*!40000 ALTER TABLE `question_types` ENABLE KEYS */;


--
-- Definition of table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(8000) DEFAULT NULL,
  `question_type_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `point` decimal(18,0) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int(11) NOT NULL,
  `question_total` decimal(18,0) DEFAULT NULL,
  `check_total` int(11) DEFAULT NULL,
  `header_text` varchar(1500) CHARACTER SET utf8 DEFAULT NULL,
  `footer_text` varchar(1500) CHARACTER SET utf8 DEFAULT NULL,
  `question_text_eng` varchar(1800) CHARACTER SET utf8 DEFAULT NULL,
  `help_image` varchar(550) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`id`,`question_text`,`question_type_id`,`priority`,`quiz_id`,`point`,`added_date`,`parent_id`,`question_total`,`check_total`,`header_text`,`footer_text`,`question_text_eng`,`help_image`) VALUES 
 (1,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	It is written in The Gita (a)/ that God incarnates (b)/ himself (c)/ in times of trouble. (d)/ No error (e)</div>',1,1,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (2,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	It is being rainy day, (a)/ we decided not to go out (b)/ but to stay at home (c)/ and watch a movie. (d)/ No error (e).</div>',1,2,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (3,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	The blind (a)/ deserving(b)/ our sympathy. (c)/ No error (d).</div>',1,3,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (4,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	Concurrent with his programme, (a)/ educational institutions may be urged (b)/ to inculcate patriotism (c)/ in each and every one of its pupils. (d)/ No error (e).</div>',1,4,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (5,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	She had shifted her residence (a)/ to this city to be (b)/ close with the child (c)/ she had wanted to adopt. (d)/ No error (e).</div>',1,5,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (6,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	The author&rsquo;s vision, (a)/ suffused by an innocence and warmth, (b)/ may not correspond (c)/ to the country as it is today. (d)/ No error (e).</div>',1,6,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (7,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	And though one did not (a)/ quite believe his claim, (b)/ one saw no harm (c)/ in granting him permission. (d)/ No error (e).</div>',1,7,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (8,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	When he went out (a)/ he left the radio on (b)/ so that his parents shall thought (c)/ that he was still in the house. (d)/ No error (e).</div>',1,8,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (9,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	More leisure, as well as an abundance of goods, (a)/ are attainable (b)/ through automation. (c)/ No error (d).</div>',1,9,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (10,'<div>\r\n	SPOTTING OF ERRORS (Whichever part has an error, mark that part as your answer):</div>\r\n<div>\r\n	If only (a) / did he marry her, (b) / but also he (c) / took care of her well. (d) / No error (e)</div>',1,10,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (11,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The sun had set but there was still some light in the sky. Martin <u><strong>(1)</strong></u> on his elbow and looked <u><strong>(2)</strong></u> through the leaves. In the waters of the lake, close to the shore, he saw a <u><strong>(3) </strong></u>of alligators floating quietly. One of the creatures, <u><strong>(4)</strong></u> huge one, was lying on a high <u><strong>(5)</strong></u> of sand, a few yard from the water.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(1)</strong></div>',1,11,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (12,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The sun had set but there was still some light in the sky. Martin&nbsp;<u><strong>(1)</strong></u>&nbsp;on his elbow and looked&nbsp;<u><strong>(2)</strong></u>&nbsp;through the leaves. In the waters of the lake, close to the shore, he saw a&nbsp;<u><strong>(3)&nbsp;</strong></u>of alligators floating quietly. One of the creatures,&nbsp;<u><strong>(4)</strong></u>&nbsp;huge one, was lying on a high&nbsp;<u><strong>(5)</strong></u>&nbsp;of sand, a few yard from the water.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(2)</strong></div>',1,12,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (13,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The sun had set but there was still some light in the sky. Martin&nbsp;<u><strong>(1)</strong></u>&nbsp;on his elbow and looked&nbsp;<u><strong>(2)</strong></u>&nbsp;through the leaves. In the waters of the lake, close to the shore, he saw a&nbsp;<u><strong>(3)&nbsp;</strong></u>of alligators floating quietly. One of the creatures,&nbsp;<u><strong>(4)</strong></u>&nbsp;huge one, was lying on a high&nbsp;<u><strong>(5)</strong></u>&nbsp;of sand, a few yard from the water.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(3)</strong></div>',1,13,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (14,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The sun had set but there was still some light in the sky. Martin&nbsp;<u><strong>(1)</strong></u>&nbsp;on his elbow and looked&nbsp;<u><strong>(2)</strong></u>&nbsp;through the leaves. In the waters of the lake, close to the shore, he saw a&nbsp;<u><strong>(3)&nbsp;</strong></u>of alligators floating quietly. One of the creatures,&nbsp;<u><strong>(4)</strong></u>&nbsp;huge one, was lying on a high&nbsp;<u><strong>(5)</strong></u>&nbsp;of sand, a few yard from the water.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(4)</strong></div>',1,14,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (15,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The sun had set but there was still some light in the sky. Martin&nbsp;<u><strong>(1)</strong></u>&nbsp;on his elbow and looked&nbsp;<u><strong>(2)</strong></u>&nbsp;through the leaves. In the waters of the lake, close to the shore, he saw a&nbsp;<u><strong>(3)&nbsp;</strong></u>of alligators floating quietly. One of the creatures,&nbsp;<u><strong>(4)</strong></u>&nbsp;huge one, was lying on a high&nbsp;<u><strong>(5)</strong></u>&nbsp;of sand, a few yard from the water.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(5)</strong></div>',1,15,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (16,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The <u><strong>(1)</strong></u> of Bengal tigers left in the world has <u><strong>(2)</strong></u> from 100,000 to 4,000 over the last century. The main threats are <u><strong>(3)</strong></u> of habitat, poaching and the trade in tiger parts for Eastern medicines. Most Bengal tigers live in protected areas of India. Anti-poaching task-forces have been <u><strong>(4)</strong></u> up and there is also a trade <u><strong>(5)</strong></u> on tiger products in many countries, as a measure to save this rare species.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(1)</strong></div>',1,16,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (17,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The&nbsp;<u><strong>(1)</strong></u>&nbsp;of Bengal tigers left in the world has&nbsp;<u><strong>(2)</strong></u>&nbsp;from 100,000 to 4,000 over the last century. The main threats are&nbsp;<u><strong>(3)</strong></u>&nbsp;of habitat, poaching and the trade in tiger parts for Eastern medicines. Most Bengal tigers live in protected areas of India. Anti-poaching task-forces have been&nbsp;<u><strong>(4)</strong></u>&nbsp;up and there is also a trade&nbsp;<u><strong>(5)</strong></u>&nbsp;on tiger products in many countries, as a measure to save this rare species.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(2)</strong></div>',1,17,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (18,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The&nbsp;<u><strong>(1)</strong></u>&nbsp;of Bengal tigers left in the world has&nbsp;<u><strong>(2)</strong></u>&nbsp;from 100,000 to 4,000 over the last century. The main threats are&nbsp;<u><strong>(3)</strong></u>&nbsp;of habitat, poaching and the trade in tiger parts for Eastern medicines. Most Bengal tigers live in protected areas of India. Anti-poaching task-forces have been&nbsp;<u><strong>(4)</strong></u>&nbsp;up and there is also a trade&nbsp;<u><strong>(5)</strong></u>&nbsp;on tiger products in many countries, as a measure to save this rare species.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(3)</strong></div>',1,18,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (19,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The&nbsp;<u><strong>(1)</strong></u>&nbsp;of Bengal tigers left in the world has&nbsp;<u><strong>(2)</strong></u>&nbsp;from 100,000 to 4,000 over the last century. The main threats are&nbsp;<u><strong>(3)</strong></u>&nbsp;of habitat, poaching and the trade in tiger parts for Eastern medicines. Most Bengal tigers live in protected areas of India. Anti-poaching task-forces have been&nbsp;<u><strong>(4)</strong></u>&nbsp;up and there is also a trade&nbsp;<u><strong>(5)</strong></u>&nbsp;on tiger products in many countries, as a measure to save this rare species.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(4)</strong></div>',1,19,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (20,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	CLOZE TEST:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The&nbsp;<u><strong>(1)</strong></u>&nbsp;of Bengal tigers left in the world has&nbsp;<u><strong>(2)</strong></u>&nbsp;from 100,000 to 4,000 over the last century. The main threats are&nbsp;<u><strong>(3)</strong></u>&nbsp;of habitat, poaching and the trade in tiger parts for Eastern medicines. Most Bengal tigers live in protected areas of India. Anti-poaching task-forces have been&nbsp;<u><strong>(4)</strong></u>&nbsp;up and there is also a trade&nbsp;<u><strong>(5)</strong></u>&nbsp;on tiger products in many countries, as a measure to save this rare species.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<strong>(5)</strong></div>',1,20,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (21,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	We</div>\r\n<p>\r\n	(P) agreed with</p>\r\n<p>\r\n	(Q) the manner in which you said it</p>\r\n<p>\r\n	(S) what you said</p>',1,21,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (22,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	<p>\r\n		(S1) I reasoned with him</p>\r\n	<p>\r\n		(P) but could not disabuse him</p>\r\n	<p>\r\n		(Q) that the lawyer</p>\r\n	<p>\r\n		(R) for an hour</p>\r\n	<p>\r\n		(S) of the nation</p>\r\n	(S6) who had his case in hand was incompetent.</div>\r\n<p>\r\n	&nbsp;</p>',1,22,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (23,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	<p>\r\n		(P) as environmental tools</p>\r\n	<p>\r\n		(Q) for military purposes</p>\r\n	<p>\r\n		(R) are finding various new uses</p>\r\n	(S) the world&rsquo;s fastest computers initially conceived.</div>\r\n<p>\r\n	&nbsp;</p>',1,23,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (24,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	<p>\r\n		(S1) The fact that</p>\r\n	<p>\r\n		(P) go to the police</p>\r\n	<p>\r\n		(Q) did not let him</p>\r\n	<p>\r\n		(R) to speak the truth</p>\r\n	<p>\r\n		(S) he was a murderer</p>\r\n	(S6) about the theft</div>\r\n<p>\r\n	&nbsp;</p>',1,24,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (25,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<p>\r\n	The U.S. Soyabean</p>\r\n<p>\r\n	(P) in the developing world</p>\r\n<p>\r\n	(Q) and when famine strikes</p>\r\n<p>\r\n	(R) is American&rsquo;s single most lucrative , export</p>\r\n<div>\r\n	(S) American soyabeans are a major source of high protein sustenance.</div>',1,25,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (26,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<p>\r\n	Little</p>\r\n<p>\r\n	(P) that he had been let down</p>\r\n<p>\r\n	(Q) stood by all these years</p>\r\n<p>\r\n	(R) did he realise</p>\r\n<div>\r\n	(S) by a colleague whom he had.</div>',1,26,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (27,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	<p>\r\n		Women</p>\r\n	<p>\r\n		(P) till the other day</p>\r\n	<p>\r\n		(Q) who were content being housewives</p>\r\n	<p>\r\n		(R) about spending their time cooking</p>\r\n	(S) now sound apologetic.</div>',1,27,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (28,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<p>\r\n	It has been established that</p>\r\n<p>\r\n	(P) Einstein was</p>\r\n<p>\r\n	(Q) although a great scientist</p>\r\n<p>\r\n	(R) weak in arithmetic</p>\r\n<div>\r\n	(S) right from his school days.</div>',1,28,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (29,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	<p>\r\n		Without books</p>\r\n	<p>\r\n		(P) no cultured society is possible</p>\r\n	<p>\r\n		(Q) no fresh ideas are possible</p>\r\n	<p>\r\n		(R) and</p>\r\n	(S) without fresh ideas</div>\r\n<p>\r\n	&nbsp;</p>',1,29,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (30,'<div>\r\n	ORDERING OF SENTENCES:</div>\r\n<div>\r\n	<p>\r\n		(S1) Guru Nanak evolved</p>\r\n	<p>\r\n		(P) on omnipresence of god</p>\r\n	<p>\r\n		(Q) with his simple teachings</p>\r\n	<p>\r\n		(R) a new religious outlook</p>\r\n	<p>\r\n		(S) and removal of</p>\r\n	(S6) the evil religious practices</div>',1,30,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (31,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom: 7px; text-indent: 0.5in;\">\r\n	Our ancestors had great difficulty in getting books. Now, our difficulty is what to read. There are books and books but our hours of reading are very few. Therefore, choice becomes essential. We should be very careful about what we read. There are books which poison our lives by suggesting evils. We should keep them at arm&rsquo;s length.We should read only those books which have stood the test of time. Such books are our great classics like the Ramayana and the Gita. They contain the wisdom of our sages and saints. They have appealed mankind from generation to generation. Reading of such books has ennobling influence on our mind and character. It gives us spiritual enjoyment. These books give us instruction with entertainment. They represent our ancient culture. They set before us high ideals to follow. They are our best friends, best guides and the best treasure.</div>\r\n<p>\r\n	We should be selective because</p>',1,31,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (32,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Our ancestors had great difficulty in getting books. Now, our difficulty is what to read. There are books and books but our hours of reading are very few. Therefore, choice becomes essential. We should be very careful about what we read. There are books which poison our lives by suggesting evils. We should keep them at arm&rsquo;s length.We should read only those books which have stood the test of time. Such books are our great classics like the Ramayana and the Gita. They contain the wisdom of our sages and saints. They have appealed mankind from generation to generation. Reading of such books has ennobling influence on our mind and character. It gives us spiritual enjoyment. These books give us instruction with entertainment. They represent our ancient culture. They&nbsp;<span style=\"text-indent: 0.5in;\">set before us high ideals to follow. They are our best friends, best guides and the best treasure.</span></div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	We should avoid those books which</div>',1,32,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (33,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Our ancestors had great difficulty in getting books. Now, our difficulty is what to read. There are books and books but our hours of reading are very few. Therefore, choice becomes essential. We should be very careful about what we read. There are books which poison our lives by suggesting evils. We should keep them at arm&rsquo;s length.We should read only those books which have stood the test of time. Such books are our great classics like the Ramayana and the Gita. They contain the wisdom of our sages and saints. They have appealed mankind from generation to generation. Reading of such books has ennobling influence on our mind and character. It gives us spiritual enjoyment. These books give us instruction with entertainment. They represent our ancient culture. They set before us high ideals to follow. They are our best friends, best guides and the best treasure.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	The books which have stood the test of time are called.....</div>',1,33,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (34,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Our ancestors had great difficulty in getting books. Now, our difficulty is what to read. There are books and books but our hours of reading are very few. Therefore, choice becomes essential. We should be very careful about what we read. There are books which poison our lives by suggesting evils. We should keep them at arm&rsquo;s length.We should read only those books which have stood the test of time. Such books are our great classics like the Ramayana and the Gita. They contain the wisdom of our sages and saints. They have appealed mankind from generation to generation. Reading of such books has ennobling influence on our mind and character. It gives us spiritual enjoyment. These books give us instruction with entertainment. They represent our ancient culture. They set before us high ideals to follow. They are our best friends, best guides and the best treasure.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	What is special qualityof a classic?</div>',1,34,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (35,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	<p>\r\n		Our ancestors had great difficulty in getting books. Now, our difficulty is what to read. There are books and books but our hours of reading are very few. Therefore, choice becomes essential. We should be very careful about what we read. There are books which poison our lives by suggesting evils. We should keep them at arm&rsquo;s length.We should read only those books which have stood the test of time. Such books are our great classics like the Ramayana and the Gita. They contain the wisdom of our sages and saints. They have appealed mankind from generation to generation. Reading of such books has ennobling influence on our mind and character. It gives us spiritual enjoyment. These books give us instruction with entertainment. They represent our ancient culture. They set before us high ideals to follow. They are our best friends, best guides and the best treasure.</p>\r\n</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	An expression in the passage which means a good effect is</div>',1,35,1,'1','2024-01-06 10:23:07',0,NULL,NULL,'','',NULL,NULL),
 (36,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	<p>\r\n		Some of the best known brands in the world belong to multinational companies. Generally speaking, a multinational company is one that operates in more than one country. Some economists, however, believe that a company has to operate in at least six countries to be called a multinational company. Whether these companies have helped or harmed the countries where they operate is debatable. Particularly in the third world, they are supposed to create jobs, bring in investments and facilitate technology transfer. But more often than not, their net effect is the exploitation of human and natural resources. They pay minimum wages to their employees and earn huge profits.</p>\r\n</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	The term &lsquo;natural resources&rsquo; used in the passage refers to</div>',1,36,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (37,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	<p>\r\n		Some of the best known brands in the world belong to multinational companies. Generally speaking, a multinational company is one that operates in more than one country. Some economists, however, believe that a company has to operate in at least six countries to be called a multinational company. Whether these companies have helped or harmed the countries where they operate is debatable. Particularly in the third world, they are supposed to create jobs, bring in investments and facilitate technology transfer. But more often than not, their net effect is the exploitation of human and natural resources. They pay minimum wages to their employees and earn huge profits.</p>\r\n</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	The poor countries do not gain from the presence of multinational companies because multinationals</div>',1,37,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (38,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	<p>\r\n		Some of the best known brands in the world belong to multinational companies. Generally speaking, a multinational company is one that operates in more than one country. Some economists, however, believe that a company has to operate in at least six countries to be called a multinational company. Whether these companies have helped or harmed the countries where they operate is debatable. Particularly in the third world, they are supposed to create jobs, bring in investments and facilitate technology transfer. But more often than not, their net effect is the exploitation of human and natural resources. They pay minimum wages to their employees and earn huge profits.</p>\r\n</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	According to the author, multinational companies</div>',1,38,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (39,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	<p>\r\n		Some of the best known brands in the world belong to multinational companies. Generally speaking, a multinational company is one that operates in more than one country. Some economists, however, believe that a company has to operate in at least six countries to be called a multinational company. Whether these companies have helped or harmed the countries where they operate is debatable. Particularly in the third world, they are supposed to create jobs, bring in investments and facilitate technology transfer. But more often than not, their net effect is the exploitation of human and natural resources. They pay minimum wages to their employees and earn huge profits.</p>\r\n</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	The author suggests that multinational companies</div>',1,39,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (40,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	<div>\r\n		Some of the best known brands in the world belong to multinational companies. Generally speaking, a multinational company is one that operates in more than one country. Some economists, however, believe that a company has to operate in at least six countries to be called a multinational company. Whether these companies have helped or harmed the countries where they operate is debatable. Particularly in the third world, they are supposed to create jobs, bring in investments and facilitate technology transfer. But more often than not, their net effect is the exploitation of human and natural resources. They pay minimum wages to their employees and earn huge profits.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	What does the term &lsquo;technology transfer&rsquo; mean?</div>',1,40,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (41,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Garbage is a great environment hazard. It comes from various sources&mdash;used paper, tiffin packing&rsquo;s, plastic bags, ice-cream wrappers, bottle caps, fallen leaves from trees and many more. Garbage makes the premises ugly, unkempt and breeds diseases. A lot of trash that is thrown away contain material that can be recycled and reused such as paper, metals and glass which can be sent to the nearest recycling centre or disposed of to the junk dealer. It also contains organic matter such as leaves which can enrich soil fertility. A compost pit can be made at a convenient location where the refuse can be placed with layers of soil and an occasional sprinkling of water. This would help decomposition to make valuable fertilizer. This would also prevent pollution that is usually caused by burning such organic waste.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	Garbage originates from</div>',1,41,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (42,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Garbage is a great environment hazard. It comes from various sources&mdash;used paper, tiffin packing&rsquo;s, plastic bags, ice-cream wrappers, bottle caps, fallen leaves from trees and many more. Garbage makes the premises ugly, unkempt and breeds diseases. A lot of trash that is thrown away contain material that can be recycled and reused such as paper, metals and glass which can be sent to the nearest recycling centre or disposed of to the junk dealer. It also contains organic matter such as leaves which can enrich soil fertility. A compost pit can be made at a convenient location where the refuse can be placed with layers of soil and an occasional sprinkling of water. This would help decomposition to make valuable fertilizer. This would also prevent pollution that is usually caused by burning such organic waste.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	<span style=\"font-family: &quot;Arial Narrow&quot;, sans-serif; font-size: 12pt;\">Garbage can create havoc to the mankind by</span></div>',1,42,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (43,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Garbage is a great environment hazard. It comes from various sources&mdash;used paper, tiffin packing&rsquo;s, plastic bags, ice-cream wrappers, bottle caps, fallen leaves from trees and many more. Garbage makes the premises ugly, unkempt and breeds diseases. A lot of trash that is thrown away contain material that can be recycled and reused such as paper, metals and glass which can be sent to the nearest recycling centre or disposed of to the junk dealer. It also contains organic matter such as leaves which can enrich soil fertility. A compost pit can be made at a convenient location where the refuse can be placed with layers of soil and an occasional sprinkling of water. This would help decomposition to make valuable fertilizer. This would also prevent pollution that is usually caused by burning such organic waste.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	What happens to the disposed material at the recycling centre?</div>',1,43,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (44,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Garbage is a great environment hazard. It comes from various sources&mdash;used paper, tiffin packing&rsquo;s, plastic bags, ice-cream wrappers, bottle caps, fallen leaves from trees and many more. Garbage makes the premises ugly, unkempt and breeds diseases. A lot of trash that is thrown away contain material that can be recycled and reused such as paper, metals and glass which can be sent to the nearest recycling centre or disposed of to the junk dealer. It also contains organic matter such as leaves which can enrich soil fertility. A compost pit can be made at a convenient location where the refuse can be placed with layers of soil and an occasional sprinkling of water. This would help decomposition to make valuable fertilizer. This would also prevent pollution that is usually caused by burning such organic waste.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	Fallen leaves from trees are useful because they</div>',1,44,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (45,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	Garbage is a great environment hazard. It comes from various sources&mdash;used paper, tiffin packing&rsquo;s, plastic bags, ice-cream wrappers, bottle caps, fallen leaves from trees and many more. Garbage makes the premises ugly, unkempt and breeds diseases. A lot of trash that is thrown away contain material that can be recycled and reused such as paper, metals and glass which can be sent to the nearest recycling centre or disposed of to the junk dealer. It also contains organic matter such as leaves which can enrich soil fertility. A compost pit can be made at a convenient location where the refuse can be placed with layers of soil and an occasional sprinkling of water. This would help decomposition to make valuable fertilizer. This would also prevent pollution that is usually caused by burning such organic waste.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	Which of these is correct with reference to a composite pit?</div>',1,45,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (46,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The cactus is a plant which grows in very hot, dry places. They do not have leaves. Instead, they have spiny needles which stick out of their stems. There are many shapes of the cactus. Some are small and round. Others are tall like columns or pillars. Some are shaped like tubes or bells. Some are shaped like wheels. Some grow as trees or shrubs. Others grow as ground cover. Cactus flowers are big, and some of them bloom at night. Their flowers come out at night because they are pollinated by insects or <strong>small </strong>animals that come out at night. Insects and small animals carry pollen from one cactus to another. Most cacti live in North and South America. Others live in Africa, Madagascar, and Sri Lanka. Cacti do not have very large leaves because large leaves would allow the water to evaporate. When water evaporates, it changes from a liquid to a gas. When it becomes a gas, it is light enough to move through the air. That would be bad for the cactus because the cactus <strong>requires </strong>the water to live. Some cacti have waxy coatings on their stems, so that water will run down the stem to the roots. Cacti can absorb water from fog in the air, since it does not rain very much in the desert. Most cacti have long roots which can spread out close to the surface so they can absorb a lot of water on the occasions when it rains.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	What do cacti have instead of leaves?</div>',1,46,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (47,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The cactus is a plant which grows in very hot, dry places. They do not have leaves. Instead, they have spiny needles which stick out of their stems. There are many shapes of the cactus. Some are small and round. Others are tall like columns or pillars. Some are shaped like tubes or bells. Some are shaped like wheels. Some grow as trees or shrubs. Others grow as ground cover. Cactus flowers are big, and some of them bloom at night. Their flowers come out at night because they are pollinated by insects or <strong>small </strong>animals that come out at night. Insects and small animals carry pollen from one cactus to another. Most cacti live in North and South America. Others live in Africa, Madagascar, and Sri Lanka. Cacti do not have very large leaves because large leaves would allow the water to evaporate. When water evaporates, it changes from a liquid to a gas. When it becomes a gas, it is light enough to move through the air. That would be bad for the cactus because the cactus <strong>requires </strong>the water to live. Some cacti have waxy coatings on their stems, so that water will run down the stem to the roots. Cacti can absorb water from fog in the air, since it does not rain very much in the desert. Most cacti have long roots which can spread out close to the surface so they can absorb a lot of water on the occasions when it rains.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	How are cacti shaped?</div>',1,47,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (48,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The cactus is a plant which grows in very hot, dry places. They do not have leaves. Instead, they have spiny needles which stick out of their stems. There are many shapes of the cactus. Some are small and round. Others are tall like columns or pillars. Some are shaped like tubes or bells. Some are shaped like wheels. Some grow as trees or shrubs. Others grow as ground cover. Cactus flowers are big, and some of them bloom at night. Their flowers come out at night because they are pollinated by insects or <strong>small </strong>animals that come out at night. Insects and small animals carry pollen from one cactus to another. Most cacti live in North and South America. Others live in Africa, Madagascar, and Sri Lanka. Cacti do not have very large leaves because large leaves would allow the water to evaporate. When water evaporates, it changes from a liquid to a gas. When it becomes a gas, it is light enough to move through the air. That would be bad for the cactus because the cactus <strong>requires </strong>the water to live. Some cacti have waxy coatings on their stems, so that water will run down the stem to the roots. Cacti can absorb water from fog in the air, since it does not rain very much in the desert. Most cacti have long roots which can spread out close to the surface so they can absorb a lot of water on the occasions when it rains.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	Where do most cacti grow?</div>',1,48,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (49,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The cactus is a plant which grows in very hot, dry places. They do not have leaves. Instead, they have spiny needles which stick out of their stems. There are many shapes of the cactus. Some are small and round. Others are tall like columns or pillars. Some are shaped like tubes or bells. Some are shaped like wheels. Some grow as trees or shrubs. Others grow as ground cover. Cactus flowers are big, and some of them bloom at night. Their flowers come out at night because they are pollinated by insects or <strong>small </strong>animals that come out at night. Insects and small animals carry pollen from one cactus to another. Most cacti live in North and South America. Others live in Africa, Madagascar, and Sri Lanka. Cacti do not have very large leaves because large leaves would allow the water to evaporate. When water evaporates, it changes from a liquid to a gas. When it becomes a gas, it is light enough to move through the air. That would be bad for the cactus because the cactus <strong>requires </strong>the water to live. Some cacti have waxy coatings on their stems, so that water will run down the stem to the roots. Cacti can absorb water from fog in the air, since it does not rain very much in the desert. Most cacti have long roots which can spread out close to the surface so they can absorb a lot of water on the occasions when it rains.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	Cacti prevent evaporation of water by&hellip;</div>',1,49,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL),
 (50,'<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	READING COMPREHENSION:</div>\r\n<div style=\"margin-bottom:7px;font-weight:bold;text-align:justify;\">\r\n	Passage:</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;text-align:justify;text-indent:0.5in;\">\r\n	The cactus is a plant which grows in very hot, dry places. They do not have leaves. Instead, they have spiny needles which stick out of their stems. There are many shapes of the cactus. Some are small and round. Others are tall like columns or pillars. Some are shaped like tubes or bells. Some are shaped like wheels. Some grow as trees or shrubs. Others grow as ground cover. Cactus flowers are big, and some of them bloom at night. Their flowers come out at night because they are pollinated by insects or <strong>small </strong>animals that come out at night. Insects and small animals carry pollen from one cactus to another. Most cacti live in North and South America. Others live in Africa, Madagascar, and Sri Lanka. Cacti do not have very large leaves because large leaves would allow the water to evaporate. When water evaporates, it changes from a liquid to a gas. When it becomes a gas, it is light enough to move through the air. That would be bad for the cactus because the cactus <strong>requires </strong>the water to live. Some cacti have waxy coatings on their stems, so that water will run down the stem to the roots. Cacti can absorb water from fog in the air, since it does not rain very much in the desert. Most cacti have long roots which can spread out close to the surface so they can absorb a lot of water on the occasions when it rains.</div>\r\n<div style=\"margin-bottom:7px;font-weight:normal;\">\r\n	When cacti bloom&hellip;</div>',1,50,1,'1','2024-01-06 10:23:08',0,NULL,NULL,'','',NULL,NULL);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;


--
-- Definition of table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `quiz_name` varchar(500) NOT NULL,
  `quiz_desc` varchar(500) NOT NULL,
  `added_date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  `show_intro` int(11) NOT NULL,
  `intro_text` varchar(3850) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

/*!40000 ALTER TABLE `quizzes` DISABLE KEYS */;
INSERT INTO `quizzes` (`id`,`cat_id`,`quiz_name`,`quiz_desc`,`added_date`,`parent_id`,`show_intro`,`intro_text`) VALUES 
 (1,1,'Assessment Test #002','Assessment Test #002','2024-01-06 10:23:07',0,1,'<h2><b>Test Organized by</b></h2>\n<h2 style=\"border-bottom: 1px solid #F4F5F7;margin-bottom:5px;padding-bottom:5px;\"><span style=\"color:red\">Apt Training Resources</span></h2><h2><b>Total number of questions: 50 Questions</b></h2>\n<h2><b>Maximum Time Limit: 60 minutes</b></h2>\n<p style=\"border-top: 1px solid #F4F5F7;margin-top:5px;padding-top:5px;\">\nPlease click on the <b>Continue</b> button only after reading the instructions thoroughly.</p>\n<p><b><u>Instructions:</u></b></p>\n<p>1.For every question, click the answer option &amp; then click the <b>Save</b> button to save the answer for that particular question. Clicking on the <b>Save </b>button is essential for the answer to be saved.</p>\n<p>2.Do not keep on pressing the <b>Save </b>button for the same question again &amp; again. Clicking once is enough.</p>\n<p>3.Clicking on the particular question number (available on the right side or bottom side) will take you directly to the particular question, but click it only after you have pressed the <b>Save </b>button for that question, that you are currently attending in the test.</p>\n<p>4.If after choosing the correct option, you click on the <b>Previous</b> button, instead of the <b>Save </b>button, even then answers will be saved. Don\'t worry.</p>\n<p>5.If you click the correct option and then click the <b>Question number link</b> in the right or in the bottom or if u click the <b>Instruction page link</b>, without pressing the <b>Save </b>button, answer won\'t be saved. Clicking on the <b>Save </b>button is essential for the answer to be saved.</p>\n<p>6.If you exceed the time limit for the test, the answers for which u have clicked the <b>Save </b>button alone, will automatically be saved &amp; it will take you to the home page.</p>\n<p>7.If incase u want to check the remaining time available for u any time during the test, u can scroll up, to see the timer on the right top corner.</p>\n<p>8.Once you have finished the test, click the <b>Finish</b> button available in the top right corner.</p>');
/*!40000 ALTER TABLE `quizzes` ENABLE KEYS */;


--
-- Definition of table `roles_rights`
--

DROP TABLE IF EXISTS `roles_rights`;
CREATE TABLE `roles_rights` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_rights`
--

/*!40000 ALTER TABLE `roles_rights` DISABLE KEYS */;
INSERT INTO `roles_rights` (`Id`,`role_id`,`module_id`) VALUES 
 (1,1,2),
 (2,1,3),
 (3,1,4),
 (4,1,6),
 (5,1,7),
 (12,1,12),
 (11,1,11),
 (9,2,9);
/*!40000 ALTER TABLE `roles_rights` ENABLE KEYS */;


--
-- Definition of table `t_quizzes`
--

DROP TABLE IF EXISTS `t_quizzes`;
CREATE TABLE `t_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `quiz_name` varchar(500) NOT NULL,
  `quiz_desc` varchar(500) NOT NULL,
  `added_date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  `show_intro` int(11) NOT NULL,
  `intro_text` varchar(3850) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_quizzes`
--

/*!40000 ALTER TABLE `t_quizzes` DISABLE KEYS */;
INSERT INTO `t_quizzes` (`id`,`cat_id`,`quiz_name`,`quiz_desc`,`added_date`,`parent_id`,`show_intro`,`intro_text`) VALUES 
 (1,1,'Assessment Test #002','Assessment Test #002','2021-08-05 18:02:04',0,1,'<h2>\n        <strong>Test Organized by</strong></h2>\n    <h2 style=\"border-bottom: 1px solid #F4F5F7;margin-bottom:5px;padding-bottom:5px;\">\n        <span style=\"color:red\">Apt Training Resources</span></h2>\n    <h2>\n        <strong>Total number of questions: 20 Questions</strong></h2>\n    <h2>\n        <strong>Maximum Time Limit: 60 minutes</strong></h2>\n    <p style=\"border-top: 1px solid #F4F5F7;margin-top:5px;padding-top:5px;\">\n        Please click on the&nbsp;<strong>Continue</strong>&nbsp;button only after reading the instructions thoroughly.</p>\n    <p>\n        <strong><u>Instructions:</u></strong></p>\n    <p>\n        1. For every question, click the answer option &amp; then click the&nbsp;<strong>Save</strong>&nbsp;button to save the answer for that particular question. Clicking on the&nbsp;<strong>Save </strong>button is essential for the answer to be saved.</p>\n    <p>\n        2. Do not keep on pressing the&nbsp;<strong>Save </strong>button for the same question again &amp; again. Clicking once is enough.</p>\n    <p>\n        3. Clicking on the particular question number (available on the right side or bottom side) will take you directly to the particular question, but click it only after you have pressed the&nbsp;<strong>Save </strong>button for that question, that you are currently attending in the test.&nbsp;</p>\n    <p>\n        4. If after choosing the correct option, you click on the&nbsp;<strong>Previous</strong>&nbsp;button, instead of the&nbsp;<strong>Save </strong>button, even then answers will be saved. Don&rsquo;t worry.</p>\n    <p>\n        5. If you click the correct option and then click the&nbsp;<strong>Question number link</strong>&nbsp;in the right or in the bottom or if u click the <strong>Instruction page link</strong>, without pressing the&nbsp;<strong>Save </strong>button, answer won&rsquo;t be saved. Clicking on the&nbsp;<strong>Save </strong>button is essential for the answer to be saved.</p>\n    <p>\n        6. If you exceed the time limit for the test, the answers for which u have clicked the&nbsp;<strong>Save </strong>button alone, will automatically be saved &amp; it will take you to the home page.</p>\n    <p>\n        7. If incase u want to check the remaining time available for u any time during the test, u can scroll up, to see the timer on the right top corner.</p>\n    <p>\n        8. Once you have finished the test, click the&nbsp;<strong>Finish</strong>&nbsp;button available in the top right corner.</p>\n        ');
/*!40000 ALTER TABLE `t_quizzes` ENABLE KEYS */;


--
-- Definition of table `tcode_assess_base`
--

DROP TABLE IF EXISTS `tcode_assess_base`;
CREATE TABLE `tcode_assess_base` (
  `assess_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `assignment_name` varchar(250) NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `total_q` int(10) unsigned NOT NULL DEFAULT '1',
  `total_score` int(10) unsigned NOT NULL DEFAULT '3',
  `total_duration` int(10) unsigned NOT NULL DEFAULT '30',
  `duration_per` int(10) unsigned NOT NULL DEFAULT '1',
  `max_submissions` int(10) unsigned NOT NULL DEFAULT '1',
  `is_to_suffle_q` tinyint(1) NOT NULL DEFAULT '1',
  `assignment_status` int(10) unsigned NOT NULL DEFAULT '0',
  `instructions` varchar(8000) NOT NULL DEFAULT ' ',
  `max_runs` int(10) unsigned NOT NULL DEFAULT '3',
  PRIMARY KEY (`assess_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_assess_base`
--

/*!40000 ALTER TABLE `tcode_assess_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_assess_base` ENABLE KEYS */;


--
-- Definition of table `tcode_assess_submit_q`
--

DROP TABLE IF EXISTS `tcode_assess_submit_q`;
CREATE TABLE `tcode_assess_submit_q` (
  `submit_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `assess_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `user_program` longtext NOT NULL,
  `q_secure_score` int(10) unsigned NOT NULL DEFAULT '0',
  `q_status` int(10) unsigned NOT NULL DEFAULT '0',
  `submit_no` int(10) unsigned NOT NULL DEFAULT '1',
  `test_cases_haverun` int(10) unsigned NOT NULL DEFAULT '0',
  `number_of_runs` int(10) unsigned NOT NULL DEFAULT '0',
  `number_of_submits` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`submit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_assess_submit_q`
--

/*!40000 ALTER TABLE `tcode_assess_submit_q` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_assess_submit_q` ENABLE KEYS */;


--
-- Definition of table `tcode_assess_submit_testcase`
--

DROP TABLE IF EXISTS `tcode_assess_submit_testcase`;
CREATE TABLE `tcode_assess_submit_testcase` (
  `submit_id` bigint(20) unsigned NOT NULL,
  `assess_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `testcase_id` bigint(20) unsigned NOT NULL,
  `user_output` varchar(2000) NOT NULL DEFAULT ' ',
  `case_status` int(10) unsigned NOT NULL DEFAULT '0',
  `testcase_secure_score` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`submit_id`,`testcase_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_assess_submit_testcase`
--

/*!40000 ALTER TABLE `tcode_assess_submit_testcase` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_assess_submit_testcase` ENABLE KEYS */;


--
-- Definition of table `tcode_assess_user`
--

DROP TABLE IF EXISTS `tcode_assess_user`;
CREATE TABLE `tcode_assess_user` (
  `assess_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_ass_status` int(10) unsigned NOT NULL DEFAULT '0',
  `user_secure_score` int(10) unsigned NOT NULL DEFAULT '0',
  `ass_start_date` datetime DEFAULT NULL,
  `ass_finish_date` datetime DEFAULT NULL,
  PRIMARY KEY (`assess_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_assess_user`
--

/*!40000 ALTER TABLE `tcode_assess_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_assess_user` ENABLE KEYS */;


--
-- Definition of table `tcode_language`
--

DROP TABLE IF EXISTS `tcode_language`;
CREATE TABLE `tcode_language` (
  `lang_code` varchar(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `api_lang_name` varchar(100) NOT NULL,
  `api_version_no` varchar(100) NOT NULL,
  `default_program` varchar(1000) NOT NULL DEFAULT '#include<stdio.h>\r\nint main(){\r\n\r\n  return 0;\r\n}',
  PRIMARY KEY (`lang_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_language`
--

/*!40000 ALTER TABLE `tcode_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_language` ENABLE KEYS */;


--
-- Definition of table `tcode_level`
--

DROP TABLE IF EXISTS `tcode_level`;
CREATE TABLE `tcode_level` (
  `level_no` int(10) unsigned NOT NULL,
  `level_name` varchar(100) NOT NULL,
  PRIMARY KEY (`level_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_level`
--

/*!40000 ALTER TABLE `tcode_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_level` ENABLE KEYS */;


--
-- Definition of table `tcode_q_base`
--

DROP TABLE IF EXISTS `tcode_q_base`;
CREATE TABLE `tcode_q_base` (
  `question_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_title` varchar(200) NOT NULL DEFAULT ' ',
  `code_question` varchar(8000) NOT NULL DEFAULT ' ',
  `lang_code` varchar(10) NOT NULL DEFAULT 'c',
  `level_no` int(10) unsigned NOT NULL DEFAULT '2',
  `tested_program` longtext,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_q_base`
--

/*!40000 ALTER TABLE `tcode_q_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_q_base` ENABLE KEYS */;


--
-- Definition of table `tcode_q_group_base`
--

DROP TABLE IF EXISTS `tcode_q_group_base`;
CREATE TABLE `tcode_q_group_base` (
  `group_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(250) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_q_group_base`
--

/*!40000 ALTER TABLE `tcode_q_group_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_q_group_base` ENABLE KEYS */;


--
-- Definition of table `tcode_q_group_q`
--

DROP TABLE IF EXISTS `tcode_q_group_q`;
CREATE TABLE `tcode_q_group_q` (
  `group_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`group_id`,`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_q_group_q`
--

/*!40000 ALTER TABLE `tcode_q_group_q` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_q_group_q` ENABLE KEYS */;


--
-- Definition of table `tcode_q_testcase`
--

DROP TABLE IF EXISTS `tcode_q_testcase`;
CREATE TABLE `tcode_q_testcase` (
  `testcase_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) unsigned NOT NULL,
  `input` varchar(2000) NOT NULL DEFAULT ' ',
  `output` varchar(2000) NOT NULL DEFAULT ' ',
  `point` int(10) unsigned NOT NULL DEFAULT '1',
  `sno` int(10) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`testcase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcode_q_testcase`
--

/*!40000 ALTER TABLE `tcode_q_testcase` DISABLE KEYS */;
/*!40000 ALTER TABLE `tcode_q_testcase` ENABLE KEYS */;


--
-- Definition of table `user_answers`
--

DROP TABLE IF EXISTS `user_answers`;
CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `user_answer_id` int(11) DEFAULT NULL,
  `user_answer_text` varchar(3800) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_answers`
--

/*!40000 ALTER TABLE `user_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_answers` ENABLE KEYS */;


--
-- Definition of table `user_quizzes`
--

DROP TABLE IF EXISTS `user_quizzes`;
CREATE TABLE `user_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `success` int(11) DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `pass_score_point` decimal(10,2) DEFAULT NULL,
  `pass_score_perc` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_quizzes`
--

/*!40000 ALTER TABLE `user_quizzes` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_quizzes` ENABLE KEYS */;


--
-- Definition of table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_types`
--

/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` (`id`,`type_name`) VALUES 
 (1,'Admin'),
 (2,'User');
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Surname` varchar(150) NOT NULL,
  `added_date` datetime NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`UserID`,`UserName`,`Password`,`Name`,`Surname`,`added_date`,`user_type`,`email`) VALUES 
 (1,'admin','baf71c021073a99609d073b6c7d2162a','admin','admin','2011-10-27 12:02:06',1,'admin'),
 (2,'APT01','486ec94022de2ba84a97e76c60e6dd89','APT01','','0000-00-00 00:00:00',NULL,NULL),
 (3,'APT02','486ec94022de2ba84a97e76c60e6dd89','APT02','','0000-00-00 00:00:00',NULL,NULL),
 (4,'APT03','486ec94022de2ba84a97e76c60e6dd89','APT03','','0000-00-00 00:00:00',NULL,NULL),
 (5,'APT04','486ec94022de2ba84a97e76c60e6dd89','APT04','','0000-00-00 00:00:00',NULL,NULL),
 (6,'APT05','486ec94022de2ba84a97e76c60e6dd89','APT05','','0000-00-00 00:00:00',NULL,NULL),
 (7,'APT06','486ec94022de2ba84a97e76c60e6dd89','APT06','','0000-00-00 00:00:00',NULL,NULL),
 (8,'APT07','486ec94022de2ba84a97e76c60e6dd89','APT07','','0000-00-00 00:00:00',NULL,NULL),
 (9,'APT08','486ec94022de2ba84a97e76c60e6dd89','APT08','','0000-00-00 00:00:00',NULL,NULL),
 (10,'APT09','486ec94022de2ba84a97e76c60e6dd89','APT09','','0000-00-00 00:00:00',NULL,NULL),
 (11,'APT10','486ec94022de2ba84a97e76c60e6dd89','APT10','','0000-00-00 00:00:00',NULL,NULL),
 (12,'APT11','486ec94022de2ba84a97e76c60e6dd89','APT11','','0000-00-00 00:00:00',NULL,NULL),
 (13,'APT12','486ec94022de2ba84a97e76c60e6dd89','APT12','','0000-00-00 00:00:00',NULL,NULL),
 (14,'APT13','486ec94022de2ba84a97e76c60e6dd89','APT13','','0000-00-00 00:00:00',NULL,NULL),
 (15,'APT14','486ec94022de2ba84a97e76c60e6dd89','APT14','','0000-00-00 00:00:00',NULL,NULL),
 (16,'APT15','486ec94022de2ba84a97e76c60e6dd89','APT15','','0000-00-00 00:00:00',NULL,NULL),
 (17,'APT16','486ec94022de2ba84a97e76c60e6dd89','APT16','','0000-00-00 00:00:00',NULL,NULL),
 (18,'APT17','486ec94022de2ba84a97e76c60e6dd89','APT17','','0000-00-00 00:00:00',NULL,NULL),
 (19,'APT18','486ec94022de2ba84a97e76c60e6dd89','APT18','','0000-00-00 00:00:00',NULL,NULL),
 (20,'APT19','486ec94022de2ba84a97e76c60e6dd89','APT19','','0000-00-00 00:00:00',NULL,NULL),
 (21,'APT20','486ec94022de2ba84a97e76c60e6dd89','APT20','','0000-00-00 00:00:00',NULL,NULL),
 (22,'APT21','486ec94022de2ba84a97e76c60e6dd89','APT21','','0000-00-00 00:00:00',NULL,NULL),
 (23,'APT22','486ec94022de2ba84a97e76c60e6dd89','APT22','','0000-00-00 00:00:00',NULL,NULL),
 (24,'APT23','486ec94022de2ba84a97e76c60e6dd89','APT23','','0000-00-00 00:00:00',NULL,NULL),
 (25,'APT24','486ec94022de2ba84a97e76c60e6dd89','APT24','','0000-00-00 00:00:00',NULL,NULL),
 (26,'APT25','486ec94022de2ba84a97e76c60e6dd89','APT25','','0000-00-00 00:00:00',NULL,NULL),
 (27,'DEVELOPER01','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER01','','0000-00-00 00:00:00',NULL,NULL),
 (28,'DEVELOPER02','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER02','','0000-00-00 00:00:00',NULL,NULL),
 (29,'DEVELOPER03','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER03','','0000-00-00 00:00:00',NULL,NULL),
 (30,'DEVELOPER04','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER04','','0000-00-00 00:00:00',NULL,NULL),
 (31,'DEVELOPER05','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER05','','0000-00-00 00:00:00',NULL,NULL),
 (32,'DEVELOPER06','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER06','','0000-00-00 00:00:00',NULL,NULL),
 (33,'DEVELOPER07','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER07','','0000-00-00 00:00:00',NULL,NULL),
 (34,'DEVELOPER08','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER08','','0000-00-00 00:00:00',NULL,NULL),
 (35,'DEVELOPER09','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER09','','0000-00-00 00:00:00',NULL,NULL),
 (36,'DEVELOPER10','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER10','','0000-00-00 00:00:00',NULL,NULL),
 (37,'DEVELOPER11','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER11','','0000-00-00 00:00:00',NULL,NULL),
 (38,'DEVELOPER12','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER12','','0000-00-00 00:00:00',NULL,NULL),
 (39,'DEVELOPER13','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER13','','0000-00-00 00:00:00',NULL,NULL),
 (40,'DEVELOPER14','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER14','','0000-00-00 00:00:00',NULL,NULL),
 (41,'DEVELOPER15','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER15','','0000-00-00 00:00:00',NULL,NULL),
 (42,'DEVELOPER16','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER16','','0000-00-00 00:00:00',NULL,NULL),
 (43,'DEVELOPER17','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER17','','0000-00-00 00:00:00',NULL,NULL),
 (44,'DEVELOPER18','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER18','','0000-00-00 00:00:00',NULL,NULL),
 (45,'DEVELOPER19','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER19','','0000-00-00 00:00:00',NULL,NULL),
 (46,'DEVELOPER20','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER20','','0000-00-00 00:00:00',NULL,NULL),
 (47,'DEVELOPER21','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER21','','0000-00-00 00:00:00',NULL,NULL),
 (48,'DEVELOPER22','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER22','','0000-00-00 00:00:00',NULL,NULL),
 (49,'DEVELOPER23','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER23','','0000-00-00 00:00:00',NULL,NULL),
 (50,'DEVELOPER24','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER24','','0000-00-00 00:00:00',NULL,NULL),
 (51,'DEVELOPER25','7b7a53e239400a13bd6be6c91c4f6c4e','DEVELOPER25','','0000-00-00 00:00:00',NULL,NULL),
 (52,'SERVER01','da941ba5e4989ca468e0af6e0645a715','SERVER01','','0000-00-00 00:00:00',NULL,NULL),
 (53,'SERVER02','da941ba5e4989ca468e0af6e0645a715','SERVER02','','0000-00-00 00:00:00',NULL,NULL),
 (54,'SERVER03','da941ba5e4989ca468e0af6e0645a715','SERVER03','','0000-00-00 00:00:00',NULL,NULL),
 (55,'SERVER04','da941ba5e4989ca468e0af6e0645a715','SERVER04','','0000-00-00 00:00:00',NULL,NULL),
 (56,'SERVER05','da941ba5e4989ca468e0af6e0645a715','SERVER05','','0000-00-00 00:00:00',NULL,NULL),
 (57,'SERVER06','da941ba5e4989ca468e0af6e0645a715','SERVER06','','0000-00-00 00:00:00',NULL,NULL),
 (58,'SERVER07','da941ba5e4989ca468e0af6e0645a715','SERVER07','','0000-00-00 00:00:00',NULL,NULL),
 (59,'SERVER08','da941ba5e4989ca468e0af6e0645a715','SERVER08','','0000-00-00 00:00:00',NULL,NULL),
 (60,'SERVER09','da941ba5e4989ca468e0af6e0645a715','SERVER09','','0000-00-00 00:00:00',NULL,NULL),
 (61,'SERVER10','da941ba5e4989ca468e0af6e0645a715','SERVER10','','0000-00-00 00:00:00',NULL,NULL),
 (62,'SERVER11','da941ba5e4989ca468e0af6e0645a715','SERVER11','','0000-00-00 00:00:00',NULL,NULL),
 (63,'SERVER12','da941ba5e4989ca468e0af6e0645a715','SERVER12','','0000-00-00 00:00:00',NULL,NULL),
 (64,'SERVER13','da941ba5e4989ca468e0af6e0645a715','SERVER13','','0000-00-00 00:00:00',NULL,NULL),
 (65,'SERVER14','da941ba5e4989ca468e0af6e0645a715','SERVER14','','0000-00-00 00:00:00',NULL,NULL),
 (66,'SERVER15','da941ba5e4989ca468e0af6e0645a715','SERVER15','','0000-00-00 00:00:00',NULL,NULL),
 (67,'SERVER16','da941ba5e4989ca468e0af6e0645a715','SERVER16','','0000-00-00 00:00:00',NULL,NULL),
 (68,'SERVER17','da941ba5e4989ca468e0af6e0645a715','SERVER17','','0000-00-00 00:00:00',NULL,NULL),
 (69,'SERVER18','da941ba5e4989ca468e0af6e0645a715','SERVER18','','0000-00-00 00:00:00',NULL,NULL),
 (70,'SERVER19','da941ba5e4989ca468e0af6e0645a715','SERVER19','','0000-00-00 00:00:00',NULL,NULL),
 (71,'SERVER20','da941ba5e4989ca468e0af6e0645a715','SERVER20','','0000-00-00 00:00:00',NULL,NULL),
 (72,'SERVER21','da941ba5e4989ca468e0af6e0645a715','SERVER21','','0000-00-00 00:00:00',NULL,NULL),
 (73,'SERVER22','da941ba5e4989ca468e0af6e0645a715','SERVER22','','0000-00-00 00:00:00',NULL,NULL),
 (74,'SERVER23','da941ba5e4989ca468e0af6e0645a715','SERVER23','','0000-00-00 00:00:00',NULL,NULL),
 (75,'SERVER24','da941ba5e4989ca468e0af6e0645a715','SERVER24','','0000-00-00 00:00:00',NULL,NULL),
 (76,'SERVER25','da941ba5e4989ca468e0af6e0645a715','SERVER25','','0000-00-00 00:00:00',NULL,NULL),
 (77,'TN301','189d5d127eab50c883b98fd2c112300a','TN301','','0000-00-00 00:00:00',NULL,NULL),
 (78,'TN302','d13f8f9d58a6871694136192ca253cdf','TN302','','0000-00-00 00:00:00',NULL,NULL),
 (79,'TN303','0ed36a9d56e045cdd796cbb460e4d269','TN303','','0000-00-00 00:00:00',NULL,NULL),
 (80,'TN304','93335e44fdf74a01eb21674b13fac4ec','TN304','','0000-00-00 00:00:00',NULL,NULL),
 (81,'TN305','3a6cead0e7b0fd88ba40ad6fdcac9a9a','TN305','','0000-00-00 00:00:00',NULL,NULL),
 (82,'TN306','2981a04f6739523aed8804ac17fc3779','TN306','','0000-00-00 00:00:00',NULL,NULL),
 (83,'TN307','17aa636e67223125b41abb0bd9f70bad','TN307','','0000-00-00 00:00:00',NULL,NULL),
 (84,'TN308','eebcb2230f618f9e4a681c61c15464ab','TN308','','0000-00-00 00:00:00',NULL,NULL),
 (85,'TN309','7ccd6661149100921072249667c1b69e','TN309','','0000-00-00 00:00:00',NULL,NULL),
 (86,'TN310','cf20c8df4b38b157704683cd7d5dea5a','TN310','','0000-00-00 00:00:00',NULL,NULL),
 (87,'TN311','996223a22f2712629435fd61f5a456fa','TN311','','0000-00-00 00:00:00',NULL,NULL),
 (88,'TN312','717709ffafdd164919e1cc509c1b4138','TN312','','0000-00-00 00:00:00',NULL,NULL),
 (89,'TN313','fad8759e818a9a9f617e002613876c33','TN313','','0000-00-00 00:00:00',NULL,NULL),
 (90,'TN314','e5754b57c4980b5dd252d11de99430ec','TN314','','0000-00-00 00:00:00',NULL,NULL),
 (91,'TN315','669a2e64203980c5cad828c7e80d22e0','TN315','','0000-00-00 00:00:00',NULL,NULL),
 (92,'TN316','626a2d5e68f15d8ecbb2d578e2ccdb2f','TN316','','0000-00-00 00:00:00',NULL,NULL),
 (93,'TN317','3f90791b587412bd52b6a6fdfeeac0b6','TN317','','0000-00-00 00:00:00',NULL,NULL),
 (94,'TN318','b2e691fa88b6b69790bf95f5eaa790ff','TN318','','0000-00-00 00:00:00',NULL,NULL),
 (95,'TN319','a3544776768790d74abb475699fb3ff0','TN319','','0000-00-00 00:00:00',NULL,NULL),
 (96,'TN320','6dc36b2fe25bf0c1bc8a029d1eda7d84','TN320','','0000-00-00 00:00:00',NULL,NULL),
 (97,'TN321','84d92e7b541bc5c42b5acb3d9c9f5dbd','TN321','','0000-00-00 00:00:00',NULL,NULL),
 (98,'TN322','3a45f4b1337b39ea5e73b920170d1fce','TN322','','0000-00-00 00:00:00',NULL,NULL),
 (99,'TN323','255bfa8feccb7b3d74fefdf77a21ee83','TN323','','0000-00-00 00:00:00',NULL,NULL),
 (100,'TN324','25440373b91a38a0aee188c687af9579','TN324','','0000-00-00 00:00:00',NULL,NULL),
 (101,'TN325','15b70350e1143ade37021ce7e3e5ab8b','TN325','','0000-00-00 00:00:00',NULL,NULL),
 (102,'TN326','ab991b6b8d5f9c265e2c2c63ced22b05','TN326','','0000-00-00 00:00:00',NULL,NULL),
 (103,'TN327','2a808bbbdc3e620cf3956db9b5459b15','TN327','','0000-00-00 00:00:00',NULL,NULL),
 (104,'TN328','97098f008557243534858173b7b3b818','TN328','','0000-00-00 00:00:00',NULL,NULL),
 (105,'TN329','dbb4a8b06233d0f03dfc4efd36432a05','TN329','','0000-00-00 00:00:00',NULL,NULL),
 (106,'TN330','27a63de15e469e88fbd37ba838bf9571','TN330','','0000-00-00 00:00:00',NULL,NULL),
 (107,'TN331','8d1ac699f7b6787ce5ac5654f2f815b2','TN331','','0000-00-00 00:00:00',NULL,NULL),
 (108,'TN332','d47cb39fb0bdaf8de58866bdffb75093','TN332','','0000-00-00 00:00:00',NULL,NULL),
 (109,'TN333','8123fb880bcc34226f86cd37b7ccab49','TN333','','0000-00-00 00:00:00',NULL,NULL),
 (110,'TN334','bfb1abe7b3cc7ddb0ebf418494fef8cb','TN334','','0000-00-00 00:00:00',NULL,NULL),
 (111,'TN335','3fcd77ca7043240db9f00862884d49de','TN335','','0000-00-00 00:00:00',NULL,NULL),
 (112,'TN336','33b4bad72b320f75f8a91904a78ae1f1','TN336','','0000-00-00 00:00:00',NULL,NULL),
 (113,'TN337','f691f2c169647c3d3a3e7b45e278a6bc','TN337','','0000-00-00 00:00:00',NULL,NULL),
 (114,'TN338','e70013a82793b896ae2212b73874a7f3','TN338','','0000-00-00 00:00:00',NULL,NULL),
 (115,'TN339','26afda222570decc013e9f68d3770b15','TN339','','0000-00-00 00:00:00',NULL,NULL),
 (116,'TN340','9b099388d7e8d615de4ba31421a59895','TN340','','0000-00-00 00:00:00',NULL,NULL),
 (117,'TN341','26ca9203f964e91b8e41b34f5d6b822b','TN341','','0000-00-00 00:00:00',NULL,NULL),
 (118,'TN342','d2e0f774a67ed88b8117e5564b1ba266','TN342','','0000-00-00 00:00:00',NULL,NULL),
 (119,'TN343','b59af31542ca56c41ed5fbc0914d3bdb','TN343','','0000-00-00 00:00:00',NULL,NULL),
 (120,'TN344','465780799677491dbafb73b8a0079a0c','TN344','','0000-00-00 00:00:00',NULL,NULL),
 (121,'TN345','ac6d8eb56782b4ba6bbbdfc91a120632','TN345','','0000-00-00 00:00:00',NULL,NULL),
 (122,'TN346','ddaa477c30eed9f64ab53eb4b5c27344','TN346','','0000-00-00 00:00:00',NULL,NULL),
 (123,'TN347','c757766a0ca032931faca64e1de06c49','TN347','','0000-00-00 00:00:00',NULL,NULL),
 (124,'TN348','d4e6bdb4d18acd6aca074952f8770b95','TN348','','0000-00-00 00:00:00',NULL,NULL),
 (125,'TN349','61361cb619953239c2de62af77f71ffe','TN349','','0000-00-00 00:00:00',NULL,NULL),
 (126,'TN350','cd73ba8ec83cc6ef519638a95271e1ab','TN350','','0000-00-00 00:00:00',NULL,NULL),
 (127,'TN351','42151998d375134e9f217cfb721c9a9a','TN351','','0000-00-00 00:00:00',NULL,NULL),
 (128,'TN352','55d019ea6e4ae1606c974a57814e79b2','TN352','','0000-00-00 00:00:00',NULL,NULL),
 (129,'TN353','84624266686267edc022d9ed6ab8c597','TN353','','0000-00-00 00:00:00',NULL,NULL),
 (130,'TN354','fd91e74e0dc84ce92037b00279725a28','TN354','','0000-00-00 00:00:00',NULL,NULL),
 (131,'TN355','5f99402d9792a0abcfccef55ceff7aac','TN355','','0000-00-00 00:00:00',NULL,NULL),
 (132,'TN356','afd9d537eb4081c44efcd256803205a0','TN356','','0000-00-00 00:00:00',NULL,NULL),
 (133,'TN357','362eaff5c3c68b33d0c6e783092873b1','TN357','','0000-00-00 00:00:00',NULL,NULL),
 (134,'TN358','61d20ea16f75257f694e02384010dbda','TN358','','0000-00-00 00:00:00',NULL,NULL),
 (135,'TN359','62fb64e704de1cba09b00beea42c4a3e','TN359','','0000-00-00 00:00:00',NULL,NULL),
 (136,'TN360','1c6ffa4bae953096cb57dbd8d00c3497','TN360','','0000-00-00 00:00:00',NULL,NULL),
 (137,'TN361','9c135812b9b26ac2565dcaf3aa3abb06','TN361','','0000-00-00 00:00:00',NULL,NULL),
 (138,'TN362','f30c385ae7d7dac336d93347359ad0f2','TN362','','0000-00-00 00:00:00',NULL,NULL),
 (139,'TN363','48080cf20e06bc7c32be2fb157a079bd','TN363','','0000-00-00 00:00:00',NULL,NULL),
 (140,'TN364','700eb82b6e2db8a7f1b469b57fe870f4','TN364','','0000-00-00 00:00:00',NULL,NULL),
 (141,'TN365','77c21f4dda3be6a40eb67e34041e50b0','TN365','','0000-00-00 00:00:00',NULL,NULL),
 (142,'TN366','11a8ad255c57b8887ddd1ff1941db139','TN366','','0000-00-00 00:00:00',NULL,NULL),
 (143,'TN367','e4184c1608164bb30fe7b6dc4715bc98','TN367','','0000-00-00 00:00:00',NULL,NULL),
 (144,'TN368','c0a3c4daa9e8c9c23b3463c8c3519ad4','TN368','','0000-00-00 00:00:00',NULL,NULL),
 (145,'TN369','8069207a38c62d8ad372c8b2076f3ad5','TN369','','0000-00-00 00:00:00',NULL,NULL),
 (146,'TN370','89c012234ee44d83aef477686f4de353','TN370','','0000-00-00 00:00:00',NULL,NULL),
 (147,'TN371','b5446dd6cb1f898edcafa6cc2c4cd145','TN371','','0000-00-00 00:00:00',NULL,NULL),
 (148,'TN372','96d619d7467be0e161108441a2bcbdcb','TN372','','0000-00-00 00:00:00',NULL,NULL),
 (149,'TN373','f47fa2d0a2e73302a2d729dcaff8dd7f','TN373','','0000-00-00 00:00:00',NULL,NULL),
 (150,'TN374','84b684d2ef7c1da8fa23177f38b5f688','TN374','','0000-00-00 00:00:00',NULL,NULL),
 (151,'TN375','b1e688b9261964947bc5c4d6e5126079','TN375','','0000-00-00 00:00:00',NULL,NULL),
 (152,'TN376','8564efbceda78d4419e52d4cf432f11d','TN376','','0000-00-00 00:00:00',NULL,NULL),
 (153,'TN377','09b030dc6e9f533797cdf4f692b9fe45','TN377','','0000-00-00 00:00:00',NULL,NULL),
 (154,'TN378','c8ef19c97d44fe6322ab83e60a0e6c0a','TN378','','0000-00-00 00:00:00',NULL,NULL),
 (155,'TN379','59fbbc2db85518ab0f7ea4cf32cb0c9a','TN379','','0000-00-00 00:00:00',NULL,NULL),
 (156,'TN380','3111570fb99f74c654ec6afda707f452','TN380','','0000-00-00 00:00:00',NULL,NULL),
 (157,'TN381','ec8e5d000b389efc43fd960990fac5fe','TN381','','0000-00-00 00:00:00',NULL,NULL),
 (158,'TN382','74153050084b1112ba1bf07c8d8251b9','TN382','','0000-00-00 00:00:00',NULL,NULL),
 (159,'TN383','75a24ddf90130240660c6b6bb1b282fd','TN383','','0000-00-00 00:00:00',NULL,NULL),
 (160,'TN384','000ea5540fa85f862b02bb1a23c72837','TN384','','0000-00-00 00:00:00',NULL,NULL),
 (161,'TN385','6542a42f0f042eb3f632b5807f673184','TN385','','0000-00-00 00:00:00',NULL,NULL),
 (162,'TN386','7ba12f6828533ae175a986b13e44206d','TN386','','0000-00-00 00:00:00',NULL,NULL),
 (163,'TN387','6e513e1bd3ad84a93015b33fcf670dd1','TN387','','0000-00-00 00:00:00',NULL,NULL),
 (164,'TN388','3611736f9c9188a7c1a016ea70aff199','TN388','','0000-00-00 00:00:00',NULL,NULL),
 (165,'TN389','fc0db063a9ef6b6939da4b1d5c0083fd','TN389','','0000-00-00 00:00:00',NULL,NULL),
 (166,'TN390','d6facf7b0a4aa67d9e104134c34a75c0','TN390','','0000-00-00 00:00:00',NULL,NULL),
 (167,'TN391','89dff14720e9f9568f7a2c146f8fcf8c','TN391','','0000-00-00 00:00:00',NULL,NULL),
 (168,'TN392','63db5f41f54aba1bf3089a0a3abe9f4e','TN392','','0000-00-00 00:00:00',NULL,NULL),
 (169,'TN393','7acd6f620726b18c16c0fd4da9f87824','TN393','','0000-00-00 00:00:00',NULL,NULL),
 (170,'TN394','1aeac4cbe770ca8aa432899ee7ba44b9','TN394','','0000-00-00 00:00:00',NULL,NULL),
 (171,'TN395','15025dacdcc69742416047d21292b277','TN395','','0000-00-00 00:00:00',NULL,NULL),
 (172,'TN396','0e2c53f7583fc3704aff9f9073e35891','TN396','','0000-00-00 00:00:00',NULL,NULL),
 (173,'TN397','9822dafb6c8b70646705715bbacf239a','TN397','','0000-00-00 00:00:00',NULL,NULL),
 (174,'TN398','9d3767fef8f5a8a12b057fbb9a3bdfd6','TN398','','0000-00-00 00:00:00',NULL,NULL),
 (175,'TN399','3564785ff4d5a796534aa1db110d539f','TN399','','0000-00-00 00:00:00',NULL,NULL),
 (176,'TN400','b906d07f035d4f5172ee7e15a49a0e75','TN400','','0000-00-00 00:00:00',NULL,NULL),
 (177,'A1','4e8615c8b214cd99d9f57e93e40762ce','KAVIPRIYA S','','0000-00-00 00:00:00',NULL,NULL),
 (178,'A2','ce177ef485e815eb711229db2a39801d','ROHITH TM','','0000-00-00 00:00:00',NULL,NULL),
 (179,'A3','0d5c052e29d7506a9d60474dd74e5a15','Kolluri Sravan Kumar','','0000-00-00 00:00:00',NULL,NULL),
 (180,'A4','df78549eeecc4b7dacf9fa753e789a77','Varshana AJ','','0000-00-00 00:00:00',NULL,NULL),
 (181,'A5','8b7829a2a1fa6239bce583a8fcb8881c','Suvathi Sukanyaa K','','0000-00-00 00:00:00',NULL,NULL),
 (182,'A6','ec29f1cfaf69eeb5ec64f2615e8139e8','Akash Kundkar','','0000-00-00 00:00:00',NULL,NULL),
 (183,'A7','244ae075f714f0069c05d15ab1a3b7e4','Ritika Ghosh','','0000-00-00 00:00:00',NULL,NULL),
 (184,'A8','3d029b2522806af74b5ad974f45bb784','Bhosale Aarti Ramrao','','0000-00-00 00:00:00',NULL,NULL),
 (185,'A9','9a96a70badedaa699c4d74515c74cd1a','JOTHIKA S','','0000-00-00 00:00:00',NULL,NULL),
 (186,'A10','67dc39aebe5c7a23b1f6e6f85c36de1a','GUNAL P','','0000-00-00 00:00:00',NULL,NULL),
 (187,'A11','5f9b4e52a0062b6d8f897727d1b456d8','Gayathri K','','0000-00-00 00:00:00',NULL,NULL),
 (188,'A12','47524b814bc821e77ddd1700ae9507d8','KANTHI VIKRAM','','0000-00-00 00:00:00',NULL,NULL),
 (189,'A13','b20a38369f69f54bdad08ce7f6ef6689','Ravichandru T','','0000-00-00 00:00:00',NULL,NULL),
 (190,'A14','d78b8d43711b1cc2e086a1ba60cfb1e5','Akila.C','','0000-00-00 00:00:00',NULL,NULL),
 (191,'A15','8d2f700bb6871f7524ecdf502d39ad7d','Pinkee Kumari Singh','','0000-00-00 00:00:00',NULL,NULL),
 (192,'A16','0555c9ccec3fd2deadd3866f764bed48','Abinaya S','','0000-00-00 00:00:00',NULL,NULL),
 (193,'A17','447ffbc46ff7663b3941ac535c5c67dd','GOPI C','','0000-00-00 00:00:00',NULL,NULL),
 (194,'A18','a897ccef27e7c75cb279856eb5e91d88','Shristi Rajwade','','0000-00-00 00:00:00',NULL,NULL),
 (195,'A19','4bba418d87eb5ca9f316219eb8f89562','Pranil Warulkar','','0000-00-00 00:00:00',NULL,NULL),
 (196,'A20','731cee18c17882fe0634f2acc3206fa6','YUVANRAJA S','','0000-00-00 00:00:00',NULL,NULL),
 (197,'A21','7443730251ee0634315a96da4260d6dc','Karthik Raja D','','0000-00-00 00:00:00',NULL,NULL),
 (198,'A22','61bee64f1af5aebc97bbc350b25e84ef','Kaviyarasi S','','0000-00-00 00:00:00',NULL,NULL),
 (199,'A23','812c58a0c2d92fd3b2787d5a5daf49c7','Chandan Kumar','','0000-00-00 00:00:00',NULL,NULL),
 (200,'A24','c890848a7d14e7b950d485d9844e3bdc','Komal','','0000-00-00 00:00:00',NULL,NULL),
 (201,'A25','b0e42b041869c13e2586e5bd9edd6b8f','Soumya Shetty','','0000-00-00 00:00:00',NULL,NULL),
 (202,'A26','0027f2c7c24d98177d9fe293b692bf0c','Swethajayaram','','0000-00-00 00:00:00',NULL,NULL),
 (203,'A27','001dccbf46d0aad14b67884dbf5dc10b','M.Sivanesh','','0000-00-00 00:00:00',NULL,NULL),
 (204,'A28','b5f7dd70d76bd490092f5fd8ab6fd666','Senaditta C S','','0000-00-00 00:00:00',NULL,NULL),
 (205,'A29','a1d356559247cf0b6e82cdaa06f0e0b8','Ranjani Thiruppathi','','0000-00-00 00:00:00',NULL,NULL),
 (206,'A30','b645721e2dc3303da9be05105082d1f0','Sumit Patel','','0000-00-00 00:00:00',NULL,NULL),
 (207,'A31','3e85eba36cb125a40f68b09b34f3d1d0','VINAYAK','','0000-00-00 00:00:00',NULL,NULL),
 (208,'A32','e8d53f5f163f703a645a82b83a21aba9','Sakthivel M','','0000-00-00 00:00:00',NULL,NULL),
 (209,'A33','7285524eb527433e423f6698b83221f1','SANDHIYA T','','0000-00-00 00:00:00',NULL,NULL),
 (210,'A34','d651f58d02cd3b6ee54080f2ece1a735','Shankarling Shivanand Halemani','','0000-00-00 00:00:00',NULL,NULL),
 (211,'A35','d2f6ec546134742f0734a3f6104caba0','Subashakthi T','','0000-00-00 00:00:00',NULL,NULL),
 (212,'A36','732440e1167f31bc4519532a3caa5767','Nandhakumar S','','0000-00-00 00:00:00',NULL,NULL),
 (213,'A37','958ec68d76bad4cf67d6fc7d2c2ac3d1','Nikhil Uday Kumar','','0000-00-00 00:00:00',NULL,NULL),
 (214,'A38','1589b8a2beae7e01772ffdeb1de19d44','Garikapati Yaswanth Chowdary','','0000-00-00 00:00:00',NULL,NULL),
 (215,'A39','e8ff99d817f2d8c485f7405460e8c685','Arpit Rout','','0000-00-00 00:00:00',NULL,NULL),
 (216,'A40','52b37ca0276e60b38f654b0456a00ad2','S CHAITRA','','0000-00-00 00:00:00',NULL,NULL),
 (217,'A41','b985b3cf59e78617100dcbd651bbffc3','Charul','','0000-00-00 00:00:00',NULL,NULL),
 (218,'A42','e1e0a3a23d82234603626827f7c8d037','GURRAM VENKATA TARUN KUMAR','','0000-00-00 00:00:00',NULL,NULL),
 (219,'A43','efcf145904ae1bd16f5da0c3cdcc03b4','Monisiprabha S','','0000-00-00 00:00:00',NULL,NULL),
 (220,'A44','24ddb9272150bf67d6edc19894bcdc57','MOHAMED ASKAR ASIB M','','0000-00-00 00:00:00',NULL,NULL),
 (221,'A45','8739430eaf927808caf4441c6255d2a4','Dongri Jugeshwar','','0000-00-00 00:00:00',NULL,NULL),
 (222,'A46','f6075503496c18a10c9089fd29b60b68','Divya D','','0000-00-00 00:00:00',NULL,NULL),
 (223,'A47','3a8f8d39ca866402b5f1a8825cce42f3','Deebika P','','0000-00-00 00:00:00',NULL,NULL),
 (224,'A48','97cfd48a9823b7b293d0346f70ad67f5','Thippeswamy M','','0000-00-00 00:00:00',NULL,NULL),
 (225,'A49','fddfc9482d4ead0b2ced46c06932fd3d','Rohit Jaiswal','','0000-00-00 00:00:00',NULL,NULL),
 (226,'A50','0ec6f2cb3d809d12f0a7048fd1b3617b','Shraddha Somnath konde','','0000-00-00 00:00:00',NULL,NULL),
 (227,'A51','6cc3e3ed11719eed9f687fe06ba13b32','Abinaya Ravichandran','','0000-00-00 00:00:00',NULL,NULL),
 (228,'A52','e714d833218359af7da5fa82d8381feb','Gurudatta Kamalakar Gadde','','0000-00-00 00:00:00',NULL,NULL),
 (229,'A53','3cf4834a5d6a5af85dae34b6afc61f56','Elakkiya V','','0000-00-00 00:00:00',NULL,NULL),
 (230,'A54','31afaa9bf2321b4f2d6cf1ce28b95cf8','JANGA RAKESH KUMAR','','0000-00-00 00:00:00',NULL,NULL),
 (231,'A55','26faa0c9ce05a1bb35dd019435bd7465','SHOBIKAA K V','','0000-00-00 00:00:00',NULL,NULL),
 (232,'A56','21ec568777737dcd48dbdda9644c48a3','Jeevanantham M','','0000-00-00 00:00:00',NULL,NULL),
 (233,'A57','f1c88453c4b768a2dc169c9c3f71b3fc','Richa Rachna','','0000-00-00 00:00:00',NULL,NULL),
 (234,'A58','509919d5442c504cdb16ee4c3414a2ac','Dipak Bhandare','','0000-00-00 00:00:00',NULL,NULL),
 (235,'A59','e9cac31719ffc63634e2352e40f00d70','Manoj','','0000-00-00 00:00:00',NULL,NULL),
 (236,'A60','674b875cc96b19ef85fe462f60f3a38e','Rahul Kumar Prajapati','','0000-00-00 00:00:00',NULL,NULL),
 (237,'A61','5ca13f8c25100af9810ffdd73bf901de','Yuvaraj T','','0000-00-00 00:00:00',NULL,NULL),
 (238,'A62','6b7169b923300cc8829be4d9660d4617','Dinesh Palanisamy','','0000-00-00 00:00:00',NULL,NULL),
 (239,'A63','99f92aa970b1e216c796c509f9bfd94a','Mukunthan j','','0000-00-00 00:00:00',NULL,NULL),
 (240,'A64','9255cef9d6c32f31558b0a80cb9709e3','Lavanya Durgam','','0000-00-00 00:00:00',NULL,NULL),
 (241,'A65','05f810be4ddaf33c4a8d70cbba3756b1','Priti Saha','','0000-00-00 00:00:00',NULL,NULL),
 (242,'A66','cd0191b8f8a3499e3af25cc1604205b6','Anumulapuri Shiva Sathyanarayana','','0000-00-00 00:00:00',NULL,NULL),
 (243,'A67','f518110211628540fe83693e7414ca82','Shrikanta k m','','0000-00-00 00:00:00',NULL,NULL),
 (244,'A68','2f4e19ad765bda30d2438e7d71ec6ad0','MOHANKUMAR S','','0000-00-00 00:00:00',NULL,NULL),
 (245,'A69','fb1bd3986788452310b02120188e1a8a','SABINATH BHOOPATHY','','0000-00-00 00:00:00',NULL,NULL),
 (246,'A70','79bba3ce68e9cd0bb967055ed67f6cee','Arya Gajendra Kumar','','0000-00-00 00:00:00',NULL,NULL),
 (247,'A71','7ff3de25e9985e008b17fa557be29516','Logeswari V','','0000-00-00 00:00:00',NULL,NULL),
 (248,'A72','eb7d6d2fb2a3f3a27bca765ca5ce0506','SWETHA S','','0000-00-00 00:00:00',NULL,NULL),
 (249,'A73','4e441cc6c158fb8a91e6ef634ac8bf9a','R Dhanushkar','','0000-00-00 00:00:00',NULL,NULL),
 (250,'A74','8f2f410b739dc7b3b28febc3991191c6','Sreekanth','','0000-00-00 00:00:00',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


--
-- Definition of table `v_imported_users`
--

DROP TABLE IF EXISTS `v_imported_users`;
CREATE TABLE `v_imported_users` (
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(250) DEFAULT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  `UserName` varchar(150) DEFAULT NULL,
  `Password` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `v_imported_users`
--

/*!40000 ALTER TABLE `v_imported_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `v_imported_users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
