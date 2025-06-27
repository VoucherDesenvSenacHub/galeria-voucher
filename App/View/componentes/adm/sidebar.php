<?php 
require_once __DIR__ . "\.\..\head.php"
?>

<aside class="sidebar-adm">
  <ul class="menu-adm">
    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastrar-usuarios.php'; ?>"> 
        USUARIOS
      </a>
    </li>

    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'lista-alunos.php'; ?>">
        TURMAS
      </a>
    </li>

    <li>
      <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . ''; ?>"> 
        ESTATÍSTICAS <i class="icon-lock"></i>
      </a>
    </li>
  </ul>
</aside>