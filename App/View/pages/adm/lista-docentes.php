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
            <input type="text" id="pesquisa" placeholder="Pesquisa" onkeyup="filtrarTabela()">
        </div>

        <div class="tabela-principal">
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
            </tbody>
        </div>

        <script>
            function editar() {
            alert("Editar usuário");
            }

            function inativar() {
            alert("Usuário inativado");
            }

            function filtrarTabela() {
            const input = document.getElementById("pesquisa");
            const filtro = input.value.toLowerCase();
            const tabela = document.getElementById("tabelaUsuarios");
            const linhas = tabela.getElementsByTagName("tr");

            for (let i = 1; i < linhas.length; i++) {
                const colNome = linhas[i].getElementsByTagName("td")[0];
                const colPolo = linhas[i].getElementsByTagName("td")[1];
                if (colNome && colPolo) {
                const nome = colNome.textContent.toLowerCase();
                const polo = colPolo.textContent.toLowerCase();
                if (nome.includes(filtro) || polo.includes(filtro)) {
                    linhas[i].style.display = "";
                } else {
                    linhas[i].style.display = "none";
                }
                }
            }
            }
        </script>

    </div>
  </main>

 
  <script src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_JS'] . 'alunos/cadastrar_usuarios.js'; ?>"></script>
</body>
</html>
