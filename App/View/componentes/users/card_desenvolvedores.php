<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo $aluno['foto']; ?>" alt="Foto de <?php echo $aluno['nome']; ?>">
    </div>
    <div class="text-card">
        <h2><?php echo $aluno['nome']; ?></h2>
        <p><?php echo $aluno['perfil']; ?></p>
        <div class="social-icons">
            <a href="<?php echo $aluno['linkedin']; ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?php echo $aluno['github']; ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>