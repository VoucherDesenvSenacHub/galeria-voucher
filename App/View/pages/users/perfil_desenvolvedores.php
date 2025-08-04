<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/button.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../Model/DocenteModel.php";

headerComponent('Desenvolvedores');

$turmaId = 1;

$alunoModel = new AlunoModel();
$alunos = $alunoModel->buscarPorTurma($turmaId);

$docenteModel = new DocenteModel();
$docentes = $docenteModel->buscarPorTurma($turmaId);
?>

<body class="body_dev">
    <header class="header_dev">
        <?php buttonComponent('primary', 'VOLTAR', false, './home.php'); ?>
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
                foreach ($alunos as $aluno):
                    include __DIR__ . "/../../componentes/users/card_desenvolvedores.php";
                endforeach; 
                ?>
            </div>
        </section>

        <section class="galeria-turma-cardss">
            <h1 class="galeria-turma-h1">Professores</h1>
            <div class="galeria-turma-container">
                <?php
                if (is_array($docentes) && count($docentes) > 0):
                    foreach ($docentes as $docente):
                        // No card_orientadores.php, a variável usada é $orientador
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
    </main>
</body>
</html>
