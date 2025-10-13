<?php

require_once __DIR__ . '/../Config/App.php';

class Redirect
{
    /**
     * Redireciona o usuário para uma URL.
     *
     * @param string $path O caminho para o qual redirecionar.
     * @param array $params Parâmetros GET a serem adicionados à URL.
     */
    public static functionto(string $path, array $params = []): void
    {
        $url = Config::get('APP_URL') . $path;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        header("Location: " . $url);
        exit;
    }

    /**
     * Redireciona para uma página de administrador.
     *
     * @param string $page O nome do arquivo da página de admin.
     * @param array $params Parâmetros GET.
     */
    public static functiontoAdm(string $page, array $params = []): void
    {
        $path = Config::get('DIR_ADM') . $page;
        self::to($path, $params);
    }
}