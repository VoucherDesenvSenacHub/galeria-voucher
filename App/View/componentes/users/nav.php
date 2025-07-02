<header>
    <nav class="NavInicial">
        <div class="nav-inner">
            <img class="logo" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/nomeNav.png" width="150px" alt="Logo Voucher">

            <?php if (!isset($esconderPesquisa) || !$esconderPesquisa) { ?>
                <div class="search">
                    <input class="pesquisa" type="text" placeholder="Pesquisar">
                </div>
            <?php } ?>

            <!-- Ícone menu mobile -->
            <span class="material-symbols-outlined hamburger" id="hamburger">menu</span>

            <ul class="menu-links" id="nav-links">
                <li><a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a></li>
                <li><a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'turma.php'; ?>">TURMAS</a></li>
                <li><a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>"><span class="material-symbols-outlined">person</span></a></li>
            </ul>
        </div>
    </nav>
    <script src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_JS']; ?>users/nav.js" defer></script>
</header>