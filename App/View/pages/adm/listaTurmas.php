<?php 
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php";
?>

<head>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="body-lista-alunos">

  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php 
      $isAdmin = true; // Para páginas de admin
      require_once __DIR__ . "/../../componentes/nav.php"; 
  ?>

  <main class="main-lista-alunos">
    <div class="container-lista-alunos">
      <div class="topo-lista-alunos">
        <?php buttonComponent('primary', 'NOVA', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php'); ?>
        
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
                <th>AÇÔES</th>
              </tr>
            </thead>
            <tbody>
              <?php
                              // Array com dados fakes de turmas
                $turmas = [
                    ['nome' => 'Turma 138 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 139 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 140 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 141 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 142 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 143 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 144 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 145 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 146 - Voucher Desenvolvedor', 'polo' => 'Campo Grande'],
                    ['nome' => 'Turma 147 - Voucher Desenvolvedor', 'polo' => 'Dourados'],
                    ['nome' => 'Turma 148 - Voucher Desenvolvedor', 'polo' => 'Dourados'],
                    ['nome' => 'Turma 149 - Voucher Desenvolvedor', 'polo' => 'Três Lagoas'],
                    ['nome' => 'Turma 150 - Voucher Desenvolvedor', 'polo' => 'Três Lagoas']
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
