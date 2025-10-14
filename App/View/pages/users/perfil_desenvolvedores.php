<?php
require_once __DIR__ . "/../../componentes/head.php";
require __DIR__ . "/../../../Model/AlunoModel.php";

$alunoModel = new AlunoModel();
$alunos = $alunoModel->buscarPorTurma(25);

$pessoasTurma = [];
$pessoasTurma = array_merge($pessoasTurma, $alunos);

headerComponent('Desenvolvedores');
?>

<body class="layout body_dev">
    <section class="main-section layout-main">
        <header class="nav-head header_dev">
            <?php
            // Aqui você passa a função JS no parâmetro do botão
            buttonComponent('primary', 'VOLTAR', false, "javascript:window.history.back()", null, null, "dev-no-button");
            ?>
            <div class="titulo-pagina">
                <h1 class="titulodev">DESENVOLVEDORES</h1>
            </div>
        </header>
        <main class="main_dev">
            <?php require_once __DIR__ . "/../../componentes/users/mira.php"; ?>
    
            <section class="galeria-turma-cardss">
                <h1 class="galeria-turma-h1">Alunos</h1>
                <div class="galeria-turma-container">
                    <?php foreach ($pessoasTurma as $pessoa): ?>
                        <?php include __DIR__ . "/../../componentes/users/card_pessoa.php"; ?>
                    <?php endforeach; ?>
                </div>
            </section>
    
        </main>
        <?php require_once __DIR__ . "/./../../componentes/users/footer.php" ?>

    </section>
</body>
</html>
