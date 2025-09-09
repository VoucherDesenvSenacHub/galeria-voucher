<?php
require_once __DIR__ . "/../../componentes/head.php";
require __DIR__ . "/../../../Model/AlunoTurmaModel.php";

$back = $_SESSION['last_page'] ?? './home.php';

$alunoTurma = new AlunoTurmaModel();
$alunos = $alunoTurma->Turma146();

headerComponent('Desenvolvedores');
?>

<body class="body_dev">
    <header class="header_dev">
        <?php
        buttonComponent('primary', 'VOLTAR', false, $back); ?>
        <div class="titulo-pagina">
            <h1 class="titulodev">DESENVOLVEDORES</h1>
        </div>
    </header>
    <main class="main_dev">
        <?php require_once __DIR__ . "/../../componentes/users/mira.php"; ?>

        <section class="galeria-turma-cardss">
            <h1 class="galeria-turma-h1">Alunos</h1>
            <div class="galeria-turma-container">
                <?php
                foreach ($alunos as $aluno) {
                    require __DIR__ . "/../../componentes/users/card_desenvolvedores.php";
                }
                ?>
            </div>
        </section>

        <?php require_once __DIR__ . "/./../../componentes/users/footer.php" ?>
    </main>
</body>

</html>