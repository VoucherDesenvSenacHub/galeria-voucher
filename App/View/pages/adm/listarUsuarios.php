<?php

$paginaAtiva = 'pessoas';

require_once __DIR__ . "/../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Pessoas");
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../../Model/PessoaModel.php";
require_once __DIR__ . "/../../componentes/breadCrumbs.php";

$pessoaModel = new PessoaModel();
$termoPesquisa = $_GET['pesquisa'] ?? '';
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$usuariosPorPagina = 10;
$offset = ($paginaAtual - 1) * $usuariosPorPagina;

try {
    $totalUsuarios = $pessoaModel->contarTotalPessoas($termoPesquisa);
    $totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);
    $usuarios = $pessoaModel->buscarPessoasPaginado($usuariosPorPagina, $offset, $termoPesquisa);
} catch (Exception $e) {
    $usuarios = [];
    $totalPaginas = 0;
    error_log("Erro ao buscar usuários: " . $e->getMessage());
}
?>

<head>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="layout body-lista-alunos">

  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php
  $isAdmin = true;
  require_once __DIR__ . "/../../componentes/nav.php";
  ?>

  <main class="layout-main main-lista-alunos">
    <?php BreadCrumbs::gerarBreadCrumbs()?>
    <div class="container-lista-alunos">
      <div class="topo-lista-alunos">
        <?php buttonComponent('primary', 'CADASTRAR', false, Config::getDirAdm() . 'cadastrarUsuarios.php'); ?>

        <form method="GET" action="">
          <div class="input-pesquisa-container">
          <input type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar por nome ou polo" value="<?= htmlspecialchars($termoPesquisa) ?>">
            <button type="submit" class="search-button">
                <img src="<?= Config::getDirImg() ?>adm/lupa.png" alt="Ícone de lupa"
                class="icone-lupa-img">
            </button>
          </div>
        </form>
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
                <th>ID</th>
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
                          <td><?= htmlspecialchars($usuario['pessoa_id']) ?></td>
                          <td><?= htmlspecialchars($usuario['nome']) ?></td>
                          <td><?= htmlspecialchars(ucfirst($usuario['tipo'])) ?></td>
                          <td><?= htmlspecialchars($usuario['polo'] ?? 'Sem polo') ?></td>
                          <td class="acoes">
                              <a href="cadastrarUsuarios.php?acao=editar&id=<?= $usuario['pessoa_id'] ?>">
                                  <span class="material-symbols-outlined acao-edit" title="Editar">edit</span>
                              </a>
                              <a href="<?= Config::getAppUrl() ?>App/Controller/PessoaController.php?acao=excluir&id=<?= $usuario['pessoa_id'] ?>&perfil=<?= $usuario['tipo']?>"
                                onclick="return confirm('Tem certeza que deseja excluir este registro?');">
                                  <span class="material-symbols-outlined acao-delete" title="Excluir">delete</span>
                              </a>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr>
                      <td colspan="5" style="text-align: center;">Nenhum usuário encontrado.</td>
                  </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="paginacao-container">
        <?php if ($totalPaginas > 1): ?>
          <div class="paginacao">
            <a href="?pagina=1<?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&laquo;</a>
            
            <?php if ($paginaAtual > 1): ?>
              <a href="?pagina=<?= $paginaAtual - 1 ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&lsaquo;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
              <a href="?pagina=<?= $i ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" 
                 class="paginacao-item <?= ($i == $paginaAtual) ? 'paginacao-ativa' : '' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>

            <?php if ($paginaAtual < $totalPaginas): ?>
              <a href="?pagina=<?= $paginaAtual + 1 ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&rsaquo;</a>
            <?php endif; ?>

            <a href="?pagina=<?= $totalPaginas ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&raquo;</a>
          </div>
        <?php endif; ?>
      </div>
        </div>
    </main>
  <script src="../../assets/js/adm/lista-alunos.js"></script>

</body>
</html>