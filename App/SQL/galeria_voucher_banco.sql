CREATE DATABASE IF NOT EXISTS galeria_voucher;
USE galeria_voucher;

-- Tabela pessoa
CREATE TABLE IF NOT EXISTS pessoa (
    pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_id INT, -- pode ser uma futura FK se houver tabela de imagens
    descricao TEXT,
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL
);

-- Tabela usuario
CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

-- Tabela cidade
CREATE TABLE IF NOT EXISTS cidade (
    cidade_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

-- Tabela polo
CREATE TABLE IF NOT EXISTS polo (
    polo_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cidade_id INT,
    FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
);

-- Tabela projeto
CREATE TABLE IF NOT EXISTS projeto (
    projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    data_inicio DATE,
    data_fim DATE,
    imagem_id INT, -- FK para tabela de imagens
    polo_id INT,
    FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
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