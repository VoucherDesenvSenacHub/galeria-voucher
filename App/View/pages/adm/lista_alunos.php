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
            <style>
                .aluno-container {
                    background: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    margin-top: 4vh;
                }

                .aluno-header {
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

                .btn-novo-aluno {
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

                .pesquisa-container {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px;
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

                .table-aluno{
                    max-height: 486.8px; /* Ajuste conforme a altura da tabela para rolar o scroll */
                    overflow-y: auto;
                    display: block;
                }

                .aluno-table {
                    width: 100%;
                    border-collapse: collapse;
                    background: #fff;
                    margin-top: 10px;
                    border: 1px solid #ccc;
                }

                .aluno-table thead th {
                    position: sticky; /* Ajuste para thead ficar fixo e não rolar com scroll */
                    top: 0;
                    background-color: #fff;
                    z-index: 2;
                    border: 1px solid #ccc;
                    padding: 8px;
                }

                .aluno-table tbody td {
                    border: 1px solid #ccc;
                    padding: 8px;
                }

                .aluno-table th, .aluno-table td {
                    text-align: center;
                    padding: 12px;
                    font-size: 15px;
                    border: 1px solid #ccc;
                }

                .aluno-table th {
                    background: #d9d9d9;
                    font-weight: bold;
                }

                .aluno-table tr:nth-child(even) {
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

            <div class="aluno-container">
                <div class="aluno-header">
                    <button class="tab">DOCENTE</button>
                    <button class="tab active">ALUNOS</button>
                </div>

                <div class="pesquisa-container">
                    <button class="btn-novo-aluno">NOVO ALUNO</button>
                    <input type="text" class="pesquisar" placeholder="Pesquisar">
                </div>

                <div class="table-aluno">
                    <table class="aluno-table">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>TIPO</th>
                                <th>EDITAR</th>
                                <th>INATIVAR</th>
                            </tr>
                        </thead>
                        <tbody>
            <tr><td>Anuar</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>pessoa</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Deutrano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Urano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Murano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>favor</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Tirano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Borano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Carano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Omano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Cariano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Lorano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Norano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Zorano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Jorano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Mariano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Verano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Ferano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Berano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Xarano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Yurano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Pelano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Delano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Kelano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Relano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Solano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Colano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Galano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Zelano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Talano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Malano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Valano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Falano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Ralano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Halano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Silano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Nolano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Filano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
            <tr><td>Milano</td><td>Aluno</td><td><i class="editar-icon"></i></td><td><i class="inativar-icon"></i></td></tr>
</tbody>


                    </table>
                </div>
            </div>

        </main>
    </div>

</div> 
</body>
</html>
