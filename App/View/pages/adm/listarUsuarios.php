<?php
require_once __DIR__ . "/../../componentes/head.php";
headerComponent('Lista de Usuários');
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
        <div class="select-pessoa">
          <select name="pessoa" id="pessoa">
            <option value="todos">TODOS</option>
            <option value="professor">PROFESSOR</option>
            <option value="aluno">ALUNO</option>
          </select>
        </div>
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
                <th>AÇÕES</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Array com dados fakes
              $usuarios = [
                  ['nome' => 'João Silva', 'tipo' => 'Aluno'],
                  ['nome' => 'Maria Santos', 'tipo' => 'Professor'],
                  ['nome' => 'Pedro Oliveira', 'tipo' => 'Aluno'],
                  ['nome' => 'Ana Costa', 'tipo' => 'Professor'],
                  ['nome' => 'Carlos Ferreira', 'tipo' => 'Aluno'],
                  ['nome' => 'Lucia Rodrigues', 'tipo' => 'Professor'],
                  ['nome' => 'Roberto Almeida', 'tipo' => 'Aluno'],
                  ['nome' => 'Fernanda Lima', 'tipo' => 'Professor'],
                  ['nome' => 'Marcos Pereira', 'tipo' => 'Aluno'],
                  ['nome' => 'Juliana Martins', 'tipo' => 'Professor'],
                  ['nome' => 'Rafael Souza', 'tipo' => 'Aluno'],
                  ['nome' => 'Patricia Santos', 'tipo' => 'Professor'],
                  ['nome' => 'Lucas Mendes', 'tipo' => 'Aluno'],
                  ['nome' => 'Camila Alves', 'tipo' => 'Professor'],
                  ['nome' => 'Diego Costa', 'tipo' => 'Aluno'],
                  ['nome' => 'Amanda Silva', 'tipo' => 'Professor'],
                  ['nome' => 'Thiago Oliveira', 'tipo' => 'Aluno'],
                  ['nome' => 'Carolina Lima', 'tipo' => 'Professor'],
                  ['nome' => 'Bruno Santos', 'tipo' => 'Aluno'],
                  ['nome' => 'Isabela Costa', 'tipo' => 'Professor'],
                  ['nome' => 'Gabriel Ferreira', 'tipo' => 'Aluno'],
                  ['nome' => 'Mariana Rodrigues', 'tipo' => 'Professor'],
                  ['nome' => 'Leonardo Almeida', 'tipo' => 'Aluno'],
                  ['nome' => 'Beatriz Martins', 'tipo' => 'Professor'],
                  ['nome' => 'Ricardo Pereira', 'tipo' => 'Aluno'],
                  ['nome' => 'Vanessa Silva', 'tipo' => 'Professor'],
                  ['nome' => 'Felipe Santos', 'tipo' => 'Aluno'],
                  ['nome' => 'Daniela Costa', 'tipo' => 'Professor'],
                  ['nome' => 'André Oliveira', 'tipo' => 'Aluno'],
                  ['nome' => 'Tatiana Lima', 'tipo' => 'Professor'],
                  ['nome' => 'Rodrigo Ferreira', 'tipo' => 'Aluno'],
                  ['nome' => 'Cristina Alves', 'tipo' => 'Professor']
              ];

              foreach ($usuarios as $usuario) {
                  echo '<tr>';
                  echo '<td>' . $usuario['nome'] . '</td>';
                  echo '<td>' . $usuario['tipo'] . '</td>';
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