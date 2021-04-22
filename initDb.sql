-- MySQL dump 10.13  Distrib 8.0.23, for osx10.15 (x86_64)
--
-- Host: localhost    Database: TestDatabase
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table `ComponentExtensions`
--

DROP TABLE IF EXISTS `ComponentExtensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ComponentExtensions` (
  `ClassName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Type` enum('variable','function') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'function',
  `Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Arguments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ClassName`,`Name`),
  CONSTRAINT `componentextensions_ibfk_1` FOREIGN KEY (`ClassName`) REFERENCES `Components` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ComponentExtensions`
--

LOCK TABLES `ComponentExtensions` WRITE;
/*!40000 ALTER TABLE `ComponentExtensions` DISABLE KEYS */;
INSERT INTO `ComponentExtensions` VALUES ('main','function','generateNavBarNav','{\"list\": \"string\"}','//function generateNavBarNav(list)\r\nvar list = extractDbFirstCol(list)\r\nvar navBarNav = $(\'<ul/>\').addClass(\"navbar-nav\")\r\nfor (k in list)\r\n	navBarNav.append(\r\n					$(\'<li/>\').addClass(\"nav-item\").append(\r\n						$(\"<a/>\").addClass(\"nav-link\").addClass(k==\"0\"?\"active\":\"\").attr(\"href\",\"#\").text(list[k])\r\n					)\r\n				)\r\nreturn navBarNav;\r\n// } ','2021-04-22 12:36:09');
/*!40000 ALTER TABLE `ComponentExtensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Components`
--

DROP TABLE IF EXISTS `Components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Components` (
  `Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ViewCode` text NOT NULL,
  `ControllerCode` text NOT NULL,
  `ModelCode` text NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Components`
--

LOCK TABLES `Components` WRITE;
/*!40000 ALTER TABLE `Components` DISABLE KEYS */;
INSERT INTO `Components` VALUES ('main','\r\nvar output = $(\"<nav/>\")\r\n.addClass(\"navbar navbar-expand-lg navbar-dark bg-dark\")\r\n.append(\r\n		$(\'<div/>\')\r\n		.addClass(\"container-fluid\")\r\n		.append(\r\n			$(\'<a/>\')\r\n			.addClass(\"navbar-brand\")\r\n			.attr(\"href\",\"#\")\r\n			.text(\"E.N.V.M.A.\")\r\n		).append(\r\n			$(\'<button/>\')\r\n			.addClass(\"navbar-toggler\")\r\n			.attr(\"type\",\"button\")\r\n			.attr(\"data-bs-toggle\",\"collapse\")\r\n			.attr(\"data-bs-target\",\"#mainNavBar\")\r\n			.append($(\"<span/>\").addClass(\"navbar-toggler-icon\"))\r\n		).append(\r\n			$(\'<div/>\')\r\n			.addClass(\"collapse navbar-collapse\")\r\n			.attr(\"id\",\"mainNavBar\")\r\n			.append(this.generateNavBarNav(this.data))\r\n		)\r\n)\r\n$(this.viewEl).empty().append(output)\r\n','','SELECT \"1. Hello\" AS Name UNION ALL SELECT \"2. World\"');
/*!40000 ALTER TABLE `Components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `JavascriptFuncs`
--

DROP TABLE IF EXISTS `JavascriptFuncs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `JavascriptFuncs` (
  `ClassName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Type` enum('variable','function') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'function',
  `Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Arguments` text COLLATE utf8mb4_general_ci,
  `Value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ClassName`,`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `JavascriptFuncs`
--

LOCK TABLES `JavascriptFuncs` WRITE;
/*!40000 ALTER TABLE `JavascriptFuncs` DISABLE KEYS */;
INSERT INTO `JavascriptFuncs` VALUES ('','function','el','{\"tag\": \"string\",\"cssClasses\": \"array\",\"attributes\": \"array\",\"children\": \"array\"}','// function el(tag, cssClasses, attributes, children) {\r\n	var output = $(\"<\"+tag+\"/>\");\r\n	if (typeof cssClasses == \"undefined\") cssClasses = []\r\n	if (typeof cssClasses == \"string\")\r\n		output.addClass(cssClasses)\r\n	else\r\n		for(k in cssClasses) output.addClass(cssClasses[k])\r\n	if (typeof attributes == \"undefined\") attributes = {}\r\n	for (k in attributes) output.attr(k,attributes[k])\r\n	if (typeof children == \"undefined\") children = []\r\n	if (typeof children == \"string\")\r\n		output.text(children)\r\n	else\r\n		for (k in children) output.append(children[k])\r\n	return output;\r\n //}','2021-04-19 16:17:10'),('','function','extractDbFirstCol','{\"a\": \"object\"}','b = []; for (k in a) b.push(a[k][Object.keys(a[k])[0]]); return b;','2021-04-19 16:17:10'),('','function','sayHello','{}','alert(\"Hello\")','2021-04-19 13:45:30'),('bs','function','createBottomNavBarForMobile','{}','// function createBottomNavBarForMobile(links) {\r\n	return el(\"div\",[],{\"id\":\"footer\"},[\r\n	el(\"div\",[\"col-xs-12\",\"navbar-inverse\",\"navbar-fixed-bottom\"],{},[\r\n		el(\"div\",[\"row\"],{\"id\":\"bottomNav\"},[\r\n			el(\"div\",[\"col-xs-4\",\"text-center\"],{},[\r\n				el(\"a\",[],{\"href\":\"#\"},[\r\n					el(\"i\",[\"glyphicon\",\"glyphicon-circle-arrow-left\"]),\r\n					el(\"br\"),\r\n					el(\"span\",[],{},\"link\")\r\n				])\r\n			])\r\n		])\r\n	])\r\n])\r\n//}','2021-04-19 15:16:25');
/*!40000 ALTER TABLE `JavascriptFuncs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-22 13:49:32
