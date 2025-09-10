<?php
// Normaliza a variável esperada pelo card: aceita $aluno ou $dev
if (!isset($aluno) && isset($dev)) {
    $aluno = $dev;
}

// Evita notice caso nada tenha sido passado
if (!isset($aluno) || !is_array($aluno)) {
    $aluno = [
        'nome' => 'Sem nome',
        'foto' => '',
        'linkedin' => '#',
        'github' => '#',
    ];
}

// Fallback: alguns chamam de 'funcao' ao invés de 'perfil'
// $perfil = $pessoa['perfil'] ?? 'professor';

?>

<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo htmlspecialchars($pessoa['foto'] ?? VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png'); ?>" alt="Foto de <?php echo htmlspecialchars($pessoa['nome']); ?>">
    </div>
    <div class="text-card">
        <h2><?php echo htmlspecialchars($pessoa['nome']); ?></h2>
        <?php if($pessoa['perfil'] == 'aluno'): ?>
            <p>Aluno</p>
        <?php elseif($pessoa['perfil'] == 'professor'): ?>
            <p>Professor</p>
        <?php endif; ?>
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