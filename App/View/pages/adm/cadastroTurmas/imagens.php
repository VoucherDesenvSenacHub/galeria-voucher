<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

  <body class="body-adm">
    <div class="container-adm">
       
        <?php require_once __DIR__ . "/./../../../componentes/adm/sidebar.php"; ?>
        <?php require_once __DIR__ . "/./../../../componentes/adm/nav.php"; ?>

        <?php
    $imagens = [
        ["titulo" => "IMAGEM DA TURMA", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA I", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA P", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA E", "quantidade" => 6],
    ];
    ?>

    <main class="main-turmas-turmas">
        <div class="tabs">
            <button class="tab ">TURMA</button>
            <button class="tab ">SOBRE</button>
            <button class="tab active ">IMAGENS</button>
        </div>

        <div class="container-imagens">
            <?php foreach ($imagens as $imagem): ?>
                <div class="section-imagens">
                    <h2><?= $imagem['titulo'] ?> <span><?= $imagem['quantidade'] ?>/<?= $imagem['quantidade'] ?></span></h2>
                    <div class="images-row-imagens">
                        <?php for ($i = 0; $i < $imagem['quantidade']; $i++): ?>
                            <img class="img-imagens" src="placeholder.png" alt="Imagem" class="image-placeholder">
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="buttons-imagens">
                <button class="cancel-imagens">CANCELAR</button>
                <button class="submit-imagens">CADASTRAR</button>
            </div>
        </div>
    </main>
 

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-turmas-turmas {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .tabs {
            display: flex;
            gap: 10px;
            padding: 20px;
        }

        .tab {
            display: flex;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border: 1px solid #000;
            border-radius: 25px;
            /* background-color: white; */
            cursor: pointer;
            text-align: center;
        }

        .tab.active {
            justify-content: center; 
            align-items: center;     
            background-color: #a8ff00;
        }
 
        .container-imagens {
            width: 150vh;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 40px;
            max-height: calc(90vh - 100px);
            overflow-y: auto;
            scroll-behavior: smooth;
            background-color: transparent;
            scroll-snap-type: y mandatory;
        }

        .container-imagens > * {
            scroll-snap-align: start;
        }
        .container-imagens::-webkit-scrollbar {
            width: 8px;
        }

        .container-imagens::-webkit-scrollbar-thumb {
            background-color: rgba(150, 150, 150, 0.4); 
            border-radius: 4px;
        }

        .container-imagens::-webkit-scrollbar-track {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .section-imagens {
            display: flex;
            flex-direction: column;
        }

        .section-imagens h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .section-imagens h2 span {
            font-size: 20px;
            margin-left: 8px;
        }

        .images-row-imagens {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
        }

        .img-imagens {
            width: 100%;
            height: 100px;
            object-fit: contain;
            border: 1px solid #000;
            border-radius: 10px;
            padding: 10px;
        }

        .buttons-imagens {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 40px;
            padding-bottom: 20px;
        }

        .cancel-imagens,
        .submit-imagens {
            display: flex;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 25px;
            border: 1px solid #000;
            cursor: pointer;
            align-items: center;
        }

        .cancel-imagens {
            background-color: white;
            color: darkgreen;
        }

        .submit-imagens {
            background-color: #a8ff00;
            color: black;
        }

    </style>
  </body>
</html>


