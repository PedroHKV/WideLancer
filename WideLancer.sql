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
    curador BOOLEAN NOT NULL
);


CREATE TABLE IF NOT EXISTS Portifolio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    foto VARCHAR(100),
    titulo VARCHAR(50),
    descricao TEXT,
    usuario_id INT UNIQUE,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Anuncio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    foto VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    titulo VARCHAR(50),
    portifolio_id INT,
    usuario_id INT,
    ativo TINYINT,
    FOREIGN KEY (portifolio_id) REFERENCES Portifolio(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Comentario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto TEXT NOT NULL,
    horario DATETIME NOT NULL,
    nota INT,
    anuncio_id INT,
    usuario_id INT,
    FOREIGN KEY (anuncio_id) REFERENCES Anuncio(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);


CREATE TABLE IF NOT EXISTS Chat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    anunciante_id INT,
    solicitante_id INT,
    FOREIGN KEY (anunciante_id) REFERENCES Usuario(id),
    FOREIGN KEY (solicitante_id) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Venda (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_init DATE NOT NULL,
    data_termino DATE NOT NULL,
    andamento BOOLEAN,
    preco DOUBLE,
    chat_id INT,
    FOREIGN KEY (chat_id) REFERENCES Chat(id)
);

CREATE TABLE IF NOT EXISTS Denuncia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    motivo TEXT NOT NULL,
    pendente TINYINT NOT NULL,
    decisao VARCHAR(45),
    delator INT NOT NULL,
    anuncio_id INT NOT NULL,
    FOREIGN KEY (delator) REFERENCES Usuario(id),
    FOREIGN KEY (anuncio_id) REFERENCES Anuncio(id)
);

CREATE TABLE IF NOT EXISTS Mensagem (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(20),
    horario DATETIME,
    chat_id INT,
    usuario_id INT,
    FOREIGN KEY (chat_id) REFERENCES Chat(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Mensagem_comum(
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto TEXT,
    imagem VARCHAR(200),
    lida TINYINT,
    FOREIGN KEY (id) REFERENCES Mensagem(id)
);

CREATE TABLE IF NOT EXISTS Proposta(
    id INT PRIMARY KEY AUTO_INCREMENT,
    orcamento DOUBLE,
    prazo DATETIME,
    aceita TINYINT,
    FOREIGN KEY (id) REFERENCES Mensagem(id)
);

CREATE TABLE IF NOT EXISTS Mensagem_produto(
    id INT PRIMARY KEY AUTO_INCREMENT,
    adquirido TINYINT ,
    caminho VARCHAR(200),
    FOREIGN KEY (id) REFERENCES Mensagem(id)
);

CREATE TABLE IF NOT EXISTS Solicitacao(
    id INT PRIMARY KEY AUTO_INCREMENT,
    cpf VARCHAR(16) NOT NULL,
    pix VARCHAR(45) NOT NULL,
    foto VARCHAR(200) NOT NULL,
    decisao VARCHAR(45),
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Produto(
	id INT PRIMARY KEY AUTO_INCREMENT,
    caminho VARCHAR(200) NOT NULL,
    usuario_id INT NOT NULL,
    data DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE OR REPLACE VIEW MensagensView AS
SELECT
    m.id,
    m.tipo,
    m.horario,
    m.chat_id,
    m.usuario_id,
    mc.texto,
    mc.imagem,
    mc.lida,
    p.orcamento,
    p.prazo,
    p.aceita,
    mp.adquirido,
    mp.caminho
FROM Mensagem m
LEFT JOIN Mensagem_comum mc ON m.id = mc.id
LEFT JOIN Proposta p ON m.id = p.id
LEFT JOIN Mensagem_produto mp ON m.id = mp.id;

CREATE OR REPLACE VIEW ViewDenunciasComUsuarios AS
SELECT
    d.id AS denuncia_id,
    d.motivo,
    d.pendente,
    d.decisao,
    a.id AS anuncio_id,
    
    delator.id AS delator_id,
    delator.nome AS delator_nome,
    delator.sobrenome AS delator_sobrenome,
    delator.email AS delator_email,

    vendedor.id AS acusado_id,
    vendedor.nome AS acusado_nome,
    vendedor.sobrenome AS acusado_sobrenome,
    vendedor.email AS acusado_email

FROM Denuncia d
JOIN Usuario delator ON d.delator = delator.id
JOIN Anuncio a ON d.anuncio_id = a.id
JOIN Usuario vendedor ON a.usuario_id = vendedor.id;

select * from ViewDenunciasComUsuarios

DELIMITER $$
    CREATE PROCEDURE cadastrar_msg_comum( 
        IN texto TEXT,
        IN imagem VARCHAR(20),
        IN chat INT,
        IN usuario_id INT)

    BEGIN
        DECLARE horario DATETIME;
        DECLARE id INT;

        SET horario := NOW();
        INSERT INTO Mensagem(tipo, horario, chat_id, usuario_id) VALUES ("mensagem_comum", horario, chat, usuario_id);
        SET id := last_insert_id();
        INSERT INTO Mensagem_comum(id, texto, imagem, lida ) VALUES (id, texto, imagem, 0);

    END $$

DELIMITER ;

DELIMITER $$
    CREATE PROCEDURE cadastrar_proposta( 
        IN prazo datetime,
        IN orcamento double,
        IN chat INT,
        IN usuario_id INT)

    BEGIN
        DECLARE horario DATETIME;
        DECLARE id INT;

        SET horario := NOW();
        INSERT INTO Mensagem(tipo, horario, chat_id, usuario_id) VALUES ("proposta", horario, chat, usuario_id);
        SET id := last_insert_id();
        INSERT INTO Proposta(id, orcamento, prazo ) VALUES (id, orcamento, prazo);

    END $$

DELIMITER ;

DELIMITER $$

DELIMITER $$

CREATE PROCEDURE cadastrar_msg_produto( 
    IN caminho VARCHAR(200),
    IN chat INT,
    IN usuario_id INT
)
BEGIN
    DECLARE horario DATETIME;
    DECLARE id INT;

    SET horario = NOW();

    INSERT INTO Mensagem(tipo, horario, chat_id, usuario_id) 
    VALUES ('produto', horario, chat, usuario_id);

    SET id = LAST_INSERT_ID();

    INSERT INTO Mensagem_produto(id, adquirido, caminho) 
    VALUES (id, 0, caminho);  
END $$

DELIMITER ;



INSERT INTO Usuario(email, senha, nome, sobrenome, stripeid, cpf, foto, vendedor, curador) VALUES ('yuriSobezak@gmail.com', 'admin123', 'Yuri', 'Sobezak', '1234567', '541.731.480-38', '1', '../imagens/usuario_icone.png', 1, 1);