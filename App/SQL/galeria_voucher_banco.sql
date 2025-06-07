 CREATE DATABASE IF NOT EXISTS galeria_voucher;
 
 USE galeria_voucher;

 

CREATE TABLE IF NOT EXISTS pessoa (
    pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_id INT, -- vincula com outra tabela!
    descricao TEXT,
    perfil ENUM('aluno', 'professor', 'adm') NOT NULL
);

CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    pessoa_id INT NOT NULL,-- vincula com outra tabela!
    senha VARCHAR(255) NOT NULL,
    FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id)
);