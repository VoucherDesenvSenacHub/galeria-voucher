<?php

$paginaAtiva = 'pessoas'; 

require_once __DIR__ . "/../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Pessoas");
require_once __DIR__ . "/../../componentes/adm/auth.php";
require_once __DIR__ . '/../../../Model/PessoaModel.php';

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
        <?php if (!empty($_GET['erro'])): ?>
          <div style="margin: 12px 0; color: #b00020; font-weight: 600;">
            <?= htmlspecialchars($_GET['erro']) ?>
          </div>
        <?php endif; ?>
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
              $model = new PessoaModel();

              $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
              $itensPorPagina = 10;
              $offset = ($pagina - 1) * $itensPorPagina;

              $usuarios = $model->listarPessoasTable($itensPorPagina, $offset);
              ?>

              <?php foreach ($usuarios as $usuario): ?>
                <tr>
                  <td><?= htmlspecialchars($usuario['nome']) ?></td>
                  <td><?= htmlspecialchars($usuario['perfil']) ?></td>
                  <td><?= htmlspecialchars($usuario['nome_polo'] ?? 'Sem polo') ?></td>
                  <td class="acoes">
                    <a href="cadastrar-usuarios.php?acao=editar&id=<?= $usuario['pessoa_id'] ?>">
                      <span class="material-symbols-outlined acao-edit" title="Editar">edit</span>
                    </a>
                    <a href="../../../Controls/ControllerPessoa.php?acao=excluir&id=<?= $usuario['pessoa_id'] ?>&perfil=<?= $usuario['perfil']?>"
                      onclick="return confirm('Tem certeza que deseja excluir este registro?');">
                      <span class="material-symbols-outlined acao-delete"
                        style="cursor: pointer;"
                        title="Excluir">
                        delete
                      </span>
                    </a>

                  </td>
                </tr>
              <?php endforeach; ?>


            </tbody>
          </table>
          <div class="paginacao">
            <?php if ($pagina > 1): ?>
              <a href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
            <?php endif; ?>
            <span>Página <?= $pagina ?></span>
            <?php if (count($usuarios) == $itensPorPagina): ?>
              <a href="?pagina=<?= $pagina + 1 ?>">Próximo</a>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </main>
  <script src="../../assets/js/adm/lista-alunos.js"></script>

</body>

</html>