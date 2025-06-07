-- 10 tabelas 

CREATE DATABASE IF NOT EXISTS galeria_voucher;

-- Drop database galeria_voucher;
USE galeria_voucher;

-- Tabela pessoa
CREATE TABLE IF NOT EXISTS pessoa (
    pessoa_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_id INT, -- FK  tabela de imagens
    descricao TEXT,
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL
);

-- Tabela usuario
CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT UNSIGNED NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

-- Tabela cidade
CREATE TABLE IF NOT EXISTS cidade (
    cidade_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

-- Tabela polo
CREATE TABLE IF NOT EXISTS polo (
    polo_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cidade_id INT UNSIGNED,-- FK tabela cidade
    FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
);

-- Tabela projeto
CREATE TABLE IF NOT EXISTS projeto (
    projeto_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    data_inicio DATE,
    data_fim DATE,
    imagem_id INT UNSIGNED, -- FK para tabela 
    polo_id INT UNSIGNED,--FK tabela polo
    FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
);

-- Tabela imagem
CREATE TABLE IF NOT EXISTS imagem (
    imagem_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    url VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL, -- Nome da chave alterado de "text", text é uma palavra reservacada do sql
    descricao VARCHAR(255) NOT NULL,
    data_upload DATE NOT NULL DEFAULT CURRENT_DATE
);
-- Tabela imagem_projeto
CREATE TABLE IF NOT EXISTS imagem_projeto (
    imagem_projeto_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    projeto_id INT UNSIGNED NOT NULL
    imagem_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);

-- tabela turma
CREATE TABLE IF NOT EXISTS turma (
    turma_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    imagem_id INT FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    polo_id INT FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
);
