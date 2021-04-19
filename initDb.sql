-- MySQL dump 10.13  Distrib 8.0.22, for osx10.15 (x86_64)
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
-- Table structure for table `JavascriptFuncs`
--

DROP TABLE IF EXISTS `JavascriptFuncs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `JavascriptFuncs` (
  `ClassName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Type` enum('variable','function') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'function',
  `Name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Arguments` json DEFAULT NULL,
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
INSERT INTO `JavascriptFuncs` VALUES ('','function','extractDbFirstCol','{\"a\": \"object\"}','b = []; for (k in a) b.push(a[k][Object.keys(a[k])[0]])','2021-04-19 16:17:10'),('','function','sayHello','{}','alert(\"Hello\")','2021-04-19 13:45:30'),('main','function','generateNavBarNav','{\"list\": \"string\"}','//function generateNavBarNav(list)\r\nvar navBarNav = $(\'<ul/>\').addClass(\"navbar-nav\")\r\nfor (k in list)\r\n	navBarNav.append(\r\n					$(\'<li/>\').addClass(\"nav-item\").append(\r\n						$(\"<a/>\").addClass(\"nav-link\").addClass(k==\"0\"?\"active\":\"\").attr(\"href\",\"#\").text(list[k])\r\n					)\r\n				)\r\nreturn navBarNav;\r\n// } ','2021-04-19 15:16:25'),('main','function','prepareModel','{}','var controller = this\r\n$.ajax({url:\"\",data: {\"sqlCmd\":\"SELECT Name FROM TopMenuItem\"}, success: function (data) { \r\n	controller.TopMenuItems = []\r\n	extractDbFirstCol(data)\r\n	for (k in data) controller.TopMenuItems.push(data[k][\"Name\"])\r\n	controller.renderAt(null)\r\n }});','2021-04-19 15:16:25'),('main','function','renderAt','{\"domEl\": \"object\"}','// function renderAt(domEl) {\r\n	if (domEl !== null) {\r\n		this.renderAtDomEl = domEl\r\n		this.prepareModel()\r\n		return;\r\n	} else {\r\n		domEl = this.renderAtDomEl\r\n	}\r\n		\r\nvar output = $(\"<nav/>\")\r\n.addClass(\"navbar navbar-expand-lg navbar-dark bg-dark\")\r\n.append(\r\n		$(\'<div/>\')\r\n		.addClass(\"container-fluid\")\r\n		.append(\r\n			$(\'<a/>\')\r\n			.addClass(\"navbar-brand\")\r\n			.attr(\"href\",\"#\")\r\n			.text(\"E.N.V.M.A.\")\r\n		).append(\r\n			$(\'<button/>\')\r\n			.addClass(\"navbar-toggler\")\r\n			.attr(\"type\",\"button\")\r\n			.attr(\"data-bs-toggle\",\"collapse\")\r\n			.attr(\"data-bs-target\",\"#mainNavBar\")\r\n			.append($(\"<span/>\").addClass(\"navbar-toggler-icon\"))\r\n		).append(\r\n			$(\'<div/>\')\r\n			.addClass(\"collapse navbar-collapse\")\r\n			.attr(\"id\",\"mainNavBar\")\r\n			.append(this.generateNavBarNav(this.TopMenuItems))\r\n		)\r\n)\r\n$(domEl).empty().append(output)\r\n// }','2021-04-28 13:32:12'),('main','function','__construct','{}','','2021-04-28 13:32:12');
/*!40000 ALTER TABLE `JavascriptFuncs` ENABLE KEYS */;
UNLOCK TABLES;

UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-19 17:18:22
