-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: EU
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `ano`
--

DROP TABLE IF EXISTS `ano`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ano` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_ano` year(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `editais` tinyint(4) NOT NULL DEFAULT '1',
  `cronogramas` tinyint(4) NOT NULL DEFAULT '1',
  `noticias` tinyint(4) NOT NULL DEFAULT '1',
  `palestras` tinyint(4) NOT NULL DEFAULT '1',
  `apresentacoes` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ano`
--

LOCK TABLES `ano` WRITE;
/*!40000 ALTER TABLE `ano` DISABLE KEYS */;
INSERT INTO `ano` VALUES (1,2019,1,1,1,1,1,1),(2,2018,1,0,0,0,0,0);
/*!40000 ALTER TABLE `ano` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apresentacoes`
--

DROP TABLE IF EXISTS `apresentacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apresentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_apresentacoes_ano1_idx` (`ano_id`),
  KEY `fk_apresentacoes_area1_idx` (`area_id`),
  CONSTRAINT `fk_apresentacoes_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_apresentacoes_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apresentacoes`
--

LOCK TABLES `apresentacoes` WRITE;
/*!40000 ALTER TABLE `apresentacoes` DISABLE KEYS */;
INSERT INTO `apresentacoes` VALUES (1,'ap1','2019-07-07','08:30:00',4,1),(2,'sdfsdfsdf','2019-10-19','11:07:00',5,1);
/*!40000 ALTER TABLE `apresentacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `descricao` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'Engenharia Civil','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),(2,'Engenharia Mecanica','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),(3,'Engenharia de ProduÃ§Ã£o','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),(4,'CiÃªncia da ComputaÃ§Ã£o','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),(5,'Engenharia de Software','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cronogramas`
--

DROP TABLE IF EXISTS `cronogramas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cronogramas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` date NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cronogramas_ano1_idx` (`ano_id`),
  CONSTRAINT `fk_cronogramas_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cronogramas`
--

LOCK TABLES `cronogramas` WRITE;
/*!40000 ALTER TABLE `cronogramas` DISABLE KEYS */;
INSERT INTO `cronogramas` VALUES (2,'2019-10-08','iukbhkisxdbvkisdxc',1);
/*!40000 ALTER TABLE `cronogramas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editais`
--

DROP TABLE IF EXISTS `editais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` longtext,
  `tipo` varchar(100) NOT NULL,
  `arquivo` varchar(200) NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_editais_ano_idx` (`ano_id`),
  CONSTRAINT `fk_editais_ano` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editais`
--

LOCK TABLES `editais` WRITE;
/*!40000 ALTER TABLE `editais` DISABLE KEYS */;
INSERT INTO `editais` VALUES (1,'iyzsvdbcskuyd','iusgheusydicsa\r\n','iysdu','',NULL);
/*!40000 ALTER TABLE `editais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mini_cursos`
--

DROP TABLE IF EXISTS `mini_cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mini_cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mini_cursos_ano1_idx` (`ano_id`),
  KEY `fk_mini_cursos_area1_idx` (`area_id`),
  CONSTRAINT `fk_mini_cursos_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_mini_cursos_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mini_cursos`
--

LOCK TABLES `mini_cursos` WRITE;
/*!40000 ALTER TABLE `mini_cursos` DISABLE KEYS */;
INSERT INTO `mini_cursos` VALUES (1,'dsafsdf','2019-10-07','20:05:00',1,5),(2,'dsafsdf','2019-10-07','13:05:00',1,4);
/*!40000 ALTER TABLE `mini_cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `conteudo` longtext NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_noticias_ano1_idx` (`ano_id`),
  CONSTRAINT `fk_noticias_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (2,'a','2019-07-28','21:17:00','asdasdas','asdasdasdasd',NULL);
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `palestras`
--

DROP TABLE IF EXISTS `palestras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `palestras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_palestras_ano1_idx` (`ano_id`),
  KEY `fk_palestras_area1_idx` (`area_id`),
  CONSTRAINT `fk_palestras_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_palestras_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `palestras`
--

LOCK TABLES `palestras` WRITE;
/*!40000 ALTER TABLE `palestras` DISABLE KEYS */;
INSERT INTO `palestras` VALUES (1,'ajksdkjasd','2019-12-07','10:10:00',1,4);
/*!40000 ALTER TABLE `palestras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'guilherme nepomuceno','guilherme@gmail.com','25d55ad283aa400af464c76d713c07ad',1),(2,'susana','susana@gmail.com','e10adc3949ba59abbe56e057f20f883e',2);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-29 12:29:50
