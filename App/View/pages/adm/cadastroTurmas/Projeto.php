<?php
$paginaAtiva = 'turmas';

require_once __DIR__ . "/../../../../Config/App.php";
require_once __DIR__ . "/../../../../Helpers/Redirect.php";
require_once __DIR__ . "/../../../../Helpers/Request.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/input.php";
require_once __DIR__ . "/../../../componentes/button.php";
require_once __DIR__ . "/../../../../Service/AuthService.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../componentes/BreadCrumbs.php";

headerComponent("Voucher Desenvolvedor - Criar Projeto");

$turmaId = Request::getUriId("turma_id");
$projetoId = Request::getUriId("projeto_id");
if (!$turmaId) {
    Redirect::toAdm('listaTurmas.php');
}

$currentTab = 'Criar Projeto';
?>

<body class="layout body-cadastro-turmas">

    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>

    <main class="layout-main main-turmas-turmas">
      <?php BreadCrumbs::gerarBreadCrumbs(); ?>
      <?php tabsTurmaComponent($currentTab, ["turma_id" => $turmaId]); ?>

      <div class="form-container-projeto">

        <h1 class="h1-sobre">DESCRIÇÃO DO PROJETO</h1>
        <div class="Container_Dia">
          <div class="nome-e-descricao">
            <input type="text" class="input-field" placeholder="Nome do Projeto:">
            <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          </div>
          <img src="<?= Config::get('APP_URL') ?>referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>

        <h1 class="h1-sobre"> DIA I</h1>
        <div class="Container_Dia">
          <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          <img src="<?= Config::get('APP_URL') ?>referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>

        <h1 class="h1-sobre"> DIA P</h1>
        <div class="Container_Dia">
          <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          <img src="<?= Config::get('APP_URL') ?>referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
            class="foto-projetoturma-novo" />
        </div>

        <h1 class="h1-sobre"> DIA D</h1>
        <div class="Container_Dia">
          <textarea class="textarea-field" placeholder="Descrição:"></textarea>
          <img src="<?= Config::get('APP_URL') ?>referencia/area-adm/tela-inicial-adm/assets/projetoimg.png" alt="Foto Turma"
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
</body>
</html>