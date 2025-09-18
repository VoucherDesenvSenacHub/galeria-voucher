<?php
if (!isset($orientador) && isset($dev)) {
    $orientador = $dev;
}


if (!isset($orientador) || !is_array($orientador)) {
    $orientador = [
        'nome' => 'Sem nome',
        'foto' => '',
        'linkedin' => '#',
        'github' => '#',
    ];
}


$perfil = $orientador['perfil'] ?? ($orientador['funcao'] ?? '');


if (!empty($orientador['foto'])) {

    $caminhoFoto = VARIAVEIS['APP_URL'] . 'App/' . $orientador['foto'];
} else {

    $caminhoFoto = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png';
}
?>


<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo htmlspecialchars($caminhoFoto); ?>" alt="Foto de <?php echo htmlspecialchars($orientador['nome']); ?>">
    </div>
    <div class="text-card">
        <h2><?php echo htmlspecialchars($orientador['nome']); ?></h2>
        <p><?php echo htmlspecialchars($perfil); ?></p>
        <div class="social-icons">
            <a href="<?php echo htmlspecialchars($orientador['linkedin'] ?? '#'); ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?php echo htmlspecialchars($orientador['github'] ?? '#'); ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>