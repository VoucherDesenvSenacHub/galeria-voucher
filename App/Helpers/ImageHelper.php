<?php
/**
 * Gera a URL completa de uma imagem, aplicando regras de fallback e subpasta.
 * 
 * @param string|null $nomeImagem Nome do arquivo da imagem ou URL completa.
 * @param string $subpastaDefault Subpasta padrão para imagens locais.
 * @param string $fallback Caminho da imagem padrão caso $nomeImagem não seja informado.
 * @return string URL completa da imagem para exibição.
 */
function urlImagem(?string $nomeImagem, string $fallback = 'App/View/assets/img/utilitarios/placeholder-user.png'): string {
    
    // 1. Se o nome informado já for uma URL absoluta (http ou https), retorna como está
    if (str_starts_with($nomeImagem, 'http://') || str_starts_with($nomeImagem, 'https://')) {
        return $nomeImagem;
    }

    // 2. Se não houver nome de imagem, usa a imagem de fallback padrão
    if (empty($nomeImagem)) {
        $nomeImagem = $fallback;
    }

    // 5. Retorna a URL completa (base + nome da imagem)
    return VARIAVEIS['APP_URL'] . $nomeImagem;
}
