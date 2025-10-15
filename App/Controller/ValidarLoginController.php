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
    
    /**
     * Valida se o usuário é 'adm' ou 'professor'.
     * Se não for, redireciona para a página especificada.
     * @param string $path O caminho relativo para redirecionar (ex: 'App/View/pages/adm/login.php')
     */
    public static function validarAdminRedirect($path)
    {
        if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['perfil'], ['adm', 'professor'])) {
            $_SESSION['erro'] = 'Acesso negado';
            Redirect::to($path); // Corrigido para usar a nova classe Redirect
        }
    }
}