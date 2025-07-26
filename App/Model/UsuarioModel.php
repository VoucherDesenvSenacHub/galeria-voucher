<?php
class UsuarioModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorEmail(string $email): ?array
    {
        $sql = "
            SELECT p.pessoa_id, p.email, p.nome, p.perfil, u.senha
            FROM pessoa p
            INNER JOIN usuario u ON u.pessoa_id = p.pessoa_id
            WHERE p.email = :email
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function validarLogin(string $email, string $senha): array|false
    {
        $usuario = $this->buscarPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']); // Remove a senha do array
            return $usuario;
        }

        return false;
    }
}
