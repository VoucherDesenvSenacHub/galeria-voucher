<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";

headerComponent('Galeria da Turma');

// Este arquivo deve receber o ID da turma pela URL: ?turma_id=123
if (!isset($_GET['turma_id']) || !is_numeric($_GET['turma_id'])) {
    header("Location: galeria-turma.php");
    exit;
}

$turmaId = (int) $_GET['turma_id'];

require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/ProjetoModel.php";
require_once __DIR__ . "/../../../Model/ProjetoDiaModel.php";
require_once __DIR__ . "/../../../Model/ImagemProjetoDiaModel.php";
require_once __DIR__ . "/../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../Model/DocenteModel.php";

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

        <section class="galeria-turma-tab-inner ">
            <img class="galeria-turma-imagem-direita" src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . $turma['imagem'] ?>">
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
                            <h3><?= htmlspecialchars($projeto['nome']) ?></h3>
                            <p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>
                        </div>
                        <div class="galeria-turma-sub-tabs-nav">
                            <?php foreach ($dias as $i => $dia): ?>
                                <button class="galeria-turma-sub-tab-btn <?= $i === 0 ? 'active' : '' ?>" data-subtab="<?= $dia['id'] ?>" data-projeto="<?= $projeto['projeto_id'] ?>">
                                    DIA <?= $dia['tipo_dia'] ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <div class="galeria-turma-sub-tabs-content">
                            <?php foreach ($dias as $i => $dia): ?>
                                <div class="galeria-turma-sub-tab-content <?= $i === 0 ? 'active' : '' ?>" id="sub-tab-<?= $dia['id'] ?>">
                                    <div class="galeria-turma-tab-inner">
                                        <div class="galeria-turma-tab-text">
                                            <h4>DIA <?= $dia['tipo_dia'] ?></h4>
                                            <p><?= nl2br(htmlspecialchars($dia['descricao'])) ?></p>
                                        </div>
                                        <div class="galeria-turma-tab-image">
                                            <?php foreach ($dia['imagens'] as $imagem): ?>
                                                <img src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . $imagem['url'] ?>" alt="Imagem do Dia <?= $dia['tipo_dia'] ?>">
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
            <?php foreach ($docentes as $docente):
                include __DIR__ . "/../../componentes/users/card_orientadores.php";
            endforeach; ?>
        </div>
    </section>

    <footer class="galeria-turma-footer">
        <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
    </footer>
</body>
</html>