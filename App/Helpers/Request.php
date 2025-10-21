<?php

class Request
{
    /**
     * Pega um valor do array $_GET.
     *
     * @param string $key A chave a ser buscada.
     * @param mixed $default O valor padrão a ser retornado se a chave não existir.
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Pega um valor do array $_POST.
     *
     * @param string $key A chave a ser buscada.
     * @param mixed $default O valor padrão a ser retornado se a chave não existir.
     * @return mixed
     */
    public static function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Pega um arquivo do array $_FILES.
     *
     * @param string $key A chave do arquivo.
     * @return array|null
     */
    public static function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }

    /**
     * Pega um valor do array $_SERVER.
     *
     * @param string $key A chave a ser buscada.
     * @return string|null
     */
    public static function server(string $key): ?string
    {
        return $_SERVER[$key] ?? null;
    }

    /**
     * Retorna o método da requisição (GET, POST, etc.).
     *
     * @return string
     */
    public static function getMethod(): string
    {
        return self::server('REQUEST_METHOD') ?? 'GET';
    }

    /**
     * Pega um ID numérico da URL (parâmetro 'id').
     *
     * @return int|null
     */
    public static function getUriId($key = "id"): ?int
    {
        $id = self::get($key);
        if ($id && filter_var($id, FILTER_VALIDATE_INT)) {
            return (int)$id;
        }
        return null;
    }
}