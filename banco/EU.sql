-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 16-Nov-2020 às 10:12
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `EU`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ano`
--

DROP TABLE IF EXISTS `ano`;
CREATE TABLE IF NOT EXISTS `ano` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_ano` year(4) NOT NULL,
  `id_evento` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `editais` tinyint(4) NOT NULL DEFAULT '1',
  `cronogramas` tinyint(4) NOT NULL DEFAULT '1',
  `noticias` tinyint(4) NOT NULL DEFAULT '1',
  `palestras` tinyint(4) NOT NULL DEFAULT '1',
  `apresentacoes` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ano`
--

INSERT INTO `ano` (`id`, `nome_ano`, `id_evento`, `status`, `editais`, `cronogramas`, `noticias`, `palestras`, `apresentacoes`) VALUES
(1, 2019, NULL, 0, 1, 1, 1, 1, 1),
(2, 2018, NULL, 0, 0, 0, 0, 0, 0),
(3, 2020, 4, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `apresentacoes`
--

DROP TABLE IF EXISTS `apresentacoes`;
CREATE TABLE IF NOT EXISTS `apresentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `resumo` longtext,
  `autor` varchar(250) NOT NULL,
  `trilha` varchar(150) DEFAULT NULL,
  `id_fake` int(11) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_fake` (`id_fake`),
  KEY `fk_apresentacoes_ano1_idx` (`ano_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `apresentacoes`
--

INSERT INTO `apresentacoes` (`id`, `nome`, `resumo`, `autor`, `trilha`, `id_fake`, `ano_id`) VALUES
(1, 'PROMOVENDO  INTEGRAÃ‡ÃƒO ENTRE ALUNAS DA TI DO CAMPUS DE RUSSAS', 'Grandes avanÃ§os estÃ£o sendo feitos para discutir sobre a participaÃ§Ã£o feminina na ComputaÃ§Ã£o. Como exemplo, o Women in Information Technology (WIT), um evento da Sociedade Brasileira de ComputaÃ§Ã£o, que abriu um indispensÃ¡vel espaÃ§o para discussÃµes nas questÃµes de gÃªnero, permite tambÃ©m o acesso a informaÃ§Ãµes do processo de construÃ§Ãµes histÃ³ricas com participaÃ§Ã£o da  mulher, alÃ©m de reforÃ§ar a busca pela equidade de oportunidades. Diante do quantitativo relacionado ao ingresso e evasÃ£o de alunas nos cursos de CiÃªncia da ComputaÃ§Ã£o (CC) e Engenharia de Software (ES) no campus da Universidade Federal do CearÃ¡ em Russas, que indicam que o nÃºmero de mulheres que ingressam nos cursos de Tecnologia da informaÃ§Ã£o (TI) Ã© bem menor do que o nÃºmero de homens, tornam-se importantes aÃ§Ãµes que objetivem o fortalecimento da participaÃ§Ã£o feminina na Ã¡rea. Para definir aÃ§Ãµes adequadas, foi necessÃ¡rio identificar os desafios e motivaÃ§Ãµes que poderiam ocasionar a evasÃ£o de alunas dos cursos de TI. Neste trabalho, serÃ£o relatados as aÃ§Ãµes realizadas nos semestres 2019.1 e 2019.2 com as alunas dos cursos de ES e CC. O acompanhamento do ingresso e evasÃ£o das alunas antes e depois do inÃ­cio do projeto indica que a permanÃªncia de alunas entre o 2Â° e 6Â° semestres de ES vÃªm crescendo, ao passo que a permanÃªncia de alunas entre o 4Â° e 6Â° semestres de CC vÃªm reduzindo, sendo necessÃ¡rias estratÃ©gias direcionadas a este pÃºblico e identificaÃ§Ã£o de causas para este cenÃ¡rio.\r\n', 'KARINA DA SILVA CASTELO BRANCO', 'Apoio de Projetos de GraduaÃ§Ã£o - Estendidos', 111, 3),

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `area`
--

