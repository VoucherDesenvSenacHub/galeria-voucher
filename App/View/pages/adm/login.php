<?php 
   require_once(__DIR__ . '/../../componentes/head.php');
?>

<body>

    <?php 
        require_once(__DIR__ . '/../../componentes/users/nav.php');
    ?>
    <?php 
        require_once(__DIR__ . '/../../componentes/users/mira.php');
    ?>

    <main class="main-login">
        <form  class="form" action="">

            <div class="form-header" action="">
                <h1>Login</h1>

            </div>
                
            <div class="form-content">

                <div class= "form-input required">

                    <input  type="email"  placeholder="Email" required>
                    <input type="password" placeholder="Senha" required>
        
                </div>

                <div class="form-action">

                    <?php buttonComponent('primary', 'Login'); ?>

                </div>
            </div>
          
        </form>
               
    </main>
    
    <?php 
        require_once(__DIR__ . '/../../componentes/users/footer.php');
    ?>

<body>

</html>