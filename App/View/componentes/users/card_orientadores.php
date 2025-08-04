<?php 
require_once __DIR__ . "/../head.php";

// Garante que $orientador está definido e é array
if (!isset($orientador) || !is_array($orientador)) {
    return;
}

// Usa a função `urlImagem` se estiver disponível (ou aplica lógica inline)
$fotoBruto = $orientador['imagem'] ?? null;

if (!empty($fotoBruto) && (str_starts_with($fotoBruto, 'http://') || str_starts_with($fotoBruto, 'https://'))) {
    $foto = $fotoBruto;
} else {
    $subpasta = (str_contains($fotoBruto, 'pessoas/')) ? '' : 'turmas/';
    $imagem = !empty($fotoBruto) ? $fotoBruto : 'utilitarios/placeholder-user.png';
    $base = rtrim(VARIAVEIS['APP_URL'], '/') . '/' . trim(VARIAVEIS['DIR_IMG'], '/') . '/';
    $foto = $base . $subpasta . $imagem;
}

$nome = htmlspecialchars($orientador['nome'] ?? 'Nome não informado');
$funcao = htmlspecialchars($orientador['funcao'] ?? 'Função não informada');
$linkedin = !empty($orientador['linkedin']) ? $orientador['linkedin'] : '#';
$github = !empty($orientador['github']) ? $orientador['github'] : '#';
?>


<div class="card-container">
    <div class="image-dev">
        <img src="<?= $foto ?>" alt="Foto de <?= $nome ?>">
    </div>
    <div class="text-card">
        <h2><?= $nome ?></h2>
        <p><?= $funcao ?></p>
        <div class="social-icons">
            <a href="<?= htmlspecialchars($linkedin) ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?= VARIAVEIS['DIR_IMG'] ?>utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?= htmlspecialchars($github) ?>" target="_blank" rel="noopener noreferrer">
                <img src="<?= VARIAVEIS['DIR_IMG'] ?>utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>
