-- Criar banco
CREATE DATABASE IF NOT EXISTS galeria_voucher;
USE galeria_voucher;

-- ======================
-- Estrutura ORIGINAL (ordem antiga)
-- ======================

-- 1. Imagem
CREATE TABLE IF NOT EXISTS imagem (
    imagem_id INT AUTO_INCREMENT PRIMARY KEY, 
    url VARCHAR(255) NOT NULL,
    text TEXT,
    descricao TEXT,
    data_upload DATETIME NOT NULL
);

-- 2. Pessoa
CREATE TABLE IF NOT EXISTS pessoa (
    pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_id INT NOT NULL,
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id)
);

-- 3. Usuario
CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

-- 4. Cidade
CREATE TABLE IF NOT EXISTS cidade (
    cidade_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- 5. Polo
CREATE TABLE IF NOT EXISTS polo (
    polo_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade_id INT NOT NULL,
    FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
);

-- 6. Turma
CREATE TABLE IF NOT EXISTS turma (
    turma_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    imagem_id INT NOT NULL,
    polo_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
);

-- 7. Docente_Turma
CREATE TABLE IF NOT EXISTS docente_turma (
    docente_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_associacao DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

-- 8. Aluno_Turma
CREATE TABLE IF NOT EXISTS aluno_turma (
    aluno_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_matricula DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

-- 9. Projeto
CREATE TABLE IF NOT EXISTS projeto (
    projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    link VARCHAR(255),
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id)
);

-- 10. Imagem_Projeto (antiga)
CREATE TABLE IF NOT EXISTS imagem_projeto (
    imagem_projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    imagem_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    projeto_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);

-- ==========
-- ALTERAÇÕES
-- ==========

-- Renomear tabela imagem_projeto para imagem_projeto_dia
RENAME TABLE imagem_projeto TO imagem_projeto_dia;

-- Remover chave estrangeira antiga (projeto_id)
ALTER TABLE imagem_projeto_dia DROP FOREIGN KEY imagem_projeto_ibfk_2;

-- Remover coluna projeto_id
ALTER TABLE imagem_projeto_dia DROP COLUMN projeto_id;

-- Adicionar coluna projeto_dia_id (referenciando novo relacionamento)
ALTER TABLE imagem_projeto_dia
    ADD projeto_dia_id INT NOT NULL AFTER imagem_id;

-- Adicionar chave estrangeira para projeto_dia_id
ALTER TABLE imagem_projeto_dia
    ADD CONSTRAINT fk_imagem_projeto_dia_projeto_dia FOREIGN KEY (projeto_dia_id) REFERENCES projeto_dia(projeto_dia_id);