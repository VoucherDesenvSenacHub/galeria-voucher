<?php
require_once __DIR__ . "/../head.php";

// Define $paginaAtiva como string vazia se não for definida na página que a incluiu
if (!isset($paginaAtiva)) {
    $paginaAtiva = '';
}
?>

<aside class="sidebar-adm">
  <ul class="menu-adm">
    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listarUsuarios.php'; ?>" class="<?= ($paginaAtiva == 'pessoas') ? 'active' : '' ?>">
        PESSOAS
      </a>
    </li>

    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php'; ?>" class="<?= ($paginaAtiva == 'turmas') ? 'active' : '' ?>">
        TURMAS
      </a>
    </li>
  </ul>
</aside>