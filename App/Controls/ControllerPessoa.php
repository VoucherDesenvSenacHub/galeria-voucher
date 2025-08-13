<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../Model/PessoaModel.php';
ob_clean();
$model = new PessoaModel();

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? null;

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';
$perfil = $_POST['perfil'] ?? '';
$polo = $_POST['polo'] ?? '';

switch ($acao) {
    case 'listarJson':
        $json = $model->listarPessoas();

        if ($json) {
            header('Content-Type: application/json');
            echo json_encode($json);
        } else {
            echo json_encode([]);
        }
        exit;  // para evitar qualquer saída extra depois

        break;
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
        if ($id) {
            if ($model->deletarPessoa($id)) {
                header("Location:/galeria-voucher/App/View/pages/adm/listarUsuarios.php");
                exit;
            }
        } else {
            echo "Erro ao deletar pessoa.";
        }
        break;
}
