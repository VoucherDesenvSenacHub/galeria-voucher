<?php 
require_once __DIR__ . "/../../componentes/head.php";

?>

<body>
  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php require_once __DIR__ . "/../../componentes/adm/nav.php"; ?>

  <main>
    <div class="container-lista-docente">
        <div class="topo-lista-docente">
            <button id="btn-nvturma">NOVA TURMA</button>
            <input type="text" id="pesquisa" placeholder="Pesquisar">
        </div>

        <div class="tabela-principal">
            <div class="tabela-container">
                <table id="tabelaUsuarios">
                    <thead>
                    <tr>
                        <th>NOME</th>
                        <th>POLO</th>
                        <th>EDITAR</th>
                        <th>INATIVAR</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>tenma</td>
                        <td>Japão</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Arthur Morgan</td>
                        <td>EUA</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    <tr>
                        <td>Maestro Jr</td>
                        <td>Bostil</td>
                        <td><button onclick="editar()">Editar</button></td>
                        <td><button onclick="inativar()">Inativar</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
         <script>
            // Função para ajustar a altura mínima da tabela
            function adjustTableHeight() {
            const table = document.querySelector('.tabela-principal');
            const windowHeight = window.innerHeight; // altura da janela
            const newMinHeight = windowHeight * 0.5 + 200; // 50% da altura da janela + 200px

            // Atualizando a altura mínima da tabela
            table.style.minHeight = `${newMinHeight}px`;
            }

            // Chama a função ao carregar a página
            window.addEventListener('load', adjustTableHeight);

            // Chama a função sempre que a janela for redimensionada (incluindo zoom out)
            window.addEventListener('resize', adjustTableHeight);
         </script>
    </div>
  </main>

</body>
</html>
