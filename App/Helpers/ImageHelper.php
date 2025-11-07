<?php

/**
 * Gera a URL completa de uma imagem, aplicando regras de fallback e subpasta.
 * * @param string|null $nomeImagem Nome do arquivo da imagem ou URL completa.
 * @param string $fallback Caminho da imagem padrão caso $nomeImagem não seja informado.
 * @return string URL completa da imagem para exibição.
 */
function urlImagem(?string $nomeImagem, ?string $fallback = 'App/View/assets/img/utilitarios/foto.png'): string
{

    // Se não houver nome de imagem, usa a imagem de fallback padrão
    if (empty($nomeImagem)) {
        $nomeImagem = $fallback;
    }

    // Retorna a URL completa (base + nome da imagem)
    return Config::getAppUrl() . $nomeImagem;
}