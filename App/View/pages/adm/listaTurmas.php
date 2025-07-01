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
        <?php buttonComponent('primary', 'NOVA TURMA', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php'); ?>
        
        <div class="input-pesquisa-container">
          <input type="text" id="pesquisa" placeholder="Pesquisar">
          <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
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
              // Array com dados fakes de turmas
              $turmas = [
                  ['nome' => 'Turma A - Desenvolvimento Web', 'polo' => 'São Paulo'],
                  ['nome' => 'Turma B - Programação Mobile', 'polo' => 'Rio de Janeiro'],
                  ['nome' => 'Turma C - Data Science', 'polo' => 'Belo Horizonte'],
                  ['nome' => 'Turma D - UX/UI Design', 'polo' => 'Salvador'],
                  ['nome' => 'Turma E - DevOps', 'polo' => 'Recife'],
                  ['nome' => 'Turma F - Inteligência Artificial', 'polo' => 'Fortaleza'],
                  ['nome' => 'Turma G - Cybersecurity', 'polo' => 'Brasília'],
                  ['nome' => 'Turma H - Cloud Computing', 'polo' => 'Curitiba'],
                  ['nome' => 'Turma I - Blockchain', 'polo' => 'Porto Alegre'],
                  ['nome' => 'Turma J - IoT', 'polo' => 'Manaus']
              ];

              foreach ($turmas as $turma) {
                  echo '<tr>';
                  echo '<td>' . $turma['nome'] . '</td>';
                  echo '<td>' . $turma['polo'] . '</td>';
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
