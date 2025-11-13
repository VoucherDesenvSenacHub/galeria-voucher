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

$caminhoImagem = Config::getDirImg() . "utilitarios/avatar.png";

if ($acao === 'editar' && $pessoa && !empty($pessoa['imagem_id'])) {
    $imagemModel = new ImagemModel();
    $imagem = $imagemModel->buscarImagemPorId((int)$pessoa['imagem_id']);
    
    if ($imagem && !empty($imagem['url'])) {
        $caminhoFisico = ROOT_PATH . '/' . $imagem['url'];
        if (file_exists($caminhoFisico)) {
            $caminhoImagem = Config::getAppUrl() . $imagem['url'];
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
            <div style="margin: 12px 0; color: #b00020; font-weight: 600;"><?= htmlspecialchars($_GET['erro']) ?></div>
        <?php endif; ?>

        <form class="form-dados" method="POST" enctype="multipart/form-data" action="<?= Config::getAppUrl() ?>App/Controller/PessoaController.php">
            <input type="hidden" name="acao" value="<?= $acao ?>">
            <?php if ($acao === 'editar' && $id): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <?php endif; ?>

                <div class="form-top">
              
                        <?php
                        inputComponent('text', 'nome', 'Nome Completo', $pessoa['nome'] ?? ($_POST['nome'] ?? ''), "nome", true );
                        inputComponent('text', 'email', 'Email', $pessoa['email'] ?? ($_POST['email'] ?? ''), "email", true);
                        inputComponent('password', 'senha', 'Senha', $pessoa['senha'] ?? ($_POST['senha'] ?? ''), "senha", true);
                        inputComponent('text', 'linkedin', 'Link do linkedin', $pessoa['linkedin'] ?? ($_POST['linkedin'] ?? ''), "linkedin" );
                        inputComponent('text', 'github', 'Link para o GitHub', $pessoa['github'] ?? ($_POST['github'] ?? ''), "github" );
                        ?>
                   
                    <div class="input-container">
                        <label for="tipo-usuario">Perfil</label>
                        <select id="tipo-usuario" name="perfil" class="input-text" style="cursor: pointer;" required>
                            <option value="">-- Selecione --</option>
                            <?php foreach ($perfis as $perfil): ?>
                                <option value="<?= htmlspecialchars($perfil) ?>"
                                    <?= (($pessoa['perfil'] ?? ($_POST['perfil'] ?? '')) === $perfil) ? 'selected' : '' ?>>
                                    <?= ucfirst(htmlspecialchars($perfil)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group-imagem input-container">
                    Clique na imagem para alterar
                    
                    <div class="input-file-cadastro">
                            <label for="fileInput">
                            <img id="preview" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Upload" />
                            <input type="file"  name="imagem" id="fileInput" accept="image/*" style="width:0; overflow: hidden;">
                            
                        </label>
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
    
    <script src="<?= Config::getAppUrl() ?>App/View/assets/js/adm/cadastra-usuario.js"></script>
</body>
</html>