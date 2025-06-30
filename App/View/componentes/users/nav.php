<header>
    <nav class = "NavInicial">

        <img class="imgnav" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/nomeNav.png" width="150px">

        <div class="search">

            <div class="search">

                <?php if (!isset($esconderPesquisa) || 
                !$esconderPesquisa) { ?>
                    <input class="pesquisa" type="text" placeholder="Pesquisar">
                    <?php } ?>
            </div>

        </div>

        <ul>

            <li><a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a></li>

            <li><a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'turma.php'; ?>" >TURMAS</a></li>

            <li> <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>">
                
            <span class="material-symbols-outlined">
                person
            </span>

                </a>
            </li>
        </ul>
    </nav>
</header>