<?php
require_once __DIR__ . '/BaseModel.php';

class PessoaModel extends BaseModel {
     // crud  criado conferir e testar!
    // Criar pessoa (Create)
    public function criarPessoa(array $dados, ?int $imagemId) : bool {
        $sql = "INSERT INTO pessoa (nome, email, perfil, linkedin, github, imagem_id) 
                VALUES (:nome, :email, :perfil, :linkedin, :github, :imagem_id)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':perfil' => $dados['perfil'],
            ':linkedin' => $dados['linkedin'] ?? null,
            ':github' => $dados['github'] ?? null,
            ':imagem_id' => $imagemId
        ]);
    }

    // Buscar pessoa por ID (Read)
    public function buscarPessoaPorId(int $id) : ?array {
        $sql = "SELECT * FROM pessoa WHERE pessoa_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }

    // Atualizar pessoa (Update)
    public function atualizarPessoa(int $id, array $dados, ?int $imagemId = null) : bool {
        $sql = "UPDATE pessoa SET nome = :nome, email = :email, perfil = :perfil, linkedin = :linkedin, github = :github";

        if ($imagemId !== null) {
            $sql .= ", imagem_id = :imagem_id";
        }

        $sql .= " WHERE pessoa_id = :id";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':perfil' => $dados['perfil'],
            ':linkedin' => $dados['linkedin'] ?? null,
            ':github' => $dados['github'] ?? null,
            ':id' => $id
        ];

        if ($imagemId !== null) {
            $params[':imagem_id'] = $imagemId;
        }

        return $stmt->execute($params);
    }

    // Deletar pessoa (Delete)
    public function deletarPessoa(int $id) : bool {
        $sql = "DELETE FROM pessoa WHERE pessoa_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Listar todas as pessoas
    public function listarPessoas() : array {
        $sql = "SELECT * FROM pessoa";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Funcao par listamso 
    public function listarPerfisPermitidos(): array {  
        $sql = "SHOW COLUMNS FROM pessoa WHERE Field = 'perfil'";
        $stmt = $this->pdo->query($sql);
        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$coluna) return [];
    
        preg_match("/^enum\((.*)\)$/", $coluna['Type'], $matches);
    
        if (!isset($matches[1])) return [];
    
        $valores = explode(',', $matches[1]);
        $valores = array_map(function($valor) {
            return trim($valor, " '");
        }, $valores);
    
        return $valores;
    }
    
}
