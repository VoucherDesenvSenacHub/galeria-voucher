<?php
// Carrega dependências necessárias
require_once __DIR__ . "/../../../Config/env.php"; // Ainda necessário para o head.php
require_once __DIR__ . "/../../../Config/App.php"; // Carrega a nova classe de config
require_once __DIR__ . "/../../../Model/GaleriaTurmaModel.php";
require_once __DIR__ . "/../../../Model/ProjetoModel.php"; // Necessário para o formatador
require_once __DIR__ . "/../../../Helpers/ViewHelper.php"; // Helper com a função de formatação

// Obtém ID da turma via URL e carrega dados
$turmaId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
if ($turmaId <= 0) {
    header("Location: ./turma.php"); // Redirecionamento simples pode permanecer aqui
    exit;
}

$galeriaModel = new GaleriaTurmaModel();
$dados = $galeriaModel->carregarDadosTurma($turmaId);

// Se não encontrou dados, redireciona
if ($dados === null) {
    header("Location: ./turma.php");
    exit;
}

// Formata os projetos usando a função do ViewHelper
$projetosFormatados = formatarProjetosParaView($dados['projetos'], new ProjetoModel());

// Extrai variáveis para a view
$imagemTurmaUrl   = $dados['imagemTurmaUrl'];
$nomeTurma        = $dados['nomeTurma'] ?? '';
$descricaoTurma   = $dados['descricaoTurma'] ?? '';
$alunos           = $dados['alunos'] ?? [];
$orientadores     = $dados['orientadores'] ?? [];
$tabsProjetos     = $projetosFormatados['tabsProjetos'];
$projetosRender   = $projetosFormatados['projetosFormatados'];
$polo             = $dados['polo'] ?? '';
$cidade           = $dados['cidade'] ?? '';

$pessoasTurma = array_merge($alunos, $orientadores);

// Define o título da página 
require_once __DIR__ . "/../../componentes/head.php";
headerComponent('Galeria da Turma');
?>

