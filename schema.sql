-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.46-0ubuntu0.14.04.2-log - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for lpoj
CREATE DATABASE IF NOT EXISTS `lpoj` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lpoj`;


-- Dumping structure for table lpoj.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.ci_sessions: ~0 rows (approximately)
DELETE FROM `ci_sessions`;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_clarification
CREATE TABLE IF NOT EXISTS `pc_clarification` (
  `CLARIFICATION_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PARTICIPANT_ID` bigint(20) NOT NULL,
  `CLARIFICATION_TITLE` varchar(128) NOT NULL,
  `CLARIFICATION_CONTENT` text NOT NULL,
  `CLARIFICATION_RESPONSE` text,
  `CLARIFICATION_TIME` varchar(128) NOT NULL,
  PRIMARY KEY (`CLARIFICATION_ID`),
  KEY `FK_ASKING_CLARIFICATION` (`PARTICIPANT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_clarification: ~0 rows (approximately)
DELETE FROM `pc_clarification`;
/*!40000 ALTER TABLE `pc_clarification` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_clarification` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_contest
CREATE TABLE IF NOT EXISTS `pc_contest` (
  `CONTEST_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CONTEST_NAME` varchar(128) NOT NULL,
  `CONTEST_DESCRIPTION` text,
  `CONTEST_START` varchar(128) NOT NULL,
  `CONTEST_FREEZE` varchar(128) NOT NULL,
  `CONTEST_END` varchar(128) NOT NULL,
  `CONTEST_PENALTY` varchar(128) NOT NULL,
  `USER_NAME` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`CONTEST_ID`),
  KEY `USER_NAME` (`USER_NAME`),
  CONSTRAINT `pc_contest_ibfk_1` FOREIGN KEY (`USER_NAME`) REFERENCES `pc_user` (`USER_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_contest: ~0 rows (approximately)
DELETE FROM `pc_contest`;
/*!40000 ALTER TABLE `pc_contest` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_contest` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_detcon
CREATE TABLE IF NOT EXISTS `pc_detcon` (
  `DETCON_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CONTEST_ID` bigint(20) NOT NULL,
  `PROBLEM_ID` bigint(20) NOT NULL,
  PRIMARY KEY (`DETCON_ID`),
  KEY `CONTEST_ID` (`CONTEST_ID`),
  KEY `PROBLEM_ID` (`PROBLEM_ID`),
  CONSTRAINT `pc_detcon_ibfk_1` FOREIGN KEY (`CONTEST_ID`) REFERENCES `pc_contest` (`CONTEST_ID`),
  CONSTRAINT `pc_detcon_ibfk_2` FOREIGN KEY (`PROBLEM_ID`) REFERENCES `pc_problem` (`PROBLEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_detcon: ~0 rows (approximately)
DELETE FROM `pc_detcon`;
/*!40000 ALTER TABLE `pc_detcon` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_detcon` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_image
CREATE TABLE IF NOT EXISTS `pc_image` (
  `IMAGE_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `IMAGE_TITLE` varchar(128) NOT NULL,
  `IMAGE_CONTENT` longblob NOT NULL,
  PRIMARY KEY (`IMAGE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_image: ~0 rows (approximately)
DELETE FROM `pc_image`;
/*!40000 ALTER TABLE `pc_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_image` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_participant
CREATE TABLE IF NOT EXISTS `pc_participant` (
  `PARTICIPANT_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `USER_NAME` varchar(128) NOT NULL,
  `CONTEST_ID` bigint(20) NOT NULL,
  `PARTICIPANT_LASTACTIVE` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`PARTICIPANT_ID`),
  KEY `FK_CONTEST_PARTICIPANT` (`CONTEST_ID`),
  KEY `FK_PARTICIPANT_DETAIL` (`USER_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_participant: ~0 rows (approximately)
DELETE FROM `pc_participant`;
/*!40000 ALTER TABLE `pc_participant` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_participant` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_problem
CREATE TABLE IF NOT EXISTS `pc_problem` (
  `PROBLEM_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PROBLEM_TITLE` varchar(128) NOT NULL,
  `PROBLEM_CONTENT` text NOT NULL,
  `PROBLEM_CREATOR` varchar(128) NOT NULL,
  `PROBLEM_INPUTCASE` longtext,
  `PROBLEM_OUTPUCASE` longtext,
  `PROBLEM_RUNTIME` varchar(128) DEFAULT NULL,
  `PROBLEM_MEMORY` varchar(128) DEFAULT NULL,
  `PROBLEM_TOLLERANCE` varchar(10) NOT NULL DEFAULT '0',
  `USER_NAME` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`PROBLEM_ID`),
  KEY `USER_NAME` (`USER_NAME`),
  CONSTRAINT `pc_problem_ibfk_1` FOREIGN KEY (`USER_NAME`) REFERENCES `pc_user` (`USER_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_problem: ~0 rows (approximately)
DELETE FROM `pc_problem`;
/*!40000 ALTER TABLE `pc_problem` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_problem` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_probset
CREATE TABLE IF NOT EXISTS `pc_probset` (
  `PROBSET_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CONTEST_ID` bigint(20) NOT NULL,
  `USER_NAME` varchar(128) NOT NULL,
  `PROBSET_STATUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`PROBSET_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_probset: ~0 rows (approximately)
DELETE FROM `pc_probset`;
/*!40000 ALTER TABLE `pc_probset` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_probset` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_root
CREATE TABLE IF NOT EXISTS `pc_root` (
  `ROOT_ITEM` varchar(128) NOT NULL,
  `ROOT_VALUE` text,
  PRIMARY KEY (`ROOT_ITEM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_root: ~0 rows (approximately)
DELETE FROM `pc_root`;
/*!40000 ALTER TABLE `pc_root` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_root` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_status
CREATE TABLE IF NOT EXISTS `pc_status` (
  `STATUS_ID` int(11) NOT NULL,
  `STATUS_NAME` varchar(128) NOT NULL,
  PRIMARY KEY (`STATUS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_status: ~11 rows (approximately)
DELETE FROM `pc_status`;
/*!40000 ALTER TABLE `pc_status` DISABLE KEYS */;
INSERT INTO `pc_status` (`STATUS_ID`, `STATUS_NAME`) VALUES
	(0, 'Success'),
	(1, 'Wrong Answer'),
	(2, 'Compile Error'),
	(3, 'Runtime Error'),
	(4, 'Time Limit Exceeded'),
	(5, 'Memory Limit Exceeded'),
	(6, 'Presentation Error'),
	(7, 'Accepted'),
	(10, 'File Not Supported'),
	(11, 'Malicious Code'),
	(99, 'Pending');
