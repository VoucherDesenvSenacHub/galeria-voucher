<?php

$paginaAtiva = 'turmas';

require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/input.php";
require_once __DIR__ . "/../../../componentes/button.php";
headerComponent("Voucher Desenvolvedor - Criar Projeto");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../componentes/breadCrumbs.php";
// require_once __DIR__ . "/../../../../Model/ProjetoModel.php";

$currentTab = 'Criar Projeto';

$projetos = [];
$isEditMode = false;
$turmaId = null;

try {
    // $projetoModel = new projetoModel();

    // Verifica se o ID da turma foi passado (modo edição)
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $turmaId = (int) $_GET['id'];

        if ($turmaId > 0) {
            $isEditMode = true;
            // $projetos = $projetoModel->buscarProjetosPorTurmaId($turmaId);
        }
    }
    // Se não houver ID, está no modo cadastro (não é erro)

} catch (Exception $e) {
    // Em caso de erro, define $projetos como um array vazio e loga o erro
    $projetos = [];
    error_log("Erro ao buscar projetos: " . $e->getMessage());

    // Exibe mensagem de erro para o usuário apenas se estiver no modo edição
    if ($isEditMode) {
        $error_message = "Erro ao carregar projetos: " . $e->getMessage();
    }
}

// Verifica se o usuário logado é um administrador para exibir o botão de excluir
$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';

?>

<body class="body-cadastro-turmas">
  <div class="container-adm">

    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true; // Para páginas de admin
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>

    <?php
    $imagens = [
      ["titulo" => "IMAGEM DA TURMA", "quantidade" => 6],
      ["titulo" => "IMAGEM DO DIA I", "quantidade" => 6],
      ["titulo" => "IMAGEM DO DIA P", "quantidade" => 6],
      ["titulo" => "IMAGEM DO DIA E", "quantidade" => 6],
    ];
    ?>

    <main class="main-turmas-turmas">
      <?php BreadCrumbs::gerarBreadCrumbs()?>

      <?php
      // Usa o componente de abas das turmas
      tabsTurmaComponent($currentTab, $turmaId);
      ?>

      <div class="form-container-projeto">

        <h1 class="h1-sobre">DESCRIÇÃO DO PROJETO</h1>
        <div class="Container_Dia">
          <div class="nome-e-descricao">
            <input type="text" class="input-field" placeholder="Nome do Projeto:">
            <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          </div>
          <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>


        <h1 class="h1-sobre"> DIA I</h1>
        <div class="Container_Dia">
          <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>

        <h1 class="h1-sobre"> DIA P</h1>
        <div class="Container_Dia">
          <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>

        <h1 class="h1-sobre"> DIA D</h1>
        <div class="Container_Dia">
          <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>

        <div class="link-projeto">
          <input type="text" class="input-projeto" placeholder="Link de Projeto:">
          <div class="btn-novos-projeto">
          </div>
        </div>
        <div class="button-projeto">
          <?php buttonComponent('secondary', 'Cancelar', false, null, null, '', 'back-button'); ?>
          <?php buttonComponent('primary', 'Salvar', true); ?>
        </div>


      </div>


    </main>
  </div>
</body>

</html>