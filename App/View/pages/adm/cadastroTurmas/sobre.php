<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

<body class="body-adm">
  <div class="container-adm">
    
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php require_once __DIR__ . "/../../../componentes/adm/nav.php"; ?>

    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas" href="cadastroTurmas.php">TURMA</a>
        <a class="tab-adm-turmas active" href="sobre.php">SOBRE</a>
        <a class="tab-adm-turmas" href="imagens.php">IMAGENS</a>
      </div>


            <div class="btn-novos-projeto">
              <button class="componente-botao btn-imagens">+ ADICIONAR PROJETOS</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
