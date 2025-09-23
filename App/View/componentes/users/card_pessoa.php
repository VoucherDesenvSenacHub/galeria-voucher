<?php
// Normaliza a variável esperada pelo card: aceita $pessoa ou $aluno
if (!isset($pessoa) && isset($aluno)) {
    $pessoa = $aluno;
}

// Evita caso nada tenha sido passado
if (!isset($pessoa) || !is_array($pessoa)) {
    $pessoa = [
        'nome' => 'Sem nome',
        'foto' => '',
        'linkedin' => '#',
        'github' => '#',
        'perfil' => ''
    ];
}

// Configura o caminho da foto
if (!empty($pessoa['foto'])) {
    if (filter_var($pessoa['foto'], FILTER_VALIDATE_URL)) {
        $caminhoFoto = $pessoa['foto'];
    } else {
        $caminhoFoto = VARIAVEIS['APP_URL'] . 'App/' . $pessoa['foto'];
    }
} else {
    $caminhoFoto = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png';
}
?>

<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo VARIAVEIS['APP_URL'] . htmlspecialchars($pessoa['foto'] ?? VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png'); ?>" alt="Foto de <?php echo htmlspecialchars($pessoa['nome']); ?>">
    </div>
    <div class="text-card">
        <h2><?php echo htmlspecialchars($pessoa['nome']); ?></h2>
        <?php if($pessoa['perfil'] == 'aluno'): ?>
            <p>Aluno</p>
        <?php elseif($pessoa['perfil'] == 'professor'): ?>
            <p>Professor</p>
        <?php endif; ?>
        <div class="social-icons">
            <a href="<?php echo htmlspecialchars($pessoa['linkedin'] ?? '#'); ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?php echo htmlspecialchars($pessoa['github'] ?? '#'); ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>
