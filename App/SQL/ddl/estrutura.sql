-- Criar banco
CREATE DATABASE IF NOT EXISTS galeria_voucher;
USE galeria_voucher;

-- ======================
-- Estrutura ORIGINAL (antiga)
-- ======================

CREATE TABLE IF NOT EXISTS imagem (
    imagem_id INT AUTO_INCREMENT PRIMARY KEY, 
    url VARCHAR(255) NOT NULL,
    text TEXT,
    descricao TEXT,
    data_upload DATETIME NOT NULL
);

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

CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

CREATE TABLE IF NOT EXISTS cidade (
    cidade_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS polo (
    polo_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade_id INT NOT NULL,
    FOREIGN KEY (cidade_id) REFERENCES cidade(cidade_id)
);

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

CREATE TABLE IF NOT EXISTS docente_turma (
    docente_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_associacao DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

CREATE TABLE IF NOT EXISTS aluno_turma (
    aluno_turma_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    turma_id INT NOT NULL,
    data_matricula DATE NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id),
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id),
    UNIQUE KEY (pessoa_id, turma_id)
);

CREATE TABLE IF NOT EXISTS projeto (
    projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    link VARCHAR(255),
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id)
);

CREATE TABLE IF NOT EXISTS imagem_projeto (
    imagem_projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    imagem_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    projeto_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);

-- ======================
-- ALTERAÇÕES para chegar no modelo ATUAL
-- ======================

-- Criar nova tabela projeto_dia
CREATE TABLE IF NOT EXISTS projeto_dia (
    projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_dia ENUM('I', 'P', 'E') NOT NULL,
    descricao TEXT,
    projeto_id INT NOT NULL,
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);

-- Restrição para garantir que não haja dias duplicados para o mesmo projeto
ALTER TABLE projeto_dia
ADD UNIQUE KEY unique_tipo_projeto (tipo_dia, projeto_id);

-- Renomear tabela imagem_projeto para imagem_projeto_dia
RENAME TABLE imagem_projeto TO imagem_projeto_dia;

-- Alterar tabela imagem_projeto_dia
ALTER TABLE imagem_projeto_dia DROP FOREIGN KEY imagem_projeto_dia_ibfk_2;

ALTER TABLE imagem_projeto_dia DROP COLUMN projeto_id;

ALTER TABLE imagem_projeto_dia DROP COLUMN url;

ALTER TABLE imagem_projeto_dia
  ADD COLUMN projeto_dia_id INT NOT NULL AFTER imagem_id,
  ADD KEY projeto_dia_id (projeto_dia_id),
  ADD CONSTRAINT imagem_projeto_dia_ibfk_2 FOREIGN KEY (projeto_dia_id) REFERENCES projeto_dia(projeto_dia_id);


/*
ALTERAÇÃO IMPORTANTE: 
Foi criada a tabela 'imagem_projeto_dia' para substituir a antiga 'imagem_projeto' na associação entre imagens e etapas (dias) do projeto.

- A tabela 'imagem_projeto_dia' relaciona imagens diretamente com os dias do projeto (projeto_dia_id).
- A coluna 'url' foi removida da tabela antiga, agora as imagens são referenciadas apenas pelo ID na tabela 'imagem'.
- Essa alteração visa melhorar a integridade referencial e organizar melhor o vínculo entre imagens e fases do projeto.
*/