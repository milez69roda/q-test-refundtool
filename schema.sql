/*
SQLyog Enterprise - MySQL GUI v8.05 RC 
MySQL - 5.0.51 : Database - refundtool_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`refundtool_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `refundtool_db`;

/*Table structure for table `brand` */

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `brandid` int(11) NOT NULL auto_increment,
  `brand_name` varchar(30) default NULL,
  `gl_account` varchar(30) default NULL,
  `date_created` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`brandid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `brand` */

insert  into `brand`(`brandid`,`brand_name`,`gl_account`,`date_created`) values (1,'Net10','01.512.7429.243.000','2011-11-14 05:03:37'),(2,'Net10 Unlimited','01.512.7429.243.000\r\n','2011-11-14 05:03:54'),(3,'Straight Talk','01.512.7429.030.000\r\n','2011-11-14 05:03:59'),(4,'Tracfone','01.512.7429.000.000\r\n','2011-11-14 05:04:05'),(5,'SafeLink','01.512.7429.000.000','2011-11-20 20:14:30');

/*Table structure for table `center` */

DROP TABLE IF EXISTS `center`;

CREATE TABLE `center` (
  `centerid` int(11) NOT NULL auto_increment,
  `centerdesc` varchar(100) default NULL,
  `centeraddress` varchar(255) default NULL,
  `centerdisabled` tinyint(4) default '0',
  `centeracronym` varchar(3) default NULL,
  PRIMARY KEY  (`centerid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `center` */

insert  into `center`(`centerid`,`centerdesc`,`centeraddress`,`centerdisabled`,`centeracronym`) values (1,'Belize City',NULL,0,'BEL'),(2,'Barranquilla',NULL,0,'BAR'),(3,'Bogota',NULL,0,'BOG'),(4,'Cebu',NULL,0,'CEB'),(5,'Guatemala City',NULL,0,'GUA'),(6,'Georgetown',NULL,0,'GEO'),(7,'Miami',NULL,0,'MIA');

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(150) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `ci_sessions` */

/*Table structure for table `items_category` */

DROP TABLE IF EXISTS `items_category`;

