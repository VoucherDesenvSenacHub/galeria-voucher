<?php 
/**
 * Gera um input HTML com estilo e tipo personalizados.
 *
 * @param string $type    Define o tipo do input ('text', 'password'). adicionaremos mais depois.
 * @param string $label  titulo do input (texto) que será exibido em cima do input.
 * @param string $name (texto) Define o name do input.
 * @param string $placeholder (Opcional) define um texto dentro do input.
 *
 * Exemplo de uso:
 * inputComponent('text', 'usuario', 'login_user', 'escreva seu usuario aqui'(opcional));                    
 * inputComponent('password', 'senha', 'login_senha','escreva sua senha aqui'(opcional) );           
 
 */
function inputComponent($type, $label, $name, $placeholder = null) {
    // Define a classe CSS com base no estilo informado
    if ($type === 'text') {
        $class = 'input-text';
    } elseif ($type === 'texteare') {
        $class = 'input-textearea';
    } else {
        // Se o estilo for inválido, usa 'text' como padrão
        $class = 'input-text';
    }
    

    
    // Exibe o input HTML com a classe e o conteúdo definidos
   echo 
    "<div class = 'input-container'>
        <label for='$name'>$label:</label><br>
        <input type='$type' class='$class' name='$name' placeholder = '$placeholder'><br>
    </div>";
    }
?>