<?php
namespace App\Helpers;

/**
 * Gera a URL completa de uma imagem, aplicando regras de fallback e subpasta.
 * 
 * @param string|null $nomeImagem Nome do arquivo da imagem ou URL completa.
 * @param string $subpastaDefault Subpasta padrão para imagens locais.
 * @param string $fallback Caminho da imagem padrão caso $nomeImagem não seja informado.
 * @return string URL completa da imagem para exibição.
 */
function urlImagem(?string $nomeImagem, string $subpastaDefault = 'turmas/', string $fallback = 'utilitarios/placeholder-user.png'): string {
    
    // 1. Se o nome informado já for uma URL absoluta (http ou https), retorna como está
    if (!empty($nomeImagem) && (str_starts_with($nomeImagem, 'http://') || str_starts_with($nomeImagem, 'https://'))) {
        return $nomeImagem;
    }

    // 2. Se não houver nome de imagem, usa a imagem de fallback padrão
    if (empty($nomeImagem)) {
        $nomeImagem = $fallback;
    }

    // 3. Verifica se o nome da imagem já contém uma subpasta válida
    //    - Se já tiver "/", considera que o caminho já está completo e não adiciona a subpastaDefault
    //    - Se não tiver, aplica a subpasta padrão
    $subpasta = (str_contains($nomeImagem, '/') && !str_contains($nomeImagem, ' ')) ? '' : $subpastaDefault;

    // 4. Monta a URL base usando as variáveis globais definidas no sistema (APP_URL e DIR_IMG)
    $base = rtrim(\VARIAVEIS['APP_URL'], '/') . '/' . trim(\VARIAVEIS['DIR_IMG'], '/') . '/';

    // 5. Retorna a URL completa (base + subpasta + nome da imagem)
    return $base . $subpasta . $nomeImagem;
}
