<?php
$paginaAtiva = 'turmas';

require_once __DIR__ . "/../../../Config/Config.php";
require_once __DIR__ . "/../../../Helpers/Redirect.php";
require_once __DIR__ . "/../../../Helpers/Request.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/input.php";
require_once __DIR__ . "/../../componentes/button.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../componentes/adm/tabsTurma.php";
require_once __DIR__ . "/../../componentes/BreadCrumbs.php";
require_once __DIR__ . "/../../../Model/ProjetoModel.php";

headerComponent("Voucher Desenvolvedor - Criar Projeto");

$turmaId = Request::getId("turma_id");
$projetoId = Request::getId("projeto_id");

$nomeProjeto = "";
$descricaoProjeto = "";
$linkProjeto = "";

$dias = [
    'I' => ['descricao' => '', 'imagem' => ''],
    'P' => ['descricao' => '', 'imagem' => ''],
    'E' => ['descricao' => '', 'imagem' => ''],
];

if ($projetoId != null) {
    $projetoModel = new ProjetoModel();
    $dados = $projetoModel->getProjetoDiaID($turmaId, $projetoId);


    if (!empty($dados)) {
        $nomeProjeto = $dados[0]['NOME_PROJETO'] ?? '';
        $descricaoProjeto = $dados[0]['DESCRICAO_PROJETO'] ?? '';
        $linkProjeto = $dados[0]['LINK_PROJETO'] ?? '';

        foreach ($dados as $d) {
            $tipo = $d['DIA_PROJETO']; // I, P ou E
            $dias[$tipo]['descricao'] = $d['DESC_DIA_PROJETO'] ?? '';
            $dias[$tipo]['imagem'] = $d['URL_IMG_PROJETO'] ?? '';
            $dias[$tipo]['img_id'] = $d['IMG_ID'] ?? '';
            $dias[$tipo]['id'] = $d['ID_DIA_PROJETO'] ?? '';
        }
        
    }
}

if (!$turmaId) {
    Redirect::toAdm('turmas.php');
}

$titulo = $projetoId ? "EDITAR PROJETO" : "CRIAR PROJETO";

$currentTab = 'cadastroProjetos';
?>

<body class="layout body-cadastroTurmas">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>

    <?php
