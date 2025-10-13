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
    public static functionget(string $key): ?string
    {
        return self::$settings[$key] ?? null;
    }
}