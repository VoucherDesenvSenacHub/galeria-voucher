<?php
require_once __DIR__ . "/../head.php";

// 1. Validação de segurança: se $pessoa não existir, não faz nada.
if (!isset($pessoa) || !is_array($pessoa)) {
    return;
}

// 2. Processamento dos dados com valores padrão para evitar erros.
$nome = htmlspecialchars($pessoa['nome'] ?? 'Nome não informado');
$funcao = htmlspecialchars($pessoa['funcao'] ?? 'Função não informada');
$linkedin = !empty($pessoa['linkedin']) ? htmlspecialchars($pessoa['linkedin']) : '#';
$github = !empty($pessoa['github']) ? htmlspecialchars($pessoa['github']) : '#';

// 3. Lógica da imagem (assumindo que VARIAVEIS já foi carregado pela página principal)
$foto = '';
$imagemOriginal = $pessoa['imagem'] ?? null;

if (!empty($imagemOriginal) && preg_match('/^https?:\/\//', $imagemOriginal )) {
    $foto = $imagemOriginal;
} else {
    $caminhoImagem = !empty($imagemOriginal) ? $imagemOriginal : 'utilitarios/icons8-github-50.png';
    // Garante que a URL base seja construída corretamente
    $baseUrl = rtrim(VARIAVEIS['APP_URL'] ?? '', '/') . '/' . trim(VARIAVEIS['DIR_IMG'] ?? 'assets/img/', '/');
    $foto = $baseUrl . '/' . ltrim($caminhoImagem, '/');
}

// 4. Caminho para os ícones
$caminhoIcones = (VARIAVEIS['DIR_IMG'] ?? 'assets/img/') . 'utilitarios/';

?>

<!-- 5. HTML do Card -->
<div class="card-container">
    <div class="image-dev">
        <img src="<?= $foto ?>" alt="Foto de <?= $nome ?>">
    </div>
    <div class="text-card">
        <h2><?= $nome ?></h2>
        <p><?= $funcao ?></p>
        <div class="social-icons">
            <a href="<?= htmlspecialchars($linkedin) ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?= '../../../../' . VARIAVEIS['DIR_IMG'] ?>utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?= htmlspecialchars($github) ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?= '../../../../' . VARIAVEIS['DIR_IMG'] ?>utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>
