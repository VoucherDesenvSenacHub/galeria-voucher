<?php
// salva a página atual
if (!isset($_SESSION['current_page'])) {
    $_SESSION['current_page'] = '';
}

$_SESSION['last_page'] = $_SESSION['current_page'];
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

?>

<footer class="footer container">
    <div class="row">
        <div class="col-100">
            <a href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] ?>perfil_desenvolvedores.php">&copy;2025 VOUCHER DESENVOLVEDOR 146</a>
        </div>
    </div>
</footer>
