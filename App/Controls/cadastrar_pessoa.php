<?php

require_once __DIR__ . '/../../Config/Database.php'; 

function limpar_dado($valor) {
    return htmlspecialchars(trim($valor));
}

function cadastrar_pessoa($dados, $arquivoFoto) {
    global $conn;

    $erros = [];

    // Validação dos campos obrigatórios
    $nome = limpar_dado($dados["nome"] ?? '');
    if (empty($nome)) $erros[] = "nome";

    $email = limpar_dado($dados["email"] ?? '');
    if (empty($email)) {
        $erros[] = "e-mail";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "e-mail (formato inválido)";
    }

    $perfil = limpar_dado($dados["perfil"] ?? '');
    if (!in_array($perfil, ['aluno', 'professor', 'adm'])) {
        $erros[] = "perfil";
    }

    // Foto (obrigatória)
    $imagem_id = null;
    if (isset($arquivoFoto) && $arquivoFoto["error"] === 0) {
        $diretorio = __DIR__ . '/../../uploads/';
        if (!is_dir($diretorio)) mkdir($diretorio, 0777, true);

        $nomeArquivo = uniqid() . "_" . basename($arquivoFoto["name"]);
        $caminhoCompleto = $diretorio . $nomeArquivo;
        $urlPublica = 'uploads/' . $nomeArquivo;
        $tipoImagem = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
        $verificaImagem = getimagesize($arquivoFoto["tmp_name"]);

        if ($verificaImagem === false) {
            $erros[] = "foto (tipo inválido)";
        } elseif (!in_array($tipoImagem, ['jpg', 'jpeg', 'png', 'gif'])) {
            $erros[] = "foto (somente JPG, JPEG, PNG e GIF)";
        } else {
            if (!move_uploaded_file($arquivoFoto["tmp_name"], $caminhoCompleto)) {
                $erros[] = "foto (falha no upload)";
            } else {
                // Inserir a imagem na tabela 'imagem'
                $sqlImagem = "INSERT INTO imagem (url, text, descricao, data_upload)
                              VALUES (?, '', '', NOW())";
                $stmtImagem = $conn->prepare($sqlImagem);
                $stmtImagem->bind_param("s", $urlPublica);
                if ($stmtImagem->execute()) {
                    $imagem_id = $conn->insert_id;
                } else {
                    $erros[] = "imagem (erro ao salvar no banco)";
                }
            }
        }
    } else {
        $erros[] = "foto";
    }

    $linkedin = limpar_dado($dados["linkedin"] ?? '');
    $github = limpar_dado($dados["github"] ?? '');

    // Se houve erros, retorna
    if (!empty($erros)) {
        return ["sucesso" => false, "mensagem" => "Erro no cadastro: (" . implode(", ", $erros) . ")"];
    }

    // Inserir na tabela pessoa
    $sqlPessoa = "INSERT INTO pessoa (email, nome, linkedin, github, imagem_id, perfil)
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmtPessoa = $conn->prepare($sqlPessoa);
    $stmtPessoa->bind_param("ssssis", $email, $nome, $linkedin, $github, $imagem_id, $perfil);

    if ($stmtPessoa->execute()) {
        return ["sucesso" => true];
    } else {
        return ["sucesso" => false, "mensagem" => "Erro no banco de dados (pessoa): " . $stmtPessoa->error];
    }
}
?>
=======
require_once __DIR__ . '/../Model/PessoaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';

$pessoaModel = new PessoaModel();
$imagemModel = new ImagemModel();
$mensagem = '';
$pessoaCriada = null;



// trim($url) remove espaços do início e fim.

// empty(...) verifica se a string está vazia após o trim.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Processar upload da imagem
        $imagemId = null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            // Validação básica da imagem
            $tipoPermitido = ['image/jpeg', 'image/png', 'image/gif'];
            $tamanhoMaximo = 2 * 1024 * 1024; // 2MB

            if (!in_array($_FILES['imagem']['type'], $tipoPermitido)) {
                throw new Exception("Tipo de arquivo não permitido. Use apenas JPEG, PNG ou GIF.");
            }

            if ($_FILES['imagem']['size'] > $tamanhoMaximo) {
                throw new Exception("Arquivo muito grande. Tamanho máximo: 2MB.");
            }

            // Configurações do upload
            $diretorioUpload = __DIR__ . '/../uploads/';
            $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $caminhoCompleto = $diretorioUpload . $nomeArquivo;

            // Criar diretório se não existir
            if (!file_exists($diretorioUpload)) {
                if (!mkdir($diretorioUpload, 0755, true)) {
                    throw new Exception("Não foi possível criar o diretório de uploads.");
                }
            }

            // Mover arquivo
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
                // Salvar no banco de dados
                $urlRelativa = '/../View/assets/img/uploads/' . $nomeArquivo;
                $imagemId = $imagemModel->criarImagem($urlRelativa, null, 'Imagem de perfil');
            } else {
                throw new Exception("Erro ao mover o arquivo enviado.");
            }
        }

        // Dados da pessoa
        $dados = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'perfil' => $_POST['perfil'] ?? '',
            'linkedin' => trim($_POST['linkedin'] ?? null),
            'github' => trim($_POST['github'] ?? null)
        ];

        // Validações básicas
        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['perfil'])) {
            throw new Exception("Nome, email e perfil são obrigatórios.");
        }

        // Criar pessoa
        $criado = $pessoaModel->criarPessoa($dados, $imagemId);

        if ($criado) {

            $ultimoId = $pessoaModel->getLastInsertId(); // ✅ agora funciona

            $pessoaCriada = $pessoaModel->buscarPessoaPorId($ultimoId);
            $mensagem = "✅ Pessoa criada com sucesso! ID: {$ultimoId}";
        } else {
            $mensagem = "❌ Erro ao cadastrar pessoa.";
        }
    } catch (Exception $e) {
        
        if (strpos($e->getMessage(), '1062 Duplicate entry') !== false) {
            $mensagem = "❌ Este email já está cadastrado.";
        } else {
            $mensagem = "❌ Erro ao cadastrar: " . $e->getMessage(); 
        }
    }
}

$perfis = $pessoaModel->listarPerfisPermitidos();
$perill = $pessoaModel->listarPessoas();
// var_dump($perill);

