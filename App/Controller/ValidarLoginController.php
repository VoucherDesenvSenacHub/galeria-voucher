<?php
class ValidarLoginController {
    public static function validarAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'mensagem' => 'Acesso negado']);
            exit;
        }
    }
    
    public static function validarAdminRedirect($url) {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            $_SESSION['erro'] = 'Acesso negado';
            header('Location: ' . $url);
            exit;
        }
    }
}