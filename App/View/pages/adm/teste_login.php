<?php
// Configuração PDO (ajuste conforme seu ambiente)
$host = 'localhost';
$port = '3308';
$dbname = 'galeriavoucher';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão OK<br>";

    $email = 'testes@exemplo.com';
    $senhaDigitada = 'usuarios';

    $sql = "
        SELECT p.pessoa_id, p.email, p.nome, p.perfil, u.senha
        FROM pessoa p
        INNER JOIN usuario u ON u.pessoa_id = p.pessoa_id
        WHERE p.email = :email
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo "Usuário encontrado:<br>";
        print_r($usuario);
        echo "<br>";

        $senhaHash = $usuario['senha'];
        if (password_verify($senhaDigitada, $senhaHash)) {
            echo "Senha correta! Login válido.";
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
