<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>
<html>
<body>

    <?php require_once __DIR__ . "/./../../componentes/users/nav.php" ?>
    <?php require_once __DIR__ . "/./../../componentes/users/mira.php" ?>

   <main>
     

   
    <div class="conteudotodo">

        <div class="turmatitulo">
            <h1 style="margin-bottom:150px; ">TURMAS </h1>
        </div>
       
    
        <!-- Cards das Turmas  obs: aqui no beckend devemos fazer um for vinculado ao banco de dados e configura apenas um card e ao inserir os dados da turma ser auto gerado-->
        <div class="cards">
            <!-- Exemplo de um card de turma -->
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 130</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 131</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 132</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 133</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 134</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 135</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 136</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 137</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 138</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 137</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 139</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 140</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 141</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
           
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 142</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 143</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>

            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 144</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>


             <!-- Cards adicionais, AQUI ESTA ocultos! -->
        <div class="cards ocultos" id="cards-adicionais">
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 145</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 146</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 147</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 148</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 149</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 150</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 151</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 152</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 153</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 154</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 155</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            <a href="emdesenvolvimento.html" class="card">
                <div class="card-content">
                    <h3 class="card-title">TURMA 156</h3>
                    <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma.jpg">
                </div>
            </a>
            
        </div>
    </div>

    <div class="vermais" id="vermais">
        <h3>VER MAIS</h3>
        <span class="material-symbols-outlined" id="arrow-icon">
            arrow_downward
        </span>
    </div>  



    <script src="script.js" defer></script>

    </main>    
    <?php require_once __DIR__ . "/./../../componentes/users/footer.php" ?>
</body>
</html>
