-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 30-Set-2020 às 09:18
-- Versão do servidor: 5.5.62-0+deb8u1
-- PHP Version: 5.6.40-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `EU`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ano`
--

DROP TABLE IF EXISTS `ano`;
CREATE TABLE IF NOT EXISTS `ano` (
`id` int(11) NOT NULL,
  `nome_ano` year(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `editais` tinyint(4) NOT NULL DEFAULT '1',
  `cronogramas` tinyint(4) NOT NULL DEFAULT '1',
  `noticias` tinyint(4) NOT NULL DEFAULT '1',
  `palestras` tinyint(4) NOT NULL DEFAULT '1',
  `apresentacoes` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `apresentacoes`
--

DROP TABLE IF EXISTS `apresentacoes`;
CREATE TABLE IF NOT EXISTS `apresentacoes` (
`id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `resumo` longtext,
  `area_id` int(11) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
`id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `area`
--

INSERT INTO `area` (`id`, `nome`, `descricao`) VALUES
(1, 'Engenharia Civil', ''),
(2, 'Engenharia Mecanica', ''),
(3, 'Engenharia de Produção', ''),
(4, 'Ciência da Computação', ''),
(5, 'Engenharia de Software', ''),
(6, 'Libras', ' '),
(7, 'Diversos', ' ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `artistico`
--

DROP TABLE IF EXISTS `artistico`;
CREATE TABLE IF NOT EXISTS `artistico` (
`id` int(11) NOT NULL,
  `facilitador` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `local` varchar(30) NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `calendario`
--

DROP TABLE IF EXISTS `calendario`;
CREATE TABLE IF NOT EXISTS `calendario` (
`id` int(11) NOT NULL,
  `data` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `ano_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronogramas`
--

DROP TABLE IF EXISTS `cronogramas`;
CREATE TABLE IF NOT EXISTS `cronogramas` (
`id` int(11) NOT NULL,
  `dia` date NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_oficinas`
--

DROP TABLE IF EXISTS `cursos_oficinas`;
CREATE TABLE IF NOT EXISTS `cursos_oficinas` (
`id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `sala` varchar(30) NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `editais`
--

DROP TABLE IF EXISTS `editais`;
CREATE TABLE IF NOT EXISTS `editais` (
`id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` longtext,
  `tipo` varchar(100) NOT NULL,
  `arquivo` varchar(200) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
`id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `subtitulo` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `conteudo` longtext NOT NULL,
  `ano_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `palestras`
--

DROP TABLE IF EXISTS `palestras`;
CREATE TABLE IF NOT EXISTS `palestras` (
`id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `sala` varchar(30) NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `tipo` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

-- Senha desse usuário admin: senha123

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(1, 'Administrador', 'admin@n2s.com', 'fa3c1cdee866e8b57b644e55aa85ad1f001ea14471da9d41cdd3195e5613f4b8b6fff905e7f1afb3954a3e182e92c52497e41decf5718b51a09bfadf52e77f20', 1),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ano`
--
ALTER TABLE `ano`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apresentacoes`
--
ALTER TABLE `apresentacoes`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_apresentacoes_ano1_idx` (`ano_id`), ADD KEY `fk_apresentacoes_area1_idx` (`area_id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artistico`
--
ALTER TABLE `artistico`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_artistico_ano1_idx` (`ano_id`), ADD KEY `fk_artistico_area1_idx` (`area_id`);

--
-- Indexes for table `calendario`
--
ALTER TABLE `calendario`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_calendario_ano1_idx` (`ano_id`);

--
-- Indexes for table `cronogramas`
--
ALTER TABLE `cronogramas`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_cronogramas_ano1_idx` (`ano_id`);

--
-- Indexes for table `cursos_oficinas`
--
ALTER TABLE `cursos_oficinas`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_cursos_oficinas_ano1_idx` (`ano_id`), ADD KEY `fk_cursos_oficinas_area1_idx` (`area_id`);

--
-- Indexes for table `editais`
--
ALTER TABLE `editais`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_editais_ano_idx` (`ano_id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_noticias_ano1_idx` (`ano_id`);

--
-- Indexes for table `palestras`
--
ALTER TABLE `palestras`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_palestras_ano1_idx` (`ano_id`), ADD KEY `fk_palestras_area1_idx` (`area_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ano`
--
ALTER TABLE `ano`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `apresentacoes`
--
ALTER TABLE `apresentacoes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `artistico`
--
ALTER TABLE `artistico`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `calendario`
--
ALTER TABLE `calendario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `cronogramas`
--
ALTER TABLE `cronogramas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cursos_oficinas`
--
ALTER TABLE `cursos_oficinas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `editais`
--
ALTER TABLE `editais`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `palestras`
--
ALTER TABLE `palestras`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
-- Limitadores para a tabela `artistico`
--
ALTER TABLE `artistico`
ADD CONSTRAINT `fk_artistico_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `fk_artistico_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `calendario`
--
ALTER TABLE `calendario`
ADD CONSTRAINT `fk_calendario_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
