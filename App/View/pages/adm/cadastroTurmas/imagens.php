<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/input.php";
require_once __DIR__ . "/../../../componentes/button.php";
?>

<body class="body-cadastro-turmas">
  <div class="container-adm">
    
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php 
        $isAdmin = true; // Para páginas de admin
        require_once __DIR__ . "/../../../componentes/nav.php"; 
    ?>

    <?php
      $imagens = [
          ["titulo" => "IMAGEM DA TURMA", "quantidade" => 6],
          ["titulo" => "IMAGEM DO DIA I", "quantidade" => 6],
          ["titulo" => "IMAGEM DO DIA P", "quantidade" => 6],
          ["titulo" => "IMAGEM DO DIA E", "quantidade" => 6],
      ];
    ?>
    
    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas active" href="sobre.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
      </div>

      <h1 class="h1-sobre">NOVO PROJETO</h1>

      <div class="form-container-sobre">
        <div class="input-grupos">
          <div class="input-group-sobre">
            <input type="text" class="input-field" placeholder="Nome do Projeto:">
            <textarea class="textarea-field" placeholder="Descrição:"></textarea>
            <h2> DIA I</h2>
            <textarea class="textarea-field" placeholder="Descrição:"></textarea>
            <h2> DIA P</h2>
            <textarea class="textarea-field" placeholder="Descrição:"></textarea>
            <h2> DIA D</h2>
            <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          </div>

          <div class="projeto-pic">
          <img src="" alt="Foto Turma" />
        </div>
          <div class="projeto-pic">
          <img src="" alt="Foto Turma" />
        </div>
          <div class="projeto-pic">
          <img src="" alt="Foto Turma" />
        </div>
            <div>
              <?php buttonComponent('secondary', 'Cancelar', false); ?></div>
            <div><?php buttonComponent('primary', 'Salvar', true); ?></div>

       

          <div class="link-projeto">
            <input type="text" class="input-projeto" placeholder="Link de Projeto:">
            <div class="btn-novos-projeto">

          
              
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>