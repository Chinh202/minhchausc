/*
Navicat MySQL Data Transfer

Source Server         : ahihi
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : minhchausc

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-09 07:07:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `phonenumber1` varchar(15) DEFAULT NULL,
  `phonenumber2` varchar(15) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nick_skype` varchar(100) DEFAULT NULL,
  `nick_face` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------

-- ----------------------------
-- Table structure for producer
-- ----------------------------
DROP TABLE IF EXISTS `producer`;
CREATE TABLE `producer` (
  `producer_id` int(11) NOT NULL AUTO_INCREMENT,
  `producer_name` varchar(100) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `img_url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`producer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of producer
-- ----------------------------
INSERT INTO `producer` VALUES ('1', 'Hikvision', 'China', null);
INSERT INTO `producer` VALUES ('2', 'YunYang', 'China', null);
INSERT INTO `producer` VALUES ('3', 'AOLIN', 'China', null);
INSERT INTO `producer` VALUES ('4', 'Hyundai Telecom', 'China', null);

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) DEFAULT NULL,
  `product_price` bigint(20) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `producer_id` int(11) NOT NULL,
  `production_year` int(11) DEFAULT NULL,
  `url_img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `type_id_fr` (`type_id`),
  KEY `pr_id_fk` (`producer_id`),
  CONSTRAINT `pr_id_fk` FOREIGN KEY (`producer_id`) REFERENCES `producer` (`producer_id`),
  CONSTRAINT `type_id_fr` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for product_details
-- ----------------------------
DROP TABLE IF EXISTS `product_details`;
CREATE TABLE `product_details` (
  `product_id` int(11) NOT NULL,
  `specifications_id` int(11) NOT NULL,
  `specifications_des` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`specifications_id`),
  KEY `spe_id_fr` (`specifications_id`),
  CONSTRAINT `pro_id_fr` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `spe_id_fr` FOREIGN KEY (`specifications_id`) REFERENCES `specifications` (`specifications_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_details
-- ----------------------------

-- ----------------------------
-- Table structure for product_type
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) DEFAULT NULL,
  `url_img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_type
-- ----------------------------

-- ----------------------------
-- Table structure for specifications
-- ----------------------------
DROP TABLE IF EXISTS `specifications`;
CREATE TABLE `specifications` (
  `specifications_id` int(11) NOT NULL,
  `specifications_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`specifications_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of specifications
-- ----------------------------