$isAdmin = true;
require_once __DIR__ . "/../../componentes/nav.php";
?>

    <main class="layout-main main-turmas-turmas">
        <?php BreadCrumbs::gerarBreadCrumbs(); ?>
        <?php tabsTurmaComponent($currentTab, ["turma_id" => $turmaId]); ?>

        <?php if (isset($_SESSION['erro_projeto'])): ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const erros = <?= json_encode($_SESSION['erro_projeto']) ?>;
            let mensagemErro = "Ocorreram os seguintes erros:\n\n";

            if (Array.isArray(erros)) {
                erros.forEach(erro => {
                    mensagemErro += "- " + erro + "\n";
                });
            } else {
                mensagemErro = erros;
            }

            alert(mensagemErro);
        });
        </script>
        <?php unset($_SESSION['erro_projeto']); ?>
        <?php endif; ?>

        <form class="form-container-projeto" method="POST"
            action="<?= Config::getAppUrl() ?>App/Controller/ProjetoController.php" enctype="multipart/form-data">

            <!-- INPUTS HIDDEN CORRIGIDOS -->
            <input type="hidden" name="action" value="<?= $projetoId ? 'editar' : 'salvar' ?>">
            <input type="hidden" name="projeto_id" value="<?= htmlspecialchars($projetoId) ?>">
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turmaId) ?>">

            <!-- DIA I -->
            <input type="hidden" name="id_dia_projeto_i" value="<?= htmlspecialchars($dias['I']['id'] ?? '') ?>">
            <input type="hidden" name="img_id_i" value="<?= htmlspecialchars($dias['I']['img_id'] ?? '') ?>">

            <!-- DIA P -->
            <input type="hidden" name="id_dia_projeto_p" value="<?= htmlspecialchars($dias['P']['id'] ?? '') ?>">
            <input type="hidden" name="img_id_p" value="<?= htmlspecialchars($dias['P']['img_id'] ?? '') ?>">

            <!-- DIA E -->
            <input type="hidden" name="id_dia_projeto_e" value="<?= htmlspecialchars($dias['E']['id'] ?? '') ?>">
            <input type="hidden" name="img_id_e" value="<?= htmlspecialchars($dias['E']['img_id'] ?? '') ?>">

            <div class="span-full">
                <div>
                    <h1 class="h1-sobre"><?= $titulo ?></h1>

                    <div class="input-container">
                        <div class="nome-e-descricao">

                            <?php
                        inputComponent(
                            'text',
                            'nome_projeto',
                            'Nome Completo',
                            $nomeProjeto,
                            "Nome do Projeto",
                            true
                        );
                        ?>

                            <textarea name="descricao_projeto" class="input-container-textarea"
                                placeholder="Descrição Geral do Projeto:"><?= $descricaoProjeto ?></textarea>

                        </div>
                    </div>
                </div>
            </div>

            <!-- DIA I -->
            <div class="span-full">
                <div>
                    <h1 class="h1-sobre"> DIA I</h1>
                    <div class="input-container">
                        <textarea name="descricao_dia_i" class="input-container-textarea"
                            placeholder="Descrição do Dia I:"><?= $dias['I']['descricao'] ?></textarea>
                    </div>
                </div>

                <div class="input-imagem-container">
                    <label for="imagem_dia_i" style="cursor: pointer;">
                        Clique aqui para inserir a imagem

                        <?php
                    $imgI = $dias['I']['imagem'] ?: "App/View/assets/img/utilitarios/sem-foto.svg";
                    ?>

                        <img src="<?= Config::getAppUrl() . $imgI ?>" alt="Preview Dia I"
                            class="foto-projetoturma-novo preview-imagem" id="preview-dia-i" style="cursor: pointer;">
                    </label>

                    <input type="file" name="imagem_dia_i" id="imagem_dia_i" accept="image/*" hidden
                        onchange="previewFile(this, 'preview-dia-i')">
                </div>
            </div>

            <!-- DIA P -->
            <div class="span-full">
                <div>
                    <h1 class="h1-sobre"> DIA P</h1>
                    <div class="input-container">
                        <textarea name="descricao_dia_p" class="input-container-textarea"
                            placeholder="Descrição do Dia P:"><?= $dias['P']['descricao'] ?></textarea>
                    </div>
                </div>

                <div class="input-imagem-container">
                    <label for="imagem_dia_p" style="cursor: pointer;">
                        Clique aqui para inserir a imagem

                        <?php
                    $imgP = $dias['P']['imagem'] ?: "App/View/assets/img/utilitarios/sem-foto.svg";
                    ?>

                        <img src="<?= Config::getAppUrl() . $imgP ?>" alt="Preview Dia P"
                            class="foto-projetoturma-novo preview-imagem" id="preview-dia-p" style="cursor: pointer;">
                    </label>

                    <input type="file" name="imagem_dia_p" id="imagem_dia_p" accept="image/*" hidden
                        onchange="previewFile(this, 'preview-dia-p')">
                </div>
            </div>

            <!-- DIA E -->
            <div class="span-full">
                <div>
                    <h1 class="h1-sobre"> DIA E</h1>
                    <div class="input-container">
                        <textarea name="descricao_dia_e" class="input-container-textarea"
                            placeholder="Descrição do Dia E:"><?= $dias['E']['descricao'] ?></textarea>
                    </div>
                </div>

                <div class="input-imagem-container">
                    <label for="imagem_dia_e" style="cursor: pointer;">
                        Clique aqui para inserir a imagem

                        <?php
                    $imgE = $dias['E']['imagem'] ?: "App/View/assets/img/utilitarios/sem-foto.svg";
                    ?>

                        <img src="<?= Config::getAppUrl() . $imgE ?>" alt="Preview Dia E"
                            class="foto-projetoturma-novo preview-imagem" id="preview-dia-e" style="cursor: pointer;">
                    </label>

                    <input type="file" name="imagem_dia_e" id="imagem_dia_e" accept="image/*" hidden
                        onchange="previewFile(this, 'preview-dia-e')">
                </div>
            </div>

            <!-- LINK DO PROJETO -->
            <div class="link-projeto">
                <?php
            inputComponent(
                'text',
                'link_projeto',
                'Link do Repositório',
                $linkProjeto,
                "Repositório"
            );
            ?>
            </div>

            <div class="button-projeto">
                <?php buttonComponent('secondary', 'Cancelar', false, Config::getDirAdm() . 'projetos.php?id=' . $turmaId, null, '', 'back-button-js'); ?>
                <?php buttonComponent('primary', 'Salvar Projeto', true); ?>
            </div>

        </form>
    </main>

    <script>
    function previewFile(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        const defaultImage = "<?= Config::getAppUrl() ?>App/View/assets/img/utilitarios/sem-foto.svg";

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = defaultImage;
        }
    }

    document.querySelectorAll('.preview-imagem').forEach(img => {
        img.addEventListener('click', () => {
            const inputFile = img.closest('.input-imagem-container').querySelector(
                'input[type="file"]');
            if (inputFile) inputFile.click();
        });
    });

    const cancelButton = document.querySelector('.back-button-js');
    if (cancelButton) {
        cancelButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = cancelButton.href;
        });
    }
    </script>

</body>

</html>