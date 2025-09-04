<?php
/**
 * Componente de Navegação Unificado
 * 
 * Parâmetros disponíveis:
 * - $isAdmin (boolean): Se true, aplica estilos de admin e remove barra de pesquisa
 * - $esconderPesquisa (boolean): Se true, esconde a barra de pesquisa
 * - $useHeader (boolean): Se true, envolve o nav em uma tag header (padrão: true para users)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($isAdmin) ? $isAdmin : false;
$useHeader = isset($useHeader) ? $useHeader : !$isAdmin;
$logado = isset($_SESSION['usuario']);
$perfil = $logado ? $_SESSION['usuario']['perfil'] : null;
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
                        <input class="pesquisa" type="text" placeholder="Pesquisar" id="pesquisar-pessoa">
                        <div id="sugestoes"></div>
                        <div id="pessoas-selecionadas"></div>
                    <?php } ?>
                </div>
            <?php endif; ?>

            <span class="material-symbols-outlined hamburger" id="hamburger">menu</span>

            <ul class="menu-links" id="nav-links">
                <!-- HOME e TURMAS (admin ou comum) -->
                <li class="<?php echo $isAdmin ? 'desktop-only' : ''; ?>">
                    <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a>
                </li>
                <li class="<?php echo $isAdmin ? 'desktop-only' : ''; ?>">
                    <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'turma.php'; ?>">TURMAS</a>
                </li>

                <?php if ($isAdmin): ?>
                    <!-- ADMIN - MOBILE LINKS -->
                    <li class="mobile-only">
                        <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php'; ?>">HOME</a>
                    </li>
                    <li class="mobile-only">
                        <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listarUsuarios.php'; ?>">PESSOAS</a>
                    </li>
                    <li class="mobile-only">
                        <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php'; ?>">TURMAS</a>
                    </li>

                    <?php if (!$logado): ?>
                        <li class="desktop-only">
                            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>">
                                <span class="material-symbols-outlined">person</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($logado && in_array($perfil, ['adm', 'professor'])): ?>
                        <!-- Sair visível apenas uma vez -->
                        <li class="desktop-only">
                            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_LOGOUT'] . 'logout.php'; ?>" title="Sair">
                                <span class="material-symbols-outlined">logout</span>
                            </a>
                        </li>
                        <li class="mobile-only">
                            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_LOGOUT'] . 'logout.php'; ?>" title="Sair"><span class="material-symbols-outlined">logout</span></a>
                        </li>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- USUÁRIO COMUM -->
                    <?php if ($logado && in_array($perfil, ['adm', 'professor'])): ?>
                        <li>
                            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'home-adm.php'; ?>">ADMINISTRATIVO</a>
                        </li>
                        <li>
                            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_LOGOUT'] . 'logout.php'; ?>" title="Sair">
                                <span class="material-symbols-outlined">logout</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="link-nav" href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php'; ?>">
                                <span class="material-symbols-outlined">person</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php if ($useHeader): ?>
    </header>
<?php endif; ?>
<script src="/galeria-voucher/app/View/assets/js/adm/autocomplete-nav.js" defer></script>