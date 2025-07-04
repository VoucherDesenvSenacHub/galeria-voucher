<?php
/**
 * Componente de Navegação Unificado
 * 
 * Parâmetros disponíveis:
 * - $isAdmin (boolean): Se true, aplica estilos de admin e remove barra de pesquisa
 * - $esconderPesquisa (boolean): Se true, esconde a barra de pesquisa
 * - $useHeader (boolean): Se true, envolve o nav em uma tag header (padrão: true para users)
 */

// Define valores padrão se não foram passados
$isAdmin = isset($isAdmin) ? $isAdmin : false;
$useHeader = isset($useHeader) ? $useHeader : !$isAdmin; // true para users, false para admin
?>

<?php if ($useHeader): ?>
<header>
<?php endif; ?>

<nav class="NavInicial<?php echo $isAdmin ? ' nav-adm' : ''; ?>">
    <div class="nav-inner">
        <div class="imgvoucher">
            <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">
                <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/logo-navbar.png" alt="Logo Voucher">
            </a>
        </div>

        <?php if (!$isAdmin): ?>
        <div class="search" id="searchBar">
            <?php if (!isset($esconderPesquisa) || !$esconderPesquisa) { ?>
                <input class="pesquisa" type="text" placeholder="Pesquisar" id="searchInput">
            <?php } ?>
        </div>
        <?php endif; ?>

        <!-- Ícone menu mobile -->
        <span class="material-symbols-outlined hamburger" id="hamburger">menu</span>
        
        <ul class="menu-links" id="nav-links">
            <li>
                <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a>
            </li>
            <li>
                <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'turma.php'; ?>">TURMAS</a>
            </li>
            <li>
                <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>">
                    <span class="material-symbols-outlined">person</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<?php if ($useHeader): ?>
</header>
<?php endif; ?>