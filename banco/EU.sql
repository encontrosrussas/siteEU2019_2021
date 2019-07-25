-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 25-Jul-2019 às 15:02
-- Versão do servidor: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.20-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `EU`
--
CREATE DATABASE IF NOT EXISTS `EU` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `EU`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ano`
--

DROP TABLE IF EXISTS `ano`;
CREATE TABLE IF NOT EXISTS `ano` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_ano` year(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `editais` tinyint(4) NOT NULL DEFAULT '0',
  `cronogramas` tinyint(4) NOT NULL DEFAULT '0',
  `noticias` tinyint(4) NOT NULL DEFAULT '0',
  `palestras` tinyint(4) NOT NULL DEFAULT '0',
  `apresentacoes` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `apresentacoes`
--

DROP TABLE IF EXISTS `apresentacoes`;
CREATE TABLE IF NOT EXISTS `apresentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `area` varchar(20) NOT NULL,
  `ano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_apresentacoes_ano1_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronogramas`
--

DROP TABLE IF EXISTS `cronogramas`;
CREATE TABLE IF NOT EXISTS `cronogramas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` date NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `ano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cronogramas_ano1_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `editais`
--

DROP TABLE IF EXISTS `editais`;
CREATE TABLE IF NOT EXISTS `editais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` longtext,
  `tipo` varchar(100) NOT NULL,
  `ano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_editais_ano_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mini_cursos`
--

DROP TABLE IF EXISTS `mini_cursos`;
CREATE TABLE IF NOT EXISTS `mini_cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `area` varchar(20) NOT NULL,
  `ano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mini_cursos_ano1_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `conteudo` longtext NOT NULL,
  `ano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_noticias_ano1_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `palestras`
--

DROP TABLE IF EXISTS `palestras`;
CREATE TABLE IF NOT EXISTS `palestras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `area` varchar(20) NOT NULL,
  `ano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_palestras_ano1_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `apresentacoes`
--
ALTER TABLE `apresentacoes`
  ADD CONSTRAINT `fk_apresentacoes_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `cronogramas`
--
ALTER TABLE `cronogramas`
  ADD CONSTRAINT `fk_cronogramas_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `editais`
--
ALTER TABLE `editais`
  ADD CONSTRAINT `fk_editais_ano` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `mini_cursos`
--
ALTER TABLE `mini_cursos`
  ADD CONSTRAINT `fk_mini_cursos_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `fk_noticias_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `palestras`
--
ALTER TABLE `palestras`
  ADD CONSTRAINT `fk_palestras_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
