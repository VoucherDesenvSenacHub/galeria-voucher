<?php
// Valida se o parâmetro "turma_id" existe e é válido
if (!isset($_GET['turma_id']) || !is_numeric($_GET['turma_id'])) {
    header("Location: turma.php");
    exit;
}

require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../../Helpers/ImageHelper.php";
require_once __DIR__ . "/../../../Helpers/HtmlHelper.php";
require_once __DIR__ . "/../../../Helpers/ProjetoHelper.php";
require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/ProjetoModel.php";
require_once __DIR__ . "/../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../Model/DocenteModel.php";

// ------------------- OBTÉM DADOS DA TURMA ------------------- //
$turmaId = (int) $_GET['turma_id'];

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

$imagemTurmaUrl = urlImagem($turma['imagem'], 'turmas/', 'turma-galeria.pg');
$nomeTurma = htmlspecialchars($turma['nome']);
$descricaoTurma = nl2br(htmlspecialchars($turma['descricao']));

$dadosProjetos = formatarProjetos($projetos, $projetoModel);

$tabsProjetos = $dadosProjetos['tabsProjetos'];
$projetosFormatados = $dadosProjetos['projetosFormatados'];

?>

<?php
// Importa configurações globais e o cabeçalho HTML
require_once __DIR__ . "/../../componentes/head.php";

// Define o título da página 
headerComponent('Galeria da Turma');
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
            <img class="galeria-turma-imagem-direita" src="<?= $imagemTurmaUrl ?>" alt="Imagem da Turma">
            <div class="galeria-turma-margin-top-left-projeto1-dia-i">
                <h2><?= $nomeTurma ?></h2>
                <p><?= $descricaoTurma ?></p>
            </div>
        </section>


        <!-- ------------------- SEÇÃO DE PROJETOS ------------------- -->
        <section class="galeria-turma-section galeria-turma-galeria projetos-turma">
            <h1 class="galeria-turma-h1">Galeria de Projetos</h1>

            <!-- Navegação principal dos projetos -->
            <div class="galeria-turma-main-tabs-nav">
                <?php foreach ($tabsProjetos as $tab): ?>
                    <a class="galeria-turma-main-tab-btn <?= $tab['classe_css'] ?>" data-projeto="<?= $tab['projeto_id'] ?>">
                        <?= $tab['nome'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Conteúdo dos projetos -->
            <div class="galeria-turma-main-tabs-content">
                <?php foreach ($projetosFormatados as $projeto): ?>
                    <div class="galeria-turma-main-tab-content <?= $projeto['ativo'] ? 'active' : '' ?>" id="main-tab-<?= $projeto['projeto_id'] ?>">

                        <div class="galeria-turma-projeto-intro">
                            <p><?= $projeto['descricao'] ?></p>
                        </div>

                        <div class="galeria-turma-sub-tabs-nav">
                            <?php
                            foreach ($projeto['dias'] as $i => $dia) {
                                renderSubTabBtn($dia, $i, $projeto['projeto_id'], $dia['linkProjeto']);
                            }
                            renderRepoBtn($projeto, $projeto['dias']);
                            ?>
                        </div>

                        <div class="galeria-turma-sub-tabs-content">
                            <?php foreach ($projeto['dias'] as $dia): ?>
                                <div class="galeria-turma-sub-tab-content <?= $dia['ativo'] ? 'active' : '' ?>" id="sub-tab-<?= $dia['id'] ?>">
                                    <div class="galeria-turma-tab-inner">
                                        <div class="galeria-turma-tab-text">
                                            <h4>DIA <?= $dia['tipo_dia'] ?></h4>
                                            <p><?= $dia['descricao'] ?></p>
                                        </div>
                                        <div class="galeria-turma-tab-image">
                                            <?php foreach ($dia['imagens'] as $imagem): ?>
                                                <img src="<?= $imagem['url'] ?>" alt="<?= $imagem['alt'] ?>">
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="galeria-turma-sub-tab-content <?= empty($projeto['dias']) ? 'active' : '' ?>" id="sub-tab-projeto-<?= $projeto['projeto_id'] ?>">
                                <div class="galeria-turma-tab-inner galeria-repos">
                                    <h1>Acesse o repositório</h1>
                                    <?php if (!empty($projeto['link'])): ?>
                                        <button class="galeria-turma-btn" type="button" onclick="window.open('<?= $projeto['link'] ?>', '_blank')">
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