CREATE TABLE `items_category` (
  `itemid` int(11) NOT NULL auto_increment,
  `item_name` varchar(100) default NULL,
  `item_desc_tpl` text,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `items_category` */

insert  into `items_category`(`itemid`,`item_name`,`item_desc_tpl`,`date_created`) values (1,'Airtime','Card PIN:      |SMP:       |Units: ','2011-11-17 16:00:14'),(2,'Handset','Make/Model:      |ESN:       |MIN:','2011-11-17 16:00:50'),(3,'Accessory','Description: ','2011-11-17 16:01:31'),(4,'Other','Description:','2011-11-17 16:01:40');

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(40) NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `login_attempts` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL auto_increment,
  `role_id` int(11) NOT NULL,
  `data` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `permissions` */

/*Table structure for table `refund_status` */

DROP TABLE IF EXISTS `refund_status`;

CREATE TABLE `refund_status` (
  `rstatusid` int(11) NOT NULL auto_increment,
  `rstatus_name` varbinary(100) default NULL,
  PRIMARY KEY  (`rstatusid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `refund_status` */

insert  into `refund_status`(`rstatusid`,`rstatus_name`) values (1,'Pending'),(2,'Audited - Approved'),(3,'Audited - Not Approve'),(4,'Completed');

/*Table structure for table `refundlog` */

DROP TABLE IF EXISTS `refundlog`;

CREATE TABLE `refundlog` (
  `logid` int(11) NOT NULL auto_increment,
  `supplier_num` varchar(15) default NULL,
  `supplier_site_num` varchar(20) default NULL COMMENT 'combination of customer''s last name and first name initial',
  `address_line1` varchar(255) default NULL COMMENT 'Customer''s first name and Last Name',
  `address_line2` varchar(255) default NULL COMMENT 'Customer''s Street Address',
  `address_line3` varchar(255) default NULL,
  `city` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `zip` varchar(10) default NULL,
  `country` varchar(100) default NULL,
  `invoice_num` varchar(30) default NULL,
  `invoice_date` date default NULL,
  `invoice_amount` varchar(20) default NULL,
  `invoice_descer` varchar(30) default NULL,
  `brand` varchar(30) default NULL,
  `gl_account` varchar(30) default NULL,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `user_id` int(11) default NULL,
  `cust_fname` varchar(30) default NULL,
  `cust_lname` varchar(30) default NULL,
  `log_status` smallint(6) default '1' COMMENT 'refund_status',
  `log_status_name` varchar(100) default NULL,
  `log_status_desc` text,
  `reason` text,
  `webcsr` varchar(20) default NULL,
  `invoice_sub_total` varchar(20) default NULL,
  `sales_tax` varchar(20) default NULL,
  `sales_tax_percent` varchar(20) default NULL,
  `other_tax` varchar(20) default '0',
  `updated_by` int(11) default NULL,
  `updated_date` datetime default NULL,
  `updated_by_name` varchar(100) default NULL,
  `audited_by` int(11) default NULL,
  `audited_date` datetime default NULL,
  `audited_name` varchar(100) default NULL,
  `log_ip` varchar(20) default NULL,
  `agent_updated_flag` smallint(6) default '0',
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `refundlog` */

insert  into `refundlog`(`logid`,`supplier_num`,`supplier_site_num`,`address_line1`,`address_line2`,`address_line3`,`city`,`state`,`zip`,`country`,`invoice_num`,`invoice_date`,`invoice_amount`,`invoice_descer`,`brand`,`gl_account`,`date_created`,`user_id`,`cust_fname`,`cust_lname`,`log_status`,`log_status_name`,`log_status_desc`,`reason`,`webcsr`,`invoice_sub_total`,`sales_tax`,`sales_tax_percent`,`other_tax`,`updated_by`,`updated_date`,`updated_by_name`,`audited_by`,`audited_date`,`audited_name`,`log_ip`,`agent_updated_flag`) values (1,'TW13','',' ','','','','','','','','2011-11-14','0','','','','2011-11-14 07:07:26',1,NULL,NULL,4,'Completed','',NULL,NULL,NULL,NULL,NULL,'0',1,'2011-11-23 10:57:18',NULL,7,'2011-11-22 08:19:51','Auditor Auditor','10.249.96.37',0),(2,'TW13','youngt','Too Young','test','test','test','test','test','test','13123','2011-11-14','123','test','Net10','01.512.7429.243.000','2011-11-14 07:21:45',1,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(3,'TW13','tomast','Tom Tomas','test','test','test','test','test','test','test','2011-11-14','45','test','Net10','01.512.7429.243.000','2011-11-14 07:35:18',4,NULL,NULL,2,'Audited - Approved','',NULL,NULL,NULL,NULL,NULL,'0',1,'2011-11-25 16:32:01','Admin Admin',1,'2011-11-25 16:32:01','Admin Admin',NULL,0),(4,'TW13','smithj','John Smith','test','12','test','test','678','test','34','2011-11-13','4567','7893','Net10','01.512.7429.243.000','2011-11-14 08:07:49',4,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(5,'TW13','holea','Amber Hole','test','56','test','test','12345','test','678','2011-11-14','56','test','Straight Talk','01.512.7429.030.000','2011-11-14 08:14:15',4,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(6,'TW13','mendozan','Nadia Mendoza','test','test','test','test','12345','test','567','2011-11-14','345','test','Tracfone','01.512.7429.000.000','2011-11-14 08:44:32',6,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(7,'TW13','testt','test test','test','test','test','Alaska','12345','test','566','2011-11-14','567','test','Net10 Unlimited','01.512.7429.243.000','2011-11-14 08:46:16',6,'test','test',3,'Audited - Not Approve','','test','test','','','','0',1,'2011-11-24 12:21:34','Admin Admin',1,'2011-11-24 12:12:22','Admin Admin',NULL,1),(8,'TW13','pedroj','Juan Pedro','test','test','test','test','12345','test','234','2011-11-14','23','test','Net10','01.512.7429.243.000','2011-11-14 09:08:14',6,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(9,'TW13','datr','Roger Dat','test','test','test','test','12345','test','test','2011-11-14','567','test','Straight Talk','01.512.7429.030.000','2011-11-14 09:09:06',6,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(10,'TW13','doej','John Doe','test','test','test','test','test','test','test','2011-11-14','678','test','Tracfone','01.512.7429.000.000','2011-11-14 09:10:43',6,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(11,'TW13','donm','Mulan Don','test','test','test','test','test','test','45','2011-11-14','567','test','Straight Talk','01.512.7429.030.000','2011-11-14 09:11:42',6,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(12,'TW13','met','The Me','test','test','test','test','4567','test','56','2011-11-14','566','test','Straight Talk','01.512.7429.030.000','2011-11-14 09:12:50',6,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(13,'TW13','johnp','Peter John','Street Address','apt 4','Florida','Miami','12345','USA','56','2011-11-14','678','test','Net10 Unlimited','01.512.7429.243.000','2011-11-14 14:00:34',4,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(14,'TW13','los','smith lo','123 red road','apt 34','miami','fl','33179','USA','777777777777777777777777777777','2011-11-14','10','111111','Net10','01.512.7429.243.000','2011-11-14 14:14:37',4,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(15,'TW13','.2','2222. .','22','2','2','2','2','2','2','2011-11-14','22222','2','Net10','01.512.7429.243.000','2011-11-14 14:24:10',4,NULL,NULL,0,'Pending',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(22,'TW13','rodac','Carmelo Roda','address','','Missi','Mississippi','604213','USA','6546546123','2011-11-17','175.96','adfa sdfa fasdf','Net10','01.512.7429.243.000','2011-11-18 14:03:45',1,NULL,NULL,0,'Pending',NULL,'ASDF ASDFASDF','123123123123','166.00','9.96',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(23,'TW13','rodac','Carmelo Roda','address','','Missi','Mississippi','604213','USA','6546546123','2011-11-17','175.96','adfa sdfa fasdf','Net10','01.512.7429.243.000','2011-11-18 14:04:30',1,NULL,NULL,0,'Pending',NULL,'ASDF ASDFASDF','123123123123','166.00','9.96',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(24,'TW13','rodac','Carmelo Roda','address','','Missi','Mississippi','604213','USA','6546546123','2011-11-17','1002.76','adfa sdfa fasdf','Net10','01.512.7429.243.000','2011-11-18 14:13:44',1,NULL,NULL,0,'Pending',NULL,'ASDF ASDFASDF','123123123123','946.00','56.76',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(25,'TW13','nicolasj','James Nicolas','Labangon Street','','Alas','Delaware','12345','USA','123456789','2011-11-18','714.07','test test test st','Straight Talk','01.512.7429.030.000','2011-11-18 14:44:32',1,'James','Nicolas',4,'Completed','','This is a test','12345678','714.00','0.07','.01','0',1,'2011-11-29 10:49:45','Admin Admin',1,'2011-11-25 16:31:25','Admin Admin',NULL,0),(26,'TW13','tabalr','Roy Tabal','Street','','New','Colorado','12345','','1111111','2011-11-21','180.54','My Description','Net10 Unlimited','01.512.7429.243.000','2011-11-21 09:32:15',1,'Roy','Tabal',4,'Completed','','My Reason','222222','177.00','3.54','0.02','0',1,'2011-11-23 14:54:32',NULL,1,'2011-11-23 14:54:13','Admin Admin',NULL,0),(27,'TW13','tabalr','Roy Tabal','Street','','New','Arizona','12345','','1111111','2011-11-21','6319.36','My Description 1','SafeLink','01.512.7429.000.000','2011-11-21 11:45:59',1,'Roy','Tabal',4,'Completed','','My Reason 1','222222','1178.00','141.36','0.12','5000',1,'2011-11-25 17:35:04','Admin Admin',1,'2011-11-25 17:34:44','Admin Admin',NULL,0),(28,'TW13','testt','test test','test','','test','Arizona','2344','testt','12313','2011-11-21','173.60','test','Net10','01.512.7429.243.000','2011-11-21 04:35:23',4,'test','test',4,'Completed','','test','test','155.00','18.60','12','0.00',1,'2011-11-23 14:50:13',NULL,1,'2011-11-22 19:23:07','Admin Admin',NULL,0),(29,'TW13','rafolsm','Marlon Rafols','Lahug','','Miami','Florida','12345','USA','333333','2011-11-21','667.80','test s','Net10 Unlimited','01.512.7429.243.000','2011-11-21 11:03:07',1,'Marlon','Rafols',3,'Audited - Not Approve','','tests','111111','190.00','22.80','0.12','455',3,'2011-11-25 08:05:20','Supervisor Supervisor',3,'2011-11-25 08:05:03','Supervisor Supervisor',NULL,1),(30,'TW13','junj','Jun Jun','street','','Miami','Florida','12345','USA','222222','2011-11-21','218.40','test me','Straight Talk','01.512.7429.030.000','2011-11-21 11:12:05',1,'Jun','Jun',4,'Completed','','reason me','11111','195.00','23.40','0.12','0.00',7,'2011-11-22 08:17:05',NULL,7,'2011-11-22 08:17:05','Auditor Auditor',NULL,0),(31,'TW13','villasj','Joey Villas','Deca Homes','','Miami','Florida','12345','USA','123456','2011-11-25','154.96','desc2 ','Net10','01.512.7429.243.000','2011-11-25 08:19:22',4,'Joey','Villas',4,'Completed','','reason 2','123456','149.00','5.96','4','0.00',1,'2011-11-25 16:30:53','Supervisor Supervisor',3,'2011-11-25 08:21:49','Supervisor Supervisor','10.249.96.37',0),(32,'TW13','testf','Fabienne Test','9700 NW 112th Ave','','Miami','Florida','33178','United States','4604654','2011-11-28','2.00','Phone Refund','Tracfone','01.512.7429.000.000','2011-11-28 10:56:44',1,'Fabienne','Test',1,'Pending',NULL,'The phone whinked at her and she got scared. ','103265428','2.00','0.00','0','0.00',NULL,'2011-11-28 10:56:44',NULL,NULL,NULL,NULL,'10.248.107.74',0);

/*Table structure for table `refundlog_items` */

DROP TABLE IF EXISTS `refundlog_items`;

CREATE TABLE `refundlog_items` (
  `itemid` int(11) NOT NULL auto_increment,
  `logid` int(11) default NULL,
  `qty` int(11) default NULL,
  `item_num` varchar(30) default NULL,
  `description` text,
  `unit_price` decimal(10,2) default NULL,
  `line_total` decimal(10,2) default NULL,
  `date_created` timestamp NULL default CURRENT_TIMESTAMP,
  `status` smallint(6) default '1',
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

/*Data for the table `refundlog_items` */

insert  into `refundlog_items`(`itemid`,`logid`,`qty`,`item_num`,`description`,`unit_price`,`line_total`,`date_created`,`status`) values (1,24,1,'Airtime','Card PIN:8888      |SMP: 9999      |Units: 2','78.00','78.00','2011-11-18 14:13:44',1),(2,24,1,'Handset','Make/Model:  7777    |ESN:  7777     |MIN: 7777','88.00','88.00','2011-11-18 14:13:44',1),(3,24,12,'Other','Description:','65.00','780.00','2011-11-18 14:13:44',1),(4,25,3,'Airtime','Card PIN: 6666     |SMP:   6666    |Units: 6','78.00','234.00','2011-11-18 14:44:32',1),(5,25,2,'Accessory','Description: test test ','105.00','210.00','2011-11-18 14:44:32',1),(6,25,6,'Handset','Make/Model: Nokia     |ESN:       |MIN:','45.00','270.00','2011-11-18 14:44:32',1),(7,26,1,'Accessory','Description: testa','99.00','99.00','2011-11-21 09:32:15',1),(8,26,1,'Handset','Make/Model:  123123    |ESN: 123123      |MIN:13123123','78.00','78.00','2011-11-21 09:32:15',1),(9,27,1,'Accessory','Description: testa','99.00','99.00','2011-11-21 11:45:59',1),(10,27,3,'Other','Make/Model:  123123    |ESN: 123123      |MIN:13123123','78.00','234.00','2011-11-21 11:45:59',1),(11,27,1,'Accessory','Description:  1111111111111','66.00','66.00','2011-11-21 11:45:59',1),(12,27,1,'Handset','Make/Model: 222     |ESN:  222     |MIN:2222','779.00','779.00','2011-11-21 12:48:28',1),(13,28,1,'Airtime','Card PIN:      |SMP:       |Units: ','66.00','66.00','2011-11-21 04:35:23',1),(14,28,1,'Accessory','Description: ','89.00','89.00','2011-11-21 04:35:23',1),(15,25,0,'','','0.00','0.00','2011-11-21 04:55:32',0),(16,25,0,'','','0.00','0.00','2011-11-21 04:55:32',0),(17,25,0,'','','0.00','0.00','2011-11-21 04:55:32',0),(18,28,0,'','','0.00','0.00','2011-11-21 07:12:09',0),(19,28,0,'','','0.00','0.00','2011-11-21 07:12:09',0),(166,30,2,'Other','Description:','42.00','0.00','2011-11-21 12:50:59',0),(21,26,0,'','','0.00','0.00','2011-11-21 09:22:08',0),(22,29,1,'Airtime','Card PIN:      |SMP:       |Units: ','50.00','50.00','2011-11-21 11:03:07',1),(23,29,1,'Handset','Make/Model:      |ESN:       |MIN:','100.00','100.00','2011-11-21 11:03:07',1),(24,29,1,'Accessory','Description: ','40.00','40.00','2011-11-21 11:03:07',1),(25,30,1,'Airtime','Card PIN:      |SMP:       |Units: ','50.00','50.00','2011-11-21 11:12:05',1),(26,30,1,'Accessory','Description: ','100.00','100.00','2011-11-21 11:12:05',1),(27,30,1,'Handset','Make/Model:      |ESN:       |MIN:','70.00','70.00','2011-11-21 11:12:05',0),(167,30,1,'Handset','Make/Model:      |ESN:       |MIN:','45.00','45.00','2011-11-21 12:53:44',1),(169,31,1,'Accessory','Description: ','99.00','99.00','2011-11-25 08:19:22',1),(168,31,1,'Handset','Make/Model:      |ESN:       |MIN:','50.00','50.00','2011-11-25 08:19:22',1),(170,32,1,'Handset','Make/Model:      |ESN:       |MIN:','2.00','2.00','2011-11-28 10:56:44',1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`parent_id`,`name`) values (1,0,'User'),(2,0,'Admin'),(3,0,'Agent'),(4,0,'Supervisor'),(5,2,'Auditor');

/*Table structure for table `states` */

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL auto_increment,
  `state_desc` varchar(100) default NULL,
  `state_usps` varchar(10) default NULL,
  `state_capital` varchar(100) default NULL,
  `state_cities` text,
  PRIMARY KEY  (`state_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Data for the table `states` */

insert  into `states`(`state_id`,`state_desc`,`state_usps`,`state_capital`,`state_cities`) values (1,'Alabama','AL','Montgomery','Birmingham%2CMontgomery%2CMobile%2CHuntsville%2CTuscaloosa'),(2,'Alaska','AK','Juneau','Anchorage%2CFairbanks%2CJuneau%2CCollege%2CKetchikan'),(3,'Arizona','AZ','Phoenix','Phoenix%2CTucson%2CMesa%2CGlendale%2CChandler'),(4,'Arkansas','AR','Little+Rock','Little+Rock%2CFort+Smith%2CFayetteville%2CSpringdale%2CJonesboro'),(5,'California','CA','Sacramento','Los+Angeles%2CSan+Diego%2CSan+Jose%2CSan+Francisco%2CFresno'),(6,'Colorado','CO','Denver','Denver%2CColorado+Springs%2CAurora%2CLakewood%2CFort+Collins'),(7,'Connecticut','CT','Hartford','Bridgeport%2CNew+Haven%2CHartford%2CStamford%2CWaterbury'),(8,'Delaware','DE','Dover','Wilmington%2CDover%2CNewark%2CPike+Creek%2CBear'),(9,'Florida','FL','Tallahassee','Jacksonville%2CMiami%2CTampa%2CSt.+Petersburg%2COrlando'),(10,'Georgia','GA','Atlanta','Atlanta%2CAugusta%2CColumbus%2CSavannah%2CAthens'),(11,'Hawaii','HI','Honolulu','Honolulu%2CHilo%2CKailua%2CKaneohe%2CKapolei'),(12,'Idaho','ID','Boise','Boise%2CNampa%2CMeridian%2CPocatello%2CIdaho+Falls'),(13,'Illinois','IL','Springfield','Chicago%2CAurora%2CRockford%2CJoliet%2CNaperville'),(14,'Indiana','IN','Indianapolis','Indianapolis%2CFort+Wayne%2CEvansville%2CSouth+Bend%2CGary'),(15,'Iowa','IA','Des+Moines','Des+Moines%2CCedar+Rapids%2CDavenport%2CSioux+City%2CIowa+City'),(16,'Kansas','KS','Topeka','Wichita%2COverland+Park%2CKansas+City%2CTopeka%2COlathe'),(17,'Kentucky','KY','Frankfort','Louisville%2CLexington%2COwensboro%2CBowling+Green%2CCovington'),(18,'Louisiana','LA','Baton+Rouge','New+Orleans%2CBaton+Rouge%2CShreveport%2CLafayette%2CLake+Charles'),(19,'Maine','ME','Augusta','Portland%2CLewiston%2CBangor%2CSouth+Portland%2CAuburn'),(20,'Maryland','MD','Annapolis','Baltimore%2CRockville%2CFrederick%2CGaithersburg%2CColumbia'),(21,'Massachusetts','MA','Boston','Boston%2CWorcester%2CSpringfield%2CLowell%2CCambridge'),(22,'Michigan','MI','Lansing','Detroit%2CGrand+Rapids%2CWarren%2CSterling+Heights%2CFlint'),(23,'Minnesota','MN','Saint+Paul','Minneapolis%2CSaint+Paul%2CRochester%2CDuluth%2CBloomington'),(24,'Mississippi','MS','Jackson','Jackson%2CGulfport%2CHattiesburg%2CBiloxi%2CSouthaven'),(25,'Missouri','MO','Jefferson+City','Kansas+City%2CSaint+Louis%2CSpringfield%2CIndependence%2CColumbia'),(26,'Montana','MT','Helena','Billings%2CMissoula%2CGreat+Falls%2CBozeman%2CButte'),(27,'Nebraska','NE','Lincoln','Omaha%2CLincoln%2CBellevue%2CGrand+Island%2CKearney'),(28,'Nevada','NV','Carson+City','Las+Vegas%2CHenderson%2CNorth+Las+Vegas%2CReno%2CParadise'),(29,'New Hampshire','NH','Concord','Manchester%2CNashua%2CConcord%2CDerry%2CRochester'),(30,'New Jersey','NJ','Trenton','Newark%2CJersey+City%2CPaterson%2CElizabeth%2CEdison'),(31,'New Mexico','NM','Santa+Fe','Albuquerque%2CLas+Cruces%2CRio+Rancho%2CSanta+Fe%2CRoswell'),(32,'New York','NY','Albany','New+York%2CBuffalo%2CRochester%2CYonkers%2CSyracuse'),(33,'North Carolina','NC','Raleigh','Charlotte%2CRaleigh%2CGreensboro%2CWinston-Salem%2CDurham'),(34,'North Dakota','ND','Bismarck','Fargo%2CBismarck%2CGrand+Forks%2CMinot%2CWest+Fargo'),(35,'Ohio','OH','Columbus','Columbus%2CCleveland%2CCincinnati%2CToledo%2CAkron'),(36,'Oklahoma','OK','Oklahoma+City','Oklahoma+City%2CTulsa%2CNorman%2CLawton%2CBroken+Arrow'),(37,'Oregon','OR','Salem','Portland%2CSalem%2CEugene%2CGresham%2CHillsboro'),(38,'Pennsylvania','PA','Harrisburg','Philadelphia%2CPittsburgh%2CAllentown%2CErie%2CReading'),(39,'Rhode Island','RI','Providence','Providence%2CWarwick%2CCranston%2CPawtucket%2CEast+Providence'),(40,'South Carolina','SC','Columbia','Columbia%2CCharleston%2CNorth+Charleston%2CRock+Hill%2CMount+Pleasant'),(41,'South Dakota','SD','Pierre','Sioux+Falls%2CRapid+City%2CAberdeen%2CWatertown%2CBrookings'),(42,'Tennessee','TN','Nashville','Memphis%2CNashville%2CKnoxville%2CChattanooga%2CClarksville'),(43,'Texas','TX','Austin','Houston%2CSan+Antonio%2CDallas%2CAustin%2CFort+Worth'),(44,'Utah','UT','Salt+Lake+City','Salt+Lake+City%2CWest+Valley+City%2CProvo%2CWest+Jordan%2CSandy'),(45,'Vermont','VT','Montpelier','Burlington%2CEssex%2CRutland%2CColchester%2CSouth+Burlington'),(46,'Virginia','VA','Richmond','Virginia+Beach%2CNorfolk%2CChesapeake%2CRichmond%2CNewport+News'),(47,'Washington','WA','Olympia','Seattle%2CSpokane%2CTacoma%2CVancouver%2CBellevue'),(48,'West Virginia','WV','Charleston','Charleston%2CHuntington%2CParkersburg%2CMorgantown%2CWheeling'),(49,'Wisconsin','WI','Madison','Milwaukee%2CMadison%2CGreen+Bay%2CKenosha%2CRacine'),(50,'Wyoming','WY','Cheyenne','Cheyenne%2CCasper%2CLaramie%2CGillette%2CRock+Springs');

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `supplierid` int(11) NOT NULL auto_increment,
  `supplier_name` varchar(50) default NULL,
  `date_created` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`supplierid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `supplier` */

insert  into `supplier`(`supplierid`,`supplier_name`,`date_created`) values (1,'TW13','2011-11-14 05:04:40');

/*Table structure for table `user_autologin` */

DROP TABLE IF EXISTS `user_autologin`;

CREATE TABLE `user_autologin` (
  `key_id` char(32) NOT NULL,
  `user_id` mediumint(8) NOT NULL default '0',
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`key_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `user_autologin` */

insert  into `user_autologin`(`key_id`,`user_id`,`user_agent`,`last_ip`,`last_login`) values ('ded0ad84eb9aed421a65d91aaeaa6a4d',1,'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Cente','10.248.107.125','2011-11-23 14:29:26');

/*Table structure for table `user_profile` */

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) default NULL,
  `website` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user_profile` */

insert  into `user_profile`(`id`,`user_id`,`country`,`website`) values (1,1,NULL,NULL);

/*Table structure for table `user_temp` */

DROP TABLE IF EXISTS `user_temp`;

CREATE TABLE `user_temp` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(34) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_key` varchar(50) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `user_temp` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `role_id` int(11) NOT NULL default '1',
  `centerid` int(11) default NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(34) NOT NULL,
  `fname` varchar(30) default NULL,
  `lname` varchar(30) default NULL,
  `email` varchar(100) NOT NULL,
  `banned` tinyint(1) NOT NULL default '0',
  `ban_reason` varchar(255) default NULL,
  `newpass` varchar(34) default NULL,
  `newpass_key` varchar(32) default NULL,
  `newpass_time` datetime default NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `supervisor_id` int(11) default NULL,
  `viewable` smallint(6) default '1',
  `isSupervisor` smallint(6) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`centerid`,`username`,`password`,`fname`,`lname`,`email`,`banned`,`ban_reason`,`newpass`,`newpass_key`,`newpass_time`,`last_ip`,`last_login`,`created`,`modified`,`supervisor_id`,`viewable`,`isSupervisor`) values (1,2,7,'admin','admin','Admin','Admin','admin@localhost.com',0,NULL,NULL,NULL,NULL,'10.248.107.223','2011-11-29 10:41:51','2008-11-30 04:56:32','2011-11-29 10:41:51',NULL,0,0),(2,1,7,'user','user','User','User','user@localhost.com',0,NULL,NULL,NULL,NULL,'127.0.0.1','2008-12-01 14:04:14','2008-12-01 14:01:53','2011-11-14 08:06:08',NULL,0,0),(3,4,1,'super','12345','Supervisor','Supervisor','',0,NULL,NULL,NULL,NULL,'10.248.107.150','2011-11-25 14:55:27','2011-11-14 05:27:19','2011-11-25 14:55:27',NULL,1,1),(4,3,1,'agent','12345','Agent','Agent','',0,NULL,NULL,NULL,NULL,'10.248.107.150','2011-11-25 16:53:34','2011-11-14 05:29:43','2011-11-25 16:53:34',3,1,0),(5,2,7,'belron','12345','Ron','Garon','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-14 08:30:12','2011-11-14 08:32:03',NULL,1,0),(6,3,1,'nick','12345','Nick','Torres','',0,NULL,NULL,NULL,NULL,'10.249.96.37','2011-11-14 08:43:44','2011-11-14 08:43:27','2011-11-14 08:43:44',3,1,0),(7,5,1,'auditor','12345','Auditor','Auditor','',0,NULL,NULL,NULL,NULL,'10.248.107.223','2011-11-25 16:26:59','0000-00-00 00:00:00','2011-11-25 16:26:59',NULL,1,0),(8,5,1,'auditor2','12345','My','Auditor','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-21 14:32:44','2011-11-21 14:32:44',NULL,1,0),(9,2,7,'test1','test','test1','test','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-25 10:18:41','2011-11-25 10:18:41',NULL,1,0),(12,4,3,'huprieto','hprieto','Hugo','Prieto','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:30:45','2011-11-28 12:30:45',NULL,1,1),(10,2,7,'jbelstock','tristan','Joy','Belstock','',0,NULL,NULL,NULL,NULL,'10.248.107.150','2011-11-29 11:56:14','2011-11-25 13:00:28','2011-11-29 11:56:14',NULL,1,0),(11,3,7,'joy_b1','tristan','Joy','Bel1','',0,NULL,NULL,NULL,NULL,'10.248.107.150','2011-11-25 13:11:19','2011-11-25 13:02:43','2011-11-25 13:11:19',NULL,1,0),(13,4,3,'rumunoz','rmunoz','Ruben','Munoz','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:31:38','2011-11-28 12:31:38',NULL,1,1),(14,4,3,'semarin','smarin','Sebastian','Marin','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:33:13','2011-11-28 12:33:13',NULL,1,1),(15,4,3,'cavinasco','cvinasco','Camilo','Vinasco','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:34:12','2011-11-28 12:34:12',NULL,1,1),(16,4,3,'lucruz','lcruz','Luisa','Cruz','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:35:11','2011-11-28 12:35:11',NULL,1,1),(17,4,4,'jesaurin','jsaurin','Jennifer','Saurin','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:35:49','2011-11-28 12:35:49',NULL,1,1),(58,3,4,'jrestorgio','jestorgio','John Rey','Estorgio','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:28:45','2011-11-28 17:28:45',NULL,1,0),(18,4,4,'ekarchival','earchival','Evette','Archival','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:39:53','2011-11-28 12:39:53',NULL,1,1),(19,4,4,'nfhingie','nhingie','Narul Fariza','Hingie','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:40:50','2011-11-28 12:40:50',NULL,1,1),(20,4,4,'varato','vrato','Vanessa','Rato','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:42:03','2011-11-28 12:42:03',NULL,1,1),(21,4,3,'ivanguerrero','iguerrero','Ivan','Guerrero','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:43:18','2011-11-28 12:43:18',NULL,1,1),(22,4,3,'yetamara','ytamara','Yeni','Tamara','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:44:07','2011-11-28 12:44:07',NULL,1,1),(23,4,3,'joespina','jespina','Jose','Espina','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:44:44','2011-11-28 12:44:44',NULL,1,1),(24,4,3,'josarria','jsarria','Josie','Sarria','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:45:19','2011-11-28 12:45:19',NULL,1,1),(25,4,3,'necuenca','ncuenca','Nelson','Cuenca','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:50:33','2011-11-28 12:50:33',NULL,1,1),(26,4,3,'moviafara','mviafara','Monica','Viafara','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:52:18','2011-11-28 12:52:18',NULL,1,1),(27,2,7,'kifilardi','kfilardi','Kim','Filardi','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 12:58:53','2011-11-28 12:58:53',NULL,1,0),(28,3,3,'moahmed','mahmed','Mohamed Hassan ','Ahmed','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:00:50','2011-11-28 13:00:50',NULL,1,0),(29,3,3,'cerincon','crincon','Christian Eduardo','Rincon','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:01:42','2011-11-28 13:01:42',NULL,1,0),(30,3,3,'joortiz','jortiz','Jonathan','Ortiz','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:03:56','2011-11-28 13:03:56',NULL,1,0),(31,3,3,'secaballero','scaballero','Sebastian','Caballero','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:04:41','2011-11-28 13:04:41',NULL,1,0),(32,3,3,'lazapata','lzapata','Lizeth Andrea','Zapata','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:05:29','2011-11-28 13:05:29',NULL,1,0),(33,3,3,'moibrahim','mibrahim','Mohamed Ibrahim','El Hadary Saad Ibrahim','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:06:26','2011-11-28 13:06:26',NULL,1,0),(34,3,3,'algaray','agaray','Alfonso','Guarin Garay','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:07:04','2011-11-28 13:07:04',NULL,1,0),(35,3,3,'jsgiraldo','jgiraldo','Joan Sebastian','Giraldo','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:07:44','2011-11-28 13:07:44',NULL,1,0),(36,3,3,'jfberrio','jberrio','Juan Felipe','Berrio','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:08:55','2011-11-28 13:08:55',NULL,1,0),(37,3,3,'olrivera','orivera','Oscar Leonardo','Rivera','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:09:50','2011-11-28 13:09:50',NULL,1,0),(38,3,3,'catovar','ctovar','Catherine','Tovar','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:10:26','2011-11-28 13:10:26',NULL,1,0),(39,3,3,'spacero','sacero','Sandra Patricia','Acero','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:11:00','2011-11-28 13:11:00',NULL,1,0),(40,3,3,'wicordoba','wcordoba','Wilfredo','Cordoba','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:11:33','2011-11-28 13:11:33',NULL,1,0),(41,3,4,'antuyor','atuyor','Anguilyne','Tuyor','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:12:55','2011-11-28 13:12:55',NULL,1,0),(42,3,4,'mgsuarez','msuarez','Mitze Gay','Suarez','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:13:40','2011-11-28 13:13:40',NULL,1,0),(43,3,4,'wiltan','witan','William','Tan III','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:14:40','2011-11-28 13:14:40',NULL,1,0),(44,3,4,'cealinea','calinea','Celeste','Alinea','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:15:10','2011-11-28 13:15:10',NULL,1,0),(45,3,4,'gisalingay','gsalingay','Gilbert','Salingay','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:15:59','2011-11-28 13:15:59',NULL,1,0),(46,3,4,'rkcabalhug','rcabalhug','Rey Kan','Cabalhug','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:16:34','2011-11-28 13:16:34',NULL,1,0),(47,3,4,'chtuyan','ctuyan','Christian','Tuyan','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:17:13','2011-11-28 13:17:13',NULL,1,0),(48,3,4,'bemanda','bmanda','Bernabe','Manda','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:49:47','2011-11-28 13:49:47',NULL,1,0),(49,3,4,'gsvillacrusis','gvillacrusis','Gerkie Shane','Villacrusis','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:50:29','2011-11-28 13:50:29',NULL,1,0),(50,3,4,'jepialan','jpialan','Jeraldine','Pialan','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:54:21','2011-11-28 13:54:21',NULL,1,0),(51,3,4,'chrinoc','cinoc','Christine','Inoc','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:55:05','2011-11-28 13:55:05',NULL,1,0),(52,3,4,'aitampos','atampos','Aida ','Tampos','',1,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 13:55:37','2011-11-28 14:00:32',NULL,1,0),(53,3,4,'aitampus','atampus','Aida','Tampus','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 14:01:17','2011-11-28 14:01:17',NULL,1,0),(54,3,4,'racuico','rcuico','Rafael','Cuico','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 14:01:48','2011-11-28 14:01:48',NULL,1,0),(55,3,4,'dadakay','ddakay','Daphne','Dakay','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 14:08:55','2011-11-28 14:08:55',NULL,1,0),(56,3,4,'mipajanostan','mpajanostan','Michelle ','Pajanostan','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 14:09:44','2011-11-28 14:10:04',NULL,1,0),(57,3,4,'fktangag','ftangag','Faith Karen','Tangag','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 14:10:45','2011-11-28 14:10:45',NULL,1,0),(59,3,4,'eaneri','eneri','Earlsel','Neri','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:29:38','2011-11-28 17:29:38',NULL,1,0),(60,3,4,'kmrabina','krabina','Kandy Mae','Rabina','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:30:20','2011-11-28 17:30:20',NULL,1,0),(61,3,4,'njtulop','ntulop','Novy Jay','Tulop','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:40:31','2011-11-28 17:40:31',NULL,1,0),(62,3,4,'dfabarca','dabarca','Dania Franziska','Abarca','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:41:15','2011-11-28 17:41:15',NULL,1,0),(63,3,1,'begerente','bgerente','Benson','Gerente','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:41:54','2011-11-28 17:41:54',NULL,1,0),(64,3,4,'miherbito','mherbito','Mirasol','Herbito','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:43:06','2011-11-28 17:43:06',NULL,1,0),(65,3,4,'tgpelomiana','tpelomiana','Tiffany Grace','Pelomiana','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:44:33','2011-11-28 17:44:33',NULL,1,0),(66,3,4,'aumercado','amercado','Aubrey','Mercado','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:45:13','2011-11-28 17:45:13',NULL,1,0),(67,3,4,'chavila','cavila','Christian','Avila','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:45:43','2011-11-28 17:45:43',NULL,1,0),(68,3,4,'raabejo','rabejo','Randel','Abejo','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:46:13','2011-11-28 17:46:13',NULL,1,0),(69,3,4,'jvtundag','jtundag','Jadda Ville','Tundag','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:46:50','2011-11-28 17:46:50',NULL,1,0),(70,3,4,'smsiroy','ssiroy','Shyrain May','Siroy','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:47:31','2011-11-28 17:47:31',NULL,1,0),(71,3,4,'mrlacerna','mlacerna','Melvin Renie','Lacerna','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:48:09','2011-11-28 17:48:09',NULL,1,0),(72,3,4,'jadinawanao','jdinawanao','James','Dinawanao','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:48:52','2011-11-28 17:48:52',NULL,1,0),(73,3,4,'cjatagocon','ctagocon','Christian Joel Azim','Tagocon','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:49:35','2011-11-28 17:49:35',NULL,1,0),(74,3,4,'lljong','llong','Llloyd Jason','Ong','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:50:27','2011-11-28 17:50:27',NULL,1,0),(75,3,4,'reyamson','ryamson','Renz','Yamson','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:51:01','2011-11-28 17:51:01',NULL,1,0),(76,3,4,'lairuelo','lruelo','Laian','Ruelo','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:51:44','2011-11-28 17:51:44',NULL,1,0),(77,3,4,'maersan','mersan','Marc Avcedy','Ersan','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:52:33','2011-11-28 17:52:33',NULL,1,0),(78,3,4,'bebentillo','bbentillo','Beverly','Bentillo','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:53:10','2011-11-28 17:53:10',NULL,1,0),(79,3,4,'eldacillo','edacillo','Eleonor','Dacillo','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:53:46','2011-11-28 17:53:46',NULL,1,0),(80,3,4,'gmcapundag','gcapundag','Grace May','Capundag','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:54:23','2011-11-28 17:54:23',NULL,1,0),(81,3,4,'mjdeveyra','mdeveyra','Maria Jesan','De Veyra','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:55:05','2011-11-28 17:55:05',NULL,1,0),(82,3,4,'maimove','mmove','Maila Mae','Move','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:55:51','2011-11-28 17:55:51',NULL,1,0),(83,3,4,'malofranco','mlofranco','Marian','Lofranco','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:56:24','2011-11-28 17:56:24',NULL,1,0),(84,3,4,'majolim','mjlim','Mario Joel','Lim','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:57:08','2011-11-28 17:57:08',NULL,1,0),(85,3,4,'mevillanueva','mvillanueva','Mennie','Villanueva','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:58:43','2011-11-28 17:58:43',NULL,1,0),(86,3,4,'emramirez','eramirez','Ester Mae','Ramirez','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 17:59:23','2011-11-28 17:59:23',NULL,1,0),(87,3,4,'habayarcal','hbayarcal','Harlene','Bayarcal','',0,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2011-11-28 18:00:00','2011-11-28 18:00:00',NULL,1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
