<?php
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/ValidarLoginController.php';

class UsuarioController
{
    private UsuarioModel $model;

    public function __construct()
    {
        $this->model = new UsuarioModel();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function verificarLogin(): void
    {
        $urlRedirecionamento = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php';
        ValidarLoginController::validarAdminRedirect($urlRedirecionamento);
    }

    public function getUsuarioNome(): string
    {
        return $_SESSION['usuario']['nome'] ?? '';
    }

    public function getUsuarioImagem(): ?string
    {
        return $this->model->buscarImagemPorPessoaId($_SESSION['usuario']['pessoa_id'] ?? 0);
    }
}
