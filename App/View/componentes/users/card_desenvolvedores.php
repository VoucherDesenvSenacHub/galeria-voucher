<?php

if (!isset($aluno) && isset($dev)) {
    $aluno = $dev;
}


if (!isset($aluno) || !is_array($aluno)) {
    $aluno = [
        'nome' => 'Sem nome',
        'foto' => '',
        'linkedin' => '#',
        'github' => '#',
    ];
}


$perfil = $aluno['perfil'] ?? ($aluno['funcao'] ?? '');


if (!empty($aluno['foto'])) {

    $caminhoFoto = VARIAVEIS['APP_URL'] . 'App/' . $aluno['foto'];
} else {

    $caminhoFoto = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png';
}
?>

<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo htmlspecialchars($caminhoFoto); ?>" alt="Foto de <?php echo htmlspecialchars($aluno['nome']); ?>">
    </div>
    <div class="text-card">
        <h2><?php echo htmlspecialchars($aluno['nome']); ?></h2>
        <p><?php echo htmlspecialchars($perfil); ?></p>
        <div class="social-icons">
            <a href="<?php echo htmlspecialchars($aluno['linkedin'] ?? '#'); ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?php echo htmlspecialchars($aluno['github'] ?? '#'); ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>
