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
    private static function get(string $key): ?string
    {
        return self::$settings[$key] ?? null;
    }
    
    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getAppUrl(array $params = []): string
    {
        if(empty($params)) {
            return self::get('APP_URL');
        }

        return self::get('APP_URL') . '?' . http_build_query($params);
    }

    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getDirImg( array $params = []): string
    {
        if(empty($params)) {
            return self::getAppUrl($params) . self::get('DIR_IMG');
        }

        return self::getAppUrl() .'?' . http_build_query($params);
    }

    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getDirCss(array $params = []): string
    {
        if(empty($params)) {
            return self::getAppUrl($params) . self::get('DIR_CSS');
        }

        return self::getAppUrl() .'?' . http_build_query($params);
    }

    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getDirJs(array $params = []): string
    {
        if(empty($params)) {
            return self::getAppUrl($params) . self::get('DIR_JS');
        }
    
        return self::getAppUrl() .'?'. http_build_query($params);
    }

    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getDirAdm(array $params = []): string
    {
        if(empty($params)) {
            return self::getAppUrl($params) . self::get('DIR_ADM');
        }

        return self::getAppUrl() .'?' . http_build_query($params);
    }

    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getDirUser(array $params = []): string
    {
        if(empty($params)) {
            return self::getAppUrl($params) . self::get('DIR_USER');
        }   
    
        return self::getAppUrl() .'?' . http_build_query($params);
    }

    /**
     * Retorna a URL da aplicação.
     *
     * @param array $params Parâmetros GET opcionais.
     * @return string
     */
    public static function getDirLogout(array $params = []): string
    {
        if(empty($params)) {
            return self::getAppUrl($params) . self::get('DIR_LOGOUT');
        }
    
        return self::getAppUrl() .'?' . http_build_query($params);
    }

}
