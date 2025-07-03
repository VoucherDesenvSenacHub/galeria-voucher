<?php 
require_once __DIR__ . "/../head.php";
?>

<aside class="sidebar-adm">
  <ul class="menu-adm">
    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listarUsuarios.php'; ?>"> 
        PESSOAS
      </a>
    </li>

    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php'; ?>">
        TURMAS
      </a>
    </li>
  </ul>
</aside>