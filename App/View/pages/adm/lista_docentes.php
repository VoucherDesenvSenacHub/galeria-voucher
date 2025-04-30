<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

<body class="body-adm">
<div class="container-adm" style="display: flex; min-height: 100vh;">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>

    <div style="flex-grow: 1; background: #f5f5f5; display: flex; flex-direction: column;">
        <?php require_once __DIR__ . "/../../componentes/adm/nav.php"; ?>

        <main style="padding: 20px; max-width: 1000px; margin: 0 auto; width: 100%;">
            <style>
                .docente-container {
                    background: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    margin-top: 4vh;
                }

                .docente-header {
                    display: flex;
                    align-items: center;
                    margin-bottom: 20px;
                }

                .tab {
                    padding: 15px 30px;
                    font-weight: bold;
                    font-size: 2rem;
                    border: 2px solid;
                    cursor: pointer;
                    background-color: #ccc;
                    transition: 0.3s;
                    height: 4rem;
                    width: 20rem;
                    border-radius: 5px;
                }

                .tab.active {
                    background-color: #c3ff3e;
                    border-radius: 5px;
                }

                .btn-novo-docente {
                    background: #c2ff7f;
                    padding-top: 3px;
                    margin: 10px 0;
                    border: 2px solid black;
                    font-weight: bold;
                    cursor: pointer;
                    border-radius: 30px;
                    font-size: 16px;
                    text-transform: uppercase;
                }


                .pesquisar {
                    width: 250px;
                    padding: 10px;
                    margin: 10px 0 20px 0;
                    border-radius: 30px;
                    border: 1px solid #ccc;
                    background: #e9efe9;
                    outline: none;
                    font-size: 14px;
                    display: flex; 
                    justify-content: flex-start;
                }

                .docente-table {
                    width: 100%;
                    border-collapse: collapse;
                    background: #fff;
                    margin-top: 10px;
                    border: 1px solid #ccc;
                }

                .docente-table th, .docente-table td {
                    text-align: center;
                    padding: 12px;
                    font-size: 15px;
                    border: 1px solid #ccc;
                }

                .docente-table th {
                    background: #d9d9d9;
                    font-weight: bold;
                }

                .docente-table tr:nth-child(even) {
                    background-color: #e9e9e9;
                }

                .editar-icon::before {
                    content: '✏️'; 
                    cursor: pointer;
                    font-size: 18px;
                }

                .inativar-icon::before {
                    content: '🗑️'; 
                    cursor: pointer;
                    font-size: 18px;
                }
                
            </style>

            <div class="docente-container">
                <div class="docente-header">
                    <button class="tab active">DOCENTE</button>
                    <button class="tab">ALUNOS</button>
                </div>

                <div class="">
                    <button class="btn-novo-docente">NOVO DOCENTE</button>
                    <input type="text" class="pesquisar" placeholder="Pesquisar">
                </div>

                <table class="docente-table">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>TIPO</th>
                            <th>EDITAR</th>
                            <th>INATIVAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Anuar</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>pessoa</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Deutrano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Urano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Murano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Surano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Tirano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Borano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Carano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Omano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                        <tr><td>Cariano</td><td>Docente</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</div> 
</body>
</html>
