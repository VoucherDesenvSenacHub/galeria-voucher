<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/input.php";
require_once __DIR__ . "/../../../componentes/button.php";
require_once __DIR__ . "/../../../includes/verificarLogin.php";
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

      

      <div class="form-container-projeto">
      
      
            <h1 class="h1-sobre">DESCRIÇÃO DO PROJETO</h1>
            <div class="Container_Dia">
              <div class="nome-e-descricao">
                <input type="text" class="input-field" placeholder="Nome do Projeto:">
                <textarea class="textarea-field" placeholder="Descrição:"></textarea>
              </div>
                <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png"alt="Foto Turma" class="foto-projetoturma-novo" />
            </div>
                

            <h1 class="h1-sobre"> DIA I</h1>
            <div class="Container_Dia">
              <textarea class="textarea-field" placeholder="Descrição:"></textarea>
              <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma" class="foto-projetoturma-novo" />
            </div>

            <h1 class="h1-sobre"> DIA P</h1>
            <div class="Container_Dia">
              <textarea class="textarea-field" placeholder="Descrição:"></textarea>
              <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma" class="foto-projetoturma-novo" />
            </div>

            <h1 class="h1-sobre"> DIA D</h1>
            <div class="Container_Dia">
              <textarea class="textarea-field" placeholder="Descrição:"></textarea>
              <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma" class="foto-projetoturma-novo" /></div>

            <div class="link-projeto">
              <input type="text" class="input-projeto" placeholder="Link de Projeto:">
              <div class="btn-novos-projeto">
            </div>
            </div>
            <div class="button-projeto">
              <?php buttonComponent('secondary', 'Cancelar', false); ?>
              <?php buttonComponent('primary', 'Salvar', true); ?>
            </div>


            </div>

           
    </main>
  </div>
</body>
</html>