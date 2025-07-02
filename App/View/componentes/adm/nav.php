<?php 
require_once __DIR__ . "/../head.php";
?>

<header class="header-adm"> 
    <nav class="nav-adm">
        <div class="imgvoucher">
            <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/logo-navbar.png">
        </div>
        <ul>
            <li>
                <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a>
            </li>
            <li>
                <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'turma.php'; ?>">TURMAS</a>
            </li>
            <li>
                <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>" class="botao-person">
                    <span class="material-symbols-outlined">person</span>
                </a>
            </li>
        </ul>
    </nav>
</header>