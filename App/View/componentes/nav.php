<?php
/**
 * Componente de Navegação Unificado
 * 
 * Parâmetros disponíveis:
 * - $isAdmin (boolean): Se true, aplica estilos de admin e remove barra de pesquisa
 * - $esconderPesquisa (boolean): Se true, esconde a barra de pesquisa
 * - $useHeader (boolean): Se true, envolve o nav em uma tag header (padrão: true para users)
 */

// Sessão já iniciada no head.php

$isAdmin = isset($isAdmin) ? $isAdmin : false;
$useHeader = isset($useHeader) ? $useHeader : !$isAdmin;
$logado = isset($_SESSION['usuario']);
$perfil = $logado ? $_SESSION['usuario']['perfil'] : null;
?>
    <header class="nav-head">
    <nav class="NavInicial<?php echo $isAdmin ? ' nav-adm' : ''; ?>">
        <div class="nav-inner">
            <div class="imgvoucher">
                <a href="<?= Config::get('APP_URL') . Config::get('DIR_USER') . 'home.php'; ?>">
                    <img src="<?= Config::get('APP_URL') . Config::get('DIR_IMG') ?>adm/logo-navbar.png" alt="Logo Voucher">
                </a>
            </div>

            <?php if (!$isAdmin): ?>
                <div class="search" id="searchBar">
                    <?php if (!isset($esconderPesquisa) || !$esconderPesquisa) { ?>
                        <input class="pesquisa" type="text" placeholder="Pesquisar" id="pesquisar-pessoa" autocomplete="off">
                    <?php } ?>
                </div>
            <?php endif; ?>

            <span class="material-symbols-outlined hamburger" id="hamburger">menu</span>

            <ul class="menu-links" id="nav-links">
                <li class="<?php echo $isAdmin ? 'desktop-only' : ''; ?>">
                    <a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_USER') . 'home.php'; ?>">HOME</a>
                </li>
                <li class="<?php echo $isAdmin ? 'desktop-only' : ''; ?>">
                    <a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_USER') . 'turma.php'; ?>">TURMAS</a>
                </li>

                <?php if ($isAdmin): ?>
                    <li class="mobile-only"><a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'home-adm.php'; ?>">INÍCIO</a></li>
                    <li class="mobile-only"><a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'listarUsuarios.php'; ?>">PESSOAS</a></li>
                    <li class="mobile-only"><a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'listaTurmas.php'; ?>">TURMAS</a></li>
                    <?php if ($logado): ?>
                        <li class="mobile-only"><a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_LOGOUT') . 'logout.php'; ?>">SAIR</a></li>
                        <li class="desktop-only">
                            <a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_LOGOUT') . 'logout.php'; ?>" title="Sair">
                                <span class="material-symbols-outlined">logout</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($logado && in_array($perfil, ['adm', 'professor'])): ?>
                        <li><a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'home-adm.php'; ?>">ADMINISTRATIVO</a></li>
                        <li>
                            <a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_LOGOUT') . 'logout.php'; ?>" title="Sair">
                                <span class="material-symbols-outlined">logout</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="link-nav" href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'login.php'; ?>">
                                <span class="material-symbols-outlined">person</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
<script src="<?= Config::get('APP_URL') ?>app/View/assets/js/adm/autocomplete-pessoas.js" defer></script>
