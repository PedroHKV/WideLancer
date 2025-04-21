CREATE DATABASE IF NOT EXISTS WideLancer;
USE WideLancer;

CREATE TABLE IF NOT EXISTS Usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    pix varchar(50),
    cpf VARCHAR(15),
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
    descricao VARCHAR(100) NOT NULL,
    data_init DATE NOT NULL,
    data_termino DATE NOT NULL,
    chat_id INT,
    anuncio_id INT,
    FOREIGN KEY (chat_id) REFERENCES Chat(id),
    FOREIGN KEY (anuncio_id) REFERENCES Anuncio(id)
);

CREATE TABLE IF NOT EXISTS Mensagem (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto TEXT NOT NULL,
    horario DATETIME NOT NULL,
    chat_id INT,
    usuario_id INT,
    FOREIGN KEY (chat_id) REFERENCES Chat(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);
