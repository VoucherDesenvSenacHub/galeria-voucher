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

$turmaId = Request::getId("turma_id");
$projetoId = Request::getId("projeto_id");
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

      <?php if (isset($_SESSION['erro_projeto'])): ?>
            <div style="color: red; margin-top: 10px;">
                <strong>Erro ao salvar projeto:</strong><br>
                <?php
                    if (is_array($_SESSION['erro_projeto'])) {
                        foreach ($_SESSION['erro_projeto'] as $erro) {
                            echo htmlspecialchars($erro) . "<br>";
                        }
                    } else {
                         echo htmlspecialchars($_SESSION['erro_projeto']);
                    }
                ?>
            </div>
            <?php unset($_SESSION['erro_projeto']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['sucesso_projeto'])): ?>
            <div style="color: green; margin-top: 10px;">
                <?= htmlspecialchars($_SESSION['sucesso_projeto']) ?>
            </div>
            <?php unset($_SESSION['sucesso_projeto']); ?>
        <?php endif; ?>


      <form class="form-container-projeto"
            method="POST"
            action="<?= Config::getAppUrl() ?>App/Controller/ProjetoController.php"
            enctype="multipart/form-data">

            <input type="hidden" name="action" value="salvar">
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turmaId) ?>">

            <h1 class="h1-sobre">DESCRIÇÃO DO PROJETO</h1>
            <div class="Container_Dia">
                <div class="nome-e-descricao">
                    <input type="text" name="nome_projeto" class="input-field" placeholder="Nome do Projeto *" required>
                    <textarea name="descricao_projeto" class="textarea-field" placeholder="Descrição Geral do Projeto:"></textarea>
                </div>
                 </div>

            <h1 class="h1-sobre"> DIA I</h1>
            <div class="Container_Dia">
                <textarea name="descricao_dia_i" class="textarea-field" placeholder="Descrição do Dia I:"></textarea>
                <div class="input-imagem-container" style="position: relative; width: 120px; height: 150px;">
                     <img src="<?= Config::getAppUrl() ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Preview Dia I" class="foto-projetoturma-novo preview-imagem" id="preview-dia-i" style="cursor: pointer;" />
                     <input type="file" name="imagem_dia_i" accept="image/*" style="display: none;" onchange="previewFile(this, 'preview-dia-i')">
                 </div>
            </div>

            <h1 class="h1-sobre"> DIA P</h1>
            <div class="Container_Dia">
                <textarea name="descricao_dia_p" class="textarea-field" placeholder="Descrição do Dia P:"></textarea>
                 <div class="input-imagem-container" style="position: relative; width: 120px; height: 150px;">
                     <img src="<?= Config::getAppUrl() ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Preview Dia P" class="foto-projetoturma-novo preview-imagem" id="preview-dia-p" style="cursor: pointer;" />
                     <input type="file" name="imagem_dia_p" accept="image/*" style="display: none;" onchange="previewFile(this, 'preview-dia-p')">
                 </div>
            </div>

             <h1 class="h1-sobre"> DIA E</h1>
            <div class="Container_Dia">
                <textarea name="descricao_dia_e" class="textarea-field" placeholder="Descrição do Dia E:"></textarea>
                 <div class="input-imagem-container" style="position: relative; width: 120px; height: 150px;">
                     <img src="<?= Config::getAppUrl() ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Preview Dia E" class="foto-projetoturma-novo preview-imagem" id="preview-dia-e" style="cursor: pointer;" />
                     <input type="file" name="imagem_dia_e" accept="image/*" style="display: none;" onchange="previewFile(this, 'preview-dia-e')">
                 </div>
            </div>

            <div class="link-projeto">
                <input type="url" name="link_projeto" class="input-projeto" placeholder="Link do Repositório (Ex: https://github.com/...)">
            </div>

            <div class="button-projeto">
                <?php buttonComponent('secondary', 'Cancelar', false, Config::getDirAdm() . 'cadastroTurmas/CadastroProjetos.php?id=' . $turmaId, null, '', 'back-button-js'); // Link direto para voltar ?>
                <?php buttonComponent('primary', 'Salvar Projeto', true); // Botão de submit ?>
            </div>
      </form>
    </main>

    <script>
        // Função para preview da imagem
        function previewFile(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const defaultImage = "<?= Config::getAppUrl() ?>App/View/assets/img/utilitarios/sem-foto.svg"; // Imagem padrão

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                 // Se nenhum arquivo for selecionado (ou seleção cancelada), volta para a imagem padrão
                 preview.src = defaultImage;
            }
        }

         // Adiciona clique nas imagens para ativar o input file correspondente
         document.querySelectorAll('.preview-imagem').forEach(img => {
            img.addEventListener('click', () => {
                // Encontra o input file irmão ou dentro do mesmo container
                const inputFile = img.closest('.input-imagem-container').querySelector('input[type="file"]');
                if (inputFile) {
                    inputFile.click();
                }
            });
         });

         // Corrige botão cancelar para não usar history.back() que pode dar problema com POST
          const cancelButton = document.querySelector('.back-button-js');
          if (cancelButton) {
              cancelButton.addEventListener('click', (e) => {
                  e.preventDefault(); // Impede comportamento padrão se for <a>
                  window.location.href = cancelButton.href; // Navega para o link definido no href
              });
          }
    </script>

</body>
</html>