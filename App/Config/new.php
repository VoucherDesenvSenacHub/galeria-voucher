<?php
function criarBancoEGerarUsuario()
{
    $host = 'localhost';
    $port = '3308';
    $user = 'root';
    $pass = '';

    try {
        // Conectar sem banco para criar o banco
        $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Criar banco se não existir
        $pdo->exec("CREATE DATABASE IF NOT EXISTS galeriavoucher CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Banco criado ou já existente.\n";

        // Usar banco
        $pdo->exec("USE galeriavoucher");

        // Criar tabelas
        $sql = "
        CREATE TABLE IF NOT EXISTS imagem (
            imagem_id INT AUTO_INCREMENT PRIMARY KEY,
            url VARCHAR(255) NOT NULL,
            text TEXT,
            descricao TEXT,
            data_upload DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS pessoa (
            pessoa_id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            nome VARCHAR(255) NOT NULL,
            linkedin VARCHAR(255),
            github VARCHAR(255),
            imagem_id INT NULL,
            descricao TEXT,
            perfil ENUM('aluno', 'professor', 'adm') NOT NULL,
            FOREIGN KEY (imagem_id) REFERENCES imagem(imagem_id) ON DELETE SET NULL ON UPDATE CASCADE
        );

        CREATE TABLE IF NOT EXISTS usuario (
            usuario_id INT AUTO_INCREMENT PRIMARY KEY,
            pessoa_id INT NOT NULL,
            senha VARCHAR(255) NOT NULL,
            FOREIGN KEY (pessoa_id) REFERENCES pessoa(pessoa_id) ON DELETE CASCADE ON UPDATE CASCADE
        );
        ";

        $pdo->exec($sql);
        echo "Tabelas criadas ou já existentes.\n";

        // Inserir usuário padrão
        $email = 'admin@admin.com';
        $nome = 'Usuário Teste';
        $perfil = 'professor';
        $senha_texto = 'admin';
        $senha_hash = password_hash($senha_texto, PASSWORD_DEFAULT);

        // Verificar se já existe
        $stmt = $pdo->prepare("SELECT pessoa_id FROM pessoa WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() === 0) {
            // Inserir pessoa
            $stmtInsert = $pdo->prepare("INSERT INTO pessoa (email, nome, perfil) VALUES (:email, :nome, :perfil)");
            $stmtInsert->execute([':email' => $email, ':nome' => $nome, ':perfil' => $perfil]);
            $pessoa_id = $pdo->lastInsertId();

            // Inserir usuário
            $stmtInsert = $pdo->prepare("INSERT INTO usuario (pessoa_id, senha) VALUES (:pessoa_id, :senha)");
            $stmtInsert->execute([':pessoa_id' => $pessoa_id, ':senha' => $senha_hash]);

            echo "Usuário criado com sucesso: $email | senha: $senha_texto\n";
        } else {
            echo "Usuário $email já existe. Nenhuma ação realizada.\n";
        }
    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }
}

// Chamada da função
criarBancoEGerarUsuario();