INSERT INTO `area` (`id`, `nome`, `descricao`) VALUES
(1, 'Engenharia Civil', ''),
(2, 'Engenharia Mecanica', ''),
(3, 'Engenharia de ProduÃ§Ã£o', ''),
(4, 'CiÃªncia da ComputaÃ§Ã£o', ''),
(5, 'Engenharia de Software', ''),
(6, 'Libras', ' '),
(7, 'Diversos', ' ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `artistico`
--

DROP TABLE IF EXISTS `artistico`;
CREATE TABLE IF NOT EXISTS `artistico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facilitador` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `local` varchar(30) NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `imagem_descricao` varchar(200) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_artistico_ano1_idx` (`ano_id`),
  KEY `fk_artistico_area1_idx` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `artistico`
--

INSERT INTO `artistico` (`id`, `facilitador`, `titulo`, `data`, `resumo`, `local`, `imagem`, `imagem_descricao`, `tipo`, `ano_id`, `area_id`) VALUES
(1, 'Orismildes Neto', 'Stand Up Comedy', '06/11/19 as 13:00 atÃ© 13:30', '<p>Trazer um momento de lazer para o pÃºblico atravÃ©s de piadas.</p>', 'AuditÃ³rio', '04-11-2019-11-03-06.jpg', NULL, 1, 1, 7),
(2, 'Banda BehÃº', 'Banda BehÃº', '06/11/19 as 16:30 atÃ© 17:30', '<p>Show: BEHÃš - Retratos na Areia;</p><p>Sinopse do Show</p><p>â€œRetratos na Areiaâ€ da banda cearense BEHÃš, Ã© o primeiro trabalho cÃªnico-musical do grupo. Na busca de uma sonoridade Ãºnica, as composiÃ§Ãµes trazem um quÃª experimental mesclando diversos elementos da psicodelia nordestina e rock setentista, sem se prender necessariamente a um estilo e trazendo consigo uma singularidade em uma nova maneira de bordar o som, muito evidente em sua performance ao vivo. O show traz em si um ar teatral, em que as mÃºsicas dialogam com intervenÃ§Ãµes performÃ¡ticas, mÃ¡scaras e poemas, criando uma atmosfera sinestÃ©sica e onÃ­rica para a palco.</p>', 'Palco', '04-11-2019-11-02-47.jpg', NULL, 1, 1, 7),
(3, 'Banda Radio 4', 'Banda Radio 4', '08/11/19 as 16:30 atÃ© 17:30', '<p>Radio 4 traz a proposta de fazer uma mÃºsica diferenciada para o Vale do Jaguaribe, tocando ritmos variados como Jovem Guarda, Disco Music, Reagge, Pop e Rock, tanto nacional quanto internacional.</p>', 'Palco', '04-11-2019-11-02-28.jpeg', NULL, 1, 1, 7),
(4, 'Elba Mara Paiva Lima', 'Doces das Mulheres Empreendedoras', '06/11  -tarde, 07/11 e 08/11 pela manhÃ£ e a tarde', '<p>Tem o objetivo de expor a toda comunidade acadÃªmica e demais participantes do evento os produtos produzidos pelo grupo de Mulheres Empreendedoras da comunidade de Bom Sucesso-QuixerÃ©. As mesmas buscam se empoderar e alcanÃ§ar melhores condiÃ§Ãµes de vida por meio da produÃ§Ã£o e venda de doces caseiros. A fÃ¡brica de cimento Apodi, em parceria com o Grupo de Desenvolvimento em Sustentabilidade da UFC campus Russas, tÃªm dado todo o apoio necessÃ¡rio para que as mesmas alcancem seus objetivos de forma satisfatÃ³ria. Nesse sentido, esse seria um momento muito importante para o projeto, tendo em vista que mais pessoas conheceriam os seus produtos e contribuÃ­ram com o sucesso do negÃ³cio.</p>', 'hall de entrada do Campus.	', NULL, NULL, 4, 1, 7),
(5, 'Francisco Luciano Quirino da Silva', 'Eu Desenho Moda', '06/11  -tarde, 07/11 e 08/11 pela manhÃ£ e a tarde', '<p>Na moda, os rabiscos iniciais sÃ£o chamados de croqui, em que nasce a peÃ§a piloto. O croqui Ã© uma ferramenta fundamental para a criaÃ§Ã£o de novos produtos no segmento de moda, ele possibilita que o designer possa expressar suas ideias por meio de linhas, representando formas, contornos, cores, texturas e padronagens. A exposiÃ§Ã£o tem como objetivo apresentar desenhos de moda desenvolvidos por Luciano Quirino mostrando a evoluÃ§Ã£o de seus trabalhos.&nbsp;</p>', 'hall de entrada do Campus.', NULL, NULL, 4, 1, 7),
(6, 'Francisco Luciano Quirino da Silva', 'Intercambistas - Relatos de ExperiÃªncia', '06/11  -tarde, 07/11 e 08/11 pela manhÃ£ e a tarde', '<p>A exposiÃ§Ã£o tem como objetivo apresentar o livro Intercambistas â€“ Relatos de ExperiÃªncias, que apresenta um pequeno relato de 4 estudantes brasileiras que estiveram em intercÃ¢mbio em Portugal durante o perÃ­odo 2018/2019. Durante a exposiÃ§Ã£o pretende-se apresentar o conceito do design do livro desenvolvido pelo aluno no perÃ­odo de intercÃ¢mbio.&nbsp;</p>', 'hall de entrada do Campus.', NULL, NULL, 4, 1, 7),
(7, 'Karina da Silva Castelo Branco', 'Meninas Digitais do Vale', '06/11  -tarde, 07/11 e 08/11 pela manhÃ£ e a tarde', '<p>O projeto Meninas Digitais do Vale tem como objetivo fortalecer a participaÃ§Ã£o feminina nos cursos de CiÃªncia da ComputaÃ§Ã£o e Engenharia de Software da UFC no campus de Russas. Algumas aÃ§Ãµes tem sido realizada com o objetivo de integrar as alunas dos cursos de TI, combater o nÃºmero de evasÃµes e aumentar a representatividade feminina. Na feira das profissÃµes vÃ£o ser expostas as aÃ§Ãµes que o projeto realiza, resultados alcanÃ§ados e como fazer parte do projeto.</p>', 'hall de entrada do Campus.', NULL, NULL, 4, 1, 7),
(8, 'Amanda da Silva Lima Carvalho', 'Morena Bunita', '06/11  -tarde, 07/11 e 08/11 pela manhÃ£ e a tarde', '<p>Aqui apresentamos um conceito de moda que acompanha as tendÃªncias de mercado, oferecendo produtos de baixo custo e qualidade.</p>', 'hall de entrada do Campus.', NULL, NULL, 4, 1, 7),
(9, 'Ismael Moreira de Sousa', 'Run-Aedes', '06/11  -tarde, 07/11 e 08/11 pela manhÃ£ e a tarde', '<p>O Aedes aegypti Ã© o transmissor de muitas doenÃ§as, tais como: dengue, febre amarela, zika e chikungunya. De certo, algumas dessas doenÃ§as sÃ£o bem graves e nÃ£o possuem tratamentos, podendo levar a Ã³bito. Sabe-se que a melhor forma de prevenir a proliferaÃ§Ã£o do mosquito Ã© promover a conscientizaÃ§Ã£o da populaÃ§Ã£o. Para isso, foi proposto o uso de jogos digitais mobile (aparelhos eletrÃ´nicos mÃ³veis) para ensinar sobre o mosquito e as doenÃ§as transmitidas. Tendo analisado o aprendizado do Run-Aedes com 18 pessoas, entre elas, crianÃ§as, adolescentes e adultos, obteve-se 78,94% de acertos nas perguntas do questionÃ¡rio sobre o jogo, alÃ©m da diversÃ£o observada nos participantes, assim, mostrando-se eficiente na aprendizagem sobre o Aedes.</p>', 'hall de entrada do Campus.', NULL, NULL, 4, 1, 7),
(10, 'ONG Anjos de PET', 'ONG Anjos de PET', '06/11 - TARDE, 07/11 - MANHÃƒ, 07/11 - TARDE', '<p>Somos um grupo organizado de pessoas de vÃ¡rias comunidades do MunicÃ­pio de Russas/CE, sem fins lucrativos, com a finalidade e interesse social na defesa dos animais domÃ©sticos (cÃ£es e gatos) abandonados nas praÃ§as e ruas, procriando desordenadamente e sofrendo por vezes crueldade com maus tratos.</p>', ' ', '04-11-2019-11-05-42.jpeg', NULL, 3, 1, 7),
(11, 'Deusdedit Teixeira de Sousa Neto', 'AdoÃ§Ã£o de animais', '06/11    Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(12, 'Charles de Oliveira Brito', 'Ajude Uma ONG', '06/11     Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(13, 'Iara de Lima Cruz ', 'AmigosPets', '06/11     Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(14, 'Bruna Batista da Silva', 'Aplicativo Mobile', '07/11  ManhÃ£', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(15, 'Mateus EugÃªnio de Andrade', 'Care 4 Pets', '07/11  ManhÃ£', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(16, 'Francisca Kelen Ferreira dos Santos', 'HOME PET', '07/11  ManhÃ£', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(17, 'Matheus Freire de Oliveira', 'IrmÃ£os de Pata', '07/11  Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(18, 'Emanuel de Oliveira FÃ©lix', 'Petfinder - Adote um amigo', '07/11  Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(19, 'Lucas AntÃ´nio Ferreira Almeida', 'MAPET', '07/11  Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(20, 'Lucas Rafael Alves Oliveira', 'Adote Um Amigo', '08/11   ManhÃ£', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(21, 'Maria Clara de Abreu Silva', 'Aplicativo AjudaPet', '08/11  ManhÃ£', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(22, 'Ismael Moreira de Sousa', 'Dog Simulator', '08/11  ManhÃ£', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(23, 'Francisco Adam de Andrade', 'Manual dos animais ', '08/11  Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(24, 'Gabriel Nogueira Bezerra ', 'Van da SaÃºde', '08/11  Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(25, 'Gabriel FonsÃªca de Oliveira JÃºnior', 'Cabine Pets', '08/11  Tarde', '<p>Em Breve.</p>', 'A Definir', NULL, NULL, 3, 1, 7),
(26, 'Dindin do Bigas', 'Dindin do Bigas', '06/11  Tarde,    07/11 e 08/11   ManhÃ£', '<p>Em breve.</p>', 'Hall de Entrada do Campus', NULL, NULL, 4, 1, 7),
(27, 'Trufas do Dudu', 'Trufas do Dudu', '06/11  Tarde,    07/11 e 08/11   ManhÃ£', '<p>Em Breve.</p>', 'Hall de Entrada do Campus', NULL, NULL, 4, 1, 7),
(28, 'Banda Cisnes Selvagens', 'Banda Cisnes Selvagens', '07/11   16h30 Ã s 17h30', '<p>Em Breve.</p>', 'Palco', '04-11-2019-20-12-30.png', NULL, 1, 1, 7),
(29, 'Concerto da Camerata de Cordas da UFC', 'Concerto da Camerata de Cordas da UFC', '06/11     11h30 Ã s 12h10', '<p>A Camerata de Cordas da UFC - Fortaleza iniciou suas atividades em MarÃ§o de 2016, como conjunto de mÃºsica de cÃ¢mara do Instituto de Cultura e Arte da Universidade Federal do CearÃ¡, sob direÃ§Ã£o das profas. Dra. Liu Man Ying (violino e viola) e Ms. Dora Utermohl de Queiroz (violoncelo e contrabaixo) e conta com o apoio da Secretaria de Cultura ArtÃ­stica da UFC. Este grupo desenvolve um repertÃ³rio pedagogicamente selecionado e atua como um conjunto musical de apoio Ã s disciplinas de ensino coletivo de cordas do curso de Licenciatura em MÃºsica da UFC Campus de Fortaleza.</p><p>&nbsp;</p><p>Coordenadoras</p><p>Profa. Dra. Liu Man Ying realizou sua graduaÃ§Ã£o em Bacharelado em Instrumento Violino na Escola de ComunicaÃ§Ãµes e Artes pela Universidade de SÃ£o Paulo (2004), Ã© Mestre em Musicologia pela ECA - USP (2007), Doutora em MÃºsica ECA - USP (2012) e atualmente realiza pesquisas de PÃ³s-doutorado no Instituto de Artes da UNESP. Foi professora de violino da Faculdade Paulista de Artes e da Faculdade Santa Marcelina, e violinista da Orquestra Jazz SinfÃ´nica do Estado de SÃ£o Paulo (1996-2015). Foi professora do Festival MÃºsica nas Montanhas de PoÃ§os de Caldas e Festival de MÃºsica de Itu. Atualmente Ã© professora de violino e viola do curso de Licenciatura em MÃºsica da Universidade Federal do CearÃ¡, coordenadora da Camerata de Cordas da UFC, do programa CASa de Artes de formaÃ§Ã£o docente da UFC e do projeto de extensÃ£o Ensino Coletivo de Violino e Viola.</p><p>Profa. Ms. Dora Utermohl de Queiroz Ã© mestre em mÃºsica e bacharel em violoncelo pela Universidade Federal do Rio Grande do Norte (UFRN). Foi artista residente no Festival MÃºsica nas Montanhas (PoÃ§os de Caldas), MIMO (Olinda) tocando juntamente com o grupo UFRN CELLOS, e do Festival Internacional de MÃºsica de BelÃ©m. Em 2015 ministrou aulas de violoncelo nos festivais â€œII Violoncelos em Foliaâ€, â€œFestival Eurochestriesâ€ e â€œXX Semana da MÃºsica da UECEâ€. Ã‰ professora de violoncelo no curso de Licenciatura em MÃºsica da Universidade Federal do CearÃ¡ (UFC), onde colabora intensamente com o programa de extensÃ£o PrÃ¡tica Instrumental SinfÃ´nica, integrando a Orquestra SinfÃ´nica da UFC Fortaleza e coordenadora do projeto Grupo de Violoncelos da UFC, Oficinas de Violoncelo e do programa CASa de Artes de formaÃ§Ã£o docente da UFC.</p>', 'Palco', '04-11-2019-20-05-13.jpeg', NULL, 1, 1, 7),
(30, 'O menino que descobriu o vento', 'O menino que descobriu o vento', '07/11   14h00', '<p>O menino que descobriu o vento<br>(2019 - Drama - 1h 53m)<br><br>&nbsp;</p><p>SINOPSE:</p><p>Sempre esforÃ§ando-se para adquirir conhecimentos cada vez mais diversificados, um jovem de Malawi se cansa de assistir todos os colegas de seu vilarejo passando por dificuldades e comeÃ§a a desenvolver uma inovadora turbina de vento.</p><p><br>&nbsp;</p>', 'AuditÃ³rio', '07-11-2019-10-39-10.png', NULL, 2, 1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `calendario`
--

DROP TABLE IF EXISTS `calendario`;
CREATE TABLE IF NOT EXISTS `calendario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `link` varchar(300) DEFAULT NULL,
  `icone` varchar(50) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_calendario_ano1_idx` (`ano_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `calendario`
--

INSERT INTO `calendario` (`id`, `data`, `descricao`, `link`, `icone`, `ano_id`) VALUES
(1, '20 de Setembro', 'LanÃ§amento do Edital.', NULL, NULL, 1),
(2, '28 de Setembro a 07 de Outubro', 'Primeira fase de submissÃ£o dos trabalhos.', NULL, NULL, 1),
(3, '28 de Setembro a 08 de Outubro', 'PerÃ­odo de aval do orientador.', NULL, NULL, 1),
(4, '08 a 14 de Outubro', 'AvaliaÃ§Ã£o dos trabalhos submetidos.', NULL, NULL, 1),
(5, '17 de Outubro', 'DivulgaÃ§Ã£o dos resultados das submissÃµes.', NULL, NULL, 1),
(6, '18 a 21 de Outubro', 'PerÃ­odo de recurso para os trabalhos nÃ£o aceitos.', NULL, NULL, 1),
(7, '<strike>22 a 26 de Outubro</strike> <span style=\'color:red\'>22 a 28 de Outubro (Alterado)</span>', 'ReavaliaÃ§Ã£o dos trabalhos submetidos no perÃ­odo de recurso.', NULL, NULL, 1),
(8, '<strike>27 de Outubro</strike> <span style=\'color:red\'>29 de Outubro (Alterado)</span>', 'DivulgaÃ§Ã£o dos resumos aceitos para submissÃ£o final.', NULL, NULL, 1),
(9, '<strike>28 a 30 de Outubro</strike> <span style=\'color: red\'>29 a 31 de Outubro (Alterado)</span>', 'SubmissÃ£o final de todos os trabalhos aceitos.', NULL, NULL, 1),
(10, '06 a 08 de Novembro', 'IV Encontros UniversitÃ¡rios da UFC em Russas', NULL, NULL, 1),

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
  `titulo` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `sala` varchar(30) NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `imagem_descricao` varchar(200) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cursos_oficinas_ano1_idx` (`ano_id`),
  KEY `fk_cursos_oficinas_area1_idx` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cursos_oficinas`
--

INSERT INTO `cursos_oficinas` (`id`, `nome`, `titulo`, `data`, `resumo`, `sala`, `imagem`, `imagem_descricao`, `tipo`, `ano_id`, `area_id`) VALUES
(1, 'Beatriz Machado', 'Fotografia de bolso: obtenha Ã³timas imagens com seu smartphone', '07/11 as 10:00 atÃ© 12:00', '<p>AcadÃªmica do curso de Engenharia de Software e freelancer em fotografia hÃ¡ 1 ano e meio, atualmente fotÃ³grafa da produtora audiovisual Ailika ProduÃ§Ãµes.</p><p>Obtenha Ã³timas imagens com seu smartphone: Celulares que fotografam ou cÃ¢meras que telefonam? Atualmente, os dispositivos mÃ³veis tÃªm vÃ¡rias funÃ§Ãµes para captura de imagem. Eles incorporam aplicaÃ§Ãµes de cÃ¢meras fotogrÃ¡ficas mais elaboradas e podem gerar arquivos de qualidade semelhante a equipamentos profissionais. Sabendo usar seu smartphone vocÃª pode fotografar, editar e compartilhar belas imagens em instantes. Aprenda nesta oficina a dominar tÃ©cnicas de fotografia e ediÃ§Ã£o para registrar grandes momentos de maneira ainda mais bela.&nbsp;</p><p>&nbsp;</p><p>NÃºmero de vagas: 30 vagas</p><p>Tempo da atividade: 2h</p><p>&nbsp;</p><p>anabeatrizcmachado@gmail.com</p>', 'A definir', '20-09-2019-08-44-35.png', NULL, 2, 1, 7),
(2, 'Luiza Fernanda de Oliveira Albano Carvalho e Veridiano Ferreira de Carvalho', 'Minicurso Libras no Campus', '06/11 as 13:30 atÃ© 17:30 e 07/11 as 08:00 atÃ© 12:00', '<p>\"Libras no Campus\" Russas tem como objetivo sensibilizar a comunidade acerca do sujeito surdo e sua lÃ­ngua que Ã© a LÃ­ngua Brasileira de Sinais â€“ LIBRAS e apresentar a introduÃ§Ã£o de lÃ©xicos bÃ¡sicos da segunda LÃ­ngua oficial do PaÃ­s.</p><p>Vagas: 40 Pessoas</p><p>Tempo da atividade: 8h</p><p>&nbsp;</p><p><a href=\"https://forms.gle/mHjVrBS2m4Mdjgqh8\">Link para InscriÃ§Ã£o</a></p>', 'A definir', '20-09-2019-08-48-32.jpeg', NULL, 1, 1, 6),
(3, 'Larissa Miguel Sousa', 'Conhecendo e construindo o currÃ­culo Lattes', '07/11 as 14:00 atÃ© 16:00 ', '<p>BibliotecÃ¡ria pela Universidade Federal do CearÃ¡, Campus de Fortaleza, e graduanda de Engenharia de Software pela mesma InstituiÃ§Ã£o, Campus de Russas.</p><p>VocÃª sabe como funciona e para que serve a plataforma de currÃ­culo Lattes? Nessa oficina iremos orientar os participantes sobre o<br>preenchimento do currÃ­culo Lattes e saber como ele se tornado presente<br>na vida acadÃªmica e profissional de estudantes, professores e<br>pesquisadores das mais diversas Ã¡reas do conhecimento.</p><p>&nbsp;</p><p>NÃºmero de Vagas: 25 vagas</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: &nbsp;https://forms.gle/Q4LxXj7FKhHgvvhn6&nbsp;</p>', 'A definir', '27-09-2019-08-22-09.jpg', NULL, 2, 1, 7),
(4, 'JÃ©ssica de Sousa Carvalho', 'Entrei na universidade, e agora? A importÃ¢ncia do plano de carreira do discente. ', '06/11    as 15:30 atÃ©  17:30', '<p>A temÃ¡tica principal Ã© conversar sobre como ter um planejamento durante a graduaÃ§Ã£o visando o mercado de trabalho, seja ele na carreira acadÃªmica ou industrial.</p><p>&nbsp;</p><p>NÃºmero de Vagas: 30</p><p>Carga HorÃ¡ria: 2H</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: https://forms.gle/Psuv7HtMAX7i424y9</p>', 'A Definir ', NULL, NULL, 2, 1, 7),
(5, 'Ãcaro LourenÃ§o', 'Oficina de IniciaÃ§Ã£o Teatral - Jogos Teatrais', '06/11, 07/11 e 08/11  as  15:00 atÃ©  16:00', '<p>Por meio de &nbsp;exercÃ­cios de consciÃªncia corporal, e &nbsp;jogos &nbsp;teatrais e dramÃ¡ticos promover a desmesmerizaÃ§Ã£o e sensibilizaÃ§Ã£o do corpo dos educandos, de modo a instalar &nbsp;um tal â€œestado de jogo ou de brincadeiraâ€ onde os â€œalunos-jogadoresâ€ &nbsp;sintam-se inteiramente presentes e &nbsp;livres para experienciar o lÃºdico a nÃ­vel intelectual, fÃ­sico e intuitivo; e lanÃ§ar-se sem reservas em processos inventivos de possÃ­veis &nbsp;soluÃ§Ãµes para &nbsp;problemas instalados no espaÃ§o-tempo de jogo. Em &nbsp;â€œestado de brincadeiraâ€ o aluno-jogador &nbsp;transcende a si mesmo e se aventura corajosamente no desconhecido. Ã€ medida em que se diverte, desenvolve habilidades e capacidades expressivas,criativas,estÃ©ticas,artÃ­sticas e interpessoais &nbsp;necessÃ¡rias para jogo, para a cena e para prÃ³pria vida.</p><p>&nbsp;</p><p>NÃºmero de Vagas. 60</p><p>Carga HorÃ¡ria: 3H</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: https://forms.gle/Ps8DzCuHUoHMqMWw6</p>', 'Sl 09 Bl 1A TÃ©rreo', NULL, NULL, 2, 1, 7),
(6, 'JoÃ£o Marcos', 'IntroduÃ§Ã£o a SeguranÃ§a da InformaÃ§Ã£o', '08/11 as 10:00 atÃ© 11:30', '<p>Com o crescimento da tecnologia nos Ãºltimos anos, a preocupaÃ§Ã£o pela seguranÃ§a vem crescendo cada vez mais, visto quando se trata de privacidade pessoais ou empresariais. Esse minicurso tem o objetivo de fazer uma breve apresentaÃ§Ã£o sobre a seguranÃ§a da informaÃ§Ã£o, mostrando a sua importÃ¢ncia no contexto atual.</p><p>&nbsp;</p><p>NÃºmero de vagas: 60 vagas</p><p>Tempo da atividade: 1h30</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: &nbsp;https://forms.gle/kG1zfDdYWBwDCVXq6</p>', 'A definir', NULL, NULL, 1, 1, 7),
(9, 'Pedro Italo Campos Da Silva', 'AnÃ¡lise estatÃ­stica usando Rstudio', '06/11   14h00 Ã s 16h00  e  07/11   08h00 Ã s 10h00', '<p>Introduzir para comunidade acadÃªmica a ferramenta RStudio, para analise dados, tornando o processo estÃ¡ticos mais rÃ¡pido. O curso terÃ¡ com objetivo incentivar os alunos a buscar novas tecnologias que possa trazer comodidade para os trabalho da faculdade e outras utilidades.</p><p>&nbsp;</p><p>NÃºmero de vagas: 25 vagas</p><p>Carga HorÃ¡ria: 4h</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: &nbsp;https://docs.google.com/forms/d/e/1FAIpQLSeRiJPUdmtATuhzRtig9YChSk78PzR51nWCMzqE4hP4gNj_Ug/viewform</p><p>&nbsp;</p><p>&nbsp;</p><p><br>&nbsp;</p>', 'LaboratÃ³rio 2A', NULL, NULL, 1, 1, 5),
(10, 'Germanno Correia Rocha', 'PrototipaÃ§Ã£o com Acessibilidade', '07/11 as 8:00 atÃ© 12:00', '<p>A Oficina de PrototipaÃ§Ã£o AcessÃ­vel abordarÃ¡ a utilizaÃ§Ã£o de tÃ©cnicas de prototipaÃ§Ã£o, de baixa e alta fidelidade, de forma prÃ¡tica e envolvendo questÃµes como acessibilidade e experiÃªncia de usuÃ¡rio.&nbsp;</p><p>&nbsp;</p><p>NÃºmero de Vagas: 20</p><p>Carga HorÃ¡ria: 4H</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: &nbsp;https://forms.gle/NE5tKm2pBU4EHA766</p>', 'A Definir', NULL, NULL, 2, 1, 7),
(11, 'Paloma Dantas Santâ€™Ana', 'Oficina sobre os mecanismos e benefÃ­cios da GratidÃ£o', '08/11 as 15:30 atÃ© 17:30', '<p>Oficina sobre os mecanismos e benefÃ­cios da GRATIDÃƒO Ã  nÃ­vel de saÃºde mental, fÃ­sico e social. O objetivo desse encontro Ã© inspirar a pequenas mudanÃ§as no dia-a-dia para se alcanÃ§ar uma vida mais plena e feliz. SOBRE A FACILITADORA: Paraibana, apaixonada pela arte de viver e de aprender sempre, seja atravÃ©s dos livros ou das gratas surpresas que a vida me traz. Graduada em Arquitetura e Urbanismo, especializada em iluminaÃ§Ã£o, ainda continuo nos bancos estudantis cursando psicologia.</p><p>&nbsp;</p><p>NÃºmero de Vagas: 15</p><p>Carga HorÃ¡ria: 2H</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: &nbsp;https://forms.gle/Qs2W6V7AWWtWE5SJ8</p>', 'Sala 10 Bl 1A TÃ©rreo', '03-11-2019-09-10-19.png', NULL, 2, 1, 7),
(12, 'Ana Cristina Azevedo Ursulino Melo', 'Uso e funcionalidade do Portal de PeriÃ³dicos da CAPES.', '07/11 as  13:30 atÃ© 15:30 ', '<p>Durante a oficina serÃ£o apresentados os recursos gerais do Portal, funcionalidades e como utilizar os mesmos, capacitando alunos e pesquisadores a fazerem melhor uso da diversidade do acervo disponibilizado pelo Portal PeriÃ³dicos da Capes. SOBRE A FACILITADORA: Ã‰ Mestre em PolÃ­ticas PÃºblicas e GestÃ£o da EducaÃ§Ã£o Superior pela Universidade Federal do CearÃ¡ (2011) , com especializaÃ§Ã£o em Sistemas Automatizados de InformaÃ§Ã£o em CiÃªncia e Tecnologia pela Universidade Federal do CearÃ¡ (1995) e graduada em Biblioteconomia pela Universidade Federal do CearÃ¡ (1985). Ã‰ BibliotecÃ¡rio/Documentalista da Universidade Federal do CearÃ¡ desde 1985. Foi Diretora da Biblioteca de Humanidades da UFC (1998-2000). Foi Chefe da SeÃ§Ã£o de Assistencia ao Leitor na Biblioteca de CiÃªncias e Tecnologia da UFC atÃ© 2017. Atualmente trabalha como BibliotecÃ¡ria na Biblioteca Central do Campus do Pici da UFC e Ã© Help Desk no Nordeste para o acesso ao Portal de PeriÃ³dicos da CAPES. Orientadora do Curso de EspecializaÃ§Ã£o em GestÃ£o Escolar da UFC Virtual. E tambÃ©m atua na Ã¡rea de treinamentos em bases de dados internacionais; Ensino de tÃ©cnicas para a utilizaÃ§Ã£o de recursos relacionados a investigaÃ§Ã£o tÃ©cnica, acadÃªmica e cientÃ­fica para usuÃ¡rios. Tem experiÃªncia na Ã¡rea de CiÃªncia da InformaÃ§Ã£o, com Ãªnfase em Bases de Dados e NormalizaÃ§Ã£o de Trabalhos CientÃ­ficos.</p><p>&nbsp;</p><p>NÃºmero de Vagas: 25</p><p>Carga HorÃ¡ria: 2H</p><p>&nbsp;</p><p>Para InscriÃ§Ã£o: &nbsp;Enviar e-mail para bcr@ufc.br informando nome completo, matrÃ­cula e curso do interessado.</p>', 'A Definir', '03-11-2019-09-16-17.jpg', NULL, 2, 1, 7),
(13, 'JocÃ¡ssia maria de Oliveira de Lima', 'Minicurso de calculadora cientÃ­fica, CASIO FX-82MS', '06/11 as 13:30 atÃ© 15:30', '<p>Nesse curso os alunos vÃ£o aprender desde funÃ§Ãµes bÃ¡sicas da calculadora cientÃ­fica, atÃ© funÃ§Ãµes complexas que podem poupar muito trabalho e \"salvar\" na hora das provas.&nbsp;</p><p>&nbsp;</p><p>NÃºmero de vagas: 30 vagas</p><p>Tempo de atividade: 2h</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: &nbsp;https://docs.google.com/forms/d/e/1FAIpQLScowml9ZvKILL9yWVzJeMdNTn2pTPyG-_dkQoNfde0o3_f4ZA/viewform?vc=0&amp;c=0&amp;w=1</p>', 'A definir', NULL, NULL, 1, 1, 7),
(14, 'Cristiane Alves', 'Treinamento de NormalizaÃ§Ã£o de Trabalhos AcadÃªmicos', '06/11 as 14:00 atÃ© 16:00', '<p>A Biblioteca do Campus de Russas- BCR, ofertarÃ¡ um Treinamento de NormalizaÃ§Ã£o de Trabalhos AcadÃªmicos. SerÃ£o abordados noÃ§Ãµes gerais sobre a elaboraÃ§Ã£o de trabalhos acadÃªmicos, citaÃ§Ãµes e elaboraÃ§Ã£o de referÃªncias seguindo as normas da AssociaÃ§Ã£o Brasileira de Normas TÃ©cnicas (ABNT). As inscriÃ§Ãµes deverÃ£o ser realizadas atÃ© o dia do evento atravÃ©s do e-mail bcr@ufc.br, informando nome completo, matrÃ­cula e curso do interessado.</p><p>NÃºmero de vagas: 30 vagas</p><p>Tempo de atividade: 2h</p><p>&nbsp;</p><p>Para InscriÃ§Ã£o: &nbsp;Enviar e-mail para bcr@ufc.br informando nome completo, matrÃ­cula e curso do interessado.</p>', 'A definir', NULL, NULL, 1, 1, 7),
(15, 'Aureliano Neto de Oliveira da Silva', 'Desvendando os grandes mistÃ©rios do cubo mÃ¡gico', '08/11 as 13:30 atÃ© 15:30', '<p>Nesta oficina serÃ¡ desvendado como montar e aumentar sua capacidade de resolver puzzles. SOBRE O FACILITADOR: Aluno do curso de engenharia de software, com experiÃªncia de 8 anos com puzzles (Cubos em geral).</p><p>&nbsp;</p><p>NÃºmero de vagas: 30 vagas</p><p>Tempo de atividade: 2h</p><p>&nbsp;</p><p>Link para InscriÃ§Ã£o: Em Breve</p><p>&nbsp;</p><p>OBS: &nbsp;Ã‰ necessÃ¡rio levar um cubo mÃ¡gico.</p>', 'A definir', '03-11-2019-21-20-52.jpg', NULL, 2, 1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `depoimentos`
--

DROP TABLE IF EXISTS `depoimentos`;
CREATE TABLE IF NOT EXISTS `depoimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_autor` varchar(200) NOT NULL,
  `depoimento` longtext NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_depoimentos_ano1_idx` (`ano_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `editais`
--

INSERT INTO `editais` (`id`, `nome`, `descricao`, `tipo`, `arquivo`, `ano_id`) VALUES
(1, 'IV Encontros UniversitÃ¡rios da UFC de Russas', '<p><strong>ObservaÃ§Ãµes:</strong></p><p>1. os participantes devem estar atentos aos critÃ©rios de avaliaÃ§Ã£o dos resumos, pois estes, para serem aceitos para apresentaÃ§Ã£o, deverÃ£o obter nota igual ou superior a 6,0 pela comissÃ£o cientÃ­fica;</p><p>ou seja, os resumos que forem avaliados com nota abaixo de 6,0 nÃ£o serÃ£o aceitos para apresentaÃ§Ã£o;</p><p>2. o participante (bolsista ou nÃ£o) poderÃ¡ escolher seu tipo de envio, Resumo Simples ou Expandido;</p><p>3. caso o participante decida reenviar o seu resumo jÃ¡ com aval do orientador, fazendo uma substituiÃ§Ã£o no sistema, este deverÃ¡ solicitar novo aval.</p><p>&nbsp;</p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/04-10-2019-16-00-31.pdf\">Edital</a></p><p><a href=\"https://drive.google.com/open?id=17met0uzbMO4x56x6mRSn48FJxn49uP6y\">Edital Assinado</a></p><p><a href=\"https://drive.google.com/open?id=1qaBN9jGQIEXaiQZ_O4px4dKb-8xJFq93\">Aditivo</a></p><p>&nbsp;</p><p>Templates:</p><p>&nbsp;</p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/ModelodeResumo_Simples_EU2019BlindReview.doc\">Template para Resumos Simples (Blind Review).</a></p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/ModelodeResumoSimplesEU2019.doc\">Template para Resumos Simples.</a></p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/templateEU2019_resumo_expandido.docx\">Template para Resumos Expandidos.</a></p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/tex_template_EU.rar\">Template tex para Resumos Expandidos(Atualizado).</a></p><p>&nbsp;</p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/EU2019_Template_Apresentacao.pptx\">SugestÃ£o de template para apresentaÃ§Ã£o oral</a></p><p>&nbsp;</p><p><a href=\"https://drive.google.com/open?id=1-gWyeopkWmufN6witaZ7XO4L6bcxzRds\">CritÃ©rios de AvaliaÃ§Ã£o</a></p><p><a href=\"https://drive.google.com/open?id=1mHDYHdxfBWolFV8j-M3qHzdzNLHlhbLq\">CritÃ©rios da AvaliaÃ§Ã£o das ApresentaÃ§Ãµes</a></p><p>&nbsp;</p><p>Link do edital acessÃ­vel:</p><p><a href=\"https://youtu.be/klwPz_2OquM\">https://youtu.be/klwPz_2OquM</a><br>&nbsp;</p><p>Link do regulamento acessÃ­vel:</p><p><a href=\"https://youtu.be/Dez15xEVjfs\">https://youtu.be/Dez15xEVjfs</a></p>', 'Edital 03/2019', '04-10-2019-16-00-31.pdf', 1),
(2, 'Mostra ArtÃ­stica dos IV Encontros UniversitÃ¡rios da UFC de Russas', '<p>AlÃ©m da programaÃ§Ã£o tradicional com apresentaÃ§Ãµes orais, palestras e minicursos, haverÃ¡ tambÃ©m a primeira ediÃ§Ã£o da Mostra ArtÃ­stica dos EU2019, com apresentaÃ§Ãµes musicais, de danÃ§a e teatro, filmes, oficinas, exposiÃ§Ãµes, feira de artesanato e gastronomia. As inscriÃ§Ãµes estarÃ£o abertas de 1Âº a 11 de outubro para estudantes, servidores docentes e tÃ©cnico-administrativos que desejarem submeter propostas. O regulamento e ficha de inscriÃ§Ã£o estarÃ£o disponÃ­veis no site dos Encontros.</p><p>&nbsp;</p><p><a href=\"https://forms.gle/f4TAz3Uj8mXBN7Gr6\">Ficha de inscriÃ§Ã£o&nbsp;</a></p>', 'Regulamento de InscriÃ§Ã£o', '25-09-2019-09-29-53.pdf', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `subtitulo` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `imagem` varchar(300) DEFAULT NULL,
  `imagem_descricao` varchar(200) DEFAULT NULL,
  `conteudo` longtext NOT NULL,
  `ano_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_noticias_ano1_idx` (`ano_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `subtitulo`, `data`, `hora`, `imagem`, `imagem_descricao`, `conteudo`, `ano_id`) VALUES
(1, 'LanÃ§ado site e edital dos Encontros UniversitÃ¡rios e Feira das ProfissÃµes 2019', ' ', '2019-09-25', '16:48:00', '25-09-2019-16-48-50.png', NULL, '<p>Foi lanÃ§ado hoje o novo site dos Encontros UniversitÃ¡rios e da Feira das ProfissÃµes 2019. Os eventos acontecerÃ£o de 6 a 8 de novembro no Campus da UFC em Russas. A primeira fase de submissÃ£o dos trabalhos serÃ¡ de 28 de setembro a 5 de outubro. As demais fases e o passo a passo para envio dos trabalhos estÃ£o detalhados no edital.</p><p>&nbsp;</p><p>Os Encontros tÃªm como objetivo principal promover a troca de experiÃªncias entre os membros da comunidade acadÃªmica, a fim de favorecer a criaÃ§Ã£o de novas ideias, bem como promover as ideias jÃ¡ implementadas ou em fase de desenvolvimento. SerÃ£o sete modalidades: IniciaÃ§Ã£o CientÃ­fica, IniciaÃ§Ã£o AcadÃªmica, Projetos de ExtensÃ£o, Aprendizagem Cooperativa, Monitoria de Projetos de GraduaÃ§Ã£o, IniciaÃ§Ã£o Ã  DocÃªncia e PrÃ¡ticas Docentes no Ensino Superior.</p><p>&nbsp;</p><p><strong>Mostra ArtÃ­stica</strong></p><p>&nbsp;</p><p>AlÃ©m da programaÃ§Ã£o tradicional com apresentaÃ§Ãµes orais, palestras e minicursos, haverÃ¡ tambÃ©m a primeira ediÃ§Ã£o da Mostra ArtÃ­stica dos EU2019, com apresentaÃ§Ãµes musicais, de danÃ§a e teatro, filmes, oficinas, exposiÃ§Ãµes, feira de artesanato e gastronomia. As inscriÃ§Ãµes estarÃ£o abertas de 1Âº a 11 de outubro para estudantes, servidores docentes e tÃ©cnico-administrativos que desejarem submeter propostas. O regulamento e ficha de inscriÃ§Ã£o estarÃ£o disponÃ­veis no site dos Encontros.</p>', 1),
(2, 'EU e Feira das ProfissÃµes', 'Dois eventos em perfeita sintonia', '2019-09-27', '08:23:00', NULL, NULL, '<p>A terceira ediÃ§Ã£o dos Encontros UniversitÃ¡rios do Campus da UFC em Russas aconteceu em 2018 junto com a primeira ediÃ§Ã£o da Feira das ProfissÃµes. Os dois eventos movimentaram a universidade com muitas apresentaÃ§Ãµes de trabalho, palestras, minicursos e apresentaÃ§Ãµes culturais. Estudantes, professores e coordenadores de escolas pÃºblicas e privadas da regiÃ£o jaguaribana estiveram presentes e tiveram a oportunidade de conhecer mais de perto os cinco cursos do Campus, bem como os projetos de extensÃ£o existentes.</p><p>Neste ano, a ComissÃ£o Organizadora dos eventos pretende repetir o sucesso do ano passado, trazendo uma programaÃ§Ã£o bastante diversificada. AlÃ©m das apresentaÃ§Ãµes convencionais, haverÃ¡ oficinas, apresentaÃ§Ãµes artÃ­sticas, exposiÃ§Ãµes, mostra de filmes, feira de artesanato, e muito mais. Esta Ã© uma combinaÃ§Ã£o que deu certo no Campus e espera-se que permaneÃ§a, visto que um evento complementa e fortalece o outro, contribuindo para o crescimento da instituiÃ§Ã£o no Vale do Jaguaribe.</p>', 1),
(3, 'Campus de Russas nos preparativos para a Feira das ProfissÃµes 2019', ' ', '2019-09-27', '08:25:00', NULL, NULL, '<p>A Feira das ProfissÃµes 2019, assim como ocorreu ano passado, acontecerÃ¡ no mesmo perÃ­odo dos Encontros UniversitÃ¡rios. A uniÃ£o dos dois maiores eventos da UFC trouxe grande pÃºblico para o Campus de Russas no ano passado e promoveu um significativo engajamento de estudantes secundaristas com os alunos dos cursos de graduaÃ§Ã£o. Este ano, nÃ£o serÃ¡ diferente. A ComissÃ£o Organizadora prepara uma vasta programaÃ§Ã£o para fomentar as visitas e movimentar ainda mais o campus. SerÃ£o atividades lÃºdicas, culturais e, claro, de muito aprendizado.</p><p>No evento, os estudantes poderÃ£o conhecer os cursos de graduaÃ§Ã£o ofertados no campus, bem como a grade curricular, dia a dia das turmas, e as oportunidades de trabalho. Dessa forma, poderÃ£o escolher de forma mais consciente o curso superior que pretendem fazer.</p><p>A comunicaÃ§Ã£o com as escolas jÃ¡ comeÃ§ou e espera-se receber um nÃºmero maior de estudantes do que o recebido no ano passado. O acesso Ã© gratuito e voltado para alunos de escolas pÃºblicas e privadas de ensino fundamental e mÃ©dio da regiÃ£o jaguaribana. Para inscrever uma turma, basta acessar o site do evento, clicar em â€œinscreva-seâ€ e preencher o formulÃ¡rio. Mais informaÃ§Ãµes atravÃ©s dos telefones (88) 3411.9223 e do e-mail cparussas@gmail.com.</p>', 1),
(4, 'ConheÃ§a as modalidades dos Encontros UniversitÃ¡rios e inscreva-se', ' ', '2019-09-30', '09:26:00', '30-09-2019-09-26-33.jpg', NULL, '<p>Os IV Encontros UniversitÃ¡rios trazem uma diversidade de trabalhos dispostos em uma variedade de modalidades voltadas para as categorias cientÃ­fica (onde se encaixam as atividades de pesquisa e demais projetos de extensÃ£o) e iniciaÃ§Ã£o acadÃªmica (onde estudantes, professores e tÃ©cnico-administrativos trocam relatos de experiÃªncias no Ã¢mbito acadÃªmico).</p><p>Deste modo, hÃ¡ sete modalidades, sÃ£o elas: IniciaÃ§Ã£o CientÃ­fica, IniciaÃ§Ã£o AcadÃªmica, Projetos de ExtensÃ£o, Aprendizagem Cooperativa, Monitoria de Projetos de GraduaÃ§Ã£o, IniciaÃ§Ã£o Ã  DocÃªncia e PrÃ¡ticas Docentes no Ensino Superior.</p><p>A novidade Ã© que, como este ano a Mostra ArtÃ­stica se integra ao evento, acrescenta-se a esta diversidade mais 13 modalidades que abrangem trabalhos artÃ­sticos, culturais e tÃ©cnicos da comunidade acadÃªmica de Russas.</p><p>O regulamento da Mostra ArtÃ­stica dos EU2019 divulga estas modalidades: Oficina; ApresentaÃ§Ã£o musical; ApresentaÃ§Ã£o de danÃ§a; ApresentaÃ§Ã£o de teatro; Performance; ExibiÃ§Ã£o audiovisual; Obra expositiva (desenho, pintura, gravura, colagem, instalaÃ§Ã£o, escultura, videoarte, etc.); ProduÃ§Ã£o digital de sites, publicaÃ§Ãµes online, webart, apps, games, etc.; LanÃ§amento de livros, revistas, catÃ¡logos, CDs, DVDs, etc.; ProduÃ§Ã£o jornalÃ­stica e publicitÃ¡ria, ProduÃ§Ã£o em design-moda (vestuÃ¡rio, desfile, etc.); Feira de produtos (editorial, artesanato, gastronomia, etc.) e Outros.</p><p>As inscriÃ§Ãµes para a Mostra ArtÃ­stica estÃ£o previstas para o perÃ­odo de 01 a 11 de outubro de 2019 (mediante preenchimento de ficha disponibilizada no site oficial da UFC Campus de Russas) e a primeira fase de submissÃµes de trabalhos para os encontros ocorrerÃ£o de 28 de setembro a 05 de outubro de 2019 (no mÃ³dulo SARA, acessÃ­vel atravÃ©s do sistema GuardiÃ£o). Estejam atentos aos prazos.</p>', 1),
(5, 'ConheÃ§a as modalidades dos Encontros UniversitÃ¡rios e inscreva-se', ' ', '2019-09-30', '09:28:00', NULL, NULL, '<p>EstÃ£o abertas as inscriÃ§Ãµes de propostas de oficinas e minicursos para os IV Encontros UniversitÃ¡rios e Feira das ProfissÃµes 2019. Todos os estudantes, professores e tÃ©cnico-administrativos do Campus da UFC de Russas sÃ£o convidados a submeter propostas para integrar a programaÃ§Ã£o dos eventos, que acontecerÃ£o de 6 a 8 de novembro de 2019.</p><p>&nbsp;</p><p>Segundo a ComissÃ£o Organizadora, a ideia Ã© trazer propostas interessantes de temÃ¡ticas diversas para atender os diversos pÃºblicos presente no Campus, que serÃ£o desde docentes a estudantes secundaristas. HaverÃ¡ entrega de certificado para os responsÃ¡veis pelas propostas que poderÃ¡ ser aproveitado como Atividade Complementar.</p><p>&nbsp;</p><p>O envio da proposta serÃ¡ atravÃ©s do preenchimento de um formulÃ¡rio contido no site dos eventos. O prazo para tal vai atÃ© o dia 18 de outubro. Aproveite esta oportunidade para partilhar seu conhecimento e tornar os Encontros e a Feira ainda melhores.</p><p>&nbsp;</p><p>Link para formulÃ¡rio:</p><p><a href=\"https://forms.gle/NicrVwRV2nxMXaFF6\">https://forms.gle/NicrVwRV2nxMXaFF6</a></p>', 1),
(6, 'Da Universidade para o mercado de trabalho: aÃ§Ãµes de inovaÃ§Ã£o e empreendedorismo', ' ', '2019-10-02', '08:28:00', NULL, NULL, '<p>Quando o mercado e a universidade estabelecem uma parceria os benefÃ­cios se estendem para alÃ©m desses setores proporcionando mais inovaÃ§Ã£o e avanÃ§o, alÃ©m de incentivar o envolvimento dos alunos em problemas e experiÃªncias reais. Com isto, a correlaÃ§Ã£o entre empresa e universidade acontece a partir do ponto em que uma fornece o problema e a outra dispÃµe dos meios e do conhecimento necessÃ¡rios para resolvÃª-lo.</p><p>Recentemente o projeto de um software de inteligÃªncia artificial responsÃ¡vel por monitorar todo o processo realizado pelo moinho usado na produÃ§Ã£o de cimento da empresa Apodi foi entregue. Para Rafael Costa, um dos envolvidos no projeto, â€œO sucesso deste projeto pode abrir portas para diversos outrosâ€.</p><p>AlÃ©m deste, a UFC Campus de Russas atua em outras aÃ§Ãµes envolvendo a Apodi por meio de projetos associados a estudos logÃ­sticos com foco na coleta do resÃ­duo da produÃ§Ã£o do pÃ³ da cera da carnaÃºba, onde Ã© feita a anÃ¡lise da viabilidade e o impacto logÃ­stico de trazer para a fÃ¡brica os resÃ­duos excedentes da produÃ§Ã£o.</p><p>Das vantagens observadas dessa associaÃ§Ã£o tÃªm-se a agregaÃ§Ã£o de valor aos produtos, tornando as empresas mais competitivas e destacando-as no disputado mercado alÃ©m de aumentar suas margens de lucro. Para o contexto universitÃ¡rio os benefÃ­cios se estendem ao acesso a recursos que custeiam a compra de equipamentos, atualizaÃ§Ãµes tecnolÃ³gicas e manutenÃ§Ã£o, por exemplo. Ter acesso a necessidades tecnolÃ³gicas reais dessas empresas mantÃ©m professores e alunos atualizados contribuindo para a existÃªncia de mais pesquisas, para a criaÃ§Ã£o de soluÃ§Ãµes alÃ©m de proporcionar oportunidade de estÃ¡gio aos alunos garantindo-lhes uma experiÃªncia profissional que torne sua capacitaÃ§Ã£o mais qualificada e, por fim, o meio social Ã© o mais privilegiado, pois, com a formaÃ§Ã£o de mÃ£o de obra qualificada Ã© dada mais propriedade aos negÃ³cios locais.</p>', 1),
(7, 'InscriÃ§Ãµes abertas para a Mostra ArtÃ­stica dos Encontros UniversitÃ¡rios 2019', ' ', '2019-10-04', '08:09:00', '04-10-2019-08-09-25.png', NULL, '<p>Se vocÃª tem algum talento artÃ­stico nas Ã¡reas de teatro, danÃ§a e mÃºsica, possui algum projeto em artes visuais ou digitais, trabalha com artesanato ou gastronomia, venha apresentar seu trabalho na&nbsp;Mostra ArtÃ­stica&nbsp;que acontecerÃ¡ durante os IV Encontros UniversitÃ¡rios e II Feira das ProfissÃµes, de 6 a 8 de novembro, no campus da UFC em Russas.</p><p>As inscriÃ§Ãµes estÃ£o abertas atÃ© dia&nbsp;11 de outubro&nbsp;via&nbsp;<a href=\"https://docs.google.com/forms/d/e/1FAIpQLSfV8jgdDsmhe-2E8jE0Yuyb0j6EbW4GkL9Q0ml9tjJs8-tKVg/viewform\">formulÃ¡rio eletrÃ´nico</a>&nbsp;cujo link, assim como o&nbsp;<a href=\"http://200.129.62.41/encontros/uploads/editais/25-09-2019-09-29-53.pdf\">Regulamento</a>&nbsp;da Mostra, encontra-se no&nbsp;<a href=\"http://200.129.62.41/encontros/\">site</a>&nbsp;dos eventos. Toda a comunidade acadÃªmica Ã© convidada a submeter propostas, que serÃ£o avaliadas por um ComitÃª Curador formado por dois professores, dois tÃ©cnico-administrativos e dois estudantes com experiÃªncia em Artes.</p><p>Na ocasiÃ£o, teremos tambÃ©m shows com bandas locais, mostra de cinema, feira de artesanato e feira de gastronomia. No formulÃ¡rio hÃ¡, ainda, a opÃ§Ã£o de ministrar oficinas e minicursos nos quais tanto o facilitador/mediador quanto os participantes receberÃ£o certificado para contar como Atividade Complementar.</p><p>Aproveite esta oportunidade para mostrar seu talento!</p><p><a href=\"http://200.129.62.41/encontros/uploads/editais/25-09-2019-09-29-53.pdf\">Regulamento</a></p><p><a href=\"https://docs.google.com/forms/d/e/1FAIpQLSfV8jgdDsmhe-2E8jE0Yuyb0j6EbW4GkL9Q0ml9tjJs8-tKVg/viewform\">FormulÃ¡rio de inscriÃ§Ã£o</a></p><p>Fonte:&nbsp;<i>Setor de ComunicaÃ§Ã£o e ProduÃ§Ã£o Cultural â€“ fone: 88 3411.9234 / e-mail: </i><a href=\"mailto:comunicacao.russas@ufc.br\"><i>comunicacao.russas@ufc.br</i></a></p>', 1),
(8, 'Fique atento aos critÃ©rios de avaliaÃ§Ã£o dos resumos', ' ', '2019-10-04', '08:11:00', NULL, NULL, '<p>A ComissÃ£o Organizadora do IV Encontros UniversitÃ¡rios informa que a avaliaÃ§Ã£o dos resumos submetidos serÃ¡ feita com base numa lista de critÃ©rios prÃ©-definidos. Somente os que obterem nota igual ou superior a 6,0 serÃ£o aceitos para apresentaÃ§Ã£o no evento. Por isso, antes de submeter o trabalho, verifique se o texto estÃ¡ condizente com o que a ComissÃ£o deste ano solicita.&nbsp;</p><p>Os critÃ©rios estÃ£o disponÃ­veis no site. SÃ£o eles:</p><ul><li>ContextualizaÃ§Ã£o/problemÃ¡tica: O resumo deve contextualizar e apresentar elementos introdutÃ³rios;</li><li>Justificativa: O resumo deve apresentar argumentos que evidenciam grau de novidade do trabalho e/ou relevÃ¢ncia do tema (dependendo da modalidade);</li><li>Objetivos: O objetivo principal do trabalho deve estar claro;</li><li>Metodologia: O resumo deve descrever uma metodologia alinhadas ao(s) objetivo(s);</li><li>Resultado: O resumo deve apresentar os resultados do trabalho;</li><li>ConsideraÃ§Ãµes finais: O resumo deve apresentar consideraÃ§Ãµes finais;</li><li>Palavras-chave: O resumo deve apresentar de 3 a 5 palavras-chaves relacionadas ao tema;</li><li>Estrutura: O resumo deve apresentar os elementos de um resumo e deve estar formatado de acordo com as orientaÃ§Ãµes contidas no<i> template</i>, disponÃ­vel no Edital de submissÃ£o;</li><li>NormatizaÃ§Ã£o da LÃ­ngua: O resumo deve utilizar a linguagem cientÃ­fica e ortografia correta.</li></ul>', 1),
(9, 'ProrrogaÃ§Ã£o das inscriÃ§Ãµes dos encontros', ' ', '2019-10-04', '17:49:00', NULL, NULL, '<p>Devido a vÃ¡rias acontecimentos no Campus essa semana, recebimento da comissÃ£o avaliadora do MEC e &nbsp;II Semana das Engenharias de Russas (SER), <strong>os&nbsp;organizadores dos Encontros UniversitÃ¡rios 2019 prorrogaram o perÃ­odo da primeira fase de submissÃµes de trabalhos em dois dias</strong>. Agora, o novo prazo vai atÃ© o dia 07 de outubro.</p><p><br>Em razÃ£o desta prorrogaÃ§Ã£o o cronograma original, que compreende todas as etapas do&nbsp;processo atÃ© o perÃ­odo de realizaÃ§Ã£o do evento, pode sofrer alteraÃ§Ãµes conforme a&nbsp;necessidade sendo divulgado posteriormente. Este cronograma pode ser encontrado no<br>edital que se encontra no site oficial dos EU 2019.<br><br>Lembrando que as submissÃµes sÃ£o feitas atravÃ©s do mÃ³dulo SARA acessÃ­vel via sistema&nbsp;GuardiÃ£o. Fiquem atentos aos novos prazos!&nbsp;</p>', 1),
(10, 'Professor, traga sua turma para a Feira das ProfissÃµes!', ' ', '2019-10-10', '06:56:00', NULL, NULL, '<p>Este Ã© o segundo ano consecutivo de realizaÃ§Ã£o da Feira das ProfissÃµes na UFC Campus de Russas. O evento acontece no mesmo perÃ­odo em que ocorrem os Encontros UniversitÃ¡rios.</p><p>&nbsp;</p><p>O objetivo da Feira Ã© apresentar aos estudantes de escolas pÃºblicas e particulares, dentre outros, os cursos que a UFC disponibiliza, proporcionando a oportunidade de conversar com os graduandos sobre os cursos oferecidos no Campus de Russas, tirando dÃºvidas em relaÃ§Ã£o Ã s Ã¡reas de atuaÃ§Ã£o, mercado de trabalho, projetos de pesquisa e extensÃ£o e atÃ© mesmo sobre os componentes da grade curricular.</p><p>&nbsp;</p><p>A ideia Ã© auxiliar na escolha da Ã¡rea pretendida, incentivando os participantes a ingressarem na UFC e aumentando as chances de que a escolha de curso seja consciente, diminuindo as incertezas e os motivando. Por isso, Ã© de grande importÃ¢ncia que professores e responsÃ¡veis por estes grupos de potenciais futuros universitÃ¡rios nÃ£o deixem de inscrever sua turma e participem da Feira das ProfissÃµes 2019. O formulÃ¡rio de inscriÃ§Ã£o se encontra no site oficial dos EU 2019. Vem pra UFC de Russas!</p>', 1),
(11, 'Prorrogado o prazo de inscriÃ§Ãµes para a Mostra ArtÃ­stica 2019', ' ', '2019-10-11', '16:03:00', '11-10-2019-16-03-58.png', NULL, '<p>EstÃ¡ previsto em regulamento que o Ãºltimo dia para a realizaÃ§Ã£o de inscriÃ§Ãµes para a Mostra ArtÃ­stica 2019 Ã© hoje (11 de outubro), entretanto a ComissÃ£o Organizadora da Mostra estendeu esse prazo para o dia 15 de outubro. Aqueles que tÃªm alguma proposta artÃ­stica ou cultural e que estejam interessados em participar e ainda nÃ£o efetuaram sua inscriÃ§Ã£o aproveitem a prorrogaÃ§Ã£o para se organizarem e se inscreverem.</p><p><br>&nbsp;</p><p>A inscriÃ§Ã£o pode ser feita atravÃ©s do preenchimento da ficha de inscriÃ§Ã£o, atravÃ©s do link&nbsp;<a href=\"https://docs.google.com/forms/d/e/1FAIpQLSfV8jgdDsmhe-2E8jE0Yuyb0j6EbW4GkL9Q0ml9tjJs8-tKVg/viewform\">https://docs.google.com/forms/d/e/1FAIpQLSfV8jgdDsmhe-2E8jE0Yuyb0j6EbW4GkL9Q0ml9tjJs8-tKVg/viewform</a> Lembrando que o evento ocorre nos dias 6, 7 e 8 de novembro em simultÃ¢neo aos encontros. Venha apresentar a sua proposta!</p><p><br>&nbsp;</p><p>Link para regulamento:&nbsp;<a href=\"http://200.129.62.41/encontros/edital/2#edital\">http://200.129.62.41/encontros/edital/2#edital</a></p><p><br>&nbsp;</p><p>Link para ficha de inscriÃ§Ã£o:&nbsp;<a href=\"https://docs.google.com/forms/d/e/1FAIpQLSfV8jgdDsmhe-2E8jE0Yuyb0j6EbW4GkL9Q0ml9tjJs8-tKVg/viewform\">https://docs.google.com/forms/d/e/1FAIpQLSfV8jgdDsmhe-2E8jE0Yuyb0j6EbW4GkL9Q0ml9tjJs8-tKVg/viewform</a></p>', 1),
(12, 'Divulgado o resultado da primeira fase de submissÃ£o dos trabalhos', ' ', '2019-10-17', '18:21:00', NULL, NULL, '<p>A ComissÃ£o Organizadora dos IV Encontros UniversitÃ¡rios 2019 divulga hoje (17 de outubro) o resultado da etapa de avaliaÃ§Ã£o dos trabalhos submetidos. Para os trabalhos reprovados, o autor tem o prazo de 18 a 20 de outubro para entrar com recurso no mÃ³dulo SARA que, neste perÃ­odo, vai permitir o envio de uma nova versÃ£o do trabalho nÃ£o aceito, para que ele possa ser reavaliado posteriormente (esta reavaliaÃ§Ã£o ocorrerÃ¡ de 20 a 24 de outubro). Verifiquem se seus trabalhos foram aprovados!</p>', 1),
(13, 'Divulgado resultado preliminar da Mostra ArtÃ­stica dos EU2019', ' ', '2019-10-21', '09:33:00', '21-10-2019-09-33-36.jpg', NULL, '<p>A ComissÃ£o Organizadora dos IV Encontros UniversitÃ¡rios divulgou hoje, 18/10, a relaÃ§Ã£o de propostas aprovadas na primeira fase de seleÃ§Ã£o da Mostra. Os proponentes cujas propostas nÃ£o estiverem na lista, poderÃ£o enviar recursos ao ComitÃª Curador atravÃ©s do e-mail <a href=\"mailto:comunicacao.russas@ufc.br\">comunicacao.russas@ufc.br</a> no perÃ­odo de 19 a 22 de outubro de 2019. O ComitÃª farÃ¡ a anÃ¡lise, entrarÃ¡ em contato com os proponentes e o resultado dos recursos sairÃ¡ no dia 25. O resultado final, bem como a programaÃ§Ã£o da Mostra, serÃ¡ divulgada a partir do dia 1Âº de novembro.<br><br>Acompanhe as notÃ­cias sobre as atividades e atraÃ§Ãµes dos Encontros UniversitÃ¡rios acessando ao site <a href=\"http://www.russas.ufc.br/encontros\">www.russas.ufc.br/encontros</a>.</p><p>&nbsp;</p><p><a href=\"https://drive.google.com/open?id=0B5R8qTnuDqdOWjJZcWJIS2xPbVdxaHlWTWMxblJ1bk1vT2Jn\">Resultado Premilinar</a></p>', 1),
(14, 'AtenÃ§Ã£o! Novo prazo para envio de recursos - EU2019', ' ', '2019-10-21', '12:12:00', NULL, NULL, '<p>Foi prorrogado para atÃ© hoje, 21 de outubro, o prazo para envio de recursos para os IV Encontros UniversitÃ¡rios. Quem teve seu trabalho reprovado na etapa de avaliaÃ§Ã£o tem atÃ© hoje para enviar uma nova versÃ£o acessando o GuardiÃ£o e o mÃ³dulo SARA. Os resumos que forem submetidos novamente serÃ£o reavaliados no perÃ­odo de 22 a 26 de outubro. O resultado sairÃ¡ dia 27. Aproveite esta oportunidade e nÃ£o fique de fora do maior evento cientÃ­fico e cultural da Universidade. &nbsp;</p>', 1),
(15, 'Divulgado o cronograma das ApresentaÃ§Ãµes Orais dos IV Encontros UniversitÃ¡rios da UFC Campus de Russas', ' ', '2019-11-05', '15:24:00', NULL, NULL, '<p>A ComissÃ£o Organizadora vem, por meio deste, divulgar o cronograma e alocaÃ§Ã£o das salas das ApresentaÃ§Ãµes Orais do IV Encontros UniversitÃ¡rios.<br><br>O cronograma por Autor Principal pode ser acessado no site do evento no link: <a href=\"http://200.129.62.41/encontros/manual#manual\">Acesse</a><br><br>O cronograma por Avaliador pode ser acessado no site do evento no link: <a href=\"http://200.129.62.41/encontros/manual#manual\">Acesse</a><br><br>Qualquer dÃºvida, favor entrar em contato com a ComissÃ£o Organizadora pelo&nbsp; e-mail&nbsp;<a href=\"mailto:encontros.ufcrussas@gmail.com\">encontros.ufcrussas@gmail.com</a>.</p>', 1),
(16, 'ComissÃ£o Organizadora informa sobre os certificados dos IV Encontros UniversitÃ¡rios e II Feira das ProfissÃµes', ' ', '2019-11-25', '09:15:00', '25-11-2019-09-15-22.jpg', NULL, '<p>A ComissÃ£o Organizadora dos&nbsp;<strong>IV Encontros UniversitÃ¡rios</strong>&nbsp;e&nbsp;<strong>II Feira das ProfissÃµes</strong>&nbsp;disponibilizou uma parte dos&nbsp;certificados&nbsp;para serem baixados. Estes estÃ£o na pÃ¡gina&nbsp;<a href=\"http://200.129.62.41/encontros/certificados#certificados\">Certificados</a>, cujo acesso se dÃ¡ atravÃ©s do<i>&nbsp;link&nbsp;</i>localizado no canto superior direito da pÃ¡gina inicial do site.</p><p>Cada item da pÃ¡gina&nbsp;direcionarÃ¡ para uma pasta contendo todos os certificados organizados em ordem alfabÃ©tica pelo nome do participante. Ao encontrar o certificado desejado, o participante deverÃ¡ realizar o&nbsp;<i>download</i>&nbsp;para ter acesso ao documento.</p><p>Os certificados disponibilizados atualmente sÃ£o:</p><ul><li>Certificados de ParticipaÃ§Ã£o nos EU 2019;</li><li>Certificados de PremiaÃ§Ã£o nos EU 2019;</li><li>Certificados de ParticipaÃ§Ã£o dos Minicursos e Oficinas;</li><li>Certificados dos Facilitadores dos Minicursos e Oficinas;</li><li>Certificados da Feira Mix (Equipe do Nemo);</li><li>Certificados dos inscritos na Mostra ArtÃ­stica.</li></ul><p>Os certificados das equipes que trabalharam na Feira das ProfissÃµes e das equipes de Apoio dos Encontros UniversitÃ¡rios serÃ£o disponibilizados em breve. Os certificados de&nbsp;<strong>ApresentaÃ§Ãµes Orais</strong>&nbsp;tambÃ©m serÃ£o disponibilizados em breve no&nbsp;<a href=\"http://sysprppg.ufc.br/eu/2019/\">site dos Encontros UniversitÃ¡rios de Fortaleza</a>, conforme ocorrido nas ediÃ§Ãµes anteriores do evento.</p><p>Para mais informaÃ§Ãµes, entre em contato com a ComissÃ£o Organizadora atravÃ©s do e-mail <a href=\"mailto:encontros.ufcrussas@gmail.com\">encontros.ufcrussas@gmail.com</a>.</p>', 1),
(17, 'Certificados das ApresentaÃ§Ãµes Orais dos EU2019 jÃ¡ estÃ£o disponÃ­veis', ' ', '2019-12-13', '09:53:00', '13-12-2019-09-53-29.jpg', NULL, '<p>A ComissÃ£o Organizadora dos&nbsp;IV Encontros UniversitÃ¡rios&nbsp;do Campus da UFC em Russas informa que jÃ¡ estÃ£o disponÃ­veis no&nbsp;<a href=\"http://sysprppg.ufc.br/eu/2019/index.php/certificados-russas\">site</a>&nbsp;dos EU de Fortaleza os certificados para alunos, orientadores e avaliadores das ApresentaÃ§Ãµes Orais do evento.</p><p>Ao acessar o site&nbsp;<a href=\"http://www.encontrosuniversitarios.ufc.br/\">www.encontrosuniversitarios.ufc.br</a>, deve-se clicar no item â€œCertificados â€“ Campus de Russasâ€ no Menu Principal, e depois clicar no tipo de certificado desejado no submenu que aparecerÃ¡.</p><p>Os certificados serÃ£o emitidos eletronicamente por trabalho apresentado e neles constarÃ£o os nomes de todos os autores (autor principal e coautores). Para emitir o certificado, basta digitar o nome de qualquer um dos autores. Do mesmo modo, para emitir o certificado para orientador ou avaliador, basta digitar o primeiro nome cadastrado.</p>', 1),
(18, 'teste', 'teste123', '2020-10-03', '14:04:00', '03-10-2020-14-20-56.png', 'sdasdasdasd', '<p>laksdjhflsdjfsd</p>', 3),
(19, 'nova', 'abc', '2020-10-03', '14:27:00', NULL, NULL, '<p>lkajdsaljkds</p>', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `palestras`
--

DROP TABLE IF EXISTS `palestras`;
CREATE TABLE IF NOT EXISTS `palestras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `sala` varchar(30) NOT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `imagem_descricao` varchar(200) DEFAULT NULL,
  `ano_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_palestras_ano1_idx` (`ano_id`),
  KEY `fk_palestras_area1_idx` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `palestras`
--

INSERT INTO `palestras` (`id`, `nome`, `titulo`, `data`, `resumo`, `sala`, `imagem`, `imagem_descricao`, `ano_id`, `area_id`) VALUES
(1, 'Carla Fernandes de Freitas', 'PrincÃ­pios de propriedade intelectual para a inovaÃ§Ã£o.', '06/11 as 10 atÃ© 11:30', '<p>Mestranda no Programa de PÃ³s-GraduaÃ§Ã£o em Propriedade Intelectual e TransferÃªncia de Tecnologia para a InovaÃ§Ã£o pela AssociaÃ§Ã£o FÃ³rum Nacional de Gestores de InovaÃ§Ã£o e TransferÃªncia de Tecnologia (FORTEC). PÃ³s-Graduada em GestÃ£o PÃºblica pela Universidade de Fortaleza. Graduada em Psicologia pela UFRJ. TÃ©cnica em Propriedade Industrial desde 2005, atualmente estÃ¡ responsÃ¡vel pelo EscritÃ³rio de DifusÃ£o Regional Nordeste do INPI. Interessa-se por Propriedade Intelectual, inovaÃ§Ã£o, polÃ­ticas e gestÃ£o pÃºblica.</p><p>&nbsp;</p>', 'AuditÃ³rio', '03-11-2019-08-33-41.jpg', NULL, 1, 7),
(2, 'FÃ¡bio Barros', 'PrincÃ­pios de propriedade intelectual para a inovaÃ§Ã£o.', '06/11 as 10 atÃ© 11:30', '<p>Possui graduaÃ§Ã£o em Engenharia de Alimentos pela Universidade Federal do CearÃ¡ - UFC(2000), Mestrado em CiÃªncia de Alimentos (2007) e Doutorado e CiÃªncia de Alimentos (2011),ambos pela Universidade Estadual de Campinas - UNICAMP. Atualmente trabalha como Pesquisador em Propriedade Industrial no Instituto Nacional da Propriedade Industrial (INPI), onde atua como examinador de patentes.</p>', 'AuditÃ³rio', '03-11-2019-08-38-51.jpg', NULL, 1, 7),
(3, 'Fabio de Azevedo Martins', 'â€œAutoconhecimento e Carreira Profissional â€“ Vida com propÃ³sitoâ€ â€“ E agora? Estou formado!!', 'A definir', '<p>Engenheiro Metalurgista, FEI, PÃ³s-graduado em AdministraÃ§Ã£o de Empresas, Esan/SP, MBA em GestÃ£o de Projetos- FGV, Green Belt 6-Sigma- Werkema, mais de 27 anos de carreira em ascensÃ£o na Ã¡rea Industrial em grandes grupos, atualmente Gerente Industrial da Cimento Apodi.</p>', 'AuditÃ³rio', '03-11-2019-08-44-23.jpg', NULL, 1, 7),
(4, 'Antonio Gomes de Souza Filho', 'O significado da ciÃªncia', '08/11 as 10 atÃ© 11:30', '<p>Antonio Gomes de Souza Filho concluiu o Doutorado em FÃ­sica pela Universidade Federal do CearÃ¡ em 2001 com a realizaÃ§Ã£o de estÃ¡gio sanduÃ­che no MIT-EUA durante o ano de 2000. Atualmente Ã© Prof. Associado IV do Departamento de FÃ­sica da UFC e Bolsista de produtividade do CNPq, nÃ­vel 1A. Publicou 232 artigos em periÃ³dicos internacionais especializados que atraÃ­ram, atÃ© Setembro de 2019, 10600 citaÃ§Ãµes resultando em um fator h=55. Ã‰ autor e co-autor de sete artigos de revisÃ£o convidados e cinco capÃ­tulos de livros (springer-verlag). Ã‰ co-autor do livro \"Solid State Properties From Bulk to Nano\" publicado pela Springer-Verlag em 2018. Orientou 8 dissertaÃ§Ãµes de mestrado e co-orientou 3. Orientou 7 Teses de Doutorado e co-orientou 2. JÃ¡ atuou como pesquisador visitante das Universidades de Tohoku (JapÃ£o), no MIT (EUA), na Universidade de Lyon-1 (FranÃ§a), e na UNICAMP. Foi agraciado em 2009 com o prÃªmio Somiya Award da International Union of Materials Research Societies 2009 for the collaborative work on ?Carbon nanostructured materials?. Foi PrÃ³-Reitor de Pesquisa e PÃ³s-GraduaÃ§Ã£o da Universidade Federal do CearÃ¡ de 2016 a 2019 e diretor-tesoureiro da sociedade brasileira de fÃ­sica de 2017-2019. Ingressou como Membro titular da Academia Brasileira de CiÃªncias em 2018. Recebeu em 2018, da PresidÃªncia da RepÃºblica do Brasil, a Comenda da Ordem Nacional do MÃ©rito CientÃ­fico - Classe Comendador. Atualmente Ã© membro do conselho da Sociedade Brasileira de FÃ­sica (2019-2021) e Membro do Conselho Consultivo da Academia Brasileira de CiÃªncias (2019-2021). Atua na Ã¡rea de fÃ­sica da matÃ©ria condensada com Ãªnfase em nanociÃªncia e nanotecnologia.</p>', 'AuditÃ³rio', '03-11-2019-08-48-04.jpeg', NULL, 1, 7);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(1, 'guilherme nepomuceno', 'guilherme@gmail.com', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 1),
(2, 'susana', 'susana@gmail.com', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 2),
(3, 'Apoio', 'apoio@russas.ufc.br', '66b690f76bad2a06ce8d98a30c78893103636418bba5a7f5a84c06ef3714cf874db019ec800e300b7a05521e0354c23538f241a3547d4ebd4442a694e302a4f8', 3),
(4, 'Bebeto', 'bebeto@gmail.com', 'c8d9ea04f9a0901a341f3eb8bd4180ebbcf5442e25c728fae56d026bdb0d9ac8ff281986cf17208ededc8e59f5fa0d83a9ccd37379c042629852e2b51180b4c8', 1);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `apresentacoes`
--
ALTER TABLE `apresentacoes`
  ADD CONSTRAINT `fk_apresentacoes_ano1` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Limitadores para a tabela `depoimentos`
--
ALTER TABLE `depoimentos`
  ADD CONSTRAINT `fk_ano_id` FOREIGN KEY (`ano_id`) REFERENCES `ano` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
