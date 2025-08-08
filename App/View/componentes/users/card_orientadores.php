


<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo $orientador['foto']; ?>" alt="Foto de <?php echo $orientador['nome']; ?>">
    </div>
    <div class="text-card">
        <h2><?php echo $orientador['nome']; ?></h2>
        <p><?php echo $orientador['funcao']; ?></p>
        <div class="social-icons">
            <a href="<?php echo $orientador['linkedin']; ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?php echo $orientador['github']; ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>