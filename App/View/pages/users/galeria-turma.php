<?php

// Importa configurações globais e o cabeçalho HTML
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";

// Importa helpers personalizados para manipulação de imagens e componentes HTML
require_once __DIR__ . "/../../../Helpers/ImageHelper.php";
require_once __DIR__ . "/../../../Helpers/HtmlHelper.php";

use function App\Helpers\urlImagem;
use function App\Helpers\renderSubTabBtn;
use function App\Helpers\renderRepoBtn;

// Define o título da página
headerComponent('Galeria da Turma');

// Valida se o parâmetro "turma_id" existe e é válido
if (!isset($_GET['turma_id']) || !is_numeric($_GET['turma_id'])) {
    header("Location: galeria-turma.php");
    exit;
}

$turmaId = (int) $_GET['turma_id'];

// ------------------- IMPORTAÇÃO DOS MODELS ------------------- //

// Importa os models responsáveis por acessar dados da turma, projeto, aluno e docente
foreach (["TurmaModel", "ProjetoModel", "AlunoModel", "DocenteModel"] as $model) {
    require_once __DIR__ . "/../../../Model/{$model}.php";
}

// ------------------- OBTÉM DADOS DA TURMA ------------------- //

$turmaModel = new TurmaModel();
$turma = $turmaModel->buscarPorId($turmaId);

if (!$turma) {
    header("Location: turma.php");
    exit;
}

$projetoModel = new ProjetoModel();
$projetos = $projetoModel->buscarProjetosPorTurma($turmaId);

$alunoModel = new AlunoModel();
$alunos = $alunoModel->buscarPorTurma($turmaId);

$docenteModel = new DocenteModel();
$docentes = $docenteModel->buscarPorTurma($turmaId);
?>

<body class="galeria-turma-body">

<!-- ------------------- CABEÇALHO COM MENU ------------------- -->
<header class="galeria-turma-header">
    <?php
    $isAdmin = false;
    require_once __DIR__ . "/../../componentes/nav.php";
    require_once __DIR__ . "/../../componentes/users/mira.php";
    ?>
</header>

