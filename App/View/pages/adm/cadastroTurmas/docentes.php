<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";

$currentTab = 'docentes';
?>

<body class="body-adm">
    <div class="container-adm">
        <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>

        <?php
        $isAdmin = true; // Para páginas de admin
        require_once __DIR__ . "/../../../componentes/nav.php";
        ?>

        <main class="main-turmas-turmas">
            <div class="tabs-adm-turmas">
                <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>"href="docentes.php">DOCENTES</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php">ALUNOS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>"href="sobre.php">PROJETOS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : '' ?>"href="cadastroTurmas.php">DADOS GERAIS</a>
            </div>

            <div class="topo-lista-alunos">
                <?php buttonComponent('primary', 'PESQUISAR', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php'); ?>

                <div class="input-pesquisa-container">
                    <input type="text" id="pesquisa" placeholder="Pesquisar">
                    <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
                </div>
            </div>

            <div class="tabela-principal-lista-alunos">
                <div class="tabela-container-lista-alunos">
                    <table id="tabela-alunos">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>POLO</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $usuarios = [
                                ['nome' => 'João Silva', 'polo' => 'Campo Grande'],
                                ['nome' => 'Maria Santos', 'polo' => 'Campo Grande'],
                                ['nome' => 'Pedro Oliveira', 'polo' => 'Campo Grande'],
                                ['nome' => 'Ana Costa', 'polo' => 'Campo Grande'],
                            ];
                            usort($usuarios, function ($a, $b) {
                                return strcasecmp($a['nome'], $b['nome']);
                            });
                            foreach ($usuarios as $usuario) {
                                echo '<tr>';
                                echo '<td>' . $usuario['nome'] . '</td>';
                                echo '<td>' . $usuario['polo'] . '</td>';
                                echo '<td class="acoes">';
                                echo '<span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.querySelector('.form-group-buton button').addEventListener('click', () => {
            const termo = document.getElementById('pesquisa').value.toLowerCase();
            const linhas = document.querySelectorAll('#tabela-alunos tbody tr');

            linhas.forEach(linha => {
                const nome = linha.children[0].textContent.toLowerCase();
                const polo = linha.children[1].textContent.toLowerCase();

                if (nome.includes(termo) || polo.includes(termo)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>