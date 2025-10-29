<?php

class Config
{
    private static $settings = [
        'APP_URL' => 'http://localhost/galeria-voucher/',
        'DIR_IMG' => 'App/View/assets/img/',
        'DIR_CSS' => 'App/View/assets/css/',
        'DIR_JS' => 'App/View/assets/js/',
        'DIR_ADM' => 'App/View/pages/adm/',
        'DIR_USER' => 'App/View/pages/users/',
        'DIR_LOGOUT' => 'App/View/includes/',
    ];

    /**
     * Retorna um valor de configuração.
     *
     * @param string $key A chave da configuração.
     * @return string|null
     */
    public static function get(string $key): ?string
    {
        return self::$settings[$key] ?? null;
    }

    public static function getAppUrl()
    {
        return self::get('APP_URL');
    }

    
    public static function getDirImg()
    {
        return self::getAppUrl() . self::get('DIR_IMG');
    }

    public static function getDirCss()
    {
        return self::getAppUrl() . self::get('DIR_CSS');
    }

    public static function getDirJs()
    {
        return self::getAppUrl() . self::get('DIR_JS');
    }

    public static function getDirAdm()
    {
        return self::getAppUrl() . self::get('DIR_ADM');
    }

    public static function getDirUser()
    {
        return self::getAppUrl() . self::get('DIR_USER');
    }

    public static function getDirLogout()
    {
        return self::getAppUrl() . self::get('DIR_LOGOUT');
    }

    //     /**
    //  * Redireciona o usuário para uma URL.
    //  *
    //  * @param string $path O caminho para o qual redirecionar.
    //  * @param array $params Parâmetros GET a serem adicionados à URL.
    //  */
    // public static function to(string $path, array $params = []): void
    // {
    //     $url = self::getAppUrl() . $path;

    //     if (!empty($params)) {
    //         $url .= '?' . http_build_query($params);
    //     }

    //     header("Location: " . $url);
    //     exit;
    // }

}