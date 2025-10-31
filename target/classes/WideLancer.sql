CREATE DATABASE IF NOT EXISTS WideLancer;
USE WideLancer;

CREATE TABLE IF NOT EXISTS Usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    stripeid varchar(50) UNIQUE,
    cpf VARCHAR(15) UNIQUE,
    ativo TINYINT,
    foto VARCHAR(100),
    vendedor BOOLEAN NOT NULL,
    curador BOOLEAN NOT NULL,
    titulo_portifolio VARCHAR(100),
    descricao_portifolio TEXT
);

CREATE TABLE IF NOT EXISTS Solicitacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cpf VARCHAR(14),
    stripeid VARCHAR(45),
    foto VARCHAR(150),
    feita_em DATETIME,
    respondida_em DATETIME,
    solicitante INT UNIQUE,
    respondida_por INT,
    decisao VARCHAR(10),
    FOREIGN KEY (solicitante) REFERENCES Usuario(id),
    FOREIGN KEY (respondida_por) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Anuncio(
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200),
    descricao TEXT,
    foto VARCHAR(200),
    anunciante INT,
    ativo BOOLEAN NOT NULL,
    FOREIGN KEY (anunciante) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Denuncia(
    id INT PRIMARY KEY AUTO_INCREMENT,
    motivo TEXT NOT NULL,
    delator INT,
    anuncio INT,
    decisao VARCHAR(15),
    avaliada_por INT,
    FOREIGN KEY (delator) REFERENCES Usuario(id),
    FOREIGN KEY (anuncio) REFERENCES Anuncio(id),
    FOREIGN KEY (avaliada_por) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Chat(
    id INT PRIMARY KEY AUTO_INCREMENT,
    vendedor INT,
    cliente INT,
    ativo BOOLEAN,
    FOREIGN KEY (vendedor) REFERENCES Usuario(id),
    FOREIGN KEY (cliente) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS MensagemComum(
    id INT PRIMARY KEY AUTO_INCREMENT,
    hora DATETIME,
    texto TEXT,
    imagem VARCHAR(15),
    emissor INT,
    chat INT,
    FOREIGN KEY (emissor) REFERENCES Usuario(id),
    FOREIGN KEY (chat) REFERENCES Chat(id)
);

CREATE TABLE IF NOT EXISTS Proposta(
    id INT PRIMARY KEY AUTO_INCREMENT,
    orcamento DOUBLE NOT NULL,
    prazo DATETIME,
    aceita VARCHAR(9),
    hora DATETIME,
    chat INT,
    FOREIGN KEY (chat) REFERENCES Chat(id)
);

CREATE TABLE IF NOT EXISTS Produto(
    id INT PRIMARY KEY AUTO_INCREMENT,
    urlProduto VARCHAR(150),
    entrega DATETIME,
    dono INT,
    emissor INT,
    pago BOOLEAN,
    preco DOUBLE,
    FOREIGN KEY (dono) REFERENCES Usuario(id),
    FOREIGN KEY (emissor) REFERENCES Usuario(id)
);

CREATE OR REPLACE VIEW SolicitacoesUsuarios AS
SELECT 
	s.id,
    s.cpf,
    s.stripeid,
    s.foto,
    s.feita_em,
    s.respondida_em,
    s.solicitante,
    s.respondida_por,
    u.nome,
    s.decisao
FROM SOLICITACAO AS s
JOIN Usuario AS u ON s.solicitante = u.id;

CREATE OR REPLACE VIEW DenunciaUsuarioAnuncio AS 
SELECT 
    d.id,
    d.motivo,
    d.decisao,
    u.email AS 'acusadoEmail', 
    a.id AS 'anuncio',
    a.titulo,
    u2.email AS 'delatorEmail'
FROM Denuncia AS d 
JOIN Anuncio AS a ON d.anuncio = a.id 
JOIN Usuario AS u ON a.anunciante = u.id
JOIN Usuario AS u2 ON d.delator = u2.id;

CREATE OR REPLACE VIEW Mensagens AS

SELECT 
    c.id AS "chat_id",
    mc.id AS "mc_id",
    mc.texto AS "mc_texto",
    mc.hora AS "mc_hora",
    mc.imagem AS "mc_imagem",
    mc.emissor AS "mc_emissor",
    mc.chat AS "mc_chat",
    NULL AS "p_orcamento",
    NULL AS "p_prazo",
    NULL AS "p_hora",
    NULL AS "p_aceita",
    NULL AS "p_chat",
    NULL AS "p_id",
    'MensagemComum' AS "tipo"
FROM Chat c
JOIN MensagemComum mc ON mc.chat = c.id

UNION ALL

SELECT 
    c.id AS "chat_id",
    NULL AS "mc_id",
    NULL AS "mc_texto",
    NULL AS "mc_hora",
    NULL AS "mc_imagem",
    NULL AS "mc_emissor",
    NULL AS "mc_chat",
    p.orcamento AS "p_orcamento",
    p.prazo AS "p_prazo",
    p.hora AS "p_hora",
    p.aceita AS "p_aceita",
    p.chat AS "p_chat",
    p.id AS "p_id",
    'Proposta' AS "tipo"
FROM Chat c
JOIN Proposta p ON p.chat = c.id;

INSERT INTO Usuario(email, senha, nome, sobrenome, cpf, ativo, foto, vendedor, curador) VALUES ("admin@gmail.com", "adm", "administrador", "1", "123.456.789-10", 1, "images/usuario_icone.png", 1, 1);