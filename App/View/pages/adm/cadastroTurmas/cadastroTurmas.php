<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

  <body class="body-adm">
    <div class="container-adm">
       
        <?php require_once __DIR__ . "/./../../../componentes/adm/sidebar.php"; ?>
        <?php require_once __DIR__ . "/./../../../componentes/adm/nav.php"; ?>

        <main class="main-turmas-turmas">
            <div class="tabs-adm-turmas">
                <button class="tab-adm-turmas active">TURMA</button>
                <button class="tab-adm-turmas">SOBRE</button>
                <button class="tab-adm-turmas">IMAGENS</button>
            </div>

            <div class="container-main-adm">
                <div class="form-section">
                <h1>CADASTRO</h1>
                <input class="input-adm-turmas" type="text" placeholder="Nome:" />
                <input class="input-adm-turmas" type="text" placeholder="Ano da Turma:" />
                <input class="input-adm-turmas" type="text" placeholder="Polo:" />
                <input class="input-adm-turmas" type="text" placeholder="Docentes:" />
                <input class="input-adm-turmas" type="text" placeholder="Alunos:" />
                </div>

                <div class="profile-pic">
                <img src="" alt="Foto usuário" />
                </div>
            </div>
        </main> 
    </div> 
  </body>
</html>