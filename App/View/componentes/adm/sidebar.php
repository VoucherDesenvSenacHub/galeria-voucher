<?php
require_once __DIR__ . "/../head.php";

if (!isset($paginaAtiva)) {
    $paginaAtiva = '';
}
?>

<aside class="sidebar-adm">
  <ul class="menu-adm">
    <li>
      <a href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'listarUsuarios.php'; ?>" class="<?= ($paginaAtiva == 'pessoas') ? 'active' : '' ?>">
        PESSOAS
      </a>
    </li>
    <li>
      <a href="<?= Config::get('APP_URL') . Config::get('DIR_ADM') . 'listaTurmas.php'; ?>" class="<?= ($paginaAtiva == 'turmas') ? 'active' : '' ?>">
        TURMAS
      </a>
    </li>
  </ul>
</aside>