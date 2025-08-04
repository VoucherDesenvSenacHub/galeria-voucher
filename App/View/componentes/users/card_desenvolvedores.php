<?php 
    require_once __DIR__ . "/../head.php";

    

    // Garante que $aluno está definido (renomeia para $dev para compatibilidade com o restante do código)
    if (!isset($aluno) || !is_array($aluno)) {
        return;
    }

    $dev = $aluno;

    $foto = '';

    // Se vier uma URL completa (começa com http), use direto
    if (!empty($dev['imagem']) && preg_match('/^https?:\/\//', $dev['imagem'])) {
        $foto = $dev['imagem'];
    }
    // Se vier um caminho relativo (ex: "alunos/foto.jpg"), adiciona DIR_IMG
    elseif (!empty($dev['imagem'])) {
        $foto = VARIAVEIS['DIR_IMG'] . ltrim($dev['imagem'], '/');
    }
    // Se não tiver nada, usa o placeholder
    else {
        $foto = VARIAVEIS['DIR_IMG'] . 'utilitarios/placeholder-user.png';
    }

    $nome = htmlspecialchars($dev['nome'] ?? 'Nome não informado');
    $funcao = htmlspecialchars($dev['funcao'] ?? 'Função não informada');
    $linkedin = !empty($dev['linkedin']) ? $dev['linkedin'] : '#';
    $github = !empty($dev['github']) ? $dev['github'] : '#';
?>

<div class="card-container">
    <div class="image-dev">
        <img src="<?= $foto ?>" alt="Foto de <?= $nome ?>">
    </div>
    <div class="text-card">
        <h2><?= $nome ?></h2>
        <p><?= $funcao ?></p>
        <div class="social-icons">
            <a href="<?= $linkedin ?>" target="_blank">
                <img src="<?= VARIAVEIS['DIR_IMG'] ?>utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?= $github ?>" target="_blank">
                <img src="<?= VARIAVEIS['DIR_IMG'] ?>utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>
