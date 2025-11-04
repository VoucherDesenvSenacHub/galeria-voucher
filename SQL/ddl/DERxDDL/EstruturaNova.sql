-- Conferindo a principio 1 coluna na tabela turma-> exibir_pagina_dev
-- Comparando os script do ddl e corrigindo para nao precisa executar varios (script unico)
-- 1. CRIAÇÃO DO BANCO DE DADOS
CREATE DATABASE IF NOT EXISTS galeria_voucher;
USE galeria_voucher;

-- 2. TABELA IMAGEM
CREATE TABLE IF NOT EXISTS imagem (
    imagem_id INT AUTO_INCREMENT PRIMARY KEY, 
    url VARCHAR(255) NOT NULL,
    text TEXT,
    descricao TEXT,
    data_upload DATETIME NOT NULL
);

-- 3. TABELAS DE LOCALIZAÇÃO

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

-- 4. TABELA PESSOA (Contém Alunos, Professores e ADMs)
CREATE TABLE IF NOT EXISTS pessoa (
    pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_id INT,
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id)
);

-- 5. TABELA USUARIO (Apenas para pessoas com acesso ao sistema: ADM e Professores)
CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);

-- 6. TABELA TURMA (Incluindo a flag de exibição na página de desenvolvedores)
CREATE TABLE IF NOT EXISTS turma (
    turma_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    imagem_id INT,
    polo_id INT NOT NULL,
    exibir_pagina_dev INT(1) DEFAULT 0, -- Coluna para controle de exibição na página Devs
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (polo_id) REFERENCES polo(polo_id)
);

-- 7. TABELAS DE RELACIONAMENTO M-M (PESSOA X TURMA)
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

-- 8. TABELAS DE PROJETO
CREATE TABLE IF NOT EXISTS projeto (
    projeto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    link VARCHAR(255),
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turma(turma_id)
);

-- 9. TABELA DE DIAS/FASES DO PROJETO
CREATE TABLE IF NOT EXISTS projeto_dia (
    projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_dia ENUM('I', 'P', 'E') NOT NULL, -- I: Início, P: Processo/Desenvolvimento, E: Entrega
    descricao TEXT,
    projeto_id INT NOT NULL,
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id),
    UNIQUE KEY unique_tipo_projeto (tipo_dia, projeto_id)
);

-- 10. TABELA DE ASSOCIAÇÃO IMAGEM X DIA_PROJETO
CREATE TABLE IF NOT EXISTS imagem_projeto_dia (
    imagem_projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
    imagem_id INT NOT NULL,
    projeto_dia_id INT NOT NULL,
    FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id),
    FOREIGN KEY (projeto_dia_id) REFERENCES projeto_dia(projeto_dia_id)
);
