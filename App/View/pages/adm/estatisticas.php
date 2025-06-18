<?php 
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../Config/Database.php";

try {
    $database = new \App\Config\Database();
    $PDO = $database->connect();
} catch (Exception $e) {
    error_log("Erro conexão BD em estatísticas.php: " . $e->getMessage());
    die("Não foi possível conectar ao banco de dados.");
}

// == leitura dos valores atualizados da página ===

$val1 = $val2 = $val3 = $val4 = 0;
try {
    $stmt = $PDO->query("SELECT alunos, projetos, polos, horas FROM estatisticas WHERE id = 1");
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($dados) {
        $val1 = (int) $dados ['alunos'];
        $val2 = (int) $dados ['projetos'];
        $val3 = (int) $dados ['polos'];
        $val4 = (int) $dados ['horas'];
    }
} catch (Exception $e) {
    error_log("Erro ao buscar estatísticas em estatísticas.php: " . $e->getMessage());
}

$fmt1 = number_format($val1, 0, ',', '.');
$fmt2 = number_format($val2, 0, ',', '.');
$fmt3 = number_format($val3, 0, ',', '.');
$fmt4 = number_format($val4, 0, ',', '.');
?>

<body class="body-estatisticas">
    <?php require_once __DIR__ . "/./../../componentes/adm/sidebar.php"; ?>
    <?php require_once __DIR__ . "/./../../componentes/adm/nav.php"; ?>

    <main class="conteudo-estatisticas">
        <div>
            <!-- profile (titulo da página) na parte de cima -->
            <div class="estatistica-profile">
                <div class="user-icon">
                    <div>
                        <button id="profile-titulo">ESTATÍSTICA</button>
                    </div>
                </div>
            </div>

            <div class="container">
                <h1 class="titulo-estatistica">ATUALIZAR ESTATÍSTICAS</h1>
            </div>

            <div class="div-formulario">
                <form id="formulario-estatistica" action="pagina-processamento-estatistica.php" method="post">
                    <!-- inputs de entrada -->
                    <div class="campo_input">
                        <label for="input1" class="sr-only">Total de Alunos</label>
                        <Input
                            type="text"
                            id="input1"
                            name="input1"
                            placeholder="Total de alunos:"
                            inputmode="numeric"
                            autocomplete="off"
                            value="<?= htmlspecialchars($val1) ?>"
                        />
                    </div>

                    <div class="campo_input">
                        <label for="input2" class="sr-only">Total de Projetos</label>
                        <Input
                            type="text"
                            id="input2"
                            name="input2"
                            placeholder="Total de projetos:"
                            inputmode="numeric"
                            autocomplete="off"
                            value="<?= htmlspecialchars($val2) ?>"
                        />
                    </div>

                    <div class="campo_input">
                        <label for="input3" class="sr-only">Total de Polos</label>
                        <Input
                            type="text"
                            id="input3"
                            name="input3"
                            placeholder="Total de polos:"
                            inputmode="numeric"
                            autocomplete="off"
                            value="<?= htmlspecialchars($val3) ?>"
                        />
                    </div>

                    <div class="campo_input">
                        <label for="input4" class="sr-only">Horas de curso</label>
                        <Input
                            type="text"
                            id="input4"
                            name="input4"
                            placeholder="Horas de curso:"
                            inputmode="numeric"
                            autocomplete="off"
                            value="<?= htmlspecialchars($val4) ?>"
                        />
                    </div>

                    <!-- espelho para visualização dos inputs -->
                    <div id="painel-estatisticas" class="painel-estatisticas">
                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho1"><?= '+ ' . $fmt1 ?></span></div>
                           <div class="legenda">DE ALUNOS</div>
                       </div>

                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho2"><?= '+ ' . $fmt2 ?></span></div>
                           <div class="legenda">PROJETOS</div>
                       </div>

                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho3"><?= '+ ' . $fmt3 ?></span></div>
                           <div class="legenda">POLOS</div>
                       </div>

                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho4"><?= '+ ' . $fmt4 ?></span></div>
                           <div class="legenda">CURSO COM HORAS</div>
                       </div>
                    </div>

                    <!-- botão atualizar -->
                     <div class="botao-atualizar">
                        <button type="submit" id="btn-atualizar">ATUALIZAR</button>
                     </div> 

                </form>
            </div>
        </div>
    </main>

<!-- import do javascript -->
 <script src="/js/estatisticas.js"></script>

</body>
</html>