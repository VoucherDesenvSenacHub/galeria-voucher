<?php

$caminhoAquivo = __DIR__ . '/../../.env';
$conteudoArquivo = file($caminhoAquivo);

$variaveis = [];

array_map(
    function($linha) use (&$variaveis){
        if (strpos($linha, '=') !== false) {
            list($key, $val) = explode('=', $linha, 2);
            $variaveis[trim($key)] = trim($val);
        }
    },
    $conteudoArquivo
);

define('VARIAVEIS', $variaveis);