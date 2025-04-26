<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

<body>
    <header>
        <?php require_once __DIR__ . "/./../../componentes/users/nav.php" ?>
        <?php require_once __DIR__ . "/./../../componentes/users/mira.php" ?>
    </header>
    <!-- parte das linhas -->
    <section class="projeto">
        <h1>Projetos da turma</h1>
    </section>
    <section class="galeria">
        <h2>Galeria E-Commerce</h2>

    </section>
    <section class="senac">
        <h1>Senac Hub Academy</h1>
        <h1>Campo Grande - MS</h1>
    </section>

    <section class="dia">
        <img class="imagem-direita"
            src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
        <div class="margin-top-left-turma-xx">
            <h2>TURMA XX</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, quod amet sint ut debitis optio
                quaerat rerum qui soluta quibusdam suscipit temporibus, aliquam ducimus distinctio hic dolorem, corporis
                itaque odio?</p>
        </div>
    </section>

    <section class="dia">
        <div>
            <h2>DIA I</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, blanditiis sequi, voluptas nam ut dicta
                maxime dignissimos, est cupiditate esse iste aliquam tempora quos vero recusandae. Facilis, iste illo!
                Unde.</p>
        </div>
        <img class="imagem-diaI"
            src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
    </section>

    <div class="binarynumber"></div>

    <section class="dia">
        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
        <div class="margin-top-left-dia-p">
            <h2>DIA P</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, esse. Cupiditate officia ut cum illo
                doloremque quibusdam fuga natus necessitatibus veritatis eligendi facere, repellat aliquam eveniet aut
                ex blanditiis perspiciatis!</p>
        </div>
    </section>

    <section class="dia">
        <div class="margin-top-right-dia-e">
            <h2>DIA E</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nobis a laboriosam error nihil
                placeat cum libero sapiente magni, voluptatum commodi accusamus repudiandae repellendus suscipit! Aut
                quo qui inventore debitis.</p>
        </div>
        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
    </section>

    <section class="dia">
        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
        <div class="margin-top-left-projeto-xx">
            <h2>PROJETO XX</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In ad iusto omnis reiciendis dolor eos illo
                quas. Ipsa modi amet officiis nulla veniam dolorem consequuntur pariatur minima. Neque, impedit
                voluptatum!</p>
            <div class="botaoprojeto"> <!-- <- classe que deixa o botao no lugar correto -->
                <button class="primary-button" type="button">Ver Projeto</button>
            </div>
        </div>
    </section>


    <section class="cardss">
        <h1>Alunos</h1>
        <li>
            <div class="container">
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                                </svg>
                            </a>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-github" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                                </svg>
                            </a>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-github" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card-turmagaleria">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="image-container">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/img-user-galeria.jpg">
                    </div>
                    <div class="text-card">
                        <h2>EDNALDO PEREIRA</h2>
                        <p>ORIENTADOR</p>
                        <div class="social-icons">
                            <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="cardss">
        <h1>Professores</h1>
        <div class="container">
            <div class="card-container">
                <div>
                    <?php for ($i = 0; $i <= 2; $i++) { ?>
                        <?php require_once __DIR__ . "/./../../componentes/users/card_desenvolvedores.php" ?>
                    <?php } ?>
                </div>
            </div>

    </section>
    <?php require_once __DIR__ . "/./../../componentes/users/footer.php" //componente do rodapé ?>

</body>

</html>