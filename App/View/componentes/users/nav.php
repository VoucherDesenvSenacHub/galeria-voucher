<header>
    <nav class="NavInicial">
        <div class="imgvoucher">
            <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">
                <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/logo-navbar.png" alt="Logo Voucher">
            </a>
        </div>
        
        <div class="search" id="searchBar">
            <?php if (!isset($esconderPesquisa) || !$esconderPesquisa) { ?>
                <input class="pesquisa" type="text" placeholder="Pesquisar" id="searchInput">
            <?php } ?>
        </div>

        <ul>
            <li><a class="link-nav" href="../../pages/users/home.php">HOME</a></li>
            <li><a class="link-nav" href="../../pages/users/turma.php">TURMAS</a></li>
            <li>
                <a class="link-nav" href="../../pages/adm/login.php">
                    <span class="material-symbols-outlined">person</span>
                </a>
            </li>
        </ul>
    </nav>
</header>