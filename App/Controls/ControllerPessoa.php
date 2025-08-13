<?php
require_once __DIR__ . '/../Model/PessoaModel.php';

$model = new PessoaModel();

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? null;

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';
$perfil = $_GET['perfil'] ?? $_POST['perfil'] ?? null;
$polo = $_POST['polo'] ?? '';

switch ($acao) {
    case 'editar':
        if ($id) {
            $dados = [
                'nome' => $nome,
                'email' => $email,
                'perfil' => $perfil,
                'linkedin' => $linkedin,
                'github' => $github,
                'polo' => $polo
            ];

            if ($model->atualizarPessoa((int)$id, $dados, null)) {
                header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?acao=editar&id={$id}");
                exit;
            } else {
                echo "Erro ao atualizar pessoa.";
            }
        }
        break;

    case 'excluir':
        if ($id && $perfil) {
            if ($model->deletarPessoa($id, $perfil)) {
                header("Location: /galeria-voucher/App/View/pages/adm/listarUsuarios.php");
                exit;
            } else {
                // Falha: exibe uma mensagem de erro
                echo "Erro: Não foi possível excluir o registro. Verifique as dependências ou contate o administrador.";
                // Para depuração, você pode querer ver o erro do banco de dados:
                // print_r($model->getDbError()); // Supondo que você tenha um método para isso no seu model
            }
        } else {
            // O ID não foi fornecido
            echo "Erro: ID do usuário não especificado.";
        }
        break;

        // ... (resto do código)
}
