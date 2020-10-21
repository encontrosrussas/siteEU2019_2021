CREATE TABLE ano ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome_ano             year(4)  NOT NULL    ,
	status               tinyint  NOT NULL DEFAULT 1   ,
	editais              tinyint  NOT NULL DEFAULT 1   ,
	cronogramas          tinyint  NOT NULL DEFAULT 1   ,
	noticias             tinyint  NOT NULL DEFAULT 1   ,
	palestras            tinyint  NOT NULL DEFAULT 1   ,
	apresentacoes        tinyint  NOT NULL DEFAULT 1   
 );

CREATE TABLE area ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome                 varchar(50)  NOT NULL    ,
	descricao            longtext  NOT NULL    
 );

CREATE TABLE artistico ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	facilitador          varchar(100)  NOT NULL    ,
	titulo               varchar(100)  NOT NULL    ,
	data                 varchar(100)  NOT NULL    ,
	resumo               text  NOT NULL    ,
	local                varchar(30)  NOT NULL    ,
	imagem               varchar(200)      ,
	imagem_descricao     text      ,
	tipo                 tinyint  NOT NULL    ,
	ano_id               int      ,
	area_id              int      
 );

CREATE INDEX fk_artistico_ano1_idx ON artistico ( ano_id );

CREATE INDEX fk_artistico_area1_idx ON artistico ( area_id );

CREATE TABLE calendario ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	data                 varchar(100)  NOT NULL    ,
	descricao            varchar(250)  NOT NULL    ,
	ano_id               int      
 );

CREATE INDEX fk_calendario_ano1_idx ON calendario ( ano_id );

CREATE TABLE cronogramas ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	dia                  date  NOT NULL    ,
	imagem               varchar(300)      ,
	ano_id               int      
 );

CREATE INDEX fk_cronogramas_ano1_idx ON cronogramas ( ano_id );

CREATE TABLE cursos_oficinas ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome                 varchar(100)  NOT NULL    ,
	titulo               varchar(100)  NOT NULL    ,
	data                 varchar(100)  NOT NULL    ,
	resumo               text  NOT NULL    ,
	sala                 varchar(30)  NOT NULL    ,
	imagem               varchar(200)      ,
	imagem_descricao     text      ,
	tipo                 tinyint  NOT NULL    ,
	ano_id               int      ,
	area_id              int      
 );

CREATE INDEX fk_cursos_oficinas_ano1_idx ON cursos_oficinas ( ano_id );

CREATE INDEX fk_cursos_oficinas_area1_idx ON cursos_oficinas ( area_id );

CREATE TABLE editais ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome                 varchar(100)  NOT NULL    ,
	descricao            longtext      ,
	tipo                 varchar(100)  NOT NULL    ,
	arquivo              varchar(200)      ,
	ano_id               int      
 );

CREATE INDEX fk_editais_ano_idx ON editais ( ano_id );

CREATE TABLE noticias ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	titulo               varchar(200)  NOT NULL    ,
	subtitulo            varchar(200)  NOT NULL    ,
	data                 date  NOT NULL    ,
	hora                 time  NOT NULL    ,
	imagem               varchar(300)      ,
	imagem_descricao     text      ,
	conteudo             longtext  NOT NULL    ,
	ano_id               int      
 );

CREATE INDEX fk_noticias_ano1_idx ON noticias ( ano_id );

CREATE TABLE palestras ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome                 varchar(100)  NOT NULL    ,
	titulo               varchar(100)  NOT NULL    ,
	data                 varchar(100)  NOT NULL    ,
	resumo               text  NOT NULL    ,
	sala                 varchar(30)  NOT NULL    ,
	imagem               varchar(200)      ,
	imagem_descricao     text      ,
	ano_id               int      ,
	area_id              int      
 );

CREATE INDEX fk_palestras_ano1_idx ON palestras ( ano_id );

CREATE INDEX fk_palestras_area1_idx ON palestras ( area_id );

CREATE TABLE usuarios ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome                 varchar(50)  NOT NULL    ,
	email                varchar(150)  NOT NULL    ,
	senha                varchar(250)  NOT NULL    ,
	tipo                 tinyint  NOT NULL    ,
	CONSTRAINT email UNIQUE ( email ) 
 );

CREATE TABLE apresentacoes ( 
	id                   int  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nome                 varchar(150)  NOT NULL    ,
	resumo               longtext      ,
	area_id              int      ,
	ano_id               int      
 );

CREATE INDEX fk_apresentacoes_ano1_idx ON apresentacoes ( ano_id );

CREATE INDEX fk_apresentacoes_area1_idx ON apresentacoes ( area_id );

ALTER TABLE apresentacoes ADD CONSTRAINT fk_apresentacoes_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE apresentacoes ADD CONSTRAINT fk_apresentacoes_area1 FOREIGN KEY ( area_id ) REFERENCES area( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE artistico ADD CONSTRAINT fk_artistico_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE artistico ADD CONSTRAINT fk_artistico_area1 FOREIGN KEY ( area_id ) REFERENCES area( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE calendario ADD CONSTRAINT fk_calendario_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE cronogramas ADD CONSTRAINT fk_cronogramas_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE cursos_oficinas ADD CONSTRAINT fk_cursos_oficinas_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE cursos_oficinas ADD CONSTRAINT fk_cursos_oficinas_area1 FOREIGN KEY ( area_id ) REFERENCES area( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE editais ADD CONSTRAINT fk_editais_ano FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE noticias ADD CONSTRAINT fk_noticias_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE palestras ADD CONSTRAINT fk_palestras_ano1 FOREIGN KEY ( ano_id ) REFERENCES ano( id ) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE palestras ADD CONSTRAINT fk_palestras_area1 FOREIGN KEY ( area_id ) REFERENCES area( id ) ON DELETE SET NULL ON UPDATE CASCADE;

INSERT INTO `area` (`id`, `nome`, `descricao`) VALUES
(1, 'Engenharia Civil', ''),
(2, 'Engenharia Mecanica', ''),
(3, 'Engenharia de Produção', ''),
(4, 'Ciência da Computação', ''),
(5, 'Engenharia de Software', ''),
(6, 'Libras', ' '),
(7, 'Diversos', ' ');
INSERT INTO usuarios( id, nome, email, senha, tipo ) VALUES ( 1, 'Administrador', 'admin@n2s.com', 'fa3c1cdee866e8b57b644e55aa85ad1f001ea14471da9d41cdd3195e5613f4b8b6fff905e7f1afb3954a3e182e92c52497e41decf5718b51a09bfadf52e77f20', 1);