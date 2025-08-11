<?php
require_once __DIR__ . '/../Model/PessoaModel.php';

$model = new PessoaModel();

$acao = $_POST['acao'] ?? '';
$id = $_POST['id'] ?? null;

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';
$perfil = $_POST['perfil'] ?? '';
$polo = $_POST['polo'] ?? '';

if ($acao === 'editar' && $id) {

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
