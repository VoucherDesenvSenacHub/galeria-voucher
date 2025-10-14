<?php
class ValidarLoginController
{
    public static function validarAdmin()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'mensagem' => 'Acesso negado']);
            exit;
        }
    }
    
    public static function validarAdminRedirect($path)
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            $_SESSION['erro'] = 'Acesso negado';
            Redirect::to($path); // Usa a classe Redirect
        }
    }
}