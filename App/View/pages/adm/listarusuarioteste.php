<?php
require_once __DIR__ . "/../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Pessoas");
require_once __DIR__ . "/../../componentes/adm/auth.php";
require_once __DIR__ . '/../../../Model/usuariomodelteste.php';


// Instancia o model e busca os dados
$usuarioModel = new UsuarioModelTeste();
$usuarios = $usuarioModel->listar();
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
        <?php buttonComponent('primary', 'CADASTRAR', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastrar-usuarios.php'); ?>

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
              <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['tipo']) ?></td>
                    <td><?= htmlspecialchars($usuario['polo'] ?? 'Não definido') ?></td>
                    <td class="acoes">
                      <span class="material-symbols-outlined acao-edit" style="cursor: pointer; margin-right: 10px;" title="Editar">edit</span>
                      <span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4">Nenhum usuário encontrado.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <script src="../../assets/js/adm/lista-alunos.js"></script>

</body>
</html>
