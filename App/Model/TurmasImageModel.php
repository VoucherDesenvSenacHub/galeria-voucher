<?php
require_once __DIR__ . '/BaseModel.php';

class ImagensModel extends BaseModel
{
    public function __construct()
    {
        $this->tabela = 'imagem';
        parent::__construct();
    }


        /**
     * Salva metadados da imagem no banco
     * @param array $imagem
     *      [ 'descricao' ]
     * @return array|null
     */
    public function salvar($imagem)
    {
        $query = "INSERT INTO $this->tabela (descricao)
            VALUES (:descricao)";

        $stmt = $this->tabela->prepare($query);

        $salvou = $stmt->execute([
            ':descricao' => $imagem['descricao']
        ]);

        if ($salvou) {
            $query = "SELECT * FROM $this->tabela ORDER BY id DESC LIMIT 1";
            $stmt = $this->tabela->prepare($query);
            $stmt->execute();
            return $stmt->fetch();
        }
        return null;
    }


    /**
     * Faz upload da imagem e salva no banco
     * @param array $imagem Arquivo recebido de $_FILES['campo']
     * @return array|null
     */
    public function upload($imagem)
    {
        // Tipos de arquivos permitidos
        $mimeTypesPermitidas = ['image/jpeg', 'image/png'];
        $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

        if (!in_array($imagem['type'], $mimeTypesPermitidas)) {
            die('Tipo de arquivo inválido!');
        }

        // Verifica extensão
        $extensaoImagem = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        if (!in_array($extensaoImagem, $extensoesPermitidas)) {
            die('Extensão de arquivo inválida!');
        }

        // Verifica tamanho
        $tamanhoMaximoEmBytes = 16 * 1024 * 1024; // 16MB
        if ($imagem['size'] > $tamanhoMaximoEmBytes) {
            die('Tamanho da imagem inválido!');
        }

        // Diretório de destino
        $diretorioDestino = './uploads/uploadsImagensTurma/';
        $caminhoParaSalvar = __DIR__ . '/../' . $diretorioDestino;

        // Nome único
        $nomeUnico = uniqid() . '_' . $imagem['name'];
        $caminhoImagemBanco = $diretorioDestino . $nomeUnico;

        // Salva no disco
        $salvou = move_uploaded_file($imagem['tmp_name'], $caminhoParaSalvar . $nomeUnico);

        if ($salvou) {
            // Salva no banco e retorna registro
            return $this->salvar([
                'descricao' => $caminhoImagemBanco  
            ]);
        }
        return null;
    }

    /**
     * Busca todas as imagens salvas
     * @return array
     */
    public function buscarTodas(): array
    {
        $query = "SELECT * FROM $this->tabela";

        $stmt = $this->tabela->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}




