<?php 
    require_once __DIR__ . "/../head.php";
?>

<div class="card-container">
    <div class="image-dev">
        <img src="<?php echo $dev['foto']; ?>" alt="Foto de <?php echo $dev['nome']; ?>">
    </div>
    <div class="text-card">
        <h2><?php echo $dev['nome']; ?></h2>
        <p><?php echo $dev['funcao']; ?></p>
        <div class="social-icons">
            <a href="<?php echo $dev['linkedin']; ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?php echo $dev['github']; ?>" target="_blank">
                <img src="../../assets/img/utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>