<!-- ------------------- DETALHES DA TURMA ------------------- -->
<section class="galeria-turma-section galeria-turma-projeto">
    <h1 class="galeria-turma-h1 projetos-turma">Projetos da turma</h1>

    <section class="galeria-turma-tab-inner">
        <img class="galeria-turma-imagem-direita" src="<?= urlImagem($turma['imagem'], 'turmas/', 'turma-galeria.png') ?>" alt="Imagem da Turma">
        <div class="galeria-turma-margin-top-left-projeto1-dia-i">
            <h2><?= htmlspecialchars($turma['nome']) ?></h2>
            <p><?= nl2br(htmlspecialchars($turma['descricao'])) ?></p>
        </div>
    </section>

    <!-- ------------------- SEÇÃO DE PROJETOS ------------------- -->
    <section class="galeria-turma-section galeria-turma-galeria projetos-turma">
        <h1 class="galeria-turma-h1">Galeria de Projetos</h1>

        <!-- Navegação principal dos projetos -->
        <div class="galeria-turma-main-tabs-nav">
            <?php foreach ($projetos as $index => $projeto): ?>
                <a class="galeria-turma-main-tab-btn <?= $index === 0 ? 'active' : '' ?>" data-projeto="<?= $projeto['projeto_id'] ?>">
                    <?= htmlspecialchars($projeto['nome']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Conteúdo dos projetos -->
        <div class="galeria-turma-main-tabs-content">
            <?php foreach ($projetos as $index => $projeto):
                $dias = $projetoModel->buscarDiasProjeto($projeto['projeto_id']); ?>
                <div class="galeria-turma-main-tab-content <?= $index === 0 ? 'active' : '' ?>" id="main-tab-<?= $projeto['projeto_id'] ?>">

                    <!-- Introdução do projeto -->
                    <div class="galeria-turma-projeto-intro">
                        <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
                    </div>

                    <!-- Abas secundárias (dias + repositório) -->
                    <div class="galeria-turma-sub-tabs-nav">
                        <?php
                        foreach ($dias as $i => $dia) {
                            renderSubTabBtn($dia, $i, $projeto['projeto_id'], $dia['linkProjeto'] ?? null);
                        }
                        renderRepoBtn($projeto, $dias);
                        ?>
                    </div>

                    <!-- Conteúdo das abas secundárias -->
                    <div class="galeria-turma-sub-tabs-content">
                        <?php foreach ($dias as $i => $dia): ?>
                            <div class="galeria-turma-sub-tab-content <?= $i === 0 ? 'active' : '' ?>" id="sub-tab-<?= $dia['id'] ?>">
                                <div class="galeria-turma-tab-inner">
                                    <div class="galeria-turma-tab-text">
                                        <h4>DIA <?= htmlspecialchars($dia['tipo_dia']) ?></h4>
                                        <p><?= nl2br(htmlspecialchars($dia['descricao'])) ?></p>
                                    </div>
                                    <div class="galeria-turma-tab-image">
                                        <?php foreach ($dia['imagens'] as $imagem): ?>
                                            <img src="<?= urlImagem($imagem['url']) ?>" alt="Imagem do Dia <?= htmlspecialchars($dia['tipo_dia']) ?>">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Aba final com botão para repositório -->
                        <div class="galeria-turma-sub-tab-content <?= empty($dias) ? 'active' : '' ?>" id="sub-tab-projeto-<?= $projeto['projeto_id'] ?>">
                            <div class="galeria-turma-tab-inner" style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px; min-height: 200px; font-size: 1.5rem;">
                                <h1>Acesse o repositório</h1>
                                <?php if (!empty($projeto['link'])): ?>
                                    <button class="galeria-turma-btn" type="button" onclick="window.open('<?= htmlspecialchars($projeto['link']) ?>', '_blank')">
                                        REPOSITÓRIO
                                    </button>
                                <?php else: ?>
                                    <p>Link do repositório não disponível.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>
</section>

<!-- ------------------- LISTAGEM DE ALUNOS ------------------- -->
<section class="galeria-turma-cardss">
    <h1 class="galeria-turma-h1">Alunos</h1>
    <div class="galeria-turma-container">
        <?php foreach ($alunos as $aluno): ?>
            <?php
                // Prepara a variável $pessoa com os dados do aluno
                $pessoa = [
                    'nome' => $aluno['nome'],
                    'imagem' => $aluno['imagem'], // Certifique-se que o nome da chave está correto
                    'funcao' => 'Aluno', // Define a função explicitamente
                    'linkedin' => $aluno['linkedin'],
                    'github' => $aluno['github']
                ];
                // Inclui o componente, que agora encontrará a variável $pessoa pronta
                include __DIR__ . "/../../componentes/users/cards_pessoas.php";
            ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- ------------------- LISTAGEM DE PROFESSORES ------------------- -->
<section class="galeria-turma-cardss">
    <h1 class="galeria-turma-h1">Professores</h1>
    <div class="galeria-turma-container">
        <?php if (!empty($docentes)): ?>
            <?php foreach ($docentes as $docente): ?>
                <?php
                    // Prepara a variável $pessoa com os dados do docente
                    $pessoa = [
                        'nome' => $docente['nome'],
                        'imagem' => $docente['imagem'], // Certifique-se que o nome da chave está correto
                        'funcao' => 'Professor', // Define a função explicitamente
                        'linkedin' => $docente['linkedin'],
                        'github' => $docente['github']
                    ];
                    // Reutiliza o mesmo componente, que também usará a variável $pessoa
                    include __DIR__ . "/../../componentes/users/cards_pessoas.php";
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Sem professores cadastrados para esta turma.</p>
        <?php endif; ?>
    </div>
</section>


<footer class="galeria-turma-footer">
    <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
</footer>

<!-- ------------------- SCRIPTS DE ABA / INTERAÇÃO ------------------- -->
<script src="<?= '/../../../' . VARIAVEIS['DIR_JS'] ?>galeria-turma.js"></script>

</body>
</html>

