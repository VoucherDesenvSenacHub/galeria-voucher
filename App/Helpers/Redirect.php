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
    public static function to(string $path, array $params = []): void
    {
        $url = self::getAppUrl($path, $params);

        header("Location: " . $url);
        exit;
    }

    /**
     * Redireciona para uma página de administrador.
     *
     * @param string $page O nome do arquivo da página de admin.
     * @param array $params Parâmetros GET.
     */
    public static function toAdm(string $page, array $params = []): void
    {
        $path = Config::get('DIR_ADM') . $page;
        self::to($path, $params);
    }

    /**
     * Redireciona o usuário para uma URL.
     *
     * @param string $path O caminho para o qual redirecionar.
     * @param array $params Parâmetros GET a serem adicionados à URL.
     * @return string Retorna o caminho para site com params
     */
    public static function getAppUrl(string $path, array $params = []):string
    {
        $url = Config::get('APP_URL') . $path;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $url;
    }

     public static function getAdmUrl(string $page, array $params = []):string
     {
        $path = Config::get('DIR_ADM') . $page;
        return self::getAppUrl($path, $params);
     }
}