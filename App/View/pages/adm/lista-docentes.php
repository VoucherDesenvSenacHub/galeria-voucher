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
        
        <div class="input-pesquisa-container">
          <input type="text" id="pesquisa" placeholder="Pesquisar">
          <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
        </div>
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
                    <td>Tenma</td>
                    <td>Japão</td>
                    <td><button>Editar</button></td>
                    <td><button>Inativar</button></td>
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
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script>
    function adjustTableHeight() {
      const table = document.querySelector('.tabela-principal');
      const windowHeight = window.innerHeight;
      const newMinHeight = windowHeight * 0.5 + 200;
      table.style.minHeight = `${newMinHeight}px`;
    }

    window.addEventListener('load', adjustTableHeight);
    window.addEventListener('resize', adjustTableHeight);
  </script>

</body>
</html>
