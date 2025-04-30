<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

  <body class="body-adm">
    <div class="container-adm">
       
        <?php require_once __DIR__ . "/./../../../componentes/adm/sidebar.php"; ?>
        <?php require_once __DIR__ . "/./../../../componentes/adm/nav.php"; ?>

        <main class="main-turmas-turmas">
            <div class="tabs">
                <button class="tab">TURMA</button>
                <button class="tab active">SOBRE</button>
                <button class="tab">IMAGENS</button>
            </div>

            <h1 class="h1-sobre">CADASTRO</h1>
            <div class="form-container-sobre">
                <div class="input-group-sobre">
                <input type="text" class="input-field" placeholder="Nome:">
                <textarea class="textarea-field" placeholder="Sobre:"></textarea>
                <input type="text" class="input-field" placeholder="Dia P">
                <textarea class="textarea-field" placeholder="Sobre:"></textarea>
                <input type="text" class="input-field" placeholder="Projeto XX">
                <textarea class="textarea-field" placeholder="Sobre:"></textarea>
                </div>

                <div class="input-group-sobre-big">
                <input type="text" class="input-field" placeholder="Dia I">
                <textarea class="textarea-field" placeholder="Sobre:"></textarea>
                <input type="text" class="input-field" placeholder="Dia E">
                <textarea class="textarea-field" placeholder="Sobre:"></textarea>
                </div>
            </div>
            <div class="link-projeto">
            <input type="text" class="input-projeto" placeholder="Link de Projeto:">
            <button class="btn-novos-projeto">NOVOS PROJETOS</button>
            </div>
        </main> 
    </div> 
  </body>
</html>