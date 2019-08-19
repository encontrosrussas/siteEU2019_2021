-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 19-Ago-2019 às 12:35
-- Versão do servidor: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.21-1+ubuntu18.04.1+deb.sury.org+1

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
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `editais` tinyint(4) NOT NULL DEFAULT '1',
  `cronogramas` tinyint(4) NOT NULL DEFAULT '1',
  `noticias` tinyint(4) NOT NULL DEFAULT '1',
  `palestras` tinyint(4) NOT NULL DEFAULT '1',
  `apresentacoes` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ano`
--

INSERT INTO `ano` (`id`, `nome_ano`, `status`, `editais`, `cronogramas`, `noticias`, `palestras`, `apresentacoes`) VALUES
(1, 2019, 1, 1, 1, 1, 1, 1),
(2, 2018, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `apresentacoes`
--

DROP TABLE IF EXISTS `apresentacoes`;
CREATE TABLE IF NOT EXISTS `apresentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `resumo` longtext,
  `area_id` int(11) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_apresentacoes_ano1_idx` (`ano_id`),
  KEY `fk_apresentacoes_area1_idx` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `descricao` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `area`
--

INSERT INTO `area` (`id`, `nome`, `descricao`) VALUES
(1, 'Engenharia Civil', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),
(2, 'Engenharia Mecanica', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),
(3, 'Engenharia de ProduÃ§Ã£o', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),
(4, 'CiÃªncia da ComputaÃ§Ã£o', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.'),
(5, 'Engenharia de Software', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum quidem obcaecati, consequatur dolorem tenetur ullam laudantium iusto, odit deserunt autem dolorum, repellat atque amet! Nisi ab nulla obcaecati fugit nostrum.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronogramas`
--

DROP TABLE IF EXISTS `cronogramas`;
CREATE TABLE IF NOT EXISTS `cronogramas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` date NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cronogramas_ano1_idx` (`ano_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_oficinas`
--

DROP TABLE IF EXISTS `cursos_oficinas`;
CREATE TABLE IF NOT EXISTS `cursos_oficinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cursos_oficinas_ano1_idx` (`ano_id`),
  KEY `fk_cursos_oficinas_area1_idx` (`area_id`)
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
  `arquivo` varchar(200) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_editais_ano_idx` (`ano_id`)
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
  `ano_id` int(11) DEFAULT NULL,
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
  `imagem` varchar(200) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_palestras_ano1_idx` (`ano_id`),
  KEY `fk_palestras_area1_idx` (`area_id`)
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(1, 'guilherme nepomuceno', 'guilherme@gmail.com', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 1),
(2, 'susana', 'susana@gmail.com', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 2);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `apresentacoes`
--
ALTER TABLE `apresentacoes`
  ADD CONSTRAINT `fk_apresentacoes_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_apresentacoes_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `cronogramas`
--
ALTER TABLE `cronogramas`
  ADD CONSTRAINT `fk_cronogramas_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `cursos_oficinas`
--
ALTER TABLE `cursos_oficinas`
  ADD CONSTRAINT `fk_cursos_oficinas_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cursos_oficinas_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `editais`
--
ALTER TABLE `editais`
  ADD CONSTRAINT `fk_editais_ano` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `fk_noticias_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `palestras`
--
ALTER TABLE `palestras`
  ADD CONSTRAINT `fk_palestras_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_palestras_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
