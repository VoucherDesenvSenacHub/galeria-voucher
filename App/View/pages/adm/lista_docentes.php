<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

<body class="body-adm">
<div class="container-adm" style="display: flex; min-height: 100vh;">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>

    <div style="flex-grow: 1; background: #f5f5f5; display: flex; flex-direction: column;">
        
        <?php require_once __DIR__ . "/../../componentes/adm/nav.php"; ?>

        <main style="padding: 20px; width: 100%;">  
            <div class="docente-container">
                
                <div class="docente-header">
                    <button class="tab active">DOCENTE</button>
                    <button class="tab">ALUNOS</button>
                </div>

                <div class="pesquisa-container">
                    <button class="btn-novo-docente">NOVO DOCENTE</button>
                    <input type="text" class="pesquisar" placeholder="Pesquisar">
                </div>

                <div class="table-docente">
                    <table class="docente-table">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>TIPO</th>
                                <th>EDITAR</th>
                                <th>EXCLUIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $docentes = [
                                "Anuar", "pessoa", "Deutrano", "Urano", "Murano", "favor", "Tirano", "Borano",
                                "Carano", "Omano", "Cariano", "Lorano", "Norano", "Zorano", "Jorano", "Mariano",
                                "Verano", "Ferano", "Berano", "Xarano", "Yurano", "Pelano", "Delano", "Kelano",
                                "Relano", "Solano", "Colano", "Galano", "Zelano", "Talano", "Malano", "Valano",
                                "Falano", "Ralano", "Halano", "Silano", "Nolano", "Filano", "Milano"
                            ];

                            foreach ($docentes as $nome) {
                                echo "<tr>
                                        <td>{$nome}</td>
                                        <td>Docente</td>
                                        <td><i class='editar-icon'></i></td>
                                        <td><i class='inativar-icon'></i></td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>

</div> 
</body>
</html>
