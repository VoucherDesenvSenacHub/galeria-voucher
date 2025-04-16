<!DOCTYPE html>
<html lang="pt-br">

<?php 
   require_once(__DIR__ . '/../../assets/componentes/users/head.php');
?>

<body>

    <?php 
        require_once(__DIR__ . '/../../componentes/users/nav.php');
    ?>

    <div class="content">
    
        <div class="square"></div>

            
            
        <div class="square1"></div>

            
        
        <div class="square2"></div>

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

                    <button type="submit"> Login </button>

                </div>

                <div class="form-footer">

                    <p>Esqueceu sua senha ? <a href="">Clique Aqui</a> </p>

                </div>

            </div>
          
        </form>
               
    </main>
    
    <?php 
        require_once(__DIR__ . '/../../componentes/users/footer.php');
    ?>

<body>

</html>