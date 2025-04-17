<?php 
require_once __DIR__ . "/../../componentes/head.php";
?>

    <body class="body-user">
        <?php require_once __DIR__ . "/./../../componentes/users/nav.php" ?>
        <?php require_once __DIR__ . "/./../../componentes/users/mira.php" ?>
        
        <main class="main-user">
        <!-- Seção 1 -->
            <section id="secao1">
                <?php require_once __DIR__ . "/./../../componentes/users/mira.php"; //componente da mira ?>

                <div class="content">
                    <div class="numero">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>numeros.png" alt="Números">
                    </div>

                    <div class="nome">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>nome.png" alt="Voucher Desenvolvedor">
                    </div>

                    <div class="mapa">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>mapa.png" alt="Mapa do Brasil">
                    </div>
                </div>
            </section>

        <!-- Seção 2 (cards Oque é?, Para quem é? e Porque fazer?) -->
            <section id="secao2">
                <div class="container">
                        <div class="card">
                            <h2>O QUE É ?</h2>
                                <p>
                                    Qualifique-se para uma das áreas mais promissoras da atualidade com o Programa Voucher
                                    Desenvolvedor. Oferecemos vagas gratuitas para o curso Técnico em Desenvolvimento de Sistemas,
                                    com carga horária de 1.200 horas. Beneficie-se de uma experiência prática com interação direta
                                    com empresas de tecnologia e, a partir do sexto mês, tenha a chance de conseguir um estágio
                                    remunerado e se destacar no curso. Invista no seu futuro e abra portas para uma carreira de
                                    sucesso em TI.
                                </p>
                        </div>

                        <div class="card">
                            <h2>PARA QUEM É ?</h2>
                                <p>
                                    Podem participar do processo seletivo pessoas com renda per capita familiar de até 2 salários
                                    mínimos. São elegíveis estudantes do ensino médio (1º, 2º ou 3º ano) matriculados em
                                    instituições públicas de ensino em Mato Grosso do Sul, desde que estejam, no mínimo, no 2º ano.
                                    Também podem participar aqueles que estão concluindo ou já concluíram o ensino médio, em
                                    instituições públicas ou privadas.
                                </p>
                        </div>

                        <div class="card">
                            <h2>POR QUE FAZER ?</h2>
                                <p>
                                    A área de Tecnologia da Informação está em expansão, com uma alta demanda por profissionais de
                                    Desenvolvimento de Sistemas. Especializar-se nessa área oferece maior empregabilidade, inclusive
                                    internacional, uma boa remuneração (a média é de R$ 2.221,00), e a possibilidade de novas
                                    carreiras e desenvolvimento. É um setor em constante crescimento, apresentando excelentes
                                    perspectivas para quem busca se destacar.
                                </p>
                        </div>
                </div>
            </section>

            <!-- Seção 3 (estatísticas) -->
            <section id="secao3">
                <div class="container2">
                    <h1>SUA EVOLUÇÃO COMEÇA AQUI</h1>
                    <div class="stats">
                        <?php 
                            //dados dinâmicos de exemplo apenas
                            $estatisticas = [
                                ['valor' => '+500', 'label' => 'DE ALUNOS'],
                                ['valor' => '+50', 'label' => 'PROJETOS'],
                                ['valor' => '+5', 'label' => 'POLOS'],
                                ['valor' => '1200', 'label' => 'CURSO COM HORAS']
                            ];
                                //foreach percorre aray ($estatisticas) e cria os elementos html (div, span, p)
                                // evitando repetição manual de código e facilitando na manutenção sem precisar
                                //alterar a estrutura do html, apenas conectando ao banco de dados
                            foreach ($estatisticas as $estatistica) {
                                echo "<div>
                                        <span>{$estatistica['valor']}</span>
                                        <p>{$estatistica['label']}</p>
                                    </div>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Seção 4 (transição da página inicial para a página de "turmas" e animação dos losângos) -->
            <section>
                
                <div class="call-to-action">
                    VEJA VÁRIOS PROJETOS E <span>INSPIRE-SE</span>
                </div>

                        <?php for($i=0; $i<=4; $i++){ ?>
                            <div class='image-container'>
                                <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/foto.png" >
                            </div>
                        <?php } ?>

                    </div>

                    <div class="image-row">
                        <?php for($i=0; $i<=5; $i++){ ?>
                            <div class='image-container'>
                                <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/foto.png" >
                            </div>
                        <?php } ?>
                    </div>

                </div>

            </div>
         </section>
    </main>
<?php require_once __DIR__ . "/./../../componentes/users/footer.php" //componente do rodapé ?>
</body>
