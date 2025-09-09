<?php

require_once __DIR__ . '/../Config/Database.php'; 

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