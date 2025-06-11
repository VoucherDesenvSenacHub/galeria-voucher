-- Create the database

-- conferir se esta de acordo 
CREATE DATABASE IF NOT EXISTS galeria_voucher;
USE galeriavoucher;

-- Create the 'imagem' table
CREATE TABLE imagem (
    imagem_id INT AUTO_INCREMENT PRIMARY KEY, -- ok
    url VARCHAR(255) NOT NULL,--ok
    text TEXT,--ok
    descricao TEXT,--ok
    data_upload DATETIME NOT NULL--ok
);

-- Create the 'pessoa' table
CREATE TABLE pessoa (
    pessoa_id INT AUTO_INCREMENT PRIMARY KEY,--ok
    email VARCHAR(255) NOT NULL UNIQUE,--ok
    nome VARCHAR(255) NOT NULL,--ok
    linkedin VARCHAR(255),--ok
    github VARCHAR(255),--ok
    imagem_id INT,--ok
    descricao TEXT,--ok
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL,--ok
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id)--ok
);

-- Create the 'usuario' table
CREATE TABLE usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

-- Create the 'cidade' table
CREATE TABLE cidade (
    cidade_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Create the 'polo' table
CREATE TABLE polo (
    polo_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade_id INT NOT NULL,
    FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
);

-- Create the 'turma' table
CREATE TABLE turma (
    turma_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    imagem_id INT,
    polo_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
);

-- Create the 'docente_turma' table (junction table for professores and turmas)
CREATE TABLE docente_turma (
    docente_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_associacao DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

-- Create the 'aluno_turma' table (junction table for alunos and turmas)
CREATE TABLE aluno_turma (
    aluno_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_matricula DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

-- Create the 'projeto' table
CREATE TABLE projeto (
    projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    link VARCHAR(255),
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id)
);

-- Create the 'imagem_projeto' table (junction table for projetos and imagens)
CREATE TABLE imagem_projeto (
    imagem_projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    imagem_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    projeto_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);