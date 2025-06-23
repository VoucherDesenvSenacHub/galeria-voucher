<?php 
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Config/Database.php";
require_once __DIR__ . "/../../../Model/EstatisticasModel.php";

use App\Model\EstatisticasModel;

//cria intância do model que contém os métodos para falar com o banco
$estatisticasModel = new EstatisticasModel();
$mensagemDeFeedback = ''; // variável para guardar mensagens de sucesso ou erro para o admin

//verifica se o formlário foi enviado (se o método da requisição for POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //valida e limpa os dados recebidos pra garantir que sejam números inteiros
    $alunos = filter_input(INPUT_POST, 'alunos', FILTER_VALIDATE_INT);
    $projetos = filter_input(INPUT_POST, 'projetos', FILTER_VALIDATE_INT);
    $polos = filter_input(INPUT_POST, 'polos', FILTER_VALIDATE_INT);
    $horas = filter_input(INPUT_POST, 'horas', FILTER_VALIDATE_INT);

    //se todos os campos contiverem números válidos
    if ($alunos !== false && $projetos !== false && $polos !== false && $horas !== false) {
        //chama o método do model para atualizar os dados no banco
        if ($estatisticasModel->updateEstatisticas($alunos, $projetos, $polos, $horas)) {
            $mensagemDeFeedback = '<div class="alerta-sucesso">Estatísticas atualizadas com sucesso!</div>';
        } else {
            $mensagemDeFeedback = '<div class="alerta-erro">Ocorreu um erro ao salvar no banco de dados.</div>';
        }
    } else {
        $mensagemDeFeedback = '<div class="alerta-erro">Todos os campos são obrigatórios e devem conter apenas números.</div>';
    }
}

//busca dados mais recentes para exibir na página
$dadosAtuais = $estatisticasModel->getEstatisticas();
if (!$dadosAtuais) {
    //caso a tabela esteja vazia, define valores padrão pra evitar erros
    $dadosAtuais = ['alunos' => 0, 'projetos' => 0, 'polos' => 0, 'horas' => 0];
}

//formata os os números para o padrão br
$fmt_alunos = number_format($dadosAtuais['alunos']);
$fmt_projetos = number_format($dadosAtuais['projetos']);
$fmt_polos = number_format($dadosAtuais['polos']);
$fmt_horas = number_format($dadosAtuais['horas']);
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

            <?php echo $mensagemDeFeedback; //exibe a mensagem de sucesso ou erro ?>

            <div class="div-formulario">
                <form id="formulario-estatistica" action="estatistica.php" method="post">
                    <!-- inputs de entrada -->
                    <div class="campo_input">
                        <Input
                            type="number"
                            id="input-alunos"
                            name="alunos"
                            placeholder="Total de alunos:"
                            value="<?php echo htmlspecialchars($dadosAtuais['alunos']); ?>" required
                        />
                    </div>

                    <div class="campo_input">
                        <Input
                            type="number"
                            id="input-projetos"
                            name="projetos"
                            placeholder="Total de projetos:"
                            value="<?php echo htmlspecialchars($dadosAtuais['projetos']); ?>" required
                        />
                    </div>

                    <div class="campo_input">
                        <Input
                            type="number"
                            id="input-polos"
                            name="polos"
                            placeholder="Total de polos:"
                            value="<?php echo htmlspecialchars($dadosAtuais['polos']); ?>" required
                        />
                    </div>

                    <div class="campo_input">
                        <Input
                            type="number"
                            id="input-horas"
                            name="horas"
                            placeholder="Horas de curso:"
                            value="<?php echo htmlspecialchars($dadosAtuais['horas']); ?>" required
                        />
                    </div>

                    <!-- espelho para visualização dos inputs -->
                    <div id="painel-estatisticas" class="painel-estatisticas">
                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho-alunos"><?= '+ ' . $fmt_alunos ?></span></div>
                           <div class="legenda">DE ALUNOS</div>
                       </div>

                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho-projetos"><?= '+ ' . $fmt_projetos ?></span></div>
                           <div class="legenda">PROJETOS</div>
                       </div>

                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho-polos"><?= '+ ' . $fmt_polos ?></span></div>
                           <div class="legenda">POLOS</div>
                       </div>

                       <div class="estatistica-item">
                           <div class="valor"><span id="espelho-horas"><?= '+ ' . $fmt_horas ?></span></div>
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

    <script src="galeria-voucher/App/View/assets/js/estatisticas.js"></script>

</body>
</html>