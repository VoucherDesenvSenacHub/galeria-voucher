<?php
$paginaAtiva = 'turmas';

require_once __DIR__ . "/../../../../Config/App.php";
require_once __DIR__ . "/../../../../Helpers/Redirect.php";

// Valida se o ID da turma foi passado e é um inteiro válido
if (!isset($_GET['id']) || empty($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Redireciona para a lista de turmas se o ID for inválido
    Redirect::toAdm('listaTurmas.php');
}

// Includes para componentes visuais e de autenticação
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/input.php";
require_once __DIR__ . "/../../../componentes/button.php";
headerComponent("Voucher Desenvolvedor - Criar Projeto"); // Define o título da página
require_once __DIR__ . "/../../../../Service/AuthService.php"; // Garante que o usuário está logado
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php"; // Componente de abas
require_once __DIR__ . "/../../../componentes/BreadCrumbs.php"; // Componente de navegação

$currentTab = 'projetos'; // Define a aba ativa correta
$turmaId = (int)$_GET['id']; // Pega o ID da turma da URL
?>

<body class="layout body-cadastro-turmas">

    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; // Inclui a barra lateral ?>
    <?php
    $isAdmin = true; // Define que é uma página de admin para o nav
    require_once __DIR__ . "/../../../componentes/nav.php"; // Inclui a barra de navegação
    ?>

    <main class="layout-main main-turmas-turmas">
        <?php BreadCrumbs::gerarBreadCrumbs(); // Gera a navegação breadcrumb ?>
        <?php tabsTurmaComponent($currentTab, $turmaId); // Exibe as abas da turma ?>

        <?php if (isset($_SESSION['erro_projeto'])): ?>
            <div class="error-message" style="margin: 10px 0; padding: 10px; background-color: #ffdddd; border: 1px solid #ffaaaa; color: #D8000C;">
                <?= $_SESSION['erro_projeto']; ?>
            </div>
            <?php unset($_SESSION['erro_projeto']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['sucesso_projeto'])): ?>
            <div class="success-message" style="margin: 10px 0; padding: 10px; background-color: #ddffdd; border: 1px solid #aaffaa; color: #4F8A10;">
                <?= $_SESSION['sucesso_projeto']; ?>
            </div>
            <?php unset($_SESSION['sucesso_projeto']); ?>
        <?php endif; ?>


        <form class="form-container-projeto" method="POST" action="<?= Config::get('APP_URL') ?>App/Controller/ProjetoController.php?action=salvar" enctype="multipart/form-data">
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turmaId) ?>">

            <h1 class="h1-sobre">DESCRIÇÃO DO PROJETO</h1>
            <div class="Container_Dia">
                <div class="nome-e-descricao">
                    <input type="text" name="nome_projeto" class="input-field" placeholder="Nome do Projeto:" required>
                    <textarea name="descricao_projeto" class="textarea-field" placeholder="Descrição:" required></textarea>
                </div>
                 <div style="position: relative; width: 150px; text-align: center;">
                    <img id="preview_projeto" src="<?= Config::get('APP_URL') ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Foto Projeto"
                        class="foto-projetoturma-novo" style="position: static; cursor: pointer; width: 120px; height: 150px; object-fit: contain; border: 1px solid #333; border-radius: 20px; background-color: #e5e9e4; padding: 10px;"/>
                    <input type="file" name="imagem_projeto" id="imagem_projeto_input" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview_projeto');">
                    <small style="display: block; margin-top: 5px;">Clique para adicionar capa</small>
                </div>
            </div>

            <h1 class="h1-sobre"> DIA I (Início)</h1>
            <div class="Container_Dia">
                <textarea name="descricao_dia_i" class="textarea-field" placeholder="Descrição das atividades do Dia I:" required></textarea>
                <div style="position: relative; width: 150px; text-align: center;">
                    <img id="preview_dia_i" src="<?= Config::get('APP_URL') ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Foto Dia I"
                         class="foto-projetoturma-novo" style="position: static; cursor: pointer; width: 120px; height: 150px; object-fit: contain; border: 1px solid #333; border-radius: 20px; background-color: #e5e9e4; padding: 10px;"/>
                    <input type="file" name="imagem_dia_i" id="imagem_dia_i_input" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview_dia_i');">
                     <small style="display: block; margin-top: 5px;">Clique para adicionar imagem</small>
                </div>
            </div>

            <h1 class="h1-sobre"> DIA P (Processo)</h1>
            <div class="Container_Dia">
                <textarea name="descricao_dia_p" class="textarea-field" placeholder="Descrição das atividades do Dia P:" required></textarea>
                 <div style="position: relative; width: 150px; text-align: center;">
                     <img id="preview_dia_p" src="<?= Config::get('APP_URL') ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Foto Dia P"
                          class="foto-projetoturma-novo" style="position: static; cursor: pointer; width: 120px; height: 150px; object-fit: contain; border: 1px solid #333; border-radius: 20px; background-color: #e5e9e4; padding: 10px;"/>
                     <input type="file" name="imagem_dia_p" id="imagem_dia_p_input" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview_dia_p');">
                      <small style="display: block; margin-top: 5px;">Clique para adicionar imagem</small>
                 </div>
            </div>

            <h1 class="h1-sobre"> DIA E (Entrega)</h1> <div class="Container_Dia">
                 <textarea name="descricao_dia_e" class="textarea-field" placeholder="Descrição das atividades do Dia E:" required></textarea>
                 <div style="position: relative; width: 150px; text-align: center;">
                     <img id="preview_dia_e" src="<?= Config::get('APP_URL') ?>App/View/assets/img/utilitarios/sem-foto.svg" alt="Foto Dia E"
                          class="foto-projetoturma-novo" style="position: static; cursor: pointer; width: 120px; height: 150px; object-fit: contain; border: 1px solid #333; border-radius: 20px; background-color: #e5e9e4; padding: 10px;"/>
                     <input type="file" name="imagem_dia_e" id="imagem_dia_e_input" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview_dia_e');">
                      <small style="display: block; margin-top: 5px;">Clique para adicionar imagem</small>
                 </div>
            </div>

            <div class="link-projeto">
                 <input type="url" name="link_projeto" class="input-projeto" placeholder="Link do Repositório (Ex: GitHub):">
                <div class="btn-novos-projeto">
                    </div>
            </div>

            <div class="button-projeto">
                <?php // Botão secundário para voltar (usa JS global 'back-button') ?>
                <?php buttonComponent('secondary', 'Cancelar', false, null, null, '', 'back-button'); ?>
                <?php // Botão primário do tipo submit para salvar ?>
                <?php buttonComponent('primary', 'Salvar Projeto', true); ?>
            </div>
        </form> </main>

    <script>
        // Função para exibir a imagem selecionada no input file
        function previewImage(input, previewId) {
            const file = input.files[0]; // Pega o arquivo selecionado
            const previewElement = document.getElementById(previewId); // Pega o elemento <img> do preview

            if (file) {
                // Se um arquivo foi selecionado
                const reader = new FileReader(); // Cria um leitor de arquivo
                reader.onload = function(e) {
                    // Quando o arquivo for lido, define o src da imagem de preview
                    previewElement.src = e.target.result;
                }
                reader.readAsDataURL(file); // Lê o arquivo como Data URL
            } else {
                 // Se nenhum arquivo for selecionado (ou a seleção for cancelada), volta para a imagem padrão
                 previewElement.src = "<?= Config::get('APP_URL') ?>App/View/assets/img/utilitarios/sem-foto.svg";
            }
        }

        // Adiciona um listener de clique a cada imagem de preview.
        // Clicar na imagem vai acionar o clique no input file correspondente (que está escondido).
        document.getElementById('preview_projeto').addEventListener('click', () => document.getElementById('imagem_projeto_input').click());
        document.getElementById('preview_dia_i').addEventListener('click', () => document.getElementById('imagem_dia_i_input').click());
        document.getElementById('preview_dia_p').addEventListener('click', () => document.getElementById('imagem_dia_p_input').click());
        document.getElementById('preview_dia_e').addEventListener('click', () => document.getElementById('imagem_dia_e_input').click());

         // Adiciona funcionalidade ao botão 'Cancelar' (se não estiver usando o global.js)
         const backButton = document.querySelector('.back-button');
         if (backButton) {
             backButton.addEventListener('click', (event) => {
                 event.preventDefault(); // Impede o envio do formulário
                 // Volta para a página anterior no histórico do navegador
                 // ou redireciona para a lista de projetos se preferir
                 // window.location.href = '<?= Config::get('APP_URL') . Config::get('DIR_ADM') ?>cadastroTurmas/CadastroProjetos.php?id=<?= $turmaId ?>';
                 history.back();
             });
         }
    </script>

</body>
</html>