<?php
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . '/../../../Model/PessoaModel.php';
require_once __DIR__ . '/../../../Model/ImagemModel.php';
require_once __DIR__ . "/../../componentes/BreadCrumbs.php";

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__, 4));
}

headerComponent('Cadastro de Pessoa');

$paginaAtiva = 'pessoas';
$acao = $_GET['acao'] ?? 'cadastrar';
$id = $_GET['id'] ?? null;

$model = new PessoaModel();
$pessoa = null;
$perfis = $model->listarPerfisPermitidos();

if ($acao === 'editar' && $id) {
    $pessoa = $model->buscarPessoaComPoloPorId((int)$id);
}

$caminhoImagem = Config::get('APP_URL') . Config::get('DIR_IMG') . "utilitarios/avatar.png";

if ($acao === 'editar' && $pessoa && !empty($pessoa['imagem_id'])) {
    $imagemModel = new ImagemModel();
    $imagem = $imagemModel->buscarImagemPorId((int)$pessoa['imagem_id']);

    if ($imagem && !empty($imagem['url'])) {
        $caminhoFisico = ROOT_PATH . '/' . $imagem['url'];
        if (file_exists($caminhoFisico)) {
            $caminhoImagem = Config::get('APP_URL') . $imagem['url'];
        }
    }
}
?>

<body class="layout body-cadastrar-users">
    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>
    <main class="conteudo-cadastro">
        <?php BreadCrumbs::gerarBreadCrumbs(); ?>
        <h1 class='h1-usuario'><?= $acao === 'editar' ? 'EDITAR PESSOA' : 'CADASTRO' ?></h1>
        <?php if (!empty($_GET['erro'])): ?>
            <div style="margin-top: 6px; color: #b00020; font-weight: 500;"><?= htmlspecialchars($_GET['erro']) ?></div>
        <?php endif; ?>

        <form class="form-dados" method="POST" enctype="multipart/form-data" action="<?= Config::get('APP_URL') ?>App/Controller/PessoaController.php">
            <input type="hidden" name="acao" value="<?= $acao ?>">
            <?php if ($acao === 'editar' && $id): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <?php endif; ?>

            <div class="form-top">
                <div class="form-group">
                    <?php
                    inputComponent('text', 'nome', 'Nome Completo *', htmlspecialchars($_GET['nome'] ?? ($pessoa['nome'] ?? ''), ENT_QUOTES, 'UTF-8'), true);
                    inputComponent('text', 'email', 'Email *', htmlspecialchars($_GET['email'] ?? ($pessoa['email'] ?? ''), ENT_QUOTES, 'UTF-8'), true);
                    inputComponent('text', 'linkedin', 'Link do LinkedIn', htmlspecialchars($_GET['linkedin'] ?? ($pessoa['linkedin'] ?? ''), ENT_QUOTES, 'UTF-8'));
                    inputComponent('text', 'github', 'Link do GitHub', htmlspecialchars($_GET['github'] ?? ($pessoa['github'] ?? ''), ENT_QUOTES, 'UTF-8'));
                    ?>
                </div>


                <div class="form-group-polo div-center">
                    <label for="tipo-usuario" style="font-weight: bold;">Perfil *</label>
                    <select id="tipo-usuario" name="perfil" class="input-text" style="cursor: pointer;" required>
                        <option value="">-- Selecione --</option>
                        <?php
                        $perfilSelecionado = $_GET['perfil'] ?? ($pessoa['perfil'] ?? '');
                        foreach ($perfis as $perfil) : ?>
                            <option value="<?= htmlspecialchars($perfil, ENT_QUOTES, 'UTF-8') ?>"
                                <?= ($perfilSelecionado === $perfil) ? 'selected' : '' ?>>
                                <?= ucfirst(htmlspecialchars($perfil, ENT_QUOTES, 'UTF-8')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group-imagem">
                    <label style="font-weight: bold;">Imagem *</label>
                    <div class="input-file-cadastro">
                        <label class="input-file-wrapper">
                            <img id="preview" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Upload" />
                            <input type="file" name="imagem" id="fileInput" accept="image/*" style="display:none;" />
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-bottom">
                <div class="form-group-buton">
                    <?php
                    buttonComponent('secondary', 'Cancelar', false, null, null, '', 'back-button');
                    buttonComponent('primary', $acao === 'editar' ? 'Atualizar' : 'Cadastrar', true);
                    ?>
                </div>
            </div>
        </form>
    </main>

    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        });
        document.querySelector('.back-button').addEventListener('click', function(e) {
            e.preventDefault();
            window.history.back();
        });
    </script>
</body>

</html>