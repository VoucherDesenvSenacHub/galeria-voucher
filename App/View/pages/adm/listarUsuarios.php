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
        <?php buttonComponent('primary', 'Novo Cadastro', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastrar-usuarios.php'); ?>

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
                <th>AÇÕES</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Array com dados fakes
              $usuarios = [
                  ['nome' => 'João Silva', 'polo' => 'Campo Grande'],
                  ['nome' => 'Maria Santos', 'polo' => 'Campo Grande'],
                  ['nome' => 'Pedro Oliveira', 'polo' => 'Campo Grande'],
                  ['nome' => 'Ana Costa', 'polo' => 'Campo Grande'],
                  ['nome' => 'Carlos Ferreira', 'polo' => 'Campo Grande'],
                  ['nome' => 'Lucia Rodrigues', 'polo' => 'Campo Grande'],
                  ['nome' => 'Roberto Almeida', 'polo' => 'Campo Grande'],
                  ['nome' => 'Fernanda Lima', 'polo' => 'Campo Grande'],
                  ['nome' => 'Marcos Pereira', 'polo' => 'Campo Grande'],
                  ['nome' => 'Juliana Martins', 'polo' => 'Campo Grande'],
                  ['nome' => 'Rafael Souza', 'polo' => 'Campo Grande'],
                  ['nome' => 'Patricia Santos', 'polo' => 'Campo Grande'],
                  ['nome' => 'Lucas Mendes', 'polo' => 'Campo Grande'],
                  ['nome' => 'Camila Alves', 'polo' => 'Campo Grande'],
                  ['nome' => 'Diego Costa', 'polo' => 'Campo Grande'],
                  ['nome' => 'Amanda Silva', 'polo' => 'Dourados'],
                  ['nome' => 'Thiago Oliveira', 'polo' => 'Dourados'],
                  ['nome' => 'Carolina Lima', 'polo' => 'Dourados'],
                  ['nome' => 'Bruno Santos', 'polo' => 'Dourados'],
                  ['nome' => 'Isabela Costa', 'polo' => 'Dourados'],
                  ['nome' => 'Gabriel Ferreira', 'polo' => 'Dourados'],
                  ['nome' => 'Mariana Rodrigues', 'polo' => 'Dourados'],
                  ['nome' => 'Leonardo Almeida', 'polo' => 'Dourados'],
                  ['nome' => 'Beatriz Martins', 'polo' => 'Dourados'],
                  ['nome' => 'Ricardo Pereira', 'polo' => 'Três Lagoas'],
                  ['nome' => 'Vanessa Silva', 'polo' => 'Três Lagoas'],
                  ['nome' => 'Felipe Santos', 'polo' => 'Três Lagoas'],
                  ['nome' => 'Daniela Costa', 'polo' => 'Três Lagoas'],
                  ['nome' => 'André Oliveira', 'polo' => 'Três Lagoas'],
                  ['nome' => 'Tatiana Lima', 'polo' => 'Três Lagoas'],
                  ['nome' => 'Rodrigo Ferreira', 'polo' => 'Três Lagoas'],
                  ['nome' => 'Cristina Alves', 'polo' => 'Três Lagoas']
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