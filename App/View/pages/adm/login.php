<?php 
   require_once(__DIR__ . '/../../componentes/head.php');
headerComponent("Voucher Desenvolvedor - Login");

?>

<body class="body-login">

    <?php 
        $esconderPesquisa = true;
        $isAdmin = false; // Para login, usamos o estilo de users mas escondemos a pesquisa
        require_once(__DIR__ . '/../../componentes/nav.php');
    ?>
    <?php
    require_once __DIR__ . '/../../componentes/users/mira.php';
    ?>

    <main class="main-login">
        <form class="form" action="">

            <div class="form-header" action="">
                <h1>Login</h1>

            </div>

            <div class="form-content">

                <div class="form-input required">

                    <input type="email" placeholder="Email" required>
                    <input type="password" placeholder="Senha" required>

                </div>

                <div class="form-action">

                    <?php buttonComponent('primary', 'Login', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'home-adm.php'); ?>

                </div>
            </div>

        </form>

    </main>

    <?php
    require_once __DIR__ . '/../../componentes/users/footer.php';
    ?>

</body>

        </html>