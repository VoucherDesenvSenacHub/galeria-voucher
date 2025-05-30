<?php 
require_once __DIR__ . "/../../componentes/head.php";
?>

<head>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

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
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Arthur Morgan</td>
              <td>EUA</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            <tr>
              <td>Maestro Jr</td>
              <td>Bostil</td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">edit</span></td>
              <td><span class="material-symbols-outlined" style="cursor: pointer;">delete</span></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <script src="../../assets/js/adm/lista-docentes.js"></script>

</body>
</html>
