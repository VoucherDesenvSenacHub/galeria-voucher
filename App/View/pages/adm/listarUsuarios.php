<?php
require_once __DIR__ . "/../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Pessoas");
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
        <?php buttonComponent('primary', 'Novo', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastrar-usuarios.php'); ?>

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
                <th>TIPO</th>
                <th>POLO</th>
                <th>AÇÕES</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Array com dados fakes
              $usuarios = [
                ['nome' => 'João Silva', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Maria Santos', 'polo' => 'Campo Grande', 'tipo' => 'Docente'],
                ['nome' => 'Pedro Oliveira', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Ana Costa', 'polo' => 'Campo Grande', 'tipo' => 'Docente'],
                ['nome' => 'Carlos Ferreira', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Lucia Rodrigues', 'polo' => 'Campo Grande', 'tipo' => 'Docente'],
                ['nome' => 'Roberto Almeida', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Fernanda Lima', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Marcos Pereira', 'polo' => 'Campo Grande', 'tipo' => 'Docente'],
                ['nome' => 'Juliana Martins', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Rafael Souza', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Patricia Santos', 'polo' => 'Campo Grande', 'tipo' => 'Docente'],
                ['nome' => 'Lucas Mendes', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Camila Alves', 'polo' => 'Campo Grande', 'tipo' => 'Docente'],
                ['nome' => 'Diego Costa', 'polo' => 'Campo Grande', 'tipo' => 'Aluno'],
                ['nome' => 'Amanda Silva', 'polo' => 'Dourados', 'tipo' => 'Aluno'],
                ['nome' => 'Thiago Oliveira', 'polo' => 'Dourados', 'tipo' => 'Docente'],
                ['nome' => 'Carolina Lima', 'polo' => 'Dourados', 'tipo' => 'Aluno'],
                ['nome' => 'Bruno Santos', 'polo' => 'Dourados', 'tipo' => 'Docente'],
                ['nome' => 'Isabela Costa', 'polo' => 'Dourados', 'tipo' => 'Aluno'],
                ['nome' => 'Gabriel Ferreira', 'polo' => 'Dourados', 'tipo' => 'Aluno'],
                ['nome' => 'Mariana Rodrigues', 'polo' => 'Dourados', 'tipo' => 'Docente'],
                ['nome' => 'Leonardo Almeida', 'polo' => 'Dourados', 'tipo' => 'Aluno'],
                ['nome' => 'Beatriz Martins', 'polo' => 'Dourados', 'tipo' => 'Aluno'],
                ['nome' => 'Ricardo Pereira', 'polo' => 'Três Lagoas', 'tipo' => 'Docente'],
                ['nome' => 'Vanessa Silva', 'polo' => 'Três Lagoas', 'tipo' => 'Aluno'],
                ['nome' => 'Felipe Santos', 'polo' => 'Três Lagoas', 'tipo' => 'Aluno'],
                ['nome' => 'Daniela Costa', 'polo' => 'Três Lagoas', 'tipo' => 'Docente'],
                ['nome' => 'André Oliveira', 'polo' => 'Três Lagoas', 'tipo' => 'Aluno'],
                ['nome' => 'Tatiana Lima', 'polo' => 'Três Lagoas', 'tipo' => 'Docente'],
                ['nome' => 'Rodrigo Ferreira', 'polo' => 'Três Lagoas', 'tipo' => 'Aluno'],
                ['nome' => 'Cristina Alves', 'polo' => 'Três Lagoas', 'tipo' => 'Aluno']
              ];


              usort($usuarios, function ($a, $b) {
                return strcasecmp($a['nome'], $b['nome']);
              });

              foreach ($usuarios as $usuario) {
                echo '<tr>';
                echo '<td>' . $usuario['nome'] . '</td>';
                echo '<td>' . $usuario['tipo'] . '</td>';
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