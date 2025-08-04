<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";

headerComponent('Galeria da Turma');

if (!isset($_GET['turma_id']) || !is_numeric($_GET['turma_id'])) {
    header("Location: galeria-turma.php");
    exit;
}

$turmaId = (int) $_GET['turma_id'];

require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/ProjetoModel.php";
require_once __DIR__ . "/../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../Model/DocenteModel.php";

/**
 * Função genérica para montar URL da imagem com fallback.
 */
function urlImagemGenerica(
    ?string $nomeImagem,
    string $subpastaDefault = 'turmas/',
    string $fallback = 'utilitarios/placeholder-user.png'
): string {
    if (!empty($nomeImagem) && (
        str_starts_with($nomeImagem, 'http://') ||
        str_starts_with($nomeImagem, 'https://')
    )) {
        return $nomeImagem;
    }

    if (empty($nomeImagem)) {
        $nomeImagem = $fallback;
    }

    $subpasta = (str_contains($nomeImagem, '/') && !str_contains($nomeImagem, ' ')) ? '' : $subpastaDefault;

    $base = rtrim(VARIAVEIS['APP_URL'], '/') . '/' . trim(VARIAVEIS['DIR_IMG'], '/') . '/';
    return $base . $subpasta . $nomeImagem;
}

/**
 * URL para imagens padrão, alunos, docentes, projetos.
 */
function urlImagem(?string $nomeImagem): string
{
    return urlImagemGenerica($nomeImagem, 'turmas/', 'utilitarios/placeholder-user.png');
}

/**
 * URL para imagens locais da turma, com fallback diferente.
 */
function urlImagemLocal(?string $nomeImagem): string
{
    return urlImagemGenerica($nomeImagem, 'turmas/', 'turma-galeria.png');
}

// Busca dados no banco
$turmaModel = new TurmaModel();
$turma = $turmaModel->buscarPorId($turmaId);
if (!$turma) {
    header("Location: /turmas");
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
    <header class="galeria-turma-header">
        <?php
        $isAdmin = false;
        require_once __DIR__ . "/../../componentes/nav.php";
        require_once __DIR__ . "/../../componentes/users/mira.php";
        ?>
    </header>

    <section class="galeria-turma-section galeria-turma-projeto">
        <h1 class="galeria-turma-h1 projetos-turma">Projetos da turma</h1>

        <section class="galeria-turma-tab-inner">
            <?php
            $urlImagemTurma = urlImagemLocal($turma['imagem']);
            ?>
            <img class="galeria-turma-imagem-direita" src="<?= $urlImagemTurma ?>" alt="Imagem da Turma">

            <div class="galeria-turma-margin-top-left-projeto1-dia-i">
                <h2><?= htmlspecialchars($turma['nome']) ?></h2>
                <p><?= nl2br(htmlspecialchars($turma['descricao'])) ?></p>
            </div>
        </section>

        <section class="galeria-turma-section galeria-turma-galeria projetos-turma">
            <h1 class="galeria-turma-h1">Galeria de Projetos</h1>

            <div class="galeria-turma-main-tabs-nav">
                <?php foreach ($projetos as $index => $projeto): ?>
                    <a class="galeria-turma-main-tab-btn <?= $index === 0 ? 'active' : '' ?>" data-projeto="<?= $projeto['projeto_id'] ?>">
                        <?= htmlspecialchars($projeto['nome']) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="galeria-turma-main-tabs-content">
                <?php foreach ($projetos as $index => $projeto):
                    $dias = $projetoModel->buscarDiasProjeto($projeto['projeto_id']); ?>
                    <div class="galeria-turma-main-tab-content <?= $index === 0 ? 'active' : '' ?>" id="main-tab-<?= $projeto['projeto_id'] ?>">
                        <div class="galeria-turma-projeto-intro">
                            <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
                        </div>
                        <div class="galeria-turma-sub-tabs-nav">
                            <?php foreach ($dias as $i => $dia): ?>
                                <div class="galeria-turma-sub-tab-wrapper" style="display: inline-flex; align-items: center; gap: 8px; margin-right: 10px;">
                                    <button class="galeria-turma-sub-tab-btn <?= $i === 0 ? 'active' : '' ?>"
                                        data-subtab="<?= $dia['id'] ?>"
                                        data-projeto="<?= $projeto['projeto_id'] ?>">
                                        DIA <?= htmlspecialchars($dia['tipo_dia']) ?>
                                    </button>
                                    <?php if (!empty($dia['linkProjeto'])): ?>
                                        <button class="galeria-turma-btn ver-projeto-btn"
                                            type="button"
                                            onclick="window.open('<?= htmlspecialchars($dia['linkProjeto']) ?>', '_blank')">
                                            Ver Projeto
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="galeria-turma-sub-tabs-content">
                            <?php foreach ($dias as $i => $dia): ?>
                                <div class="galeria-turma-sub-tab-content <?= $i === 0 ? 'active' : '' ?>"
                                    id="sub-tab-<?= $dia['id'] ?>">
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
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </section>

    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Alunos</h1>
        <div class="galeria-turma-container">
            <?php foreach ($alunos as $aluno):
                include __DIR__ . "/../../componentes/users/card_desenvolvedores.php";
            endforeach; ?>
        </div>
    </section>

    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Professores</h1>
        <div class="galeria-turma-container">
            <?php
            if (is_array($docentes) && count($docentes) > 0):
                foreach ($docentes as $docente):
                    $orientador = $docente;
                    include __DIR__ . "/../../componentes/users/card_orientadores.php";
                endforeach;
            else:
                echo "<p>Sem professores cadastrados para esta turma.</p>";
            endif;
            ?>
        </div>
    </section>

    <footer class="galeria-turma-footer">
        <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
    </footer>

    <!-- JS das abas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainTabs = document.querySelectorAll('.galeria-turma-main-tab-btn');
            const mainContents = document.querySelectorAll('.galeria-turma-main-tab-content');
            const subTabState = {};

            mainTabs.forEach(btn => {
                btn.addEventListener('click', function() {
                    const projetoId = this.dataset.projeto;
                    mainTabs.forEach(b => b.classList.remove('active'));
                    mainContents.forEach(c => c.classList.remove('active'));

                    this.classList.add('active');
                    document.getElementById('main-tab-' + projetoId).classList.add('active');
                });
            });

            const allSubTabs = document.querySelectorAll('.galeria-turma-sub-tab-btn');
            allSubTabs.forEach(btn => {
                const subtabId = btn.dataset.subtab;
                const projetoId = btn.dataset.projeto;

                const parent = document.getElementById('main-tab-' + projetoId);
                const subTabBtns = parent.querySelectorAll('.galeria-turma-sub-tab-btn');
                const subContents = parent.querySelectorAll('.galeria-turma-sub-tab-content');

                btn.addEventListener('mouseenter', () => {
                    subTabBtns.forEach(b => b.classList.remove('active'));
                    subContents.forEach(c => c.classList.remove('active'));
                    btn.classList.add('active');
                    document.getElementById('sub-tab-' + subtabId).classList.add('active');
                });

                btn.addEventListener('mouseleave', () => {
                    const activeId = subTabState[projetoId];
                    subTabBtns.forEach(b => {
                        b.classList.toggle('active', b.dataset.subtab === activeId);
                    });
                    subContents.forEach(c => {
                        c.classList.toggle('active', c.id === 'sub-tab-' + activeId);
                    });
                });

                btn.addEventListener('click', () => {
                    subTabState[projetoId] = subtabId;
                });
            });
        });
    </script>
</body>

</html>
