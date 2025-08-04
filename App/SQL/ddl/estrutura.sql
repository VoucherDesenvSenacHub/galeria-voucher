CREATE DATABASE IF NOT EXISTS galeria_voucher;
USE galeria_voucher;

-- Tabela para armazenar imagens
CREATE TABLE IF NOT EXISTS imagem (
    imagem_id INT AUTO_INCREMENT PRIMARY KEY, 
    url VARCHAR(255) NOT NULL,
    text TEXT,
    descricao TEXT,
    data_upload DATETIME NOT NULL
);

-- Tabela para cidades
CREATE TABLE IF NOT EXISTS cidade (
    cidade_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela para polos, vinculados a cidades
CREATE TABLE IF NOT EXISTS polo (
    polo_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade_id INT NOT NULL,
    FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
);

-- Tabela para turmas, vinculadas a polos e imagens (imagem opcional)
CREATE TABLE IF NOT EXISTS turma (
    turma_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    imagem_id INT NULL,
    polo_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
);

-- Tabela para pessoas (alunos, professores, admin)
CREATE TABLE IF NOT EXISTS pessoa (
    pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_id INT NULL,
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id)
);

-- Tabela para usuários do sistema, vinculados a pessoa
CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

-- Tabela de associação entre professores e turmas (docente_turma)
CREATE TABLE IF NOT EXISTS docente_turma (
    docente_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_associacao DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

-- Tabela de associação entre alunos e turmas (aluno_turma)
CREATE TABLE IF NOT EXISTS aluno_turma (
    aluno_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_matricula DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

-- Tabela para projetos vinculados a uma turma
CREATE TABLE IF NOT EXISTS projeto (
    projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    link VARCHAR(255),
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id)
);

-- Tabela para dias do projeto, tipo: Início, Processo, Entrega
CREATE TABLE IF NOT EXISTS projeto_dia (
    projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_dia ENUM('I', 'P', 'E') NOT NULL,
    descricao TEXT,
    projeto_id INT NOT NULL,
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);

-- Tabela para imagens vinculadas a dias do projeto
CREATE TABLE IF NOT EXISTS imagem_projeto_dia (
    imagem_projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
    imagem_id INT NOT NULL,
    projeto_dia_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (projeto_dia_id) REFERENCES projeto_dia(projeto_dia_id)
);






-- -- Create the database

-- -- conferir se esta de acordo 
-- CREATE DATABASE IF NOT EXISTS galeria_voucher;
-- USE galeria_voucher;

-- -- Drop database galeria_voucher;

-- -- Create the 'imagem' table
-- CREATE table if not EXISTS imagem (
--     imagem_id INT AUTO_INCREMENT PRIMARY KEY, 
--     url VARCHAR(255) NOT NULL,
--     text TEXT,
--     descricao TEXT,
--     data_upload DATETIME NOT NULL
-- );

-- -- Create the 'pessoa' table
-- CREATE table if not EXISTS pessoa (
--     pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
--     email VARCHAR(255) NOT NULL UNIQUE,
--     nome VARCHAR(255) NOT NULL,
--     linkedin VARCHAR(255),
--     github VARCHAR(255),
--     imagem_id INT,
--     perfil ENUM('aluno', 'professor', 'adm') NOT NULL,
--     FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id)
-- );

-- -- Create the 'usuario' table
-- CREATE table if not EXISTS usuario (
--     usuario_id INT AUTO_INCREMENT PRIMARY KEY,
--     pessoa_id INT NOT NULL,
--     senha VARCHAR(255) NOT NULL,
--     FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
-- );

-- -- Create the 'cidade' table
-- CREATE table if not EXISTS cidade (
--     cidade_id INT AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(100) NOT NULL
-- );

-- -- Create the 'polo' table
-- CREATE table if not EXISTS polo (
--     polo_id INT AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(100) NOT NULL,
--     cidade_id INT NOT NULL,
--     FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
-- );

-- -- Create the 'turma' table
-- CREATE table if not EXISTS turma (
--     turma_id INT AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(100) NOT NULL,
--     descricao TEXT,
--     data_inicio DATE NOT NULL,
--     data_fim DATE,
--     imagem_id INT,
--     polo_id INT NOT NULL,
--     FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
--     FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
-- );

-- -- Create the 'docente_turma' table if not EXISTS (junction table if not EXISTS for professores and turmas)
-- CREATE table if not EXISTS docente_turma (
--     docente_turma_id INT AUTO_INCREMENT PRIMARY KEY,
--     pessoa_id INT NOT NULL,
--     turma_id INT NOT NULL,
--     data_associacao DATE NOT NULL,
--     FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
--     FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
--     UNIQUE KEY (pessoa_id, turma_id)
-- );

-- -- Create the 'aluno_turma' table if not EXISTS (junction table if not EXISTS for alunos and turmas)
-- CREATE table if not EXISTS aluno_turma (
--     aluno_turma_id INT AUTO_INCREMENT PRIMARY KEY,
--     pessoa_id INT NOT NULL,
--     turma_id INT NOT NULL,
--     data_matricula DATE NOT NULL,
--     FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
--     FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
--     UNIQUE KEY (pessoa_id, turma_id)
-- );


-- -- Manter: Tabela projeto
-- CREATE TABLE IF NOT EXISTS projeto (
--     projeto_id INT AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(255) NOT NULL,
--     descricao TEXT,
--     link VARCHAR(255),
--     turma_id INT NOT NULL,
--     FOREIGN KEY (turma_id) REFERENCES turma(turma_id)
-- );

-- -- ⚠️ ALTERAÇÃO: Renomeando e ajustando imagem_projeto para imagem_projeto_dia
-- DROP TABLE IF EXISTS imagem_projeto;

-- CREATE TABLE IF NOT EXISTS imagem_projeto_dia (
--     imagem_projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
--     imagem_id INT NOT NULL,
--     url VARCHAR(255) NOT NULL,
--     projeto_dia_id INT NOT NULL,
--     FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
--     FOREIGN KEY (projeto_dia_id) REFERENCES projeto_dia(projeto_dia_id)
-- );

-- -- ✅ NOVA: Tabela projeto_dia
-- CREATE TABLE IF NOT EXISTS projeto_dia (
--     projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
--     tipo_dia ENUM('I', 'P', 'E') NOT NULL,
--     descricao TEXT,
--     projeto_id INT NOT NULL,
--     FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
-- );
