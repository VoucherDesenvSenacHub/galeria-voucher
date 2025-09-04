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
    public function buscarComImagemPorEmail(string $email): ?array
    {
        $query = "
            SELECT 
                p.pessoa_id, 
                p.email, 
                p.nome, 
                p.perfil, 
                i.url AS imagem
            FROM pessoa p
            INNER JOIN " . $this->tabela . " u ON u.pessoa_id = p.pessoa_id
            LEFT JOIN imagem i ON i.imagem_id = p.imagem_id
            WHERE p.email = :email
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return null;
        }

        return $usuario;
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

    public function buscarImagemPorPessoaId(int $pessoaId): string
    {
        $query = "
            SELECT COALESCE(i.url, '" . VARIAVEIS['APP_URL'] . "App/View/assets/img/adm/fallbackAdm.png') AS imagem
            FROM pessoa p
            LEFT JOIN imagem i ON i.imagem_id = p.imagem_id
            WHERE p.pessoa_id = :pessoaId
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':pessoaId' => $pessoaId]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['imagem'];
    }
}
