<?php
require_once __DIR__ . "/../../componentes/head.php";
?>

<head>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="body-lista-alunos">

  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php require_once __DIR__ . "/../../componentes/adm/nav.php"; ?>

  <main class="main-lista-alunos">
    <div class="container-lista-alunos">
      <div class="topo-lista-alunos">
        <?php buttonComponent('primary', 'Novo Professor', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastrar-usuarios.php'); ?>

        <div class="input-pesquisa-container">
          <input type="text" id="pesquisa" placeholder="Pesquisar">
          <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa"
            class="icone-lupa-img">
        </div>
      </div>

      <div class="tabela-principal-lista-alunos">
        <div class="tabela-container-lista-alunos">
          <table id="tabela-alunos">
            <thead>
              <tr>
                <th>NOME</th>
                <th>POLO</th>
                <th>AÇÃO</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Array com dados fakes
              $usuarios = [
                  ['nome' => 'João Silva', 'polo' => 'São Paulo'],
                  ['nome' => 'Maria Santos', 'polo' => 'Rio de Janeiro'],
                  ['nome' => 'Pedro Oliveira', 'polo' => 'Belo Horizonte'],
                  ['nome' => 'Ana Costa', 'polo' => 'Salvador'],
                  ['nome' => 'Carlos Ferreira', 'polo' => 'Recife'],
                  ['nome' => 'Lucia Rodrigues', 'polo' => 'Fortaleza'],
                  ['nome' => 'Roberto Almeida', 'polo' => 'Brasília'],
                  ['nome' => 'Fernanda Lima', 'polo' => 'Curitiba'],
                  ['nome' => 'Marcos Pereira', 'polo' => 'Porto Alegre'],
                  ['nome' => 'Juliana Martins', 'polo' => 'Manaus']
              ];

              foreach ($usuarios as $usuario) {
                  echo '<tr>';
                  echo '<td>' . $usuario['nome'] . '</td>';
                  echo '<td>' . $usuario['polo'] . '</td>';
                  echo '<td class="acoes">';
                  echo '<span class="material-symbols-outlined acao-edit" style="cursor: pointer; margin-right: 10px;" title="Editar">edit</span>';
                  echo '<span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>';
                  echo '</td>';
                  echo '</tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <script src="../../assets/js/adm/lista-alunos.js"></script>

</body>

</html>