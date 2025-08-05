<?php
namespace App\Helpers;

/**
 * Gera a URL da imagem, considerando fallback e subpasta.
 * 
 * @param string|null $nomeImagem Nome do arquivo ou URL da imagem.
 * @param string $subpastaDefault Subpasta padrão para imagens locais.
 * @param string $fallback Imagem padrão caso não tenha nome.
 * @return string URL completa da imagem.
 */
function urlImagem(?string $nomeImagem, string $subpastaDefault = 'turmas/', string $fallback = 'utilitarios/placeholder-user.png'): string {
    if (!empty($nomeImagem) && (str_starts_with($nomeImagem, 'http://') || str_starts_with($nomeImagem, 'https://'))) {
        return $nomeImagem;
    }

    if (empty($nomeImagem)) {
        $nomeImagem = $fallback;
    }

    $subpasta = (str_contains($nomeImagem, '/') && !str_contains($nomeImagem, ' ')) ? '' : $subpastaDefault;
    $base = rtrim(\VARIAVEIS['APP_URL'], '/') . '/' . trim(\VARIAVEIS['DIR_IMG'], '/') . '/';

    return $base . $subpasta . $nomeImagem;
}
