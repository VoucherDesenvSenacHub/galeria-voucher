<?php

require_once __DIR__ . '/BaseModel.php';

class UsuarioModel extends BaseModel
{
    public function __construct()
    {
        $this->tabela = "usuario";
        parent::__construct();
    }

    /**
     * Busca um usuário pelo e-mail
     * @param string $email
     * @return array|null
     */
    public function buscarPorEmail(string $email): ?array
    {
        $query = "
            SELECT p.pessoa_id, p.email, p.nome, p.perfil, u.senha
            FROM pessoa p
            INNER JOIN " . self::$tabela . " u ON u.pessoa_id = p.pessoa_id
            WHERE p.email = :email
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Valida login do usuário pelo e-mail e senha
     * @param string $email
     * @param string $senha
     * @return array|false Retorna os dados do usuário (sem senha) ou false se inválido
     */
    public function validarLogin(string $email, string $senha): array|false
    {
        $query = "
            SELECT p.pessoa_id, p.email, p.nome, p.perfil, u.senha
            FROM pessoa p
            INNER JOIN " . $this->tabela . " u ON u.pessoa_id = p.pessoa_id
            WHERE p.email = :email
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            return false;
        }

        unset($usuario['senha']);
        return $usuario;
    }
}