/*!40000 ALTER TABLE `pc_status` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_submit
CREATE TABLE IF NOT EXISTS `pc_submit` (
  `SUBMIT_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PROBLEM_ID` bigint(20) NOT NULL,
  `STATUS_ID` int(11) NOT NULL,
  `PARTICIPANT_ID` bigint(20) NOT NULL,
  `SUBMIT_FILENAME` varchar(128) NOT NULL,
  `SUBMIT_TIME` varchar(128) NOT NULL,
  `SUBMIT_HASH` varchar(512) NOT NULL,
  `Source` text NOT NULL,
  `SUBMIT_LOG` text,
  `SCORE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SUBMIT_ID`),
  KEY `FK_SUBMITTER` (`PARTICIPANT_ID`),
  KEY `FK_SUBMIT_PROBLEM` (`PROBLEM_ID`),
  KEY `FK_SUBMIT_STATUS` (`STATUS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_submit: ~0 rows (approximately)
DELETE FROM `pc_submit`;
/*!40000 ALTER TABLE `pc_submit` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_submit` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_testcase
CREATE TABLE IF NOT EXISTS `pc_testcase` (
  `TESTCASE_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PROBLEM_ID` bigint(20) NOT NULL,
  `INPUTCASE` varchar(128) NOT NULL,
  `OUTPUTCASE` varchar(128) NOT NULL,
  `PERSENTASE` varchar(128) NOT NULL,
  PRIMARY KEY (`TESTCASE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_testcase: ~0 rows (approximately)
DELETE FROM `pc_testcase`;
/*!40000 ALTER TABLE `pc_testcase` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_testcase` ENABLE KEYS */;


-- Dumping structure for table lpoj.pc_user
CREATE TABLE IF NOT EXISTS `pc_user` (
  `USER_NAME` varchar(128) NOT NULL,
  `USER_FULLNAME` varchar(1024) DEFAULT NULL,
  `USER_PASSWORD` varchar(128) NOT NULL,
  `USER_LASTIP` varchar(128) DEFAULT NULL,
  `USER_SESSIONKEY` varchar(128) DEFAULT NULL,
  `USER_STATUS` int(11) DEFAULT NULL,
  PRIMARY KEY (`USER_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lpoj.pc_user: ~0 rows (approximately)
DELETE FROM `pc_user`;
/*!40000 ALTER TABLE `pc_user` DISABLE KEYS */;
INSERT INTO `pc_user` (`USER_NAME`, `USER_FULLNAME`, `USER_PASSWORD`, `USER_LASTIP`, `USER_SESSIONKEY`, `USER_STATUS`) VALUES
  ('admin', NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL, NULL, 1),
  ('user', NULL, '12dea96fec20593566ab75692c9949596833adc9', NULL, NULL, 3);
/*!40000 ALTER TABLE `pc_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