<body class="layout galeria-turma-body">

    <section class="main-section layout-main">
        <?php
        $isAdmin = false;
        require_once __DIR__ . "/../../componentes/nav.php";
        ?>
        <main>
            <?php require_once __DIR__ . "/../../componentes/users/mira.php"; ?>
            
            <section class="galeria-turma-section galeria-turma-projeto">
                <h1 class="galeria-turma-h1 projetos-turma">Projetos da turma</h1>
        
                <section class="galeria-turma-senac">
                    <h3 class="galeria-turma-h3"><?= htmlspecialchars($polo) ?></h3>
                    <h3 class="galeria-turma-h3"><?= htmlspecialchars($cidade) ?></h3>
                </section>
        
                <section class="galeria-turma-tab-inner">
                    <img class="galeria-turma-imagem-direita" src="<?= htmlspecialchars($imagemTurmaUrl) ?>" alt="Imagem da Turma">
                    <div class="galeria-turma-margin-top-left-projeto1-dia-i">
                        <h2><?= htmlspecialchars($nomeTurma) ?></h2>
                        <p><?= nl2br(htmlspecialchars($descricaoTurma)) ?></p>
                    </div>
                </section>

                <section class="galeria-turma-section galeria-turma-galeria projetos-turma galeria-turma-no-side-padding">
                    <h1 class="galeria-turma-h1">Galeria de Projetos</h1>

                    <div class="galeria-turma-main-tabs-nav">
                        <?php foreach ($tabsProjetos as $tab): ?>
                            <a class="galeria-turma-main-tab-btn <?= htmlspecialchars($tab['classe_css']) ?>" data-projeto="<?= htmlspecialchars($tab['projeto_id']) ?>">
                                <?= htmlspecialchars($tab['nome']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <div class="galeria-turma-main-tabs-content">
                        <?php foreach ($projetosRender as $projeto): ?>
                            <div class="galeria-turma-main-tab-content <?= $projeto['ativo'] ? 'active' : '' ?>" id="main-tab-<?= htmlspecialchars($projeto['projeto_id']) ?>">

                                <div class="galeria-turma-projeto-intro">
                                    <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
                                </div>

                                <div class="galeria-turma-sub-tabs-nav">
                                    <div class="galeria-turma-sub-wrapper">
                                        <?php foreach ($projeto['dias'] as $i => $dia): ?>
                                            <button class="galeria-turma-sub-tab-btn <?= $dia['ativo'] ? 'active' : '' ?>"
                                                data-subtab="<?= htmlspecialchars($dia['id']) ?>"
                                                data-projeto="<?= htmlspecialchars($projeto['projeto_id']) ?>">
                                                <?= htmlspecialchars($dia['titulo'])?>
                                            </button>
                                        <?php endforeach; ?>
            
                                        <h1 class="galeria-turma-h1">
                                            PROJETO
                                        </h1>
                                    </div>
                                </div>

                                <div class="galeria-turma-sub-tabs-content">
                                    <?php foreach ($projeto['dias'] as $dia): ?>
                                        <div class="galeria-turma-sub-tab-content <?= $dia['ativo'] ? 'active' : '' ?>" id="sub-tab-<?= htmlspecialchars($dia['id']) ?>">
                                            <div class="galeria-turma-tab-inner">
                                                <div class="galeria-turma-tab-text">
                                                    <h4><?= htmlspecialchars($dia['titulo']) ?></h4>
                                                    <p><?= nl2br(htmlspecialchars($dia['descricao'])) ?></p>
                                                </div>
                                                <div class="galeria-turma-tab-image">
                                                    <?php foreach (($dia['imagens'] ?? []) as $img): ?>
                                                        <img src="<?= htmlspecialchars($img['url']) ?>" alt="<?= htmlspecialchars($img['alt']) ?>">
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Seção do Projeto com botão dedicado -->
                                <div class="galeria-turma-projeto-section">
                                    <div class="galeria-turma-projeto-header">
                                        <h3>Repositório do Projeto</h3>
                                        <p>Acesse o código-fonte completo deste projeto</p>
                                    </div>
                                    <div class="galeria-turma-projeto-actions">
                                        <?php if (!empty($projeto['link'])): ?>
                                            <button onclick="window.open('<?= htmlspecialchars($projeto['link']) ?>')" class="galeria-turma-sub-tab-btn">
                                                Ver no GitHub
                                            </button>
                                        <?php else: ?>
                                            <div class="galeria-turma-no-repo">
                                                <p>Link do repositório não disponível</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            
                <section class="galeria-turma-cardss">
                    <h1 class="galeria-turma-h1">Alunos</h1>
                    <div class="galeria-turma-container">
                        <?php if (!empty($alunos)): ?>
                            <?php foreach ($alunos as $aluno): ?>
                                <?php $pessoa = $aluno; // Adaptação para o card genérico ?>
                                <?php include __DIR__ . "/../../componentes/users/card_pessoa.php"; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Nenhum aluno encontrado para esta turma.</p>
                        <?php endif; ?>
                    </div>
                </section>
            
                <section class="galeria-turma-cardss">
                    <h1 class="galeria-turma-h1">Professores</h1>
                    <div class="galeria-turma-container">
                        <?php if (!empty($orientadores)): ?>
                            <?php foreach ($orientadores as $orientador): ?>
                                <?php $pessoa = $orientador; // Adaptação para o card genérico ?>
                                <?php include __DIR__ . "/../../componentes/users/card_pessoa.php"; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Nenhum professor encontrado para esta turma.</p>
                        <?php endif; ?>
                    </div>
                </section>
        </main>
    
        <footer class="galeria-turma-footer">
            <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
        </footer>
    </section>

    <script>
        // Adiciona a variável APP_URL ao JavaScript para ser usada no nav.js
        const APP_URL = '<?= Config::get("APP_URL") ?>';
    </script>
    <script src="<?= Config::get('APP_URL') . Config::get('DIR_JS') ?>users/nav.js"></script>
</body>

</html>