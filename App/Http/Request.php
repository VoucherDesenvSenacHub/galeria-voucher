<?php

/**
 * Classe para encapsular a requisição HTTP.
 * Fornece métodos seguros para acessar dados de $_GET, $_POST e $_SERVER.
 */
class Request
{
    /**
     * Obtém um valor do array $_GET.
     *
     * @param string $key A chave a ser buscada.
     * @param mixed $default O valor padrão a ser retornado se a chave não existir.
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Obtém um valor do array $_POST.
     *
     * @param string $key A chave a ser buscada.
     * @param mixed $default O valor padrão a ser retornado se a chave não existir.
     * @return mixed
     */
    public function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Obtém um valor de $_GET ou $_POST.
     *
     * @param string $key A chave a ser buscada.
     * @param mixed $default O valor padrão.
     * @return mixed
     */
    public function input(string $key, $default = null)
    {
        return $this->post($key, $this->get($key, $default));
    }

    /**
     * Retorna o método HTTP da requisição (GET, POST, etc.).
     *
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Obtém e valida o 'id' da requisição (de $_GET ou $_POST).
     * Garante que o ID seja um número inteiro positivo.
     *
     * @param string $key O nome do parâmetro do ID (padrão: 'id').
     * @return int|null Retorna o ID como inteiro ou null se for inválido.
     */
    public function id(string $key = 'id'): ?int
    {
        $id = $this->input($key);
        
        if (is_numeric($id) && filter_var($id, FILTER_VALIDATE_INT) && (int)$id > 0) {
            return (int)$id;
        }
        
        return null;
    }
}