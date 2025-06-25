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
    $alunos = ($_POST['alunos'] !== '') ? (int)$_POST['alunos'] : (int)$_POST['alunos_atual'];
    $projetos = ($_POST['projetos'] !== '') ? (int)$_POST['projetos'] : (int)$_POST['projetos_atual'];
    $polos = ($_POST['polos'] !== '') ? (int)$_POST['polos'] : (int)$_POST['polos_atual'];
    $horas = ($_POST['horas'] !== '') ? (int)$_POST['horas'] : (int)$_POST['horas_atual'];

    //se todos os campos contiverem números válidos
    if ($estatisticasModel->updateEstatisticas($alunos, $projetos, $polos, $horas)) {
        $mensagemDeFeedback = '<div class="alerta-sucesso">Estatísticas atualizadas com sucesso!</div>';
    } else {
        $mensagemDeFeedback = '<div class="alerta-erro">Ocorreu um erro ao salvar no banco de dados.</div>';
    }
}

//busca dados mais recentes para usar nos inputs e no espelho
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
                <form id="formulario-estatistica" action="estatisticas.php" method="post">
                    <!-- inputs de entrada -->
                    <div class="campo_input">
                        <input
                            type="number"
                            id="input-alunos"
                            name="alunos"
                            placeholder="Total de alunos:"
                            data-original-value="<?php echo htmlspecialchars($dadosAtuais['alunos']); ?>"
                        />
                        <input 
                            type="hidden" 
                            name="alunos_atual" 
                            value="<?php echo htmlspecialchars($dadosAtuais['alunos']); ?>"
                        >
                    </div>

                    <div class="campo_input">
                        <input
                            type="number"
                            id="input-projetos"
                            name="projetos"
                            placeholder="Total de projetos:"
                            data-original-value="<?php echo htmlspecialchars($dadosAtuais['projetos']); ?>"
                        />
                        <input 
                            type="hidden" 
                            name="projetos_atual" 
                            value="<?php echo htmlspecialchars($dadosAtuais['projetos']); ?>"
                        >
                    </div>

                    <div class="campo_input">
                        <input
                            type="number"
                            id="input-polos"
                            name="polos"
                            placeholder="Total de polos:"
                            data-original-value="<?php echo htmlspecialchars($dadosAtuais['polos']); ?>"
                        />
                        <input 
                            type="hidden" 
                            name="polos_atual" 
                            value="<?php echo htmlspecialchars($dadosAtuais['polos']); ?>"
                        >
                    </div>

                    <div class="campo_input">
                        <input
                            type="number"
                            id="input-horas"
                            name="horas"
                            placeholder="Horas de curso:"
                            data-original-value="<?php echo htmlspecialchars($dadosAtuais['horas']); ?>"
                        />
                        <input 
                            type="hidden" 
                            name="horas_atual" 
                            value="<?php echo htmlspecialchars($dadosAtuais['horas']); ?>"
                        >
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

    <script src="/galeria-voucher/App/View/assets/js/estatisticas.js"></script>

</body>
</html>