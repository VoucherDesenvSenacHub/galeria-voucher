<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

<body class="body-adm">
<div class="container-adm">

    <?php require_once __DIR__ . "/./../../componentes/adm/sidebar.php"; ?>
    <?php require_once __DIR__ . "/./../../componentes/adm/nav.php"; ?>

    <main>
        <style>
            .docente-container {
                padding: 20px;
                background: #f5f5f5;
                height: calc(100vh - 80px);
            }

            .docente-header {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
            }

            .tab {
                background: #d3d3d3;
                border: 1px solid #000;
                padding: 10px 30px;
                font-weight: bold;
                font-size: 16px;
                cursor: pointer;
            }

            .tab.active {
                background: #c2ff7f;
                border-bottom: none;
                z-index: 2;
            }

            .btn-novo-docente {
                background: #c2ff7f;
                padding: 8px 20px;
                margin: 20px 0 10px 0;
                border: 2px solid black;
                font-weight: bold;
                cursor: pointer;
                border-radius: 15px;
                font-size: 16px;
                text-transform: uppercase;
            }

            .pesquisar {
                width: 200px;
                padding: 8px;
                margin-left: auto;
                margin-bottom: 10px;
                border-radius: 15px;
                border: 1px solid #ccc;
                display: block;
            }

            .docente-table {
                width: 100%;
                border-collapse: collapse;
                background: #fff;
                margin-top: 10px;
                border-radius: 10px;
                overflow: hidden;
            }

            .docente-table th {
                background: #d3d3d3;
                font-weight: bold;
                text-align: center;
                padding: 12px;
            }

            .docente-table td {
                border-top: 1px solid #ddd;
                padding: 12px;
                text-align: center;
                vertical-align: middle;
            }

            .docente-table tr:nth-child(even) {
                background-color: #f0f0f0;
            }

            .editar-icon, .inativar-icon {
                cursor: pointer;
                font-size: 18px;
            }

            .editar-icon::before {
                content: '✎';
            }

            .inativar-icon::before {
                content: '🗑️';
            }
        </style>

        <div class="docente-container">
            <div class="docente-header">
                <button class="tab active">DOCENTE</button>
                <button class="tab">ALUNOS</button>
            </div>

            <button class="btn-novo-docente">NOVO DOCENTE</button>

            <input type="text" class="pesquisar" placeholder="Pesquisar">

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
                    <tr>
                        <td>Anuar</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                    <tr>
                        <td>pessoa</td>
                        <td>Docente</td>
                        <td><i class="editar-icon"></i></td>
                        <td><i class="inativar-icon"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</div> 
</body>
</html>
