<nav class="NavInicial nav-adm">
    <div class="imgvoucher">
        <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">
            <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/logo-navbar.png" alt="Logo Voucher">
        </a>
    </div>
    
    <ul>
        <li>
            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a>
        </li>
        <li>
            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'turma.php'; ?>">TURMAS</a>
        </li>
        <li>
            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>" class="botao-person">
                <span class="material-symbols-outlined">person</span>
            </a>
        </li>
    </ul>
</nav>
