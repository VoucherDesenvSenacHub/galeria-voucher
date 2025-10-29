<?php 
/**
 * Gera um input HTML com estilo e tipo personalizados.
 *
 * @param string $type    Define o tipo do input ('text', 'password'). adicionaremos mais depois.
 * @param string $name (texto) Define o name do input.
 * @param string $placeholder (Opcional) define um texto dentro do input.
 * @param string $required (Opcional) define se o campo é obrigatório.
 * 
 * 
 * Exemplo de uso:
 * inputComponent('text', 'usuario', 'login_user', 'escreva seu usuario aqui'(opcional));                    
 * inputComponent('password', 'senha', 'login_senha','escreva sua senha aqui'(opcional) );           

 */
function inputComponent($type, $name, $placeholder = null, $value = null, $label = null, $required = false) {
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
    $valueAttr = $value !== null ? "value='$value'" : "";
    $valueRequired = $required  ? "required=" : "";
    $html = '<div class ="input-container">';

    if($label !== null){
        $html .= "<label for='input_$name' id='text_input' class='form-label'>$label</label>";
    }

    $html .= "<input id='input_$name' type='$type' class='$class' name='$name' placeholder='$placeholder' $valueAttr $valueRequired>";
    $html .= "</div>";
    echo $html;
    }
?>