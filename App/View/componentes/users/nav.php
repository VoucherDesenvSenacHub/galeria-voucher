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

            <li><a href="../../pages/users/home.php">HOME</a></li>

            <li><a href="../../pages/users/turma.php">TURMAS</a></li>

            <li> <a href="../../pages/adm/login.php">
                
            <span class="material-symbols-outlined">
                person
            </span>

                </a>
            </li>
        </ul>
    </nav>
</header>